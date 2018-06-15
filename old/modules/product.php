<?php
//Nguyen Van Binh
//suongmumc@gmail.com

defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );
$tpl = new TemplatePower($CONFIG['template_dir']."/product.htm");
$tpl->prepare();
$id 	= intval ($_GET['id']);
if($_GET['idcgr']){
	$idc 	= intval ($_GET['idcgr']);
}else{
	$idc 	= intval ($_GET['idc']);
}
$tpl->assignGlobal("pathpage",Get_Main_Cat_Name_path($idc));

$Product = new Product;
$Product->__contruct();	

$tpl->printToScreen();

class Product{
	private $numberpage = 8;
	private $numberitempage = 15;
	public function __contruct(){
		global $DB, $tpl, $dir_path, $idc, $id;	
		$tpl->assignGlobal("dir_path",$dir_path);
		$catinfo = Category::categoryInfo($idc);
		$tpl->assignGlobal("catname",$catinfo['name']);
		$tpl->assignGlobal("catcontent",$catinfo['content']);
		
		if($id){
			$this->productDetail();
		}else{
			$this->cell();
		}
	}	
	private function cell(){
		global $DB, $tpl, $dir_path, $idc,$imagedir,$SETTING;
		$tpl->newBlock("productCat");
		$keywords = $_GET['keywords'];
		if($keywords){
			$dk = " AND name LIKE '%".$keywords."%' ";
		}
		
		$sql = "SELECT * FROM product WHERE active = 1 AND (id_category IN(".Category::getParentId($idc).") OR groupcat LIKE '%:".$idc.":%' ) $dk ORDER BY thu_tu DESC, name ASC";
		
		$db = paging::pagingFonten($_GET['p'],$dir_path."/".url_process::getUrlCategory($idc),$sql,$this->numberpage,$SETTING->proinpage);
		$i=0;
		while($rs = mysql_fetch_array($db['db'])){
			$tpl->newBlock("cell")	;
			$i++;
			if($i==1) $tpl->assign("marginleft0","marginleft0");
			$tpl->assign("name",$rs['name']);
			if($rs['image']){
				$tpl->assign("image",'<img src="'.$dir_path.'/image.php?w=190&h=180&src='.$rs['image'].'"  alt="'.$rs['name'].'" />');
			}
			if(intval($rs['price'])>0){
				$tpl->assign('price',@number_format($rs['price']));
			}else{
            	$tpl->assign('price',$rs['price']);
			}
			$tpl->assign("link_detail",$dir_path."/".url_process::getUrlCategory($rs['id_category']).$rs['url']);
			if($rs['icon'] == 'hot'){
				$tpl->assign("icon",'<div class="hot"></div>')	;
			}
			if($rs['icon'] == 'new'){
				$tpl->assign("icon",'<div class="new"></div>')	;
			}
			if($rs['icon'] == 'sales'){
				$tpl->assign("icon",'<div class="sale"></div>')	;
			}
			if($i>=4) {
				$i=0;
				$tpl->assign("borderleftnone",'borderleftnone');
			}
			
		}
			$tpl->assign("productCat.pages",$db['pages']);
			
	}
	private function productDetail(){
		global $DB, $tpl, $dir_path, $idc, $id,$imagedir,$SETTING;	
		$tpl->newBlock("productDetail");
		$tpl->assignGlobal("linkcat",$dir_path."/".url_process::getUrlCategory($idc));
		$sql = "SELECT * FROM product WHERE id_product = $id";
		$db = $DB->query($sql);
		if($rs = mysql_fetch_array($db)){
			$tpl->assign("name",$rs['name']);
			$tpl->assign("intro",$rs['intro']);
			if(intval($rs['price']>0)){
                if(intval($rs['pricekm'])>0){
                    $tpl->assign('pricekm','<div class="proAttribute">Giá: <s>'.number_format($rs['price'])." ".$rs['don_vi'].'</s></div>');
                    $tpl->assign('price','<div class="proAttribute">Giá: <span class="productPriceDetail">'.number_format($rs['price'])." ".$rs['don_vi'].'</span></div>');
                }else{
                    $tpl->assign('price','<div class="proAttribute">Giá: <span class="productPriceDetail">'.number_format($rs['price'])." ".$rs['don_vi'].'</span></div>');
                }
            }else{
                $tpl->assign('price','<div class="pricedetail"  style="text-align:left">'.$rs['price'].'</div>');
            }
			$tpl->assign("ma",$rs['ma']);
			$tpl->assignGlobal("id_product",$rs['id_product']);
			if($rs['status'] == 1) $tpl->assign("status","Còn hàng");
			$tpl->assign("content",$rs['content']);
			$tpl->assign("phonesupport",$SETTING->phonesupport);
			if($rs['image']){
				$tpl->assign("image",'<img src="'.$dir_path.'/image.php?w=380&h=380&src='.$rs['image'].'" alt="'.$rs['name'].'" />');	
				$tpl->assign("bigimage",$rs['image']);
			}
			if($rs['tab2']){
				$tpl->assign("tab2",'<li rel="#tabdetail2">'.$rs['tab2'].'</li>');
				$tpl->assign("tab2content",'<div class="contentTab" id="tabdetail2">'.$rs['tab2content'].'</div>');
			}
			if($rs['tab3']){
				$tpl->assign("tab3",'<li rel="#tabdetail3">'.$rs['tab3'].'</li>');
				$tpl->assign("tab3content",'<div class="contentTab" id="tabdetail3">'.$rs['tab3content'].'</div>');
			}
			if($rs['tab4']){
				$tpl->assign("tab4",'<li rel="#tabdetail4">'.$rs['tab4'].'</li>');
				$tpl->assign("tab4content",'<div class="contentTab" id="tabdetail4">'.$rs['tab4content'].'</div>');
			}
			
			$tpl->assign("linkcart",$dir_path."/".'addcart/'.clean_url($rs['name']).'_'.$rs['id_product'].'.html');
			$tpl->assign("attr",$this->getAttr($rs['attr'],$rs['id_category']));
			// other image
			$sqlx = "SELECT * FROM image_product WHERE id_product = $id";
			$dbx = $DB->query($sqlx);
			$i=0;
			while($rsx = mysql_fetch_array($dbx)){
				$tpl->newBlock("otherimage");
				$i++;
				if($i%5==0) $tpl->assign("marginleft0","marginleft0");
				$tpl->assign("thumb",'<img src="'.$dir_path.'/image.php?w=75&h=54&src='.$imagedir.$rsx['image'].'" alt="'.$rsx['name'].'" />');
				$tpl->assign("bigimage",$dir_path.'/image.php?w=380&h=380&src='.$imagedir.$rsx['image']);
			}
			$this->otherProduct($rs['phukien']);
			
		}
	}
	
	public function otherProduct($phuk){
		global $DB, $tpl, $dir_path;	
		$id = intval($id); 
		$idc = intval($idc);
		
		$phukien = json_decode($phuk);	
		if($phukien){
			foreach($phukien as $pk){
				$sql = "SELECT * FROM product WHERE active=1 AND id_product = ".intval($pk)." ORDER BY thu_tu DESC, name ASC";
				$db = $DB->query($sql);
				if($rs = mysql_fetch_array($db)){
		  			$tpl->newBlock("cell1")	;
		  			$i++;
		  			if($i==1) $tpl->assign("noneborderleft","noneborderleft");
		  			$tpl->assign("name1",$rs['name']);
		  			if($rs['image']){
		  				$tpl->assign("image1",'<img src="'.$dir_path.'/image.php?w=190&h=180&src='.$rs['image'].'"  alt="'.$rs['name'].'" />');
		  			}
		  			if(intval($rs['price'])>0){
		  				$tpl->assign('price',@number_format($rs['price']));
		  			}else{
		              	$tpl->assign('price',$rs['price']);
		  			}
		  			$tpl->assign("link_detail1",$dir_path."/".url_process::getUrlCategory($rs['id_category']).$rs['url']);
		  			if($rs['icon'] == 'hot'){
		  				$tpl->assign("icon",'<div class="hot"></div>')	;
		  			}
		  			if($rs['icon'] == 'new'){
		  				$tpl->assign("icon",'<div class="new"></div>')	;
		  			}
		  			if($rs['icon'] == 'sales'){
		  				$tpl->assign("icon",'<div class="sale"></div>')	;
		  			}
		  			if($i>=4) {
		  				$i=0;
		  				$tpl->assign("borderleftnone",'borderleftnone');
		  			}
				}
			}
		}
		
	}
	private function getAttr($json,$idc){
		global $DB, $tpl;
		$idc = intval($idc);
		$attribute = json_decode($json);	
		$sql = "SELECT * FROM category WHERE id_category = $idc";
		$db = $DB -> query($sql);
		if($rs = mysql_fetch_array($db)){
			$sql1 = "SELECT g.*,p.name AS attrName, p.default_value AS defaultvalue, alias_name AS alias_name FROM group_attribute AS g LEFT JOIN pro_attribute AS p ON(g.id_attr = p.id) WHERE g.id_group = ".intval($rs['id_attr'])." ORDER BY g.thu_tu ASC,p.name";
			$str ='';
			$db1= $DB->query($sql1);
			while($rs1 = mysql_fetch_array($db1)){
				if($rs1['attrName']){
					if($attribute)
						$str.= '<div class="proAttribute">'.$rs1['attrName'].': '.$attribute->$rs1['alias_name'].'</div>
	        			<div class="lineAttri"></div>';
						
				}
			}
		}
		return $str;
	}
}

?>