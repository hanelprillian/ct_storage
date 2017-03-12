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
	<i class="fa fa-cogs fa-3x left margin10right"></i><div class="title">Settings</div>
</div>
<div style="clear:both"></div>
<script type="text/javascript">
 $(document).ready(function() {
  $('.alert').fadeOut(5000);
   });
</script>
<?php
	$msg=addslashes($_GET['msg']);
	$id_msg=addslashes($_GET['id_msg']);

	if($msg=="error") {
		if($id_msg==1) {
			echo '<div class="alert alert-block alert-danger fade in">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
					<p align="center">Username sudah ada!</p>
				</div>';
		} else if($id_msg==2) {
			echo '<div class="alert alert-block alert-danger fade in">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
					<p align="center">Space per user is empty!</p>
				</div>';
		}
	} else if($msg=="success") {
		if($id_msg==1) {
			echo '<div class="alert alert-block alert-success fade in">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
					<p align="center">Success Active the extensions!</p>
				</div>';
		} else if($id_msg==2) {
			echo '<div class="alert alert-block alert-success fade in">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
					<p align="center">Success Inactive the extensions!</p>
				</div>';
		} else if($id_msg==3) {
			echo '<div class="alert alert-block alert-success fade in">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
					<p align="center">Success Edit Space for user!</p>
				</div>';
		} 
	}
?>
<div class="content-dash">
<?php
	if($_POST['active_ext_set']) {
		$id_cheked=$_POST['checkbox'];
		foreach ($_POST['checkbox'] as $id) {
			$stat=1;
			$q=$db->prepare("UPDATE admin_settings_extensions SET status = :stat WHERE id =:id");
			$q->bindparam(":id",$id);
			$q->bindparam(":stat",$stat);
			$q->execute();
		}
		header('location:?mod=administrator&page=settings&msg=success&id_msg=1');
		exit();
	} else if($_POST['inactive_ext_set']) {
		$id_cheked=$_POST['checkbox'];
		foreach ($_POST['checkbox'] as $id) {
			$stat=0;
			$q=$db->prepare("UPDATE admin_settings_extensions SET status = :stat WHERE id =:id");
			$q->bindparam(":id",$id);
			$q->bindparam(":stat",$stat);
			$q->execute();
		}
		header('location:?mod=administrator&page=settings&msg=success&id_msg=2');
		exit();
	}
?>
	<div class="box">
		<div class="head">
			Extensions Settings
		</div>
		<div class="content">
			<script type="text/javascript">
				function check_all(val) {
				    var checkbox = document.checkboxlistusers.elements['checkbox[]'];
				    if ( checkbox.length > 0 ) {
				        for (i = 0; i < checkbox.length; i++) {
				            if ( val.checked ) {
				                checkbox[i].checked = true;
				            }
				            else {
				                checkbox[i].checked = false;
				            }
				        }
				    }
				    else {
				        if ( val.checked ) {
				            checkbox.checked = true;
				        }
				        else {
				            checkbox.checked = false;
				        }
				    }
				}

			</script>

			<table width="100%" class="table table-hover table-background table-bordered">
				<form action="" method="post" name="checkboxlistusers" id="checkbox">
					<style type="text/css">
						.skat {
							width: 90px;
							float: left;
						}
						.listext {
							margin-left: 20px;
						}
					</style>
					<tbody class="">
						<tr>
							<td width="20%">Extensions <span style="color:green">Active</span></td>
							<td width="80%">
								<?php
									$q=$db->prepare("SELECT * FROM admin_settings_extensions where status = 1");
									$q->execute();
									$r=$q->rowCount();
									if($r==0) {
										echo "-";
									} else {

								?>
								<div class="input-group">
									<ul class="listext">
									<?php
										while ($row=$q->fetch(PDO::FETCH_ASSOC)) {
									?>
									<div class="skat">
										<li>.<?=$row['ext_name']?>
										</li>
									</div>
									<?php
										}
									?>
									</ul>
						        </div>
						        <?php
						        	}
						        ?>
							</td>
						</tr>
						<tr>
							<td width="20%">Extensions <span style="color:red">Inactive</span></td>
							<td width="80%">
								<?php
									$q=$db->prepare("SELECT * FROM admin_settings_extensions where status = 0");
									$q->execute();
									$r=$q->rowCount();
									if($r==0) {
										echo "-";
									} else {
								?>
								<div class="input-group">
									<ul class="listext">
									<?php
										while ($row=$q->fetch(PDO::FETCH_ASSOC)) {
									?>
									<div class="skat">
										<li>.<?=$row['ext_name']?>
										</li>
									</div>
									<?php
										}
									?>
									</ul>
						        </div>
						        <?php
						        	}
						        ?>
							</td>
						</tr>
						<tr>
							<td width="20%">List All Extensions</span></td>
							<td width="80%">
								<div class="input-group">
									<?php
										$q=$db->prepare("SELECT * FROM admin_settings_extensions");
										$q->execute();

										while ($row=$q->fetch(PDO::FETCH_ASSOC)) {
											if($row['status']==1) {
												$action="checked";
											} else {
												$action="";
											}
									?>
									<div class="skat">
										<input type="checkbox" name="checkbox[]" value="<?=$row['id']?>"/>&nbsp; .<?=$row['ext_name']?>
									</div>
									<?php
										}
									?>
						        </div>
							</td>
						</tr>
						<tr>
							<td>Select All</td>
							<td><input type="checkbox" onclick="check_all(this)"></td>
						</tr>
						<tr>
							<td colspan="2">
								<span>Checked Action</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="submit" name="active_ext_set" value="Active" class="btn btn-success"/>&nbsp;&nbsp;&nbsp;
								<input type="submit" name="inactive_ext_set" value="Inactive" class="btn btn-danger"/>
							</td>
						</tr>
					</tbody>
				</form>
			</table>
		</div>
	</div>

	<div class="box">
		<div class="head">Bandwith and Space</div>
		<div class="content">
			<table width="100%" class="table table-hover table-background table-bordered">
				<script type="text/javascript">
				$(document).ready(function () {
				    $('input[name=space_per_user]').keyup(function() {
				        var $th = $(this);
				        $th.val( $th.val().replace(/[^0-9]/g, function(str) { alert('Input Must Numeric'); return ''; } ) );
				    });
				});
				</script>
				<?php
					$q=$db->prepare("SELECT * FROM admin_settings_users_bandwith");
					$q->execute();
					$f_q=$q->fetch(PDO::FETCH_ASSOC);

					$save_space_per_user=trim(htmlentities(htmlspecialchars(addslashes($_POST['save_space_per_user']))));
					$space_per_user=trim(htmlentities(htmlspecialchars(addslashes($_POST['space_per_user']))));
					$size_by=trim(htmlentities(htmlspecialchars(addslashes($_POST['size_by']))));

					if($save_space_per_user) {
						if($space_per_user=="") {
							header('location:?mod=administrator&page=settings&msg=error&id_msg=2');
							exit();
						}
						if (is_numeric($space_per_user)) {
							$q=$db->prepare("UPDATE admin_settings_users_bandwith SET space_for_users='$space_per_user', size_by = '$size_by' WHERE id = '1'");
							$q->execute();
							header('location:?mod=administrator&page=settings&msg=success&id_msg=3');
							exit();
						} else {
							echo "is not numeric";
						}
					}

				?>
				<form action="" method="post">
					<tbody>
						<tr>
							<td width="20%">Space per User</td>
							<td width="80%">
								<input type="text" name="space_per_user" class="form-control" value="<?=$f_q['space_for_users']?>" style="width:40%;float:left"/>
								<?php
									if($f_q['size_by']=="MB") {
										echo '<select name="size_by" style="width:10%;height:40px;">
										<option value="KB">KB</option>
									<option value="MB" selected="selected">MB</option>
									<option value="GB">GB</option>
								</select>';
									} else if($f_q['size_by']=="GB"){
										echo '<select name="size_by" style="width:10%;height:40px;">
										<option value="KB">KB</option>
									<option value="MB">MB</option>
									<option value="GB" selected="selected">GB</option>
								</select>';
									} else if($f_q['size_by']=="KB"){
										echo '<select name="size_by" style="width:10%;height:40px;">
										<option value="KB" selected="selected">KB</option>
									<option value="MB">MB</option>
									<option value="GB">GB</option>
								</select>';
									}
								?>
							</td>
						</tr>
						<tr>
							<td></td>
							<td><input type="submit" value="Save As" name="save_space_per_user" class="btn btn-primary"></td>
						</tr>
					</tbody>
				</form>
			</table>
		</div>
	</div>

	<div style="clear:both"></div>

	<div id="footer">
		Copyright &copy; <?php echo date("Y")?> CT Upload Portal. All Right Reserved.
	</div>

</div>