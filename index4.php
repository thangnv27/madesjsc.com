<?php
define('_VALID_NVB','1');
include("initcms.php");
session_start();
$page=$_GET['page'];
$lang = $_GET['lang'];
if($lang=='fr'){
		$langu = "vn";
	}else{
		$langu = "en";
	}
if ($page == '' || $page == null) $page = 'home';
$path="modules/$page.php";
if (file_exists($path)) {
	include($path);
}
include("endcms.php");
?>