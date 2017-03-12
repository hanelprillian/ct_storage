<?php
	error_reporting(0);
	session_start();
	if(!isset($_SESSION['role'])) die ("<h1>Not Found</h1>
<p>The requested URL $_SERVER[PHP_SELF] was not found on this server.</p>");
	if($_SESSION['role']!="users") {
		header('location:login.php');
		exit();
	}

	// check file public link is exist
	$q_c_f_p_l_i_e=$db->prepare("SELECT * FROM user_public_links where id_user = '$_SESSION[user_id]'");
	$q_c_f_p_l_i_e->execute();
	$c_q_c_f_p_l_i_e=$q_c_f_p_l_i_e->rowCount();

	while ($f_q_c_f_p_l_i_e=$q_c_f_p_l_i_e->fetch(PDO::FETCH_ASSOC)) { 
	  if (!file_exists($f_q_c_f_p_l_i_e['file_path'].$f_q_c_f_p_l_i_e['file_name'])) {
	    $q_d_f_s=$db->prepare("DELETE FROM user_public_links where ref_code ='$f_q_c_f_p_l_i_e[ref_code]'");
	    $q_d_f_s->execute();
	  }
	}

	$msg=addslashes($_GET['msg']);
	$id_msg=addslashes($_GET['id_msg']);
?>
<div class="title-dash">
	<i class="fa fa-link fa-3x left margin10right"></i><div class="title">Links</div>
</div>
<div style="clear:both"></div>

<script type="text/javascript">
 $(document).ready(function() {
 
  $('.alert').fadeOut(5000);
   });
</script>

<?php
if($msg=="success") {
	if($id_msg==1) {
		echo '<div class="alert alert-block alert-success fade in">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
				<p align="center">Success Created Public Link!</p>
			</div>';
	} else if($id_msg==2) {
		echo '<div class="alert alert-block alert-success fade in">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
				<p align="center">Success Remove Public Link!</p>
			</div>';
	} 
}
?>

<div class="content-dash">
	<div class="box">
		<div class="head">
			All Links
		</div>
		<div class="content">
			<table width="100%" class="table table-hover table-background table-bordered">
				<thead>
					<th width="55%">Files Name</th>
					<th width="10%" class="center">Downloaded</th>
					<th width="20%" class="center">Created at</th>
					<th width="12%" class="center">Action</th>
				</thead>
				<tbody>
					<?php
						$q=$db->prepare("SELECT * FROM user_public_links where id_user = '$_SESSION[user_id]' order by id DESC");
						$q->execute();
						$count=$q->rowCount();
						if($count == 0) {
							echo '<tr><td colspan="4" class="center">Public links is empty!</td></tr>';
						} else {
							if($_POST['remove_pub_link']) {
								$remove_pub_link=trim(htmlentities(htmlspecialchars(addslashes($_POST['remove_pub_link']))));
								
								$s_user=$db->prepare("SELECT * FROM user_public_links where ref_code = '$remove_pub_link'");
								$s_user->execute();
								$f_user=$s_user->fetch(PDO::FETCH_ASSOC);

								$q=$db->prepare("DELETE FROM user_public_links where ref_code = '$remove_pub_link'");
								$q->execute();

								$title_log='<b>'.$f_user['file_name'].'</b>';

				        $q_log=$db->prepare("INSERT INTO user_recent_activity SET id_user='$_SESSION[user_id]',date=now(), action='Delete',type='Public Link',name='$title_log'");
				        $q_log->execute();

								header('location:?mod=users&page=links&msg=success&id_msg=2');
								exit();
							}
							while ($fetch=$q->fetch(PDO::FETCH_ASSOC)) {
					?>
								<tr>
									<td><a href="links.php?files=<?=$fetch['file_name']?>&code=<?=$fetch['ref_code']?>" target="_blank"><?=$fetch['file_name']?></a></td>
									<td class="center"><?=$fetch['downloaded']?></td>
									<td class="center"><?=$fetch['date']?></td>
									<td class="center">
										<form action="" method="POST">
		          <button type="submit" name="remove_pub_link" value="<?=$fetch['ref_code']?>" class="btn btn-danger" style="font-size:9pt;padding:5px;margin:-5px 0px 0px" onclick="return confirm('are you sure want to remove this link?')">
		            <i class="fa fa-unlink fa-fw"></i>
		            Remove Link
		          </button>
		        </form>
		       </td>
								</tr>
					<?php
							}
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>


<div style="clear:both"></div>
<div id="footer">
		Copyright &copy; <?php echo date("Y")?> CT Upload Portal. All Right Reserved.
</div>
