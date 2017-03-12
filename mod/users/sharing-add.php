<?php
	error_reporting(0);
	session_start();
	if(!isset($_SESSION['role'])) die ("<h1>Not Found</h1>
<p>The requested URL $_SERVER[PHP_SELF] was not found on this server.</p>");
	if($_SESSION['role']!="users") {
		header('location:login.php');
		exit();
	}
	if($_POST['share']) {
		if($_POST['folder_select']=="") {
			header('location:?mod=users&page=sharing&msg=error&id_msg=1');
			exit();
		} else if ($_POST['email']=="") {
			header('location:?mod=users&page=sharing&msg=error&id_msg=2');
			exit();
		} else {
			$folder_select=trim(htmlentities(htmlspecialchars(addslashes(str_replace('..', '',$_POST['folder_select'])))));
			$email=trim(htmlentities(htmlspecialchars(addslashes(str_replace('..', '',$_POST['email'])))));
			$permission=trim(htmlentities(htmlspecialchars(addslashes(str_replace('..', '',$_POST['permission'])))));

			$explode_folder_select=explode("-", $folder_select);
			$folder_select_name=$explode_folder_select[0];
			$folder_select_root=$explode_folder_select[1];

			$q=$db->prepare("SELECT * FROM users where email = '$email'");
			$q->execute();
			$check=$q->rowcount();
			$fetch=$q->fetch(PDO::FETCH_ASSOC);
			if($check==1) {
				$q=$db->prepare("SELECT * FROM user_sharing_subscriber where id_user = '$_SESSION[user_id]' and id_subscriber = '$fetch[id]' and folder_sharing = '$folder_select_root'");
				$q->execute();
				$check=$q->rowcount();
				if($check==1) {
					header('location:?mod=users&page=sharing&msg=error&id_msg=4');
					exit();
				} else {
					$q=$db->prepare("INSERT INTO user_sharing_subscriber SET id_user = '$_SESSION[user_id]', id_subscriber = '$fetch[id]', folder_sharing = '$folder_select_root', folder_name = '$folder_select_name', root_user = '$_SESSION[username]', status = '0', permission = '$permission'");
					$q->execute();

					$title_log="<b>$folder_select_name</b> to user email account <b>$email</b>";
					$q_log=$db->prepare("INSERT INTO user_recent_activity SET id_user='$_SESSION[user_id]',date=now(), action='Share',type='Folder',name='$title_log'");
			  		$q_log->execute();
				}
			} else {
				header('location:?mod=users&page=sharing&msg=error&id_msg=3');
				exit();
			}

			header('location:?mod=users&page=sharing&msg=success&id_msg=4');
			exit();
		}
	} else if($_POST['share_each']) {
		if ($_POST['email']=="") {
			header('location:?mod=users&page=sharing&msg=error&id_msg=2');
			exit();
		} else {
			$email=trim(htmlentities(htmlspecialchars(addslashes(str_replace('..', '',$_POST['email'])))));
			$permission=trim(htmlentities(htmlspecialchars(addslashes(str_replace('..', '',$_POST['permission'])))));
			$folder_select_name=trim(htmlentities(htmlspecialchars(addslashes(str_replace('..', '',$_POST['folder_to_share_name'])))));
			$folder_select_root=trim(htmlentities(htmlspecialchars(addslashes(str_replace('..', '',$_POST['folder_to_share_path'])))));

			$q=$db->prepare("SELECT * FROM users where email = '$email'");
			$q->execute();
			$check=$q->rowcount();
			$fetch=$q->fetch(PDO::FETCH_ASSOC);

			if($check==1) {
				$q=$db->prepare("SELECT * FROM user_sharing_subscriber where id_user = '$_SESSION[user_id]' and id_subscriber = '$fetch[id]' and folder_sharing = '$folder_select_root'");
				$q->execute();
				$check=$q->rowcount();

				if($check==1) {
					header('location:?mod=users&page=sharing&msg=error&id_msg=4');
					exit();
				} else {
					$q=$db->prepare("INSERT INTO user_sharing_subscriber SET id_user = '$_SESSION[user_id]', id_subscriber = '$fetch[id]', folder_sharing = '$folder_select_root', folder_name = '$folder_select_name', root_user = '$_SESSION[username]', status = '0', permission = '$permission'");
					$q->execute();

					$title_log="<b>$folder_select_name</b> to user email account <b>$email</b>";
					$q_log=$db->prepare("INSERT INTO user_recent_activity SET id_user='$_SESSION[user_id]',date=now(), action='Share',type='Folder',name='$title_log'");
			  		$q_log->execute();
				}
				
			} else {
				header('location:?mod=users&page=sharing&msg=error&id_msg=3');
				exit();
			}

			header('location:?mod=users&page=sharing&msg=success&id_msg=4');
			exit();
		}
	}
?>
<div class="title-dash">
	<i class="fa fa-share-square-o fa-3x left"></i><div class="title">Share</div>
</div>

<div style="clear:both"></div>

<div class="content-dash">
	<div class="box">
		<div class="head">
			<?php

	      $folder_to_share_path_only=trim(htmlentities(htmlspecialchars(addslashes(str_replace('..', '',$_GET['folder_path'])))));
	      $folder_to_share_path_name=rtrim($folder_to_share_path_only,"/");
	      $folder_to_share_name=end(explode("/", $folder_to_share_path_name));
	      
	      if (!is_dir(STORAGE_DIR.'/'.$folder_to_share_path_only)) {
	      	die("Folder not found!");
	      }
	    ?>
	    Share a Folder <strong><?=$folder_to_share_name?></strong>
		</div>

		<div class="content">
			<script type="text/javascript">
			function validateemail() {
				$("#email").keyup(function(){
				    $("#messageemail").html("<span style='font-size:10pt'>Checking.....</span>");
						var emailid=$("#email").val();
						var mailformat = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;  
			        $.ajax({
		            type:"post",
		            url:"mod/users/check_email_to_share.php?id=<?=$_SESSION['user_id']?>",
		            data:"email="+emailid,
		            success:function(data){
		            
			            if(email.value.match(mailformat)) {  
										validemail=true;  
									} else {  
										$("#messageemail").html("<span style='color:red;font-size:10pt'>Please enter correct email!</span>"); 
										email.focus();
										$(email).css("border-color","red");
										validemail=false;  
										return false;  
									}

		              if(data==1){
		                  $("#messageemail").html("<span style='color:green;font-size:10pt'>Email found!</span>");
		                  $(email).css("border-color","green");
		                  validemail=true;
		              } else if(data==2){
		                  $("#messageemail").html("<span style='color:red;font-size:10pt'>It's your mail!</span>");
		                  $(email).css("border-color","red");
		                  validemail=false;
		              } else {
		              	$("#messageemail").html("<span style='color:red;font-size:10pt'>Email not found!</span>");
		              	$(email).css("border-color","red");
		                 	validemail=false;
		                 	return false;
		              }
			          }
			        });
			    	});	
					}
				function ValidateForm() {
					var email = document.sharefolders.email;
					var mailformat = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;  

					if (email.value=="" || !validemail) {
						alert("Please fix error!");
						$(email).css("border-color","red");
						return false;
					} else if(email.value.match(mailformat)) {  
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

			<form action="" method="POST" enctype="multipart/form-data" name="sharefolders">

		    <input type="hidden" name="folder_to_share_name" value="<?=$folder_to_share_name?>">
		    <input type="hidden" name="folder_to_share_path" value="<?=$folder_to_share_path_only?>">

		    <div class="loading" style="display:none;"><img src="img/load.gif" alt="" /></div>

		    <table width="100%" class="table table-hover table-background table-bordered">
			    <tr>
						<td width="20%">Select User By Email</td>
						<td>
					    <input type="text" name="email" id="email" class="form-control" onkeyup="return validateemail();" autocomplete="off"/><span id="messageemail"></span>
						</td>
					</tr>

					<tr>
						<td>
							Permission
						</td>
						<td>
							<select name="permission">
								<option value="r">Read</option>
								<option value="rw">Read / Write</option>
							</select>
						</td>
					</tr>

			    <tr>
			    	<td></td>
			    	<td>
			    		<input class="btn btn-danger b" type="submit" value="Share" name="share_each" onclick="return ValidateForm();"/>
			    		<button type="button" class="btn btn-primary c">No</button>
			    	</td>
			    </tr>
		    </table>
			</form>
			
		</div>
		
	</div>
</div>



<div style="clear:both"></div>
<div id="footer">
	Copyright &copy; <?php echo date("Y")?> CT Upload Portal. All Right Reserved.
</div>

