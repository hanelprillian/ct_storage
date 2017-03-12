<?php
	if(file_exists('autoload.php')) {
    include 'autoload.php';
  }

	if(isset($_SESSION['role'])) {
		$mod_path=$_SESSION['role'];
		header('location:index.php?mod='.$mod_path.'');
		exit();
	}

	/*
	$ip_address=$_SERVER['REMOTE_ADDR'];
	$query_login_attempts=$db->prepare("SELECT * from login_attempts where ip_address = ?");
	$query_login_attempts->execute(array($ip_address));
	$count_query_login_attempts=$query_login_attempts->rowCount();
	$row_login_attempts=$query_login_attempts->fetch(PDO::FETCH_ASSOC);

	if ($row_login_attempts['total'] >= 2) {
		$captcha_form=true;
	} else {
		$captcha_form=false;
	}
	*/

	if($_POST['login']) {

		$query=$db->prepare("SELECT * from users where username= :usn and password = :pass");
		$query->bindParam(":usn",$usn);
		$query->bindParam(":pass",$pass);
		$query->execute();
		$count=$query->rowCount();
		$row=$query->fetch(PDO::FETCH_ASSOC);

		/*if($captcha_form) {

			if ($count==1 && $captcha==$_SESSION['encoded_captcha'] && $_SESSION['encoded_captcha']!=""){
				$valid=1;
			} else {
				$valid=0;
			}

		} else {

			if ($count==1) {
				$valid=1;
			} else {
				$valid=0;
			}
		}*/

		if ($count==1) {
			$valid=1;
		} else {
			$valid=0;
		}

		if($valid==1) {
			session_save_path("temp/sessions");
			session_regenerate_id(true);
			if($row['role']=='1') {
				$role="administrator";
			} else if ($row['role']=='2') {
				$role="users";
			}
			$_SESSION['role']=$role;
			$_SESSION['username']=$row['username'];
			$_SESSION['user_id']=$row['id'];

			/*$ip_address=$_SERVER['REMOTE_ADDR'];
			$query_login_attempts=$db->prepare("SELECT * from login_attempts where ip_address = ?");
			$query_login_attempts->execute(array($ip_address));
			$count_query_login_attempts=$query_login_attempts->rowCount();
			$row_login_attempts=$query_login_attempts->fetch(PDO::FETCH_ASSOC);

			if($count_query_login_attempts > 0) {
				$ip_address=$_SERVER['REMOTE_ADDR'];
				$q_insert=$db->prepare("UPDATE login_attempts SET total = 0 where ip_address = ?");
				$q_insert->execute(array($ip_address));
			} else {
				$ip_address=$_SERVER['REMOTE_ADDR'];
				$q_insert=$db->prepare("INSERT into login_attempts SET ip_address = ?, total = 0");
				$q_insert->execute(array($ip_address));
			}*/

			session_write_close();
			$success_message=true;
			/*unset($_SESSION['encoded_captcha']);*/

		} else {

			/*$ip_address=$_SERVER['REMOTE_ADDR'];
			$query_login_attempts=$db->prepare("SELECT * from login_attempts where ip_address = ?");
			$query_login_attempts->execute(array($ip_address));
			$count_query_login_attempts=$query_login_attempts->rowCount();
			$row_login_attempts=$query_login_attempts->fetch(PDO::FETCH_ASSOC);

			if($count_query_login_attempts > 0) {
				//nothing
			} else {
				$ip_address=$_SERVER['REMOTE_ADDR'];
				$q_insert=$db->prepare("INSERT into login_attempts SET ip_address = ?, total = 1");
				$q_insert->execute(array($ip_address));
			}

			$ip_address=$_SERVER['REMOTE_ADDR'];

			if($row_login_attempts['ip_address'] != $ip_address) {
				$fail_login=0;
			} else {
				$fail_login=$row_login_attempts['total']+1;
			}

			$query_login_attempts=$db->prepare("UPDATE login_attempts set total = ? where ip_address = ?");
			$query_login_attempts->execute(array($fail_login,$ip_address));*/

			header('location:login.php?message=error');
			exit();
		}
	}

?>
<!DOCTYPE html>
<html>
	<head>
		<title>LOGIN | Portal Upload | CT</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="assets/css/style.css"/>
	 <!-- Loading Bootstrap -->
  	<link href="assets/css/bootstrap.css" rel="stylesheet" type="text/css">
  	<link href="assets/css/prettify.css" rel="stylesheet" type="text/css">

  	<!-- Loading Flat UI -->
  	<link href="assets/css/flat-ui.css" rel="stylesheet" >
  	<link href="assets/css/font-awesome.min.css" rel="stylesheet" media="screen">
  	<link href="assets/css/bootflat.css" rel="stylesheet" media="screen">
  	<link href="assets/css/bootflat-extensions.css" rel="stylesheet" media="screen">
  	<link href="assets/css/bootflat-square.css" rel="stylesheet" media="screen">
  	<script src="assets/js/jquery-1.10.1.min.js"></script>
  	<script src="assets/js/bootstrap.min.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="assets/js/html5shiv.js"></script>
      <script src="assets/js/respond.min.js"></script>
    <![endif]-->

    <script type="text/javascript">
    	$(function(){
	    jQuery.fn.center = function ()
	    {
	        this.css("position","absolute");
	        this.css("top", ($(window).height() / 2) - (this.outerHeight() / 2));
	        this.css("left", ($(window).width() / 2) - (this.outerWidth() / 2));
	        return this;
	    }
	   
	    $('.wraplogin').center();
		    $(window).resize(function(){
		       $('.wraplogin').center();
		    });
		});
    </script>
	</head> 
	<body class="img_blur">
		<div class="wraplogin">
			<div id="login">
				<div class="contentboxlogin">
					<?php
						$message=trim(htmlentities(htmlspecialchars(addslashes($_GET['message']))));
						if($message == "error") {
							if ($captcha_form) {
								echo '<div class="alert alert-block alert-danger fade in">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
								<p align="center">Wrong Username or Password or Captcha!</p>
						</div>';
							} else {
								echo '<div class="alert alert-block alert-danger fade in">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
								<p align="center">Wrong Username or Password!</p>
						</div>';
							}
						$loginform=true;

						} else if($success_message) {
							$mod_path=$_SESSION['role'];
							echo '<div class="alert alert-block alert-success fade in">
							<p align="center">Sukses Login, Redirecting...</p>
					</div>
					<meta http-equiv="refresh" content="0;URL=\'index.php?mod='.$mod_path.'\'" />  ';
							$loginform=false;
						} else {
							$loginform=true;
						}
					?>
					<?php
						if($loginform) {
					?>
					<div class="logologin"><img src="img/2itc.png"></div>
					<table width="100%" border="0">
						<form action="login.php" method="post">
						  <tr>
						  	<div class="input-group" style="margin-bottom:10px">
									<span style="background:#16a085;border:1px solid #16a085;color:white" class="form-control-square input-group-addon"><i class="fa fa-user"></i></span>
									<input autocomplete="off" type="text" placeholder="Username" name="usn" class="form-control form-control-square"/>
								</div>
						  </tr>
						  <tr>
						  	<div class="input-group">
									<span style="background:#16a085;border:1px solid #16a085;color:white" class="form-control-square input-group-addon"><i class="fa fa-lock"></i></span>
									<input autocomplete="off" type="password" placeholder="Password" name="psw" class="form-control form-control-square"/>
								</div>
						  </tr>
						  <?php
						 
						  	if($captcha_form) {
						  ?>
						  <tr>
						  	<center>
									<img src="img.php" style="margin:10px 0px 10px 0px">
								</center>
						  	<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
									<input name="captcha"class="form-control" placeholder="Insert Code" type="text">
								</div>
						  </tr>
						  <?php
						  	} else {
						  		//nothing
						  	}
						  ?>
						  <tr>
						    <td><input type="submit" name="login" class="btn btn-success" value="Login"/></td>
						  </tr>
						</form>
					</table>
					<?php
						} else {
							//nothing
						}
					?>
				</div>

			</div>
		</div>

	</body>
</html>