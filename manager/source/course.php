<?php 
// Nguyen Binh
// suongmumc@gmail.com

defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );
$tpl=new TemplatePower("skin/course.tpl");
$tpl->prepare();
	$id=intval($_GET['id']);
	$idc=intval($_GET['idc']);
	$pid=intval($_GET['pid']);
	
	$module = new News();
	$module->_int();

$tpl->printToScreen();

class News extends cat_tree{
	
	private $page = "Trang khóa học";
	private $item = "khóa học";
	private $table = "course";
	private $id_item = "id_course";
	private $par_page = "course";
	
	private $numberPageShow = 8;
	private $numberItemPage = 30;
	private $thumbwidth = 80;
	private $data_type='course';
	
	public function _int(){
		global $tpl,$id,$pid,$dir_path, $imagedir;
		$this->get_cat_tree(0,'');	
		$pathpage = '<li><a href="?page='.$this->par_page.'">'.$this->page.'</a> <span class="divider">></span></li>'. $this->get_cat_string_admin($pid,$this->par_page);
		$tpl->assignGlobal('pathpage',$pathpage);
		$tpl->assignGlobal("item",$this->item);
		$tpl->assignGlobal("table",$this->table);
		$tpl->assignGlobal("id_item",$this->id_item);
		$tpl->assignGlobal("par_page",$this->par_page);
		$tpl->assignGlobal("pid",$pid);
		$tpl->assignGlobal("dir_path",$dir_path);
		$tpl->assignGlobal("imagedir",$imagedir);		
		
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
			case "deletemulti":
				$this->deleteMultiItem();
				break;
		}	
		$this->showList();
	}
	private function showAddNew(){
		global $DB,$tpl,$lang,$dklang,$tree,$pid,$CONFIG, $imagedir;
		$pid = intval($pid);
		$tpl->assignGlobal("imagedir",$imagedir);	
		$tpl->newBlock("AddNew");	
		$tpl->assign("action",'?page='.$this->par_page.'&code=save&pid='.$pid);
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
					
					$dtype = Category::idCatToDataType($k);
					if($dtype == $this->data_type){
						$info['parentid'] .= '<option value="' . $k . '"'.$selectstr.'>' . $j . '</option>';						
					}else{
						$info['parentid'] .= '<option value="' . $k . '"'.$selectstr.' disabled>' . $j . '</option>';
					}
				}
			}
			$info['parentid'] .= '</select>';
			$tpl->assign("parentid",$info['parentid']);
			
			// in group	
			$str=$rs['groupcat'];
			$gr=explode(':',$str);
			$info1['parentid'] .= '<option value="0">None</option>';
			if($tree)
			foreach($tree as $k => $v) {
				foreach($v as $i => $j) {
					$dtype = Category::idCatToDataType($k);
					if($dtype == $this->data_type){
						$info1['parentid'] .= '<option value="' . $k . '">' . $j . '</option>';					
					}
				}
			}
			$tpl->assign("parentid1"	,$info1['parentid']);
			
			$tpl->assign("intro"		,ClEditor::EditorBase("intro",'&nbsp;'));
			$tpl->assign("content"		,ClEditor::Editor("content",'&nbsp;'));
			$tpl->assign("active"		,"checked");
			$tpl->assign("showdate"		,"checked");
			$tpl->assign("autourl"		,"checked");
			$tpl->assign("ngay_dang",date('d/m/Y H:i',time() + $CONFIG['time_offset']));
			$tpl->assign("thu_tu",Order::getOrderCat($this->table));
	}	
	
	private function showUpdate(){
		global $DB,$tpl,$lang,$dklang,$id,$imagedir,$tree,$pid,$cache_image_path,$dir_path;
		$tpl->assignGlobal("imagedir",$imagedir);	
		
		$tpl->newBlock("AddNew");
		if($_GET['p']>1){
			$pa = '&p='.$_GET['p'];	
		}
		$tpl->assign("action",'?page='.$this->par_page.'&code=update&id='.$id.'&pid='.$pid.$pa);
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
					
					$dtype = Category::idCatToDataType($k);
					if($dtype == $this->data_type){
						$info['parentid'] .= '<option value="' . $k . '"'.$selectstr.'>' . $j . '</option>';						
					}else{
						$info['parentid'] .= '<option value="' . $k . '"'.$selectstr.' disabled>' . $j . '</option>';
					}
				}
			}
			$info['parentid'] .= '</select>';
			$tpl->assign("parentid",$info['parentid']);
			
			// in group	
			$str=$rs['groupcat'];
			$gr=explode(':',$str);
			$info1['parentid'] .= '<option value="0">None</option>';
			if($tree)
			foreach($tree as $k => $v) {
				foreach($v as $i => $j) {
					if(in_array($k,$gr)){
						$selectstr1='selected="selected"';
					}else{
						$selectstr1='';
					}
					
					$dtype = Category::idCatToDataType($k);
					if($dtype == $this->data_type){
						$info1['parentid'] .= '<option value="' . $k . '"'.$selectstr1.'>' . $j . '</option>';					
					}
				}
			}
			$tpl->assign("parentid1"	,$info1['parentid']);
			$tpl->assign("name"			,$rs['name']);
			$tpl->assign("title"		,$rs['title']);
			$tpl->assign("description"	,$rs['description']);
			$tpl->assign("keywords"		,$rs['keywords']);
			$tpl->assign("thu_tu"		,$rs['thu_tu']);
			$tpl->assign("intro"		,ClEditor::EditorBase("intro",$rs['intro']));
			$tpl->assign("content"		,ClEditor::Editor("content",$rs['content']));
			$tpl->assign("url"			,$rs['url']);
			$tpl->assign("ngay_dang" 	,date('d/m/Y H:i',$rs['ngay_dang']));
			$link_delete_image = "index4.php?page=action_ajax&code=delete&id=".$rs[$this->id_item]."&table=".$this->table."&id_item=".$this->id_item;
			if($rs['image']){
				$tpl->assign("image",'<img src="'.$cache_image_path.resizeimage(160,120,$dir_path."/".$rs['image']).'" class="img-polaroid marginright5" align="left" id="avatar" />
				<br /><a href="'.$link_delete_image.'" id="trash_image" class="icon-trash" title="Xóa ảnh"></a>');
				$tpl->assign("imageurl",$rs['image']);
			}
			
			if($rs['active']==1) $tpl->assign("active","checked");
			if($rs['showdate']==1) $tpl->assign("showdate","checked");
			$file = array();
			$file= json_decode($rs['file'],true);	
			$filename='';
			if($file){
				foreach($file as $f){
						$filename.='<div><a href="#" onclick="removeFile($(this)); return false">Xóa</a><input name="file['.$f.'][name]" type="text"  value="'.$f[name].'"/>
						<input type="hidden" name="file['.$f.'][url]" value="'.$f[url].'" /><input type="hidden" name="file['.$f.'][filename]" value="'.$f[filename].'" /> <span><a href="'.$f[url].'" target="_blank">' .$f[filename]. '</a></span></div>'	;
					
				}
				
			}
			$tpl->assign("filename",$filename);
		}
	}
	
	private function showList(){
		global $DB,$tpl,$lang,$language,$pid,$site_address,$dir_path,$imagedir,$tree,$cache_image_path;
		$tpl->newBlock("showList");
		if(intval($_GET['p']) < 1 ) $p = 1;
		else $p= intval($_GET['p']);
		$tpl->assign("pid",$pid);
		$tpl->assign("par_page",$this->par_page);
		$tpl->assign("action","?page=".$this->par_page."&code=ordering&pid=".$pid."&p=".$p);
		// list category
		$info['parentid1']=$pid;
		$info['parentid'] .= '<select name="parentid" style="WIDTH: 300px" id="parentid" >';
		$info['parentid'] .= '<option value="0">Category</option>';
		if($tree)
		foreach($tree as $k => $v) {
			foreach($v as $i => $j) {
				$selectstr='';
				if ($info['parentid1']==$k)
					$selectstr=" selected ";
				$dtype = Category::idCatToDataType($k);
				if($dtype == $this->data_type){
					$info['parentid'] .= '<option value="' . $k . '"'.$selectstr.'>' . $j . '</option>';						
				}else{
					$info['parentid'] .= '<option value="' . $k . '"'.$selectstr.' disabled>' . $j . '</option>';
				}
			}
		}
		$info['parentid'] .= '</select>';
		$tpl->assign("parentid",$info['parentid']);
		
		
		//if($pid == 0 && $dk==''){
			//$dk= " 1 = 1 ".$language;
		//}else{
			$dk="(".$this->table.".id_category=".$pid." OR ".$this->table.".groupcat LIKE '%:".$pid.":%')";
		//}
		
		if($_REQUEST['keyword']){
			$keyword = clean_value($_REQUEST['keyword']);
			$dk.=" AND ".$this->table.".name LIKE '%".$keyword."%' ";
			$kw = "&keyword=".$keyword;
		}
		
		$sql="SELECT ".$this->table.".*,users.name as user_name, users.username as username FROM ".$this->table." LEFT JOIN users ON(".$this->table .".id_user=users.id_users) WHERE  $dk ORDER BY ".$this->table.".thu_tu DESC, ".$this->id_item." DESC";
		
		$db = paging::pagingAdmin($p,"?page=".$this->par_page.$kw,$sql,$this->numberPageShow,$this->numberItemPage);
		while($rs = mysql_fetch_array($db['db'])){
			$tpl->newBlock("list");
			$tpl->assign(array(
				name => $rs['name'],
				thu_tu => $rs['thu_tu'],
				id => $rs[$this->id_item],
				username =>$rs['username'],
				user_name => $rs['user_name'],
				createdate => @date('d/m/Y | H:i',$rs['ngay_dang']),
				url => $site_address.url_process::builUrlArticle($rs['id_news'],$rs['id_category']),
				groupcat => $this->getGroupCatName($rs['groupcat'])
			));
			$tpl->assign("categoryname",Category::categoryName($rs['id_category']));
			$tpl->assign("linkcat","?page=".$this->par_page."&pid=".$rs['id_category']);
			if($rs['image']){
				$tpl->assign("image",'<img src="'.$cache_image_path.cropimage(100,75,$dir_path."/".$rs['image']).'" class="thumblistnews" />');
			}
			if($rs['active']==1) $tpl->assign("active","checked");
			
			$tpl->assign("link_edit",'?page='.$this->par_page.'&code=showUpdate&pid='.$rs['id_category'].'&id='.$rs[$this->id_item]);
			$tpl->assign("link_delete",'?page=action_ajax&code=deleteitem&id='.$rs[$this->id_item].'&table='.$this->table.'&id_item='.$this->id_item);
		}
		$tpl->assign("showList.pages",$db['pages'])	;
	}
	
	private function showListCate(){
		global $DB,$tpl,$lang,$language,$pid;
		$tpl->newBlock("showListCate");
		$sql = "SELECT * FROM category WHERE parentid = $pid $language ORDER BY thu_tu ASC, name ASC";
		$db = $DB->query($sql);
		while($rs = mysql_fetch_array($db)){
			$tpl->newBlock("listCate")	;
			$tpl->assign(array(
				name => $rs['name'],
				thu_tu => $rs['thu_tu']
			));
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
		if($data){
			$b=$DB->compile_db_update_string($data);
			$sql="UPDATE ".$this->table." SET ".$b." WHERE ".$this->id_item."=".$id;
			$db=$DB->query($sql);
			Message::showMessage("success","Sửa chữa thành công !");
		}
	}
	private function getGroupCatName($groupcat){
		global $DB;
		$i=0;$str='';
		if($groupcat) $gr=explode(":",$groupcat);	
		if($gr)
		foreach($gr as $idgroup){
			if($idgroup){
				$sql="SELECT * FROM category WHERE id_category=$idgroup";
				$db=$DB->query($sql);
				if($rs=mysql_fetch_array($db)){
					$i++;
					if($i==1){
						$str.=$rs['name'];	
					}else{
						$str.=", ".$rs['name'];	
					}
				}
			}
		}
		return $str;
	}
	
	private function deleteMultiItem(){
		global $DB;	
		$multi = $_POST['delmulti'];
		if($multi){
			foreach ($multi as $mtId){
				$sql = "SELECT * FROM ".$this->table." WHERE ".$this->id_item."=".$mtId;
				$db = $DB->query($sql);
				if($rs = mysql_fetch_array($db)){
					deleteimage($rs['image']);
				}
				$DB->query("DELETE FROM ".$this->table." WHERE ".$this->id_item."=".$mtId);
				Message::showMessage("success","Đã xóa xong !");
			}	
		}
	}
	
	private function getData($update=0,$id=0){
		global  $my,$_FILES, $CONFIG;
		$id = intval($id);
		$data = array();
		$data['name']		= compile_post('name');
		
		if(compile_post('title')){
			$data['title']	= compile_post('title');	
		}else{
			$data['title']	= compile_post('name');	
		}
		$data['id_category']= compile_post('parentid');
		$groupcat 			= $_POST['groupcat'];
		$data['intro'] 		= $_POST['intro'];
		$data['content'] 	= $_POST['content'];
		$data['description']= compile_post('description');	
		$data['keywords']	= compile_post('keywords');	
		$data['active']		= intval(compile_post('active'));	
		$data['thu_tu'] 	= intval(compile_post('thu_tu'));

		$data['showdate'] 	= intval(compile_post('showdate'));
		
		if(compile_post('ngay_dang')!=''){
			$data['ngay_dang']		=string_to_microtime(compile_post('ngay_dang'));
		}else{
			$data['ngay_dang']		=time() + $CONFIG['time_offset'];
		}
		if(compile_post('autourl')==1){
			$url = clean_url(compile_post('name')).'.html';	
		}else{
			$url = compile_post('url');
		}
		$data['url'] = $url;
		
		$group=":";
		$gr =$groupcat;
		if($gr){
			foreach($gr as $gro){
				$group.=$gro.":";	
			}
		}
		$data['groupcat']=$group;
		
		// xử lý ảnh
		if($_FILES['image']['size']){
			$image = Image::uploadImage('image','no');
			$data['image'] = $image['image'];
		}else{
		 	$data['image'] 	= compile_post('imageurl');
		}
		$data['id_user'] = $my['id'];
		$file = $_POST['file'];
		$data['file'] = addslashes(json_encode($file));
		return $data;
	}
	
}

?>
