<?php


define('_VALID_NVB','1');

include("../initcms.php");
$page=$_GET['page'];
$ap=array('action_ajax','editphoto','excu_attr','ajaxQuestion','listtuongthich','tool_write_sitemap');
if(in_array($page,$ap)){
	if ($page == '' || $page == null) $page = 'home';
	$path="source/$page.php";
	if (file_exists($path)) {
		include($path);
	}
}
include("../endcms.php");
?>