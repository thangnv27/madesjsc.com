<?php
defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );

$url_filename = $getUrl->get_filename($uri);
$exten_f = array();
$exten_f = explode(".",$url_filename);
$trimold = explode("_",$url_filename);
$filename = $trimold[0].'.html';
if($trimold[1] !=''){
	$old = explode(".",$trimold[1]);
	$idold = intval($old[0]);
}

if(intval($idold) >0){
	$sql = "SELECT * FROM product WHERE id_product='".intval($idold)."'";	
		$db = $DB->query($sql);
		if($rs = mysql_fetch_array($db)){
			$_GET['idp']=$rs['id_product'];
			$_GET['id_product']=$rs['id_product'];
			$_GET['prod_cat']='product';
		}
}else{
	if($url_filename !='' && end($exten_f)=='html'){
		$sql = "SELECT * FROM product WHERE url='".$url_filename."'";	
		$db = $DB->query($sql);
		if($rs = mysql_fetch_array($db)){
			$_GET['idp']=$rs['id_product'];
			$_GET['id_product']=$rs['id_product'];
			$_GET['prod_cat']='product';
		}
	}
}

	//include_once('lib/class.phpmailer.php');
	///include_once('lib/phpmailer.lang-en.php');
    class Cart { 
        function check_item($session, $id_prod, $prod_cat) { 
            $query = "SELECT * FROM cart WHERE session='$session' AND id_prod=$id_prod AND prod_cat='$prod_cat' "; 
            $result = mysql_query($query); 
             
            if(!$result) { 
                return 0; 
            } 

            $numRows = mysql_num_rows($result); 

            if($numRows == 0) { 
                return 0; 
            } else { 
                $row = mysql_fetch_object($result); 
                return $row->quantity; 
            } 
        } 

        function add_item($session, $id_prod, $prod_cat, $quantity) { 

            $qty = $this->check_item($session, $id_prod, $prod_cat); 
            if($qty == 0) { 
                $query = "INSERT INTO cart (session, id_prod, prod_cat, quantity, time) VALUES "; 
                $query .= "('$session', '$id_prod', '$prod_cat', '$quantity', '".time()."') "; 
                mysql_query($query); 
            } else { 
                $quantity += $qty; 
                $query = "UPDATE cart SET quantity='$quantity' WHERE session='$session' AND "; 
                $query .= "id_prod='$id_prod' AND prod_cat='$prod_cat' "; 
                mysql_query($query); 
            } 
        } 
        function delete_item($session, $id_cart) { 
            $query = "DELETE FROM cart WHERE session='$session' AND id_cart='$id_cart' "; 
            mysql_query($query); 
        } 
         
        function modify_quantity($session, $id_cart, $quantity) { 
            $query = "UPDATE cart SET quantity='$quantity' WHERE session='$session' "; 
            $query .= "AND id_cart='$id_cart' "; 
            mysql_query($query); 
        } 
        function clear_cart($session) { 
            $query = "DELETE FROM cart WHERE session='$session' "; 
            mysql_query($query); 
        } 
        function cart_total($session) { 
            $query = "SELECT * FROM cart WHERE session='$session' "; 
            $result = mysql_query($query); 
            if(mysql_num_rows($result) > 0) { 
                while($row = mysql_fetch_object($result)) { 
					$prod_cat=$row->prod_cat;
					$id_prod=$row->id_prod;
					
                    $query = "SELECT price,pricekm FROM $prod_cat WHERE id_$prod_cat='$id_prod' "; 
                    $invResult = mysql_query($query); 
                    $row_price = mysql_fetch_object($invResult); 
					if($row_price->pricekm>0){
						$total += ($row_price->pricekm * $row->quantity); 					
					}else{
						$total += ($row_price->price * $row->quantity); 	
					}
                    
					
					
                } 
            } 
            return $total; 
        }
		
        function display_contents($session) { 
			global $DB;
            $count = 0; 
            $query = "SELECT * FROM cart WHERE session='$session' ORDER BY id_cart "; 
            $a = $DB->query($query); 
            while ($row = mysql_fetch_array($a)) 
			{ 
				$prod_cat=$row['prod_cat'];
				$id_prod=$row['id_prod'];			
                $query = "SELECT * FROM $prod_cat WHERE id_$prod_cat='$id_prod' "; 
                $result_inv = $DB->query($query); 
                $row_inventory = mysql_fetch_object($result_inv); 
				$contents["id_cart"][$count]=$row['id_cart'];
				$contents["id_prod"][$count]=$row['id_prod'];
                $contents["name"][$count] = $row_inventory->name; 
				$contents["image"][$count] = $row_inventory->image; 
 				$contents["ma"][$count]=$row_inventory->ma;
				if($row_inventory->pricekm>0){
					$contents["price"][$count] = $row_inventory->pricekm; 
				}else{
                	$contents["price"][$count] = $row_inventory->price; 
				}
				$contents["don_vi"][$count] = $row_inventory->don_vi; 
                $contents["quantity"][$count] = $row['quantity']; 
				if($row_inventory->pricekm>0){
                	$contents["total"][$count] = ($row_inventory->pricekm * $row['quantity']); 
				}else{
					$contents["total"][$count] = ($row_inventory->price * $row['quantity']); 
				}
                $count++; 
            } 
            $total = $this->cart_total($session, $id_prod, $prod_cat); 
            $contents["final"] = $total; 
			$contents["count"]=$count-1;
            return $contents; 
        } 
        function num_items($session) { 
            $query = "SELECT * FROM cart WHERE session='$session' "; 
            $result = mysql_query($query); 
            $num_rows = mysql_num_rows($result); 
            return $num_rows; 
        } 
        function quant_items($session) { 
            $quant = 0; 
            $query = "SELECT * FROM cart WHERE session='$session' "; 
            $result = mysql_query($query); 
            while($row = mysql_fetch_object($result)) { 
                $quant += $row->quantity; 
            } 
            return $quant; 
        } 
    } 
	
	class Order1
	{
		function add_order($session,$name,$tel,$email,$address,$addinfo,$miss,$username,$phone,$g_phone,$g_addinfo,$g_address,$g_name,$g_email)
		{
			global $DB;
			if ($session and $name  and $email and $address )
			{
				$sql="SELECT max(id_order) as code FROM orders";
				$db=$DB->query($sql);
				$rs=mysql_fetch_array($db);
				$code=intval($rs['code'])+1;
				$sql="INSERT INTO orders (session,name,tel,email,address,addinfo,time,username,phone,code,g_name,g_address,g_email,g_phone,g_addinfo) VALUES ('$session','$name','$tel','$email','$address','$addinfo','".time()."','".$username."','".$phone."','".$code."','".$g_name."','".$g_address."','".$g_email."','".$g_phone."','".$g_addinfo."')";
				
				mysql_query($sql);
				$cartId = mysql_insert_id();
				if ($miss)
				{
					$save['username']=$username;
					$save['name']=$name;
					$save['tel']=$tel;
					$save['phone']=$phone;
					$save['email']=$email;
					$save['address']=$address;
					$save['addinfo']=$addinfo;
					$save['code']=$code;
					
					$save['g_name']=$g_name;
					$save['g_phone']=$g_phone;
					$save['g_email']=$g_email;
					$save['g_address']=$g_address;
					$save['g_addinfo']=$g_addinfo;

				}
				$info=array();
				$info['username']=$username;
				$info['name']=$name;
				$info['tel']=$tel;
				$info['phone']=$phone;
				$info['code']=$code;
				$info['email']=$email;
				$info['address']=$address;
				$info['addinfo']=$addinfo;
				
				$info['g_phone']=$g_phone;
				$info['g_email']=$g_email;
				$info['g_address']=$g_address;
				$info['g_addinfo']=$g_addinfo;
				$info['g_name']=$g_name;
				$info['cartId'] = $cartId;
				return $info;
			}
			else
			{
				echo "Qu&#253; kh&#225;ch &#273;&#227; nh&#7853;p thi&#7871;u th&#244;ng tin c&#7847;n thi&#7871;t !";
				return "";
			}
		}
		function delete_order($id_order)
		{
			global $DB;
			$sql="SELECT session FROM orders WHERE id_order=".$id_order;
			$a=$DB->query($sql);
			if ($b=mysql_fetch_array($a))
			{
				$session=$b['session'];
				$sql="DELETE FROM cart WHERE session='".$session."'";
				mysql_query($sql);	
			}
			$sql="DELETE FROM orders WHERE id_order='".$id_order."'";
			mysql_query($sql);
		}
		function delete_cart_not_order()
		{
			$timelimit=3600*24*10; //10 days
			$sql="DELETE FROM cart HAVING (time+".$timelimit.")<".time." AND session NOT IN (SELECT session FROM orders)";
			mysql_query($sql);
		}
	
	}


$cart=new Cart();

$scid=$_SESSION['scid'];
if (!$scid)
{
	$session = md5(uniqid(rand()));
	$_SESSION['scid']=$session;
	$scid=$session;
}

$tpl = new TemplatePower("templates/cart1.htm");

$tpl->prepare();
$tpl->assign("_ROOT.menubar",menubar());
$prod_cat=str_replace("\\'","",$_GET['prod_cat']);

$prod_cat=str_replace('\\"',"",$prod_cat);
$id=intval($_GET['id_product']);
$tpl->assignGlobal("site_address",$site_address);
$tpl->assignGlobal("dir_path",$dir_path);
$avalcat=array("product");
$tpl->assignGlobal("_shopingcart",_shopingcart);



if ($prod_cat and (!in_array($prod_cat,$avalcat)))
{
	exit();
}
$check = 0;
if($_GET['code'] == 'procheckout'){
	if(strtolower($_POST['sercurity']) == $_SESSION['imagesercurity']){
		
	}else{
		alert("Sai captcha");
		$_GET['code'] = 'add';
		$check = 1;
	}
}


if ($_GET['code']=='add') 
{
	
	if(intval($_GET['qlt'])>0){
		$soluong=intval($_GET['qlt']);
	}else{
		$soluong=1;	
	}

	if ($id and $prod_cat)
	{

		$cart->add_item($scid,$id,$prod_cat,$soluong);
		
	}
	
	$tpl->assign("act_name", "Shopping Cart");
	$cont=$cart->display_contents($scid);
	$tpl->newBlock("giohang");
	printLang();
	$info['grandtotal']=$cont['final'];
	$tpl->assign("giohang_tongcong", @number_format($info['grandtotal'],'2',',','.'));	
	for ($i=0;$i<=$cont['count'];$i++)
	{
		$tpl->newBlock("giohang_row");
		
		$info['prod_name']=$cont['name'][$i];
		$info['prod_image']=$cont['image'][$i];
		$info['price']=$cont['price'][$i];
		$info['ma']=$cont['ma'][$i];
		$info['donvitinh']=$cont['donvitinh'][$i];
		$info['quantity']=$cont['quantity'][$i];
		$info['id_prod']=$cont['id_prod'][$i];
		$info['total']=$cont['total'][$i];
		$info['id']=$cont['id_cart'][$i];
		$tpl->assign("giohang_name", $info['prod_name']);
		$tpl->assign("giohang_image", '<img src="'.$cache_image_path.resizeimage(120,120,$dir_path.'/'.$info['prod_image']).'" class="cartimage" />');
		$tpl->assign("ma", $info['ma']);
		$tpl->assign("id_prod", $info['id_prod']);
		$tpl->assign("giohang_price", @number_format($info['price'],'2',',','.'));
		$tpl->assign("donvitinh", $info['donvitinh']);
		$tpl->assign("giohang_soluong", $info['quantity']);
		$tpl->assign("giohang_tongtien", @number_format($info['total'],'2',',','.'));
		$tpl->assign("giohang_id", $info['id']);
		$tpl->assign("link_detail",get_link_product($info['id_prod']));
	}
	$tpl->newBlock("formuserorder");
	$c = array();
	$c['cusname']=clean_value($_POST['name']);
	$c['cusphone']=clean_value($_POST['phone']);
	$c['cusemail']=clean_value($_POST['email']);
	$c['cusaddress']=clean_value($_POST['address']);
	$c['cusaddinfo']=clean_value($_POST['addinfo']);
	$tpl->assign(array(
		name => $c['cusname'],
		phone => $c['cusphone'],
		email => $c['cusemail'],
		address => $c['cusaddress'],
		addinfo => $c['cusaddinfo']
	));
}

if ($_GET['code']=='proadd')
{

	$tpl->assign("act_name", "Shopping Cart");
	
	$iddel = intval($_GET['iddel']);
	if($iddel > 0){
		$cart->delete_item($scid, $iddel);
	}else{
		$sql="select * from cart where session='".$scid."'";
		$b=$DB->query($sql);
		while ($a=mysql_fetch_array($b))
		{
			$id=$a['id_cart'];
			$quantname='quant'.$id;
			if ($_POST[$quantname]!=$a['quantity'])
			{
				$cart->modify_quantity($scid, $id, doubleval($_POST[$quantname]));
			}
		}
		$d=$DB->query($sql);
		while ($c=mysql_fetch_array($d))
		{
			$id=$c['id_cart'];	
			$delname='del'.$id;
			if ($_POST[$delname])
			{
				$cart->delete_item($scid, $id);
			}
		}
	}
	
	
	
	
	$cont=$cart->display_contents($scid);
	$tpl->newBlock("giohang");
	
	printLang();
	
	$info['grandtotal']=$cont['final'];
	$tpl->assign("giohang_tongcong", @number_format($info['grandtotal'],2,',','.'));	
	for ($i=0;$i<=$cont['count'];$i++)
	{
		
		$tpl->newBlock("giohang_row");
		
		$info['prod_name']=$cont['name'][$i];
		$info['prod_image']=$cont['image'][$i];
		$info['price']=$cont['price'][$i];
		$info['ma']=$cont['ma'][$i];
		$info['id_prod']=$cont['id_prod'][$i];
		$info['donvitinh']=$cont['donvitinh'][$i];
		$info['quantity']=$cont['quantity'][$i];
		$info['total']=$cont['total'][$i];
		$info['id']=$cont['id_cart'][$i];
		$tpl->assign("id_prod", $info['id_prod']);
		$tpl->assign("giohang_name", $info['prod_name']);
		
		$tpl->assign("giohang_image", '<img src="'.$cache_image_path.resizeimage(120,120,$dir_path.'/'.$info['prod_image']).'" class="cartimage"/>');
		$tpl->assign("ma", $info['ma']);
		$tpl->assign("giohang_price", @number_format($info['price'],2,',','.'));
		$tpl->assign("donvitinh", $info['donvitinh']);
		$tpl->assign("giohang_soluong", $info['quantity']);
		$tpl->assign("giohang_tongtien", @number_format($info['total'],2,',','.'));
		$tpl->assign("giohang_id", $info['id']);
		$tpl->assign("link_detail",get_link_product($info['id_prod']));
				
	}
	$info['grandtotal']=$cont['final'];
	$tpl->assign("giohang_tongcong", @number_format($info['grandtotal'],2,',','.'));
	$tpl->newBlock("message");
	$msg="Đã cập nhật !<br>";
	$tpl->assign("msg", $msg);
	$tpl->newBlock("formuserorder");

}


if ($_GET['code']=='checkout0')
{
	$tpl->assign("act_name", "Check out information");
	if($_SESSION['id_userorder']){ 
		$tpl->assign("act_name", "Information of Client");
	
		$sql="select * from userorder where id_userorder='".intval($_SESSION['id_userorder'])."'";
		$a=$DB->query($sql);
		if (mysql_num_rows($a))
		{
			if ($b=mysql_fetch_array($a))
			{
				$info['id_userorder']=$b['id_userorder'];
				$info['username']=$b['username'];
				$info['name']=$b['name'];
				$info['email']=$b['email'];
				$info['phone']=$b['phone'];
				$info['address']=$b['address'];
				$info['addinfo']=$b['addinfo'];
				
				$info['g_name']=$b['g_name'];
				$info['g_email']=$b['g_email'];
				$info['g_phone']=$b['g_phone'];
				$info['g_address']=$b['g_address'];
				$info['g_addinfo']=$b['g_addinfo'];
				
				$tpl->newBlock("formorderreg");
				printLang();
				
				
				$tpl->assign("username", $info['username']);
				$tpl->assign("name", $info['name']);
				$tpl->assign("email", $info['email']);
				$tpl->assign("phone", $info['phone']);
				$tpl->assign("address", $info['address']);
				$tpl->assign("addinfo", $info['addinfo']);
				
				$tpl->assign("g_name", $info['name']);
				$tpl->assign("g_email", $info['email']);
				$tpl->assign("g_phone", $info['phone']);
				$tpl->assign("g_address", $info['address']);
				$tpl->assign("g_addinfo", $info['addinfo']);
				
				
				
			}
		}
	}else{
		$tpl->newBlock("formuserorder");
		
		printLang();
	}
	

}
if ($_GET['code']=='checkout1')
{
	$tpl->assign("act_name", "Information of Client");
	$username=str_replace("'","",$_POST['username']);
	$password=md5($_POST['password']);
	$sql="select * from userorder where username='".$username."' and password='".$password."'";
	$a=$DB->query($sql);
	if (mysql_num_rows($a))
	{
		if ($b=mysql_fetch_array($a))
		{
			$info['id_userorder']=$b['id_userorder'];
			$info['username']=$b['username'];
			$info['name']=$b['name'];
			
			$info['password']=$b['password'];
			$info['email']=$b['email'];
			$info['tel']=$b['tel'];
			$info['phone']=$b['phone'];
			$info['address']=$b['address'];
			$tpl->newBlock("formorderreg");
			printLang();
			$tpl->assign("username", $info['username']);
			$tpl->assign("name", $info['name']);
			$tpl->assign("email", $info['email']);
			$tpl->assign("tel", $info['tel']);
			$tpl->assign("phone", $info['phone']);
			$tpl->assign("address", $info['address']);
			
		}
	}
	else
	{
		$tpl->newBlock("formuserorder");
		printLang();
		$msg="Name or Password 's incorrect !";
		$tpl->assign("msg", $msg);
	}
	

}

if ($_GET['code']=='checkout')
{
	if ($saved)
	{
		$info['name']=$saved['name'];
		$info['tel']=$saved['tel'];
		$info['phone']=$saved['phone'];
		$info['email']=$saved['email'];
		
		$info['address']=$saved['address'];
	}
	$info['main']=form_order($info);
}

if ($_GET['code']=='procheckout')
{
	$tpl->assign("act_name", "Information of Client");

	$order=new Order1;
		
		$info['username']=clean_value($_POST['username']);
		$info['password']=clean_value($_POST['password']);
		$info['cusname']=clean_value($_POST['name']);
		//$info['custel']=clean_value($_POST['tel']);
		$info['cusphone']=clean_value($_POST['phone']);
		$info['cusemail']=clean_value($_POST['email']);
		$info['cusaddress']=clean_value($_POST['address']);
		$info['cusaddinfo']=clean_value($_POST['addinfo']);
		
		$info['g_cusphone']=clean_value($_POST['g_phone']);
		$info['g_cusemail']=clean_value($_POST['g_email']);
		$info['g_cusaddress']=clean_value($_POST['g_address']);
		$info['g_cusaddinfo']=clean_value($_POST['g_addinfo']);
		$info['g_cusname']=clean_value($_POST['g_name']);
		
		$tpl->newBlock("orderuser");
		
		printLang();
		
		
		
		$tpl->assign("cusname", $info['cusname']);
		
		$tpl->assign("cusphone", $info['cusphone']);
		$tpl->assign("cusemail", $info['cusemail']);
		$tpl->assign("cusaddress", $info['cusaddress']);
		$tpl->assign("cusaddinfo", $info['cusaddinfo']);
		
		
		
		$tpl->assign("g_cusname", $info['g_cusname']);
		$tpl->assign("g_cusphone", $info['g_cusphone']);
		$tpl->assign("g_cusemail", $info['g_cusemail']);
		$tpl->assign("g_cusaddress", $info['g_cusaddress']);
		$tpl->assign("g_cusaddinfo", $info['g_cusaddinfo']);
		
		$cont=$cart->display_contents($scid);
		$tpl->newBlock("orderprod");
		
		printLang();
		
		
		for ($i=0;$i<=$cont['count'];$i++)
		{
			$info['prod_name']=$cont['name'][$i];
			$info['prod_image']=$cont['image'][$i];
			$info['price']=$cont['price'][$i];
			$info['ma']=$cont['ma'][$i];
			$info['quantity']=$cont['quantity'][$i];
			$info['donvitinh']=$cont['donvitinh'][$i];
			$info['total']=$cont['total'][$i];
			$info['id']=$cont['id_cart'][$i];
			$tpl->assign("giohang_image", '<img src="'.$cache_image_path.resizeimage(120,120,$dir_path.'/'.$info['prod_image']).'" class="cartimage"/>');
			//$info['cart']=$info['cart'].show_cart_row_order($info);
			$tpl->newBlock("orderprod_row");
			$tpl->assign("giohang_name", $info['prod_name']);
			$tpl->assign("giohang_price", @number_format($info['price'],2,',','.'));
			$tpl->assign("ma", $info['ma']);
			$tpl->assign("giohang_soluong", $info['quantity']);
			$tpl->assign("donvitinh", $info['donvitinh']);
			$tpl->assign("giohang_tongtien", @number_format($info['total'],2,',','.'));
			$tpl->assign("giohang_id", $info['id']);	
				
			
		}
		$tpl->newBlock("tongcong");
		
		printLang();
		$info['grandtotal']=$cont['final'];
		$tpl->assign("giohang_tongcong", @number_format($info['grandtotal'],2,',','.'));
		$tpl->newBlock("chuaxacnhan");
		$tpl->assign("_order",_order);
		$tpl->assign("frm_username", $_POST['username']);
		$tpl->assign("frm_name", $_POST['name']);
		$tpl->assign("frm_password", $_POST['password']);
		$tpl->assign("frm_tel", $_POST['tel']);
		$tpl->assign("frm_phone", $_POST['phone']);
		$tpl->assign("frm_email", $_POST['email']);
		$tpl->assign("frm_address", $_POST['address']);
		$tpl->assign("frm_addinfo", $_POST['addinfo']);
		$tpl->assign("frm_miss", $_POST['miss']);
		
		
		$tpl->assign("frm_g_phone", $_POST['g_phone']);
		$tpl->assign("frm_g_email", $_POST['g_email']);
		$tpl->assign("frm_g_address", $_POST['g_address']);
		$tpl->assign("frm_g_addinfo", $_POST['g_addinfo']);
		$tpl->assign("frm_g_name", $_POST['g_name']);
		
		
}




if ($_GET['code']=='procheckout1')
{
	$tpl->assign("act_name", "Information of Client");
	include_once('lib/class.phpmailer.php');
	include_once('lib/phpmailer.lang-en.php');
	$order=new Order1;
	if ($cusinfo=$order->add_order($scid,compile_post('name'),compile_post('tel'),compile_post('email'),compile_post('address'),compile_post('addinfo'),compile_post('miss'),compile_post('username'),compile_post('phone'),compile_post('g_phone'),compile_post('g_addinfo'),compile_post('g_address'),compile_post('g_name'),compile_post('g_email')))
	{

		
		$code=substr(time(),0,5);
		
		
		$info['cususername']=$cusinfo['username'];
		$info['cusname']=$cusinfo['name'];
		$info['custel']=$cusinfo['tel'];
		$info['cusphone']=$cusinfo['phone'];
		$info['cusemail']=$cusinfo['email'];
		$info['cusaddress']=$cusinfo['address'];
		$info['cusaddinfo']=$cusinfo['addinfo'];
		
		$info['g_cusaddinfo']=$cusinfo['g_addinfo'];
		$info['g_cusname']=$cusinfo['g_name'];
		$info['g_cusemail']=$cusinfo['g_email'];
		$info['g_cusphone']=$cusinfo['g_phone'];
		$info['g_cusaddress']=$cusinfo['g_address'];
		$tpl->newBlock("orderuser");
		
		
		printLang();
		
		$tpl->assignGlobal("code", $code);
		$tpl->assign("username", $info['cususername']);
		$tpl->assign("cusname", $info['cusname']);
		$tpl->assign("cusphone", $info['cusphone']);
		$tpl->assign("custel", $info['custel']);
		$tpl->assign("cusemail", $info['cusemail']);
		$tpl->assign("cusaddress", $info['cusaddress']);
		$tpl->assign("cusaddinfo", $info['cusaddinfo']);
		
		$tpl->assign("g_cusname", $info['g_cusname']);
		$tpl->assign("g_cusphone", $info['g_cusphone']);
		$tpl->assign("g_cusemail", $info['g_cusemail']);
		$tpl->assign("g_cusaddress", $info['g_cusaddress']);
		$tpl->assign("g_cusaddinfo", $info['g_cusaddinfo']);
		
		if($_POST['password']){
			$r['password']=md5($_POST['password']);
			$r['username']=$info['cususername'];
			$r['name']=$info['cusname'];
			
			$r['phone']=$info['cusphone'];
			$r['email']=$info['cusemail'];
			$r['address']=$info['cusaddress'];
			$r['cusaddinfo']=$info['cusaddinfo'];
			
			$r['g_name']=$info['g_cusname'];
			
			$r['g_phone']=$info['g_cusphone'];
			$r['g_email']=$info['g_cusemail'];
			$r['g_address']=$info['g_cusaddress'];
			
			$r['g_ddinfo']=$info['g_cusaddinfo'];
			
			
			$t=$DB->compile_db_insert_string($r);
			$sql="INSERT INTO userorder (".$t['FIELD_NAMES'].") VALUES (".$t['FIELD_VALUES'].")";
			$DB->query($sql);
			
			
			
			// Additional headers
			if($lang==''){
				$subject = 'Ch&#224;o m&#7915;ng b&#7841;n &#273;&#7871;n v&#7899;i website '.$site_address;
				$message='Trang '.$site_address.' da nhan duoc thong tin dang ky thanh vien cua ban. <br>Th&#244;ng tin &#273;&#259;ng nh&#7853;p <br>Username: '.$username."<br>Password: ".$password;
			}else{
				$subject='welcome to '.$site_address;
				$message='Thank you for registering at '.$site_address.' !<br><strong>Acount infomation</strong>  <br>Username:'.$info['cususername']."<br>Password: ".compile_post('password');
			}
			$to=$info['cusemail'];
			
			
			
			
			// Mail it
			$to.=",".$from;
			//sendmail($to,$subject,$headers,$message, 'tnt');
		//	sendmail($to,$from,$subject,$message, $name);
			//sendmail($to,$subject,$headers,$message);
			//sendmail($CONFIG['site_mail'],$subject,$headers,$message);
		}	
		$DB->query("UPDATE userorder SET level=level+1 WHERE username='".$info['cususername']."'");
		
		$cont=$cart->display_contents($scid);
		$tpl->newBlock("orderprod");
		
		
		printLang();
		
		for ($i=0;$i<=$cont['count'];$i++)
		{
			$info['prod_name']=$cont['name'][$i];
			$info['ma']=$cont['ma'][$i];
			$info['price']=$cont['price'][$i];
			$info['quantity']=$cont['quantity'][$i];
			$info['donvitinh']=$cont['donvitinh'][$i];
			$info['total']=$cont['total'][$i];
			$info['id']=$cont['id_cart'][$i];
			$info['prod_image']=$cont['image'][$i];
			//$info['cart']=$info['cart'].show_cart_row_order($info);
			
			$tpl->newBlock("orderprod_row");
			$tpl->assign("giohang_image", '<img src="'.$cache_image_path.resizeimage(120,120,$dir_path.'/'.$info['prod_image']).'" class="cartimage"/>');
			$tpl->assign("giohang_name", $info['prod_name']);
			$tpl->assign("ma", $info['ma']);
			$tpl->assign("giohang_price",  number_format($info['price'],2,',','.'));
			$tpl->assign("giohang_soluong", $info['quantity']);
			$tpl->assign("donvitinh", $info['donvitinh']);
			$tpl->assign("giohang_tongtien", number_format($info['total'],2,',','.'));
			$tpl->assign("giohang_id", $info['id']);		
			
		}
		$tpl->newBlock("tongcong");
		printLang();
		$info['grandtotal']=$cont['final'];
		$tpl->assign("giohang_tongcong", number_format($info['grandtotal'],2,',','.'));
		
		$content='';
		
		
		$content="<table width='800' border='0' style='font-family: Arial; font-size: 10pt; color: #181818;border-collapse:collapse'>
		  <tr>
			<td colspan='3'></td>
		  </tr>
		  <tr>
			<td colspan='3'>
			<p>Thông tin đặt hàng từ, ".$info['cusname']."</p>
			<!--Cám ơn quý khách hàng ".$info['cusname']." đã đặt hàng từ website <strong>".$site_address."</strong>!<br>
			  Chúng tôi xin xác nhận đơn đặt hàng của quý khách vào ngày ".date('d/m/Y',time())." theo những thông tin dưới đây:--> </td>
		  </tr>
		
		  <tr>
			<td>Số đơn đặt hàng </td>
			
			<td>#".$code."</td>
		  </tr>
		  <tr>
			<td>Website</td>
			
			<td><a href='".$site_address."' target='_blank'><strong>".$site_address."</strong></a></td>
		  </tr> 
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			
		  </tr>
		  <tr>
		    <td colspan='2' style='background:#EEE;'><strong>Thông tin khách hàng</strong></td>
  </tr>
		  <tr>
			<td>Tên:</td>
			
			<td>".$info['cusname']."</td>
		  </tr>
		  <tr>
			<td>Email:</td>
			
			<td>".$info['cusemail']."</td>
		  </tr>
		  <tr>
			<td>Điện thoại:</td>
			
			<td>".$info['cusphone']."</td>
		  </tr>
		  <tr>
			<td>Địa chỉ:</td>
			<td>".$info['g_cusaddress']."</td>
		  </tr>
		 <tr>
		    <td>Thông tin thêm:</td>
		    <td>".$info['cusaddinfo']."</td>
  </tr>
		 
		  <tr>
			<td><strong>Tổng tiền</strong></td>
			
			<td><strong>".number_format($info['grandtotal'],2,',','.')."</strong></td>
		  </tr>
		  <tr>
			<td>Chi tiết đơn đặt hàng</td>
			
			<td>Xem bảng dưới</td>
		  </tr>
		</table>
<br>
		<table border='1' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-family: Arial; font-size: 10pt; color: #181818' bordercolor='#BFBFBF' width='800' bgcolor='#F3F3F3'>
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
				 $content.=" <tr>
					<td align='center' bgcolor='#FFFFFF'>".$no."</td>
					<td bgcolor='#FFFFFF'>".$cont['name'][$i]." </td>
					<td align='center' bgcolor='#FFFFFF'>".number_format($cont['price'][$i],2,',','.')." ".$cont['donvitinh'][$i]."</td>
					<td align='center' bgcolor='#FFFFFF'>".$cont['quantity'][$i]."</td>
					<td align='center' bgcolor='#FFFFFF'>".number_format($cont['total'][$i],2,',','.')." ".$cont['donvitinh'][$i]."</td>
				  </tr>";
			}
		  $content.="
		  <tr>
			<td align='center' bgcolor='#FFFFFF'>&nbsp;</td>
			<td colspan='3' align='right' bgcolor='#FFFFFF'><strong>Tổng tiền</strong></td>
			<td colspan='1' bgcolor='#FFFFFF' align='center'><strong>".number_format($info['grandtotal'],2,',','.')." ".$cont['donvitinh'][$i]."</strong></td>
		  </tr>
		</table>
		<br>
		
		";
		
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
			<td colspan='1' bgcolor='#FFFFFF' align='center'><strong>".number_format($info['grandtotal'],2,',','.')." ".$cont['donvitinh'][$i]." đ</strong></td>
		  </tr>
		</table>";
		
		
			// Additional headers
			
			$subject='Thong tin dat hang tu '. $site_address." số đơn hàng: #".$code;
		
			$to=$CONFIG['site_email'];
			
			// Additional headers
			$headers .= 'To:' .$to. "\r\n";
			$headers .= 'From: Website '.$site_address." - ".$info['cusemail'] . "\r\n";
			// Mail it
			//mail($to, $subject, $content, $headers);
			//mail($info['cusemail'], $subject, $content1, $headers);
		
			sendmail($to,$subject,$content, " antien.vn");
		
		
		$sqlc = "SELECT * FROM content_mail WHERE inwhere ='replaymailorder' ORDER BY thu_tu ASC LIMIT 1";
		$db = $DB->query($sqlc);
		$contentmail = '';
		if($rs = mysql_fetch_array($db)){
			$contentmail .= str_replace('[hoten]',$info['cusname'],$rs['content']);
			$contentmail = str_replace('[dienthoai]',$info['cusphone'],$contentmail);
			$contentmail = str_replace('[email]',$info['cusemail'],$contentmail);
			$contentmail = str_replace('[diachi]',$info['cusaddress'],$contentmail);
			$contentmail = str_replace('[yeucau]',$info['cusaddinfo'],$contentmail);
			$contentmail = str_replace('[giohang]',$giohang,$contentmail);
		}
		
		$cussubject='Thông tin đặt hàng tại '.$site_address;
		sendmail($info['cusemail'],$cussubject,$contentmail, " antien.vn");
		//	sendmail($to,$subject,$content, $site_name);
		$tpl->newBlock("daxacnhan");
		header('Location: '.$dir_path.'/view-cart/?cid='.intval($cusinfo['cartId'] ));
	//	$DB->query("DELETE FROM cart WHERE session='".$scid."'");
		printLang();
		
	}
	
}

$tpl->printToScreen();

function printLang(){
	global $tpl;
	$tpl->assign(array(
			"_username"				=>_username,
			"_password"				=>_password,
			"_confirm_password"		=>_confirm_password,
			"_phonenumber"			=>_phonenumber,
			"_email"				=>_email,
			"_address"				=>_address,
			"_request"				=>_request,
			"_notregistered"		=>_notregistered,
		
			"_ROOT._order"				=>_order,
			"_order"				=>_order,
			"_cart"					=>_cart,
			"_useralreadyofwebsite"	=>_useralreadyofwebsite,
			"_ok"					=>_ok,
			"_fullinfomation"		=>_fullinfomation,

			"_totalamount"			=>_totalamount,
			"_fullname"				=>_fullname,
			"giohang._productname"	=>_productname,
			"_price"				=>_price,
			"_quality"				=>_quality,
			"_total"				=>_total,
			"_totalamount"			=>_totalamount,
			"_delete"				=>_delete,

			"_productname"			=>_productname,
			"_update"				=>_update,
			"_order"				=>_order,
			"_thankyou"				=>_thankyou,
			"_price"				=>_price,
			"_quality"				=>_quality,
			"_continue"				=>_continue,
			"_update"				=>_update,
			"_cusinfomation"		=>_cusinfomation,
			"_login"				=>_login,
			
			"_enterusername"		=>_enterusername,
			"_enterpassword"		=>_enterpassword,
			"_entername"			=>_entername,
			"_enterphonenumber"		=>_enterphonenumber,
			"_enteremail"			=>_enteremail,
			"_enteraddress"			=>_enteraddress,
			"_STT"					=>_STT,
			"_orderdetail"			=>_orderdetail,
			"_seetable"				=>_seetable
		));
}


function get_link_product($id){
	global $DB,$dir_path;
	$sql="SELECT * FROM product WHERE id_product=$id";
	$db=$DB->query($sql);
	if($rs=mysql_fetch_array($db)){
		$linkdetail = $dir_path."/".get_url_category($rs['id_category']).$rs['url'];
	}
	return $linkdetail;
}
?>