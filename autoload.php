<?php
	ob_start();
	ob_flush();
	ob_clean();

	session_save_path("temp/sessions");
	session_regenerate_id(true);
	session_start();

	include 'config.php';
	include 'assets/function/encrypt_decrypt.func.php';
	include 'assets/function/files.func.php';
	include 'assets/function/rand.func.php';
	include 'var.php';

?>