<?php

// Binh Minh
defined('_VALID_NVB') or die('Direct Access to this location is not allowed.');
$tpl = new TemplatePower("skin/static_lang.tpl");
$tpl->prepare();
$module = new Lang;
$module->_int();
$tpl->printToScreen();
if (intval($_GET['editmode']) == 1)
    $_SESSION['editmode'] = 1;

class Lang {

    private $page = "Cấu hình ngôn ngữ";
    private $item = "Cấu hình";
    private $table = "lang";
    private $id_item = "id";
    private $par_page = "static_lang";
    private $data_type = 'static_lang';

    public function _int() {
        global $tpl, $id, $pid, $imagedir, $dir_path;
        $tpl->assignGlobal('pathpage', $pathpage);
        $tpl->assignGlobal("item", $this->item);
        $tpl->assignGlobal("table", $this->table);
        $tpl->assignGlobal("id_item", $this->id_item);
        $tpl->assignGlobal("par_page", $this->par_page);
        $tpl->assignGlobal("dir_path", $dir_path);
        $code = $_GET['code'];
        switch ($code) {
            case "showUpdate": $this->showUpdate();
                break;
            case "update": $this->update($id);
                break;
        } $this->showUpdate();
    }

    private function showUpdate($id) {
        global $DB, $tpl, $lang, $dklang, $dir_image, $tree, $pid;
        $tpl->newBlock("AddNew");
        if ($_GET['p'] > 1) {
            $pa = '&p=' . $_GET['p'];
        } $id = 1;
        $tpl->assign("action", '?page=' . $this->par_page . '&code=update&id=' . $id . '&pid=' . $pid . $pa);
        $sql = "SELECT * FROM " . $this->table . " WHERE " . $this->id_item . " = " . $id;
        $db = $DB->query($sql);
        if ($rs = mysql_fetch_array($db)) {
            $static_lang = array();
            $static_lang = json_decode($rs['lang'], true);
            if ($static_lang) {
                foreach ($static_lang as $st => $val1) {
                    $tpl->newBlock("label_list");
                    $tpl->assign("labelcode", $st);
                    $tpl->assign("labelvalue_default", $val1['default']);
                    $tpl->assign("labelvalue_en", $val1['en']);
                    if (intval($_SESSION['editmode']) == 1 || intval($_GET['editmode']) == 1)
                        $tpl->assign("xoanhan", '<a href="#" class="remove_lable" onclick="DeleteRow();">Xóa nhãn</a>');
                    $i = 0;
                    foreach ($val1 as $st1 => $val) {
                        $tpl->assign($st . $st1, $val);
                        //alert($st1 . '-->' . $val );
                        $tpl->assign($st . $st1, $val);
                        if ($i == 0)
                            $tpl->assign("labelname", $val);
                        $i++;
                    }
                }
            }
        } if (intval($_SESSION['editmode']) == 1 || intval($_GET['editmode']) == 1)
            $tpl->newBlock("label_add");
    }

    private function update() {
        global $DB, $tpl;
        $data = $this->getData();
        if ($data) {
            $b = $DB->compile_db_update_string($data);
            $sql = "UPDATE " . $this->table . " SET " . $b . " WHERE " . $this->id_item . "=1";
            $db = $DB->query($sql);
            Message::showMessage("success", "Sửa chữa thành công !");
        }
    }

    function getData() {
        global $my;
        $data = array();
        $attr = $_POST['static_lang'];
        $data['lang'] = addslashes(json_encode($attr));
        return $data;
    }

}

?>