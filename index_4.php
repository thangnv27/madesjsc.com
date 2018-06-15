<?php
session_start();
define('_VALID_NVB', '1');
include("initcms.php");
//clearstatcache();
$request = $_SERVER['REQUEST_URI'];
$request = substr($request, strlen($dir_path), strlen($request));
$params = split("/", $request);


include_once("./redirects_301.php");
$redirects = new redirects301();
include_once ('lang/lang.php');

if ($params[1] == 'en') {
    $lang = 'en';
    $_GET['lang'] = 'en';
    $_SESSION['lang'] = 'en';
    $lang_dir = 'en/';
} else {
    $lang = '';
    $_GET['lang'] = '';
    $_SESSION['lang'] = '';
    $lang_dir = '';
}
if ($lang == 'en') {
    $language = " AND lang='en' ";
} else {
    $language = " AND lang<>'en' ";
}



if ($CONFIG['active_site'] == 1) {
    if ($_GET['page']) {
        $page = $_GET['page'];
        $page1 = $_GET['page'];
    } else {
        $getUrl = new url_process;
        //$uri=urldecode($_SERVER['REQUEST_URI']);
        $url_request = urldecode($_SERVER['REQUEST_URI']);
        $url_request1 = $url_request;
        $x = array();
        $x = explode("?", $url_request);
        $uri = $x[0];
        $cateinfo = $getUrl->Url_Type($uri);
        $page1 = $cateinfo['page'];
        $page = $cateinfo['page'];
        $_GET['id'] = intval($getUrl->get_id_item($uri));
        $_GET['id_product'] = intval($getUrl->get_id_item($uri));
        $_GET['idc'] = intval($cateinfo['id_category']);
        $_GET['keyword'] = $cateinfo['keyword'];
        $_GET['title'] = $cateinfo['title'];
        $_GET['p'] = intval($cateinfo['p']);
        $_GET['code'] = $cateinfo['code'];
		$_GET['iw'] = $cateinfo['iw']; /*in where*/
        if ($uri == '/addcart/') {
            $_GET['code'] = 'add';
            $_GET['id_product'] = $_GET['idp'];
            $_GET['prod_cat'] = 'product';
        }

        if ($uri == '/update-cat/') {
            $_GET['code'] = 'proadd';
        }
        if ($uri == '/cart-checkout/') {
            $_GET['code'] = 'checkout0';
        }
        if ($uri == '/cart-order/') {
            $_GET['code'] = 'procheckout1';
        }
		$url_filename = $getUrl->get_filename($uri);
        $_GET['id'] = $getUrl->get_id_article($cateinfo['data_type'], $url_filename);
        $idc = $_GET['idc'];
        $p = $_GET['p'];

        if ($p) {
            if ($p <= 0)
                $p = 1;
            if ($id) {
				
            } elseif ($p > 1) {
                $plink = $p . '.htm';
            }
        }
        $meta = $getUrl->get_meta_item($cateinfo['data_type']);
    }
	
	
	if($page1=='' && strlen($uri)>1){
		header( "Location: ".$site_address.$dir_path."/index.php?page=404");
		exit;
	}
	
    if ($page1 == '' || $page1 == null)
        $page1 = 'home';
	
	// url - process
	//include("lib/404_process.php");
    $page1 = "modules/$page1.php";
    if (file_exists($page1)) {
        include("modules/header.php");
        include($page1);
        include("modules/footer.php");
    } else {
        referbox("/index.php?", "Page not pound, redirec to home page");
    }
    include("endcms.php");
} else {

    include("source/error.php");
}
?>



