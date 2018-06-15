<?php 
error_reporting(0);
require( "./lib/imagelib/WideImage.php" );
	$w=intval($_GET['w']);
	$h=intval($_GET['h']);
// nguyenbinh 2012
//xepro.vn
$image			=''. preg_replace('/^(s?f|ht)tps?:\/\/[^\/]+/i', '', (string) $_GET['src']);
$image=$_SERVER['DOCUMENT_ROOT'].$image;

$size=getimagesize($image);
$img = WideImage::load($image);
if($size[0] > $size[1] && $size[0] > $w){
	$im = $img->resize($w, $h, 'outside');
}elseif($size[0] <= $size[1] && $size[1] > $h){
		$im = $img->resize($w, $h, 'outside');
}else{
	$im=$img;
}
$img1= $im->crop('center', 'center', $w, $h);
$img1->output('jpg', 100);

?>