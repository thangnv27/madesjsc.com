<?php 

// Nguyen Binh

// suongmumc@gmail.com

// error_reporting(E_ALL);

defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );



class dbNews{

	public function newsList($idc,$limit=6){

		global $DB, $SETTING,$dir_path,$_GET;

		$idc = intval($idc);

		$data = array();

		$sql = "SELECT * FROM news WHERE active=1 AND (id_category IN (".Category::getParentId($idc).") OR groupcat LIKE '%:".$idc.":%') ORDER BY thu_tu DESC, name ASC";

                //echo $sql; 

		$db1 = paging::pagingFonten($_GET['p'],$dir_path."/".url_process::getUrlCategory($idc),$sql,8,$limit);

		

		while($rs = mysql_fetch_array($db1['db'])){

		  	$data[] = $rs;	

		}

		$data['pages'] = $db1['pages'];

		return $data;

	}

	

	public function newsDetail($id){

		global $DB, $SETTING;

		$id = intval($id);

		$sql = "SELECT * FROM news WHERE id_news = $id";

		$db = $DB->query($sql);

		$rs = mysql_fetch_array($db);

		return $rs;

	}

	
        public function news_other($idc,$ids){

		global $DB, $SETTING;

		$idc = intval($idc);

		$sql = "SELECT * FROM news WHERE active = 1 AND  (id_category IN(".Category::getParentId($idc).") OR groupcat LIKE '%:".$idc.":%') AND id_news NOT IN ($ids) ORDER BY id_news DESC LIMIT 0,8";

		$db = $DB->query($sql);

		while($rs = mysql_fetch_array($db)){
			$data[] = $rs;
		}

		return $data;

	}

	public function news_new($idc,$id){

		global $DB, $SETTING;

		$idc = intval($idc);

		$id = intval($id);

		$sql = "SELECT * FROM news WHERE active = 1 AND  (id_category IN(".Category::getParentId($idc).") OR groupcat LIKE '%:".$idc.":%') AND id_news > $id  ORDER BY id_news DESC LIMIT 0,5";

		$db = $DB->query($sql);

		while($rs = mysql_fetch_array($db)){

			$data[] = $rs;

		}

		return $data;

	}

	

	public function news_old($idc,$id){

		global $DB, $SETTING,$id;

		$id = intval($id);

		$idc = intval($idc);

		$sql = "SELECT * FROM news WHERE active = 1 AND  (id_category IN(".Category::getParentId($idc).") OR groupcat LIKE '%:".$idc.":%') AND id_news < $id  ORDER BY id_news DESC LIMIT 0,5";

		$db = $DB->query($sql);

		while($rs = mysql_fetch_array($db)){

			$data[] = $rs;

		}

		return $data;

	}

	

	

}



?>