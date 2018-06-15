<?php

defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );

$tpl=new TemplatePower("skin/excu_size_price.tpl");

$tpl->prepare();

$id = intval($_GET['id']);
if($_GET['code'] == 'load'){
	getSizePrice($id);	
}
$tpl->printToScreen();

function loadSizePrice($id){
	global $DB,$tpl;
	$sql = "SELECT * FROM dm_size ORDER BY thu_tu DESC";
	$db = $DB->query($sql);
	$str='';
	while($rs = mysql_fetch_array($db)){
		$tpl->newBlock("size_price");
		$tpl->assign("name",$rs['name']);
		$tpl->assign("id_size",$rs['id_size']);
	}
	return $str;
}

function getSizePrice($idp){
	global $DB,$tpl;
	if($idp){
		$ok=true;
		$sql = "SELECT * FROM product WHERE id_product = $idp";
		$db = $DB->query($sql);
		if($rs = mysql_fetch_array($db)){
			$size_price = json_decode($rs['size_price']);	
		}
	}else{
		$ok=false;
	}	
	$sql = "SELECT * FROM dm_size ORDER BY thu_tu DESC";
	$db = $DB->query($sql);
	while($rs = mysql_fetch_array($db)){
		$tpl->newBlock("size_price");
		$tpl->assign("name",$rs['name']);
		$tpl->assign("id_size",$rs['id_size']);
		$tpl->assign("size_price_value",$size_price->$rs['id_size']);
	}
}

?>