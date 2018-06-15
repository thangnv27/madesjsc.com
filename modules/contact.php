<?php 

defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );



if($_POST['code'] == 'save')

{

	if ($_SESSION['imagesercurity'] == strtolower(compile_post('sercurity')))

	{

		$a = array();

		$a['fullname']		= compile_post('yourname');

		$a['email']			= compile_post('email');

		$a['subject']		= compile_post('subject');		

		$a['other_request']	= compile_post('other_request');

		$a['createdate'] 	= time();

		$message =

		'

			<table width="100%" border="1" cellspacing="0" cellpadding="0">

			 <tr>

				   <td height="30" colspan="2" align="left" valign="middle"><strong> Thông tin liên hệ: </strong></td>

			</tr>

				 <tr>

				   <td height="30" align="left" style="width:200px;" valign="middle">Họ tên:</td>

				   <td height="30" align="left" valign="middle"><strong>'.$a['fullname'].'</strong></td>

			  </tr>

				 <tr>

				   <td height="30" align="left" valign="middle">E-mail:</td>

				   <td height="30" align="left" valign="middle"><strong>'.$a['email'].'</strong></td>

			  </tr>

				 <tr>

				   <td height="30" align="left" valign="middle">Tiêu đề:</td>

				   <td height="30" align="left" valign="middle"><strong>'.$a['subject'].'</strong></td>

			  </tr>

			  <tr>

				   <td height="30" align="left" valign="middle"><strong>Nội dung liên hệ</strong>: </td>

				   <td height="30" align="left" valign="middle"><i>'.$a['other_request'].'</i></td>



			  </tr>

				 

		  </table>	

			

		';

		  $c = array();

		  $c['name'] = "Contact from " .$a['fullname'];

		  $c['content'] = $message;

		  $c['email'] = $a['email'];

		  $c['createdate'] = $a['createdate'];

		  $b=$DB->compile_db_insert_string($c);

		  $sql="INSERT INTO contact (".$b['FIELD_NAMES'].") VALUES (".$b['FIELD_VALUES'].")";

		  $DB->query($sql);

		  

		  echo "Thông tin liên hệ của bạn đã gửi thành công, chúng tôi sẽ trả lời trong thời gian sớm nhất. Cảm ơn bạn đã quan tâm !";

		  

		  include_once('lib/class.phpmailer.php');

		  include_once('lib/phpmailer.lang-en.php');

	      $subject = "Thông tin liên hệ ".$a['name'] ." - ".date('d/m/Y H:i',$a['createdate']);



			try{

				 sendmail($CONFIG['site_email'],$subject,$message, $site_address);

			}

			catch(exception $e){}		  

		  

		  

	}

	else{

		echo "Mã bảo vệ không đúng !";

	}

}

else

{

	$tpl = new TemplatePower("templates/contact.htm");

	$tpl->prepare();

	$tpl->assignGlobal("pathpage",Get_Main_Cat_Name_path($idc));

	$tpl->assignGlobal("dir_path",$dir_path);

	$tpl->assignGlobal("site_address",$site_address);

	$catinfo = Category::categoryInfo($idc);

	$tpl->assignGlobal("catname",$catinfo['name']);
        $tpl->assignGlobal("catcontent",$catinfo['content']);
	showMap();

	showFormBook();	

	$tpl->printToScreen();		

}


function showFormBook(){

	global $DB, $tpl, $language, $lang;

	$tpl->newBlock("formBook");

}



function showMap(){

	global $DB, $tpl, $language, $lang;

	$sql = "SELECT * FROM contactinfo WHERE active=1 ";

	$db = $DB->query($sql);

	if($rs = mysql_fetch_array($db)){

		$tpl->assignGlobal("contentcontact",$rs['content']);

		$tpl->assignGlobal("title",$rs['title']);

		$tpl->assignGlobal("address",$rs['address']);

		$tpl->assignGlobal("latitude",$rs['latitude']);

		$tpl->assignGlobal("longitude",$rs['longitude']);

	}

	

}





?>