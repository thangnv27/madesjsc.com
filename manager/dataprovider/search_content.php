<?php

defined('_VALID_NVB') or die('Direct Access to this location is not allowed.');

class search_content {

    public function getById($id) {
        global $DB;
        $id = intval($id);
        $sql = "SELECT * FROM search_content WHERE id_search ='" . $id . "'";
        $db = $DB->query($sql);
        $rs = mysql_fetch_array($db);
        return $rs;
    }

    public function getSearch($id_item, $table_name, $id_item_value) {
        global $DB;
        $sql = "SELECT * FROM search_content WHERE id_item = '$id_item' AND id_item_value = $id_item_value  AND table_name = '$table_name'";
        $db = $DB->query($sql);
        $rs = mysql_fetch_array($db);
        return $rs;
    }

    public function getListItem($keywords, $scopelevel = 0) {
        global $DB, $lang, $language;
        /*            $scopelevel = 0 title, 1 title and intro, 2 all        */
        $keywords = $this->RemoveSign($keywords);
        $sql = "SELECT * FROM search_content WHERE name_unsign like '%$keywords%' $language ORDER BY id_search DESC";
        //echo $sql;
        $id_not_in = '0';
        $db = $DB->query($sql);
        while ($row = mysql_fetch_array($db)) {
            $data[] = $row;
            $id_not_in .= "," . $row['id_search'];
        } if ($scopelevel == 1) {
            $sql1 = "SELECT * FROM search_content WHERE id_search NOT IN ($id_not_in) AND intro_unsign like '%$keywords%' $language ORDER BY id_search DESC";
            $db1 = $DB->query($sql1);
            while ($row1 = mysql_fetch_array($db1))
                $data[] = $row1;
        } if ($scopelevel > 1) {
            $sql2 = "SELECT * FROM search_content WHERE id_search NOT IN ($id_not_in) content_unsign like '%$keywords%' $language ORDER BY id_search DESC";
            $db2 = $DB->query($sql2);
            while ($row2 = mysql_fetch_array($db2))
                $data[] = $row2;
        }
        //echo $sql.$sql1.$sq2;
        return $data;
    }

    public function insertSearch($data, $id_category, $id_item, $table_name, $id_item_value) {
        global $DB, $lang;
        $ds = array();
        if ($data) {
            $ds['name'] = $data['name'];
            $ds['intro'] = $data['intro'];
            $ds['content'] = $data['content'];
            $ds['url'] = $data['url'];
            $ds['image'] = $data['image'];
            $ds['ngay_dang'] = time();
            $ds['name_unsign'] = strtolower($this->RemoveSign($data['name']));
            $intro_decode = html_entity_decode(strip_tags($data['intro']), ENT_COMPAT, 'UTF-8');
            $ds['intro_unsign'] = strtolower($this->RemoveSign($intro_decode));
            $content_decode = html_entity_decode(strip_tags($data['content']), ENT_COMPAT, 'UTF-8');
            $ds['content_unsign'] = strtolower($this->RemoveSign($content_decode));
            $ds['lang'] = $lang;
            $ds['id_category'] = $id_category;
            $ds['id_item'] = $id_item;
            $ds['id_item_value'] = $id_item_value;
            $ds['table_name'] = $table_name;
            $b = $DB->compile_db_insert_string($ds);
            $sql = "INSERT INTO search_content (" . $b['FIELD_NAMES'] . ") VALUES (" . $b['FIELD_VALUES'] . ")";
            try {
                $DB->query($sql);
                return 1;
            } catch (Exception $ex) {
                return $ex;
            }
        } return 0;
    }

    public function updateSearch($data, $id_category, $id_item, $table_name, $id_item_value) {
        global $DB, $lang;
        $ds = array();
        if ($data) {
            $ds['name'] = $data['name'];
            $ds['intro'] = $data['intro'];
            $ds['content'] = $data['content'];
            $ds['url'] = $data['url'];
            $ds['image'] = $data['image'];
            $ds['ngay_dang'] = time();
            $ds['name_unsign'] = strtolower($this->RemoveSign($data['name']));
            $intro_decode = html_entity_decode(strip_tags($data['intro']), ENT_COMPAT, 'UTF-8');
            $ds['intro_unsign'] = strtolower($this->RemoveSign($intro_decode));
            $content_decode = html_entity_decode(strip_tags($data['content']), ENT_COMPAT, 'UTF-8');
            $ds['content_unsign'] = strtolower($this->RemoveSign($content_decode));
            $ds['lang'] = $lang;
            $ds['id_category'] = $id_category;
            $ds['id_item'] = $id_item;
            $ds['id_item_value'] = $id_item_value;
            $ds['table_name'] = $table_name;
            $b = $DB->compile_db_update_string($ds);
            $sql = "UPDATE search_content SET " . $b . " WHERE id_item = '$id_item' AND id_item_value = $id_item_value  AND table_name = '$table_name'";
            try {
                $DB->query($sql);
                return 1;
            } catch (Exception $ex) {
                return $ex;
            }
        } return 0;
    }

    public function deleteSearch($id_item, $table_name, $id_item_value) {
        global $DB, $lang;
        $sql = "DELETE FROM search_content WHERE id_item = '$id_item' AND id_item_value = $id_item_value  AND table_name = '$table_name'";
        try {
            $DB->query($sql);
            return 1;
        } catch (Exception $ex) {
            return $ex;
        } return 0;
    }

    public function RemoveSign($str) {
        $coDau = array("à", "á", "ạ", "ả", "ã", "â", "ầ", "ấ", "ậ", "ẩ", "ẫ", "ă", "ằ", "ắ", "ặ", "ẳ", "ẵ", "è", "é", "ẹ", "ẻ", "ẽ", "ê", "ề", "ế", "ệ", "ể", "ễ", "ì", "í", "ị", "ỉ", "ĩ", "ò", "ó", "ọ", "ỏ", "õ", "ô", "ồ", "ố", "ộ", "ổ", "ỗ", "ơ", "ờ", "ớ", "ợ", "ở", "ỡ", "ù", "ú", "ụ", "ủ", "ũ", "ư", "ừ", "ứ", "ự", "ử", "ữ", "ỳ", "ý", "ỵ", "ỷ", "ỹ", "đ", "À", "Á", "Ạ", "Ả", "Ã", "Â", "Ầ", "Ấ", "Ậ", "Ẩ", "Ẫ", "Ă", "Ằ", "Ắ", "Ặ", "Ẳ", "Ẵ", "È", "É", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ề", "Ế", "Ệ", "Ể", "Ễ", "Ì", "Í", "Ị", "Ỉ", "Ĩ", "Ò", "Ó", "Ọ", "Ỏ", "Õ", "Ô", "Ồ", "Ố", "Ộ", "Ổ", "Ỗ", "Ơ", "Ờ", "Ớ", "Ợ", "Ở", "Ỡ", "Ù", "Ú", "Ụ", "Ủ", "Ũ", "Ư", "Ừ", "Ứ", "Ự", "Ử", "Ữ", "Ỳ", "Ý", "Ỵ", "Ỷ", "Ỹ", "Đ", "ê", "ù", "à");
        $khongDau = array("a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "i", "i", "i", "i", "i", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "y", "y", "y", "y", "y", "d", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "I", "I", "I", "I", "I", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "Y", "Y", "Y", "Y", "Y", "D", "e", "u", "a");
        return str_replace($coDau, $khongDau, $str);
    }

}