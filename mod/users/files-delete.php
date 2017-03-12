<?php
	error_reporting(0);
	session_start();
	if(!isset($_SESSION['role'])) die ("<h1>Not Found</h1>
<p>The requested URL $_SERVER[PHP_SELF] was not found on this server.</p>");
	if($_SESSION['role']!="users") {
		header('location:login.php');
		exit();
	}
	
if($_SERVER['REQUEST_METHOD']=="POST") {
	foreach ($_POST['checkfile'] as $file_atau_folder) {
    if(is_dir($file_atau_folder)) {
    	$dir = $file_atau_folder;
    	$folder_share_path=str_replace(STORAGE_DIR.'/', "", $dir);

			$share_table=$db->prepare("SELECT * FROM user_sharing_subscriber where id_user = '$_SESSION[user_id]' and folder_sharing = '$folder_share_path'");
			$share_table->execute();
			$fetch=$share_table->fetch(PDO::FETCH_ASSOC);
			$count=$share_table->rowcount();

			if ($count > 0) {
				$delete_share_folder=TRUE;
			} else {
				$delete_share_folder=FALSE;
			}

			chmod($dir, 0755);
			$di = new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS);
			$ri = new RecursiveIteratorIterator($di, RecursiveIteratorIterator::CHILD_FIRST);

			foreach ( $ri as $file ) {
			    $file->isDir() ?  rmdir($file) : unlink($file);
			}

			$dir_name=rtrim($dir,"/");
			$dir_name=str_replace(STORAGE_DIR.'/', "", $dir_name);
			$dir_name=end(explode("/", $dir_name));

			$dir_root=str_replace($dir_name.'/', "", $dir);
			$dir_root=str_replace(STORAGE_DIR, ' <i class="fa fa-home"></i>(Home) ', $dir_root);

			$title_log="<b>$dir_name</b> from <b>$dir_root</b>";

			rmdir($dir);

			if ($delete_share_folder) {
				//delete action
				$q_del_share=$db->prepare("DELETE FROM user_sharing_subscriber where id_user = '$_SESSION[user_id]' and folder_sharing = '$folder_share_path'");
				$q_del_share->execute();

				$q_log=$db->prepare("INSERT INTO user_recent_activity SET id_user='$_SESSION[user_id]',date=now(), action='Delete',type='Folder',name='$title_log'");
				$q_log->execute();
			}

			$q_log=$db->prepare("INSERT INTO user_recent_activity SET id_user='$_SESSION[user_id]',date=now(), action='Delete',type='Folder',name='$title_log'");
			$q_log->execute();

		} else  {

			$file=$file_atau_folder;
			$file_name=end(explode("/", $file));
			$file_root=str_replace($file_name, "", $file);
			$file_root=str_replace(STORAGE_DIR, ' <i class="fa fa-home"></i>(Home) ', $file_root);

	  		$title_log="<b>$file_name</b> from <b>$file_root</b>";
			unlink($file);
			$q_log=$db->prepare("INSERT INTO user_recent_activity SET id_user='$_SESSION[user_id]',date=now(), action='Delete',type='File',name='$title_log'");
			$q_log->execute();
		} 
	}
} else {
	echo "not found";
}
?>