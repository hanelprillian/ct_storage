<?php
	error_reporting(0);
	define(SALT_FOR_PASSWORD, 'JAHANAMBUL2014HAHAHA');

	// start database config

	$username="root";
	$password="";
	try {
		$db=new PDO('mysql:host=localhost;dbname=ct_storage',$username,$password);
		$db->setAttribute(PDO::ATTR_EMULATE_PREPARES,false); 
	} catch (PDOException $e){
		echo 'ERROR '. $e->getMessage();
		die();
	}

	//GLOBAL CONFIG

	$id=$_SESSION['user_id'];
	if($_SESSION['role']=="administrator") {
		$role=1;
	} else if ($_SESSION['role']=="users") {
		$role=2;
	}

	$user_root_file=$db->prepare("SELECT * FROM users where id = :id and role= :role");
	$user_root_file->bindParam(":id",$id);
	$user_root_file->bindParam(":role",$role);
	$user_root_file->execute();
	$count=$user_root_file->rowCount();
	$fetch=$user_root_file->fetch(PDO::FETCH_ASSOC);

	//constanta root file

	define(ROOT_FILE_STORAGE, 'root_storage_file/'.$_SESSION['role']);
	define(ROOT_FILE, 'root_storage_file/');
	define(USER_FILE_ROOT, $fetch['root_file']);
	define(STORAGE_DIR, 
		   ROOT_FILE_STORAGE.'/'.USER_FILE_ROOT
		   );
