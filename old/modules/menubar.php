<?php
//Nguyen Van Binh
//suongmumc@gmail.com

defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );
$tpl = new TemplatePower($CONFIG['template_dir']."/menubar.htm");
$tpl->prepare();
$tpl->assignGlobal("dir_path",$dir_path);
	
$mnb = new Menubar;
$mnb->showMenuBar(); 
$mnb->support(); 
if($page=='' || $page=='home'){
	$mnb->slideshow(); 
}	
$catinfo = Category::categoryInfo($idc);
if($catinfo['image']){
	$tpl->assignGlobal("catimage",'<img src="'.$catinfo['image'].'" width="802" />');
}
$tpl->printToScreen();

class Menubar{
	public function showMenuBar(){
		global $DB, $tpl, $dir_path,$idc;
		$sql = "SELECT * FROM category WHERE active=1 AND vitri LIKE '%:menubar:%' AND data_type<>'logo' ORDER BY thu_tu ASC, name ASC";
		$db = $DB->query($sql);
		$i=0;
		$ar = Get_Id_Cat_Back($idc);
		$arr = explode(",",$ar);
		while($rs = mysql_fetch_array($db)){
			$i++;
			$tpl->newBlock("menubar");
			$tpl->assign("name",$rs['name']);
			
			if($rs['data_type']=='link'){
				$tpl->assign("link",$rs['url']);
				$tpl->assign("target","_bank");
			}else{
  				$tpl->assign("link",url_process::builUrl($rs['id_category']));
			}
			
			if(in_array($rs['id_category'],$arr)){
				$tpl->assign("current","current");
			}
			$sql1 = "SELECT * FROM category WHERE active=1 AND parentid = $rs[id_category] ORDER BY thu_tu ASC, name ASC";
			$db1 = $DB->query($sql1);
			$tpl->newBlock("showsub");
			if(mysql_num_rows($db1)>0){
				while($rs1 = mysql_fetch_array($db1)){
					$tpl->newBlock("subbar");
					$tpl->assign("name1",$rs1['name']);
					$tpl->assign("target1",$rs1['target']);
					if($rs1['data_type']=='link'){
						$tpl->assign("link",$rs1['url']);
					}else{
		  				$tpl->assign("link1",url_process::builUrl($rs1['id_category']));
					}
					
					
				}
			}
		}
	}
	public function slideshow(){
		global $DB, $tpl, $dir_path;
		$sql = "SELECT * FROM category WHERE active=1 AND vitri LIKE '%:slideshow:%'";
		$db = $DB->query($sql);
		if(mysql_num_rows($db)>0){
			$tpl->newBlock("slideshow")	;
			while($rs = mysql_fetch_array($db)){
				$sql1 = "SELECT * FROM logo WHERE active=1 AND id_category = $rs[id_category] ORDER BY thu_tu DESC, name ASC";
				$db1 = $DB->query($sql1);
				while($rs1 = mysql_fetch_array($db1)){
					if($rs1['image']){
						$tpl->newBlock("list_logo")	;
						$tpl->assign("image",'<img src="'.$dir_path.'/image.php?w=802&src='.$rs1['image'].'" />');
						$tpl->assign("link",$rs1['link']);
						$tpl->assign("target",$rs1['target']);
					}
					
				}
			}
		}
	}
		
	public function support(){
			global $DB, $tpl;
			$sql = "SELECT * FROM yahoo WHERE active=1 ORDER BY thu_tu DESC, name ASC";
			$db = $DB->query($sql);
			$str='';
			while($rs = mysql_fetch_array($db)){
				$str.=$rs['name'];
				if($rs['nic']){
					$str.='&nbsp;<a href="ymsgr:SendIM?'.$rs['nic'].'" rel="nofollow"><img style="margin-top:2px;" src="http://opi.yahoo.com/online?u='.$rs['nic'].'&amp;m=g&amp;t=5&amp;l=us" alt="'.$rs['name'].'"></a>';	
				}	
				if($rs['sky']){
					$str.='<a href="skype:'.$rs['sky'].'?chat"><img border="0" alt="Mr bình" src="http://mystatus.skype.com/smallicon/'.$rs['sky'].'" style="margin-top:5px;"></a>';	
				}
			}
			$tpl->assignGlobal('supportonline',$str);
	}
}

?>