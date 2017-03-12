<?php
error_reporting(0);
session_start();
if(!isset($_SESSION['role'])) die ("<h1>Not Found</h1>
<p>The requested URL $_SERVER[PHP_SELF] was not found on this server.</p>");
if($_SESSION['role']!="users") {
	header('location:login.php');
	exit();
}
	$confirm=trim(htmlentities(htmlspecialchars(addslashes($_POST['confirm']))));
	$noconfirm=trim(htmlentities(htmlspecialchars(addslashes($_POST['no_confirm']))));
	$id_sharing=trim(htmlentities(htmlspecialchars(addslashes($_POST['id_sharing']))));
	if($confirm) {
		$confirm_q=$db->prepare("UPDATE user_sharing_subscriber SET status = '1' where id = '$id_sharing'");
		$confirm_q->execute();
		header('location:?mod=users&page=sharing&msg=success&id_msg=1');
		exit();
	} else if($noconfirm) {
		$no_confirm_q=$db->prepare("DELETE FROM user_sharing_subscriber WHERE id = '$id_sharing'");
		$no_confirm_q->execute();
		header('location:?mod=users&page=sharing&msg=success&id_msg=2');
		exit();
	} 
?>