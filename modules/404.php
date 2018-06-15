<?php 
defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );
$tpl = new TemplatePower("templates/404.htm");

$tpl->prepare();

$page404 = $static->page404();
$tpl->assignGlobal("page404",$page404['content']);

$tpl->printToScreen();	


?>