<?php


//error_reporting(E_ALL);

defined('_VALID_NVB') or die('Direct Access to this location is not allowed.');

$tpl = new TemplatePower($CONFIG['template_dir'] . "/left_right_col.htm");

$tpl->prepare();

$tpl->assign("_ROOT.menuright",menuRight());
//Get root

$root_idc = Category::get_root_category_id($idc);
$root_cat = Category::categoryInfo($root_idc);
if ($root_cat['image']) {
    $tpl->assign("root_cat_image", '<img  src="'.$cache_image_path.  cropimage(690, 165, $dir_path . '/' . $root_cat['image']) . '" alt="' . $root_cat['name'] . '" width="690" />');
}
$tpl->assignGlobal("cat_name", $root_cat['name']);
$tpl->assignGlobal("cat_link",$dir_path.'/'.$root_cat['url']);


//right col

$cat = new dbMenu;

$dbright = $cat->selectByLocation('inright');
foreach($dbright as $rs){
	if($rs['id_category'] > 0){
		$inrightpage =  explode(":",$rs['inpage']);
		$inrightpage[0]=-3;

		if(in_array($idc,$inrightpage) || in_array('-2',$inrightpage)){
			$tpl->newBlock("right");
			if($rs['data_type'] == 'logo'){
				advRight($rs['id_category']);
			}
			if($rs['data_type'] == 'video'){
				$tpl->newBlock("right");
				$tpl->newBlock("video");
				$tpl->assign("catname",$rs['name']);
				$tpl->assign("link",$dir_path.'/'.$rs['url']);
				videoLeft($rs['id_category']);
			}
			if($rs['data_type'] == 'news'){
				$tpl->newBlock("right");
				$tpl->newBlock("news");
				$tpl->assign("catname",$rs['name']);
				$tpl->assign("link",$dir_path.'/'.$rs['url']);
				$tpl->assign("id_category",$rs['id_category']);
				newsRight($rs['id_category']);
			}
			if($rs['data_type'] == 'product'){
				$tpl->newBlock("right");
					$tpl->newBlock("product");
					$tpl->assign("catname",$rs['name']);
					$tpl->assign("link",$dir_path.'/'.$rs['url']);
					productRight($rs['id_category']);
				
			}
			if($rs['data_type'] == 'support'){
				$tpl->newBlock("right");
				$tpl->newBlock("support_blk");
				$tpl->assign("catname",$rs['name']);
				$tpl->assign("link",$dir_path.'/'.$rs['url']);
				support_online();
			}
		}
	}
}



$tpl->printToScreen();



function advRight($idc){

	global $DB, $tpl,$cache_image_path,$dir_path;
	$idc = intval($idc);
	$lg = new dbLogo;
	$dblg = $lg->logoList($idc);
	foreach($dblg as $rs){
		$tpl->newBlock("advRight");
		if($rs['image']){
		$tpl->assign("image",'<a href="'.$rs['link'].'" target="'.$rs['target'].'"><img src="'.$cache_image_path.resizeimage(260,600,$dir_path.'/'.$rs['image']).'" width="100%" alt="'.$rs['name'].'"></a>');
		}else{
			$tpl->assign("image",$rs['comment']);
		}
	}
}


function newsRight($idc){

	global $DB, $tpl,$cache_image_path,$dir_path,$SETTING,$clsUrl;
	$idc = intval($idc);
	$news = new dbNews();
	$dbnews = $news->newsList($idc, 8);
	$i = 0;
	foreach ($dbnews as $rs) {
        if ($rs['id_news'] > 0) {
			$i++;
			$tpl->newBlock("itemnews");	
			//$tpl->assign('image','<img src="'.$cache_image_path.cropimage(80,60,$dir_path.'/'.$rs['image']).'" width="65" height="40" alt="'.$rs['name'].'" class="image-news">');
			
			$tpl->assign("newsname",$rs['name']);
			$tpl->assign('link_detail',$dir_path . "/" . url_process::getUrlCategory($rs['id_category']) . $rs['url']);
			$tpl->assign("createdate",date('d/m/Y H:i',$rs['ngay_dang']));
		}
	}
}

function photoLeft($idc){
	global $DB,$tpl,$dir_path,$cache_image_path;
	$sql = "SELECT * FROM category WHERE active=1 AND id_category = $idc ORDER BY thu_tu DESC, name ASC LIMIT 1";
	$db = $DB->query( $sql);
	if($rs =mysql_fetch_array($db)){
		$tpl->newBlock("photo");
		$tpl->assign("name",$rs['name']);
		$tpl->assign("link",$dir_path.'/'.$rs['url']);
		if($rs['image']){
			$tpl->assign("image",'<img src="'.$cache_image_path.cropimage(230,152,$dir_path.'/'.$rs['image']).'" alt="'.$rs['name'].'">')	;
		}
	}	
}
function videoLeft($idc){
	global $DB,$tpl,$dir_path,$cache_image_path;	
	$idc = intval($idc);
	
	$sql = "SELECT * FROM video WHERE active=1 AND (id_category IN(".Category::getParentId($idc).") OR  groupcat IN(".$idc.")) ORDER BY thu_tu DESC, name ASC LIMIT 1";
	$db = $DB->query($sql);
	if($rs =mysql_fetch_array($db)){
		$tpl->assign("name",$rs['name']);
		$parse = parse_url($rs['video']);
		if($parse['host'] == 'youtube.com' || $parse['host'] == 'www.youtube.com'){
				if($rs['image']){
					$tpl->assign("image",'<img src="'.$cache_image_path.cropimage(195,'126',$dir_path.'/'.$rs['image']).'" width="100%"  />');
				}else{
					$tpl->assign("image",'<img src="http://img.youtube.com/vi/'.getVideoCode($rs['video']).'/0.jpg" width="100%"   />');	
				}
			}else{
				$tpl->assign("image",'<img src="'.$cache_image_path.cropimage(195,'126',$dir_path.'/'.$rs['image']).'" width="100%"  />');	
			}
		$tpl->assign("link_detail",	$dir_path.'/'. url_process::getUrlCategory($rs['id_category']).$rs['url']);
	}
}

function productRight($idc){
	global $DB,$tpl,$dir_path,$cache_image_path,$SETTING;	
	$idc = intval($idc);
	$sql = "SELECT * FROM product WHERE active=1 AND (id_category IN(".Category::getParentId($idc).") OR  groupcat LIKE '%:".$idc.":%') ORDER BY thu_tu DESC, name ASC LIMIT ".intval($SETTING->productinboxright);
	$db = $DB->query($sql);
	while($rs =mysql_fetch_array($db)){
		$tpl->newBlock("list_pro");
		$tpl->assign("name",$rs['name']);
		if($rs['image']){
			$tpl->assign("image",'<img class="image-pro-left" src="'.$cache_image_path.cropimage(80,60,$dir_path.'/'.$rs['image']).'" alt="'.$rs['name'].'">')	;
		}
		$tpl->assign('link_detail',$dir_path . "/" . url_process::getUrlCategory($rs['id_category']) . $rs['url']);
		$tpl->assign("intro", strstrim(strip_tags($rs['intro']),10));
	}
}
function support_online(){
	global $DB, $tpl,$cache_image_path,$dir_path,$SETTING;
        $db = $DB->query("SELECT * FROM yahoo WHERE active = 1 ORDER BY thu_tu");
        
        $tpl->assign("hotlinesupport",$SETTING->hotlinesupport);
        $tpl->assign("addresssupport",$SETTING->addresssupport);
	while ($rs = mysql_fetch_array($db)) {
		$tpl->newBlock("support_item");
                $tpl->assign("sky",$rs["sky"]);
                $tpl->assign("nic",$rs["nic"]);
                $tpl->assign("name",$rs["name"]);
	}
}
?>