<?php
//Nguyen Van Binh
//suongmumc@gmail.com

defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );
$tpl = new TemplatePower($CONFIG['template_dir']."/header.htm");
$tpl->prepare();
$idc = intval($_GET['idc']);
$id = intval($_GET['id']);
$tpl->assignGlobal("dir_path",$dir_path);
$getUrl = new url_process;
$uri=$_SERVER['REQUEST_URI'];
$cate = $getUrl->Url_Type($uri);
$meta=$getUrl->get_meta_item($cate['data_type']);
if($cate['keyword']){
	$tpl->assign("site_keyword",$cate['keyword']);
}else{
	$tpl->assign("site_keyword",$CONFIG['site_keywords']);	
}
if(intval($_GET['p'])>1){
	$ptitle=' - trang '.intval($_GET['p'])	;
}

if($page=='home' || $page==''){
	$sql1="SELECT * FROM category WHERE data_type='home' ";
	$db1=$DB->query($sql1);
	if($rs1=mysql_fetch_array($db1)){
		if($rs1['title']){
			$tpl->assignGlobal("site_name",$rs1['title'].$ptitle);
		}else{
			$tpl->assignGlobal("site_name",$rs1['name'].$ptitle);
		}
		if($rs1['description']){
			$tpl->assignGlobal("site_description",$rs1['description'].$ptitle);	
		}else{
			$tpl->assignGlobal("site_description",$CONFIG['site_name'].$ptitle);	
		}
		if($rs1['keyword']){
	  		$tpl->assignGlobal("site_keywords",$rs1['keyword'].$ptitle);	
	  	}else{
	  		$tpl->assignGlobal("site_keywords",$CONFIG['site_keywords'].$ptitle);	
	  	}
	}
}elseif($page=='search'){
		$tpl->assignGlobal("site_name",$keywords." - ".$CONFIG['site_name'].$p1title);
}else{
	if($meta['title']){
		$tpl->assignGlobal("site_name",$meta['title'].$ptitle);
	}else{
		$tpl->assignGlobal("site_name",$CONFIG['site_name'].$ptitle);
	}
	if($meta['description']){
		$tpl->assignGlobal("site_description",$meta['description'].$ptitle);	
	}else{
		$tpl->assignGlobal("site_description",$CONFIG['site_description'].$ptitle);	
	}
	if($meta['keyword']){
		$tpl->assignGlobal("site_keywords",$meta['keyword'].$ptitle);	
	}else{
		$tpl->assignGlobal("site_keywords",$CONFIG['site_keywords'].$ptitle);	
	}
}
$tpl->assignGlobal("hotline",$SETTING->hotline);
$hd = new Header;
$hd->__contruct();	
$hd->Banner();
$topa=array('&#39;');
$topb=array("'");
$tpl->assignGlobal('toppage',str_replace($topa, $topb, $CONFIG['toppage']));
$tpl->printToScreen();

include("modules/leftcol.php");
include("modules/menubar.php");

class Header{
  	public function __contruct(){
		global $DB, $tpl, $dir_path;
		$this->menuTop();
		
	
		
		$sql = "SELECT * FROM category WHERE active=1 AND vitri LIKE '%:left:%' ORDER BY thu_tu ASC, name ASC";
		$db = $DB->query($sql);
		while($rs = mysql_fetch_array($db)){
			
			if($rs['data_type'] == 'support'){
				$tpl->newBlock("left");
				$tpl->newBlock("support");	
				$tpl->assign("name",$rs['name']);
				$this->boxSupport();	
			}
			if($rs['data_type'] == 'logo'){
				$tpl->newBlock("left");
				$tpl->newBlock("advleft");	
				$this->advLeft($rs['id_category']);
			}
			if($rs['data_type'] == 'news'){
				$tpl->newBlock("left");
				$tpl->newBlock("news");
				$tpl->assign("name",$rs['name']);
				$tpl->assign("link",url_process::builUrl($rs['id_category']));
				$this->News($rs['id_category']);
			}
			if($rs['data_type'] == 'product'){
				$tpl->newBlock("left");
				$tpl->newBlock("product");
				$tpl->assign("name",$rs['name']);
				$tpl->assign("link",url_process::builUrl($rs['id_category']));
				$this->Product($rs['id_category']);
			}
		}
		
	}	
	
	private function menuTop(){
		global $DB, $tpl, $dir_path,$idc;
		$sql = "SELECT * FROM category WHERE active=1 AND vitri LIKE '%:menutop:%' ORDER BY thu_tu ASC, name ASC";
		$db = $DB->query($sql);
		$i=0;
		$ar = Get_Id_Cat_Back($idc);
		while($rs = mysql_fetch_array($db)){
			$i++;
			$tpl->newBlock("menutop");
			$tpl->assign("name",$rs['name']);
			if($i > 1) $tpl->assign("line","|");
			$tpl->assign("link",url_process::builUrl($rs['id_category']));
			if(in_array($rs['id_category'],$arr)){
				$tpl->assign("current","current");
			}
			
		}
	}
	
	
	
	private function boxSupport(){
		global $DB, $tpl , $idc;	
		$sql = "SELECT * FROM yahoo WHERE active=1 ORDER BY thu_tu DESC, name ASC";
		$db = $DB->query($sql);
		while($rs = mysql_fetch_array($db)){
			$tpl->newBlock("list_support");
			$tpl->assign("name",$rs['name']);
			if($rs['nic']){
				$tpl->assign("yahoo",'<div style="float:left; margin-right:5px;"><a href="ymsgr:SendIM?'.$rs['nic'].'" rel="nofollow"><img src="http://opi.yahoo.com/online?u='.$rs['nic'].'&amp;m=g&amp;t=1&amp;l=us" alt="'.$rs['name'].'"></a></div>');
			}
			if($rs['sky']){
				$tpl->assign("sky",'<div style="float:left;margin-right:5px;"><a href="skype:'.$rs['sky'].'?chat"><img border="0" alt="'.$rs['name'].'" src="http://mystatus.skype.com/smallicon/'.$rs['sky'].'"></a></div>');	
			}
		}
	}
	
	private function advLeft($idc){
		global $DB, $tpl,$dir_path;	
		$idc = intval($idc);
		$sql = "SELECT * FROM logo WHERE active=1 AND (id_category IN(".Category::getParentId($idc).") OR groupcat LIKE '%:".$idc.":%') ORDER BY thu_tu DESC, name ASC";
		$db = $DB->query($sql);
		while($rs = mysql_fetch_array($db)){
			
			if($rs['image']){
				$tpl->assign("image",'<a href="'.$rs['link'].'" target="'.$rs['target'].'"><img src="'.$dir_path."/image.php?w=240&src=".$rs['image'].'" alt="'.$rs['name'].'" /></a>');
			}else{
				$tpl->assign("image",$rs['comment']);
			}
		}
	}
	
	private function News($idc){
		global $DB, $tpl,$dir_path;	
		$idc = intval($idc);
		$sql = "SELECT * FROM news WHERE active=1 AND (id_category IN(".Category::getParentId($idc).") OR groupcat LIKE '%:".$idc.":%') ORDER BY thu_tu DESC, name ASC";
		$db = $DB->query($sql);
		while($rs = mysql_fetch_array($db)){
			$tpl->newBlock("listNews");
			$tpl->assign("name1",$rs['name']);
			if($rs['image']){
				$tpl->assign("image",'<img src="'.$dir_path.'/image.php?w=60&src='.$rs['image'].'" class="imagenewsleft" />')	;
			}
			$tpl->assign("link_detail",url_process::builUrlArticle($rs['id_news'],$rs['id_category']));
		}
	}
	private function Product($idc){
		global $DB, $tpl,$dir_path;	
		$idc = intval($idc);
		$sql = "SELECT * FROM product WHERE active=1 AND (id_category IN(".Category::getParentId($idc).") OR groupcat LIKE '%:".$idc.":%') ORDER BY thu_tu DESC, name ASC";
		$db = $DB->query($sql);
		while($rs = mysql_fetch_array($db)){
			$tpl->newBlock("listProduct");
			$tpl->assign("name1",$rs['name']);
			if($rs['image']){
				$tpl->assign("image",'<img src="'.$dir_path.'/image.php?w=60&src='.$rs['image'].'" class="imagenewsleft" />')	;
			}
			$tpl->assign("link_detail",url_process::builUrlArticle($rs['id_product'],$rs['id_category']));
			$tpl->assign('price',$rs['price']);
		}
	}
	
	public function Banner(){
		global $DB, $tpl,$dir_path;	
		$sql1 = "SELECT * FROM category WHERE active=1 AND vitri LIKE '%:logo:%' ORDER BY thu_tu ASC, name ASC LIMIT 0,1";
		$db1 = $DB->query($sql1);
		if($rs1= mysql_fetch_array($db1)){
			$sql = "SELECT * FROM logo WHERE active=1 AND (id_category IN(".Category::getParentId($rs1['id_category']).") OR groupcat LIKE '%:".$rs1['id_category'].":%') ORDER BY thu_tu DESC, name ASC";
			$db = $DB->query($sql);
			if($rs = mysql_fetch_array($db)){
				
				$tpl->assignGlobal("logosite",'<a href="'.$rs['link'].'"><img src="'.$dir_path."/image.php?h=119&src=".$rs['image'].'" alt="'.$rs['name'].'" /></a>');
			}	
		}

	}
}
?>