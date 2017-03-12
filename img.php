<?php
	session_save_path("temp/sessions");
	session_start(); 

	$string_length=4; //jumlah karakter
	$rand_string="";

	for($i=0;$i<$string_length;$i++) {
		$rand_string.=chr(rand(65,90));
		$rand_string.=rand(0,9);
	}

	//IMAGE VARIABLES

	$width=376;
	$height=60;

	//INIT IMAGE

	$img=imagecreatetruecolor($width, $height);

	// COLORS

	$black=imagecolorallocate($img, 0, 0, 0);
	$gray=imagecolorallocate($img, 200, 200, 200);
	imagefilledrectangle($img, 0, 0, $width, $height, $gray);

	// FONT

	$f_collection=array('assets/fonts/wew.TTF','assets/fonts/lato/lato-black-webfont.TTF');
	$font=$f_collection[rand(0,1)];
	$font_size=rand(10,14);

	// CALC APPROX LOCATION FOR TEXT

	$y_value=rand(15,30);
	$x_value=rand(5,180);

	//DRAW STRING USING TRUE TYPE FUNCTION

	$rotate=rand(-5,5);
	imagettftext($img, $font_size, $rotate, $x_value,
	$y_value, $black, $font, $rand_string);
	$_SESSION['encoded_captcha']=md5($rand_string);

	header("Content-Type: image/png");
	imagepng($img);
?>