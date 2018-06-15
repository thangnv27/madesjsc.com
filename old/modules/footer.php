<?php
//Nguyen Van Binh
//suongmumc@gmail.com

defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );
$tpl = new TemplatePower($CONFIG['template_dir']."/footer.htm");
$tpl->prepare();
$tpl->assignGlobal("dir_path",$dir_path);
	
$sql = "SELECT * FROM static WHERE inwhere='infooter'";
$db = $DB->query($sql);
if($rs = mysql_fetch_array($db)){
	$tpl->assignGlobal("footer",$rs['content']);
}
$sql = "SELECT * FROM static WHERE inwhere='footer'";
$db = $DB->query($sql);
if($rs = mysql_fetch_array($db)){
	$tpl->assignGlobal("textfooter",$rs['content']);
}
// count cart
$sql="SELECT * FROM cart WHERE session='".$_SESSION['scid']."'";
$db=$DB->query($sql);
$quantity=0;
while($rs=mysql_fetch_array($db)){
	$quantity=$quantity+$rs['quantity'];
}

$tpl->assignGlobal("quantity",intval($quantity));


$ft = new Footer;
$ft->__contruct();

$tpl->printToScreen();

class Footer{
	
	public function __contruct(){
		$this->boxMenu();	
	}
	
	public function boxMenu(){
		global $DB, $tpl;	
		$sql = "SELECT * FROM category WHERE active=1 AND vitri LIKE '%:menufooter:%' ORDER BY thu_tu ASC, name ASC";
		$db = $DB->query($sql);
		while($rs = mysql_fetch_array($db)){
			switch($rs['colfooter']){
				case 1:
					$block1 ="col1";	
					$block = "submenu1";
					break;
				case 2:
					$block1 ="col2";	
					$block = "submenu2";
					break;
				case 3:
					$block1 ="col3";	
					$block = "submenu3";
					break;
				default:
					$block1 ="col1";	
					$block = "submenu1";
					break;
			}
			if($rs['data_type'] == 'logo'){
				$sql2 = "SELECT * FROM logo WHERE active=1 AND id_category = $rs[id_category] ORDER BY thu_tu DESC, name ASC";
				$db2 = $DB->query($sql2);
				$i=0;
				while($rs2 = mysql_fetch_array($db2)){
					$i++;
					if($i == 1){
						$tpl->newBlock($block1);
						$tpl->assign("name",$rs2['name']);
						$tpl->assign("link",$rs2['link']);
					}else{
						$tpl->newBlock($block);
						$tpl->assign("name1",$rs2['name']);
						$tpl->assign("link1",$rs2['link']);
					}
					
				}
			}else{
				$tpl->newBlock($block1);
				$tpl->assign("name",$rs['name']);
				$tpl->assign("link",url_process::builUrl($rs['id_category']));
				$sql1 = "SELECT * FROM category WHERE active=1 AND parentid = $rs[id_category] ORDER BY thu_tu ASC, name ASC";
				$db1 = $DB->query($sql1);
				while($rs1 = mysql_fetch_array($db1)){
					$tpl->newBlock($block);
					$tpl->assign("name1",$rs1['name']);
					$tpl->assign("link1",url_process::builUrl($rs1['id_category']));
				}
			}
		}	
	}
}

?>