<?php
	error_reporting(0);
	session_start();
	if(!isset($_SESSION['role'])) die ("<h1>Not Found</h1>
<p>The requested URL $_SERVER[PHP_SELF] was not found on this server.</p>");
	if($_SESSION['role']!="users") {
		header('location:login.php');
		exit();
	}
?>
<div class="title-dash">
	<i class="fa fa-home fa-3x left margin10right"></i><div class="title">User Dashboard</div>
</div>
<div style="clear:both"></div>
<div class="content-dash">
<?php
	$q=$db->prepare("SELECT * FROM users where id = :id");
	$q->bindParam(':id',$_SESSION['user_id']);
	$q->execute();
	$r=$q->fetch(PDO::FETCH_ASSOC);
?>


	<?php
		$stat=$db->prepare("SELECT * FROM users");
		$stat->execute();
		$rstat=$stat->fetch(PDO::FETCH_ASSOC);
	?>
	<div class="box" style="width:50.01%;height:300px">
		<div class="head">
			<i class="fa fa-link fa-fw margin10right"></i><strong>Recent Public Link</strong>
		</div>
		<div class="content" style="height:195px">
			<table width="100%" class="table table-hover">
					<?php
						$q=$db->prepare("SELECT * FROM user_public_links where id_user = '$_SESSION[user_id]' order by id DESC LIMIT 4");
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
								$filename=$fetch['file_name'];
								if(strlen($filename)>20) {
				          $filename=substr($filename, 0, 30).'....';
				        }
					?>
			<tr>
				<td><a href="links.php?files=<?=$fetch['file_name']?>&code=<?=$fetch['ref_code']?>" target="_blank"><?=$filename?></a></td>
				<td class="center">
					<form action="" method="POST">
			          <button type="submit" name="remove_pub_link" value="<?=$fetch['ref_code']?>" class="btn btn-danger tooltip1" title="Remove Public Link" style="font-size:9pt;padding:5px;margin:-5px 0px 0px" onclick="return confirm('are you sure want to remove this link?')">
			            <i class="fa fa-unlink fa-fw"></i>
			          </button>
		       		</form>
		       </td>
			</tr>
					<?php
							}
					}
					?>
			</table>
		</div>
		<div class="center"><a href="index.php?mod=users&page=links">More...</a></div>
	</div>

	<div class="box" style="width:48%;margin-right:-10px;height:300px">
		<div class="head">
			<i class="fa fa-user fa-fw margin10right"></i><strong>Your Account Information</strong>
		</div>
		<div class="content">
			<table width="100%" border="0">
			  <tr>
			    <td width="170">Username</td>
			    <td width="8">:</td>
			    <td width="166"><?=$r['username']?></td>
			  </tr>
			  <tr>
			   <td width="170">Email</td>
			    <td width="8">:</td>
			    <td width="166"><?=$r['email']?></td>
			  </tr>
			  <tr>
			    <td width="170">Fullname</td>
			    <td width="8">:</td>
			    <td width="166"><?=$r['fullname']?></td>
			  </tr>
			  <tr>
			    <td width="170">Address</td>
			    <td width="8">:</td>
			    <td width="166">
			    	<?php
			    		$address=$r['address'];
			    		if(strlen($address)>20) {
				        $address=substr($address, 0, 20).'....';
				      }
				      echo $address;
			    	?>
			    </td>
			  </tr>
			  <tr>
			    <td width="170">Photo</td>
			    <td width="8">:</td>
			    <td width="166">
			    	<?php
			    		if($r['photo']==null) {
			    			$linkphoto="img/user.png";
			    		} else {
			    			$linkphoto=$r['photo'];
			    		}
			    	?>
			    	<img src="<?=$linkphoto;?>" width="100">

			    </td>
			  </tr>
			</table>
		</div>
	</div>	

	<div class="box" style="height:370px">
		<div class="head">
			<i class="fa fa-globe fa-fw margin10right"></i><strong>Recent Activity</strong>
		</div>
		<div class="contentscroll" style="height:300px">
			<table width="100%" class="table table-hover">
			<tbody style="font-size:11pt">
				<?php
					$r_a=$db->prepare("SELECT * FROM user_recent_activity where id_user = '$_SESSION[user_id]' ORDER BY date desc LIMIT 6");
					$r_a->execute();
					$r_a_count=$r_a->rowCount();

					if ($r_a_count > 0) {
						while($r_a_f=$r_a->fetch(PDO::FETCH_ASSOC)) {
				?>
						<tr>
							<td width="25%"><?=$r_a_f['date']?></td>
							<td width="10%"><?=$r_a_f['action']?></td>
							<td width="15%"><?=$r_a_f['type']?></td>
							<td width="50%"><?=$r_a_f['name']?></td>
						</tr>
				<?php
						}
					} else {
				?>
						<tr>
							<td class="center" colspan="4">Recent Activity is Empty!</td>
						</tr>
				<?php
					}
				?>
			</tbody>
			</table>
		</div>
	</div>

	<div style="clear:both"></div>
	<div id="footer">
		Copyright &copy; <?=date("Y");?> CT Upload Portal. All Right Reserved.
	</div>

</div>