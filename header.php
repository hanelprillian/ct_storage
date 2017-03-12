<?php
if(!isset($_SESSION['role'])) {
	die("
<html><head>
<title>404 Not Found</title>
</head><body>
<h1>Not Found</h1>
<p>The requested URL was not found on this server.</p>
</body></html>
");
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Dashboard | CT</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="assets/css/style.css"/>
		<link rel="stylesheet" type="text/css" href="assets/css/font.css"/>
	 	<!-- Loading Bootstrap -->
  	<link href="assets/css/bootstrap.css" rel="stylesheet" type="text/css">
  	<link href="assets/css/prettify.css" rel="stylesheet" type="text/css">

  	<!-- Loading Flat UI -->
    		
  	<link href="assets/css/font-awesome.min.css" rel="stylesheet" media="screen">
  	<script src="assets/js/jquery-1.10.1.min.js"></script>
  	<script src="assets/js/bootstrap.min.js"></script>

  	<link rel="stylesheet" href="assets/css/jquery-ui-1.10.0.custom.css"type="text/css" media="all"/>

  	<!-- form confirm -->
  	<script type="text/javascript">
	$(document).ready(function() {
	$('.confirmation').click(function() {
	    
	            //Getting the variable's value from a link 
	    var confirmbox = $(this).attr('name');

	    //Fade in the Popup
	    $(confirmbox).fadeIn(100);
	    
	    //Set the center alignment padding + border see css style
	    var popMargTop = ($(confirmbox).height() + 24) / 2; 
	    var popMargLeft = ($(confirmbox).width() + 24) / 2; 
	    
	    $(confirmbox).css({ 
	        'margin-top' : -popMargTop,
	        'margin-left' : -popMargLeft
	    });
	    
	    // Add the mask to body
	    $('body').append('<div id="mask"></div>');
	    $('#mask').fadeIn(200);
	    
	    return false;
	});

	  $('.close, #mask,.c').click(function() { 
	    $('#mask , .confirmation-popup').fadeOut(300 , function() {
	      $('#mask').remove();  
	  	}); 
	  	return true;
	  });

	  $('.d').click(function(){
	  	$('.loading').show();
	  	return true;
	  });
	  
	});
	</script>

	<script type="text/javascript">
  	$(function(){
	    jQuery.fn.center = function ()
	    {
        
      var popMargTop = ($(this).height() + 24) / 2; 
			var popMargLeft = ($(this).width() + 24) / 2; 
			    
			    $(this).css({ 
			        'margin-top' : -popMargTop,
			        'margin-left' : -popMargLeft
			    });
	        return this;
	    }
   
			$('.loading').center();
	    $(window).resize(function(){
	       $('.loading').center();
	    });
		});
  </script>
  <!-- form confirm -->

  <script type="text/javascript">
		function showhide() {
			$("#notife").toggle();
		}
		function close_notife() {
			$("#notife").hide();
		}
	</script>


  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
    <script src="assets/js/html5shiv.js"></script>
    <script src="assets/js/respond.min.js"></script>
  <![endif]-->

</head> 
<body class="bg_dash">
	<div id="menuatas">
		<div class="logo"><img src="img/2itc.png">Cargando Team</div>
		<ul>
			<?php
				if($_SESSION['role']=="administrator") {
			?>
				<?php
				$s_user_profile=$db->prepare("SELECT * FROM users where id = '$_SESSION[user_id]'");
				$s_user_profile->execute();
				$f_user_profile=$s_user_profile->fetch(PDO::FETCH_ASSOC);
				?>
				<li><a href="?mod=administrator&page=profile"><i class="fa fa-user fa-fw margin10right"></i><?=$f_user_profile['fullname']?></a></li>
				<li><a href="logout.php"><i class="fa fa-power-off fa-fw margin10right"></i>Logout</a></li>
			<?php
				} else if($_SESSION['role']=="users") {
			?>

				<div class="capacity_files_users">
					<?php
						$total_space_used = 0;
				    $d = new RecursiveIteratorIterator(
				      	new RecursiveDirectoryIterator(ROOT_FILE_STORAGE.'/'.USER_FILE_ROOT), 
				      	RecursiveIteratorIterator::SELF_FIRST
				    );

				    foreach($d as $file){
				     $total_space_used += $file->getSize();
				    }

				    //check space per user
				    $space_for_user_q=$db->prepare("SELECT * FROM admin_settings_users_bandwith where id = '1'");
				    $space_for_user_q->execute();
				    $fetch_space_for_user=$space_for_user_q->fetch(PDO::FETCH_ASSOC);

				    if ($fetch_space_for_user['size_by']=="GB") {
				    	$max_space_per_user=$fetch_space_for_user['space_for_users']*1024*1024*1024;
				    } else if ($fetch_space_for_user['size_by']=="MB") {
				    	$max_space_per_user=$fetch_space_for_user['space_for_users']*1024*1024;
				    } else if ($fetch_space_for_user['size_by']=="KB") {
				    	$max_space_per_user=$fetch_space_for_user['space_for_users']*1024;
				    }

				    $used=$total_space_used;

				    $percentage_count=$max_space_per_user/100;
				    $percentage=round($used/$percentage_count,1);

				    $total_space_used_in_bytes=$total_space_used;
				    $max_space_per_user_in_bytes=$max_space_per_user;

				    $total_space_used=formatBytes($total_space_used);
				    $max_space_per_user=formatBytes($max_space_per_user);

				    $action_for_user=true;
				    if($percentage >= 100) {
				    	$percentage=100;
				    	$action_for_user=false;
				    }
					?>

					<div class="capacity_files_users_text"><?=$total_space_used?> of <?=$max_space_per_user?> Used</div>
					<div class="progress_wrap">
						<?php
							if ($percentage <= 20) {
								$background="#27ae60";
							} else if($percentage <= 40) {
								$background="#2ecc71";
							} else if ($percentage <= 60) {
								$background="#f39c12";
							} else if ($percentage <= 80) {
								$background="#e67e22";
							} else if ($percentage <= 100) {
								$background="#e74c3c";
							}
						?>
						<div class="progress_bar" style="width:<?=$percentage?>%;background:<?=$background?>">
							<?=$percentage?>%
						</div>
					</div>
				</div>
				<li class="notife_menu">
					<a style="cursor:pointer" onclick="return showhide();" class="tooltip2" title="Notification"><i class="fa fa-bell fa-fw"></i>
						<?php
						$q=$db->prepare("SELECT * FROM user_sharing_subscriber where id_subscriber = $_SESSION[user_id] and status = '0'");
		    			$q->execute();
		    			$count=$q->rowcount();
		    				if($count > 0) {
		    					echo '<span class="count_notife">'.$count.'</span>';
		    				}
						?>
					</a>
					<div id="notife" style="display:none">
						<div class="triangle"></div>
			    		<div class="modal-content">
			      			<!-- dialog body -->
					    	<div class="modal-body" style="padding:10px;overflow-y:scroll;height:210px">
					    		<div class="loading" style="display:none;padding-top:40px;"><img src="img/load.gif" alt="" /></div>
					    		<?php
					    			$q=$db->prepare("SELECT * FROM user_sharing_subscriber where id_subscriber = $_SESSION[user_id] and status = '0'");
					    			$q->execute();
					    			$count=$q->rowcount();

					    			if($count > 0) {
					    				while($fetch=$q->fetch(PDO::FETCH_ASSOC)) {
					    				$s_user=$db->prepare("SELECT * FROM users where id = $fetch[id_user]");
						    			$s_user->execute();
						    			$f_s_user=$s_user->fetch(PDO::FETCH_ASSOC);
					    		?>
					    		<div class="each_notife">
					    			<div class="photo_user">
					    				<?php
					    					if($f_s_user['photo']=="") {
					    						$photo_user="img/user.png";
					    					} else {
					    						$photo_user=$f_s_user['photo'];
					    					}
					    				?>
					    				<img src="<?=$photo_user?>" width="64">
					    			</div>
					    			
					    			<div class="text_notife">
					    				<strong><u><?=$f_s_user['fullname']?></u></strong> mengundang anda untuk berbagi file <u><?=$fetch['folder_name']?></u> kepada anda.
					    			</div>

					    			<div class="button_notife">
					    				<script type="text/javascript">
					    					function NotifeSubmit() {
					    						$('.loading').show();
					    						return true;
					    					}
					    				</script>
					    				<form action="?mod=users&page=sharing&act=invitation" method="post">
					    					<input type="hidden" name="id_sharing" value="<?=$fetch['id']?>">
					    					<input type="submit" name="confirm" class="confirm" value="Confirm" onclick="return NotifeSubmit();">
					    					<input type="submit" name="no_confirm" class="no_confirm" value="No, Thanks!" onclick="return NotifeSubmit();">
					    				</form>
					    			</div>
					    			<div style="clear:both"></div>
					    		</div>
					    		<?php
					    				}
					    			} else {
					    				echo "No Notification!";
					    			}
					    		?>

					    	</div>
					    	<!-- dialog buttons -->
					    	<div class="modal-footer" style="margin:0px 0px -10px 0px">
					    		<button class="btn btn-primary" onclick="return close_notife();">Close</button>
					    	</div>
			    		</div>
					</div>
				</li>
				<?php
					$s_user_profile=$db->prepare("SELECT * FROM users where id = '$_SESSION[user_id]'");
					$s_user_profile->execute();
					$f_user_profile=$s_user_profile->fetch(PDO::FETCH_ASSOC);
				?>
				<li><a href="index.php?mod=users&page=profile"><i class="fa fa-user fa-fw margin10right"></i><?=$f_user_profile['fullname']?></a></li>
				<li><a href="logout.php"><i class="fa fa-power-off fa-fw margin10right"></i>Logout</a></li>

			<?php
				}
			?>
		</ul>
	</div>
	