<?php
	error_reporting(0);
	session_start();
	if(!isset($_SESSION['role'])) die ("<h1>Not Found</h1>
<p>The requested URL $_SERVER[PHP_SELF] was not found on this server.</p>");
	if($_SESSION['role']!="administrator") {
		header('location:login.php');
		exit();
	}
?>
<div class="title-dash">
	<i class="fa fa-group fa-3x left margin10right"></i>
	<div class="title">Users Management | <button name="#confirmation-box" class="btn btn-primary confirmation" style="background: #34495e">Add User</button></div>
</div>
<div style="clear:both"></div>
<script type="text/javascript">
 $(document).ready(function() {
 
  $('.alert').fadeOut(5000);
   });
</script>
<?php
	$msg=addslashes($_GET['msg']);
	$id_msg=addslashes($_GET['id_msg']);

	if($msg=="error") {
		if($id_msg==1) {
			echo '<div class="alert alert-block alert-danger fade in">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
					<p align="center">Username or Email exits!</p>
				</div>';
		} else if ($id_msg==2) {
			echo '<div class="alert alert-block alert-danger fade in">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
					<p align="center">Field (*) is Required!</p>
				</div>';
		} else if ($id_msg==3) {
			echo '<div class="alert alert-block alert-danger fade in">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
					<p align="center">Cannot delete logged in user!</p>
				</div>';
		}
	} else if($msg=="success") {
		if($id_msg==1) {
			echo '<div class="alert alert-block alert-success fade in">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
					<p align="center">Success Add User!</p>
				</div>';
		} else if($id_msg==2) {
			echo '<div class="alert alert-block alert-success fade in">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
					<p align="center">Success Delete User!</p>
				</div>';
		} else if($id_msg==3) {
			echo '<div class="alert alert-block alert-success fade in">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
					<p align="center">Success Edit User!</p>
				</div>';
		} else if($id_msg==4) {
			echo '<div class="alert alert-block alert-success fade in">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
					<p align="center">Success Change Password!</p>
				</div>';
		}
	}
?>
<div class="content-dash">
	<?php
		$keyword=addslashes(strip_tags(htmlentities($_POST[keyword])));
		$field=addslashes(strip_tags(htmlentities($_POST[field])));
		$sort_of=addslashes(strip_tags(htmlentities($_POST[sort_of])));
		$role=addslashes(strip_tags(htmlentities($_POST[role])));

		if($role!="") $clause="where role = $role AND (fullname LIKE '%$keyword%' OR username LIKE '%$keyword%' OR email LIKE '%$keyword%')";
		elseif($keyword!="") $clause="where fullname LIKE '%$keyword%' OR username LIKE '%$keyword%' OR email LIKE '%$keyword%'";				
		$q=$db->prepare("SELECT * FROM users $clause order by id $sort_of");

		$q->execute();
		$check=$q->rowCount();
	?>
	<div class="box">
		<script type="text/javascript">
		var validusn=true;
		var validpass=true;
		var validphoto=true;
		var validemail=true;

		function validateusn() {
			$("#username").keyup(function(){
        	$("#message").html("<span style='font-size:10pt'>Checking.....</span>");
			var usernameid=$("#username").val();
 
            $.ajax({
                type:"post",
                url:"mod/administrator/check.php",
                data:"username="+usernameid,
                success:function(data){
                    if(data==0){
                        $("#message").html("<span style='color:green;font-size:10pt'>Username Available!</span>");
                        validusn=true;
                    }
                    else{
                    	$("#message").html("<span style='color:red;font-size:10pt'>Username already taken!</span>");
                       	validusn=false;
                       	return false;
                    }
                }
            });
        	});	
		}

		function validateemail() {
			$("#email").keyup(function(){
        	$("#messageemail").html("<span style='font-size:10pt'>Checking.....</span>");
			var emailid=$("#email").val();
 			var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;  
            $.ajax({
                type:"post",
                url:"mod/administrator/check.php",
                data:"email="+emailid,
                success:function(data){
                	if(email.value.match(mailformat)) {  
						validemail=true;  
					} else {  
						$("#messageemail").html("<span style='color:red;font-size:10pt'>Please enter correct email!</span>"); 
						email.focus();
						$(email).css("border-color","red");
						return false;  
					}
                    if(data==0){
                        $("#messageemail").html("<span style='color:green;font-size:10pt'>Email Available!</span>");
                        validemail=true;
                    } else {
                    	$("#messageemail").html("<span style='color:red;font-size:10pt'>Email already taken!</span>");
                       	validemail=false;
                       	return false;
                    }
                }
            });
        	});	
		}

		function validatepass() {
			$("#password,#cpassword").keyup(function(){
        	$("#confirmMessage").html("Checking.....");
			if(password.value!=cpassword.value) {
			    $("#confirmMessage").html("<span style='color:red;font-size:10pt'>Password Don't Match!</span>");
			    $(cpassword).css("border-color","red");
			    validpass=false;
                return false;
			} else {
				$("#confirmMessage").html("<span style='color:green;font-size:10pt'>Password Match!</span>");
				$(cpassword).css("border-color","");
			    validpass=true;
			}

			if(password.value.length < 5) {
			    password.focus();
			    $("#confirmMessage").html("<span style='color:red;font-size:10pt'>Password must be least 5 character</span>");
			    $(password).css("border-color","red");
			    validpass=false;
                return false;
			} else {
				$(password).css("border-color","");
				validpass=true;
			}
			});
		}

		function validatephoto() {
			var _URL = window.URL || window.webkitURL;
			var photo = document.inputuser.photo;
			var file, img;

		    if ((file = photo.files[0])) {
		        img = new Image();
		        img.onload = function() {
		        	if (this.width != 300 && this.height !=300) {
		        		alert("Width must 300 px height must 300 px!");
		        		validphoto = false;
		        		return false;
		        	} else {
		        		validphoto = true;
		        		return true;
		        	};
		            
		        };
		        img.src = _URL.createObjectURL(file);
		    }
		}

		function ValidateForm() {
			$('.required,.requiredpass').change(function(){
        		$(this).css("border-color","");
        	});

			var username = document.inputuser.username;
			var password = document.inputuser.password;
			var cpassword = document.inputuser.cpassword;
			var fullname = document.inputuser.fullname;
			var email = document.inputuser.email;
			var role = document.inputuser.role;
		    
			var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;  

		    if (username.value == "" || !validusn) {
			    window.alert("Please insert valid username.");
			    username.focus();
			    $(username).css("border-color","red");
			    return false;
			} else if(password.value=="") {
				window.alert("Please enter password.");
			    password.focus();
			    $(password).css("border-color","red");
			    return false;
			} else if(cpassword.value=="" || !validpass) {
				window.alert("Please fix the error!.");
			    cpassword.focus();
			    $(cpassword).css("border-color","red");
				return false;
			} else if(fullname.value=="") {
				window.alert("Please enter fullname.");
			    fullname.focus();
			    $(fullname).css("border-color","red");
			    return false;
			} else if(email.value=="" || !validemail) {
				$("#messageemail").html("<span style='color:red;font-size:10pt'>Please enter correct mail.</span>");
			    email.focus();
			    $(email).css("border-color","red");
			    return false;
			} else if(role.value=="") {
				window.alert("Please enter role.");
			    role.focus();
			    $(role).css("border-color","red");
			    return false;
			}
			if (!validpass) {
				$(password).css("border-color","");
			};	
			if(password.value!=cpassword.value) {
				window.alert("Password confirmation invalid.");
			    cpassword.focus();
			    $(cpassword).css("border-color","red");
			    $("#confirmMessage").html("<span style='color:red'>Password Don't Match!</span>");
			    return false;
			}

			if(email.value.match(mailformat)) {  
				return true;  
			} else {  
				alert("You have entered an invalid email address!");  
				email.focus();
				$(email).css("border-color","red");
				return false;  
			}
			if(!validphoto) {
				alert("Photo must 300px x 300px");
				return false;
			}
			$('.loading').show();
			return true;
		}
		</script>
		<div id="confirmation-box" class="confirmation-popup popup-box">
			<form action="?mod=administrator&page=users_manager&act=add_user" method="POST" enctype="multipart/form-data" name="inputuser">
		 		<div class="modal-dialog" style="width:700px">
		    	
		    	<div class="modal-content" style="height:500px;overflow:scroll">
			      <!-- dialog body -->
			      <div class="modal-body" style="padding:10px">

			        <a class="close">&times;</a>
			        Add New User. Field yang bertanda <span style="color:red;font-size:25px">*</span> wajib diisi!

			        <div class="loading" style="display:none;"><img src="img/load.gif" alt="" /></div>

			        <table width="100%" class="table table-hover table-background table-bordered" style="margin-bottom:-20px;">
				        <script type="text/javascript">
									$(document).ready(function () {
								    $('input.requiredusn').keyup(function() {
							        var $th = $(this);
							        $th.val( $th.val().replace(/[^a-zA-Z0-9_]/g, function(str) { alert('Input Invalid'); return ''; } ) );
								    });
								    $('input.requiredpass').keyup(function() {
							        var $th = $(this);
							        $th.val( $th.val().replace(/[^a-zA-Z0-9_ ]/g, function(str) { alert('Input Invalid'); return ''; } ) );
								    });
									});
								</script>
		        		<tr>
		        			<td>Username <span style="color:red;font-size:25px">*</span></td>
		        			<td><input type="text" name="username" id="username" class="form-control required requiredusn" autocomplete="Off" onkeyup="return validateusn();"/><span id="message"></span></td>
		        		</tr>
		        		<script type="text/javascript">

		        		</script>
		        		<tr>
		        			<td>Password <span style="color:red;font-size:25px">*</span></td>
		        			<td><input autocomplete="off" type="password" id ="password" name="password" class="form-control required requiredpass" onchange="return validatepass();"/></td>
		        		</tr>

		        		<tr>
		        			<td>Confirm Password <span style="color:red;font-size:25px">*</span></td>
		        			<td><input autocomplete="off" type="password" id ="cpassword" name="cpassword" class="form-control required requiredpass" onchange="return validatepass();"/><span id="confirmMessage"></span></td>
		        		</tr>

		        		<tr>
		        			<td>Fullname <span style="color:red;font-size:25px">*</span></td>
		        			<td><input type="text" name="fullname" class="form-control required"/></td>
		        		</tr>
		        		<tr>
		        			<td>Email <span style="color:red;font-size:25px">*</span></td>
		        			<td><input type="text" name="email" id="email" class="form-control required" onkeyup="return validateemail();" autocomplete="off"/><span id="messageemail"></span></td>
		        		</tr>
		        		<tr>
		        			<td>Address</td>
		        			<td>
		        				<textarea name="address" class="form-control" row="1"></textarea>
		        			</td>
		        		</tr>
		        		<tr>
		        			<td>Role <span style="color:red;font-size:25px">*</span></td>
		        			<td>
		        				<select name="role" class='form-control required' style='width:100%;padding:0px;'>
		        					<option value="">-- Select Role --</option>
		        					<option value="1">Administrator</option>
		        					<option value="2">User</option>
		        				</select>
		        			</td>
		        		</tr>
		        		<tr>
		        			<td>Photo</td>
		        			<td><input type="file" name="photo" class="form-control" id="photo" onchange="return validatephoto();"/><span id="photoconfirmMessage"></span></td>
		        		</tr>
			        </table>
			      </div>
		      	<!-- dialog buttons -->
			      <div class="modal-footer" style="margin:-10px 0px -10px 0px">
			      	<input class="btn btn-danger b" id="submit" type="submit" value="Create" name="create" onclick="return ValidateForm();"/>
			        <button type="button" class="btn btn-primary c">No</button>
			      </div>
		    	</div>
				</div>
			</form>
		</div>

		<?php
			if($_POST['deleteall'] || $_POST['delete'] ) {
				include 'users_manager-delete_user.php';
			} 
		?>
		<div class="head">
			<table width="100%">
				<form action="?mod=administrator&page=users_manager" method="POST">
					<tr width="100%">
						<td width="7%">Filter Users</td>
						<td width="30%">
							<input type="text" name="keyword" placeholder="By Keyword" value="<?=$keyword?>" class="form-control">
						</td>
						<td width="10%">
							<select name="role">
								<option value="">All Role</option>
								<option value="1" <?php if($role==1) echo "selected"?>>Administrator</option>
								<option value="2" <?php if($role==2) echo "selected"?>>User</option>
							</select>
						</td>
						<td width="8%">
							<select name="sort_of">
								<option value="asc" <?php if($sort_of=="asc") echo "selected"?>>Ascending</option>
								<option value="desc" <?php if($sort_of=="desc") echo "selected"?>>Discending</option>
							</select>
						</td>
						<td width="5%">
							<input type="submit" class="btn btn-primary" style="margin-left:10px;" name="search_it" value="GO!">
						</td>
					</tr>
				</form>
			</table>
		</div>

		<div class="content">
			<table width="100%" class="table table-hover table-background respond">
				<form action="" method="post" name="checkboxlistusers" id="checkbox">
					<thead>
						<tr>
						<script type="text/javascript">
						function check_all(val) {
						    var checkbox = document.checkboxlistusers.elements['checkboxusers[]'];
						    if ( checkbox.length > 0 ) {
						        for (i = 0; i < checkbox.length; i++) {
						            if ( val.checked ) {
						                checkbox[i].checked = true;
						            }
						            else {
						                checkbox[i].checked = false;
						            }
						        }
						    }
						    else {
						        if ( val.checked ) {
						            checkbox.checked = true;
						        }
						        else {
						            checkbox.checked = false;
						        }
						    }
						}

						</script>
						<th width="4%" class="center"><input type="checkbox" onclick="check_all(this)"></th>
						<th width="22%">Username</th>
						<th width="22%">Name</th>
						<th width="34%">Email</th>
						<th width="19%">Role</th>
						</tr>
					</thead>

					<tbody class="">
						<?php
							while($row=$q->fetch(PDO::FETCH_ASSOC)) {
								if ($row['role']=='1') {
									$role="administrator";
								} else if ($row['role']=='2') {
									$role="users";
								}
						?>

					<tr>
						<td class="center">
							<input type="hidden" name="root[]" value="<?=$role;?>"> 
							<?php
								if($row['id']!=$_SESSION['user_id']) {
									echo '<input type="checkbox" name="checkboxusers[]" value="'.$row['username'].'" id="checkbox">';
								}
							?>
						</td>
						<td>
							<div class="img_photo_admin">
								<?php
									if($row['photo']=="") {
										$img="img/user.png";							
									} else {
										$img=$row['photo'];
									}
								?>
								<img src="<?=$img?>" width="36"/>
							</div>
							<style type="text/css">
								.action {
									font-size: 0.7em;
								}
								.action .edit {

								}
								.action .delete a{
									color:red;
								}
							</style>
							<?=$row['username']?>
							<?php
								if($row['id']==$_SESSION['user_id']) {
									echo '	<div class="action">
												<span class="edit"><a href="?mod=administrator&page=users_manager&act=edit&username='.$row['username'].'&id_user='.$row['id'].'">Edit</a></span>
											</div>';
								} else {
							?>
							<div class="action">
								<span class="edit"><a href="?mod=administrator&page=users_manager&act=edit&username=<?=$row['username']?>&id_user=<?=$row['id']?>">Edit</a></span> | 
								<span class="delete"><a href="?mod=administrator&page=users_manager&act=delete&username=<?=$row['username']?>&id_user=<?=$row['id']?>">Delete</a></span>
							</div>
							<?php
								}
							?>
						</td>
						<td><?=$row['fullname']?></td>
						<td><?=$row['email']?></td>
						<td>
							<?php
								if($row['role']=="2") {
									$word="User";
								} else {
									$word="Administrator";
								}
								
							?>
							<?=$word?>
						</td>
					</tr>
						<?php
							}
						?>
						<div id="confirmation-box-selecteddelete" class="confirmation-popup">
						 <div class="modal-dialog">
						    <div class="modal-content">
						      <!-- dialog body -->
						      <div class="modal-body" style="height:50px;padding:20px">
						        <a class="close">&times;</a>
						        Are you sure delete selected users and delete their files?   
						        <div class="loading" style="display:none;"><img src="img/load.gif" alt="" /></div>
						      </div>
						      <!-- dialog buttons -->
						      <div class="modal-footer"><button class="btn btn-danger d" type="submit" value="Delete" name="deleteall"/>OK</button>
						        <button type="button" class="btn btn-primary c">No</button>

						      </div>
						    </div>
						  </div>
						</div>
						<tr>
							<td colspan="7">
						    	<span>Checked Action</span> :&nbsp;  <button name="#confirmation-box-selecteddelete" class="btn btn-danger confirmation">Delete</button>
						    </td>
						</tr>
					</tbody>
				</form>
			</table>
		</div>
		
	</div>

	<div style="clear:both"></div>
	<div id="footer">
		Copyright &copy; <?=date("Y");?> CT Upload Portal. All Right Reserved.
	</div>

</div>