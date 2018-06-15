<?php 
defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );
$tpl=new TemplatePower("skin/home.tpl");
$tpl->prepare();

$H = new homeAdmin;
$H->__contract();

$tpl->printToScreen();

	class homeAdmin{
		public function __contract(){
			$this->shortcutInHome();
			$this->countContact();
		
		}
		
		private function shortcutInHome(){
			global $DB,$tpl,$language;	
			$dataType = new url_process;
			$sql = "SELECT * FROM category WHERE shortinhome=1 $language ORDER BY thu_tu ASC, name ASC";
			$db = $DB->query($sql);
			while($rs = mysql_fetch_array($db)){
				$dt = $dataType->type_Info($rs['data_type']);
				$tpl->newBlock("cell");
				$tpl->assign("name",$rs['name'])	;
				$tpl->assign("link","?page=".$dt['adminpage']."&pid=".$rs['id_category']);
			}
		}
		
		private function countContact(){
			global $DB,$tpl;
			$sql = "SELECT * FROM contact WHERE xem=0";
			$db = $DB->query($sql);
			if(intval(mysql_num_rows($db))>0){
			$tpl->assignGlobal("countcontact",'<div class="icon"><span class="badge badge-warning">'.intval(mysql_num_rows($db)).'</span></div>');
			}
		}
	
	}

?>