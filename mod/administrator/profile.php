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
	<i class="fa fa-user fa-3x left margin10right"></i><div class="title">Profile</div>
</div>
<script type="text/javascript">
 $(document).ready(function() {
 
  $('.alert').fadeOut(5000);
   });
</script>
<?php
	$msg=trim(htmlentities(htmlspecialchars(addslashes($_GET['msg']))));
	$id_msg=trim(htmlentities(htmlspecialchars(addslashes($_GET['id_msg']))));

	if($msg=="error") {
		if($id_msg==1) {
			echo '<div class="alert alert-block alert-danger fade in">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
					<p align="center">Wrong Old Password!</p>
				</div>';
		} else if ($id_msg==2) {
			echo '<div class="alert alert-block alert-danger fade in">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
					<p align="center">Password Field is Empty!</p>
				</div>';
		} else if ($id_msg==3) {
			echo '<div class="alert alert-block alert-danger fade in">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
					<p align="center">New password must not be same as old password</p>
				</div>';
		}
	} else if($msg=="success") {
		if($id_msg==1) {
			echo '<div class="alert alert-block alert-success fade in">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
					<p align="center">Success Edit Profile!</p>
				</div>';
		} else if($id_msg==2) {
			echo '<div class="alert alert-block alert-success fade in">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
					<p align="center">Success Change Password!</p>
				</div>';
		}
	}
?>
<div style="clear:both"></div>
<div class="content-dash">
<?php
	if($_SESSION['role']=="administrator") {
		$role=1;
	}
	$q=$db->prepare("SELECT * FROM users where id = :id and role = :role");
	$q->bindParam(':id',$_SESSION['user_id']);
	$q->bindParam(':role',$role);
	$q->execute();

	$r=$q->fetch(PDO::FETCH_ASSOC);
?>
<script type="text/javascript">
	function validateemail() {
		$('#email').change(function(){
			$(this).css("border-color","");
		});

		$("#email").change(function(){
			$("#messageemail").html("<span style='font-size:10pt'>Checking.....</span>");
			var emailid=$("#email").val();
			var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;  
			$.ajax({
			    type:"post",
			    url:"mod/administrator/check.php?id=<?=$r['id']?>",
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

	function ValidateForm() {
		$('.required').change(function(){
			$(this).css("border-color","");
		});
		var fullname = document.generalset.fullname;
		var email = document.generalset.email;
		var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;  
	 
		if(fullname.value=="") {
			window.alert("Fullname is empty!.");
		    fullname.focus();
		    $(fullname).css("border-color","red");
		    return false;
		} else if (email.value=="" || !validemail) {
			window.alert("Please fix the error!.");
		    email.focus();
		    $(email).css("border-color","red");
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

		return true;
	}
</script>
	<div class="box">
		<div class="head">
			Information
		</div>
		<div class="content">
			<table width="100%" class="table table-hover table-background table-bordered">
				<form action="?mod=administrator&page=profile&act=apply" method="post" enctype="multipart/form-data" name="generalset">
					<tbody>
						<tr>
							<td width="20%"><label for="username">Username</label></td>
							<td width="80%">
								<div class="input-group" style="width:100%">
					            	<input type="text" name="username" style="color:black;font-weight:bold" class="form-control" id="username" placeholder="Your Username" value="<?=$r['username']?>" readonly/>    
					         	</div>
					     	</td>
						</tr>
						<tr>
							<td width="20%"><label for="fullname">Fullname</label></td>
							<td width="80%">
								<div class="input-group" style="width:100%">
					            	<input type="text" name="fullname" class="form-control required" id="fullname" placeholder="Your Fullname" value="<?=$r['fullname']?>"/>    
					         	</div>
					     	</td>
						</tr>
						<tr>
							<td width="20%"><label for="email">Email</label></td>
							<td width="80%">
								<div class="input-group" style="width:100%">
					            	<input type="text" name="email" id="email" class="form-control required" onkeyup="return validateemail();" autocomplete="off" placeholder="Your Mail" value="<?=$r['email']?>"/><span id="messageemail"></span>  
					         	</div>
					     	</td>
						</tr>
						<tr>
							<td width="20%"><label for="address">Address</label></td>
							<td width="80%">
								<div class="input-group" style="width:100%">
									<textarea name="address" id="address" class="form-control" rows="3" style="padding-top:10px"><?=$r['address']?></textarea>
					         	</div>
					     	</td>
						</tr>
						<tr>
							<td width="20%"><label for="address">Photo</label></td>
							<td width="60%">
								<div class="input-group" style="width:100%">
									<img src="<?=$r['photo']?>" width="100"><br>
									<input type="file" name="filePhoto"/>
								</div>
					     	</td>
						</tr>
						<tr>
							<td width="20%"></td>
							<td width="80%">
								<div class="input-group" style="width:100%">
									<input class="btn btn-primary" type="submit" value="Save As" name="save_general_set" onclick="return ValidateForm();"/>
					         	</div>
					     	</td>
						</tr>
					</tbody>
				</form>
			</table>
		</div>
	</div>

	<div class="box">
		<div class="head">
			Security
		</div>
		<div class="content"> 
			<script type="text/javascript">
				var validpass=true;

				function ValidateFormPass() {
					$('#old_pass,#new_pass,#cnew_pass').change(function(){
		        		$(this).css("border-color","");
		        	});
					var oldpassword = document.passwordset.old_pass;
					var newpassword = document.passwordset.new_pass;
					var cnewpassword = document.passwordset.cnew_pass;

					if(oldpassword.value=="") {
						window.alert("Old password is empty!.");
					    oldpassword.focus();
					    $(oldpassword).css("border-color","red");
					    return false;
					} else if (newpassword.value=="") {
						window.alert("New password is empty!.");
					    newpassword.focus();
					    $(newpassword).css("border-color","red");
					    return false;
					} else if(newpassword.value!=cnewpassword.value) {
						window.alert("Password confirmation don't match!.");
					    cnewpassword.focus();
					    $(cnewpassword).css("border-color","red");
					    return false;
					} else if(cnewpassword.value=="" || !validpass) {
						window.alert("Please validate password.");
					    cnewpassword.focus();
					    $(cnewpassword).css("border-color","red");
						return false;
						}
					return true;
				}
				function validatepass() {
					$("#new_pass,#cnew_pass").change(function(){
					if(newpassword.value!=cnewpassword.value) {
					    cnewpassword.focus();
					    $(cnewpassword).css("border-color","red");
					    validpass=false;
			            return false;
					} else {
						$(cnewpassword).css("border-color","green");
					    validpass=true;
					}
					});
				}
			</script>
			<table width="100%" class="table table-hover table-background table-bordered">
				<form action="?mod=administrator&page=profile&act=apply" method="post" enctype="multipart/form-data" name="passwordset">
					<tbody>
						<tr>
							<td width="20%"><label for="old_pass">Old Password</label></td>
							<td width="80%">
								<div class="input-group" style="width:100%">
									<input type="password" name="old_pass" id="old_pass" class="form-control w">
					         	</div>
					     	</td>
						</tr>
						<tr>
							<td width="20%"><label for="new_pass">New Password</label></td>
							<td width="80%">
								<div class="input-group" style="width:100%">
									<input type="password" name="new_pass" id="new_pass" class="form-control" onkeyup="return validatepass();">
					         	</div>
					     	</td>
						</tr>
						<tr>
							<td width="20%"><label for="new_pass">Confirm New Password</label></td>
							<td width="80%">
								<div class="input-group" style="width:100%">
									<input type="password" name="cnew_pass" id="cnew_pass" class="form-control" onkeyup="return validatepass();">
					         	</div>
					     	</td>
						</tr>
						<tr>
							<td width="20%"></td>
							<td width="80%">
								<div class="input-group" style="width:100%">
									<input class="btn btn-primary" type="submit" value="Save As" name="save_password_set" onclick="return ValidateFormPass();"/>
					         	</div>
					     	</td>
						</tr>
					</tbody>
				</form>
			</table>
		</div>
	</div>

	<div style="clear:both"></div>
	<div id="footer">
		Copyright &copy; <?php echo date("Y")?> CT Upload Portal. All Right Reserved.
	</div>

</div>