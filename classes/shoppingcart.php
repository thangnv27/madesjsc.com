<?php 
defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );
    /* shoppingcart.php 
     * 
     * 
     */ 
	/*
	Dat session "scid" voi gia tri la md5(uniquid(rand()))
	
	*/
    if(!$session && !$scid) { 
        $session = md5(uniqid(rand())); 
        SetCookie("scid", "$session", time() + 14400); 
    } /* last number is expiration time in seconds, 14400 sec = 4 hrs */ 
     
    class Cart { 
		/*
		Input: $table: ten bang
				$session: gia tri session (cua cookie) vua tao o tren
				$product:	san pham
		Process:	Kiem tra trong bang $table, dk: session='$session' AND product='$product'
			
		Output: ko co record thoa man dk: return 0
				co record thoa man dk: return gia tri field "quantity"
		*/
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

		/*
		Input:	$table: ten bang
				$session: gia tri session (cua cookie) vua tao
				$product: ten san pham them vao
				$quantity: so luong san pham them vao
		Process:	- goi check_item kiem tra trong $table
					- ko co sp truoc: Them moi
						co sp truoc: update (cong them vao gia tri $quantity)
		
		*/
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
         /*
		 	Input:	$table
					$session
					$product
			Process: delete record voi dk session='$session' AND product='$product'
		 */
        function delete_item($session, $id_cart) { 
            $query = "DELETE FROM cart WHERE session='$session' AND id_cart='$id_cart' "; 
            mysql_query($query); 
        } 
         
		 /*
		 	Input:	$table
					$session
					$product
					$quantity
			Output: Update bang $table, gan quantity='$quantity', voi dk session='$session' AND product='$product'
		 
		 */
        function modify_quantity($session, $id_cart, $quantity) { 
            $query = "UPDATE cart SET quantity='$quantity' WHERE session='$session' "; 
            $query .= "AND id_cart='$id_cart' "; 
            mysql_query($query); 
        } 
         /*
		 Input:	$table
		 		$session
		  Process:	delete khoi $table , dk: session='$session'
		 
		 */
        function clear_cart($session) { 
            $query = "DELETE FROM cart WHERE session='$session' "; 
            mysql_query($query); 
        } 
         /*
		 Input:	$table
		 		$session
		Process:	ket noi bang $table va bang inventory (ds product hien co) de tinh tong gia tien
		Output:	tong gia tien
				
		 
		 */
        function cart_total($session) { 
            $query = "SELECT * FROM cart WHERE session='$session' "; 
            $result = mysql_query($query); 
            if(mysql_num_rows($result) > 0) { 
                while($row = mysql_fetch_object($result)) { 
					$prod_cat=$row->prod_cat;
					$id_prod=$row->id_prod;
                    $query = "SELECT price FROM $prod_cat WHERE id_$prod_cat='$id_prod' "; 
                    $invResult = mysql_query($query); 
                    $row_price = mysql_fetch_object($invResult); 
                    $total += ($row_price->price * $row->quantity); 
                } 
            } 
            return $total; 
        }
		
		/*
		Input:	$table
				$session
		Process:	Lien ket bang $table va inventory de dua ra ds hang da dat va tong gia tien
		
		Output:
				Mang 2 chieu $contents[][0..] bat dau tu 0
				$contents['product'][]:	ten hang 
				$contents['price'][]: gia tien tuong ung
				$contents['quantity'][]: so luong
				$contents['total'][]: tong tien cho loai hang nay
				$contents['description'][]: mo ta ve loai hang nay
				$contents['final']: toan bo tong so tien
		
		*/ 
         
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
                $contents["name"][$count] = $row_inventory->name; 
                $contents["price"][$count] = $row_inventory->price; 
                $contents["quantity"][$count] = $row['quantity']; 
                $contents["total"][$count] = ($row_inventory->price * $row['quantity']); 
                $count++; 
            } 
            $total = $this->cart_total($session, $id_prod, $prod_cat); 
            $contents["final"] = $total; 
			$contents["count"]=$count-1;
            return $contents; 
        } 
        /*
		Input:	$table
				$session
		Output: so loai hang chon mua
		
		*/
        function num_items($session) { 
            $query = "SELECT * FROM cart WHERE session='$session' "; 
            $result = mysql_query($query); 
            $num_rows = mysql_num_rows($result); 
            return $num_rows; 
        } 
         /*
		 Input:	$table,$session
		 Ouput: Tong luong hang hoa chon mua
		 */
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
	
	class Order
	{
		function add_order($session,$name,$tel,$email,$address,$addinfo,$miss)
		{
			if ($session and $name and $tel and $email and $address)
			{
				$sql="INSERT INTO orders (session,name,tel,email,address,addinfo,time) VALUES ('$session','$name','$tel','$email','$address','$addinfo','".time()."')";
				mysql_query($sql);
				if ($miss)
				{
					$save['name']=$name;
					$save['tel']=$tel;
					$save['email']=$email;
					$save['address']=$address;
					$save['addinfo']=$addinfo;

				}
				$info=array();
				$info['name']=$name;
				$info['tel']=$tel;
				$info['email']=$email;
				$info['address']=$address;
				$info['addinfo']=$addinfo;
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
?> 
