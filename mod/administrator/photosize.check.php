<?php
	error_reporting(0);
include '../../config.php';
$photo=trim(htmlentities(htmlspecialchars(addslashes($_POST['photo']))));

if($photo["size"] > 30000) {
	return false;
} else {
	return true;
}
return true;
?>