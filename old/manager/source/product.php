<?php 
// Nguyen Binh
// suongmumc@gmail.com

defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );
$tpl=new TemplatePower("skin/product.tpl");
$tpl->prepare();
	$id=intval($_GET['id']);
	$idc=intval($_GET['idc']);
	$pid=intval($_GET['pid']);

	$module = new News;
	$module->_int();

$tpl->printToScreen();

class News extends cat_tree{
	private $page = "Sản phẩm";
	private $item = "sản phẩm";
	private $table = "product";
	private $id_item = "id_product";
	private $par_page = "product";
	private $numberPageShow = 8;
	private $numberItemPage = 30;
	private $thumbwidth = 80;
	private $data_type='product';
	
	public function _int(){
		global $tpl,$id,$pid, $imagedir;
		$this->get_cat_tree(0,$this->data_type);	
		$pathpage = '<li><a href="?page='.$this->par_page.'">'.$this->page.'</a> <span class="divider">></span></li>'. $this->get_cat_string_admin($pid,$this->par_page);
		$tpl->assignGlobal('pathpage',$pathpage);
		$tpl->assignGlobal("item",$this->item);
		$tpl->assignGlobal("table",$this->table);
		$tpl->assignGlobal("id_item",$this->id_item);
		$tpl->assignGlobal("par_page",$this->par_page);
		$tpl->assignGlobal("pid",$pid);
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
		global $DB,$tpl,$lang,$dklang,$tree,$pid,$CONFIG;
		$pid = intval($pid);
		$tpl->newBlock("AddNew");	
		$tpl->assign("action",'?page='.$this->par_page.'&code=save&pid='.$pid);
		// list category
			$info['parentid1']=$pid;
			$info['parentid'] .= '<select name="parentid" style="WIDTH: 300px" id="idc" >';
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
			
			
			$catphukien['parentid'] .= '<select name="listcatphukien" style="WIDTH: 200px" id="listcatphukien" >';
			$catphukien['parentid'] .= '<option value="0">Tất cả</option>';
			if($tree)
			foreach($tree as $k => $v) {
				foreach($v as $i => $j) {
					$catphukien['parentid'] .= '<option value="' . $k . '">' . $j . '</option>';
				}
			}
			$catphukien['parentid'] .= '</select>';
			$tpl->assign("catphukien",$catphukien['parentid']);
			
			
			// in group	
			$str=$rs['groupcat'];
			$gr=explode(':',$str);
			$info1['parentid'] .= '<option value="0">None</option>';
			if($tree)
			foreach($tree as $k => $v) {
				foreach($v as $i => $j) {
					$info1['parentid'] .= '<option value="' . $k . '">' . $j . '</option>';
				}
			}
			$tpl->assign("parentid1"	,$info1['parentid']);
			
			$tpl->assign("intro"		,ClEditor::EditorBase("intro",'&nbsp;'));
			$tpl->assign("content"		,ClEditor::Editor("content",'&nbsp;'));
			$tpl->assign("active"		,"checked");
			$tpl->assign("autourl"		,"checked");
			$tpl->assign("ngay_dang",date('d/m/Y H:i',time() + $CONFIG['time_offset']));
			$tpl->assign("thu_tu",Order::getOrderCat($this->table));
	}	
	
	private function showUpdate(){
		global $DB,$tpl,$lang,$dklang,$id,$imagedir,$tree,$pid;
		$tpl->newBlock("AddNew");
		if($_GET['p']>1){
			$pa = '&p='.$_GET['p'];	
		}
		$tpl->assignGlobal("id",$id);
		$tpl->assign("action",'?page='.$this->par_page.'&code=update&id='.$id.'&pid='.$pid.$pa);
		$sql = "SELECT * FROM ".$this->table." WHERE ".$this->id_item." = ".$id;
		$db = $DB->query($sql);
		if($rs = mysql_fetch_array($db)){
			
			// list category
			$info['parentid1']=$pid;
			$info['parentid'] .= '<select name="parentid" style="WIDTH: 300px"  id="idc" >';
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
			
			$catphukien['parentid'] .= '<select name="listcatphukien" style="WIDTH: 200px" id="listcatphukien" >';
			$catphukien['parentid'] .= '<option value="0">Tất cả</option>';
			if($tree)
			foreach($tree as $k => $v) {
				foreach($v as $i => $j) {
					$catphukien['parentid'] .= '<option value="' . $k . '">' . $j . '</option>';
				}
			}
			$catphukien['parentid'] .= '</select>';
			$tpl->assign("catphukien",$catphukien['parentid']);
			
			
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
					$info1['parentid'] .= '<option value="' . $k . '"'.$selectstr1.'>' . $j . '</option>';
				}
			}
			$tpl->assign("parentid1"	,$info1['parentid']);
			$tpl->assign("name"			,$rs['name']);
			$tpl->assign("ma"			,$rs['ma']);
			$tpl->assign("title"		,$rs['title']);
			$tpl->assign("description"	,$rs['description']);
			$tpl->assign("keywords"		,$rs['keywords']);
			$tpl->assign("thu_tu"		,$rs['thu_tu']);
			$tpl->assign("intro"		,ClEditor::EditorBase("intro",$rs['intro']));
			$tpl->assign("content"		,ClEditor::Editor("content",$rs['content']));
			
			$tpl->assign("tab2"		,$rs['tab2']);
			$tpl->assign("tab3"		,$rs['tab3']);
			
			
			$tpl->assign("tab2content"	,ClEditor::Editor("tab2content",$rs['tab2content']));
			$tpl->assign("tab3content"	,ClEditor::Editor("tab3content",$rs['tab3content']));
			
			$tpl->assign("url"			,$rs['url']);
			$tpl->assign("don_vi"		,$rs['don_vi']);
			$tpl->assign("price"		,$rs['price']);
			$tpl->assign("pricekm"		,$rs['pricekm']);
			$tpl->assign("baohanh"		,$rs['baohanh']);
			if($rs['status'] == 1) 		$tpl->assign("status","checked");
			$tpl->assign($rs['icon'] 	,"checked");
			$tpl->assign("ngay_dang" 	,date('d/m/Y H:i',$rs['ngay_dang']));
			$link_delete_image = "index4.php?page=action_ajax&code=delete&id=".$rs[$this->id_item]."&table=".$this->table."&id_item=".$this->id_item;
			if($rs['image']){
				$tpl->assign("image",'<img src="image.php?w=150&src='.$rs['image'].'" class="img-polaroid marginright5" align="left" id="avatar" /><br /><a href="'.$link_delete_image.'" id="trash_image" class="icon-trash" title="Xóa ảnh"></a>');
			}
			$tpl->assign("imageurl",$rs['image']);
			if($rs['active']==1) $tpl->assign("active","checked");
			
			
			$phukien = json_decode($rs['phukien']);	
			if($phukien){
				foreach($phukien as $pk){
					$sql2 = "SELECT name, id_product FROM product WHERE active=1 AND id_product = ".intval($pk)." ORDER BY name ASC";
					$db2 = $DB->query($sql2);
					while($rs2 = mysql_fetch_array($db2)){
						$tpl->newBlock("phukien");
						$tpl->assign("phukienname",$rs2['name']);
						$tpl->assign("phukienid",$rs2['id_product']);
					}
				}
			}
			
			// show other image;
			$sql1 = "SELECT * FROM image_product WHERE id_product = $id";
			$db1 = $DB->query($sql1);
			while($rs1 = mysql_fetch_array($db1)){
				$tpl->newBlock("OtherImage");
				$tpl->assign("image",$imagedir.$rs1['image']);
				$tpl->assign("image1",$rs1['image']);
				$tpl->assign("id_image",$rs1['id']);
			}
			
			
		}
	}
	
	private function showList(){
		global $DB,$tpl,$lang,$dklang,$pid,$site_address,$dir_path,$imagedir,$tree;
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
				$info['parentid'] .= '<option value="' . $k . '"'.$selectstr.'>' . $j . '</option>';
			}
		}
		$info['parentid'] .= '</select>';
		$tpl->assign("parentid",$info['parentid']);
		
		
		if($pid == 0 && $dk==''){
			$dk= " 1 = 1 ";
		}else{
			$dk="(".$this->table.".id_category=".$pid." OR ".$this->table.".groupcat LIKE '%:".$pid.":%')";
		}
		
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
				don_vi =>$rs['don_vi'],
				user_name => $rs['user_name'],
				createdate => @date('d/m/Y | H:i',$rs['ngay_dang']),
				url => $site_address.$dir_path."/".$rs['url'],
				groupcat => $this->getGroupCatName($rs['groupcat'])
			));
			$tpl->assign("categoryname",Category::categoryName($rs['id_category']));
			$tpl->assign("linkcat","?page=".$this->par_page."&pid=".$rs['id_category']);
			if($rs['image']){
				$tpl->assign("image",'<img src="./image.php?w='.$this->thumbwidth.'&src='.$rs['image'].'" class="thumblistnews" />');
			}
			if($rs['active']==1) $tpl->assign("active","checked");
			$tpl->assign("link_edit",'?page='.$this->par_page.'&code=showUpdate&pid='.$rs['id_category'].'&id='.$rs[$this->id_item]);
			$tpl->assign("link_delete",'?page=action_ajax&code=deleteitem&id='.$rs[$this->id_item].'&table='.$this->table.'&id_item='.$this->id_item);
		}
		$tpl->assign("showList.pages",$db['pages'])	;
	}
	
	private function showListCate(){
		global $DB,$tpl,$lang,$dklang,$pid;
		$tpl->newBlock("showListCate");
		$sql = "SELECT * FROM category WHERE parentid = $pid $dklang ORDER BY thu_tu ASC, name ASC";
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
			$idx = mysql_insert_id();
			$this->insertOtherImage($idx);
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
			$this->insertOtherImage($id);
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
		global  $my,$_FILES,$imagedir;
		$id = intval($id);
		$data = array();
		$data['name']		= compile_post('name');
		$data['ma']		= compile_post('ma');
		
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
		$data['don_vi'] 	= compile_post('don_vi');
		$data['price'] 		= compile_post('price');
		$data['pricekm'] 	= compile_post('pricekm');
		$data['baohanh'] 	= compile_post('baohanh');
		$data['icon'] 		= compile_post('icon');
		$data['status'] 	= intval(compile_post('status'));
		
		$data['tab2'] 		= compile_post('tab2');
		$data['tab3'] 		= compile_post('tab3');
		$data['tab4'] 		= compile_post('tab4');
		
		$data['tab2content'] 	= $_POST['tab2content'];
		$data['tab3content'] 	= $_POST['tab3content'];
		$data['tab4content'] 	= $_POST['tab4content'];
		
		if(compile_post('ngay_dang')!=''){
			$data['ngay_dang']		=string_to_microtime(compile_post('ngay_dang'));
		}else{
			$data['ngay_dang']		=time();
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
		$attr = $_POST['attribute'];
		$data['attr'] = addslashes(json_encode($attr));	
		// xử lý ảnh
		if($_FILES['image']['size']){
			$image = Image::uploadImage('image','no');
			$data['image'] = $imagedir."/".$image['image'];
		}else{
		 	$data['image'] 	= compile_post('imageurl');
		}
		$data['id_user'] = $my['id'];
		
		$pk = $_POST['phukien'];
		$data['phukien'] = addslashes(json_encode($pk));
		
		
		return $data;
	}
	
	public function insertOtherImage($id){
		global $DB, $tpl;
		$id = intval($id);
		$otherimage = $_POST['otherimage'];
		$DB->query("DELETE FROM image_product WHERE id_product = $id");
		foreach($otherimage as $image){
			$DB->query("INSERT INTO image_product(image,id_product) VALUES('".$image."','".$id."')");	
		}
	}
	
	
	
}

?>