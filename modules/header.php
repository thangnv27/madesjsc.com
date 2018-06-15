<?php

//Nguyen Van Binh

//suongmumc@gmail.com



defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );

$tpl = new TemplatePower($CONFIG['template_dir']."/header.htm");

$tpl->prepare();

$idc = intval($_GET['idc']);

$id = intval($_GET['id']);

$tpl->assignGlobal("dir_path",$dir_path);

 langsite();

$tpl->assignGlobal("lang",$lang);
$tpl->assignGlobal("lang_dir",$lang_dir);

if ($lang=='en')
    $tpl->assignGlobal("langflag",'<a class="lang" href= "/vn/"></a>');
else
    $tpl->assignGlobal("langflag",'<a class="langen" href= "/en/"></a>');

$arr_back_id = Get_Id_Cat_Back($idc);

$arr_back = explode(",",$arr_back_id);



include_once('modules/db.provider/db.menu.php');

include_once('modules/db.provider/db.logo.php');
include_once("modules/db.provider/db.product.php");
include_once('modules/db.provider/db.news.php');
$logo = new dbLogo();



include("modules/db.provider/db.static.php");

$static = new dbStatic();

//$tpl->assignGlobal("hotline",$static->getInWhere('hotline'));
$tpl->assign("_ROOT.message_top", $SETTING->message_top);
$tpl->assign("_ROOT.hotline", $SETTING->hotline);

$tpl->assign("_ROOT.hotlinekythuat", $SETTING->hotlinekythuat);
$tpl->assign("_ROOT.giaohangbanner",$SETTING->giaohangbanner);
$tpl->assign("_ROOT.doihangbanner",$SETTING->doihangbanner);
$tpl->assign("_ROOT.hotrobanner",$SETTING->hotrobanner);
$tpl->assign("_ROOT.sloganbanner",$SETTING->sloganbanner);
 $tpl->assign("_ROOT.address_top",$SETTING->addresssupport);

$getUrl = new url_process;
$uri = $_SERVER['REQUEST_URI'];

$cate = $getUrl->Url_Type($uri);
$meta = $getUrl->get_meta_item($cate['data_type']);


if($_GET['p']>1){

	$ptitle=" - trang ".$_GET['p'];

}

if($page == 'product' && $idc<=0){

	$meta['title']	= "Pin dự phòng Antien: ".$_GET['qr'];

}elseif($page == 'product' && $idc > 0 && $_GET['qr']){

	$meta['title'] = $meta['title'].' : '.$_GET['qr'];

}elseif($page=='cart'){

		

}

$uri = $_SERVER['REQUEST_URI'];
$siteUrl = "http://" . $_SERVER['HTTP_HOST'];

if ($cate['keyword']) {
    $site_keywords = $cate['keyword'];
}


if ($_GET['p'] > 1) {
    $ptitle = " - page " . $_GET['p'];
}

if ($page == 'home' || $page == '') {
    $sql1 = "SELECT * FROM category WHERE data_type='home' $language";
    $db1 = $DB->query($sql1);
    if ($rs1 = mysql_fetch_array($db1)) {
        if ($rs1['title']) {
            $site_name = $rs1['title'] . $ptitle;
        } else {
            $site_name = $rs1['name'] . $ptitle;
        }
        if ($rs1['description']) {
            $site_description = $rs1['description'] . $ptitle;
        } else {
            $site_description = $CONFIG['site_name'] . $ptitle;
        }
        if ($rs1['keyword']) {
            $site_keywords = $rs1['keyword'] . $ptitle;
        } else {
            $site_keywords = $CONFIG['site_keywords'] . $ptitle;
        }
        if($rs1['image']){
            $tpl->assign('site_image', $siteUrl . $rs1['image']);
        }
    }
    $tpl->assign('siteurl', $siteUrl);
} elseif ($page == 'search') {
    $site_name = $keywords . " - " . $CONFIG['site_name'] . $p1title;
} else {
    if ($meta['title']) {
        $site_name = $meta['title'] . $ptitle;
    } else {
        $site_name = $CONFIG['site_name'] . $ptitle;
    }
    if ($meta['description']) {
        $site_description = $meta['description'] . $ptitle;
    } else {
        $site_description = $CONFIG['site_description'] . $ptitle;
    }
    if ($meta['keyword']) {
        $site_keywords = $meta['keyword'] . $ptitle;
    } else {
        $site_keywords = $CONFIG['site_keywords'] . $ptitle;
    }
    if($meta['image']){
        $tpl->assign('site_image', $siteUrl . $meta['image']);
    }
}
if($page=='staticview'){
	$iw = clean_value($_GET['iw']);
	$sql = "SELECT * FROM static WHERE active=1 AND inwhere ='".$iw."'";
	$db = $DB->query($sql);
	if($rs = mysql_fetch_array($db)){
		$staticview_name = $rs['name'];
		$staticview_content=$rs['content'];
	}	
	$tpl->assignGlobal("site_name", $staticview_name.' - '.$site_name);
}else{
	$tpl->assignGlobal("site_name", $site_name);
}

$tpl->assignGlobal("site_description", $site_description);
if ($site_keywords == '') {
    $site_keywords = $CONFIG['site_keywords'];
}
$tpl->assignGlobal("site_keywords", $site_keywords);
$topa=array('&#39;');

$topb=array("'");
$tpl->assignGlobal('toppage',str_replace($topa, $topb, $CONFIG['toppage']));

if($_GET['qr']){
	$tpl->assignGlobal("keywords",$_GET['qr']);
}

$activeid = Get_Id_Cat_Back($idc);

//	logo
$rslg=$logo->logo();
if($rslg['id_logo']>0){
	$tpl->assign("_ROOT.logo",'<a href="'.$rslg['link'].'"><img src="'.$rslg['image'].'" alt="'.$rslg['name'].'" style="max-width:100%"  /></a>')	;
}
$rslg=$logo->banner();
if($rslg['id_logo']>0){
	$tpl->assign("_ROOT.banner",'<a href="'.$rslg['link'].'"><img src="'.$rslg['image'].'" alt="'.$rslg['name'].'" style="max-width:100%" /></a>')	;
}

include_once("modules/menu.php");

$tpl->assign("_ROOT.menutop",menutop());
$tpl->assign("_ROOT.mainmenu",mnuMain());
$tpl->assign("_ROOT.menubar",menubar());
$tpl->assign("_ROOT.qr",$_GET['qr']);
$tpl->assign("_ROOT.cateSearch",cateSearch());

if($page == '' || $page == 'home'){
	
}else{
	$tpl->newBlock("crumb");
	$tpl->assignGlobal("pathpage", Get_Main_Cat_Name_path($idc));
}




$tpl->printToScreen();




?>