<?php 

session_start();

define('_VALID_NVB','1');



include("initcms.php");

 	clearstatcache();

 	$request  = $_SERVER['REQUEST_URI']; 

	$request=substr($request,strlen($dir_path),strlen($request));

	$params     = split("/", $request);
if ($_SERVER['HTTP_HOST'] != 'www.smartphonecentre.vn'){ 
		header("HTTP/1.1 301 Moved Permanently"); 
		header("Location: http://www.smartphonecentre.vn".$_SERVER['REQUEST_URI']);
	}
	

	if($params[1]=='fr'){

		$lang='fr';

		$_GET['lang']='fr';

		$_SESSION['lang']='fr';

		$lang_dir='fr/';

	}else{

		$lang=''	 ;

		$_GET['lang']='';

		$_SESSION['lang']='';

		$lang_dir='';

	}

/*	if($lang=='fr'){

		$language = " AND lang='fr' ";

	}else{

		$language = " AND lang<>'fr' ";

	}*/

	$language ='';

		

if($CONFIG['active_site']==1){

	

	if($_GET['page']){

		$page=$_GET['page'];

		$page1=$_GET['page'];

	}else{

		

		$getUrl = new url_process;

		//$uri=urldecode($_SERVER['REQUEST_URI']);

		$url_request = urldecode($_SERVER['REQUEST_URI']);
		$url_request1 = $url_request;
		$x = array();
		$x = explode("?",$url_request);
		$uri = $x[0];
		
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

		if($uri=='/addcart/'){
			$_GET['code']='add';
			$_GET['id_product']=$_GET['idp'];
			$_GET['prod_cat'] = 'product';
		}

		if($uri=='/update-cat/'){
			$_GET['code']='proadd';
			
		}
		if($uri=='/cart-checkout/'){
			$_GET['code']='checkout0';
		}
		if($uri=='/cart-order/'){
			$_GET['code']='procheckout1';
		}

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



