<?php 
// Nguyen Binh
// suongmumc@gmail.com
defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );
$tpl=new TemplatePower("skin/module.tpl");
$tpl->prepare();
	$id=intval($_GET['id']);
	$module = new Module;
	$module->_int();

$tpl->printToScreen();

class Module{
	
	private $table 		= 'module';
	private $id_item 	= 'id_module';
	private $par_page 	= 'module';
	
	
	
	public function _int(){
		global $DB, $tpl;
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
				$this->update();
				break;	
			case "ordering":
				$this->ordering();
				break;	
		}	
		$this->showList();
	}
	private function showAddNew(){
		global $DB,$tpl,$lang,$dklang;
		$tpl->newBlock("AddNew");	
		$tpl->assign("action",'?page='.$this->par_page.'&code=save');
	}	
	
	private function showUpdate(){
		global $DB,$tpl,$lang,$dklang,$id;
		$tpl->newBlock("AddNew");	
		$tpl->assign("action",'?page='.$this->par_page.'&code=update&id='.$id);
		$sql = "SELECT * FROM ".$this->table." WHERE ".$this->id_item." = ".$id;
		$db = $DB->query($sql);
		if($rs = mysql_fetch_array($db)){
			$tpl->assign("name",$rs['name']);
			$tpl->assign("gia_tri",$rs['gia_tri']);
			$tpl->assign("filefontend",$rs['filefontend']);
			$tpl->assign("thu_tu",$rs['thu_tu']);
			if($rs['active']==1) $tpl->assign("active","checked");
		}
	}
	
	private function showList(){
		global $DB,$tpl,$lang,$dklang;
		$tpl->newBlock("showList");
		
		$sql = "SELECT * FROM ".$this->table." ORDER BY thu_tu ASC, name ASC";
		$db = $DB->query($sql);
		while($rs = mysql_fetch_array($db)){
			$tpl->newBlock("list");
			$tpl->assign("name",$rs['name']);
			$tpl->assign("thu_tu",$rs['thu_tu']);
			$tpl->assign("id",$rs[$this->id_item]);
			if($rs['active']==1) $tpl->assign("active","checked");
			$tpl->assign("link_edit",'?page='.$this->par_page.'&code=showUpdate&id='.$rs[$this->id_item]);
			$tpl->assign("link_delete",'?page=action_ajax&code=deleteitemmodule&id='.$rs[$this->id_item]);
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
			
			Message::showMessage("success","Thêm mới thành công !");
		}
	}
	
	private function update(){
		global $DB,$tpl,$lang,$dklang, $id;
		$id = intval($id);
		$data = $this->getData();
		if($data){
			$b=$DB->compile_db_update_string($data);
			$sql="UPDATE ".$this->table." SET ".$b." WHERE ".$this->id_item."=".$id;
			$db=$DB->query($sql);
			Message::showMessage("success","Sửa chữa thành công !");
		}
	}
	
	private function getData(){
		global $DB, $tpl;
		$a = array();
		$a['name'] 			= compile_post('name');
		$a['gia_tri'] 		= compile_post('gia_tri');
		$a['filefontend'] 	= compile_post('filefontend');
		$a['active'] 		= intval(compile_post('active'));
		$a['thu_tu'] 		= intval(compile_post('thu_tu'));
		return $a;
	}
	
}

?>