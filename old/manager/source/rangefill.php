<?php 

defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );
$tpl=new TemplatePower("skin/rangefill.tpl");
$tpl->prepare();
$id = intval($_GET['id']);

$range = new rangeFill;
$range->__contruct();

$tpl->printToScreen();

class rangeFill{
	
	private $table = 'supportsearch';
	private $id_item = 'id';
	private $par_page = "rangefill";
	
	public function __contruct(){
		global $DB, $tpl,$id;	
		$tpl->assignGlobal("par_page",$this->par_page);
		switch($_GET['code']){
			case "showUpdate":	
				$this->showUpdate();
				break;
			case "showAddNew":	
				$this->showAddNew();
				break;
			case "save":
				$this->Save($this->getContent(),0);
				break;
			case "update":
				$this->Save($this->getContent(),$id);
				break;
			case "delete":
				$this->Delete();
				break;
			case "changeorder":
				$this->updateOrder();
				break;
			case "deletemulti":
				$this->deleteMulti();
				break;
		}
		$this->showList();
	}
	
	public function showList(){
		global $DB, $tpl;	
		$tpl->newBlock("showList");
		$sql = "SELECT * FROM ".$this->table." ORDER BY thu_tu ASC, name ASC";
		$db = $DB->query($sql);
		while($rs = mysql_fetch_array($db)){
			$tpl->newBlock("list");
			$tpl->assign("name",$rs['name']);
			$tpl->assign("giatri",$rs['giatri']);
			$tpl->assign("giatri1",$rs['giatri1']);
			$tpl->assign("thu_tu",$rs['thu_tu']);
			$tpl->assign("id",$rs[$this->id_item]);
			if($rs['active']==1) $tpl->assign("active","checked");
			$tpl->assign("link_edit","?page=".$this->par_page."&code=showUpdate&id=".$rs[$this->id_item]);
			$tpl->assign("link_delete","?page=".$this->par_page."&code=delete&id=".$rs[$this->id_item]);
		}
	}	
	
	public function showAddNew(){
		global $DB, $tpl;
		$tpl->newBlock("showUpdate");
		$tpl->assign("action",'?page='.$this->par_page.'&code=save');
		$tpl->assign("active","checked");
		$sql = "SELECT max(thu_tu) AS tt FROM ".$this->table;
		$db = $DB->query($sql);
		if($rs = mysql_fetch_array($db)){
			$tpl->assign("thu_tu",$rs['tt']+1)	;
		}
	}
	
	public function showUpdate(){
		global $DB, $tpl, $id;
		$tpl->newBlock("showUpdate");
		$tpl->assign("action",'?page='.$this->par_page.'&code=update&id='.$id);
		$sql = "SELECT * FROM ".$this->table." WHERE ".$this->id_item."=".$id;
		$db = $DB->query($sql);
		if($rs = mysql_fetch_array($db)){
			$tpl->assign("name",$rs['name']);
			$tpl->assign("giatri",$rs['giatri']);
			$tpl->assign("giatri1",$rs['giatri1']);
			$tpl->assign("thu_tu",$rs['thu_tu']);
			if($rs['active']==1) $tpl->assign("active","checked");
		}
	}
	
	public function Save($data,$id){
		global $DB, $tpl;		
		$id = intval($id);
		if($id <= 0){
			if($data){
				$b=$DB->compile_db_insert_string($data);
				$sql="INSERT INTO ".$this->table." (".$b['FIELD_NAMES'].") VALUES (".$b['FIELD_VALUES'].")";
				$DB->query($sql);
				Message::showMessage("success","Thêm mới thành công !");
			}
		}else{
			if($data){
				$b=$DB->compile_db_update_string($data);
				$sql="UPDATE ".$this->table." SET ".$b." WHERE ".$this->id_item."=".$id;
				$db=$DB->query($sql);
				Message::showMessage("success","Sửa chữa thành công !");
			}
		}
	}
	
	public function getContent(){
		global $DB, $tpl;	
		$data = array()	;
		$data['name'] 		= compile_post('name');
		$data['giatri'] 	= compile_post('giatri');
		$data['giatri1'] 	= compile_post('giatri1');
		$data['active'] 	= intval(compile_post('active'));
		$data['thu_tu'] 	= intval(compile_post('thu_tu'));
		return $data;
	}
	
	public function Delete(){
		global $DB, $tpl,$id;
		$DB->query("DELETE FROM ".$this->table." WHERE ".$this->id_item ."=".$id);
		Message::showMessage("success","Đã xóa xong !");
	}
	
	public function updateOrder(){
		global $DB, $tpl;
		$thu_tu = $_POST['thu_tu'];
		if($thu_tu){
			foreach($thu_tu as $tt=>$val)	{
				$DB->query("UPDATE ".$this->table. " SET thu_tu = ".$val." WHERE ".$this->id_item."=".$tt);
				
			}
			Message::showMessage("success","Cập nhật thành công !");
		}
		
	}
	
	public function deleteMulti(){
		global $DB, $tpl;
		$iddel = $_POST['delmulti']	;
		if($iddel){
			foreach	($iddel as $del=>$val){
				$DB->query("DELETE FROM ".$this->table." WHERE ".$this->id_item."=".$val);
			}
			Message::showMessage("success","Cập nhật thành công !");
		}
	}
	
	
}
?>