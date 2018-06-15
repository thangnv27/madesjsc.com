<?php 
// Nguyen Binh
// suongmumc@gmail.com

defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );
$tpl=new TemplatePower("skin/category.tpl");
$tpl->prepare();
	$id=intval($_GET['id']);
	$idc=intval($_GET['idc']);
	$pid=intval($_GET['pid']);

	$module = new Cat;
	$module->_int();

$tpl->printToScreen();

class Cat extends cat_tree{
	private $page = "Chuyên mục";
	private $item = "chuyên mục";
	private $table = "category";
	private $id_item = "id_category";
	private $par_page = "category";
	private $numberPageShow = 8;
	private $numberItemPage = 30;
	private $thumbwidth = 80;
//	private $data_type='news';
	
	public function _int(){
		global $tpl,$id,$pid;
		$this->get_cat_tree(0);	
		$pathpage = '<li><a href="?page='.$this->par_page.'">'.$this->page.'</a> <span class="divider">></span></li>'. $this->get_cat_string_admin($pid,$this->par_page);
		$tpl->assignGlobal('pathpage',$pathpage);
		
		$tpl->assignGlobal("item",$this->item);
		$tpl->assignGlobal("table",$this->table);
		$tpl->assignGlobal("id_item",$this->id_item);
		$tpl->assignGlobal("par_page",$this->par_page);
		
		
		$code = $_GET['code'];
		switch($code){
			case "showAddNew":
				$this->showAddNew();
				break;	
			case "showUpdate":
				$this->showUpdate();
				break;	
			case "save":
				$this->save();
				break;
			case "update":
				$this->update($id);
				break;	
			case "ordering":
				$this->ordering();
				break;
		}	
		$this->showList();
	}
	private function showAddNew(){
		global $DB,$tpl,$lang,$dklang,$tree,$pid,$CONFIG;
		$pid = intval($pid);
		$tpl->newBlock("AddNew");	
		$tpl->assign("action",'?page='.$this->par_page.'&code=save');
		// list category
			$info['parentid1']=$pid;
			$info['parentid'] .= '<select name="parentid" style="WIDTH: 300px" >';
			$info['parentid'] .= '<option value="0">Root</option>';
			
			$info['parentid'] .= '</select>';
			$tpl->assign("parentid",$info['parentid']);
			
			$tpl->assign("content"		,ClEditor::EditorBase("content",'&nbsp;'));
			$tpl->assign("active"		,"checked");
			$tpl->assign("autourl"		,"checked");
			$tpl->assign("colfooter1","checked");
			$tpl->assign("logotitleleft0","checked");
			$tpl->assign("thu_tu",Order::getOrderCat($this->table));
			$this->getGroupAttr();
		
	}	
	
	private function showUpdate(){
		global $DB,$tpl,$lang,$dklang,$id,$dir_image,$tree,$pid;
		$tpl->newBlock("AddNew");
		if($_GET['p']>1){
			$pa = '&p='.$_GET['p'];	
		}
		$tpl->assign("action",'?page='.$this->par_page.'&code=update&id='.$id.'&pid='.$pid);
		$sql = "SELECT * FROM ".$this->table." WHERE ".$this->id_item." = ".$id;
		$db = $DB->query($sql);
		if($rs = mysql_fetch_array($db)){
			
			// list category
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
			$tpl->assign("parentid",$info['parentid']);
			
			$tpl->assign("name"			,$rs['name']);
			$tpl->assign("title"		,$rs['title']);
			$tpl->assign("description"	,$rs['description']);
			$tpl->assign("keywords"		,$rs['keywords']);
			$tpl->assign("thu_tu"		,$rs['thu_tu']);
			$tpl->assign($rs['data_type'] 	,"checked");
			$tpl->assign("content"		,ClEditor::EditorBase("content",$rs['content']));
			$tpl->assign("url"			,$rs['url']);
			$link_delete_image 			= "index4.php?page=action_ajax&code=delete&id=".$rs[$this->id_item]."&table=".$this->table."&id_item=".$this->id_item;
			if($rs['image']){
				$tpl->assign("image",'<img src="image.php?w=150&src='.$rs['image'].'" class="img-polaroid marginright5" align="left" id="avatar" /><br /><a href="'.$link_delete_image.'" id="trash_image" class="icon-trash" title="Xóa ảnh"></a>');
			}
			$tpl->assign("imageurl",$rs['image']);
			if($rs['active']==1) $tpl->assign("active","checked");
			$tpl->assign("stypeshow".$rs['stypeshow'],"checked");
			$tpl->assign("colfooter".$rs['colfooter'],"checked");
			$tpl->assign("logotitleleft".$rs['logotitleleft'],"checked");
			$tpl->assign("logotitlehome".$rs['logotitlehome'],"checked");
			if($rs['shortinhome']==1) $tpl->assign("shortinhome","checked");
			
			$vitri = explode(":",$rs['vitri']);
			foreach($vitri as $vt){
				if($vt=='logo'){
					$tpl->assign('logo1',"checked")	;
				}else{
				  $tpl->assign($vt,"checked")	;
				}
			}
			$this->getGroupAttr($rs['id_attr']);
		}
	}
	
	private function showList(){
		global $DB,$tpl,$lang,$dklang,$pid,$site_address,$dir_path,$dir_image,$tree;
		$tpl->newBlock("showList");
		if(intval($_GET['p']) < 1 ) $p = 1;
		else $p = intval($_GET['p']);
		$tpl->assign("pid",$pid);
		$tpl->assign("par_page",$this->par_page);
		$tpl->assign("action","?page=".$this->par_page."&code=ordering&pid=".$pid."&p=".$p);
		$this->showListCate(0,'');
		$tpl->assign("showList.pages",$db['pages'])	;
	}
	
	private function showListCate($pid,$n){
		global $DB,$tpl,$lang,$dklang;
		$tpl->newBlock("showListCate");
		$dataType = new url_process;
		$sql = "SELECT * FROM ".$this->table." WHERE parentid = $pid $dklang ORDER BY thu_tu ASC, name ASC";
		$db = $DB->query($sql);
		$str =$n;
		$n = $n."-- ";	
		while($rs = mysql_fetch_array($db)){
			$tpl->newBlock("listCate")	;
			$dt = $dataType->type_Info($rs['data_type']);
			$tpl->assign(array(
				name => $str.$rs['name'],
				thu_tu => $rs['thu_tu'],
				id => $rs[$this->id_item],
				datatype => $dt['titlemenu'],
			));
			$tpl->assign("link","?page=".$dt['adminpage']."&pid=".$rs[$this->id_item]);
			if($rs['active']==1) $tpl->assign("active","checked");
			$tpl->assign("link_edit",'?page='.$this->par_page.'&code=showUpdate&id='.$rs[$this->id_item].'&pid='.$rs['parentid']);
			$tpl->assign("link_delete",'?page=action_ajax&code=deleteitem&id='.$rs[$this->id_item].'&table='.$this->table.'&id_item='.$this->id_item);
			
			$tpl->assign("vitri",$rs['vitri']);
			$this->showListCate($rs[$this->id_item],$n);
			
		}
	}
	
	private function ordering(){
		global $DB,$tpl,$lang,$dklang;
		$thu_tu = $_POST['thu_tu'];
		if($thu_tu){
			foreach ($thu_tu as $tt=>$val){
				$DB->query("UPDATE ".$this->table." SET thu_tu=".$val." WHERE ".$this->id_item."=".$tt);
			}	
			Message::showMessage("success","Cập nhật thứ tự thành công !");
		}
	}
	
	private function save(){
		global $DB,$tpl,$lang,$dklang;
		$data = $this->getData();
		if($data){
			$b=$DB->compile_db_insert_string($data);
			$sql="INSERT INTO ".$this->table." (".$b['FIELD_NAMES'].") VALUES (".$b['FIELD_VALUES'].")";
			$DB->query($sql);
			Message::showMessage("success","Thêm mới thành công !");
		}
		
	}
	
	private function update($id){
		global $DB,$tpl,$lang,$dklang;
		$id = intval($id);
		$data = $this->getData();
		if($data['parentid']==$id){
			Message::showMessage("error","Bạn không thể tạo \"".$data['name']."\" thuộc nhóm cha chính là \"".$data['name']."\"  !");
		}else{
			if($data){
				$b=$DB->compile_db_update_string($data);
				$sql="UPDATE ".$this->table." SET ".$b." WHERE ".$this->id_item."=".$id;
				$db=$DB->query($sql);
				Message::showMessage("success","Sửa chữa thành công !");
			}
		}
	}
	
	
	private function getData($update=0,$id=0){
		global  $my,$_FILES,$dir_lang, $dir_path;
		$id = intval($id);
		$data = array();
		$data['name']		= compile_post('name');
		
		if(compile_post('title')){
			$data['title']	= compile_post('title');	
		}else{
			$data['title']	= compile_post('name');	
		}
		$data['parentid']= compile_post('parentid');
	  	$data['data_type'] = compile_post('data_type');
		$data['content'] 	= $_POST['content'];
		$data['description']= compile_post('description');	
		$data['keywords']	= compile_post('keywords');	
		$data['active']		= intval(compile_post('active'));	
		$data['thu_tu'] 	= intval(compile_post('thu_tu'));
		$data['id_attr'] 	= intval(compile_post('id_attr'));
		$data['colfooter'] 	= intval(compile_post('colfooter'));
		$data['logotitleleft'] 	= intval(compile_post('logotitleleft'));
		$data['logotitlehome'] 	= intval(compile_post('logotitlehome'));
		$data['shortinhome'] 	= intval(compile_post('shortinhome'));
		if(compile_post('autourl')==1){
			if($data['data_type']=='home'){
				$url = $dir_lang;	
			}else{
				if($data['parentid'] > 0){
					$url = url_process::getUrlCategory($data['parentid']).clean_url(compile_post('name')).'/';
				}else{
					$url = $dir_lang.clean_url(compile_post('name')).'/';	
				}

			}
		}else{
			if($data['data_type']=='home'){
				$url = $dir_lang;
			}else{
				$url = $dir_lang. compile_post('url');
			}
		}
		$data['url'] = $url;
		
		$vitri = $_POST['vitri'];
		$vt=":";
		if($vitri){
			foreach($vitri as $v){
				$vt.=$v.":";
			}
		}
		$data['vitri']=$vt;
		if($_FILES['image']['size']){
			$image = Image::uploadImage('image','no');
			$data['image'] = $dir_path."/".$image['image'];
		}else{
			$data['image'] = compile_post('imageurl');
		}
		return $data;
	}
	private function getGroupAttr($idc){
		global $DB, $tpl;
		$sql = "SELECT * FROM group_attr ORDER BY name ASC";
		$db = $DB->query($sql);
		while($rs = mysql_fetch_array($db)){
			$tpl->newBlock("list_attr");
			if($rs['setdefault']==1 && $idc <= 0){
				$tpl->assign("checked","checked='checked'")	;
			}elseif($rs['id_group'] == $idc){
				$tpl->assign("checked","checked='checked'")	;
			}
			$tpl->assign("attrname",$rs['name']);
			$tpl->assign("id_attr",$rs['id_group']);
		}
	}
}

?>