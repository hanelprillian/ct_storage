<?php
	error_reporting(0);
	session_start();
	if(!isset($_SESSION['role'])) die ("<h1>Not Found</h1>
<p>The requested URL $_SERVER[PHP_SELF] was not found on this server.</p>");
	if($_SESSION['role']!="administrator") {
		header('location:login.php');
		exit();
	}
?>
<div class="title-dash">
	<i class="fa fa-home fa-3x left margin10right"></i><div class="title">Admin Dashboard</div>
</div>
<div style="clear:both"></div>
<div class="content-dash">
	<?php
		$q=$db->prepare("SELECT * FROM users where id = :id");
		$q->bindParam(':id',$_SESSION['user_id']);
		$q->execute();
		$r=$q->fetch(PDO::FETCH_ASSOC);

		$stat=$db->prepare("SELECT * FROM users");
		$stat->execute();
		$rstat=$stat->fetch(PDO::FETCH_ASSOC);
	?>
	<div class="box" style="width:50.01%">
		<div class="head">
			<b>Statistict</b>
		</div>
		<div class="content">
			<table width="100%" border="0" style="margin:0px auto">
			  <tr>
			    <td width="180">Users</td>
			    <td width="8">:</td>
			    <td width="190">
			    	<?php
						$stat=$db->prepare("SELECT * FROM users where role = '2'");
						$stat->execute();
						$rstat=$stat->fetch(PDO::FETCH_ASSOC);
						echo $stat->rowCount();
					?>
			    </td>
			  </tr>
			  <tr>
			    <td>Admins</td>
			    <td>:</td>
			    <td>
			    	<?php
						$stat=$db->prepare("SELECT * FROM users where role = '1'");
						$stat->execute();
						$rstat=$stat->fetch(PDO::FETCH_ASSOC);
						echo $stat->rowCount();
					?>
			    </td>
			  </tr>
			  <?php 
			    // integer starts at 0 before counting
			  function getFileCount($path) {
			    $size = 0;
			    $ignore = array('.','..','cgi-bin','.DS_Store');
			    $files = scandir($path);
			    foreach($files as $t) {
			        if(in_array($t, $ignore)) continue;
			        if (is_dir(rtrim($path, '/') . '/' . $t)) {
			            $size += getFileCount(rtrim($path, '/') . '/' . $t);
			        } else {
			            $size++;
			        }   
			    }
			    return $size;
			}
			?>
			  <tr>
			    <td>Total File Uploaded</td>
			    <td>:</td>
			    <td><?=getFileCount("./".ROOT_FILE);?></td>
			  </tr>
			</table>
		</div>
	</div>

	<div class="box" style="width:48%;margin-right:-10px;">
		<div class="head">
			<strong>Admin Information</strong>
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
			    <td width="166"><?=$r['address']?></td>
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
	<div style="clear:both"></div>
	<div id="footer">
		Copyright &copy; <?=date("Y");?> CT Upload Portal. All Right Reserved.
	</div>

</div>