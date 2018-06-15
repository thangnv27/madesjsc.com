<?php
defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );
$id = intval($_GET['id']);
$idg = intval($_GET['idg']);
if($_GET['code']=='delete_attr_in_group'){
	$DB->query("DELETE FROM group_attribute WHERE id_group=$idg AND id_attr=$id");
}

if($_GET['code'] == 'deletegroup'){
	$DB->query("DELETE FROM group_attribute WHERE id_group=$id");
	$DB->query("DELETE FROM group_attr WHERE id_group=$id");
}
if($_GET['code'] == 'delete'){
	$DB->query("DELETE FROM group_attribute WHERE id_attr=$id");
	$DB->query("DELETE FROM pro_attribute WHERE id=$id");
}

if($_GET['code'] == 'listGroupAttr'){
	$tpl=new TemplatePower("skin/excu_attr.htm");
	$tpl->prepare();
	$tpl->newBlock("new_list_group");
	$sql = "SELECT * FROM group_attr ORDER BY name ASC"	;
	$db = $DB->query($sql);
	while($rs = mysql_fetch_array($db)){
		$tpl->newBlock("list_group");
		$tpl->assign("name",$rs['name']);
		$tpl->assign("id_group",$rs['id_group']);
		if(!$id){
		  	if($rs['setdefault']==1) $tpl->assign("checked","checked");
		}
		if($rs['id_group'] == $id) $tpl->assign("checked","checked");
		
	}
	$tpl->printToScreen();
}
/*if($_GET['code'] == 'listGroupAttr'){
	$tpl=new TemplatePower("skin/excu_attr.htm");
	$tpl->prepare();
	$tpl->newBlock("new_list_group");
	$sql = "SELECT * FROM group_attr ORDER BY name ASC"	;
	$db = $DB->query($sql);
	while($rs = mysql_fetch_array($db)){
		$tpl->newBlock("list_group");
		$tpl->assign("name",$rs['name']);
		$tpl->assign("id_group",$rs['id_group']);
		if(!$id){
		  	if($rs['setdefault']==1) $tpl->assign("checked","checked");
		}
		if($rs['id_group'] == $id) $tpl->assign("checked","checked");
		
	}
	$tpl->printToScreen();
}*/
if($_GET['code'] == 'loadAttr'){
	$idpro = intval($_GET['idpro']);
	getAttribute($id,$idpro);
}


function getAttribute($idc,$id=0){
	global $DB,$tpl;
	
	if($id){
		$ok=true;
		$sql = "SELECT * FROM product WHERE id_product = $id";
		$db = $DB->query($sql);
		if($rs = mysql_fetch_array($db)){
			$attribute = json_decode($rs['attr']);	
		}
	}else{
		$ok=false;
	}
	$tpl=new TemplatePower("skin/excu_attr.tpl");
	$tpl->prepare();
	$tpl->newBlock("new_list_attribute");
	$sql = "SELECT * FROM category WHERE id_category = $idc";
	$db = $DB -> query($sql);
	if($rs = mysql_fetch_array($db)){
		$sql1 = "SELECT g.*,p.name AS attrName, p.default_value AS defaultvalue, alias_name AS alias_name,p.id FROM group_attribute AS g LEFT JOIN pro_attribute AS p ON(g.id_attr = p.id) WHERE g.id_group = ".intval($rs['id_attr'])." ORDER BY g.thu_tu ASC,p.name";
		$str ='';
		$db1= $DB->query($sql1);
		while($rs1 = mysql_fetch_array($db1)){
			if($rs1['attrName']){
				$tpl->newBlock("list_attribute");
				$tpl->assign("attrname",$rs1['attrName']);
				$tpl->assign("alias_name",$rs1['alias_name']);
				$tpl->assign("id_attr",$rs1['id_attr']);
				if($ok){
					if($attribute)
						$tpl->assign("defaultvalue",$attribute->$rs1['id_attr']);
				}else{
					$tpl->assign("defaultvalue",$rs1['defaultvalue']);
				}
			}
		}
	}
	$tpl->printToScreen();
	
}

?>