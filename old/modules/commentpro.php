<?php
//Nguyen Van Binh
//suongmumc@gmail.com

defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );

	if($_POST['code']=='1'){
			$a=array();
			$a['name']		= compile_post('commentname');
			$a['comment']	= strip_tags(compile_post('comment'));
			$a['createdate']= time()+$CONFIG['time_offset'];
			$a['id_product']= intval($_GET['id']);
			$a['active']	= 0;
			
			$b=$DB->compile_db_insert_string($a);
			$sql="INSERT INTO commentpro (".$b['FIELD_NAMES'].") VALUES (".$b['FIELD_VALUES'].")";
			$DB->query($sql);
			echo "Ý kiếm của bạn đã gửi thành công !";
			//$id=mysql_insert_id();
			//$sql="SELECT * FROM commentnews WHERE id=".intval($id);
			//$db=$DB->query($sql);
			//if($rs=mysql_fetch_array($db)){
			//	echo '<div class="item"><div class="name">'.$rs['subject'].'<span class="createdate" style="font-weight:normal; padding-left:50px;">Ngày: '.date('d/m/Y | H:i',$rs['createdate']).'</span></div>    <div>'.$rs['comment'].'</div><div style="font-style:italic">('.$rs['name'].')</div></div><div style="clear:both; height:10px;"></div>';
			//}
		
	}

if($_GET['code']=='load'){
	$tpl = new TemplatePower("templates/loadcommentpro.htm");
	$tpl->prepare();	
	$id=intval($_GET['id']);
	
	$sql="SELECT * FROM commentpro WHERE active=1 AND id_product=$id ORDER BY createdate ASC";
//	$db=$DB->query($sql);
	$db=$DB->query($sql);
	while($rs=mysql_fetch_array($db)){
		$tpl->newBlock("itemcomment");
		$tpl->assign("createdate",date('d/m/Y H:i',$rs['createdate']));
		$tpl->assign("name",$rs['name']);
		$tpl->assign("phone",$rs['address']);
		$tpl->assign("comment",$rs['comment']);		
	}

	$tpl->printToScreen();	
}
?>