<?php

//Nguyen Van Binh

//suongmumc@gmail.com



defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );

$tpl = new TemplatePower($CONFIG['template_dir']."/video.htm");

$tpl->prepare();

$id 	= intval ($_GET['id']);
$idc 	= intval ($_GET['idc']);
langsite();


$catinfo = Category::categoryInfo($idc);

$tpl->assignGlobal("catname",$catinfo['name']);

$tpl->assignGlobal("catcontent",$catinfo['content']);

$tpl->assignGlobal("pathpage",Get_Main_Cat_Name_path($idc));

$tpl->assignGlobal("dir_path",$dir_path);



$info = new Video;

$info -> __contruct();	




$tpl->printToScreen();



class Video{

	private $numberItemPage=8;

	public function __contruct(){

		global $idc, $id, $DB;

		if($id <= 0){
			$sql = "SELECT * FROM video WHERE active=1 ORDER BY thu_tu DESC, name ASC LIMIT 1";
			$db = $DB->query($sql);
			if($rs = mysql_fetch_array($db)){
				$id = intval($rs['id_video']);
			}
			$this->videoDetail();

		}else{

			$this->videoDetail();	

		}

	}

	

	private function cellVideo(){

		global $DB, $tpl,$idc,$SETTING,$dir_path,$cache_image_path;	

		$tpl->newBlock("videolist");

		$sql = "SELECT * FROM video WHERE active=1 AND (id_category IN(".Category::getParentId($idc).") OR groupcat LIKE '%:".$idc.":%')  $language ORDER BY thu_tu DESC, id_video DESC";

		$db = paging::pagingFonten($_GET['p'],$dir_path."/".url_process::getUrlCategory($idc),$sql,$this->numberItemPage,intval($SETTING->videoinpage));

		$i=0;

		while($rs = mysql_fetch_array($db['db'])){

			$tpl->newBlock("cellvideo");

			$i++;

			$tpl->assign("name",$rs['name']);

			

			$tpl->assign("link_detail",$dir_path."/".url_process::getUrlCategory($rs['id_category']).$rs['url']);

			$parse = parse_url($rs['video']);

			if($parse['host'] == 'youtube.com' || $parse['host'] == 'www.youtube.com'){

				if($rs['image']){

					$tpl->assign("image",'<img src="'.$cache_image_path.cropimage(195,'126',$dir_path.'/'.$rs['image']).'" width="195"  />');

				}else{

					$tpl->assign("image",'<img src="http://img.youtube.com/vi/'.getVideoCode($rs['video']).'/0.jpg" width="195" height="140"  />');	

				}

			}else{

				$tpl->assign("image",'<img src="'.$cache_image_path.cropimage(195,'126',$dir_path.'/'.$rs['image']).'" width="195"  />');	

				

			}

			if($i%4==0){
				 $tpl->assign("pc_break_30",'<div class="c10 mobile-break-30"></div>');
			}
			if($i%2==0){
				 $tpl->assign("pc_break_50",'<div class="c10 mobile-break-50"></div>');
			}

		}

		$tpl->assignGlobal("pages",$db['pages']);

	}

	

	private function videoDetail(){

		global $DB, $tpl, $idc, $dir_path,$id,$cache_image_path;

		$sql = "SELECT * FROM video WHERE active = 1 AND id_video = $id";

		$db = $DB->query($sql);

		if($rs = mysql_fetch_array($db)){

			$tpl->newBlock("videodetail");

			$tpl->assign("name",$rs['name']);

			$tpl->assign("content",$rs['content']);

			$tpl->assign("autostart",",'autostart': 'true'");

			$parse = parse_url($rs['video']);

			if($parse['host'] == 'youtube.com' || $parse['host'] == 'www.youtube.com'){
				$tpl->newBlock("youtube");
				$tpl->assign("video",$rs['video']);
				$tpl->assign("videocode",getVideoCode($rs['video']));
				$tpl->assign("image",'http://img.youtube.com/vi/'.getVideoCode($rs['video']).'/0.jpg');	

			}else{
				$tpl->newBlock("localvideo");
				$tpl->assign("video",$dir_path.'/'.$rs['video']);
				$tpl->assign("image",$cache_image_path.resizeimage(628,'400',$dir_path.'/'.$rs['image']));

			}

		}

		$this->otherVideo();

	}

	private function otherVideo(){

		global $DB, $tpl, $idc, $dir_path,$id,$cache_image_path;

		$tpl->newBlock("othervideo");

		$sql = "SELECT * FROM video WHERE active=1 AND id_video<>$id AND (id_category IN(".Category::getParentId($idc).") OR groupcat LIKE '%:".$idc.":%') ORDER BY thu_tu DESC, id_video DESC ";

		$db = $DB->query($sql);
		$i=0;
		while($rs = mysql_fetch_array($db)){
			
		
			$tpl->newBlock("list1");
			$i++;	
			$tpl->assign("name",$rs['name']);
			$tpl->assign("content",strstrim(strip_tags($rs['content']),10));

			$tpl->assign("link_detail",$dir_path."/".url_process::getUrlCategory($rs['id_category']).$rs['url']);

			$parse = parse_url($rs['video']);

			if($parse['host'] == 'youtube.com' || $parse['host'] == 'www.youtube.com'){

				if($rs['image']){

					$tpl->assign("image",'<img src="'.$cache_image_path.cropimage(300,'200',$dir_path.'/'.$rs['image']).'" width="100%"  />');

				}else{

					$tpl->assign("image",'<img src="http://img.youtube.com/vi/'.getVideoCode($rs['video']).'/0.jpg"  width="100%"  />');	

				}

			}else{

				$tpl->assign("image",'<img src="'.$cache_image_path.cropimage(300,'200',$dir_path.'/'.$rs['image']).'" width="100%"  />');	
			}

			if($i%4==0){
					 $tpl->assign("pc_break",'<div class="c20 pc-break"></div>');
				}
				/*if($i%3==0){
					 $tpl->assign("pc_break_30",'<div class="c20 mobile-break-30"></div>');
				}*/
				if($i%2==0){
					 $tpl->assign("pc_break_50",'<div class="c20 pc-break-50"></div>');
				}
		}

	}

}

?>