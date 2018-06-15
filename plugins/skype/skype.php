<?php

//Nguyen Van Binh
//suongmumc@gmail.com

defined('_VALID_NVB') or die('Direct Access to this location is not allowed.');

function showSkype($nick) {
	global $DB;
    $tpl1 = new TemplatePower("plugins/skype/skype.htm");
    $tpl1->prepare();
	
	$sql = "SELECT * FROM yahoo WHERE active=1 ORDER BY thu_tu ASC";
	$db = $DB->query($sql);
	while($rs = mysql_fetch_array($db)){
		$tpl1->newBlock("list_skype");
		$tpl1->assign("nick",$rs['sky']);
		$tpl1->assign("name",$rs['name']);
		/*$data = file_get_contents("http://mystatus.skype.com/".$rs['sky'].".txt");
		if($data == "Online" ){
			$tpl1->assign("skype_call","skype_call");	
			$tpl1->assign("skype_chat","skype_chat");	
		}else{
			$tpl1->assign("skype_call","skype_call1");	
			$tpl1->assign("skype_chat","skype_chat1");	
		}*/
	}
	
    return $tpl1->getOutputContent();
}

?>