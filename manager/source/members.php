<?php 
// Nguyen Binh
// suongmumc@gmail.com


defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );
$tpl=new TemplatePower("skin/members.tpl");
$tpl->prepare();
	$id=intval($_GET['id']);
	$idc=intval($_GET['idc']);
	$pid=intval($_GET['pid']);

	$Member = new Members;
	$Member->__contruct();

$tpl->printToScreen();

class Members {
	private $page = "Quản lý thành viên";
	private $item = "thành viên";
	private $table = "member";
	private $id_item = "id_member";
	private $par_page = "members";
	private $numberPageShow = 8;
	private $numberItemPage = 30;
	private $thumbwidth = 80;
	private $data_type='';
	
	public function __contruct(){
		global $tpl,$id,$pid, $dir_path;
		
		$pathpage = '<li><a href="?page='.$this->par_page.'">'.$this->page.'</a> <span class="divider">></span></li>Quản lý thành viên';
		$tpl->assignGlobal('pathpage',$pathpage);
		$tpl->assignGlobal("item",$this->item);
		$tpl->assignGlobal("table",$this->table);
		$tpl->assignGlobal("id_item",$this->id_item);
		$tpl->assignGlobal("par_page",$this->par_page);
		$tpl->assignGlobal("dir_path",$dir_path);
		
		
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
		$tpl->assign("active"		,"checked");
		
	}	
	
	private function showUpdate(){
		global $DB,$tpl,$lang,$dklang,$id,$dir_image,$tree,$pid;
		$tpl->newBlock("AddNew");
		if($_GET['p']>1){
			$pa = '&p='.$_GET['p'];	
		}
		$tpl->assign("action",'?page='.$this->par_page.'&code=update&id='.$id.'&pid='.$pid.$pa);
		$sql = "SELECT * FROM ".$this->table." WHERE ".$this->id_item." = ".$id;
		$db = $DB->query($sql);
		if($rs = mysql_fetch_array($db)){
			
			$tpl->assign("name"			,$rs['name']);
			$tpl->assign("telephone"	,$rs['telephone']);
			$tpl->assign("email"		,$rs['email']);
			$tpl->assign("address"		,$rs['address']);
			$tpl->assign("chucvu"		,$rs['chucvu']);
			$tpl->assign("otherinfo"	,$rs['otherinfo']);
		
			
			$tpl->assign("registtime" 	,date('d/m/Y H:i',$rs['registtime']));
			$link_delete_image = "index4.php?page=actionajax&code=delete&id=".$rs[$this->id_item]."&table=".$this->table."&id_item=".$this->id_item;
			
			if($rs['active']==1) $tpl->assign("active","checked");
		}
	}
	
	private function showList(){
		global $DB,$tpl,$lang,$language,$pid,$site_address,$dir_path,$dir_image,$tree;
		$tpl->newBlock("showList");
		if(intval($_GET['p']) < 1 ) $p = 1;
		else $p= intval($_GET['p']);
		
		$tpl->assign("par_page",$this->par_page);
		$tpl->assign("action","?page=".$this->par_page."&code=ordering&pid=".$pid."&p=".$p);
		
		if($_REQUEST['keyword']){
			$keyword = clean_value($_REQUEST['keyword']);
			$dk.=" WHERE ".$this->table.".name LIKE '%".$keyword."%' ";
			$kw = "&keyword=".$keyword;
		}
		
		$sql = "SELECT * FROM member $dk ORDER BY name ASC";
		$db = paging::pagingAdmin($p,"?page=".$this->par_page.$kw,$sql,$this->numberPageShow,$this->numberItemPage);
		while($rs = mysql_fetch_array($db['db'])){
			$tpl->newBlock("list");
			$tpl->assign(array(
				name => $rs['name'],
				email => $rs['email'],
				telephone => $rs['telephone'],
				registtime => date('d/m/Y H:i',$rs['registtime'])
			));
			
			if($rs['active']==1) $tpl->assign("active","checked");
			$tpl->assign("link_edit",'?page='.$this->par_page.'&code=showUpdate&pid='.$rs['id_category'].'&id='.$rs[$this->id_item]);
			$tpl->assign("link_delete",'?page=action_ajax&code=deleteitem&id='.$rs[$this->id_item].'&table='.$this->table.'&id_item='.$this->id_item);
		}
		$tpl->assign("showList.pages",$db['pages'])	;
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
		$data['registtime'] = time();
		$sql = "SELECT * FROM member WHERE email = '".$data['email']."'";
		$db = $DB->query($sql);
		if(mysql_num_rows($db)>0){
			Message::showMessage("success","Thành viên này đã tồn tại trên hệ thống !");
		}else{
			if($data){
				$b=$DB->compile_db_insert_string($data);
				$sql="INSERT INTO ".$this->table." (".$b['FIELD_NAMES'].") VALUES (".$b['FIELD_VALUES'].")";
				$DB->query($sql);
				Message::showMessage("success","Thêm mới thành công !");
			}
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
	
	function getData($update=0,$id=0){
		global  $my,$_FILES;
		$id = intval($id);
		$data = array();
		$data['name']		= compile_post('name');
		$data['telephone'] 	= compile_post('telephone');	
		$data['email'] 		= compile_post('email');	
		$data['chucvu'] 	= compile_post('chucvu');
		$data['address'] 	= compile_post('address');	
		$data['otherinfo'] 	= compile_post('otherinfo');	
		$data['active']		= intval(compile_post('active'));	
		if(compile_post('password') && (compile_post('password') == compile_post('repassword'))){
			$data['password'] = compile_post('password');
		}
		return $data;
	}
	
}

?>