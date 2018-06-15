<?php 
session_start();
define('_VALID_NVB','1');
include("initcms.php");

 	
 	$request  = $_SERVER['REQUEST_URI']; 
	$request=substr($request,strlen($dir_path),strlen($request));
	$params     = split("/", $request);
	
	
		
if($CONFIG['active_site']==1){
	
	if($_GET['page']){
		$page=$_GET['page'];
		$page1=$_GET['page'];
	}else{
		
		$getUrl = new url_process;
		$uri=urldecode($_SERVER['REQUEST_URI']);
		$cateinfo = $getUrl->Url_Type($uri);
		
		
		//alert($getUrl->get_dir($uri));
  		//alert($getUrl->get_filename($uri));
		$page1=$cateinfo['page'];
		$page=$cateinfo['page'];
	
		$_GET['id'] 	= intval($getUrl->get_id_item($uri));
		$_GET['id_product'] 	= intval($getUrl->get_id_item($uri));
		$_GET['idc'] 	= intval($cateinfo['id_category']);
		
		
			$_GET['keyword']= $cateinfo['keyword'];	
		
		$_GET['title'] = $cateinfo['title'];
		$_GET['p'] 		= intval($cateinfo['p']);
		$_GET['code'] 	= $cateinfo['code'];
		$_GET['prod_cat'] =$cateinfo['prod_cat'];
		$_GET['id'] = $getUrl->get_id_article($cateinfo['data_type'],$getUrl->get_filename($uri));
	
	
		$idc=$_GET['idc'];
		$p=$_GET['p'];
		if($p){
			if($p<=0) $p=1;	
			if($id){
			}elseif($p>1){
			$plink=$p.'.htm';
			}
		}
		$meta = $getUrl->get_meta_item($cateinfo['data_type']);
		
		
	}

	if ($page1 == '' || $page1 == null) $page1='home';
	$page1="modules/$page1.php";
	if (file_exists($page1)) {
			include("modules/header.php");	
			include($page1);
			include("modules/footer.php");
	}else{
		referbox("/index.php?","Page not pound, redirec to home page");
	}
	include("endcms.php");
} else {
	include("source/error.php");
}




?>

