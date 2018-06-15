<?php

require_once('./export_lib/excell.php');

$header='<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="40" height="25" align="center" valign="middle" bgcolor="#CCCCCC">STT</td>
	<td height="25" align="left" valign="middle" bgcolor="#CCCCCC">Tên</td>
    <td width="250" height="25" align="left" valign="middle" bgcolor="#CCCCCC">Email</td>
    <td width="250" height="25" align="left" valign="middle" bgcolor="#CCCCCC">Phone</td>
    
  </tr> ';

$body ='';

$sql = "SELECT  * FROM newsletter ORDER BY id DESC";
$db = $DB->query($sql);
$i=0;
while($rs = mysql_fetch_array($db))	{
    
    if($_REQUEST['fromdate']){
		$fromdate = $_REQUEST['fromdate'];
		
	}else{
		$fromdate = '01/01/2014 00:00';
	}
	if($_REQUEST['todate']){
		$todate = $_REQUEST['todate'];
	}else{
		$now = date('d/m/Y',time());
		$todate = date($now.' 00:00');
	}
	
	$fromdate1 =strip_date_time($fromdate);
	$todate1 =strip_date_time($todate.' '.'11:59');
	
	$dk = ' WHERE (time >= '.$fromdate1.' AND time<='.$todate1.') ';	
	$sql="Select * from orders $dk ORDER BY code DESC";
	$db = $DB->query($sql);
	while($rs = mysql_fetch_array($db)){
		if (strlen($rs['email']) > 5){
			$i++;
			$body.='  <tr><td>'.$i.'</td><td>'.$rs['name'].'</td><td>'.$rs['email'].'</td><td>'.$rs['phone'].'</td></tr>';	
		}
	}
	
	
        
}

$footer = '
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

  ';
 
 
$data = $header.$body.$footer;
exportExcell($data,'order_list','Danh sách email');

?>