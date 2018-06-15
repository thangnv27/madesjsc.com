<?php 
// Nguyen Binh
// suongmumc@gmail.com


defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );

$id = intval($_GET['id']);
$pid = intval($_GET['pid']);

$page = "Trang ảnh";
$item = "ảnh";
$table = "photo";
$id_item = "id_photo";
$par_page = "photo";
$thumbwidth = 150;
$thumbheight = 130;
$data_type='photo';

$tpl=new TemplatePower("skin/editphoto.tpl");
$tpl->prepare();
	$ct = new cat_tree;
	
	$ct->get_cat_tree(0,$data_type);	
	$tpl->assignGlobal("pid",$pid);
	$tpl->assignGlobal("id",$id);
	
	$sql = "SELECT * FROM ".$table." WHERE ".$id_item." = $id";
		$db = $DB->query($sql);
		if($rs = mysql_fetch_array($db)){
			$tpl->assign("name",$rs['name']);
			$tpl->assignGlobal("id",$rs['id_photo']);
			$tpl->assign("content",$rs['content']);
			$tpl->assign("image",'<img src="image.php?w='.$thumbwidth.'&src='.$imagedir.$rs['image'].'" class="img-polaroid marginright5" align="left" id="avatar" />');
			$tpl->assign("bigimage",$rs['image']);
			$info['parentid1']=$rs['id_category'];
			$info['parentid'] .= '<select name="parentid" style="width:250px;" >';
			$info['parentid'] .= '<option value="0">Root</option>';
			if($tree)
			foreach($tree as $k => $v) {
				foreach($v as $i => $j) {
					$selectstr='';
					if ($info['parentid1']==$k)
						$selectstr=" selected ";
					$info['parentid'] .= '<option value="' . $k . '"'.$selectstr.'>' . $j . '</option>';
				}
			}
			$info['parentid'] .= '</select>';
			$tpl->assign("parentid",$info['parentid']);
		}
$tpl->printToScreen();

	
	

		

?>