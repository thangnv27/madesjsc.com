<?php 

//defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );

require ("../lib/upload.php");
require ("../lib/imaging.php");

include_once 'inputcontent/ckeditor.php';
include_once 'inputcontent/ckfinder/ckfinder.php';
$_SESSION['IsAuthorized']='binhnv';
$tpl=new TemplatePower("skin/header.tpl");
$tpl->prepare();

$tpl->assignGlobal("loginadminname",$_SESSION["addminname"]);
$tpl->assignGlobal("loginusername",$_SESSION["session_username"] );
$tpl->assignGlobal("site_name",$CONFIG["site_name"]);





$tpl->printToScreen();
?>