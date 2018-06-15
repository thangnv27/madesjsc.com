<?php

//Nguyen Van Binh

//suongmumc@gmail.com



defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );

function slideShow(){

		global $DB, $dir_path, $cache_image_path,$CONFIG,$logo, $language;
		$tpl1 = new TemplatePower($CONFIG['template_dir']."/slidehome.htm");

		$tpl1->prepare();
		$id 	= intval ($_GET['id']);

		$idc 	= intval ($_GET['idc']);

		$tpl1->newBlock("show_slideshow");

		$sql = "SELECT * FROM category WHERE active = 1 $language AND vitri LIKE '%:slideshow:%' ORDER BY thu_tu ASC, name ASC LIMIT 0,1"	;

		$db = $DB->query($sql);

		if($rs = mysql_fetch_array($db)){

			$dblg = $logo->logoList($rs['id_category']);	

			foreach($dblg as $rslg){		

				if($rslg['image']){

					$tpl1->newBlock("list_slide");

					$tpl1->assign("image",'<img src="'.$cache_image_path.resizeimage(820,322,$dir_path.'/'.$rslg['image']).'" alt="'.$rslg['name'].'" width="100%"/>');	
					$tpl1->assign("link",$rslg['link']);
					$tpl1->assign("target",$rslg['target']);

				}

			}
		}

		return $tpl1->getOutputContent();

}

?>