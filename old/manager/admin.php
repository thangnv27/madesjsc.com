<?php
//session_save_path('F:/Domains/xepro.com.vn/wwwroot/uploaded/temp/');
session_cache_limiter('none');
session_name( 'NVBadmin' );
session_start();

error_reporting  (E_ERROR | E_WARNING | E_PARSE);
//error_reporting (E_ALL);
define('_VALID_NVB','1');
require( "../initcms.php" );

if (@$_GET['act']=="logout") 
{
  session_unset();
  session_destroy();
  redir("admin.php");
}
if (@$_POST['login'] )
{
	//if($_SESSION['imagesercurityadmin']==$_POST['imagesercurity']){
		
		$username = preg_replace("/[^a-zA-Z0-9_-\s]/", "", compile_post('username'));
		$password = compile_post('password');
		if ($username && $password)
		{
			$password=md5($password);
			$sql="select * from users where password='$password'";
			$db=$DB->query($sql);
			if($rs = mysql_fetch_array($db)){
				$result = $DB->query("select * from users where username='$username' and password='$password'");		
				if(mysql_num_rows($result)>0) 
				{
					
					$a=mysql_fetch_array($result);
					$my['username']=$username;
					$my['lastvisit']="&#272;&#259;ng nh&#7853;p l&#7847;n g&#7847;n &#273;&#7845;y nh&#7845;t: ".date('d/M/y',$a['lastvisit']);
					$my['id']=$a['id_users'];
					$my['name']=$a['name'];
					$my['password']=$a['password'];
					if ($a['super']==1)
					{
						$my['usertype']="super";
					}
					else
					{
						$my['usertype']="normal";
					}
					$logintime = time();
					$_SESSION["session_username"] = $my['username'];
				
					$_SESSION["session_usertype"] = $my['usertype'];				
					$_SESSION["session_user_id"] = $my['id'];
					$_SESSION["session_logintime"] = $logintime;
					$_SESSION["addminname"]=$my['name'];
					$_SESSION["phone"]=$a['telephone'];
					$_SESSION["email"]=$a['email'];
					
					$_SESSION['password'] = $my['password'];
					$_SESSION['IsAuthorized']='binhnv';
					
					session_write_close();
					
					$sql="update users set lastvisit='".$logintime."' where id_users=".$my['id'];
					mysql_query($sql);		
					//chuyen toi trang main.php
					echo '
						<html>
						<head>
						<title>Khu v&#7921;c qu&#7843;n tr&#7883;</title>
						</head>
						<frameset rows="64">
							<frame name="main" src="main.php">
						  <noframes>
						  <body>
						  <p>This page uses frames, but your browser doesn not support them.</p>					
						  </body>
						  </noframes>
						</frameset>
						</html>			
					';
					//redir("main.php");
					die();
				}else{
					echo "<script>alert('Incorrect Username and Password, please try again'); document.location.href='admin.php';</script>\n";
					session_unset();
					@session_destroy();			
					exit();
				} 
			}else {
				echo "<script>alert('Incorrect Username and Password, please try again'); document.location.href='admin.php';</script>\n";
				session_unset();
				@session_destroy();			
				exit();
			}
		}
		else
		{
			echo "<script>alert('Please enter your username and password'); document.location.href='admin.php';</script>\n";
			session_unset();
			@session_destroy();			
			exit();	
		}
	/*}else{
		echo "<script>alert('Mã bảo vệ không đúng'); document.location.href='admin.php';</script>\n";
		session_unset();
			@session_destroy();			
			exit();	
	}*/

}
else{

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login</title>
<link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<script language="javascript" src="js/jquery-1.10.2.min.js"></script>
<script language="javascript" src="js/bootstrap.js"></script>
<script language="javascript" src="js/script.js"></script>
</head>

<body>
<div id="navbar-example" class="navbar navbar-inverse navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container" style="width: auto;">
      <a class="brand" href="#" style="margin-left:20px;">Administrator</a>
    </div>
  </div>
</div>
<form action="?" onsubmit="return check_null_login_binh();" id="loginform" method="post">
  <input type="hidden" name="login" value="1" />
<div class="boxlogin">
	<div class="title">Đăng nhập</div>
    <div class="lineLogin"></div>
    <div class="c20"></div>
    <div style="padding-left:20px; padding-right:20px;" id="alert">
    	
    </div>
   	<div class="boxlogin_txt"><span>Mã đăng nhập:</span><input name="username" id="username" type="text" class="txt" /></div>
    <div class="c10"></div>
    <div class="boxlogin_txt"><span >Mật khẩu:</span><input type="password" id="password" name="password" class="txt" /></div>
    <div class="c10"></div>
    <input name="" type="submit" class="btn btn-primary" style="margin-left:130px;" value="Đăng nhập" />
    <div class="c20"></div>
    <div class="lineLogin"></div>
    <div class="c20"></div>
</div>
</form>
</body>
</html>

<script language="javascript">
$(document).ready(function(){
	$('#username').focus();	
})
function check_null_login_binh(){
	if($('#username').val()==''){
		$('#alert').html('<div class="alert alert-error">Bạn phải nhập vào tên đăng nhập !</div>');
		$('#username').focus();
		return false;
	}
	if($('#password').val()==''){
		$('#alert').html('<div class="alert alert-error">Bạn phải nhập vào mật khẩu đăng nhập !</div>');
		$('#password').focus();
		return false;
	}
}
</script>

</body>
</html>

<?php 
} require( "../endcms.php" );
?>