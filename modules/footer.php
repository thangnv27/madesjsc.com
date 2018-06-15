<?php

//Nguyen Van Binh
//suongmumc@gmail.com
//error_reporting(E_ERROR);

defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );

include("modules/left_right_col.php");	


$tpl = new TemplatePower($CONFIG['template_dir']."/footer.htm");
$tpl->prepare();
$tpl->assignGlobal("dir_path",$dir_path);

$tpl->assign("_ROOT.boxmenufooter",boxmenufooter());
$tpl->assign("_ROOT.menumobile",menuMobile());
	
$tpl->assign("_ROOT.hotline",$SETTING->hotline);
$tpl->assign("_ROOT.addresssupport",$SETTING->addresssupport);
$tpl->assign("_ROOT.emailsupport",$SETTING->emailsupport);

$tpl->assign(array(
	facebook => $SETTING->facebook,
	twitter => $SETTING->twitter,
	linkedin => $SETTING->linkedin,
	pinterest => $SETTING->pinterest,
	youtube => $SETTING->youtube,
	
));

// copyright 
$copyright = $static->copyright();

$tpl->assignGlobal("copyright",$copyright['content']);
$tpl->assignGlobal("namecopyright",$copyright['name']);
$fanpage = $static->fanpage();
$tpl->assignGlobal("fanpagename",$fanpage['name']);
$tpl->assignGlobal("fanpage",$fanpage['content']);

$tpl->assignGlobal("menuChinhsach",menuChinhsach());
$tpl->assignGlobal("menufooter",menuFooter());
//address footer

$textfooter = $static->textFooter();
$tpl->assignGlobal("namefooter",$textfooter['name']);
$tpl->assignGlobal("textfooter",$textfooter['content']);

$tpl->assignGlobal("callnow",$SETTING->callnow);

$chantrang1 = $static->getInWhere('chantrang1');
$chantrang2 = $static->getInWhere('chantrang2');
$tpl->assignGlobal("chantrang1",$chantrang1);
$tpl->assignGlobal("chantrang2",$chantrang2);

if ($_POST['code'] == 'letter_add') {

    $news_letter_textbox = compile_post('news_letter_textbox');
    if ($news_letter_textbox != ''){
        $sql = "INSERT INTO newsletter(name,email) VALUES ('Khách hàng','$news_letter_textbox')";
        $DB->query($sql);
        alert('Bạn đã đăng ký Email thành công!');

    }
}



//users online

	// count cart

$sql="SELECT * FROM cart WHERE session='".$_SESSION['scid']."'";
$db=$DB->query($sql);
$quantity=0;
while($rs=mysql_fetch_array($db)){
	$quantity=$quantity+$rs['quantity'];
}
$tpl->assignGlobal("quantity",intval($quantity));


$tpl->printToScreen();

?>