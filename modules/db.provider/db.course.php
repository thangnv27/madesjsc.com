<?php 
// Nguyen Binh
// suongmumc@gmail.com
// error_reporting(E_ALL);
defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );

class dbCourse{
	public function selectList($idc,$limit=50){
		global $DB, $SETTING,$dir_path,$_GET;
		$idc = intval($idc);

		$data = array();
		$sql = "SELECT * FROM news WHERE active=1 AND (id_category IN (".Category::getParentId($idc).") OR groupcat LIKE '%:".$idc.":%') ORDER BY thu_tu DESC, name ASC";
		$db1 = paging::pagingFonten($_GET['p'],$dir_path."/".url_process::getUrlCategory($idc),$sql,8,$limit);
		
		while($rs = mysql_fetch_array($db1['db'])){
		  	$data[] = $rs;	
		}
		$data['pages'] = $db1['pages'];
		return $data;
	}
	
	public function selectById($id){
		global $DB, $SETTING;
		$id = intval($id);
		$sql = "SELECT * FROM news WHERE id_news = $id";
		$db = $DB->query($sql);
		$rs = mysql_fetch_array($db);
		return $rs;
	}
	
	
	
	
}

?>