<?php
//Nguyen Van Binh
//suongmumc@gmail.com

defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );
$tpl = new TemplatePower($CONFIG['template_dir']."/leftcol.htm");
$tpl->prepare();
$tpl->assignGlobal("dir_path",$dir_path);
	$left = new LeftCol;
	$left->menuLeft();
	$left->adv();
$tpl->printToScreen();

class LeftCol{
 	public function menuLeft(){
		global $DB, $tpl, $dir_path,$idc;
		$sql = "SELECT * FROM category WHERE active=1 AND vitri LIKE '%:menuleft:%' ORDER BY thu_tu ASC, name ASC";
		$db = $DB->query($sql);
		$i=0;
		$ar = Get_Id_Cat_Back($idc);
		$arr = explode(",",$ar);
		while($rs = mysql_fetch_array($db)){
			$i++;
			$tpl->newBlock("menuleft");
			$tpl->assign("name",$rs['name']);
			$tpl->assign("link",url_process::builUrl($rs['id_category']));
			$sql1 = "SELECT * FROM category WHERE active=1 AND parentid = $rs[id_category] ORDER BY thu_tu ASC, name ASC";
			$db1 = $DB->query($sql1);
			$tpl->newBlock("showleft");
			if(mysql_num_rows($db1)>0){
				while($rs1 = mysql_fetch_array($db1)){
					$tpl->newBlock("subleft");
					if(in_array($rs1['id_category'],$arr)) $tpl->assign("active","active");
					$tpl->assign("name1",$rs1['name']);
					$tpl->assign("link1",url_process::builUrl($rs1['id_category']));
					
					$sql2 = "SELECT * FROM category WHERE active=1 AND parentid = $rs1[id_category] ORDER BY thu_tu ASC, name ASC";
					$db2 = $DB->query($sql2);
					if(mysql_num_rows($db2)>0){
						$tpl->newBlock("showleft2");
						if(mysql_num_rows($db2)>0){
							while($rs2 = mysql_fetch_array($db2)){
								$tpl->newBlock("subleft2");
								$tpl->assign("name2",$rs2['name']);
								$tpl->assign("link2",url_process::builUrl($rs2['id_category']));
								
							}
						}
					}
				}
			}
		}	
	}	
	
	public function adv(){
		global $DB, $tpl, $dir_path,$page;
		if($page == 'home' || $page == ''){
			
		}else{
			
			$sql = "SELECT * FROM category WHERE active = 1 AND vitri LIKE '%:left:%' AND (data_type='logo' OR data_type ='news') ORDER BY thu_tu ASC, name ASC";
			$db = $DB->query($sql);
			while($rs = mysql_fetch_array($db)){
				
				if($rs['data_type'] == 'logo'){
					$tpl->newBlock("leftcol");
					$tpl->newBlock("logoleft");
					if($rs['logotitleleft']==1){
						$tpl->newBlock("logotitle");
						$this->advLeftTitle($rs['id_category']);
					}else{
						$tpl->newBlock("logonotitle");
						$this->advLeft($rs['id_category']);
					}
				}else if($rs['data_type'] == 'news'){
					$tpl->newBlock("leftcol");
					$tpl->newBlock("news");
					$tpl->assign("name",$rs['name']);
					$tpl->assign("link",$dir_path."/".$rs['url']);
					$this->newsLeft($rs['id_category']);
				}
				
			}
		}
	}
	
	public function advLeftTitle($idc){
		global $DB, $tpl, $dir_path;
		$sql = "SELECT * FROM logo WHERE active=1 AND (id_category IN (".Category::getParentId($idc).") OR groupcat LIKE '%:".$idc.":%') ORDER BY thu_tu DESC, name ASC";
		$db = $DB->query($sql);
		while($rs = mysql_fetch_array($db)){
			$tpl->newBlock("list_logo_title");
			if($rs['image']){
				$tpl->assign("image",'<a href="'.$rs['link'].'" target="'.$rs['target'].'"><img src="'.$dir_path."/image.php?w=138&src=".$rs['image'].'" width="138" alt="'.$rs['name'].'" /></a>')	;
			}else{
				$tpl->assign("image",$rs['comment']);
			}
		}
	}
	public function advLeft($idc){
		global $DB, $tpl, $dir_path;
		$sql = "SELECT * FROM logo WHERE active=1 AND (id_category IN (".Category::getParentId($idc).") OR groupcat LIKE '%:".$idc.":%') ORDER BY thu_tu DESC, name ASC";
		$db = $DB->query($sql);
		while($rs = mysql_fetch_array($db)){
			$tpl->newBlock("list_logo_no_title");
			if($rs['image']){
				$tpl->assign("image",'<a href="'.$rs['link'].'" target="'.$rs['target'].'"><img src="'.$dir_path."/image.php?w=155&src=".$rs['image'].'" width="155" alt="'.$rs['name'].'" /></a>')	;
			}else{
				$tpl->assign("image",$rs['comment']);
			}
		}
	}
	
	public function newsLeft($idc){
		global $DB, $tpl, $dir_path;
		$sql = "SELECT * FROM news WHERE active=1 AND (id_category IN(".Category::getParentId($idc).") OR groupcat LIKE '%:".$idc.":%') ORDER BY thu_tu DESC, name ASC LIMIT 0,10";
		$db = $DB->query($sql);
		while($rs = mysql_fetch_array($db)){
			  $tpl->newBlock("newslist");	
			  $tpl->assign("newsname",$rs['name']);
			  $tpl->assign("link_detail",$dir_path."/".url_process::getUrlCategory($rs['id_category']).$rs['url']);
		}
		
	}
}

?>