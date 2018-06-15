<?php 
// Nguyen Binh
// suongmumc@gmail.com

defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );
$tpl=new TemplatePower("skin/photo.tpl");
$tpl->prepare();
	$id=intval($_GET['id']);
	$idc=intval($_GET['idc']);
	$pid=intval($_GET['pid']);
	$tpl->assignGlobal('dir_path',$dir_path);
	$tpl->assignGlobal('pid',$pid);
	$photo = new Photo;
	$photo->_int();
	

$tpl->printToScreen();

class Photo extends cat_tree{
	private $page = "Trang ảnh";
	private $item = "ảnh";
	private $table = "photo";
	private $id_item = "id_photo";
	private $par_page = "photo";
	private $numberPageShow = 8;
	private $numberItemPage = 30;
	private $thumbwidth = 196;
	private $thumbheight = 156;
	private $data_type='photo';
	
	public function _int(){
		global $DB, $tpl, $lang,$dklang,$pid, $imagedir;
		$this->get_cat_tree(0,'');	
		$pathpage = '<li><a href="?page='.$this->par_page.'">'.$this->page.'</a> <span class="divider">></span></li>'. $this->get_cat_string_admin($pid,$this->par_page);
		$tpl->assignGlobal('pathpage',$pathpage);
		
		$tpl->assignGlobal("par_page",$this->par_page);
		$tpl->assignGlobal("imagedir",$imagedir);
		$tpl->assignGlobal("pid",$pid);
		switch ($_GET['code']){
			case "save"	:
				$this->save();
				$this->listPhoto();
				break;
			case "addNew"	:
				$this->addNew();
				break;
			default:
				$this->listPhoto();
		}
		
		
	}
  	public function listPhoto(){
		global $DB, $tpl, $lang,$dklang,$pid,$imagedir;
		$tpl->newBlock("CellPhoto");
		
		$tpl->assign("parentid",$this->listCategory($pid,'parentid'));
		$fillter='';
		if($pid>0){
			$fillter.=" WHERE id_category IN(".Category::getParentId($pid).") ";
		}else{
			$fillter.=" WHERE id_category = 0 ";
		}
		$id_category = intval(compile_post('parentid'));
		
		$tpl->assign("pid",$pid);
		
		$sql = "SELECT * FROM ".$this->table." $fillter ORDER BY thu_tu DESC, ".$this->id_item." DESC";

		$db = paging::pagingAdmin($_GET['p'],"?page=".$this->par_page,$sql,$this->numberPageShow,$this->numberItemPage);
		//$db = $DB->query($sql);
		while($rs = mysql_fetch_array($db['db'])){
			$tpl->newBlock("cell_photo");
			$tpl->assign("name",$rs['name']);
			$tpl->assign("id",$rs[$this->id_item]);
			$tpl->assign("id_category",$rs['id_category']);
			//$tpl->assign("content",$rs['content']);
			if($rs['image']){
				$tpl->assign("image",'<img src="./image.php?w='.$this->thumbwidth.'&h='.$this->thumbheight.'&src='.$imagedir.$rs['image'].'" />');
				$tpl->assign("bigimage",$imagedir.$rs['image']);
			}
		}
		$tpl->assignGlobal("pages",$db['pages']);
	}	
	public function save(){
		global $DB, $tpl, $lang,$dklang,$pid;
		$name = array();
		$id_photo = array();
		$content = array();
		$id_photo = $_POST['id_photo'];
		$name = $_POST['name1'];
		$id_category = intval(compile_post('parentid'));
		$content = $_POST['description'];
		if($_POST['id_photo']){
			foreach($id_photo as $idp)	{
				$a = $name[$idp];
				
				$sql = "UPDATE ".$this->table." SET name='".$a."',id_category='".$id_category."',ngay_dang=".time() .",content='".$content[$idp]."' WHERE ".$this->id_item." = $idp";
				$DB->query($sql);
			}
		}
	}
	
	public function addNew(){
		global $DB, $tpl, $lang,$dklang,$pid;
		$tpl->newBlock("addNew");	
		
		$tpl->assign("parentid",$this->listCategory($pid));
	}
	
	private function listCategory($selectedID=0,$idelement='')
	{
		global $tree;
		$info['parentid'] .= '<select name="parentid" id="'.$idelement.'" style="WIDTH: 220px" >';
		$info['parentid'] .= '<option value="0">Root</option>';
		if($tree)
		foreach($tree as $k => $v)
			foreach($v as $i => $j){
				if ($k == $selectedID)
					$selectstr=" selected ";
				$dtype = Category::idCatToDataType($k);
				if($dtype == $this->data_type)
					$info['parentid'] .= '<option value="' . $k . '"'.$selectstr.'>' . $j . '</option>';
				else
					$info['parentid'] .= '<option value="' . $k . '"'.$selectstr.' disabled>' . $j . '</option>';
			}
		$info['parentid'] .= '</select>';
		return $info['parentid'];
		
	}
}

?>