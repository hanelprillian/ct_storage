<?php
	include 'config.php';
	session_save_path("temp/sessions");
	session_regenerate_id(true);
	session_start();
	unset($_SESSION['role']);
	$ip_address=$_SERVER['REMOTE_ADDR'];
	$query_logout_attempts=$db->prepare("DELETE from login_attempts where ip_address = ?");
	$query_logout_attempts->execute(array($ip_address));
	header('location:login.php');
	exit();
?>