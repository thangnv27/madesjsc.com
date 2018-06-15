<?php 
	defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );
	$id = intval($_GET['id']);
	$table = $_GET['table'];
	$id_item = $_GET['id_item'];
	$lang = $_GET['lang'];
	include('../lib/imaging.php');
	
	// delete image
	if($_GET['code'] == 'delete'){
		if($table && $id && $id_item){
			$sql = "SELECT * FROM $table WHERE $id_item = $id";
			$db = $DB->query($sql);
			if($rs = mysql_fetch_array($db)){
				try {
				   @unlink($CONFIG['root_path'].$rs['image']);
				} catch (Exception $e) {
				    
				}
				$DB->query("UPDATE $table SET image='' WHERE $id_item=$id");
			}
		}
	}
	
	if($_GET['code'] == 'deleteimageurl'){
		$image = $_GET['image'];
		$urlthumb = $_GET['urlthumb'];
		if($image){
			@unlink($_SERVER['DOCUMENT_ROOT'].$imagedir.$image);
		}
		if($urlthumb){
			@unlink($_SERVER['DOCUMENT_ROOT'].$imagedir.$urlthumb);
		}
	}
	if($_GET['code'] == 'deleteotherimageurl'){
		$image = $_GET['image'];
		$urlthumb = $_GET['urlthumb'];
		if($image){
			@unlink($_SERVER['DOCUMENT_ROOT'].$imagedir.$image);
		}
		if($_GET['id']){
			$id = intval($_GET['id']);
			$DB->query("DELETE FROM image_product WHERE id = $id");
		}
	}
	if($_GET['code'] == 'deletePhoto'){
		$image = $_GET['image'];
		$id = intval($_GET['id']);
		
		$sql = "SELECT * FROM photo WHERE id_photo = $id";
		$db = $DB->query($sql);
		if($rs = mysql_fetch_array($db)){
			if($rs['image']){
				@unlink($_SERVER['DOCUMENT_ROOT'].$imagedir.$rs['image']);
			}  	
			$DB->query("DELETE FROM photo WHERE id_photo = $id");
		}
	}
	
	// delete item
	if($_GET['code'] == 'deleteitem'){
		if($table && $id && $id_item){
			$sql = "SELECT * FROM $table WHERE $id_item=$id";		
			$db = $DB->query($sql);
			if($rs = mysql_fetch_array($db)){
				@unlink($CONFIG['root_path'].$iamgedir.$rs['image']);
				$DB->query("DELETE FROM $table WHERE $id_item=$id");
			}
		}
	}
	
	// delete module 
	if($_GET['code']=='deleteitemmodule'){
		if($id)	{
			$DB->query("DELETE FROM user_module WHERE id_module=$id") ;
			$DB->query("DELETE FROM module WHERE id_module=$id") ;
		}
	}
	
	if($_GET['code'] == 'change_active'){
		$active = intval($_GET['active']);
		if($table && $id && $id_item){
			$DB->query("UPDATE ".$table." SET active = ".$active." WHERE ".$id_item."=".$id);
		}	
	}
	
	
	// load combo category 
	if($_GET['code']=='loadcommbo'){
		$data_type = $_GET['data_type'];
		$ct=new cat_tree(0);
		$ct->get_cat_tree(0,$data_type);	
		/*$ct->get_cat_string_admin($pid,$par_page,$category,$id_category,$data_type);
		$navigator.=$catstring2;	*/					
		
		$info['parentid1']=$pid;
			$info['parentid'] .= '<select name="parentid" style="WIDTH: 300px" >';
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
			//$tpl->assign("parentid",$info['parentid']);
			echo $info['parentid'];
		
	}
	
	if($_GET['code']=='uploadimageurl'){
		$url = $_GET['url'];
		$image = Image::url_upload_image($url);	
		echo strip_tags($dir_path.$dir_image_upload.$image['image']);
		//echo '<div class="defaultimage"><input name="defaultimage" onchange="insert_image_default(\''. $dir_path.$dir_image_upload.$image['image'] .'\')" type="radio" value="'.$dir_path.$dir_image_upload.$image['image'].'"  /></div><img src="'.$dir_path.'/manager/image.php?w=130&h=90&src='.$dir_path.$dir_image_upload.$image['image'].'" /><div class="tool"><a href="#" onclick="insertimage(\''.$dir_path.$dir_image_upload.$image['image'].'\');return false">Chèn</a> | <a href="#" class="a_deleteimage" onclick="deleteimage(\''.$dir_path.$dir_image_upload.$image['image'].'\',\''.$dir_path.$dir_image_upload.$image['image'].'\',$(this));return false">Xóa</a></div>';
	}
	
	if($_GET['code']=='uploadimageurl1'){
		$url = $_GET['url'];
		$image = Image::url_upload_image($url);	
		echo '<div class="defaultimage"><input name="defaultimage" onchange="insert_image_default(\''. $dir_path.$dir_image_upload.$image['image'] .'\')" type="radio" value="'.$dir_path.$dir_image_upload.$image['image'].'"  /></div><img src="'.$dir_path.'/manager/image.php?w=130&h=90&src='.$dir_path.$dir_image_upload.$image['image'].'" /><div class="tool"><a href="#" onclick="insertimage(\''.$dir_path.$dir_image_upload.$image['image'].'\');return false">Chèn</a> | <a href="#" class="a_deleteimage" onclick="deleteimage(\''.$dir_path.$dir_image_upload.$image['image'].'\',\''.$dir_path.$dir_image_upload.$image['image'].'\',$(this));return false">Xóa</a></div>';
	}
	
	if($_GET['code'] == 'addphoto'){
		$url = clean_value($_GET['url']);
		$pid = intval($_GET['pid']);
		$sql = "INSERT INTO photo(image,id_category) VALUES('".$url."','".$pid."')";
		$db = $DB->query($sql);	
		echo intval(mysql_insert_id());
	}
	
	if($_GET['code'] == 'updatephoto'){
		$id = intval($id);
		if($id){
			$parentid = intval(compile_post('parentid'));
			$DB->query("UPDATE photo SET name = '".compile_post('name')."', content = '".compile_post('content')."',id_category='".$parentid ."' WHERE id_photo= $id");	
		}
	}
	
	if($_GET['code']=='updateorder'){
		$id=intval($_GET['id']);
		$status=$_GET['status'];
		
		$sql="UPDATE orders SET status=$status WHERE id_order=$id";
		$DB->query($sql);
		if($db) echo "Đã cập nhật";
	}
	
?>