<?php
define('_VALID_NVB','1');
include("initcms.php");
session_start();
$page=$_GET['page'];
if ($page == '' || $page == null) $page = 'home';
$path="modules/$page.php";
if (file_exists($path)) {
	include($path);
}
include("endcms.php");
?>