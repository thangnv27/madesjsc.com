<?php 

// Nguyen Binh

// suongmumc@gmail.com



defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );

$tpl=new TemplatePower("skin/video.tpl");

$tpl->prepare();

	$id=intval($_GET['id']);

	$idc=intval($_GET['idc']);

	$pid=intval($_GET['pid']);



	$module = new Info;

	$module->_int();







$tpl->printToScreen();



class Info extends cat_tree{

	private $page = "Trang video";

	private $item = "video";

	private $table = "video";

	private $id_item = "id_video";

	private $par_page = "video";

	private $numberPageShow = 8;

	private $numberItemPage = 30;

	private $thumbwidth = 80;

	private $data_type='video';

	

	public function _int(){

		global $tpl,$id,$pid,$imagedir, $dir_path;

		$this->get_cat_tree(0,'');	

		$pathpage = '<li><a href="?page='.$this->par_page.'">'.$this->page.'</a> <span class="divider">></span></li>'. $this->get_cat_string_admin($pid,$this->par_page);

		$tpl->assignGlobal('pathpage',$pathpage);

		$tpl->assignGlobal("item",$this->item);

		$tpl->assignGlobal("table",$this->table);

		$tpl->assignGlobal("id_item",$this->id_item);

		$tpl->assignGlobal("par_page",$this->par_page);

		$tpl->assignGlobal("pid",$pid);

		$tpl->assignGlobal("dir_path",$dir_path);

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

			$info['parentid'] .= '<select name="parentid" style="WIDTH: 300px" >';

			$info['parentid'] .= '<option value="0">Root</option>';

			if($tree)

			foreach($tree as $k => $v) {

				foreach($v as $i => $j) {

					$selectstr='';

					if ($info['parentid1']==$k)

						$selectstr=" selected ";

					

					$dtype = Category::idCatToDataType($k);

					if($dtype == $this->data_type)

						$info['parentid'] .= '<option value="' . $k . '"'.$selectstr.'>' . $j . '</option>';

					else

						$info['parentid'] .= '<option value="' . $k . '"'.$selectstr.' disabled>' . $j . '</option>';

	

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

					

					$dtype = Category::idCatToDataType($k);

					if($dtype == $this->data_type)

						$info1['parentid'] .= '<option value="' . $k . '">' . $j . '</option>';

				}

			}

			$tpl->assign("parentid1"	,$info1['parentid']);

			

			$tpl->assign("content"		,ClEditor::Editor("content",'&nbsp;'));

			$tpl->assign("active"		,"checked");

			$tpl->assign("autourl"		,"checked");

			$tpl->assign("ngay_dang",date('d/m/Y H:i',time() + $CONFIG['time_offset']));

			$tpl->assign("thu_tu",Order::getOrderCat($this->table));

	}	

	

	private function showUpdate(){

		global $DB,$tpl,$lang,$dklang,$id,$dir_image,$tree,$pid,$cache_image_path, $dir_path;

		$tpl->newBlock("AddNew");

		if($_GET['p']>1){

			$pa = '&p='.$_GET['p'];	

		}

		$tpl->assign("action",'?page='.$this->par_page.'&code=update&id='.$id.'&pid='.$pid.$pa);

		$sql = "SELECT * FROM ".$this->table." WHERE ".$this->id_item." = ".$id;

		$db = $DB->query($sql);

		if($rs = mysql_fetch_array($db)){

			

			// list category

			$info['parentid1']=$pid;

			$info['parentid'] .= '<select name="parentid" style="WIDTH: 300px" >';

			$info['parentid'] .= '<option value="0">Root</option>';

			if($tree)

			foreach($tree as $k => $v) {

				foreach($v as $i => $j) {

					$selectstr='';

					if ($info['parentid1']==$k)

						$selectstr=" selected ";

					

					$dtype = Category::idCatToDataType($k);

					if($dtype == $this->data_type)

						$info['parentid'] .= '<option value="' . $k . '"'.$selectstr.'>' . $j . '</option>';

					else

						$info['parentid'] .= '<option value="' . $k . '"'.$selectstr.' disabled>' . $j . '</option>';

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

					if(in_array($k,$gr)){

						$selectstr1='selected="selected"';

					}else{

						$selectstr1='';

					}

					//$info1['parentid'] .= '<option value="' . $k . '"'.$selectstr1.'>' . $j . '</option>';

					$dtype = Category::idCatToDataType($k);

					if($dtype == $this->data_type)

						$info1['parentid'] .= '<option value="' . $k . '"'.$selectstr1.'>' . $j . '</option>';

					

				}

			}

			$tpl->assign("parentid1"	,$info1['parentid']);

			$tpl->assign("name"			,$rs['name']);

			$tpl->assign("title"		,$rs['title']);

			$tpl->assign("description"	,$rs['description']);

			$tpl->assign("keywords"		,$rs['keywords']);

			$tpl->assign("thu_tu"		,$rs['thu_tu']);

			$tpl->assign("videourl"		,$rs['video']);

			$tpl->assign("content"		,ClEditor::Editor("content",$rs['content']));

			$tpl->assign("url"			,$rs['url']);

			$tpl->assign("ngay_dang" 	,date('d/m/Y H:i',$rs['ngay_dang']));
			if($rs['showinfooter'] == 1) $tpl->assign("showinfooter","checked");

			$link_delete_image = "index4.php?page=actionajax&code=delete&id=".$rs[$this->id_item]."&table=".$this->table."&id_item=".$this->id_item;

			$parse = parse_url($rs['video']);

			if($parse['host'] == 'youtube.com' || $parse['host'] == 'www.youtube.com'){

				if($rs['image']){

					$tpl->assign("image",'<img src="'.$cache_image_path.resizeimage(120,'200',$dir_path.'/'.$rs['image']).'"  />');

				}else{

					$tpl->assign("image",'<img src="http://img.youtube.com/vi/'.getVideoCode($rs['video']).'/1.jpg" width="120" align="left" style="margin-right:5px" />');	

				}

			}else{

				$tpl->assign("image",'<img src="'.$cache_image_path.resizeimage(120,'200',$dir_path.'/'.$rs['image']).'" width="120" align="left" style="margin-right:5px" />');	

				$tpl->assign("imageurl",$rs['image']);

			}

			if($rs['active']==1) $tpl->assign("active","checked");

		}

	}

	

	private function showList(){

		global $DB,$tpl,$lang,$dklang,$pid,$site_address,$dir_path,$dir_image,$tree,$cache_image_path;

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

				

				$dtype = Category::idCatToDataType($k);

				if($dtype == $this->data_type)

					$info['parentid'] .= '<option value="' . $k . '"'.$selectstr.'>' . $j . '</option>';

				else

					$info['parentid'] .= '<option value="' . $k . '"'.$selectstr.' disabled>' . $j . '</option>';

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

				user_name => $rs['user_name'],

				createdate => @date('d/m/Y | H:i',$rs['ngay_dang']),

				url => $site_address.$dir_path."/".url_process::getUrlCategory($rs['id_category']).$rs['url'],

				groupcat => $this->getGroupCatName($rs['groupcat'])

			));

			$tpl->assign("categoryname",Category::categoryName($rs['id_category']));

			$tpl->assign("linkcat","?page=".$this->par_page."&pid=".$rs['id_category']);

			$parse = parse_url($rs['video']);



			if($parse['host'] == 'youtube.com' || $parse['host'] == 'www.youtube.com'){

				if($rs['image']){

					$tpl->assign("image",'<img src="'.$cache_image_path.resizeimage(120,'200',$dir_path.'/'.$rs['image']).'"  align="left"  />');

				}else{

					$tpl->assign("image",'<img src="http://img.youtube.com/vi/'.getVideoCode($rs['video']).'/1.jpg" width="120" align="left" style="margin-right:5px" />');	

				}

			}else{

				$tpl->assign("image",'<img src="'.$cache_image_path.resizeimage(120,'200',$dir_path.'/'.$rs['image']).'" width="120" align="left" style="margin-right:5px" />');	

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

	

	function getData($update=0,$id=0){

		global  $my,$_FILES;

		$id = intval($id);

		$data = array();

		$data['name']		= compile_post('name');

		if(compile_post('title')){

			$data['title']	= compile_post('title');	

		}else{

			$data['title']	= compile_post('name');	

		}

		$data['id_category']= compile_post('parentid');

		$groupcat 			= $_POST['groupcat'];

		$data['video']    	= compile_post('videourl');	

		$data['content'] 	= $_POST['content'];

		$data['description']= compile_post('description');	

		$data['keywords']	= compile_post('keywords');	

		$data['active']		= intval(compile_post('active'));	

		$data['thu_tu'] 	= intval(compile_post('thu_tu'));
		$data['showinfooter'] 	= intval(compile_post('showinfooter'));

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

		$data['id_user'] = $my['id'];	

		$data['image']  = compile_post('imageurl');

		return $data;

	}

}









?>