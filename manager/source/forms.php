<?php 
// Nguyen Binh
// suongmumc@gmail.com

defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );
$tpl=new TemplatePower("skin/forms.tpl");
	$tpl->prepare();
	
if($_GET['act'] == 'getField'){
	$tpl->newBlock("list_field_of_form");
	$form_id = intval($_GET['form_id']);
	getFieldList($form_id);
}else{
		$tpl->newBlock("show_list_form");
		$id=intval($_GET['id']);
		
		
		$fdate = $_GET['fromdate'];
		$tdate = $_GET['todate'];
		
		$fromdate = strip_date_time($fdate.' 00:00');
		$todate = strip_date_time($tdate.' 23:59');
		
		$module = new formResult;
	
}
$tpl->printToScreen();
class formResult{
	public function __construct(){
		global $DB, $tpl;
		if($_GET['code'] == 'view'){
			$this->viewFormInfo();
		}
		if($_GET['code'] == 'delete'){
			$this->Delete();	
		}
		$this->listFormResult();
	}	
	
	private function listFormResult(){
		global $DB, $tpl,$fdate,$tdate,$fromdate,$todate;
		$tpl->newBlock("showList");
		$dk = '';
		if($fdate){
			$tpl->assign("fromdate",$fdate);	
			$dk.= ' AND createdate >='.$fromdate.' ';
		}
		
		if($tdate){
			$tpl->assign("todate",$tdate);	
			$dk.= ' AND createdate <='.$todate.' ';	
		}
		
		$sql = "SELECT * FROM forms_result WHERE 1=1 $dk ORDER BY createdate DESC";
		$db = paging::pagingAdmin($_GET['p'],'?page=forms',$sql,8,40);
		while($rs = mysql_fetch_array($db['db']))	{
			$tpl->newBlock("list")	;
			if($rs['viewed']==0){
				$tpl->assign("name",'<strong>'.$rs['subject'].'</strong>');
			}else{
				$tpl->assign("name",$rs['subject']);
			}
			$tpl->assign("createdate",date('d/m/Y - H:i', $rs['createdate']));
			$tpl->assign("link",'?page=forms&code=view&id='.$rs['id']);
			$tpl->assign("linkdel","?page=forms&code=delete&id=".$rs['id']);
		}
		$tpl->assign("showList.pages",$db['pages']);
		$this->listForms();
	}
	private function viewFormInfo(){
		global $DB, $tpl,$id;
		$sql = "SELECT * FROM forms_result WHERE id = $id";
		$db = $DB->query($sql);
		if($rs = mysql_fetch_array($db)){
		  	$tpl->newBlock("view")	;
			if($rs['viewed'] == 0){
				$tpl->assign("name",'<strong>'.$rs['subject'].'</strong>');
			}else{
				$tpl->assign("name",$rs['subject']);
			}
			$tpl->assign("createdate",date('d/m/Y H:i', $rs['createdate']));
			$tpl->assign("content",$rs['content']);
		}
		$DB->query("UPDATE forms_result SET viewed=1 WHERE id=$id");
	}
	
	private function Delete(){
		global $DB, $tpl, $id;
		$DB->query("DELETE FROM forms_result WHERE id = $id");
	}
	
	private function listForms(){
		global $DB, $tpl;	
		$sql = "SELECT * FROM forms";
		$db = $DB->query($sql);
		while($rs = mysql_fetch_array($db)){
			$tpl->newBlock("listForms");
			$tpl->assign("form_name",$rs['form_name']);
			$tpl->assign("form_id",$rs['id']);
			
		}
	}
	
	
}
function getFieldList($id){
	global $DB,$tpl;
	$id = intval($id);
	$sql1 = "SELECT * FROM form_field WHERE form_id = $id";
	$db1 = $DB -> query($sql1);
	$notIn = array("submitbuttom","captcha");
	while($rs1 = mysql_fetch_array($db1)){
		
		if(!in_array($rs1['control_type'],$notIn)){
			$tpl->newBlock("list_field");
			$tpl->assign('column_name',$rs1['column_name']);
			$tpl->assign('field_caption',$rs1['field_caption']);
			$tpl->assign('field_id',$rs1['id']);
		}
	}
}
?>