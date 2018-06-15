<?php 
// Nguyen Binh
// suongmumc@gmail.com

defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );
$tpl=new TemplatePower("skin/profile.tpl");
$tpl->prepare();
	$id=intval($_GET['id']);
	$module = new Contact;
	$module->_int();

$tpl->printToScreen();

class Contact{
	public function _int(){
		global $DB, $tpl;
		if($_POST['code']=='save'){
			$this->Save();	
		}
		$this->viewProfile();
	}	
	
	private function viewProfile(){
		global $DB, $tpl;
		$tpl->newBlock("view");
		$sql = "SELECT * FROM users WHERE id_users = ". intval($_SESSION["session_user_id"]);
		$db = $DB->query($sql);
		if($rs = mysql_fetch_array($db)){
			$tpl->assign("name",$rs['name']);
			$tpl->assign("username",$rs['username']);
			$tpl->assign("email",$rs['email']);
			$tpl->assign("address",$rs['address']);
			$tpl->assign("telephone",$rs['telephone']);
		}
	}
	
	private function getData(){
		$data = array();
		$data['name']		= compile_post('name');
		$data['email']		= compile_post('email');
		$data['address']	= compile_post('address');
		$data['telephone']	= compile_post('telephone');
		
		return $data;
	}
	private function Save(){
		global $DB, $tpl;
		$a = $this->getData();
		$id = intval($id);
		$sql = "SELECT * FROM users WHERE id_users = ".intval($_SESSION["session_user_id"])." AND password = '".md5(compile_post('currentpassword'))."'";
		$db = $DB->query($sql);
		if($rs = mysql_fetch_array($db)){
			if(compile_post('newpassword') && (compile_post('newpassword') == compile_post('repassword'))){
				$a['password']	= md5(compile_post('newpassword'));
				if($a){
					$b=$DB->compile_db_update_string($a);
					$sql="UPDATE users SET ".$b." WHERE id_users=".intval($_SESSION["session_user_id"]);
					$db=$DB->query($sql);
					Message::showMessage("success","Cập nhật thành công !");
				}
			
			}else{
				Message::showMessage("error","Mật khẩu và mật khẩu nhập lại không trùng nhau !");	
			}
			
		}else{
			Message::showMessage("error","Mật khẩu nhập hiện tại không đúng !");	
		}
	}
	
}

?>