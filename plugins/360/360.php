<?php

//Nguyen Van Binh
//suongmumc@gmail.com

defined('_VALID_NVB') or die('Direct Access to this location is not allowed.');

function slide360($image_path) {
    global $DB, $dir_path, $cache_image_path, $CONFIG, $logo;

    $tpl1 = new TemplatePower("plugins/360/360.htm");
    $tpl1->prepare();

    /* get image in path */
    if ($image_path) {
        $image_path = substr($image_path, 1, strlen($image_path));
        //$image_path = "uploaded/anh360/sp1";
        $files = scandir($image_path);
        
        ksort($files);
        foreach ($files as $key => $value) {
            if (!in_array($value, array(".", ".."))) {
                $tpl1->newBlock("image_list");
                $tpl1->assign("image_item",'"/'.$image_path."/".$value.'",');
            }
        }
    }


    return $tpl1->getOutputContent();
}

?>