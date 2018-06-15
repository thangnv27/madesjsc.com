<?php 

// Nguyen Binh

// suongmumc@gmail.com
defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );
$tpl=new TemplatePower("skin/tool_redirects.tpl");
$tpl->prepare();
	if($_POST['gone'] == 1){
		write_redir($_POST['robots_view']);
	}
	$file = file_get_contents('../redirects_301.php', FILE_USE_INCLUDE_PATH);
	if($file){
		$tpl->assign("content",$file);
	}else{
		$File = "../"."redirects_301.php"; 
		$Handle = fopen($File, 'w');
		
		
		
		$ok=fwrite($Handle, $Data); 
		fclose($Handle); 	
		$file = file_get_contents('../redirects_301.php', FILE_USE_INCLUDE_PATH);
		$tpl->assign("content",$file);
	}

$tpl->printToScreen();

function write_redir($content){
	global $DB,$CONFIG,$tpl;
	$File = "../"."redirects_301.php"; 
	$Handle = fopen($File, 'w');
	$Data = $content;

	$ok=fwrite($Handle, $Data); 
	fclose($Handle); 	
	$tpl->assign("msg", "<div class=\"alert alert-success\" style=\"text-align:center; width:460px;\"><strong>Đã cập nhật xong !</strong></div>");
}

?>