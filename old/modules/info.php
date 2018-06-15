<?php
//Nguyen Van Binh
//suongmumc@gmail.com

defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );
$tpl = new TemplatePower($CONFIG['template_dir']."/info.htm");
$tpl->prepare();
$id 	= intval ($_GET['id']);
$idc 	= intval ($_GET['idc']);

$tpl->assignGlobal("pathpage",Get_Main_Cat_Name_path($idc));

$info = new Info;
$info -> _int();	

$tpl->printToScreen();

class Info{
	public function _int(){
		$this->viewContent();	
	}
	private function viewContent(){
		global $DB, $tpl, $dir_path, $dir_lang, $lang, $idc, $id;
		if($id){
			$this->content($id,$idc);		
		}else{
			$sql1 = "SELECT * FROM info WHERE active=1 AND id_category = $idc ORDER BY thu_tu DESC, name ASC LIMIT 0,1";
			$db1 = $DB->query($sql1);
			if($rs1 = mysql_fetch_array($db1)){
				$this->content($rs1['id_info'],$idc);
			}
		}
	}	
	private function content($id, $idc){
		global $DB, $tpl, $lang, $dir_lang, $dir_path;
		$sql = "SELECT * FROM info WHERE active=1 AND id_info = $id";
		$db = $DB->query($sql);
		if($rs = mysql_fetch_array($db)){
			$tpl->assign(array(
				name => $rs['name'],
				content => $rs['content']
			));
			$this->otherArticle($rs['id_info'],$idc);
		}
	}
	private function otherArticle($id,$idc){
		global $DB, $tpl, $dir_path;
		$sql = "SELECT * FROM info WHERE active=1 AND (id_category IN(".Category::getParentId($idc).") OR groupcat LIKE '%:".$idc.":%') AND id_info<>$id ORDER BY thu_tu DESC, name ASC";
		$db = $DB->query($sql);
		while($rs = mysql_fetch_array($db)){
			$tpl->newBlock("otherarticle")	;
			$tpl->assign("name",$rs['name']);
			$tpl->assign("link_detail",$dir_path."/".url_process::getUrlCategory($rs['id_category']).$rs['url']);
		}
	}
}
?>