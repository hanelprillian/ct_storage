<?php
	error_reporting(0);
	session_start();
	if(!isset($_SESSION['role'])) die ("<h1>Not Found</h1>
<p>The requested URL $_SERVER[PHP_SELF] was not found on this server.</p>");
	if($_SESSION['role']!="administrator") {
		header('location:login.php');
		exit();
	}

	$usn=trim(htmlentities(htmlspecialchars(addslashes($_GET['username']))));
	$id_user=trim(htmlentities(htmlspecialchars(addslashes($_GET['id_user']))));
?>
<div class="title-dash">
	<i class="fa fa-eraser fa-3x left margin10right"></i><div class="title">Delete User</div>
</div>
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
	} 
?>
<div style="clear:both"></div>
<div class="content-dash">
	<?php
		$q=$db->prepare("SELECT * FROM users where username = :usn and id = :id");
		$q->bindParam(':usn',$usn);
		$q->bindParam(':id',$id_user);
		$q->execute();
		$count=$q->rowCount();
		$r=$q->fetch(PDO::FETCH_ASSOC);

		if($count!=1) {
			die("Username or Id User not found!");
		}

		if($_POST['delete_ok']) {

			if ($r['role']==1) {
				$role="administrator";
			} elseif ($r['role']==2) {
				$role="users";
			}

			if($r['username']==$_SESSION['username']) {
				header('location:?mod=administrator&page=users_manager&msg=error&id_msg=3');
				exit();
			}

			$user_file=ROOT_FILE.$role.'/'.$r['username'];

			if(is_dir($user_file)) {
				$dir = $user_file;
				chmod($dir, 0755);
				$di = new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS);
				$ri = new RecursiveIteratorIterator($di, RecursiveIteratorIterator::CHILD_FIRST);
				foreach ( $ri as $file ) {
					$file->isDir() ?  rmdir($file) : unlink($file);
				}

				rmdir($dir);

				$q=$db->prepare("DELETE FROM users where username = :uname");
				$q->bindParam(":uname",$r['username']);
				$q->execute();

				// delete sharing folder
				$q_del_share_folder=$db->prepare("DELETE FROM user_sharing_subscriber where id_user ='$id_user'");
				$q_del_share_folder->execute();

				// delete public links
				$q_del_pub_links=$db->prepare("DELETE FROM user_public_links where id_user ='$id_user'");
				$q_del_pub_links->execute();

				// delete recent action
				$q_del_recent_act=$db->prepare("DELETE FROM user_recent_activity where id_user ='$id_user'");
				$q_del_recent_act->execute();

				//delete photo 
				unlink($r['photo']);

			} else {
				$q=$db->prepare("DELETE FROM users where username = :uname");
				$q->bindParam(":uname",$r['username']);
				$q->execute();

				// delete sharing folder
				$q_del_share_folder=$db->prepare("DELETE FROM user_sharing_subscriber where id_user ='$id_user'");
				$q_del_share_folder->execute();

				// delete public links
				$q_del_pub_links=$db->prepare("DELETE FROM user_public_links where id_user ='$id_user'");
				$q_del_pub_links->execute();

				// delete recent action
				$q_del_recent_act=$db->prepare("DELETE FROM user_recent_activity where id_user ='$id_user'");
				$q_del_recent_act->execute();

				//delete photo 
				unlink($r['photo']);
			}

			header('location:?mod=administrator&page=users_manager&msg=success&id_msg=2');
			exit();

		} else if($_POST['delete_cancel']){
			header('location:?mod=administrator&page=users_manager');
			exit();
		}
	?>

	<div class="box">
		<div class="head">
			Confirm Delete
		</div>
		<div class="content">
			<?php
				if ($r['username']==$_SESSION['username']) {
					echo "You cannot delete yourself!";
				} else {
			?>
			Are you sure want to delete <strong><?=$r['fullname']?></strong> with their files permanently? <br>
			<form action="" method="POST">
				<input type="submit" class="btn btn-danger" value="Ok" name="delete_ok" onclick="return confirm('are you sure?')">&nbsp;&nbsp;
				<input type="submit" class="btn btn-primary" value="Cancel" name="delete_cancel">
			</form>
			<?php
				}
			?>
		</div>
	</div>
	
	<div style="clear:both"></div>
	
	<div id="footer">
		Copyright &copy; <?php echo date("Y")?> CT Upload Portal. All Right Reserved.
	</div>

</div>