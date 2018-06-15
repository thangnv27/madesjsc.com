<?php

defined('_VALID_NVB') or die('Direct Access to this location is not allowed.');

class clsProductType{

    
    function getById($id) {
        global $DB;
        //$id = intval($id);
        $sql = "SELECT * FROM product_type WHERE id =" . $id . "";
        $db = $DB->query($sql);
        $rs = mysql_fetch_array($db);
        return $rs;
    }

    function getList() {
        global $DB;
        $sql = "SELECT * FROM product_type";
        $db = $DB->query($sql);
        while ($row = mysql_fetch_array($db)) 
            $data[] = $row;
        return $data;
    }


}

?>