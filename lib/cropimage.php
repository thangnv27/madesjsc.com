<?php 
	// nguyenbinh 2012
	//xepro.vn
error_reporting(E_ERROR);
function cropimage($w,$h,$src){
	global $_SERVER, $_GET,$CONFIG,$dir_path,$cache_image_path;
	
	$savepath = $_SERVER['DOCUMENT_ROOT'].$cache_image_path;
	$src = urldecode($src);
	$src = str_replace("//","/",$src);
	
	$image			=''. preg_replace('/^(s?f|ht)tps?:\/\/[^\/]+/i', '', (string) $src);
	$image1 = $image;
	$image=$_SERVER['DOCUMENT_ROOT'].$image;
	$new_name = basename($image);
	$directory_name = str_replace('/','-',dirname($src)).'_';
	$ext = pathinfo($image, PATHINFO_EXTENSION);
	$new_name = substr($new_name,0,-strlen($ext)-1);
	$new_name =$directory_name . $new_name."_cr_".$w."x".$h.".".$ext;
	if(file_exists($_SERVER['DOCUMENT_ROOT'].$cache_image_path.$new_name)){
		return $new_name;	
	}else{	
		if(file_exists($image) && $image1 && $ext){
			
			try {
	  			$size=getimagesize($image);
	  			$img = WideImage::load($image);
	  			
	  			if($size[0] > $size[1] && $size[0] > $w){
	  				$im = $img->resize($w, $h, 'outside');
	  			}elseif($size[0] <= $size[1] && $size[1] > $h){
	  				$im = $img->resize($w, $h, 'outside');
	  			}else{
	  				$im=$img;
	  			}
	  			$img1= $im->crop('center', 'center', $w, $h)->saveToFile($savepath.$new_name);;
	  			//$img1->output('jpg', 100);
	  			
	  		
	  			return  $new_name;
			} catch (Exception $e) {}
		}
	}
}


function resizeimage($w,$h,$src){
	global $_SERVER, $_GET,$CONFIG,$dir_path,$cache_image_path;
	//require( "lib/imagelib/WideImage.php" );
	
	// nguyenbinh 2012
	//xepro.vn
	$savepath = $_SERVER['DOCUMENT_ROOT'].$cache_image_path;
	$src = urldecode($src);
	$src = str_replace("//","/",$src);
	
	$image			=''. preg_replace('/^(s?f|ht)tps?:\/\/[^\/]+/i', '', (string) $src);
	$image1 = $image;
	$image=$_SERVER['DOCUMENT_ROOT'].$image;
	$new_name = basename($image);
	$directory_name = str_replace('/','-',dirname($src)).'_';
	$ext = pathinfo($image, PATHINFO_EXTENSION);
	$new_name = substr($new_name,0,-strlen($ext)-1);
	$new_name = $directory_name . $new_name."_thumb_".$w."x".$h.".".$ext;
	
	if(file_exists($_SERVER['DOCUMENT_ROOT'].$cache_image_path.$new_name)){
		return $new_name;	
	}else{	
		if(file_exists($image) && $image1 && $ext){
			try {
				$img = WideImage::load($image);
				$wh = getimagesize($image);
                                
                               
                                
				$xRatio		= $w / $wh[0];
				$yRatio		= $h / $wh[1];
                                if($wh[0] < $w && $wh[1] <$h){
                                    $w = $w;
                                    $h = $h;
                                }else if ($xRatio * $wh[1] < $h){ 
					$tnHeight	= ceil($xRatio * $wh[1]);
					$tnWidth	= $w;
                                }else {
                                        $tnWidth	= ceil($yRatio * $wh[0]);
                                        $tnHeight	= $h;
                                }
				
				$w = $tnWidth;
				$h = $tnHeight;
				$im = $img->resize($w, $h, 'outside')->saveToFile($savepath.$new_name);
				
				//$im->saveToFile($savepath.$new_name, 100);
				return  $new_name;
			} catch (Exception $e) {}
		}
	}
}
?>