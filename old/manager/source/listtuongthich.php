<?php 
	defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );
	$tpl=new TemplatePower("skin/listtuongthich.tpl");
	$tpl->prepare();
	
	$idc = intval($_GET['idc']);
	
	$sql = "SELECT * FROM product WHERE id_category IN(".Category::getParentId($idc).")";
	$db = $DB->query($sql);
	while($rs = mysql_fetch_array($db)){
		$tpl->newBlock("list")	;
		$tpl->assign("name",$rs['name']);
		$tpl->assign("id_product",$rs['id_product']);
	}
	
	$tpl->printToScreen();
?>