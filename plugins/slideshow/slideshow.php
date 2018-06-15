<?php


defined('_VALID_NVB') or die('Direct Access to this location is not allowed.');



function slideshow() {

    global $DB, $dir_path, $cache_image_path, $CONFIG, $logo;



    $tpl1 = new TemplatePower("plugins/slideshow/slideshow.htm");

    $tpl1->prepare();



    $id = intval($_GET['id']);

    $idc = intval($_GET['idc']);

    $tpl1->newBlock("show_slideshow");

    $sql = "SELECT * FROM category WHERE active = 1 AND vitri LIKE '%:slideshow:%' ORDER BY thu_tu ASC, name ASC LIMIT 0,1";

    $db = $DB->query($sql);

    if ($rs = mysql_fetch_array($db)) {

        $dblg = $logo->logoList($rs['id_category']);

        foreach ($dblg as $rslg) {

            if ($rslg['image']) {

                $tpl1->newBlock("list_slide");

                $tpl1->assign("name", $rslg['name']);

                $tpl1->assign("intro", $rslg['comment']);

                $tpl1->assign("image_src", $cache_image_path.cropimage(980,363,$dir_path.'/'. $rslg['image']));

                $tpl1->assign("link", $rslg['link']);

                $tpl1->assign("target", $rslg['target']);

            }

        }

    }

    return $tpl1->getOutputContent();

}



?>