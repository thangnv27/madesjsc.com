<?php

//Nguyen Van Binh
//suongmumc@gmail.com

defined('_VALID_NVB') or die('Direct Access to this location is not allowed.');
$data_type_not_in = array("sitemap", "logo");

function sitemap() {
    global $DB, $dir_path, $category, $site_address;

    $tpl1 = new TemplatePower("plugins/sitemap/sitemap.htm");
    $tpl1->prepare();
    $tpl1->assignGlobal("site_address", $site_address);
    $tpl1->assignGlobal("dir_path", $dir_path);
    $sitemap = new dbSitemap;
    $sm = $sitemap->sitemap();
    $total_sm = count($sm);
    $i = 0;
    foreach ($sm as $rs_item) {
        if ($rs_item['id_category'] > 0) {
            $i++;
            $tpl1->newBlock("sitemap");
            if ($i == 1)
                $tpl1->assign("name", "├ " . $rs_item['name']);
            else
            if ($i < $total_sm)
                $tpl1->assign("name", "├ " . $rs_item['name']);
            else
                $tpl1->assign("name", "└ " . $rs_item['name']);

            $tpl1->assign("link", $dir_path . "/" . $rs_item['url']);
            $sm1 = $sitemap->sitemap($rs_item['id_category']);
            $total_sm1 = count($sm1);
            $n = 0;
            foreach ($sm1 as $rs_item1) {
                if ($rs_item1['id_category'] > 0) {
                    $n++;
                    $tpl1->newBlock("sitemap1");
                    if ($n < $total_sm1)
                        $tpl1->assign("name1", "├ " . $rs_item1['name']);
                    else
                        $tpl1->assign("name1", "└ " . $rs_item1['name']);
                    $tpl1->assign("link1", $dir_path . "/" . $rs_item1['url']);
                    $sm2 = $sitemap->sitemap($rs_item1['id_category']);
                    $total_sm2 = count($sm2);
                    $n2 = 0;
                    foreach ($sm2 as $rs_item2) {
                        if ($rs_item2['id_category'] > 0) {
                            $n2++;
                            $tpl1->newBlock("sitemap2");
                            if ($n2 < $total_sm2)
                                $tpl1->assign("name2", "├" . $rs_item2['name']);
                            else
                                $tpl1->assign("name2", "└ " . $rs_item2['name']);
                            $tpl1->assign("link2", $dir_path . "/" . $rs_item2['url']);
                        }
                    }
                }
            }
        }
    }



    return $tpl1->getOutputContent();
}

class dbSitemap {

    public function sitemap($idc = 0) {
        global $DB,$language;
        $idc = intval($idc);
        $notIn = array("logo", "sitemap");
        $parent = " AND parentid = $idc ";
        $sql = "SELECT * FROM category WHERE active=1 $language $like $parent ORDER BY thu_tu ASC, name ASC";
        $db = $DB->query($sql);
        while ($rs = mysql_fetch_array($db)) {
            if (!in_array($rs['data_type'], $notIn)) {
                $data[] = $rs;
            }
        }
        return $data;
    }

}

?>