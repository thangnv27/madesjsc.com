<?php 
//error_reporting(E_ERROR);
defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );

$pid = intval($_REQUEST['pid']);
$id = intval($_REQUEST['id']);
$field_id = intval($_REQUEST['field_id']);
$code = $_GET['code'];

if($_REQUEST['act'] == 'create_field_form'){
	$tpl=new TemplatePower("skin/create_field.tpl");
	$tpl->prepare();
	
		$tpl->assignGlobal('id',$id);
		$create_field = new createField($code);
	
	$tpl->printToScreen();
}else if ($_REQUEST['act'] == 'load_field_list'){
	echo createField::putDropdownlist($id);
}else if($_REQUEST['act'] == 'delete_field'){
		createField::deleteField($field_id);	

}else{
	$tpl=new TemplatePower("skin/create_form.tpl");
	$tpl->prepare();
		
		
		$adminpage = "create_form";
		$data_type = 'forms';
		$category = "category";
		$id_category = "id_category";
		$page_title = "forms";
		
		$ct=new cat_tree($pid);
		$ct->get_cat_tree(0,$data_type);	
		$pathpage = '<li><a href="?page='.$adminpage.'">'.$page_title.'</a> <span class="divider">></span></li>'. $ct->get_cat_string_admin($pid,$adminpage);
		
		$tpl->assignGlobal('pathpage',$pathpage);
		$tpl->assignGlobal("adminpage",$adminpage);
		$tpl->assignGlobal("pid",$pid);
	
		
	
		$createForm = new createForm($code);
	
	$tpl->printToScreen();
}

class createForm{
	
		
	public function __construct($code){
		global $tpl,$id, $pid;
		
		switch($code){
			case 'tabgeneral':
				$tpl->newBlock("create_form");
				$tpl->assign("tabgeneral","active");
				$this->showTabGeneral();
				break;

			case 'save_tabgeneral':
				$tpl->newBlock("create_form");
				$tpl->assign("tabgeneral","active");
				$this->saveDataFormGeneral();
				break;
				
			case 'show_update':
				$tpl->newBlock("create_form");
				$tpl->assign("tabgeneral","active");
				$this->showUpdateForm($id);
				break;
				
			case 'update_tabgeneral':
				$tpl->newBlock("create_form");
				$tpl->assign("tabgeneral","active");
				$this->updateDataFormGeneral();
				break;
			
		}	
		$this->showList();
	}
		
		
	/// tab general
	private function showTabGeneral(){
		global $DB, $tpl, $tree, $pid, $adminpage;
		$tpl->newBlock("tabgeneral");
			
			$tpl->assign("action","?page=".$adminpage."&pid=".$pid."&code=save_tabgeneral");
			$tpl->assignGlobal ("layout",ClEditor::Editor("layout",'&nbsp;'));
			$tpl->assignGlobal ("notifi_email",ClEditor::Editor("notifi_email",'&nbsp;'));
			$tpl->assignGlobal ("autoresponder_email",ClEditor::Editor("autoresponder_email",'&nbsp;'));
			// list category
			$info['parentid1']=$pid;
			$info['parentid'] .= '<select name="id_category" style="width: 300px" >';
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
			$tpl->assign("autourl","checked");
			
	}	
	
	private function showUpdateForm($id){
		global $tpl,$tree,$adminpage,$pid;
		$id = intval($id);
		
		$tpl->assignGlobal("id",$id);
		
		$tpl->newBlock("showNextTab");
		
		$tpl->assignGlobal("action_tabfield","index4.php?page=".$adminpage."&act=create_field_form&id=$id");
		$tpl->assign("action","?page=".$adminpage."&pid=".$pid."&code=update_tabgeneral&id=$id");
		$tpl->newBlock("tabgeneral");
	  	$tpl->assign("action","?page=".$adminpage."&pid=".$pid."&code=update_tabgeneral&id=$id");
		$rs = $this->getByIdForm($id);
		
		$tpl->assignGlobal ("layout",ClEditor::Editor("layout",$rs['layout']));
		$tpl->assignGlobal ("notifi_email",ClEditor::Editor("notifi_email",$rs['notifi_email']));
		$tpl->assignGlobal ("autoresponder_email",ClEditor::Editor("autoresponder_email",$rs['autoresponder_email']));
		$tpl->assign(array(
			form_name 			=> $rs['form_name'],
			title 				=> $rs['title'],
			description			=> $rs['description'],
			keywords 			=> $rs['keywords'],
			display_text 		=> $rs['display_text'],
			url_redirect 		=> $rs['url_redirect'],
			submit_button_text 	=> $rs['submit_button_text'],
			url 				=> $rs['url'],
			
			from_email 			=> $rs['from_email'],
			to_email 			=> $rs['to_email'],
			subject_email 		=> $rs['subject_email'],
			autoresponder_subject 		=> $rs['autoresponder_subject']

		));
		
		
		if($rs['custom_layout'] == 1) $tpl->assign("custom_layout","checked");
		if($rs['send_to_email'] == 1) $tpl->assign("send_to_email","checked");
		if($rs['autoresponder'] == 1) $tpl->assign("autoresponder","checked");
		
		$tpl->assign("after_submit_".$rs['after_submit'],"checked");
				
		// list category
		$info['parentid1']=$rs['id_category'];
		$info['parentid'] .= '<select name="id_category" style="width: 300px" >';
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
		$tpl->assign('field_dropdownlist',createField::putDropdownlist($id)) ;
	}
	
	private function saveDataFormGeneral(){
		global $DB;
		$data = $this->getDataFormGeneral();
		if($data){
			$b=$DB->compile_db_insert_string($data);
			$sql="INSERT INTO forms (".$b['FIELD_NAMES'].") VALUES (".$b['FIELD_VALUES'].")";
			$DB->query($sql);
			$lastid = mysql_insert_id();
			Message::showMessage("success","Thêm mới thành công !");

			$this->showUpdateForm($lastid);
		}
	}
	
	private function updateDataFormGeneral(){
		global $DB,$id;
		$id = intval($id);
		$data = $this->getDataFormGeneral(1);/// update = 1
		if($data){
			$b=$DB->compile_db_update_string($data);
			$sql="UPDATE forms SET ".$b." WHERE id=".$id;
			$db=$DB->query($sql);
			
			Message::showMessage("success","Sửa chữa thành công !");
			$this->showUpdateForm($id);
		}
	}
	
	private function getDataFormGeneral($update = 0){
		global $my,$CONFIG;
		$a = array();
		$a['form_name'] 			= compile_post('form_name');
		
		if(compile_post('title')){
			$a['title']	= compile_post('title');	
		}else{
			$a['title']	= $a['form_name'];	
		}
		
		$a['after_submit'] 			= compile_post('after_submit');
		$a['id_category'] 			= intval(compile_post('id_category'));
		$a['display_text'] 			= compile_post('display_text');
		$a['url_redirect'] 			= compile_post('url_redirect');
		$a['submit_button_text'] 	= compile_post('submit_button_text');
		$a['submit_button_image'] 	= compile_post('submit_button_image');
		$a['layout'] 				= $_POST['layout'];
		
		$a['notifi_email'] 			= $_POST['notifi_email'];
		$a['custom_layout'] 		= intval(compile_post('custom_layout'));
		$a['send_to_email'] 		= intval(compile_post('send_to_email'));
		$a['autoresponder'] 		= intval(compile_post('autoresponder'));
		$a['autoresponder_email'] 	= $_POST['autoresponder_email'];
		$a['from_email'] 			= compile_post('from_email');
		$a['to_email'] 				= compile_post('to_email');
		$a['subject_email'] 		= compile_post('subject_email');
		$a['autoresponder_subject'] = compile_post('autoresponder_subject');
		
		if($update == 0){
			$a['id_user'] 				= $my['id'];
			$a['createdate'] 	= time() + $CONFIG['time_offset'];
		}
		
		if(compile_post('autourl')==1){
			$url = clean_url(compile_post('form_name')).'.html';	
		}else{
			$url = compile_post('url');
		}
		$a['url'] 			= $url;
		$groupcat = $_POST['groupcat'];
		$group=":";
		$gr =$groupcat;
		if($gr){
			foreach($gr as $gro){
				$group.=$gro.":";	
			}
		}
		$a['groupcat'] 		= $group;

		$a['description'] 	= compile_post('description');	
		$a['keywords']		= compile_post('keywords');	
		
		return $a;
	}
	
	
	public function listForms($pid){
		global $DB;
		$pid = intval($pid);
		$data = array();
		$filter = "WHERE id_category IN(".Category::getParentId($pid).")";
		$sql = "SELECT f.*,u.name AS username FROM forms f LEFT JOIN users AS u ON(f.id_user = u.id_users) $filter ORDER BY f.form_name ASC";	
		$db = $DB->query($sql) ;
		while($rs = mysql_fetch_array($db)){
			$data[]	= $rs;
		}
		return $data;
	}
	
	public function getByIdForm($id){
		global $DB;
		$id = intval($id);
		$sql = "SELECT * FROM forms WHERE id = $id";
		$db = $DB->query($sql);
		$rs = mysql_fetch_array($db);
		return $rs;
	}
	/// end tab general
	
	
	
	private function showList(){
		global $DB, $tpl, $adminpage,$pid, $site_address,$dir_path,$tree;
		$list = $this->listForms($pid);
		$tpl->newBlock("showlist");
		
		// list category
		$info['parentid1']=$pid;
		$info['parentid'] .= '<select name="parentid" id="parentid" style="width: 300px" >';
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
		
		foreach($list as $rs){
			if($rs['id'] > 0){
				$tpl->newBlock("list_forms");
				$tpl->assign(array(
					form_name 	=> $rs['form_name'],
					username 	=> $rs['username'],
					createdate 	=> date('d/m/Y H:i',$rs['createdate']),
					url 		=> $site_address.$dir_path.'/'.url_process::getUrlCategory($rs['id_category']).$rs['url'],
					link_edit 	=> '?page='.$adminpage.'&code=show_update&id='.$rs['id'],
					categoryname=> Category::categoryName($rs['id_category']),
					id   		=> $rs['id'],
					groupcatname=> Category::getGroupCatName($rs['groupcat'])
					
				));
				$tpl->assign("link_delete",'?page=action_ajax&code=deleteitem&id='.$rs['id'].'&table=forms&id_item=id');
			}
		}
	}
	
}

class createField{
	
	public function __construct($code){
		global $id, $field_id, $tpl;
		$id = intval($id);
		
		switch($code){
			case 'save':
				$tpl->assign("action","index4.php?page=create_form&act=create_field_form&id=$id&code=save");
				$this->saveTabfield($id);
				break;
			case 'showupdate':
				$tpl->assign("action","index4.php?page=create_form&act=create_field_form&id=$id&field_id=$field_id&code=update");
				$this->showUpdateTabfield($field_id);
				break;
			case 'update':
				$this->updateTabfield($field_id);
				break;
			
			default: 
				$tpl->assign("action","index4.php?page=create_form&act=create_field_form&id=$id&code=save");	
			
		}	
	}
	
	private function showUpdateTabfield($field_id){
		global $tpl;
		$rs = createField::getById($field_id);
		$tpl->assign(array(
			column_name => $rs['column_name'],
			placeholder => $rs['placeholder'],
			default_value => $rs['default_value'],
			field_caption => $rs['field_caption'],
			data_source_text => $rs['data_source_text'],
			error_message => $rs['error_message'],
			control_css_class => $rs['control_css_class'],
			caption_css_class => $rs['caption_css_class'],
			input_style => $rs['input_style'],
			caption_style => $rs['caption_style']
		));
		if($rs['allow_empty_value'] == 1)  $tpl->assign("allow_empty_value","checked");
		$tpl->assign($rs['data_source_type'],"checked");
		$tpl->assign($rs['control_type'],"selected");
	}
	
	private function saveTabfield($id){
		global $DB;
		$id = intval($id);
		
		if($id > 0){
			$data = $this->getDataFormField();
			
			$data['form_id'] = $id;
			$b=$DB->compile_db_insert_string($data);
			$sql="INSERT INTO form_field (".$b['FIELD_NAMES'].") VALUES (".$b['FIELD_VALUES'].")";
			$DB->query($sql);
		}
	}
	
	private function updateTabfield($field_id){
		global $DB;
		$id = intval($field_id);
		if($id >0){
			$data = $this->getDataFormField();
			if($data){
				$b=$DB->compile_db_update_string($data);
				$sql="UPDATE form_field SET ".$b." WHERE id=".$id;
				
				$db=$DB->query($sql);
			}
		}
	}
	
	public function deleteField($field_id){
		global $DB;
		$field_id = intval($field_id);
		$sql = "DELETE FROM form_field WHERE id=$field_id";
		$DB->query($sql);
	}
	
	private function getDataFormField(){
		$a = array();
		$a['field_caption']	 			= compile_post('field_caption');
		$a['column_name']	 			= compile_post('column_name');
		$a['placeholder']	 			= compile_post('placeholder');
		$a['allow_empty_value']	 		= intval(compile_post('allow_empty_value'));
		$a['default_value']	 			= compile_post('default_value');
		$a['caption_style']	 			= compile_post('caption_style');
		$a['control_type']	 			= compile_post('control_type');
		$a['data_source_type']	 		= compile_post('data_source_type');
		$a['data_source_text']	 		= compile_post('data_source_text');
		$a['error_message']	 			= compile_post('error_message');
		$a['control_css_class']	 		= compile_post('control_css_class');
		$a['caption_css_class']	 		= compile_post('caption_css_class');
		$a['input_style']	 			= compile_post('input_style');
		return $a;
	}
	// end tab field
	
	public function getList($form_id){
		global $DB;
		$form_id = intval($form_id);
		$sql = "SELECT * FROM form_field WHERE form_id = $form_id";
		$db = $DB->query($sql);
		while($rs = mysql_fetch_array($db)){
			$data[]	 = $rs;
		}
		return $data;
	}
	
	public function getById($field_id){
		global $DB;
		$form_id = intval($form_id);
		$sql = "SELECT * FROM form_field WHERE id = $field_id";
		$db = $DB->query($sql);
		$rs = mysql_fetch_array($db);
		return $rs;
	}
	
	public function putDropdownlist($form_id){
		$str = '';
		$db = createField::getList($form_id);
		foreach ( $db as $rs){
			if ( $rs['id'] > 0 ){
				$str.='<option value="'.$rs['id'].'">'.$rs['column_name'].'</option>';		
			}
		}
		$str.='<script>
	$(function(){ 
		$("#field option").dblclick(function(){
						$("#create_field_form").append("<div class=\'loading\'></div>");
						$("#create_field_form").load("index4.php?page=create_form&act=create_field_form&code=showupdate&field_id=" + $(this).val() + "&id={id}", function(response, status, xhr) 						{
						  if (status == "error") {
						    var msg = "Sorry but there was an error: ";
						    $("#error").html(msg + xhr.status + " " + xhr.statusText);
						  }
						});
						return false;
					
			});
		});
       </script>';
		return $str;
	}
}


?>