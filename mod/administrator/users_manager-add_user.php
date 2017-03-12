<?php
	error_reporting(0);
	session_start();
	if(!isset($_SESSION['role'])) die ("<h1>Not Found</h1>
<p>The requested URL $_SERVER[PHP_SELF] was not found on this server.</p>");
	if($_SESSION['role']!="administrator") {
		header('location:login.php');
		exit();
	}

	if($_POST['create']) {
		$usn=trim(htmlentities(htmlspecialchars(addslashes($_POST['username']))));
		$psw=trim(htmlentities(htmlspecialchars(addslashes(md5($_POST['password'].SALT_FOR_PASSWORD)))));
		$cpsw=trim(htmlentities(htmlspecialchars(addslashes(md5($_POST['cpassword'].SALT_FOR_PASSWORD)))));
		$fname=trim(htmlentities(htmlspecialchars(addslashes($_POST['fullname']))));
		$email=trim(htmlentities(htmlspecialchars(addslashes($_POST['email']))));
		$address=trim(htmlentities(htmlspecialchars(addslashes($_POST['address']))));
		$role=trim(htmlentities(htmlspecialchars(addslashes($_POST['role']))));

		if($usn == "" || $psw=="" || $fname=="" || $email=="" || $role=="" || $cpsw!=$psw) {
			header('location:?mod=administrator&page=users_manager&msg=error&id_msg=2');
			exit();
		} else {
			$usn=trim(htmlentities(htmlspecialchars(addslashes(str_replace('..', '',str_replace('/', '',str_replace(" ", "", $_POST['username'])))))));
			$psw=trim(htmlentities(htmlspecialchars(addslashes(md5($_POST['password'].SALT_FOR_PASSWORD)))));
			$fname=trim(htmlentities(htmlspecialchars(addslashes($_POST['fullname']))));
			$email=trim(htmlentities(htmlspecialchars(addslashes($_POST['email']))));
			$address=trim(htmlentities(htmlspecialchars(addslashes($_POST['address']))));
			$role=trim(htmlentities(htmlspecialchars(addslashes($_POST['role']))));

			if($role=='1') {
				$rolename="administrator";
			} else if($role=='2') {
				$rolename="users";
			}

			$q=$db->prepare("SELECT * FROM users where username = :usn OR email = :email");
			$q->bindParam(":usn",$usn);
			$q->bindParam(":email",$email);
			$q->execute();
			$count=$q->rowCount();

			if($count > 0) {
				header('location:?mod=administrator&page=users_manager&msg=error&id_msg=1');
				exit();
			} else {
				$img_type=$_FILES["photo"]['type'];
			    $allowext=array("jpeg","jpg","gif","png","jpe");
			    $allowtype = array(
		            // images
		            'png' => 'image/png',
		            'jpe' => 'image/jpeg',
		            'jpeg' => 'image/jpeg',
		            'jpg' => 'image/jpeg',
		            'gif' => 'image/gif'
			    );
			    $ex_file=end(explode(".",$_FILES["photo"]['name']));

			    if(in_array($img_type, $allowtype) && in_array($ex_file,$allowext)){
			    	$upload = true;
			    } else {
			        $upload = false;
			    }

			    if($upload) {
			         //loop the uploaded file array
			    	
			         $filen = $_FILES["photo"]['name']; //file name
			         $path = 'img/'.$filen; //generate the destination path
			         move_uploaded_file($_FILES["photo"]['tmp_name'],$path);
			    }

				$q=$db->prepare("INSERT INTO users SET username = :usn, password = :psw, fullname= :fname, email = :email, address = :address, role = :role, root_file = :rfile, photo=:photo");
				$q->bindParam(":usn",$usn);
				$q->bindParam(":psw",$psw);
				$q->bindParam(":fname",$fname);
				$q->bindParam(":email",$email);
				$q->bindParam(":address",$address);
				$q->bindParam(":role",$role);
				$q->bindParam(":rfile",$usn);
				$q->bindParam(":photo",$path);
				$q->execute();

				$the_path=ROOT_FILE.$rolename.'/';
				mkdir($the_path.$usn,0755);
				header('location:?mod=administrator&page=users_manager&msg=success&id_msg=1');
				exit();
			}
		}
	}
?>