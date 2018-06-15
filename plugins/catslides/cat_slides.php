<?php

//Nguyen Van Binh
//suongmumc@gmail.com

defined('_VALID_NVB') or die('Direct Access to this location is not allowed.');


function cat_slides($idc,$w,$h) {
    $w = intval($w);
    $h = intval($h);
    if ($w ==0) $w = 658;
    if ($h ==0) $h = 456;
    
    global $DB, $dir_path, $cache_image_path, $CONFIG, $logo;
    $tpl1 = new TemplatePower("plugins/catslides/cat_slides.htm");
    $tpl1->prepare();
    
    $id = intval($_GET['id']);
    $idc = intval($_GET['idc']);
    $tpl1->newBlock("show_slideshow");
    
    $tpl1->assignGlobal("slidewidth",$w);
    $tpl1->assignGlobal("slideheight",$h);
    
    $sql = "SELECT * FROM sys_image WHERE active = 1 AND id_category = $idc ";
    
    $db = $DB->query($sql);
    $i=0;
    while ($rs = mysql_fetch_array($db)) {
        if ($rs['image']) {
            $i++;
            $tpl1->newBlock("list_slide");
            $tpl1->assign("name", $rs['name']);
            $tpl1->assign("image_src", $cache_image_path.cropimage($w,$h,$dir_path.'/'. $rs['image']));
            $tpl1->newBlock("list_slide_number");
            $tpl1->assign("stt", $i);

        }
    }
    return $tpl1->getOutputContent();
}

?>