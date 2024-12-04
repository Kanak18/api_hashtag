<?php 
session_start();

$im = imagecreatetruecolor(130,35);
$im_src = imagecreatefromjpeg("./captcha.jpg");
imagecopyresampled($im,$im_src,0,0,0,0,130,35,155,50);

$black = imagecolorallocate($im,0,0,0);

$font = "./captcha.ttf";
$size = 20;
$angel = 0;

$string = strtoupper(substr(md5(uniqid(rand())),0,6));
$string = str_replace("0","9",$string);
$string = str_replace("O","P",$string);
$string = str_replace("D","P",$string);

$_SESSION["myCAPTCHA"] = $string;

$x = 18;
$y = 28;

imagefttext($im,$size,$angel,$x,$y,$black,$font,$string); 

header("Content-type: image/jpeg"); 
imagejpeg($im);
imagedestroy($im);

?>