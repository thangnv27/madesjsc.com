<?php
//Nguyen Van Binh
//suongmumc@gmail.com

defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );
$tpl = new TemplatePower($CONFIG['template_dir']."/contact.htm");
$tpl->prepare();
$tpl->assignGlobal("pathpage",Get_Main_Cat_Name_path($idc));
$tpl->assignGlobal("dir_path",$dir_path);

$sql = "SELECT * FROM contactinfo WHERE active=1 ";
$db = $DB->query($sql);
if($rs = mysql_fetch_array($db)){
	$tpl->newBlock("contactinfo");
	$tpl->assign("contentcontact",$rs['content']);
	$tpl->assign("title",$rs['title']);
	$tpl->assign("address",$rs['address']);
	$tpl->assign("latitude",$rs['latitude']);
	$tpl->assign("longitude",$rs['longitude']);
}




if($_POST['code'] == 'save'){
	$a = array();
	$a['fullname']		= compile_post('fullname');
	$a['email']			= compile_post('email');
	$a['phonenumber']	= compile_post('phonenumber');
	$a['address']		= compile_post('address');
	$a['request']		= compile_post('request');
	$a['createdate'] 	= time();
	
	$message ='<table width="100%" border="0" cellspacing="0" cellpadding="5">
	  <tr>
	    <td width="120">Họ tên </td>
	    <td>'.$a['fullname'].'</td>
	  </tr>
	  <tr>
	    <td>Email </td>
	    <td>'.$a['email'].'</td>
	  </tr>
	  <tr>
	    <td>Điện thoại </td>
	    <td>'.$a['phonenumber'].'</td>
	  </tr>
	  <tr>
	    <td>Địa chỉ</td>
	    <td>'.$a['address'].'</td>
	  </tr>
	  <tr>
	    <td>Nội dung </td>
	    <td>'.$a['request'].'</td>
	  </tr>
	  </table>';
	  $c = array();
	  $c['name'] = $a['fullname'];
	  $c['content'] = $message;
	  $c['email'] = $a['email'];
	  $c['createdate'] = $a['createdate'];
	  $b=$DB->compile_db_insert_string($c);
	  $sql="INSERT INTO contact (".$b['FIELD_NAMES'].") VALUES (".$b['FIELD_VALUES'].")";
	  $DB->query($sql);
	  
	  $tpl->assignGlobal ("message","Thông tin liên hệ của quý khách đã được gửi đi, chúng tôi sẽ trả lời quý khách trong thời gian sớm nhất. <br>Cảm ơn !");
	  include_once('lib/class.phpmailer.php');
		include_once('lib/phpmailer.lang-en.php');
		$subject = "Thông tin liên hệ từ ".$a['name'] ." - ".date('d/m/Y H:i',$a['createdate']);
		sendmail($CONFIG['site_email'],$subject,$message, " ngoclanmobile.vn");
		

}

$tpl->printToScreen();
?>