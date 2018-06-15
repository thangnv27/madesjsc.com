<?php
session_start();
$text=strtoupper(substr(md5(rand(1,999)),0,6));
$text1=strtolower($text);
$_SESSION['imagesercurity']=$text1;

header("Content-type: image/png");
$im = @imagecreate(62, 22)  or die("Cannot Initialize new GD image stream");
$background_color = imagecolorallocate($im, 235, 236, 240);
$text_color = imagecolorallocate($im, 121, 121, 123);
$font='arial.ttf';

		$red = imagecolorallocate($im, 255, 0, 0);                  // red
		$white = imagecolorallocate($im, 177, 181, 241);			// white
		$line=imagecolorallocate($im, 131, 131, 135);				// gray
        
	    imagerectangle ($im,   0,  0, 61, 21, $line);
		imageline ($im,   5,  1, 15, 20, $white);
		imageline ($im,   20,  1, 30, 20, $white);
		imageline ($im,   35,  1, 45, 20, $white);
		imageline ($im,   50,  1, 60, 20, $white);
		imageline ($im,   1,  15, 61, 15, $white);
		imageline ($im,   1,  10, 61, 10, $white);
		imageline ($im,   1,  5, 61, 5, $white);
		imagestring($im, 7, 5, 5,  $text, $text_color);
        

imagepng($im);
imagedestroy($im);

?>