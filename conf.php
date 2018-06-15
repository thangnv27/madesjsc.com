<?php

//Nguyen Binh
//email:suongmumc@gmail.com

//session_save_path('F:/Domains/xepro.com.vn/wwwroot/uploaded/temp/');

$config['dbname']="madesjsc_ha";
$config['username']="madesjsc_ha";
$config['password']="anhhabkaa2604";
$config['host']="localhost";

$site_address='http://'.$_SERVER['HTTP_HOST'];
$dir_path='';
$cache_file_dir = dirname(__FILE__);

$imagedir_finder = "/uploaded/";
$dir_image_upload = "/uploaded/".date('Y',time())."/".date('m',time())."/";
$dir_image_browser = '/uploaded/';
$cache_image_path = $dir_path.'/temp/';
$minify = 0;
$clearcachetime = time() + 172800 ; // 2 ngày

// config url
$rewrite = 1;
$url_extension_category = '/';
$url_extension_article = '.html'; // .htm,.html
$url_max_number_category = 2; //1,2,3,4
 
?>
