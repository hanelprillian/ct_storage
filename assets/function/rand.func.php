<?php
class main {
	public static function md5_rand($length){
		$var=md5(mt_rand(0,99999));
		$code="";
		$i=0;
		while($i<$length){
			$code.=substr($var,mt_rand(0,strlen($var)-1),1);
			$i++;
		}
		return $code;
	}
}
?>
