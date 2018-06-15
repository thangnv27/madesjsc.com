<?php
//Nguyen Van Binh
//suongmumc@gmail.com

defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );
$tpl = new TemplatePower($CONFIG['template_dir']."/news.htm");
$tpl->prepare();
$id 	= intval ($_GET['id']);
$idc 	= intval ($_GET['idc']);

$tpl->assignGlobal("pathpage",Get_Main_Cat_Name_path($idc));

$info = new News;
$info -> _int();	

$tpl->printToScreen();

class News{
	private $numberItemPage = 8;
	private $numberItemOnPage = 6;
	public function _int(){
		global $idc,$id,$tpl;
		$catinfo = Category::categoryInfo($idc);
		$tpl->assignGlobal("catname",$catinfo['name']);
		$tpl->assignGlobal("catcontent",$catinfo['content']);
		if($id){
			$this->detailNews($id,$idc);
		}else{
			$this->listNews($idc);
		}
	}
	
	private function listNews($idc){
		global $DB, $tpl, $lang, $dir_lang, $dir_path,$SETTING;
		$idc = intval($idc);
		$tpl->newBlock("news");
		$sql = "SELECT * FROM news WHERE active=1 AND (id_category IN(".Category::getParentId($idc).") OR groupcat LIKE '%:".$idc.":%') ORDER BY thu_tu DESC, id_news ASC";
		$db = paging::pagingFonten($_GET['p'],$dir_path."/".url_process::getUrlCategory($idc),$sql,$this->numberItemPage,$SETTING->newsinpage);
		while($rs = mysql_fetch_array($db['db'])){
			$tpl->newBlock("list_news");
			
			$tpl->assign("name",$rs['name']);
			$tpl->assign("intro",$rs['intro']);
			if($rs['showdate']==1)
			$tpl->assign("createdate",'<div class="createdate">'.date('d/m/Y H:i', $rs['ngay_dang']).'</div>');
			if($rs['image']){
				$tpl->assign("image",'<img src="'.$dir_path.'/image.php?w=180&src='.$rs['image'].'" class="imagenews" alt="'.$rs['name'].'" />');
			}
			$tpl->assign("link_detail",url_process::builUrlArticle($rs['id_news'],$rs['id_category']));
		}
		$tpl->assignGlobal("pages",$db['pages']);
	}
	
	
	private function detailNews($id,$idc){
		global $DB, $tpl, $lang, $dir_lang, $dir_path;
		$idc = intval($idc);
		$idc = intval($id);
		$tpl->newBlock("detailNews");
		$sql = "SELECT * FROM news WHERE active=1 AND id_news = $id";
		$db = $DB->query($sql);
		if($rs = mysql_fetch_array($db)){
			$tpl->assign("name",$rs['name']);
			$tpl->assign("intro",$rs['intro']);
			$tpl->assign("content",$rs['content']);
			if($rs['showdate']==1)
			$tpl->assign("createdate",'<div class="createdate">'.date('d/m/Y H:i', $rs['ngay_dang']).'</div>');
			$this->otherArticle_new($rs['id_news'],$rs['id_category']);
			$this->otherArticle_old($rs['id_news'],$rs['id_category']);
		}
	}
	
	private function otherArticle_new($id,$idc){
		global $DB, $tpl, $dir_path;	
		$idc = intval($idc); $id = intval($id);
		$sql = "SELECT * FROM news WHERE active = 1 AND  (id_category IN(".Category::getParentId($idc).") OR groupcat LIKE '%:".$idc.":%') AND id_news > $id  ORDER BY id_news DESC LIMIT 0,5";
		$db = $DB->query($sql);
		while($rs = mysql_fetch_array($db)){
			$tpl->newBlock("newest");
			$tpl->assign("name",$rs['name']);
			$tpl->assign("link_detail",url_process::builUrlArticle($rs['id_news'],$rs['id_category']));
			if($rs['showdate']==1)
			$tpl->assign("createdate",'&nbsp;<span class="createdate">('.date('d/m/Y H:i', $rs['ngay_dang']).')</span>');
		}
	}
	private function otherArticle_old($id,$idc){
		global $DB, $tpl, $dir_path;	
		$idc = intval($idc); $id = intval($id);
		$sql = "SELECT * FROM news WHERE active = 1 AND  (id_category IN(".Category::getParentId($idc).") OR groupcat LIKE '%:".$idc.":%') AND id_news < $id  ORDER BY id_news DESC LIMIT 0,10";
		$db = $DB->query($sql);
		while($rs = mysql_fetch_array($db)){
			$tpl->newBlock("older");
			$tpl->assign("name",$rs['name']);
			$tpl->assign("link_detail",url_process::builUrlArticle($rs['id_news'],$rs['id_category']));
			if($rs['showdate']==1)
			$tpl->assign("createdate",'&nbsp;<span class="createdate">('.date('d/m/Y H:i', $rs['ngay_dang']).')</span>');
		}
	}
}
?>