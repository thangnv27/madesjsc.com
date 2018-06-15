<?php
defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );
require ("../lib/upload.php");
require ("../lib/imaging.php");
include_once 'inputcontent/ckeditor.php';
include_once 'inputcontent/ckfinder/ckfinder.php';
$_SESSION['IsAuthorized']='binhnv';
$tpl=new TemplatePower("skin/header.tpl");
$tpl->prepare();
if ($_GET['lang'] == 'en')
    $_SESSION["lang"] = 'en'; 
elseif ($_GET['lang'] == 'default')
    $_SESSION["lang"] = ''; 
if ($_SESSION['lang']) {
    $lang = $_SESSION['lang'];
    $lang_dir = 'en/';
    $language = " AND category.lang = 'en' ";
} else {
    $lang = '';
    $lang_dir = '';
    $language = " AND category.lang <> 'en' ";
}
$tpl->assignGlobal('lang',$lang);
$tpl->assign("lang".$lang,"selected");
$tpl->assignGlobal("loginadminname",$_SESSION["addminname"]);
$tpl->assignGlobal("loginusername",$_SESSION["session_username"] );
$tpl->assignGlobal("site_name",$CONFIG["site_name"]);
$tpl->printToScreen();