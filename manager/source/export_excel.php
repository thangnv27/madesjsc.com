<?php

require_once('./export_lib/excell.php');
$header = '<table width="100%" border="0" cellspacing="0" cellpadding="0">  <tr>    <td width="40" height="25" align="center" valign="middle" bgcolor="#CCCCCC">STT</td>    <td width="250" height="25" align="left" valign="middle" bgcolor="#CCCCCC">Email</td>    <td width="250" height="25" align="left" valign="middle" bgcolor="#CCCCCC">Phone</td>    <td height="25" align="left" valign="middle" bgcolor="#CCCCCC">Ghi chú</td>  </tr> ';
$body = '';
$sql = "SELECT  * FROM newsletter ORDER BY id DESC";
$db = $DB->query($sql);
$i = 0;
while ($rs = mysql_fetch_array($db)) {
    if (($rs['table_name'] != '') && ($rs['id_item_name'] != '')) {
        $sqle = "SELECT * FROM $rs[table_name] WHERE $rs[id_item_name] = $rs[id_item_val]";
        $dbe = $DB->query($sqle);
        if ($rse = mysql_fetch_array($dbe)) {
            $ename = $rse['name'];
        }
    } if (strlen($rs['email']) > 5) {
        $i++;
        $body.='  <tr><td>' . $i . '</td><td>' . $rs['email'] . '</td><td>' . $rs['phone'] . '</td><td>' . $ename . '</td></tr>';
    }
}
$footer = '<tr>    <td>&nbsp;</td>    <td>&nbsp;</td>    <td>&nbsp;</td>    <td>&nbsp;</td>  </tr></table>  ';
$data = $header . $body . $footer;
exportExcell($data, 'newsletter_list', 'Danh sách email');
?>