<?php
	//error_reporting(0);
	session_start();
	if(!isset($_SESSION['role'])) die ("<h1>Not Found</h1>
<p>The requested URL $_SERVER[PHP_SELF] was not found on this server.</p>");
	if($_SESSION['role']!="users") {
		header('location:login.php');
		exit();
	}  
?>
<div class="title-dash">
	<i class="fa fa-file fa-3x left margin10right"></i><div class="title">Files</div>
</div>
<div style="clear:both"></div>
<?php
	$msg=addslashes($_GET['msg']);
	$id_msg=addslashes($_GET['id_msg']);

	if($msg=="error") {
		if ($id_msg==5) {
			echo '<div class="alert alert-block alert-danger fade in">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
					<p align="center"> Copy failed! Space not enough!</p>
				</div>';
		} else if ($id_msg==6) {
			echo '<div class="alert alert-block alert-danger fade in">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
					<p align="center"> Upload failed! Space not enough!</p>
				</div>';
		} 
	} else if ($msg=="success") {
		if($id_msg==2) {
			echo '<div class="alert alert-block alert-success fade in">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
					<p align="center">Delete success!</p>
				</div>';
		}
	}
?>
<div style="clear:both"></div>

<div class="content-dash">
	<div class="box">
		<div class="content">
			<?php
				if($_POST['delete']) {
					include 'files-delete.php';
					header('location:?mod=users&page=files&msg=success&id_msg=2');
					exit();
				} else if($_POST['deletefile']){

					$file=$_POST['deletefile'];
					$file_only_path=$_POST['filepath'];
					$file_name=str_replace($file_only_path, "", $file);

					$user_public_links_table=$db->prepare("SELECT * FROM user_public_links where id_user = '$_SESSION[user_id]' and file_path = '$file_only_path' and file_name='$file_name'");
					$user_public_links_table->execute();
					$fetch=$user_public_links_table->fetch(PDO::FETCH_ASSOC);
					$count=$user_public_links_table->rowcount();

					if ($count > 0) {
						$delete_user_public_links=TRUE;
					} else {
						$delete_user_public_links=FALSE;
					}

					$file_name=end(explode("/", $file));
					$file_root=str_replace($file_name, "", $file);
					$file_root=str_replace(STORAGE_DIR, ' <i class="fa fa-home"></i>(Home) ', $file_root);

			  		$title_log="<b>$file_name</b> from <b>$file_root</b>";

					unlink($file);

					if ($delete_user_public_links) {
						//delete action
						$q_delete_user_public_links=$db->prepare("DELETE FROM user_public_links where ref_code='$fetch[ref_code]'");
  						$q_delete_user_public_links->execute();
					}

					$q_log=$db->prepare("INSERT INTO user_recent_activity SET id_user='$_SESSION[user_id]',date=now(), action='Delete',type='File',name='$title_log'");
				  	$q_log->execute();

				  	if ($_POST['type_access']=="share") {
				  		header('location:?mod=users&page=sharing&user='.$_POST['root_user_share'].'&folders='.$_POST['root_folders_share'].'');
						exit();
				  	}

					header('location:?mod=users&page=files&dir='.$leadon.'');
					exit();

					} else if($_POST['deletefolder']) {

						$dir=$_POST['deletefolder'];

						delete_folder($dir);

						header('location:?mod=users&page=files&dir='.$leadon.'');
						exit();

					} else if($_POST['renamefile']) {
						include 'files-rename.php';
					} else if($_POST['renamefolder']) {
						include 'folder-rename.php';
					} else if($_POST['copyfile']) {
						include 'files-copy.php';
					} else if($_POST['copyfolder']) {
						include 'folder-copy.php';
					} else if($_POST['create_pub_links']) { 

						$create_pub_links=trim(htmlentities(htmlspecialchars(addslashes($_POST['create_pub_links']))));
						$create_pub_links_filepath=trim(htmlentities(htmlspecialchars(addslashes($_POST['filepath']))));
						$create_pub_links_rand_ref_code=main::md5_rand(10);

						$c_p_l_q=$db->prepare("INSERT INTO user_public_links SET id_user = '$_SESSION[user_id]', ref_code = '$create_pub_links_rand_ref_code',file_name='$create_pub_links',file_path='$create_pub_links_filepath',user_path='$_SESSION[username]',downloaded='0',date=now()");
						$c_p_l_q->execute();

						$title_log="<b>$create_pub_links</b>";

        		$q_log=$db->prepare("INSERT INTO user_recent_activity SET id_user='$_SESSION[user_id]',date=now(), action='Create',type='Public Link',name='$title_log'");
        		$q_log->execute();

						header('location:?mod=users&page=links&msg=success&id_msg=1');
						exit();
					} else {
						include 'files-core.php';
					}
			?>
		</div>
	</div>	
	<div style="clear:both"></div>
	<div id="footer">
		Copyright &copy; <?php echo date("Y")?> CT Upload Portal. All Right Reserved.
	</div>
</div>