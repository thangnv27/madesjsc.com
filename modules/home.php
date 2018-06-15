<?php

//Nguyen Van Binh
//suongmumc@gmail.com
//error_reporting(E_ALL);
defined('_VALID_NVB') or die('Direct Access to this location is not allowed.');

$tpl = new TemplatePower($CONFIG['template_dir'] . "/home.htm");
$tpl->prepare();

$tpl->assignGlobal("dir_path", $dir_path);
 langsite();
include_once("modules/slidehome.php");
	$tpl->assign("slideshow",slideshow());
include_once("modules/db.provider/db.menu.php");
$dbHome = new dbMenu;
$objProduct = new dbProduct();
$home = new clsHome;


$tpl->printToScreen();

class clsHome{
	function __construct(){
		global $DB, $idc, $tpl,$dir_path,$cache_image_path,$SETTING,$dbHome;	
		
		
		
		$db = $dbHome->selectByLocation('cathome','logoscrollhome');
		$i=0;
		
		
		foreach($db as $rs){
			if($rs['id_category'] > 0)	{
				
							
				if($rs['data_type'] == 'logo'){
					$tpl->newBlock("home");
					$this->advHome($rs['id_category']);
					
				}
				if($rs['data_type'] == 'info'){
					$tpl->newBlock("home");
					$tpl->newBlock("info");
					$this->infoHome($rs['id_category']);
				}
				
				if($rs['data_type'] == 'news'){
					$tpl->newBlock("home");
					$tpl->newBlock("news");
					$tpl->assign("catname",$rs['name']);
					$tpl->assign("link",$dir_path.'/'.$rs['url']);
					$this->newsHome($rs['id_category']);
				}
				if($rs['data_type'] == 'product'){
					$tpl->newBlock("home");
					$tpl->newBlock("productHome");
					$tpl->assign("catname",$rs['name']);
					$tpl->assign("link",$dir_path.'/'.$rs['url']);
					$this->proHome($rs['id_category']);
				}
				
				if($rs['data_type'] == 'video'){
					
					$tpl->newBlock("video");
					$tpl->assign("catname",$rs['name']);
					$tpl->assign("link",$dir_path.'/'.$rs['url']);
					$this->videoHome($rs['id_category']);
				}
				
			}
		}
	}	
	

	
	function LogoScrollHome($idCat){
		global $DB,  $tpl,$dir_path,$cache_image_path,$SETTING,$logo;		
		$idCat = intval($idCat);
		$db = $logo->logoList($idCat);
		foreach($db as $rs){
			if($rs['id_logo']>0){
				$tpl->newBlock("list_lg");
				if($rs['image']){
					$tpl->assign("image",'<a href="'.$rs['link'].'" target="'.$rs['target'].'"><img src="'.$cache_image_path.resizeimage(105,50,$dir_path.'/'.$rs['image']).'" width="105" height="50" alt="'.$rs['name'].'"></a>');
				}
			}
		}
	}
	

	private function infoHome($idCat){
		global $DB,  $tpl,$dir_path,$cache_image_path,$SETTING;	
		include_once('db.provider/db.info.php');
		$info = new dbInfo;
		$idCat = intval($idCat);
		$db = $info->itemList($idCat,1);
		foreach($db as $rs){
			if($rs['id_info'] > 0){
				$tpl->newBlock("info_home");
				$tpl->assign(array(
					name => $rs['name'],
					intro => $rs['intro']
					)
				);
				$tpl->assign("link_detail",	$dir_path.'/'. url_process::getUrlCategory($rs['id_category']).$rs['url']);
			}
		}
	}
	
	
	function videoHome($idc){
		global $DB,$tpl,$dir_path,$cache_image_path;	
		$idc = intval($idc);
		$sql = "SELECT * FROM video WHERE active=1 AND (id_category IN(".Category::getParentId($idc).") OR  groupcat IN(".$idc.")) ORDER BY thu_tu DESC, name ASC LIMIT 2";
		$db = $DB->query($sql);
		$n=0;
		while($rs =mysql_fetch_array($db)){
			
			$parse = parse_url($rs['video']);
			$n++;
		
				$tpl->newBlock("videohome");
				$tpl->assign("name",$rs['name']);
				if($parse['host'] == 'youtube.com' || $parse['host'] == 'www.youtube.com'){
					$tpl->assign("video",$rs['video']);
					$tpl->assign("image",'<img atl="'.$rs['name'].'" src="http://img.youtube.com/vi/'.getVideoCode($rs['video']).'/0.jpg"'.' width="100%" height="163"/>');	
				}else{
					$tpl->assign("video",$dir_path.'/'.$rs['video']);
					$tpl->assign("image",'<img atl="'.$rs['name'].'" src="'.$cache_image_path.resizeimage(310,226,$dir_path.'/'.$rs['image']).'" width="100%" height="163px" />');
				}
		
			$tpl->assign("link_detail",	$dir_path.'/'. url_process::getUrlCategory($rs['id_category']).$rs['url']);
		}
	}
	
	
	function newsHome($idc){
		global $DB, $tpl,$dir_path,$cache_image_path,$lang,$SETTING;
		$idc = intval($idc);
		$sql = "SELECT * FROM news WHERE active=1 AND (id_category IN(".Category::getParentId($idc).") OR groupcat LIKE '%:".$idc.":%') ORDER BY thu_tu DESC, id_news DESC LIMIT ".$SETTING->newshome;
		$db = $DB->query($sql);
		$i=0;
		while($rs = mysql_fetch_array($db)){
			$tpl->newBlock("newshome");
			$i++;
			$tpl->assign("name",$rs['name']);
			$tpl->assign("intro",strip_tags($rs['intro']));
			if($rs['image']){
				$tpl->assign("image",'<img src="'.$cache_image_path.cropimage(370,230,$dir_path.'/'.$rs['image']).'" width="100%" alt="'.$rs['name'].'">');
			}
			
			$tpl->assign("link_detail",$dir_path.'/'.url_process::getUrlCategory($rs['id_category']).$rs['url']);
			if($i%3==0){
				 $tpl->assign("pc_break",'<div class="c20 pc-break"></div>');
			}
			
		}
		
	}
	function photoHome($idc){
		global $DB, $tpl, $dir_path, $cache_image_path;
		$sql = "SELECT * FROM photo WHERE active=1 AND (id_category IN(".Category::getParentId($idc).")) ORDER BY thu_tu ASC, name ASC LIMIT 10";	
		$db = $DB->query($sql);
		while($rs = mysql_fetch_array($db)){
			$tpl->newBlock("list_photo");
			$tpl->assign("name",$rs['name']);
			$tpl->assign("link",$dir_path.'/'.$rs['url']);
			if($rs['image']){
				$tpl->assign("image",'<img src="'.$cache_image_path.cropimage(315,205,$dir_path.'/'.$rs['image']).'" width="100%" alt="'.$rs['name'].'" >');
			}
		}
	}
	
	function advHome($idc){

		global $DB, $tpl,$cache_image_path,$dir_path;
		$idc = intval($idc);
		$lg = new dbLogo;
		$dblg = $lg->logoList($idc);
		foreach($dblg as $rs){
			$tpl->newBlock("advHome");
			if($rs['image']){
			$tpl->assign("image",'<a href="'.$rs['link'].'" target="'.$rs['target'].'"><img src="'.$cache_image_path.resizeimage(820,600,$dir_path.'/'.$rs['image']).'" width="100%" alt="'.$rs['name'].'"></a>');
			}else{
				$tpl->assign("image",$rs['comment']);
			}
		}
	}
	
	
	function proHome($idc){
		global $DB, $tpl,$cache_image_path,$dir_path,$SETTING;
		$idc = intval($idc);
		$pro = new dbProduct;
		$db = $pro->itemList($idc,intval($SETTING->producthome),$filter,$orderby );
		$i = 0;
		foreach($db as $rs){
			if($rs['id_product'] > 0)	{
				$i++;
				$tpl->newBlock("products");

				$tpl->assign("name",$rs['name']);
				if($rs['icon']){
					$tpl->assign("km",'<div class="'.$rs['icon'].'">'.$rs['texticon'].'</div>')	;
				}
				
				if(intval($rs['pricekm'])>0){
					$tpl->assign("price","Giá KM: ".number_format($rs['pricekm']).' đ');
					$tpl->assign("pricekm","Giá: ".number_format($rs['price']).' đ');	
				}else{
					if(intval($rs['price']) > 0){
						$tpl->assign("price","Giá: ".number_format($rs['price']).' đ');
					}else{
						$tpl->assign("price",$rs['price']);	
					}
				}
  
				if($rs['image']){
					$tpl->assign("image",'<img src="'.$cache_image_path.cropimage(250,250,$dir_path.'/'.$rs['image']).'" alt="'.$rs['name'].'" width="100%">')	;
				}
				if($rs['icon']){
					$tpl->assign("icon",'<div class="'.$rs['icon'].'">'.$rs['texticon'].'</div>')	;
				}
				$tpl->assign("ttkhuyenmai", strstrim(strip_tags($rs['ttkhuyenmai']),20));
				//$tpl->assign("attribute",$objProduct->getAttr(intval($rs['id_category']),$rs['attr']));
				//$tpl->assign("link_detail",$clsUrl->getUrl('product',$rs['id_category'],$rs['id_product']));
				$tpl->assign("link_detail",	$dir_path.'/'. url_process::getUrlCategory($rs['id_category']).$rs['url']);
				if($i%4==0){
					 $tpl->assign("pc_break",'<div class="c20 pc-break"></div>');
				}
				if($i%3==0){
					 $tpl->assign("pc_break_30",'<div class="c20 mobile-break-30"></div>');
				}
				if($i%2==0){
					 $tpl->assign("pc_break_50",'<div class="c20 pc-break-50"></div>');
				}
			}	
		}
	}
	
}


?>