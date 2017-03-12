<?php
	error_reporting(0);
include '../../config.php';
$username=trim(htmlentities(htmlspecialchars(addslashes($_POST['username']))));

$q=$db->prepare("SELECT * FROM users where username = :usn");
$q->bindParam(":usn",$username);
$q->execute();
$count=$q->rowCount();

echo $count;
?>