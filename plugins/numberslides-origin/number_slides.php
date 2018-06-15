<?php

//Nguyen Van Binh
//suongmumc@gmail.com

defined('_VALID_NVB') or die('Direct Access to this location is not allowed.');

function number_slides($w,$h) {
    $w = intval($w);
    $h = intval($h);
    if ($w ==0) $w = 658;
    if ($h ==0) $h = 456;
    
    global $DB, $dir_path, $cache_image_path, $CONFIG, $logo;
    $tpl1 = new TemplatePower("plugins/numberslides/number_slides.htm");
    $tpl1->prepare();
    
    $id = intval($_GET['id']);
    $idc = intval($_GET['idc']);
    $tpl1->newBlock("show_slideshow");
    
    $tpl1->assignGlobal("slidewidth",$w);
    $tpl1->assignGlobal("slideheight",$h);
    
    $sql = "SELECT * FROM category WHERE active = 1 AND vitri LIKE '%:slideshow:%' ORDER BY thu_tu ASC, name ASC LIMIT 0,1";
    $db = $DB->query($sql);
    if ($rs = mysql_fetch_array($db)) {
        $dblg = $logo->logoList($rs['id_category']);
        $i=0;
        foreach ($dblg as $rslg) {
            if ($rslg['image']) {
                $i++;
                $tpl1->newBlock("list_slide");
                $tpl1->assign("name", $rslg['name']);
                $tpl1->assign("intro", $rslg['comment']);
                $tpl1->assign("image_src", $cache_image_path.cropimage($w,$h,$dir_path.'/'. $rslg['image']));
                $tpl1->assign("link", $rslg['link']);
                $tpl1->assign("target", $rslg['target']);
                
                $tpl1->newBlock("list_slide_number");
                $tpl1->assign("stt", $i);
                
            }
        }
    }
    return $tpl1->getOutputContent();
}


?>