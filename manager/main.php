<?php
// log php errors
//@ini_set('log_errors','On'); // enable or disable php error logging (use 'On' or 'Off')
//@ini_set('display_errors','On'); // enable or disable public display of errors (use 'On' or 'Off')
//@ini_set('error_log', $_SERVER['DOCUMENT_ROOT'] . '/manager/php-errors.log'); // path to server-writable log file

// CMS 2011 Nguyen Binh
session_name( 'NVBadmin' );
session_start();
clearstatcache();
// error_reporting (E_ALL); //report all error and notice
// error_reporting(ALL);
define('_VALID_NVB','1');
require( "./initcms.php" );
if($_GET['code']=='logout'){
	session_unset();
 	@session_destroy();
   	redir("admin.php");
}
// must start the session before we create the mainframe object
if ($_SESSION["session_username"] && $_SESSION["session_usertype"] && $_SESSION["session_user_id"] && $_SESSION["session_logintime"])
{
	
//START

	$username=clean_value($_SESSION["session_username"]);
	$id_users=intval($_SESSION["session_user_id"]);
	$super=0;
	if ($_SESSION["session_usertype"]=='super')
	{
		$super=1;
	}
	if ($_SESSION["session_usertype"]=='normal')
	{
		$super=0;
	}
	
	$sql="select * from users where id_users=".$id_users." and username='".$username."' and super=".$super;
	$uu=$DB->query($sql);
	if ($vv=mysql_fetch_array($uu))
	{
	
		$my['username']=$_SESSION["session_username"];
		$my['id']=$_SESSION["session_user_id"];
		$my['usertype']=$_SESSION["session_usertype"];
		$my['session_logintime']=$_SESSION["session_logintime"];
		$my['lastvisit']=date('d/m/Y-H:i',$vv['lastvisit']);
		$my['name']=$vv['name'];
		
	}	
	
	//check permission
		$modules_permission=array();
		if ($_SESSION["session_usertype"]=='super')
		{
			$sql="select * from module";
			$a=$DB->query($sql);
			$i=0;
			while ($b=mysql_fetch_array($a))
			{
				$modules_permission[$i]="source/".$b['gia_tri'];
				$i++;
			}
			$modules_permission[$i]='source/users.php';
			$i++;
			$modules_permission[$i]='source/myadmin.php';
			$i++;
			
		}
		if ($_SESSION["session_usertype"]=='normal')
		{
			$sql="select m.gia_tri from user_module as um inner join module as m on (um.id_module=m.id_module) where um.id_user=".intval($_SESSION["session_user_id"]);
			$a=$DB->query($sql);
			$i=0;
			while ($b=mysql_fetch_array($a))
			{
				$modules_permission[$i]="source/".$b['gia_tri'];
				$i++;
			}
			$modules_permission[$i]='source/myadmin.php';
			$i++;
			
			
		}
		
		
	include("source/header.php");
		$page=$_GET['page'];
		if (!$page)
		{
			include('source/home.php');
		}
		else
		{
			if (@$page=='logout')
			{
				session_unset();
				session_destroy();
				redir("admin.php");
			}
			else
			{	
				$path="source/"."$page.php";
			//	include($path);
				//xac dinh quyen truy cap voi tung module
				if (in_array($path,$modules_permission))
				{
					if (file_exists($path)) 
					{
						include($path);
					}
				}
				else
				{
					print("<center><font color='red'>B&#7841;n kh&#244;ng &#273;&#7911; th&#7849;m quy&#7873;n &#273;&#7875; truy nh&#7853;p v&#224;o ph&#7847;n n&#224;y !<br>H&#227;y li&#234;n h&#7879; v&#7899;i ng&#432;&#7901;i qu&#7843;n tr&#7883; !</font></center>");
				}
			}
		
	}include("source/footer.php");
}
else
{
	session_unset();
 	@session_destroy();
   	redir("admin.php");
}

require( "../endcms.php" );
?>