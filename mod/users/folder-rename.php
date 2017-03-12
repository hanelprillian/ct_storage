<?php
	error_reporting(0);
	session_start();
	if(!isset($_SESSION['role'])) die ("<h1>Not Found</h1>
<p>The requested URL $_SERVER[PHP_SELF] was not found on this server.</p>");
	if($_SESSION['role']!="users") {
		header('location:login.php');
		exit();
	}

	if($_POST['update']) {

		$oldname=$_POST['oldnamefolder'];
		$separator=$_POST['separator'];
		$path=$_POST['path'];

		$folder_share_path=str_replace(STORAGE_DIR.'/', "", $oldname);

		$share_table=$db->prepare("SELECT * FROM user_sharing_subscriber where id_user = '$_SESSION[user_id]' and folder_sharing = '$folder_share_path'");
		$share_table->execute();
		$fetch=$share_table->fetch(PDO::FETCH_ASSOC);
		$count=$share_table->rowcount();

		if ($count > 0) {
			$rename_share_folder=TRUE;
		} else {
			$rename_share_folder=FALSE;
		}

		$name=strip_tags(trim(addslashes(str_replace('..', '',str_replace('/', '',$_POST['namefolder'])))));

		if ($name=="") {
			header('location:'.$_POST['weburl'].'');
			exit();
		}
		$newname=$path.$name.$separator;

		$oldname_name=str_replace(STORAGE_DIR.'/', "", $oldname);
		$newname_name=$name;

		$title_log="<b>$oldname_name</b> to <b>$newname_name/</b>";

		$folder_sharing=str_replace(STORAGE_DIR.'/',"", $newname);

		rename($oldname,$newname);

		if ($rename_share_folder) {
			//rename action
			$q_rename_share=$db->prepare("UPDATE user_sharing_subscriber SET folder_sharing = '$folder_sharing', folder_name='$newname_name' where id_user = '$_SESSION[user_id]' and folder_sharing = '$folder_share_path'");
			$q_rename_share->execute();
		}


  		$q_log=$db->prepare("INSERT INTO user_recent_activity SET id_user='$_SESSION[user_id]',date=now(), action='Rename',type='Folder',name='$title_log'");
  		$q_log->execute();
  	
		header('location:'.$_POST['weburl'].'');
		exit();
	} 

	if(!isset($_POST['renamefolder'])) die();
?>
<script type="text/javascript">
$(document).ready(function () {
    $('input').keyup(function() {
        var $th = $(this);
        $th.val( $th.val().replace(/[^a-zA-Z0-9_ ]/g, function(str) { alert('Input Invalid'); return ''; } ) );
    });
});
</script>

<div class="alert alert-block alert-info fade in">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
	<p align="center">
		<strong>If you rename this folder, the shared folder or public linked file will be remove automatic!</strong>
	</p>
</div>

<table width="100%" class="table table-hover table-background table-bordered">
	<form action="?mod=users&page=folder&act=rename" method="POST" role="form" name="formrename">
		<input type="hidden" name="weburl" value="<?=$_POST['websiteurl']?>"/>
	<tbody>
		<?php
			$folderfullpath=$_POST['folderpath'];
			$folderfullpath_name=str_replace(ROOT_FILE_STORAGE, "", $folderfullpath);
			list($name,$separator)=explode("/", $_POST['renamefolder']);
			$oldname=$folderfullpath.$_POST['renamefolder'];
		?>
			<tr>
			<td colspan="2"><strong>Rename Folder</strong></td>
			</tr>
			<tr>
				<td width="20%"><label for="name">Name</label></td>
				<td width="80%">
					<div class="input-group">
						<input type="hidden" name="oldnamefolder" value="<?=$oldname?>"/>
							<input type="text" name="namefolder" class="form-control" id="name" value="<?=$name?>"/><span class="input-group-addon">/</span>
							<input type="hidden" name="separator" value="/"/>
					</div>
				</td>
			</tr>
			<tr>
				<td width="20%"><label for="name">Path</label></td>
				<td width="80%">
					<div class="input-group" style="width:100%">
							<input type="text" class="form-control" style="color:red" value="<?=$folderfullpath_name?>" readonly/>	
							<input type="hidden" name="path" class="form-control" style="color:red" value="<?=$folderfullpath?>" readonly/>					
					</div>
				</td>
			</tr>
		<tr>
			<td colspan="2" width="80%">
				<input type="submit" name="update" class="btn btn-primary" style="width:100%" value="Update"/>
			</td>
		</tr>
	</tbody>
	</form>
</table>
