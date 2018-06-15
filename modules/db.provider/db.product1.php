<?php

// error_reporting(E_ALL);
defined('_VALID_NVB') or die('Direct Access to this location is not allowed.');

class dbProduct {

    public function itemList($idc, $limit = 6) {
        global $DB, $SETTING, $dir_path, $_GET;
        $idc = intval($idc);
		if($_GET['qr']){
			$qr = clean_value($_GET['qr']);
			$search = " AND name LIKE '%".$qr."%' ";
		}
        $data = array();
        $sql = "SELECT * FROM product WHERE active=1 AND (id_category IN (" . Category::getParentId($idc) . ") OR groupcat LIKE '%:" . $idc . ":%') $search ORDER BY thu_tu DESC, name ASC";
        //echo $sql; 
        $db1 = paging::pagingFonten($_GET['p'], $dir_path . "/" . url_process::getUrlCategory($idc), $sql, 8, $limit);
        while ($rs = mysql_fetch_array($db1['db']))
            $data[] = $rs;
        $data['pages'] = $db1['pages'];
        return $data;
    }

    public function itemDetail($id) {
        global $DB, $SETTING;
        $id = intval($id);
        $sql = "SELECT * FROM product WHERE id_product = $id";
        $db = $DB->query($sql);
        $rs = mysql_fetch_array($db);
        return $rs;
    }

    public function item_other($idc, $id) {
        global $DB, $SETTING;
        $idc = intval($idc);
        $id = intval($id);
        $sql = "SELECT * FROM product WHERE active = 1 AND id_product <> $id AND (id_category IN(" . Category::getParentId($idc) . ") OR groupcat LIKE '%:" . $idc . ":%') ORDER BY id_product DESC LIMIT 0,16";
        $db = $DB->query($sql);
        while ($rs = mysql_fetch_array($db)) {
            $data[] = $rs;
        }
        return $data;
    }

    public function other_product($idc, $id) {
        global $DB, $SETTING;
        $idc = intval($idc);
        $id = intval($id);
        $sql = "SELECT * FROM product WHERE active = 1 AND  (id_category IN(" . Category::getParentId($idc) . ") OR groupcat LIKE '%:" . $idc . ":%') AND id_product <> $id  ORDER BY id_product DESC LIMIT 0,10";
        $db = $DB->query($sql);
        while ($rs = mysql_fetch_array($db)) {
            $data[] = $rs;
        }
        return $data;
    }

    public function item_old($idc, $id) {
        global $DB, $SETTING, $id;
        $id = intval($id);
        $idc = intval($idc);
        $sql = "SELECT * FROM product WHERE active = 1 AND  (id_category IN(" . Category::getParentId($idc) . ") OR groupcat LIKE '%:" . $idc . ":%') AND id_product < $id  ORDER BY id_product DESC LIMIT 0,5";
        $db = $DB->query($sql);
        while ($rs = mysql_fetch_array($db)) {
            $data[] = $rs;
        }
        return $data;
    }
	
	function getAttr($idc,$attr){
		global $DB;
		$idc = intval($idc);
		$attribute = json_decode($attr);	

		$sql = "SELECT * FROM category WHERE id_category = $idc";
		$db = $DB -> query($sql);
		if($rs = mysql_fetch_array($db)){
			$sql1 = "SELECT g.*,p.name AS attrName, p.default_value AS defaultvalue,p.alias_name as aliasname,p.id  FROM group_attribute AS g LEFT JOIN pro_attribute AS p ON(g.id_attr = p.id) WHERE g.id_group = $rs[id_attr] ORDER BY g.thu_tu ASC, p.name";
			
			$str ='';
			$db1= $DB->query($sql1);
			while($rs1 = mysql_fetch_array($db1)){
				if($rs1['attrName']){
					
					if($attribute->$rs1['id_attr'] >0){
						$str.='<li>'.$rs1['attrName'].': '.$attribute->$rs1['id_attr'].'</li>';
					}
				}
			}
			return $str;
		}
	}
	
	
	function getAttrDetail($idc,$attr){
		global $DB;
		$idc = intval($idc);
		$attribute = json_decode($attr);	
		$sql = "SELECT * FROM category WHERE id_category = $idc";
		$db = $DB -> query($sql);
		if($rs = mysql_fetch_array($db)){
			$sql1 = "SELECT g.*,p.name AS attrName, p.default_value AS defaultvalue,p.alias_name as aliasname FROM group_attribute AS g LEFT JOIN pro_attribute AS p ON(g.id_attr = p.id) WHERE g.id_group = $rs[id_attr] ORDER BY g.thu_tu ASC, p.name";
			$db1= $DB->query($sql1);
			$data = array();
			while($rs1 = mysql_fetch_array($db1)){
				if($rs1['attrName']){
					if($attribute->$rs1['id_attr'] !=''){
						
						$data[$rs1['attrName']] =$attribute->$rs1['id_attr'];
					}
				}
			}
			return $data;
		}
	}

}

?>