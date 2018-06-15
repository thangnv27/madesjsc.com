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

	$sql="Select * from orders where id_order=".$id;

	$a=$DB->query($sql);

	$info=array();

	if ($b=mysql_fetch_array($a))

	{

		$session=$b['session'];

		$tpl->assign("id_order",$b['id_order']);

		$tpl->assign("name",$b['name']);

		$tpl->assign("phone",$b['phone']);

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

		$tpl->assignGlobal("final",number_format($cont['final'],2,',','.'));

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