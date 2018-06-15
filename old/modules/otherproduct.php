<?php
//Nguyen Van Binh
//suongmumc@gmail.com

defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );
$tpl = new TemplatePower($CONFIG['template_dir']."/otherproduct.htm");
$tpl->prepare();
$id = intval($_GET['id']);
$idc = intval($_GET['idc']);
$sql = "SELECT * FROM product WHERE active = 1 AND (id_category IN(".Category::getParentId($idc).") OR groupcat LIKE '%:".$idc.":%' ) AND id_product<>$id ORDER BY thu_tu DESC, name ASC";

		$db = paging::pagingAjax($_GET['p'],$dir_path.'/index4.php?page=otherproduct&id=$id&idc=$idc',$sql,8,6);
		$i=0;
		while($rs = mysql_fetch_array($db['db'])){
			$tpl->newBlock("cell1")	;
			$i++;
			if($i==1) $tpl->assign("marginleft0","marginleft0");
			$tpl->assign("name",$rs['name']);
			
			if($rs['image']){
				$tpl->assign("image",'<img src="'.$dir_path.'/image.php?w=230&h=168&src='.$rs['image'].'" width="230" height="168" alt="'.$rs['name'].'" />');
			}
			if(intval($rs['price']>0)){
                if(intval($rs['pricekm'])>0){
                    $tpl->assign('pricekm',"<div class='pricekm'>Giá: <s>".number_format($rs['price'])." VNĐ</s></div>");
                    $tpl->assign('price',"<div class='price'>Giá KM: ".number_format($rs['pricekm'])." VNĐ</div>");
                }else{
                    $tpl->assign('price',"<div class='price'>Giá: ".number_format($rs['price'])." VNĐ</div>");
                }
            }else{
                $tpl->assign('price','<div class="price">'.$rs['price'].'</div>');
            }
			$tpl->assign("baohanh",$rs['baohanh']);
			if($rs['status'] == 1) $tpl->assign("status","Còn hàng");
			else $tpl->assign("status","Hết hàng");
			$tpl->assign("link_detail",$dir_path."/".url_process::getUrlCategory($rs['id_category']).$rs['url']);
			if($i>=3) {
				$i=0;
				$tpl->assign("br",'<div class="c10"></div><div class="linerow"></div><div class="c10"></div>');
			}
		}
	

$tpl->printToScreen();
?>