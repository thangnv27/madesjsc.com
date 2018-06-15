<?php

defined('_VALID_NVB') or die('Direct Access to this location is not allowed.');
$tpl = new TemplatePower("skin/comment.tpl");
$tpl->prepare();
$id = intval($_GET['id']);
$idc = intval($_GET['idc']);
$pid = intval($_GET['pid']);

$eid = intval($_REQUEST['eid']);

$module = new Comment();
$module->_int();
$tpl->printToScreen();

class Comment extends cat_tree {

    private $page = "Quản lý bình luận";
    private $item = "bình luận";
    private $table = "comments";
    private $id_item = "id_comment";
    private $par_page = "comment";
    private $numberPageShow = 8;
    private $numberItemPage = 30;
    private $thumbwidth = 80;
    private $data_type = 'static';

    public function _int() {
        global $tpl, $id, $pid, $imagedir, $dir_path;

        $tpl->assignGlobal('pathpage', $pathpage);
        $tpl->assignGlobal("item", $this->item);
        $tpl->assignGlobal("table", $this->table);
        $tpl->assignGlobal("id_item", $this->id_item);
        $tpl->assignGlobal("par_page", $this->par_page);
        $tpl->assignGlobal("pid", $pid);
        $tpl->assignGlobal("dir_path", $dir_path);
        $tpl->assignGlobal("imagedir", $imagedir);

        $code = $_GET['code'];
        switch ($code) {
            case "showAddNew":
                $this->showAddNew();
                break;
            case "showUpdate":
                $this->showUpdate();
                break;
            case "save":
                $this->save();
                break;
            case "update":
                $this->update($id);
                break;

            case "deletemulti":
                $this->deleteMultiItem();
                break;
        }
        $this->showList();
    }

    private function showAddNew() {
        global $DB, $tpl, $lang, $dklang, $tree, $pid, $CONFIG, $my;
        $pid = intval($pid);
        
        
        $tpl->newBlock("AddNew");
        $tpl->assign("action", '?page=' . $this->par_page . '&code=save&pid=' . $pid);
        $tpl->assign("content", ClEditor::Editor("content", '&nbsp;'));
        $tpl->assign("active", "checked");
        //$tpl->assign("estate_str", $this->bindEstate($eid));
        
        $idcm = intval($_GET['idcm']);
        if ($idcm > 0){
            $sql = "SELECT * FROM comments WHERE id_comment = $idcm";
            $db = $DB->query($sql);
            if ($rs = mysql_fetch_array($db)){
                if (($rs['table_name'] != '') && ($rs['id_item'] != '')){
                    $sqle = "SELECT * FROM $rs[table_name] WHERE $rs[id_item] = $rs[id_value]";
                    $dbe = $DB->query($sqle);
                    if ($rse = mysql_fetch_array($dbe)) $tpl->assign("ename",$rse['name']);
                }
                $tpl->assign("idcm",$idcm);
                $tpl->assign("comment",strstrim($rs['comment'],20)." Trong bài:");
                
                $tpl->assign("name",$my['name']);
                $tpl->assign("email",$my['email']);
                
                $tpl->assign("table_name",$rs['table_name']);
                $tpl->assign("id_item",$rs['id_item']);
                $tpl->assign("id_value",$rs['id_value']);
                
                
                
            }
            
        }
        
        
        
    }

    private function showUpdate() {
        global $DB, $tpl, $lang, $dklang, $id, $dir_image, $tree, $pid, $eid;
        $tpl->newBlock("AddNew");
        if ($_GET['p'] > 1) {
            $pa = '&p=' . $_GET['p'];
        }
        //$tpl->assign("estate_str", $this->bindEstate($eid));                  
        
        $tpl->assign("action", '?page=' . $this->par_page . '&code=update&id=' . $id . '&pid=' . $pid . $pa);
        $sql = "SELECT * FROM comments  WHERE id_comment = " . $id;
        $db = $DB->query($sql);
        if ($rs = mysql_fetch_array($db)) {
            $tpl->assign("name", $rs['name']);
            $tpl->assign("email", $rs['email']);
            
            $tpl->assign("content", ClEditor::Editor("content", $rs['comment']));
            $link_delete_image = "index4.php?page=actionajax&code=delete&id=" . $rs[$this->id_item] . "&table=" . $this->table . "&id_item=" . $this->id_item;
            
            if (($rs['table_name'] != '') && ($rs['id_item'] != '')){
                $sqle = "SELECT * FROM $rs[table_name] WHERE $rs[id_item] = $rs[id_value]";
                $dbe = $DB->query($sqle);
                if ($rse = mysql_fetch_array($dbe)) {
                    $ename = $rse['name'];
                    $tpl->assign("ename",$ename);
                }
            }
            
            
            if ($rs['active'] == 1)
                $tpl->assign("active", "checked");
            $tpl->assign($rs['inwhere'], "checked");
        }
    }

    private function showList() {
        global $DB, $tpl, $lang, $pid, $site_address, $dir_path, $dir_image, $tree, $eid;
        $tpl->newBlock("showList");
        if (intval($_GET['p']) < 1)
            $p = 1;
        else
            $p = intval($_GET['p']);
        
        $tpl->assign("estate_str", $this->bindEstate($eid));                  
        $tpl->assign("eid", $eid);
        
        $tpl->assign("pid", $pid);
        $tpl->assign("par_page", $this->par_page);
        $tpl->assign("action", "");
        
        $keyword = $_REQUEST['keyword'];
        $tpl->assign("keyword", $keyword);
        $strWhere = "";
        if ($keyword != '') $strWhere = " AND (email like '%$keyword%' OR name like '%$keyword%' OR comment like '%$keyword%')";
        
        
        if ($eid > 0)
            $sql = "SELECT * FROM comments  WHERE (parentid is NULL OR parentid = '' OR parentid = 0) $strWhere AND table_name = 'product' AND id_value = $eid ORDER BY (SELECT active FROM comments  WHERE parentid = c.id_comment AND active = 0), id_comment DESC";
        else 
            $sql = "SELECT * FROM comments c  WHERE (parentid is NULL OR parentid = '' OR parentid = 0) $strWhere ORDER BY  (SELECT active FROM comments  WHERE parentid = c.id_comment ORDER BY active LIMIT 1), id_comment DESC";
        
        $db = paging::pagingAdmin($p, "?page=comment", $sql, 8, 50);
        
        //$db = $DB->query($sql);
        while ($rs = mysql_fetch_array($db['db'])) {
            
            $tpl->newBlock("list");
            $tpl->assign(array(
                member_name => 'Người bình luận: <b>' . $rs['name'] . ' </b> - Email: <b>'.$rs['email'].'</b>',
                comment => '<div><i>' . $rs['comment'] . '</i></div>',
                id => $rs[$this->id_item],
            ));
		$s_i = 1;
		$str_star='';
		$str_star1='';
		if($rs['star_rate'] > 0){
			for($s_i==1; $s_i<=$rs['star_rate'];$s_i++){
				$str_star .= '<i class="fa fa-star"></i>';
			}
			if($rs['star_rate'] < 5){
				$starrate = 5 - intval($rs['star_rate']);
				$s_n=1;
				for($s_n==1;$s_n<=$starrate;$s_n++)
				$str_star1 .= '<i class="fa fa-star-o"></i>';
			}
				
			$tpl->assign("str_star", '<span class="box-star">'.$str_star.$str_star1.'</span>');	
		}
            if ($rs['active'] == 1)
                $tpl->assign("active", "checked");
            $tpl->assign("link_edit", '?page=' . $this->par_page . '&code=showUpdate&id=' . $rs[$this->id_item]);
            $tpl->assign("link_delete", '?page=action_ajax&code=deleteitem&id=' . $rs[$this->id_item] . '&table=' . $this->table . '&id_item=' . $this->id_item);
            
            if (($rs['table_name'] != '') && ($rs['id_item'] != '')){
                $sqle = "SELECT * FROM $rs[table_name] WHERE $rs[id_item] = $rs[id_value]";
                $dbe = $DB->query($sqle);
                if ($rse = mysql_fetch_array($dbe)) {
                    
                    $ename = $rse['name'];
                    $tpl->assign("ename","Trong bài viết : <b> <a href='" . $site_address . $dir_path . '/' . url_process::getUrlCategory($rse['id_category']) . $rse['url'] . "' target='_blank'>" . $ename . "</a></b>");
                }

            }
            
            $tpl->newBlock("tra_loi_binh_luan");
            $tpl->assign("par_page", $this->par_page);
            $tpl->assign("id", $rs[$this->id_item]);
            
            $this->showSubList($rs[$this->id_item]);
        }
		$tpl->assign("showList.pages",$db['pages']);
    }

    private function showSubList($idcm) {
        global $DB, $tpl, $lang, $site_address, $dir_path, $dir_image;
        
        $sql = "SELECT * FROM comments  WHERE parentid = $idcm ORDER BY id_comment DESC";
        
        $db = $DB->query($sql);
        while ($rs = mysql_fetch_array($db)) {
            
            $tpl->newBlock("list");
            $tpl->assign(array(
                member_name => 'Người bình luận: <b>' . $rs['name'] . ' </b> - Email: <b>'.$rs['email'].'</b>',
                comment => '<div><i>' . $rs['comment'] . '</i></div>',
                id => $rs[$this->id_item],
            ));
            $tpl->assign("padding_left", "padding-left: 20px;");
            
            if ($rs['active'] == 1) $tpl->assign("active", "checked");
            $tpl->assign("link_edit", '?page=' . $this->par_page . '&code=showUpdate&id=' . $rs[$this->id_item]);
            $tpl->assign("link_delete", '?page=action_ajax&code=deleteitem&id=' . $rs[$this->id_item] . '&table=' . $this->table . '&id_item=' . $this->id_item);
            
            
        }
    }
    
    private function save() {
        global $DB, $tpl, $lang, $dklang;
        $data = $this->getData();
        if ($data) {
            $b = $DB->compile_db_insert_string($data);
            $sql = "INSERT INTO " . $this->table . " (" . $b['FIELD_NAMES'] . ") VALUES (" . $b['FIELD_VALUES'] . ")";
            $DB->query($sql);
            Message::showMessage("success", "Thêm mới thành công !");
        }
    }

    private function update($id) {
        global $DB, $tpl, $lang, $dklang;
        $id = intval($id);
        $data = $this->getData($id);
        if ($data) {
            $b = $DB->compile_db_update_string($data);
            $sql = "UPDATE " . $this->table . " SET " . $b . " WHERE " . $this->id_item . "=" . $id;
            $db = $DB->query($sql);
            Message::showMessage("success", "Sửa chữa thành công !");
        }
    }

    private function deleteMultiItem() {
        global $DB;
        $multi = $_POST['delmulti'];
        if ($multi) {
            foreach ($multi as $mtId) {
                $sql = "SELECT * FROM " . $this->table . " WHERE " . $this->id_item . "=" . $mtId;
                $db = $DB->query($sql);
                if ($rs = mysql_fetch_array($db)) {
                    deleteimage($rs['image']);
                }
                $DB->query("DELETE FROM " . $this->table . " WHERE " . $this->id_item . "=" . $mtId);
                Message::showMessage("success", "Đã xóa xong !");
            }
        }
    }

    function getData($id = 0) {
        global $my, $lang, $CONFIG;
        $id = intval($id);
        $data = array();
        $data['name'] = compile_post("name");
        $data['email'] = compile_post("email");
        $data['comment'] = $_POST['content'];
        $data['active'] = intval(compile_post('active'));
        
        if ($id == 0){
            $data['parentid'] = compile_post("parentid");
            $data['table_name'] = compile_post("table_name");
            $data['id_item'] = compile_post("id_item");
            $data['id_value'] = compile_post("id_value");
            $data['createdate'] = time() + $CONFIG['time_offset'];
            $data['name'] = $my['name'];
            $data['id_admin'] = $my['id'];
            
        }
        
        return $data;
    }
    
    
    public function bindEstate($selectedid) {
        global $DB;
        $db = $DB->query("SELECT * FROM product WHERE active =  1 ORDER BY thu_tu");
        $result_str = '';
        while ($rs = mysql_fetch_array($db)) {
            if ($selectedid == $rs['id_product'])
                $result_str.= '<option value="' . $rs['id_product'] . '" selected>' . $rs['name'] . '</option>';
            else
                $result_str.= '<option value="' . $rs['id_product'] . '">' . $rs['name'] . '</option>';
        }
        return $result_str;
        
    }    
    
}

?>