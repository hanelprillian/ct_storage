<?php
	error_reporting(0);
	session_start();
	if(!isset($_SESSION['role'])) die ("<h1>Not Found</h1>
<p>The requested URL $_SERVER[PHP_SELF] was not found on this server.</p>");
	if($_SESSION['role']!="administrator") {
		header('location:login.php');
		exit();
	}

	$root=str_replace('..','',str_replace('/','',$_POST['root']));
	$checkboxuser=str_replace('..','',str_replace('/','',$_POST['checkboxusers']));
	$root[]=array();
	$index=0;

	if($_POST['deleteall']) {
		foreach ($checkboxuser as $checkboxusers) {

			$q=$db->prepare("SELECT * FROM users where username = :usn");
			$q->bindParam(':usn',$checkboxusers);
			$q->execute();
			$count=$q->rowCount();
			$r=$q->fetch(PDO::FETCH_ASSOC);

			if($count!=1) {
				die("Username or Id User not found!");
			}

			$index++;
			$destinations=ROOT_FILE.$root[$index].'/'.$checkboxusers;

			if(is_dir($destinations)) {
				$dir = $destinations;
				chmod($dir, 0755);
				$di = new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS);
				$ri = new RecursiveIteratorIterator($di, RecursiveIteratorIterator::CHILD_FIRST);
				foreach ( $ri as $file ) {
					$file->isDir() ?  rmdir($file) : unlink($file);
				}
				rmdir($dir);

				$q=$db->prepare("DELETE FROM users where id = :id");
				$q->bindParam(":id",$r['id']);
				$q->execute();

				$q_del_share_folder=$db->prepare("DELETE FROM user_sharing_subscriber where id_user ='$r[id]'");
				$q_del_share_folder->execute();

				// delete public links
				$q_del_pub_links=$db->prepare("DELETE FROM user_public_links where id_user ='$r[id]'");
				$q_del_pub_links->execute();

				// delete recent action
				$q_del_recent_act=$db->prepare("DELETE FROM user_recent_activity where id_user ='$r[id]'");
				$q_del_recent_act->execute();

				//delete photo 
				unlink($r['photo']);

			} else {
				$q=$db->prepare("DELETE FROM users where id = :id");
				$q->bindParam(":id",$r['id']);
				$q->execute();

				$q_del_share_folder=$db->prepare("DELETE FROM user_sharing_subscriber where id_user ='$r[id]'");
				$q_del_share_folder->execute();

				// delete public links
				$q_del_pub_links=$db->prepare("DELETE FROM user_public_links where id_user ='$r[id]'");
				$q_del_pub_links->execute();

				// delete recent action
				$q_del_recent_act=$db->prepare("DELETE FROM user_recent_activity where id_user ='$r[id]'");
				$q_del_recent_act->execute();

				//delete photo 
				unlink($r['photo']);
			}
		}
		header('location:?mod=administrator&page=users_manager&msg=success&id_msg=2');
		exit();
	} 
?>