<?php
	error_reporting(0);
include '../../config.php';
$username=trim(htmlentities(htmlspecialchars(addslashes($_POST['username']))));
$email=trim(htmlentities(htmlspecialchars(addslashes($_POST['email']))));
$id=trim(htmlentities(htmlspecialchars(addslashes($_GET['id']))));

if ($email) {
$q=$db->prepare("SELECT * FROM users where email = :email");
$q->bindParam(":email",$email);
$q->execute();
$count=$q->rowCount();

	if(isset($id)) {
		$q=$db->prepare("SELECT * FROM users where id = :id");
		$q->bindParam(":id",$id);
		$q->execute();
		$r=$q->fetch(PDO::FETCH_ASSOC);
		if($email==$r['email']) {
			$count=2;
		}
	}

echo $count;
}
?>