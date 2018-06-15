<?php

//Nguyen Binh
//email:suongmumc@gmail.com

//session_save_path('F:/Domains/xepro.com.vn/wwwroot/uploaded/temp/');
$config['dbname']="antien_db";
$config['username']="antien_us";
$config['password']="@nt1en";
$config['host']="localhost";

$site_address="http://".$_SERVER['HTTP_HOST'];
$dir_path='';
$cache_file_dir = dirname(__FILE__);
$imagedir = "";
$dir_image_upload = "/uploaded/files/";  // /uploaded/files/

$clearcachetime = time() + 172800 ; // 2 ngày

?>