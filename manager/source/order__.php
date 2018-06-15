<?php 
// Nguyen Binh
// suongmumc@gmail.com
// update 04/2008

defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );


	$tpl=new TemplatePower("skin/order.tpl");
	$tpl->prepare();
	
	$fromdate = $_REQUEST['fromdate'];
	$todate = $_REQUEST['todate'];
	if($fromdate){
		$tpl->assignGlobal("fromdate",$fromdate);
	}else{
		$tpl->assignGlobal("fromdate",'01/01/2015');
	}
	if($todate){
		$tpl->assignGlobal("todate",$todate);
	}else{
		$tpl->assignGlobal("todate",date('d/m/Y', time()));
	}
	require "../lib/shoppingcart.php";
	$cart=new Cart;
	$order=new Order1;
	$id=intval($_GET['id']);

	
	if (($_GET['code']=='01') && $id)
	{
		$tpl->newBlock("viewcart");
		$tpl->assignGlobal("id",$id);
		$sql="select * from orders where id_order=".$id;
		
		$a=$DB->query($sql);
	
		$info=array();
	
		if ($b=mysql_fetch_array($a))
		{
			$session=$b['session'];
			$tpl->assign("id_order",$b['id_order']);
			$tpl->assign("name",$b['name']);
			$tpl->assign("phone",$b['phone']);
			$tpl->assign("bill",$b['bill']);
			$tpl->assign($b['billservice'],"selected");
			$tpl->assign("code",$b['code']);
			$tpl->assign("email",$b['email']);
			$tpl->assign("address",$b['address']);
			$tpl->assign("addinfo",$b['addinfo']);
			$tpl->assign("status".$b['status'],"selected='selected'");
	
			$tpl->assign("time",date('d/m/Y H:i',$b['time']))	;	
			$tpl->assign("g_email",$b['g_email']);
			$tpl->assign("g_address",$b['g_address']);
			$tpl->assign("g_addinfo",$b['g_addinfo']);
			$tpl->assign("g_name",$b['g_name']);
			$tpl->assign("g_phone",$b['g_phone']);
			
			$tpl->assign("bill",compile_post('bill'));
			//$cont=$cart->display_contents($scid);
			$cont=$cart->display_contents($b['session']);
			$x=0;
			for ($i=0;$i<=$cont['count'];$i++)
			{
				$x++;
				$tpl->newBlock("list_row_cart");
				$tpl->assign("tt",$x);
				$tpl->assign("name",$cont['name'][$i]);
				$tpl->assign("link",$dir_path.'/'.getLinkPro($cont['id_prod'][$i]));
				$tpl->assign("price",number_format($cont['price'][$i],2,',','.'));
				$tpl->assign("quantity",$cont['quantity'][$i]);
				$tpl->assign("total",number_format($cont['total'][$i],2,',','.'));
				$info['id']=$cont['id_cart'][$i];
				$info['cart']=$info['cart'];
			}
			$final = number_format($cont['final'],2,',','.');
			$tpl->assignGlobal("final",$final);
		}
		if($_GET['act'] == 'updatebill'){		
			$bill = compile_post('bill');
			$billservice = compile_post('billservice');
			$DB->query("UPDATE orders SET bill ='".$bill."', billservice='".$billservice."' WHERE id_order=$id");
			
			$giohang="<table border='1' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-family: Arial; font-size: 10pt; color: #181818' bordercolor='#BFBFBF' width='800' bgcolor='#F3F3F3'>
		  <tr>
			<td width='35' align='center'><strong>STT</strong></td>
			<td width='345'><strong>Tên sản phẩm</strong></td>
			<td width='94' align='center'><strong>Giá</strong></td>
			<td width='82' align='center'><strong>Số lượng</strong></td>
			<td width='102' align='center'><strong>Tổng</strong></td>
		  </tr>";
		  $no=0;
		  for ($i=0;$i<=$cont['count'];$i++)
			{
				$no++;	
				 $giohang.=" <tr>
					<td align='center' bgcolor='#FFFFFF'>".$no."</td>
					<td bgcolor='#FFFFFF'>".$cont['name'][$i]." </td>
					<td align='center' bgcolor='#FFFFFF'>".number_format($cont['price'][$i],2,',','.')." ".$cont['donvitinh'][$i]." đ</td>
					<td align='center' bgcolor='#FFFFFF'>".$cont['quantity'][$i]."</td>
					<td align='center' bgcolor='#FFFFFF'>".number_format($cont['total'][$i],2,',','.')." ".$cont['donvitinh'][$i]." đ</td>
				  </tr>";
			}
		  $giohang.="
		  <tr>
			<td align='center' bgcolor='#FFFFFF'>&nbsp;</td>
			<td colspan='3' align='right' bgcolor='#FFFFFF'><strong>Tổng tiền</strong></td>
			<td colspan='1' bgcolor='#FFFFFF' align='center'><strong>".$final." ".$cont['donvitinh'][$i]." đ</strong></td>
		  </tr>
		</table>";
		
			$sqlc = "SELECT * FROM content_mail WHERE inwhere ='mailbill' ORDER BY thu_tu ASC LIMIT 1";
			$db = $DB->query($sqlc);
			$contentmail = '';
			if($rs = mysql_fetch_array($db)){
				$contentmail = str_replace('[hoten]',$b['name'],$rs['content']);
				$contentmail = str_replace('[yeucau]',$b['addinfo'],$contentmail);
				if($b['billservice'] == 'viettel'){
					$linkbill = '<br>Bạn có thể kiểm tra đơn hàng với liên kết <a href="http://www.viettelpost.com.vn/?tabid=208">http://www.viettelpost.com.vn/?tabid=208</a>';
				}else if($b['billservice'] == 'ems'){
					$linkbill ='<br>Bạn có thể kiểm tra đơn hàng với liên kết <a href="http://ems.com.vn/">http://ems.com.vn/</a>';
				}
				$contentmail = str_replace('[bill]',$bill.$linkbill,$contentmail);
				
				$contentmail = str_replace('[dienthoai]',$b['phone'],$contentmail);
				$contentmail = str_replace('[email]',$b['email'],$contentmail);
				$contentmail = str_replace('[diachi]',$b['address'],$contentmail);
				
				$contentmail = str_replace('[giohang]',$giohang,$contentmail);
			}
			include_once('../lib/class.phpmailer.php');
			include_once('../lib/phpmailer.lang-en.php');
			$subject="Thông báo chuyển hàng - antien.vn";
			sendmail($b['email'],$subject,$contentmail, " antien.vn");
		}
		$DB->query("UPDATE orders SET xem=1 WHERE id_order=$id");
	}
	
	// xoa don hang
	
	if($_GET['code']=='02'){
		$sql="DELETE FROM orders WHERE id_order=$id";
		$DB->query($sql);
		Message::showMessage("success","Đã xóa xong !");
	}
	
	if($_GET['code']=='03'){
		$keyword=$_POST['keyword'];
		$keyword=ereg_replace("#","",$keyword);
		$dk=" WHERE name LIKE '%".$keyword."%' OR code LIKE '%".$keyword."%' OR email LIKE '%".$keyword."%' OR phone LIKE '%".$keyword."%' ";
		showlist($dk);
	}else{
		showlist();
	}
	$tpl->printToScreen();

function showlist($dk='')
{
	global $DB,$tpl;
	$tpl->newBlock("showList");
	if($_REQUEST['fromdate']){
		$fromdate = $_REQUEST['fromdate'];
		
	}else{
		$fromdate = '01/01/2014 00:00';
	}
	if($_REQUEST['todate']){
		$todate = $_REQUEST['todate'];
	}else{
		$now = date('d/m/Y',time());
		$todate = date($now);
	}
	
	$fromdate1 =strip_date_time($fromdate);
	$todate1 =strip_date_time($todate + (24 * 60 * 60)) ;
	
//	echo date('d/m/Y H:i',$fromdate1).'-'.date('d/m/Y H:i',$todate1);
	
	$dk = ' WHERE (time >= '.$fromdate1.' AND time<='.$todate1.') ';
	if($_REQUEST['keyword']){
		$dk.=" AND (name LIKE '%".clean_value($_REQUEST['keyword'])."%' OR email LIKE '%".clean_value($_REQUEST['keyword'])."%')";	
	}
	$sql="Select * from orders $dk ORDER BY code DESC";

	$a=paging::pagingAdmin($_GET['p'],"?page=order&fromdate=".$fromdate."&todate=".$todate."&keyword=".$_REQUEST['keyword'],$sql,8,40);

	$info=array();

	$i=0;



	while ($b=mysql_fetch_array($a['db']))

	{

		$i++;

		$tpl->newBlock("list_order");

		$tpl->assign("tt",$i);

		$tpl->assign("id_order",$b['id_order']);

		$tpl->assign("name",$b['name']);
		$tpl->assign("email",$b['email']);
		$tpl->assign("phone",$b['phone']);
		if($b['bill'])
		$tpl->assign("bill",$b['bill'].' ['.$b['billservice'].']');

		$tpl->assign("code",$b['code']);

		$tpl->assign("time",date("d/m/Y | H:i",$b['time']));

		if($b['xem']==1) $tpl->assign("normal","normal");

		else $tpl->assign("normal","bold");

		if($b['status']==0) $tpl->assign("status","Đang chờ");

		if($b['status']==1) $tpl->assign("status","Hoàn thành");

		if($b['status']==2) $tpl->assign("status","Đã hủy");

		if($b['status']==3) $tpl->assign("status","Đang xử lý");
		if($b['status']==4) $tpl->assign("status","Đã duyệt");

		

		$tpl->assign("linkdel","?page=order&id=$b[id_order]&code=02");

		$tpl->assign("link","?page=order&id=$b[id_order]&code=01");

	}

	$tpl->assignGlobal('pages_items',$a['pages']);



}


function getLinkPro($id){
	global $DB;
	$id = intval($id);
	$sql = "SELECT * FROM product WHERE id_product = $id";
	$db = $DB->query($sql);
	if($rs = mysql_fetch_array($db)){
		return url_process::getUrlCategory($rs['id_category']).$rs['url'];
	}
		
}


?>