<?php

defined('_VALID_NVB') or die('Direct Access to this location is not allowed.');

$id = intval($_GET['id']);
$idc = intval($_GET['idc']);
$template_name = $cateinfo['template_name'];
if ($template_name)
    $tpl = new TemplatePower($CONFIG['template_dir'] . "/$template_name.htm");
else
    $tpl = new TemplatePower($CONFIG['template_dir'] . "/news.htm");
$tpl->prepare();

$tpl->assignGlobal("dir_path", $dir_path);
$tpl->assignGlobal("site_address", $site_address);

 $rs_cat = Category::categoryInfo($idc);
langsite();	
   
$news = new dbNews();


if (!$id) {
	newsCatList();   
} else {
    newsDetail();
}

$tpl->printToScreen();

function listCat(){
	global $DB, $tpl, $cache_image_path, $news, $dir_path, $idc, $SETTING, $clsUrl;
	
	
	$sql = "SELECT * FROM category WHERE active=1 AND parentid = $idc";
	$db = $DB->query($sql);
	while($rs = mysql_fetch_array($db)){
		$tpl->newBlock("list_cat");
		$tpl->assign("catname",$rs['name']);
		$tpl->assign("link",$dir_path.'/'.$rs['url']);
		$dbnews = $news->newsList($rs['id_category'], 4);
		$i = 0 ;
		
		foreach ($dbnews as $rs1) {
			if ($rs1['id_news'] > 0) {
				$i++;

				$tpl->newBlock("list_news");
				
				$tpl->assign(array(
					name => $rs1['name'],
					intro => strip_tags($rs1['intro']),
					newsdate => date("d/m/Y", $rs1['ngay_dang']),
					content => ($rs1['content']),
					link_detail => $dir_path . '/' . url_process::getUrlCategory($rs1['id_category']) . $rs1['url']
				));
				if ($rs1['image']){
					$tpl->assign("image", '<img  src="' . $cache_image_path . cropimage(180, 125, $dir_path . '/' . $rs1['image']) . '" alt="' . $rs1['name'] . '" class="newsimage"/>');
				}
				$tpl->assign("mobile_break", '<div class="c20 mobile-break"></div>');
				if ($i % 2 ==0) {
					$tpl->assign("pc_break", '<div class="c20 pc-break"></div>');
				}
				$i++;
			}
		}
	}
}


function newsCatList() {

		global $DB, $tpl, $cache_image_path, $news, $dir_path, $idc, $SETTING, $clsUrl,$rs_cat;
	
		$dbnews = $news->newsList($idc, $SETTING->newsinpage);
		 
		$tpl->newBlock("newsCat");
		$tpl->assignGlobal("cat_name", $rs_cat['name']);
		if(strlen($rs_cat['content'])>7)
			 $tpl->assignGlobal("cat_content", '<div style="padding-bottom:20px">'. $rs_cat['content'].'</div>');
		$i = 0;
		$ids = "0";
		foreach ($dbnews as $rs) {
			if ($rs['id_news'] > 0) {
				$ids .= ",$rs[id_news]";
				$tpl->newBlock("news_list");
				
				$i++;
				$tpl->assign(array(
					name => $rs['name'],
					intro => strstrim(strip_tags($rs['intro']),40),
					
					content => ($rs['content']),
					link_detail => $dir_path . '/' . url_process::getUrlCategory($rs['id_category']) . $rs['url']
				));
				if($rs['showdate'] == 1) $tpl->assign("createdate",'<div class="createdate">'.date('d/m/Y H:i',$rs['ngay_dang']).'</div>');
				if ($rs['image']) {
					$tpl->assign("image", '<img  src="' . $cache_image_path . cropimage(250, 190, $dir_path . '/' . $rs['image']) . '" alt="' . $rs['name'] . '" width="100%" class="newsimage"/>');
				}
				$tpl->assign("mobile_break", '<div class="c20 mobile-break"></div>');
				if ($i % 2 ==0) {
					$tpl->assign("pc_break", '<div class="c20 pc-break"></div>');
				}
				
			}
		}
		$tpl->assign("newsCat.page",$dbnews['pages']);
        $newsother = $news->news_other($idc, $ids);
        if (count($newsother) > 0) {
            foreach ($newsother as $rse) {
                if ($rse['id_news'] > 0) {
                    $tpl->newBlock("news_other");
                    $tpl->assign("name", $rse['name']);
                    $tpl->assign("link_detail", $dir_path . "/" . url_process::getUrlCategory($rse['id_category']) . $rse['url']);
                }
            }
        }

    $tpl->assignGlobal("pages", $dbnews['pages']);
}

function newsDetail() {

    global $DB, $news, $id, $idc, $tpl, $dir_path, $cache_image_path, $clsUrl,$rs_cat;

    $tpl->newBlock("newsDetail");
	$tpl->assignGlobal("cat_name", $rs_cat['name']);
    $rs = $news->newsDetail($id);
    if ($rs) {
        $tpl->assign(array(
            name => $rs['name'],
            intro => $rs['intro'],
            content => $rs['content'],
        ));

        if ($rs['showdate'] == 1)
            $tpl->assign("createdate", '<div class="createdate">' . date('d/m/Y H:i', $rs['ngay_dang']) . '</div>');
        $newsold = $news->news_new($idc, $id);
        if (count($newsold) > 0) {
            foreach ($newsold as $rse) {
                if ($rse['id_news'] > 0) {
                    $tpl->newBlock("newsest");
                    $tpl->assign("name", $rse['name']);
                    $tpl->assign("link_detail", $dir_path . "/" . url_process::getUrlCategory($rse['id_category']) . $rse['url']);
                }
            }
        }
        $newsold = $news->news_old($idc, $id);
        if (count($newsold) > 0) {
            foreach ($newsold as $rse) {
                if ($rse['id_news'] > 0) {
                    $tpl->newBlock("newsold_list");
                    $tpl->assign("name", $rse['name']);
                    $tpl->assign("link_detail", $dir_path . "/" . url_process::getUrlCategory($rse['id_category']) . $rse['url']);
                }
            }
        }
    }
}


function checkChildCat($idc){
	global $DB;
	$idc = intval($idc);
	
	$sql = "SELECT * FROM category WHERE parentid = $idc";
	$db =$DB->query($sql);
	if(mysql_num_rows($db) >0) return true;
	else return false;
}
?>