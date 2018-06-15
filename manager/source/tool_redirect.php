<?php 
// Nguyen Binh
// suongmumc@gmail.com

defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );
$tpl=new TemplatePower("skin/tool_redirect.tpl");
$tpl->prepare();
	
		$File = "../"."redirect.txt"; 
		$Handle = fopen($File, 'w');
		$Data = 'User-agent: *
Disallow:';
		$ok=fwrite($Handle, $Data); 
		fclose($Handle); 	
	
	
$tpl->printToScreen();
function write_robots($content){
	global $DB,$CONFIG,$tpl;
	
	$File = "../"."redirect.txt"; 
	$Handle = fopen($File, 'w');
	$Data = $content;

	$ok=fwrite($Handle, $Data); 
	fclose($Handle); 	
	$tpl->assign("msg", "<div class=\"alert alert-success\" style=\"text-align:center; width:460px;\"><strong>Đã cập nhật xong !</strong></div>");
}

?>