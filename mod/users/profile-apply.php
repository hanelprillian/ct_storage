<?php
	error_reporting(0);
	session_save_path("temp/sessions");
	session_start();
	if(!isset($_SESSION['role'])) die ("<h1>Not Found</h1>
<p>The requested URL $_SERVER[PHP_SELF] was not found on this server.</p>");
	if($_SESSION['role']!="users") {
		header('location:login.php');
		exit();
	} 

	if($_POST['save_general_set']) {
		$fullname=trim(htmlentities(htmlspecialchars(addslashes($_POST['fullname']))));
		$email=trim(htmlentities(htmlspecialchars(addslashes($_POST['email']))));
		$address=trim(htmlentities(htmlspecialchars(addslashes($_POST['address']))));

		$q=$db->prepare("UPDATE users SET fullname = :fn, email = :email, address= :address where id = :id and role = '2'");
		$q->bindParam(":fn",$fullname);
		$q->bindParam(":email",$email);
		$q->bindParam(":address",$address);
		$q->bindParam(":id",$_SESSION['user_id']);

		$q->execute();

		if($_FILES['filePhoto']['tmp_name']=="") {

		} else {
			$img_type=$_FILES["filePhoto"]['type'];
		    $allowext=array("jpeg","jpg","gif","png","jpe");
		      $allowtype = array(
		            // images
		            'png' => 'image/png',
		            'jpe' => 'image/jpeg',
		            'jpeg' => 'image/jpeg',
		            'jpg' => 'image/jpeg',
		            'gif' => 'image/gif',
		        );
		      $ex_file=end(explode(".",$_FILES["filePhoto"]['name']));

		      if(in_array($img_type, $allowtype) && in_array($ex_file,$allowext)){
		         $upload = true;
		      } else {
		        $upload = false;
		      }
		      if($upload) {
		         //loop the uploaded file array
		        $filen = $_FILES["filePhoto"]['name']; //file name
		        $path = 'img/'.$filen; //generate the destination path
		        move_uploaded_file($_FILES["filePhoto"]['tmp_name'],$path);
		        $q=$db->prepare("UPDATE users SET photo = :photo where id = :id and role = '2'");
				$q->bindParam(":photo",$path);
				$q->bindParam(":id",$_SESSION['user_id']);

				$q->execute();
		      }
		}

		header('location:?mod=users&page=profile&msg=success&id_msg=1');
		exit();
		
	} else if($_POST['save_password_set']) {
		if($_POST['old_pass']=="" || $_POST['new_pass']=="") {
			header('location:?mod=users&page=profile&msg=error&id_msg=2');
			exit();
		} else if($_POST['old_pass']==$_POST['new_pass']) {
			header('location:?mod=users&page=profile&msg=error&id_msg=3');
			exit();
		} else {
			$old_pass=trim(htmlentities(htmlspecialchars(addslashes(md5($_POST['old_pass'].SALT_FOR_PASSWORD)))));
			$new_pass=trim(htmlentities(htmlspecialchars(addslashes(md5($_POST['new_pass'].SALT_FOR_PASSWORD)))));
			$q=$db->prepare("SELECT * FROM users where id = :id and password = :oldpass and role= '2'");
			$q->bindParam(":id",$_SESSION['user_id']);
			$q->bindParam(":oldpass",$old_pass);
			$q->execute();

			$check=$q->rowCount();
			if($check == 1) {
				$q=$db->prepare("UPDATE users set password = :newpass where id = :id and role= '2'");
				$q->bindParam(":newpass",$new_pass);
				$q->bindParam(":id",$_SESSION['user_id']);
				$q->execute();
				header('location:?mod=users&page=profile&msg=success&id_msg=2');
				exit();
			} else {
				header('location:?mod=users&page=profile&msg=error&id_msg=1');
				exit();
			}
		}
	} else {
		header('location:?mod=users&page=profile');
		exit();
	}
?>
