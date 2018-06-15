<?php



error_reporting(0);

define('_VALID_NVB','1');



include("./initcms.php");

$page=$_GET['page'];

$ap=array('action_ajax','editphoto','excu_attr','ajaxQuestion','listtuongthich','create_form','forms','export_list_customer','tool_clearcachefile','tool_write_sitemap','tool_robots','tool_redirects','excu_size_price','spcungloai','export_excel','export_excel_order');

if(in_array($page,$ap)){

	if ($page == '' || $page == null) $page = 'home';

	$path="source/$page.php";

	if (file_exists($path)) {

		include($path);

	}

}

include("../endcms.php");

?>