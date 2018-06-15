<?php

//Nguyen Van Binh

//suongmumc@gmail.com



defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );

$tpl = new TemplatePower($CONFIG['template_dir']."/photo.htm");

$tpl->prepare();

$id 	= intval ($_GET['id']);

$idc 	= intval ($_GET['idc']);

langsite();

$tpl->assignGlobal("pathpage",Get_Main_Cat_Name_path($idc));

$tpl->assignGlobal("dir_path",$dir_path);



$catinfo = Category::categoryInfo($idc);

$tpl->assignGlobal("catname",$catinfo['name']);
if(strlen($catinfo['content'])>7)
	$tpl->assignGlobal("catcontent",'<div class="c5"></div>'.$catinfo['content']);

if($catinfo['image']){

			$tpl->assignGlobal("catimage",'<img src="'.$dir_path.'/image.php?w=679&src='.$catinfo['image'].'" alt="'.$catinfo['name'].'" />');

		}

$photo = new Photo;





$tpl->printToScreen();



class Photo{

	public function __construct(){

		global $DB, $tpl, $dklang, $dir_path,$idc,$id;		

		

		

		$sql = "SELECT * FROM category WHERE active=1 AND parentid=$idc";

		$db = $DB->query($sql);

		if(mysql_num_rows($db)>1){

			$tpl->newBlock("album");

			$this->album($idc);

		}else{

			$tpl->newBlock("photocell");

			$this->cellPhoto($idc,$id);

		}

		

		//$tpl->newBlock("photoslide");

	}

	private function cellPhoto($idc,$id=0){

		global $DB, $tpl, $dklang, $dir_path,$SETTING,$cache_image_path;		

		$idc = intval ($idc);

		$sql = "SELECT * FROM photo WHERE active=1 AND id_category IN(".Category::getParentId($idc).") ORDER BY id_photo DESC";

		$db = paging::pagingFonten($_GET['p'],$dir_path."/".url_process::getUrlCategory($idc),$sql,8,12);

		$i=0;

		if($id) $tpl->assign("photoactive","hs.addEventListener(window, 'load', function() {

	document.getElementById('thumb1').onclick();

});

");

		while($rs = mysql_fetch_array($db['db'])){

			if($rs['image']){

				$i++;				

				$tpl->newBlock("cellPhoto")	;

				if($i==1) $tpl->assign("marginleft0","marginleft0");

				$tpl->assign("name",$rs['name']);

				$tpl->assign("content",$rs['content']);


				if($id == $rs['id_photo']) $tpl->assign("loadphoto","thumb1");

					$image = $dir_path."/".$rs['image'];

					$image = str_replace("//","/",$image);

					$tpl->assign("image",'<img src="'.$cache_image_path.cropimage('184','120',$image).'"  alt="'.$rs['name'].'" title="'.$rs['name'].'" />');

				

					$tpl->assign("bigimage",$image);

				if($i>=3) {

					$i=0;

					$tpl->assign("br",'<div class="c15"></div>');

				}

			}

		}

		$tpl->assignGlobal("pages",$db['pages']);

	}

	

	private function album($idc){
			global $DB, $tpl, $language, $dir_path,$SETTING,$cache_image_path;
			$idc = intval($idc);
			$sql = "SELECT * FROM category WHERE parentid = $idc ORDER BY thu_tu ASC, name ASC ";
			$db = $DB->query($sql);
			$i=0;
			while($rs = mysql_fetch_array($db)){
				$i++;
				$tpl->newBlock("listAlbum");
				$tpl->assign("num_photo",$this->countPhoto($rs['id_category']));
				if($i==1) $tpl->assign("marginleft0","marginleft0");
				if($rs['image']){
					 $tpl->assign("image", '<img  src="'.$cache_image_path.  cropimage(184, 120, $dir_path . '/' . $rs['image']) . '" alt="' . $rs['name'] . '" width="100%" />');
				}

				$tpl->assign("name",$rs['name']);
				$tpl->assign("link",$dir_path."/".$rs['url']);
				if($i>=3){
					$i=0;
					$tpl->assign("br","<div class='c20'></div>");
				}
			}

	}
	private function countPhoto($idc){
		global $DB;
		$sql = "SELECT * FROM photo WHERE active=1 AND id_category = $idc";
		$db = $DB->query($sql);
		return mysql_num_rows($db);
	}
	

	

}

?>