<?php 
// Nguyen Binh
// suongmumc@gmail.com
error_reporting(0);
defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );

	$tpl=new TemplatePower("skin/export_list_customer.tpl");
	$tpl->prepare();
	
	
	
	$fieldId = $_REQUEST['fieldId'];
	$formId = intval($_REQUEST['formId']);
	$fDate = $_POST['fromdate'];
	$tDate = $_POST['todate']	;
	$fromDate = strip_date_time($fDate.' 00:00');
	$toDate = strip_date_time($tDate.' 23:59');
	
	$sql = "SELECT * FROM forms WHERE id = $formId";
	$db = $DB->query($sql);
	if($rs = mysql_fetch_array($db)){
		$form_name = $rs['form_name'];
		$tpl->assign("form_name",$form_name);
		
	}	
	if($fDate) $tpl->assign("fromdate",$fDate);
	if($tDate) $tpl->assign("todate",' - ' .$tDate);
	
	
	
	listFormResult();
	// export to
	if($_POST['exportTo'] == 'screen'){
		$tpl->assignGlobal("style",'style="border:solid 1px #CCC; border-collapse:collapse"');
		$tpl->printToScreen();
	}else{
		require_once('../lib/excell.php');
		$data = $tpl->getOutputContent();
		exportExcell($data,clean_url($form_name),$form_name);
	}

	function getFieldCaption($fieldId){
		global $DB,$tpl;
		$fieldId = intval($fieldId);
		$sql = "SELECT * FROM form_field WHERE id = $fieldId";
		$db = $DB->query($sql);
		if($rs = mysql_fetch_array($db)){
			$tpl->newBlock("field")	;
			$tpl->assign("field_caption",$rs['field_caption']);
			return $rs['column_name'];
		}
	}
	
	
	function listFormResult(){
		global $DB, $tpl,$fDate,$tDate,$fromDate,$toDate,$formId,$fieldId;
		$dk = '';
		if($fDate){
			$dk.= ' AND createdate >='.$fromDate.' ';
		}
		
		if($tDate){
			$dk.= ' AND createdate <='.$toDate.' ';	
		}
		if($fieldId){ // loc truong theo tuy chon
			foreach ($fieldId as $field){
				$fieldshow[] = getFieldCaption($field);
			}
		}else{ // lay tat ca các truong cua form
			$notIn = array("submitbuttom","captcha");
			$sql = "SELECT * FROM form_field WHERE form_id = $formId";
			$db = $DB->query($sql);
			while($rs = mysql_fetch_array($db)){
				if(!in_array($rs['control_type'],$notIn)){
					$tpl->newBlock("field")	;
					$tpl->assign("field_caption",$rs['field_caption']);
					$fieldshow[] = $rs['column_name'];	
				}
			}
		}
		$sql = "SELECT * FROM forms_result WHERE form_id=$formId $dk ORDER BY createdate DESC";
		$db = paging::pagingAdmin($_GET['p'],'?page=forms',$sql,8,2000);
		while($rs = mysql_fetch_array($db['db']))	{
			$tpl->newBlock("tr");
			$json = json_decode($rs['json_content']);
			foreach($fieldshow as $f){
				try {
					$tpl->newBlock("td");
					$tpl->assign("column",$json->$f);
				} catch (Exception $e) {
				   
				}
			}
		}
	}
?>