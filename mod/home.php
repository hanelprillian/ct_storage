<?php
	session_start();
	if($_SESSION['role']=="") {
		header('location:login.php');
	} else {
		$mod_path=$_SESSION['role'];
		header('location:index.php?mod='.$mod_path.'');
	}
?>