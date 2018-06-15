<?php 
// Nguyen Binh
// suongmumc@gmail.com

defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );
$tpl=new TemplatePower("skin/tool_robots.tpl");
$tpl->prepare();
	
	if($_POST['gone'] == 1){
		write_robots($_POST['robots_view']);
	}
	
	$file = file_get_contents('../robots.txt', FILE_USE_INCLUDE_PATH);
	
	if($file){
		$tpl->assign("content",$file);
	}else{
		$File = "../"."robots.txt"; 
		$Handle = fopen($File, 'w');
		$Data = 'User-agent: *
Disallow:';
		$ok=fwrite($Handle, $Data); 
		fclose($Handle); 	
		$file = file_get_contents('../robots.txt', FILE_USE_INCLUDE_PATH);
		$tpl->assign("content",$file);
	}
	
	
$tpl->printToScreen();
function write_robots($content){
	global $DB,$CONFIG,$tpl;
	
	$File = "../"."robots.txt"; 
	$Handle = fopen($File, 'w');
	$Data = $content;

	$ok=fwrite($Handle, $Data); 
	fclose($Handle); 	
	$tpl->assign("msg", "<div class=\"alert alert-success\" style=\"text-align:center; width:460px;\"><strong>Đã cập nhật xong !</strong></div>");
}

?>