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
		$namefolder=$_POST['namefolder'];
		$oldpath=$_POST['oldpath'];
		$newpath=$_POST['newpath'];
		if($newpath==STORAGE_DIR.'') {
			$linkredirect=str_replace(STORAGE_DIR.'', "", $newpath);
		} else {
			$linkredirect=str_replace(STORAGE_DIR.'/', "", $newpath);
		}

		$source =$oldpath.'/'.$namefolder;
		$dest=$newpath.'/'.$namefolder;

		$d = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($source), 
    RecursiveIteratorIterator::SELF_FIRST
	  );

	  foreach($d as $file){
	   $total_space_used_source += $file->getSize();
	  }

	  $totalall=$total_space_used_in_bytes+$total_space_used_source;

	  if($totalall >= $max_space_per_user_in_bytes) {
	  	header('location:?mod=users&page=files&msg=error&id_msg=5');
				exit();
	  }

  	$newpath_name=str_replace(STORAGE_DIR, ' <i class="fa fa-home"></i>(Home) ', $newpath);

	$title_log="<b>$namefolder</b> to <b>$newpath_name/</b>";

	$q_log=$db->prepare("INSERT INTO user_recent_activity SET id_user='$_SESSION[user_id]',date=now(), action='Copy',type='Folder',name='$title_log'");
	$q_log->execute();
		function recurse_copy($src,$dst) { 
		    $dir = opendir($src); 
		    @mkdir($dst); 
		    while(false !== ( $file = readdir($dir)) ) { 
		        if (( $file != '.' ) && ( $file != '..' )) { 
		            if ( is_dir($src . '/' . $file) ) { 
		                recurse_copy($src . '/' . $file,$dst . '/' . $file); 
		            } 
		            else { 
		                copy($src . '/' . $file,$dst . '/' . $file); 
		            } 
		        } 
		    } 
		    closedir($dir); 
		} 

		recurse_copy($source,$dest);
		header('location:'.$_POST['weburl'].'');
		exit();
	}
	if(!isset($_POST['copyfolder'])) die();
?>
<table width="100%" class="table table-hover table-background table-bordered">
	<form action="?mod=users&page=folder&act=copy" method="POST" role="form" name="formrename">
		<input type="hidden" name="weburl" value="<?=$_POST['websiteurl']?>"/>
	<tbody>
		<?php
			$folderoldpath=rtrim($_POST['folderpath'],"/");
			$folderoldpath_name=str_replace(ROOT_FILE_STORAGE, "", $folderoldpath);
			$namefolder=$_POST['copyfolder'];
		?>
			<tr>
			<td colspan="2"><strong>Copy Folder</strong></td>
			</tr>
			<tr>
				<td width="20%"><label for="name">Folder Name</label></td>
				<td width="80%">
					<div class="input-group" style="width:100%">
							<input type="text" name="namefolder" style="color:black;font-weight:bold" class="form-control" id="name" value="<?=$namefolder?>" readonly/>					
					</div>
				</td>
			</tr>

			<tr>	
				<td width="20%"><label for="name">Old Path</label></td>
				<td width="80%">
					<div class="input-group" style="width:100%">
							<input type="text" class="form-control" style="color:red;font-weight:bold" value="<?=$folderoldpath_name?>" readonly/>		
							<input type="hidden" name="oldpath" value="<?=$folderoldpath?>">			
					</div>
				</td>
			</tr>
			<tr>
				<td width="20%"><label for="name">New Path</label></td>
				<td width="80%">

					<div class="input-group" style="width:100%">
					<?php
						$root = STORAGE_DIR;
						if ($_POST['type_access']=="share") {
					  		$root = $startdir;
					  	}

						$iter = new RecursiveIteratorIterator(
						    new RecursiveDirectoryIterator($root, RecursiveDirectoryIterator::SKIP_DOTS),
						    RecursiveIteratorIterator::SELF_FIRST,
						    RecursiveIteratorIterator::CATCH_GET_CHILD // Ignore "Permission denied"
						);

						$paths = array($root);
						foreach ($iter as $path => $dir) {
						    if ($dir->isDir()) {
						        $paths[] = $path;
						    }
						}
						$b=count($paths);
						echo "<select class='form-control' style='width:100%;padding:0px;' name='newpath'>";
						for ($i=0; $i<$b ; $i++) { 
						    $paths[$i]=str_replace("\\", "/", $paths[$i]);
						    $paths[$i]=rtrim($paths[$i],"/");
						    $path2=str_replace(ROOT_FILE_STORAGE,"", $paths[$i]);
						    $path3=str_replace("/", " / ", $path2);
						    echo "<option class='' value='$paths[$i]'>$path3</option>";
						}
						echo "</select>";
						?>				
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
