<?php

	$_SESSION[a]=str_replace("/index.php","",$_SERVER['SCRIPT_NAME']);
	$url=$_SESSION[a];

	$websiteurl=str_replace("/index.php/","",$_SERVER['SCRIPT_NAME']);
	$websiteurl=str_replace($websiteurl, "", $_SERVER['REQUEST_URI']);

	foreach(array_keys($_GET) as $key)
	{
	  $_GET[$key] = trim(htmlentities(htmlspecialchars(addslashes($_GET[$key]))));
	}

	$mod=trim(htmlentities(htmlspecialchars(addslashes(str_replace('..', '',str_replace('/', '',$_GET['mod']))))));
	$page=trim(htmlentities(htmlspecialchars(addslashes(str_replace('..', '',str_replace('/', '',$_GET['page']))))));
	$act=trim(htmlentities(htmlspecialchars(addslashes(str_replace('..', '',str_replace('/', '',$_GET['act']))))));
	$id=trim(htmlentities(htmlspecialchars(addslashes(str_replace('..', '',str_replace('/', '',$_GET['id']))))));

	//var login form
	$usn=trim(htmlentities(htmlspecialchars(addslashes($_POST['usn']))));
	$pass=trim(htmlentities(htmlspecialchars(addslashes(md5($_POST['psw'].SALT_FOR_PASSWORD)))));
	$captcha=trim(htmlentities(htmlspecialchars(addslashes(md5($_POST['captcha'])))));
