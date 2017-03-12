<?php
function encryptDecrypt($key, $string, $decrypt) {
    if($decrypt) {
        
        $string = str_replace("|", "/", $string);
        $decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($string), MCRYPT_MODE_CBC, md5(md5($key))), "12");
        return $decrypted;
    } else {
        $encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5(md5($key))));
        $stripping = true;

        while ($stripping) {
            if(substr($encrypted, -1) == "="){
                $encrypted = substr($encrypted, 0, strlen($encrypted)-1);
            } else {
                $stripping = false;
            }
        }
        return str_replace("/", "|", $encrypted);
    }
}

//exaple implementation

// $echo = encryptDecrypt("JAHANAM", "/dsdsddsd/", 0);
// echo $echo."<br>";
// echo encryptDecrypt("JAHANAM", $echo, 1);
?>
