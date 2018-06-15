<?php
//Nguyen Van Binh
//suongmumc@gmail.com
defined('_VALID_NVB') or die('Direct Access to this location is not allowed.');
function spnoibat(){

	global $DB, $dir_path, $cache_image_path, $CONFIG, $logo,$clsUrl;
    $tpl1 = new TemplatePower("templates/spnoibat.htm");
    $tpl1->prepare();
	
	$sql = "SELECT * FROM category WHERE active=1 AND vitri LIKE '%:showincatpro:%' ORDER BY thu_tu ASC, name ASC";
	$db = $DB->query($sql);
	while($rs = mysql_fetch_array($db)){
		$tpl1->newBlock("spnoibat");
		$tpl1->assign("id",$rs['id_category']);
		$tpl1->assign("name",$rs['name']);
		proCat($rs['id_category'],$tpl1);
	}
	
    return $tpl1->getOutputContent();

}


function proCat($idc,$tpl){
		global $DB,  $objProduct,$dir_path,$cache_image_path,$SETTING,$clsUrl;	

		
		$db = $objProduct->itemList($idc,15 );
		$i = 0;
		foreach($db as $rs){
			if($rs['id_product'] > 0)	{
				$i++;
				$tpl->newBlock("products");
				if($i==1) $tpl->assign("marginleft0","marginleft0");
				$tpl->assign("name",$rs['name']);
				if($rs['km'] > 0){
					$tpl->assign("km",'<div class="icon-off">'.$rs['km'].'%</div>');
				}
				$price = $objProduct -> getSizePriceDefault($rs['size_price'],$rs['km']);
				if($price['pricekm'] > 0){
					$tpl->assign("price",'<div class="price-ny"><s>Giá NY: '.$price['price'].' VND</s></div><div class="price">Giá KM: '.$price['pricekm'].' VND</div>');
					
				}else{
					$tpl->assign("price",'<div class="price">Giá: '.$price['price'].' VND</div>');
				}
				 
  
				if($rs['image']){
					$tpl->assign("image",'<img src="'.$cache_image_path.resizeimage(200,150,$dir_path.'/'.$rs['image']).'" alt="'.$rs['name'].'">')	;
				}
				if($rs['icon']){
					$tpl->assign("icon",'<div class="'.$rs['icon'].'">'.$rs['texticon'].'</div>')	;
				}
				$tpl->assign("ttkhuyenmai", strstrim(strip_tags($rs['ttkhuyenmai']),10));
				$tpl->assign("attribute",$objProduct->getAttr(intval($rs['id_category']),$rs['attr']));
				$tpl->assign("link_detail",	$dir_path.'/'. url_process::getUrlCategory($rs['id_category']).$rs['url']);
				if($i>=5){
					 $i=0;
					 $tpl->assign("br",'<div class="c20"></div>');
				}
			}	
		}
	}
?>