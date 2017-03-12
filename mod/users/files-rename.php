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
		$oldname=$_POST['oldnamefile'];
		$oldnamefile_name=$_POST['oldnamefile_name'];
		$ext=$_POST['extension'];
		$path=$_POST['path'];

		$name=trim(strip_tags(addslashes(str_replace('..', '',str_replace('/', '',$_POST['namefile'])))));
		
		if ($name=="") {
			header('location:'.$_POST['weburl'].'');
			exit();
		}
		
		$newname=$path.$name.$ext;

		$oldname_name=$oldnamefile_name.$ext;
		$newname_name=$name.$ext;

		$pub_links_table=$db->prepare("SELECT * FROM user_public_links where id_user = '$_SESSION[user_id]' and file_path = '$path' and file_name='$oldname_name'");
		$pub_links_table->execute();
		$fetch=$pub_links_table->fetch(PDO::FETCH_ASSOC);
		$count=$pub_links_table->rowcount();

		if ($count > 0) {
			$rename_pub_links=TRUE;
		} else {
			$rename_pub_links=FALSE;
		}

	  $title_log="<b>$oldname_name</b> to <b>$newname_name</b>";

	  rename ($oldname,$newname);

	  if ($rename_pub_links) {
			//rename action
			$q_rename_pub_links=$db->prepare("UPDATE user_public_links SET file_name='$newname_name' where id_user = '$_SESSION[user_id]' and file_path = '$path'");
			$q_rename_pub_links->execute();
		}

	  $q_log=$db->prepare("INSERT INTO user_recent_activity SET id_user='$_SESSION[user_id]',date=now(), action='Rename',type='File',name='$title_log'");
	  $q_log->execute();
		
		header('location:'.$_POST['weburl'].'');
		exit();
	} 

	if(!isset($_POST['renamefile'])) die();
?>
<script type="text/javascript">
$(document).ready(function () {
    $('input').keyup(function() {
        var $th = $(this);
        $th.val( $th.val().replace(/[^a-zA-Z0-9_ ]/g, function(str) { alert('Input Invalid'); return ''; } ) );
    });
});
</script>
<table width="100%" class="table table-hover table-background table-bordered">
	<form action="?mod=users&page=files&act=rename" method="POST" role="form" name="formrename">
		<input type="hidden" name="weburl" value="<?=$_POST['websiteurl']?>"/>
	<tbody>
		<?php
			$filefullpath=$_POST['filepath'];
			$filefullpath_name=str_replace(ROOT_FILE_STORAGE, "", $filefullpath);
			list($name,$ext)=explode(".", $_POST['renamefile']);
			$oldname=$filefullpath.$_POST['renamefile'];
		?>
			<tr>
			<td colspan="2"><strong>Rename File</strong></td>
			</tr>
			<tr>
				<td width="20%"><label for="name">Name</label></td>
				<td width="80%">
					<div class="input-group">
						<input type="hidden" name="oldnamefile" value="<?=$oldname?>"/>
						<input type="hidden" name="oldnamefile_name" value="<?=$name?>"/>
							<input type="text" name="namefile" class="form-control" id="name" value="<?=$name?>"/><span class="input-group-addon">.<?=$ext?></span>
							<input type="hidden" name="extension" value=".<?=$ext?>"/>
					</div>
				</td>
			</tr>
			<tr>
				<td width="20%"><label for="name">Path</label></td>
				<td width="80%">
					<div class="input-group" style="width:100%">
							<input type="text" class="form-control" style="color:red" value="<?=$filefullpath_name?>" readonly/>	
							<input type="hidden" name="path" class="form-control" style="color:red" value="<?=$filefullpath?>" readonly/>					
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
