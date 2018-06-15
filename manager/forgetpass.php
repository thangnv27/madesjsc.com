<?php 
error_reporting(0);
define('_VALID_NVB','1');
session_cache_limiter('none');
session_name( 'NVBadmin' );
session_start();
require( "./initcms.php" );
	if($_POST['code'] == 'check'){
		$email = compile_post('email');
		$_SESSION['count'] = intval($_SESSION['count']) + 1;
		if($_SESSION['count'] <= 5){
			$sql = "SELECT * FROM users WHERE (email = '$email')";
			$db = $DB->query($sql);
			if($rs = mysql_fetch_array($db)){
				
				$hash = md5('nb'.$rs['username'].$rs['password']);	
				$link=$site_address.$dir_path."/manager/forgetpass.php?code=check&email=".$rs['email']."&hash=$hash";
				include_once('../lib/class.phpmailer.php');
				include_once('../lib/phpmailer.lang-en.php');
				
			    $subject = "Lấy lại mật khẩu từ website ".$site_address;
				$message = '<strong>Chào bạn,'.$rs['name'].'</strong>';
				$message.= '<br />Bạn hoặc ai đó đã yêu cầu lấy lại mật khẩu quản trị từ websie '.$site_address.' nếu không đúng vui lòng bỏ qua email này. <br />'. 'Nếu đúng bạn muối lấy lại mật khẩu, hãy nhấp vào link dưới đây:';
				$message.='<a href="'.$link.'" target="_blank" />Lấy lại mật khẩu</a> hoặc '.$link;
				
				try{
					sendmail(trim($rs['email']),$subject,$message, $site_address);
					$error_message = '<div class="alert alert-success">Thông tin lấy lại mật khẩu của bạn đã được gửi vào email. Bạn hãy check mail và làm theo hướng dẫn</div>';
				}catch(exception $e){
				
				}	
			}else{
				$error_message = '<div class="alert alert-error">Email không chính xác</div>';
			}
			
		}else{
			$error_message = '<div class="alert alert-error">Bạn đã làm quá số lần quy định để lấy lại mật khẩu</div>';
		}
	}else if($_GET['hash']) {
		
		$email = clean_value($_GET['email']);
		$hash=clean_value($_GET['hash']);
		
		$sql = "SELECT * FROM users WHERE (email = '$email')";
		$db = $DB->query($sql);
		if($rs = mysql_fetch_array($db)){
			if($hash = md5('nb'.$rs['username'].$rs['password'])){	
				$newpass=rand(111111111,9999999999);
				$message='<strong>Chào bạn, '.$rs['name'].'</strong> <br>';
				$message.='Bạn đã thực hiện đổi mật khẩu cho tài khoản của bạn tại website '. $site_address.'<br />';
				$message.='Hãy truy cập với thông tin sau:';
				$message.='<br />Mã đăng nhập:'.$rs['username'];
				$message.='<br />Mật khẩu:'.$newpass;
				$DB->query("UPDATE users SET password='".md5($newpass)."' WHERE (email ='$rs[email]')");
				include_once('../lib/class.phpmailer.php');
				include_once('../lib/phpmailer.lang-en.php');
				$subject = 'Mật khẩu mới - '.$site_address;
				sendmail($rs['email'],$subject,$message, $site_address);
				$error_message = '<div class="alert alert-success">Mật khẩu của bạn đã được gửi vào email, bạn hãy check mail để lấy thông tin đăng nhập.</div>';
			}else{
				$error_message ='<div class="alert alert-error">Thông tin tài khoản không phù hợp!</div>';
			}
		}else{
			$error_message ='<div class="alert alert-error">Thông tin tài khoản không phù hợp!</div>';	
		}
	}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Quên mật khẩu</title>
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<script language="javascript" src="js/jquery-1.10.2.min.js"></script>
<style>
body {
	font-family:Arial, Helvetica, sans-serif;
	font-size:12px;
}
</style>
</head>
<body>
<div class="boxlogin" style="width:380px; margin:0 auto; margin-top:100px;">
	<div class="title">Lấy lại mật khẩu</div>
    <div class="lineLogin"></div>
    <div class="c20"></div>
  	<div style="padding:10px;">
	  <form action="" method="post" id="forget_form">
	    <input type="hidden" name="code" value="check">
	    <?php echo $error_message ?>
	    <div class="alert alert-error" id="alerterror" style="display:none">Bạn cần nhập vào địa chỉ email tài khoản của bạn!</div>
	    <div>
	      <div class="input-prepend"><span class="add-on">Email</span>
	        <input class="span2" id="email" name="email" type="text" placeholder="Email tài khoản của bạn" style="width:304px;">
	      </div>
	    </div>
	    <div style="padding-top:10px; text-align:center">
	      <button class="btn btn-primary">Lấy lại mật khẩu</button>
	    </div>
	  </form>
  </div>
</div>

<script>$(function(){$('#forget_form').submit(function(){if($('#email').val() == ''){$('#alerterror').show();	$('#email').focus();return false;}});});</script>
<?php require( "../endcms.php" ); ?>
</body>
</html>