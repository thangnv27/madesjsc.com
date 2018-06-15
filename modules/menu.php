<?php

//Nguyen Van Binh
//suongmumc@gmail.com
defined('_VALID_NVB') or die('Direct Access to this location is not allowed.');

function menubar() {

    global $DB, $dir_path, $lang_dir , $cache_image_path, $CONFIG, $logo, $clsUrl,$activeid,$page;
    $tpl1 = new TemplatePower("templates/menu.htm");
    $tpl1->prepare();
    $tpl1->newBlock("menubar");
    $tpl1->assignGlobal("lang_dir",$lang_dir);
    if($page=='' || $page=='home') $tpl1->assign('homeactive',"active");
    
    $menu = new dbMenu;
    $menutop = $menu->menuBar();
    $arr = explode(',', $activeid);
    foreach ($menutop as $rs) {
        if ($rs['id_category'] > 0 && $rs['data_type']!='home') {
            $tpl1->newBlock("item_barmenu");
            $tpl1->assign("name", $rs['name']);
            if (in_array($rs['id_category'], $arr))
                $tpl1->assign("active", "active");
            $tpl1->assign("image", trim_url_image($dir_path . '/' . $rs['image']));
            $tpl1->assign("link", $dir_path . '/' . $rs['url']);
            $submenu = $menu->listSubCat($rs['id_category']);
            if (count($submenu) > 0)
                $tpl1->newBlock("has_sub_menu");
            foreach ($submenu as $rs1) {
                if ($rs1['id_category'] > 0) {
                    $tpl1->newBlock("submenudrop");
					if (in_array($rs1['id_category'], $arr))
                	$tpl1->assign("active1", "active");
                    $tpl1->assign("name1", $rs1['name']);
                    $tpl1->assign("link1", $dir_path . '/' . $rs1['url']);
                }
            }
        }
    }

    return $tpl1->getOutputContent();
}

function menutop() {
    global $DB, $dir_path, $CONFIG, $activeid;
    $tpl1 = new TemplatePower("templates/menu.htm");
    $tpl1->prepare();
    $tpl1->newBlock("topmenu");
    $menu = new dbMenu;
    $menutop = $menu->menuTop();
    $arr = explode(',', $activeid);
	$i=0;
    foreach ($menutop as $rs) {
        if ($rs['id_category'] > 0) {
			$i++;
            $tpl1->newBlock("item_topmenu");
			if($i>1) $tpl1->assign("line","|");
            $tpl1->assign("name", $rs['name']);
            if (in_array($rs['id_category'], $arr))
                $tpl1->assign("active", "active");
            $tpl1->assign("link", $dir_path . '/' . $rs['url']);
			if($rs['data_type'] == 'sitemap') $tpl1->assign("icon",'<i class="fa fa-sitemap"></i> ');
			if($rs['data_type'] == 'contact') $tpl1->assign("icon",'<i class="fa fa-envelope-o"></i> ');
        }
    }
    return $tpl1->getOutputContent();
}

function menuFooter() {

    global $DB, $dir_path, $CONFIG, $activeid;
    $tpl1 = new TemplatePower("templates/menu.htm");
    $tpl1->prepare();
    $tpl1->newBlock("menubarfooter");
    $menu = new dbMenu;
    $menutop = $menu->menuFooter();
    $arr = explode(',', $activeid);
	$i = 0;
    foreach ($menutop as $rs) {
        if ($rs['id_category'] > 0) {
            $tpl1->newBlock("item_menu");
			$i++;
			if($i>1) $tpl1->assign("line","|");
            $tpl1->assign("name", $rs['name']);
            if (in_array($rs['id_category'], $arr))
                $tpl1->assign("active", "active");
            $tpl1->assign("link", $dir_path . '/' . $rs['url']);
        }
    }
    return $tpl1->getOutputContent();
}
function menuChinhsach() {

    global $DB, $dir_path, $CONFIG, $activeid;
    $tpl1 = new TemplatePower("templates/menu.htm");
    $tpl1->prepare();
    $tpl1->newBlock("menuchinhsach");
    $menu = new dbMenu;
    $menutop = $menu->menuChinhsach();
    $arr = explode(',', $activeid);
	$i = 0;
    foreach ($menutop as $rs) {
        if ($rs['id_category'] > 0) {
            $tpl1->newBlock("item_menuchinhsach");
            $tpl1->assign("name", $rs['name']);
            if (in_array($rs['id_category'], $arr))
                $tpl1->assign("active", "active");
            $tpl1->assign("link", $dir_path . '/' . $rs['url']);
			$db1 = $menu->listSubCat($rs['id_category']);
			foreach($db1 as $rs1){
					$tpl1->newBlock("item_menuchinhsach1");
					$tpl1->assign("name1", $rs1['name']);
					$tpl1->assign("link1", $dir_path . '/' . $rs1['url']);
			}
        }
    }
    return $tpl1->getOutputContent();
}

function boxmenufooter(){
	global $DB, $dir_path, $CONFIG, $activeid;
	$tpl1 = new TemplatePower("templates/menu.htm");
    $tpl1->prepare();
	 $menu = new dbMenu;
    $mnu = $menu->selectByLocation("boxmenufooter");	
	$tpl1->newBlock("footercol");
	foreach($mnu as $rs){
		if($rs['id_category'] > 0){
			if($rs['footercol'] == 2){
				$tpl1->newBlock("col2");	
				$block = "subcol2";
			}else{
				$tpl1->newBlock("col1");	
				$block = "subcol1";
			}
			$tpl1->assign("name",$rs['name']);
			$tpl1->assign("link", $dir_path . '/' . $rs['url']);
			$db1 = $menu->listSubCat($rs['id_category']);
			foreach($db1 as $rs1){
				if($rs1['id_category'] > 0){
					$tpl1->newBlock($block);
					$tpl1->assign("name1",$rs1['name']);
					$tpl1->assign("link1", $dir_path . '/' . $rs1['url']);
				}
			}
		}
	}
	 return $tpl1->getOutputContent();
}
function mnuMain() {

    global $DB, $dir_path, $CONFIG, $activeid;
    $tpl1 = new TemplatePower("templates/menu.htm");
    $tpl1->prepare();
   
   	$sql = "SELECT * FROM static WHERE active=1 AND inwhere ='hdmuahang'";
	$db = $DB->query($sql);
	if($rs = mysql_fetch_array($db)){
		$tpl1->assignGlobal("hdmuaname",$rs['name']);
		$tpl1->assignGlobal("hdmuacontent",$rs['content']);
	}	
   
    $menu = new dbMenu;
    $menutop = $menu->menuMain();
   
	$i = 0;
    foreach ($menutop as $rs) {
        if ($rs['id_category'] > 0) {
			$i++;
			if($i==1){
				$tpl1->newBlock("mainmenu");
				$tpl1->newBlock("item_menu_main");
				$tpl1->assign("name", $rs['name']);
				$tpl1->assign("link", $dir_path . '/' . $rs['url']);
				$db1 = $menu->listSubCat($rs['id_category']);
				foreach($db1 as $rs1){
					if($rs1['id_category'] > 0){
						$tpl1->newBlock("main_level1");
						$tpl1->assign("name1", $rs1['name']);
						$tpl1->assign("link1", $dir_path . '/' . $rs1['url']);
					}
				}
			}else{
				$tpl1->newBlock("mainmenu1");	
				$tpl1->assign("name", $rs['name']);
				$tpl1->assign("link", $dir_path . '/' . $rs['url']);
			}
        }
    }
    return $tpl1->getOutputContent();
}

function menuRight(){
	global $DB, $dir_path, $cache_image_path, $CONFIG, $logo, $clsUrl, $activeid;
    $tpl1 = new TemplatePower("templates/menu.htm");
    $tpl1->prepare();
	$tpl1->newBlock("menuright");
	$menu = new dbMenu;
	$arr = explode(",",$activeid);
	$db = $menu->selectByLocation("menuright");
	foreach($db as $rs){
		if($rs['id_category'] > 0){
			$tpl1->newBlock("item_menu_right");	
			$tpl1->assign("name",$rs['name']);
			$tpl1->assign("link", $dir_path . '/' . $rs['url']);
			$db1 = $menu->listSubCat($rs['id_category']);
			foreach($db1 as $rs1){
				if($rs1['id_category'] > 0){
					$tpl1->newBlock("r_level1");
					if(in_array($rs1['id_category'],$arr)) $tpl1->assign("active","active");
					$tpl1->assign('name1',$rs1['name']);
					$tpl1->assign("link1", $dir_path . '/' . $rs1['url']);	
					$db2 = $menu->listSubCat($rs1['id_category']);
					if(count($db2) > 0){
						$tpl1->newBlock("show_r_level2");
						foreach($db2 as $rs2){
							if($rs2['id_category'] > 0){
								$tpl1->newBlock("r_level2");
								$tpl1->assign('name2',$rs2['name']);
								$tpl1->assign("link2", $dir_path . '/' . $rs2['url']);	
							}
						}
						if(in_array($rs1['id_category'],$arr)){ 
							$tpl1->newBlock("show_r_level2_1");
							foreach($db2 as $rs2){
								if($rs2['id_category'] > 0){
									$tpl1->newBlock("r_level2_1");
									if(in_array($rs2['id_category'],$arr)) $tpl1->assign("active2","active");
									$tpl1->assign('name2',$rs2['name']);
									$tpl1->assign("link2", $dir_path . '/' . $rs2['url']);	
								}
							}
						}
					}
				}
			}
		}
	}
	
	return $tpl1->getOutputContent();
}

function cateSearch() {
    global $DB, $dir_path, $cache_image_path, $CONFIG, $logo, $clsUrl, $activeid;
    $tpl1 = new TemplatePower("templates/menu.htm");
    $tpl1->prepare();
    $tpl1->newBlock("cateSearch");

    $menu = new dbMenu;
    $menutop = $menu->menuBar();
    $arr = explode(',', $activeid);
    foreach ($menutop as $rs) {
        if ($rs['id_category'] > 0) {
            $tpl1->newBlock("S_item1");
            $tpl1->assign("name", $rs['name']);
            if (in_array($rs['id_category'], $arr))
                $tpl1->assign("selected", "selected");
            $tpl1->assign("link", $dir_path . '/' . $rs['url']);
            $submenu = $menu->listSubCat($rs['id_category']);
            foreach ($submenu as $rs1) {
                if ($rs1['id_category'] > 0) {
                    $tpl1->newBlock("S_item2");
                    if (in_array($rs1['id_category'], $arr))
                        $tpl1->assign("selected1", "selected");
                    $tpl1->assign("name1", $rs1['name']);
                    $tpl1->assign("link1", $dir_path . '/' . $rs1['url']);
                }
            }
        }
    }

    return $tpl1->getOutputContent();
}

function subCategory($idc) {
    global $DB, $dir_path, $CONFIG, $activeid;
    $tpl1 = new TemplatePower("templates/menu.htm");
    $tpl1->prepare();
    $tpl1->newBlock("sub_category");
    $menu = new dbMenu;
    $menutop = $menu->listSubCat($idc);
    $arr = explode(',', $activeid);
    $i = 0;
    foreach ($menutop as $rs) {
        if ($rs['id_category'] > 0) {
            $tpl1->newBlock("item_sub_category");
            $i++;
            if ($i > 1)
                $tpl1->assign("line", "|");
            $tpl1->assign("name", $rs['name']);
            if (in_array($rs['id_category'], $arr))
                $tpl1->assign("active", "active");
            $tpl1->assign("link", $dir_path . '/' . $rs['url']);
        }
    }
    return $tpl1->getOutputContent();
}
function menuMobile(){
		
		global $DB, $dir_path, $cache_image_path, $CONFIG, $logo,$activeid,$language;
    	$tpl1 = new TemplatePower("templates/menu.htm");
    	$tpl1->prepare();
		$tpl1->newBlock("showmenumobile");
		$sql = "SELECT * FROM category WHERE active=1 AND vitri LIKE '%:menubar:%'  $language ORDER BY thu_tu ASC, name ASC";
		$db = $DB->query($sql);
		while($rs = mysql_fetch_array($db)){
			$tpl1->newblock("m_level1");	
			$tpl1->assign(array(
				name => $rs['name'],
				link=>$dir_path."/".$rs['url']
			));
			$sql1 = "SELECT * FROM category WHERE active=1 AND parentid = $rs[id_category] ORDER BY thu_tu DESC, name DESC";
			$db1 = $DB->query($sql1);
			if(mysql_num_rows($db1) > 0){
				//$tpl1->newBlock("showlevel2");
				while($rs1= mysql_fetch_array($db1)){
					$tpl1->newBlock("m_level2");
					$tpl1->assign(array(
						name1 => $rs1['name'],
						link1=>$dir_path.'/'.$rs1['url']
					));
					$sql2 = "SELECT * FROM category WHERE active=1 AND parentid = $rs1[id_category] ORDER BY thu_tu DESC, name DESC";
					$db2 = $DB->query($sql2);
					if(mysql_num_rows($db2) > 0){
						$tpl1->newBlock("showlevel3");
						while($rs2= mysql_fetch_array($db2)){
							$tpl1->newBlock("m_level3");
							$tpl1->assign(array(
								name2 => $rs2['name'],
								link2=>$dir_path.'/'.$rs2['url']
							));
							$sql3 = "SELECT * FROM category WHERE active=1 AND parentid = $rs2[id_category] ORDER BY thu_tu DESC, name DESC";
							$db3 = $DB->query($sql3);
							if(mysql_num_rows($db3) > 0){
								$tpl1->newBlock("showlevel4");
								while($rs3= mysql_fetch_array($db3)){
									$tpl1->newBlock("m_level4");
									$tpl1->assign(array(
										name3 => $rs3['name'],
										link3=>$dir_path.'/'.$rs3['url']
									));
								}
							}
						}
					}
				}
			}
		}
		$sql = "SELECT * FROM category WHERE active=1 AND vitri LIKE '%:menutop:%'  $language ORDER BY thu_tu ASC, name ASC";
		$db = $DB->query($sql);
		while($rs = mysql_fetch_array($db)){
			$tpl1->newblock("m_level1");
			$tpl1->assign(array(
				name => $rs['name'],
				link=>$dir_path."/".$rs['url']
			));
		}
		return $tpl1->getOutputContent();
	}
?>