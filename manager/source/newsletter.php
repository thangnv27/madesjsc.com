<?php
defined('_VALID_NVB') or die('Direct Access to this location is not allowed.');
$tpl = new TemplatePower("skin/newsletter.tpl");
$tpl->prepare();
$id = intval($_GET['id']);
$module = new NewsLetter();
$module->_int();
$tpl->printToScreen();

class NewsLetter {

    public function _int() {
        global $DB, $tpl;
        if ($_GET['code'] == 'delete') $this->Delete();
        $this->listContact();
    }

    private function listContact() {
        global $DB, $tpl;
        $tpl->newBlock("showList");
        $sql = "SELECT * FROM newsletter ORDER BY id DESC";
        $db = paging::pagingAdmin($_GET['p'], '?page=newsletter', $sql, 8, 40);
        while ($rs = mysql_fetch_array($db['db'])) {
            $tpl->newBlock("list");
            $tpl->assign("name", $rs['name']);
            $tpl->assign("email", $rs['email']);
            $tpl->assign("phone", $rs['phone']);
            $tpl->assign("linkdel", "?page=newsletter&code=delete&id=" . $rs['id']);
            if (($rs['table_name'] != '') && ($rs['id_item_name'] != '')) {
                $sqle = "SELECT * FROM $rs[table_name] WHERE $rs[id_item_name] = $rs[id_item_val]";
                $dbe = $DB->query($sqle);
                if ($rse = mysql_fetch_array($dbe)) {
                    $tpl->assign("ename", $rse['name']);
                }
            }
        } $tpl->assign("showList.pages", $db['pages']);
    }

    private function Delete() {
        global $DB, $tpl, $id;
        $DB->query("DELETE FROM newsletter WHERE id = $id");
    }

}