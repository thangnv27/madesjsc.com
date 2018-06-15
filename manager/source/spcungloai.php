<?php
defined('_VALID_NVB') or die('Direct Access to this location is not allowed.');

$lstId = $_GET['lstId'];
if($lstId!=''){
	$lst=array();
	$lst = explode(",",$lstId);
	$lid = 0;
	foreach($lst as $id){
		$lid.=",".intval($id);
	}
	
	$sql = "SELECT * FROM product WHERE id_product IN(".$lid.")";
	$db = $DB->query($sql);
	$str='';
	$i=0;
	while($rs = mysql_fetch_array($db)){
		$i++;
		$str.='<div>'.$i.'. <a href="'.$site_address.$dir_path.'/'.url_process::getUrlCategory($rs['id_category']).$rs['url'].'" target="_blank" >ID:'.$rs['id_product'].' - '.$rs['name'].'</a></div>';
	}
	echo $str;
}
?>