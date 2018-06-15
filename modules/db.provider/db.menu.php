<?php 
// Nguyen Binh
// suongmumc@gmail.com
// error_reporting(E_ALL);
defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );
class dbMenu{
	public function menuHome($idc){
		global $DB, $language;
		$idc = intval($idc);
		if($idc > 0){
			$parent = " AND parentid = $idc ";
		}else{
			$like =" AND vitri LIKE '%:menuhome:%' ";
		}
		$sql = "SELECT * FROM category WHERE active=1 $language $like $parent ORDER BY thu_tu ASC, name ASC LIMIT 10";
		$db = $DB->query($sql);
		while($rs = mysql_fetch_array($db)){	
			 $data[] = $rs;
		}
		return $data;
	}
	public function menuBar($idc){
		global $DB, $language;
		$idc = intval($idc);
		if($idc > 0){
			$parent = " AND parentid = $idc ";
		}else{
			$like =" AND vitri LIKE '%:menubar:%' ";
		}
		$sql = "SELECT * FROM category WHERE active=1 $language $like $parent ORDER BY thu_tu ASC, name ASC";
		$db = $DB->query($sql);
		while($rs = mysql_fetch_array($db)){	
			 $data[] = $rs;
		}
		return $data;
	}
	public function menuTop($idc){
		global $DB, $language;
		$idc = intval($idc);
		if($idc > 0){
			$parent = " AND parentid = $idc ";
		}else{
			$like =" AND vitri LIKE '%:menutop:%' ";
		}
		$sql = "SELECT * FROM category WHERE active=1 $language $like $parent ORDER BY thu_tu ASC, name ASC";
		$db = $DB->query($sql);
		while($rs = mysql_fetch_array($db)){	
			 $data[] = $rs;
		}
		return $data;
	}
     public function menuMain($idc){
		global $DB, $language;
		$idc = intval($idc);
		if($idc > 0){
			$parent = " AND parentid = $idc ";
		}else{
			$like =" AND vitri LIKE '%:mainmenu:%' ";
		}
		$sql = "SELECT * FROM category WHERE active=1 $language $like $parent ORDER BY thu_tu ASC, name ASC";
		$db = $DB->query($sql);
		while($rs = mysql_fetch_array($db)){	
			 $data[] = $rs;
		}
		return $data;
	}   
        
	public function menuFooter(){
		global $DB, $language;
	
		$location =" AND vitri LIKE '%:menufooter:%' ";
		
		$sql = "SELECT * FROM category WHERE active=1 $language $location ORDER BY thu_tu ASC, name ASC";
		$db = $DB->query($sql);
		while($rs = mysql_fetch_array($db)){	
			 $data[] = $rs;
		}
		return $data;
	}
    
	 public function menuChinhsach(){
		global $DB, $language;
	
		$location =" AND vitri LIKE '%:chinhsach:%' ";
		
		$sql = "SELECT * FROM category WHERE active=1 $language $location ORDER BY thu_tu ASC, name ASC";
		$db = $DB->query($sql);
		while($rs = mysql_fetch_array($db)){	
			 $data[] = $rs;
		}
		return $data;
	}
        
        public function menuBarFooter(){
		global $DB, $language;
		
		$location =" AND vitri LIKE '%:menufooter:%' ";
		
		$sql = "SELECT * FROM category WHERE active=1 $language $location ORDER BY thu_tu ASC, name ASC";
		$db = $DB->query($sql);
		while($rs = mysql_fetch_array($db)){	
			 $data[] = $rs;
		}
		return $data;
	}
	
	public function listSubCat($idc){
		global $DB;
		$idc = intval($idc);
		$sql = "SELECT * FROM category WHERE active=1 AND parentid = $idc ORDER BY thu_tu ASC, name ASC";
		$db = $DB->query($sql);
		while($rs = mysql_fetch_array($db)){	
			 $data[] = $rs;
		}
		return $data;
	}
	
	public function selectList($idc=0,$data_type){
		global $DB;
		$idc = intval($idc);
		if($data_type !=''){
			$dk = " AND data_type = '".$data_type."' ";
		}
		$sql = "SELECT * FROM category WHERE active=1 AND parentid = $idc $dk ORDER BY thu_tu ASC, name ASC";
		$db = $DB->query($sql);
		while($rs = mysql_fetch_array($db)){	
			 $data[] = $rs;
		}
		return $data;	
	}
	
	
	public function selectByLocation($location,$location1=''){
		global $DB, $language;
		$idc = intval($idc);
		if($location1 !=''){
			
			$loca = " AND (vitri LIKE '%:".$location.":%'  OR vitri LIKE '%:".$location1.":%')";	
		}else{
			$loca = " AND vitri LIKE '%:".$location.":%' ";
		}
		$sql = "SELECT * FROM category WHERE active=1 $language $loca ORDER BY thu_tu ASC, name ASC";
		$db = $DB->query($sql);
		while($rs = mysql_fetch_array($db)){	
			 $data[] = $rs;
		}
		return $data;	
	}
	public function selectByDataType($data_type){
		global $DB, $language;
		$idc = intval($idc);
		$sql = "SELECT * FROM category WHERE active=1 $language AND data_type ='".$data_type."' ORDER BY thu_tu ASC, name ASC LIMIT 1";
		$db = $DB->query($sql);
		$rs = mysql_fetch_array($db);
		return $rs;	
	}
	
	public function selectMenuById($idc){
		global $DB;	
		$idc = intval($idc);
		$sql = "SELECT * FROM category WHERE active=1 AND id_category = $idc";
		$db = $DB->query($sql);
		if($rs = mysql_fetch_array($db))
			return $rs;	
	}
	
	public function getCateSearch(){
		global $DB;
		$sql = "SELECT c.*,u.id_category as idc,u.url as uurl FROM category as c LEFT JOIN url as u ON(c.id_category = u.id_category) WHERE u.id_item=0 AND u.data_type='product' AND c.parentid=0 AND c.data_type='product' ORDER BY name ASC"	;
		echo $sql;
		
		$db = $DB->query($sql);
		$data = array();
		while($rs = mysql_fetch_array($db))		{
			$data[]	= $rs;
		}
		return $data;
	}
}
?>