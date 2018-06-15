<?php
//Nguyen Van Binh
//suongmumc@gmail.com

defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );
$tpl = new TemplatePower($CONFIG['template_dir']."/home.htm");
$tpl->prepare();
$tpl->assignGlobal("dir_path",$dir_path);
	
$Home=new Home;
$Home->adv();
$Home->proHome();


$tpl->printToScreen();

class Home{
	public function adv(){
		global $DB, $tpl, $dir_path,$page;
			$sql = "SELECT * FROM category WHERE active = 1 AND vitri LIKE '%:inhome:%' AND (data_type='logo' OR data_type='news') ORDER BY thu_tu ASC, name ASC";
			$db = $DB->query($sql);
			while($rs = mysql_fetch_array($db)){
				if($rs['data_type'] == 'logo'){
					$tpl->newBlock("homeright");
					$tpl->newBlock("logoleft");
					if($rs['logotitleleft']==1){
						$tpl->newBlock("logotitle");
						$this->advHomeTitle($rs['id_category']);
					}else{
						$tpl->newBlock("logonotitle");
						$this->advHome($rs['id_category']);
					}
				}else if($rs['data_type'] == 'news'){
					$tpl->newBlock("homeright");
					$tpl->newBlock("newsleft");
					$tpl->assign("catname",$rs['name']);
					$tpl->assign("link",$dir_path."/".$rs['url']);
					$this->newsLeft($rs['id_category']);
				}
			}	
	}
	public function newsLeft($idc){
		global $DB, $tpl, $dir_path;
		$sql = "SELECT * FROM news WHERE active=1 AND (id_category IN(".Category::getParentId($idc).") OR groupcat LIKE '%:".$idc.":%') ORDER BY thu_tu DESC, name ASC LIMIT 0,10";
		$db = $DB->query($sql);
		while($rs = mysql_fetch_array($db)){
			  $tpl->newBlock("newslist");	
			  $tpl->assign("newsname",$rs['name']);
			  $tpl->assign("link_detail",$dir_path."/".url_process::getUrlCategory($rs['id_category']).$rs['url']);
		}
		
	}
	public function proHome(){
		global	$DB,$tpl, $dir_path;
		$sql = "SELECT * FROM category WHERE active=1 AND vitri LIKE '%:inhome:%' AND (data_type = 'product' OR data_type = 'info') ORDER BY thu_tu ASC, name ASC" ;
		$db = $DB->query($sql);
		$x = 0;
		while($rs = mysql_fetch_array($db)){
			$x++;
			if($rs['data_type'] == 'product'){
				$tpl->newBlock("productHome");
				$tpl->assign("name",$rs['name']);
				$tpl->assign("link",$dir_path."/".$rs['url']);
				$this->productHome($rs['id_category'])	;
			}
			if($rs['data_type'] == 'info'){
				$tpl->newBlock("infoHome");
				if($x==1){
					$this->infoHome($rs['id_category'],"h1")	;
				}else{
					$this->infoHome($rs['id_category'],"h2")	;
				}
			}
		}
	}
	
	public function advHomeTitle($idc){
		global $DB, $tpl, $dir_path;
		$sql = "SELECT * FROM logo WHERE active=1 AND (id_category IN (".Category::getParentId($idc).") OR groupcat LIKE '%:".$idc.":%') ORDER BY thu_tu DESC, name ASC";
		$db = $DB->query($sql);
		while($rs = mysql_fetch_array($db)){
			$tpl->newBlock("list_logo_title");
			if($rs['image']){
				$tpl->assign("image",'<a href="'.$rs['link'].'" target="'.$rs['target'].'"><img src="'.$dir_path."/image.php?w=138&src=".$rs['image'].'" width="138" alt="'.$rs['name'].'" /></a>')	;
			}else{
				$tpl->assign("image",$rs['comment']);
			}
		}
	}
	public function advHome($idc){
		global $DB, $tpl, $dir_path;
		$sql = "SELECT * FROM logo WHERE active=1 AND (id_category IN (".Category::getParentId($idc).") OR groupcat LIKE '%:".$idc.":%') ORDER BY thu_tu DESC, name ASC";
		$db = $DB->query($sql);
		while($rs = mysql_fetch_array($db)){
			$tpl->newBlock("list_logo_no_title");
			if($rs['image']){
				$tpl->assign("image",'<a href="'.$rs['link'].'" target="'.$rs['target'].'"><img src="'.$dir_path."/image.php?w=155&src=".$rs['image'].'" width="148" alt="'.$rs['name'].'" /></a>')	;
			}else{
				$tpl->assign("image",$rs['comment']);
			}
		}
	}
	
	private function productHome($idc){
		global $DB, $tpl, $dir_path,$SETTING;	
		$sql = "SELECT * FROM product WHERE active = 1 AND (id_category IN(".Category::getParentId($idc).") OR groupcat LIKE '%:".$idc.":%' ) $dk ORDER BY thu_tu DESC, name ASC LIMIT 0,".$SETTING->proinhome;
		
		$db = $DB->query($sql);
		$i=0;
		while($rs = mysql_fetch_array($db)){
			$tpl->newBlock("cell")	;
			$i++;
			if($i==1) $tpl->assign("marginleft0","marginleft0");
			$tpl->assign("name",$rs['name']);
			if($rs['image']){
				$tpl->assign("image",'<img src="'.$dir_path.'/image.php?w=153&h=140&src='.$rs['image'].'"  alt="'.$rs['name'].'" />');
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
			if($i>=5) {
				$i=0;
				$tpl->assign("borderrightnone",'borderrightnone');
			}
			
		}
	}	
	
	private function infoHome($idc,$htags){
		global $DB, $tpl, $dir_path	;
		$idc = intval($idc);
		$sql = "SELECT * FROM info WHERE active = 1 AND (id_category IN(".Category::getParentId($idc).") OR groupcat LIKE '%:".$idc.":%') ORDER BY thu_tu DESC, name ASC LIMIT 0,1";
		$db = $DB->query($sql);
		$tpl->assign("htags",$htags);
		if($rs = mysql_fetch_array($db)){
			
			$tpl->assign("name",$rs['name']);
			$tpl->assign("content",$rs['intro']);
			$tpl->assign("link_detail",$dir_path."/".url_process::getUrlCategory($rs['id_category']).$rs['url']);
			if($rs['image']){
				$tpl->assign("image",'<img src="'.$dir_path.'/image.php?w=180&src='.$rs['image'].'" alt="'.$rs['name'].'" align="left" style="margin-right:10px;" />')	;
			}
		}
	}
	
	
	
	
}

?>