<?php

// Nguyen Binh
// suongmumc@gmail.com

defined('_VALID_NVB') or die('Direct Access to this location is not allowed.');
$tpl = new TemplatePower("skin/category.tpl");
$tpl->prepare();
$id = intval($_GET['id']);
$idc = intval($_GET['idc']);
$pid = intval($_GET['pid']);


include_once ('./dataprovider/db_sys_image.php');
$objSysImage = new dbSysImage();


$module = new Cat;
$module->_int();

$tpl->printToScreen();

class Cat extends cat_tree {

    private $page = "Chuyên mục";
    private $item = "chuyên mục";
    private $table = "category";
    private $id_item = "id_category";
    private $par_page = "category";
    private $numberPageShow = 8;
    private $numberItemPage = 30;
    private $thumbwidth = 80;

//	private $data_type='news';

    public function _int() {
        global $tpl, $id, $pid;
        $this->get_cat_tree(0);
        $pathpage = '<li><a href="?page=' . $this->par_page . '">' . $this->page . '</a> <span class="divider">></span></li>' . $this->get_cat_string_admin($pid, $this->par_page);
        $tpl->assignGlobal('pathpage', $pathpage);

        $tpl->assignGlobal("item", $this->item);
        $tpl->assignGlobal("table", $this->table);
        $tpl->assignGlobal("id_item", $this->id_item);
        $tpl->assignGlobal("par_page", $this->par_page);


        $code = $_GET['code'];
        switch ($code) {
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
        }
        $this->showList();
    }

    private function showAddNew() {
        global $DB, $tpl, $lang, $dklang, $tree, $pid, $CONFIG;
        $pid = intval($pid);
        $tpl->newBlock("AddNew");
        $tpl->assign("action", '?page=' . $this->par_page . '&code=save');
        // list category
        $info['parentid1'] = $pid;
        $info['parentid'] .= '<select name="parentid" style="WIDTH: 300px" >';
        $info['parentid'] .= '<option value="0">Root</option>';

        $info['parentid'] .= '</select>';
        $tpl->assign("parentid", $info['parentid']);

        $tpl->assign("content", ClEditor::EditorBase("content", '&nbsp;'));
        $tpl->assign("active", "checked");
        $tpl->assign("autourl", "checked");
        $tpl->assign("colfooter1", "checked");
        $tpl->assign("logotitleleft0", "checked");
        $tpl->assign("thu_tu", Order::getOrderCat($this->table));
        $tpl->assign("vtcolsub3", "checked");
        $this->getGroupAttr();
    }

    private function showUpdate() {
        global $DB, $tpl, $lang, $dklang, $id, $dir_image, $tree, $pid;
        $tpl->newBlock("AddNew");
        if ($_GET['p'] > 1) {
            $pa = '&p=' . $_GET['p'];
        }
        $tpl->assign("action", '?page=' . $this->par_page . '&code=update&id=' . $id . '&pid=' . $pid);
        $sql = "SELECT * FROM " . $this->table . " WHERE " . $this->id_item . " = " . $id;
        $db = $DB->query($sql);
        if ($rs = mysql_fetch_array($db)) {

            // list category
            $info['parentid1'] = $pid;
            $info['parentid'] .= '<select name="parentid" style="WIDTH: 300px" >';
            $info['parentid'] .= '<option value="0">Root</option>';
            if ($tree)
                foreach ($tree as $k => $v) {
                    foreach ($v as $i => $j) {
                        $selectstr = '';
                        $disabled = '';
                        if ($info['parentid1'] == $k)
                            $selectstr = " selected ";
                        if ($rs[$this->id_item] == $k)
                            $disabled = ' disabled ';
                        $info['parentid'] .= '<option  value="' . $k . '"' . $selectstr . $disabled . '>' . $j . '</option>';
                    }
                }
            $info['parentid'] .= '</select>';
            $tpl->assign("parentid", $info['parentid']);

            $tpl->assign("name", $rs['name']);
            $tpl->assign("title", $rs['title']);
            $tpl->assign("template_name", $rs['template_name']);
            $tpl->assign("home_layout", $rs['home_layout']);
            $tpl->assign("description", $rs['description']);
            $tpl->assign("keywords", $rs['keywords']);
			 
            $tpl->assign("thu_tu", $rs['thu_tu']);
            $tpl->assign($rs['data_type'], "checked");
            $tpl->assign("content", ClEditor::EditorBase("content", $rs['content']));
            $tpl->assign("url", $rs['url']);
            $link_delete_image = "index4.php?page=action_ajax&code=delete&id=" . $rs[$this->id_item] . "&table=" . $this->table . "&id_item=" . $this->id_item;
            if ($rs['image']) {
                $tpl->assign("image", '<img src="image.php?w=150&src=' . $rs['image'] . '" class="img-polaroid marginright5" align="left" id="avatar" /><br /><a href="' . $link_delete_image . '" id="trash_image" class="icon-trash" title="Xóa ảnh"></a>');
            }
			
			$tpl->assign("menucolor", $rs['menucolor']);
			$tpl->assign($rs['menucolor'],'۷');
			
            $tpl->assign("imageurl", $rs['image']);
            if ($rs['active'] == 1)
                $tpl->assign("active", "checked");
            $tpl->assign("stypeshow" . $rs['stypeshow'], "checked");
            $tpl->assign("footercol" . $rs['footercol'], "checked");
          	$tpl->assign($rs['iconmenu'], "checked");
            if ($rs['shortinhome'] == 1)
                $tpl->assign("shortinhome", "checked");
            $vitri = explode(":", $rs['vitri']);
            foreach ($vitri as $vt) {
                if ($vt == 'logo') {
                    $tpl->assign('logo1', "checked");
                } else {
                    $tpl->assign($vt, "checked");
                }
            }
            $this->getGroupAttr($rs['id_attr']);
            
            $this->show_multi_image($id);
            
        }
    }

    private function showList() {
        global $DB, $tpl, $lang, $dklang, $pid, $site_address, $dir_path, $dir_image, $tree;
        $tpl->newBlock("showList");
        if (intval($_GET['p']) < 1)
            $p = 1;
        else
            $p = intval($_GET['p']);
        $tpl->assign("pid", $pid);
        $tpl->assign("par_page", $this->par_page);
        $tpl->assign("action", "?page=" . $this->par_page . "&code=ordering&pid=" . $pid . "&p=" . $p);
        $this->showListCate(0, '');
        $tpl->assign("showList.pages", $db['pages']);
    }

    private function showListCate($pid, $n) {
        global $DB, $tpl, $lang, $language;
        $tpl->newBlock("showListCate");
        $dataType = new url_process;

        $strWhere = "";
        if ($_GET['pos']) {
            $strWhere .= " AND vitri LIKE '%$_GET[pos]%'";
            $tpl->assignGlobal('pos', "$_GET[pos] <a href='?page=category'>(Bỏ lọc)</a>");
        }

        if ($_GET['dtype']) {
            $strWhere .= " AND data_type LIKE '%$_GET[dtype]%'";
            $dt1 = $dataType->type_Info($_GET['dtype']);

            $tpl->assignGlobal('dtype', "$dt1[titlemenu] <a href='?page=category'>(Bỏ lọc)</a>");
        }





        $sql = "SELECT * FROM " . $this->table . " WHERE parentid = $pid $language $strWhere ORDER BY thu_tu ASC,name ASC";

        $db = $DB->query($sql);
        $str = $n;
        $n = $n . "-- ";
        while ($rs = mysql_fetch_array($db)) {
            $tpl->newBlock("listCate");
            $dt = $dataType->type_Info($rs['data_type']);
            $tpl->assign(array(
                name => $str . $rs['name'],
                thu_tu => $rs['thu_tu'],
                id => $rs[$this->id_item],
                datatype => $dt['titlemenu'],
            ));
            $tpl->assign("link", "?page=" . $dt['adminpage'] . "&pid=" . $rs[$this->id_item]);
            if ($rs['active'] == 1)
                $tpl->assign("active", "checked");
            $tpl->assign("link_edit", '?page=' . $this->par_page . '&code=showUpdate&id=' . $rs[$this->id_item] . '&pid=' . $rs['parentid']);
            $tpl->assign("link_delete", '?page=action_ajax&code=deleteitem&id=' . $rs[$this->id_item] . '&table=' . $this->table . '&id_item=' . $this->id_item);


            $tpl->assign("datatype", "<a href='?page=category&dtype=$rs[data_type]'>$dt[titlemenu]</a>");

            $vitri_str = "";
            $vitri = explode(":", $rs['vitri']);
            foreach ($vitri as $vt)
                $vitri_str .= "<a href='?page=category&pos=$vt'>$vt</a> ";

            $tpl->assign("vitri", $vitri_str);

            $this->showListCate($rs[$this->id_item], $n);
        }
    }

    private function ordering() {
        global $DB, $tpl, $lang, $dklang;
        $thu_tu = $_POST['thu_tu'];
        if ($thu_tu) {
            foreach ($thu_tu as $tt => $val) {
                $DB->query("UPDATE " . $this->table . " SET thu_tu=" . $val . " WHERE " . $this->id_item . "=" . $tt);
            }
            Message::showMessage("success", "Cập nhật thứ tự thành công !");
        }
    }

    private function save() {
        global $DB, $tpl, $lang, $dklang,$clsUrl;
        $data = $this->getData();
        if ($data) {
            $b = $DB->compile_db_insert_string($data);
            $sql = "INSERT INTO " . $this->table . " (" . $b['FIELD_NAMES'] . ") VALUES (" . $b['FIELD_VALUES'] . ")";
            $DB->query($sql);
            $lastid = mysql_insert_id();
			$type_info = $clsUrl->typeInfo($data['data_type']);
			$clsUrl->delete($type_info['tableitem'],$lastid,0);
			$clsUrl->insert($data['url'],$type_info['tableitem'],$lastid,$lastid,$data['data_type']);
            Message::showMessage("success", "Thêm mới thành công !");
            $this->insert_multi_image($lastid);
        }
    }

    private function update($id) {
        global $DB, $tpl, $lang, $dklang,$clsUrl;
        $id = intval($id);
        $data = $this->getData();
        if ($data['parentid'] == $id) {
            Message::showMessage("error", "Bạn không thể tạo \"" . $data['name'] . "\" thuộc nhóm cha chính là \"" . $data['name'] . "\"  !");
        } else {
            if ($data) {
                $table_old = $this->getDataType($id);
                $b = $DB->compile_db_update_string($data);
                $sql = "UPDATE " . $this->table . " SET " . $b . " WHERE " . $this->id_item . "=" . $id;
                $db = $DB->query($sql);
				
				$type_info = $clsUrl->typeInfo($data['data_type']);
				$clsUrl->delete($table_old ,$id,0,$table_old);
				$clsUrl->insert($data['url'],$type_info['tableitem'],$id,0,$data['data_type']);
               
				
                Message::showMessage("success", "Sửa chữa thành công !");
                $this->insert_multi_image($id);
            }
        }
    }
	
	private function getDataType($id){
		global $DB,$clsUrl;
		$id = intval($id);
		$sql = "SELECT * FROM category WHERE id_category = $id"	;
		$db = $DB->query($sql);
		if($rs = mysql_fetch_array($db)){
			$data = array();
			$data = $clsUrl->typeInfo($rs['data_type']);
			return $data['tableitem'];
		}
	}
    function insert_multi_image($id_category){
        global $DB, $objSysImage;
        $objSysImage->deleteMulti($id_category);
        
        $collection_image = $_POST['collection_image'];
        $image_name = $_POST['image_name'];
        $image_thu_tu = $_POST['image_thu_tu'];
        $a = array();
        foreach($collection_image as $k=>$v){
            $a['name'] = $image_name[$k];
            $a['thu_tu'] = $image_thu_tu[$k];
            $a['id_category'] = $id_category;
            $a['image'] = $v;
            $objSysImage->insertImage($a);
        }
    }        

    function show_multi_image($id_category){
        global $DB,$tpl,$dir_path,$cache_image_path,$objSysImage;
        
        $db =  $objSysImage->getList($id_category);
        foreach ($db as $rs){
            $tpl->newBlock("collection_cell");
            $tpl->assign(array(
                big_image => $dir_path.'/'.trim_url_image($rs['image']),
                image => $cache_image_path.resizeimage(192,130,$dir_path.'/'.$rs['image']),
                real_image => trim_url_image($rs['image']),
                thu_tu => $rs['thu_tu'],
                name => $rs['name'],
                id => $rs['id']
            ));
        }
    }    
    
    private function getData($update = 0, $id = 0) {
        global $my, $_FILES, $lang_dir, $dir_path, $lang,$clsUrl,$url_extension_category;
        $id = intval($id);
        $data = array();
        $data['name'] = compile_post('name');

        if (compile_post('title')) {
            $data['title'] = compile_post('title');
        } else {
            $data['title'] = compile_post('name');
        }
        $data['parentid'] = compile_post('parentid');
        $data['template_name'] = compile_post('template_name');
        $data['home_layout'] = compile_post('home_layout');

        $data['data_type'] = compile_post('data_type');
        $data['content'] = $_POST['content'];
        $data['description'] = compile_post('description');
        $data['keywords'] = compile_post('keywords');
        $data['active'] = intval(compile_post('active'));
        $data['thu_tu'] = intval(compile_post('thu_tu'));
        $data['id_attr'] = intval(compile_post('id_attr'));

        $data['footercol'] = intval(compile_post('footercol'));
        $data['logotitleleft'] = intval(compile_post('logotitleleft'));
        $data['homescroll'] = intval(compile_post('homescroll'));
        $data['shortinhome'] = intval(compile_post('shortinhome'));
        $data['col'] = intval(compile_post('col'));
        $data['localnews'] = intval(compile_post('localnews'));
        $data['vtcolsub'] = intval(compile_post('vtcolsub'));
		$data['iconmenu'] = compile_post('iconmenu');
		$data['menucolor'] = compile_post('menucolor');
		
        $data['lang'] = $lang;
        if (compile_post('autourl') == 1) {
            if ($data['data_type'] == 'home') {
                $url = $lang_dir;
            } else {
                $url = $lang_dir.$clsUrl->builUrl(compile_post('name'),$url_extension_category);
            }
        } else {
            if ($data['data_type'] == 'home') {
                $url = $lang_dir;
            } else {
                if (substr(compile_post('url'), 0, strlen($lang_dir)) == $lang_dir) {
                    $url = $lang_dir . substr(compile_post('url'), strlen($lang_dir), strlen(compile_post('url')));
					$url = $clsUrl->builUrl($url,'',0);
                }
            }
        }
        $data['url'] = $url;
		

        $vitri = $_POST['vitri'];
        $vt = ":";
        if ($vitri) {
            foreach ($vitri as $v) {
                $vt.=$v . ":";
            }
        }
        $data['vitri'] = $vt;
        if ($_FILES['image']['size']) {
            $image = Image::uploadImage('image', 'no');
            $data['image'] = $dir_path . "/" . $image['image'];
        } else {
            $data['image'] = compile_post('imageurl');
        }
        return $data;
    }
	private function urlProcess(){
			
	}
    private function getGroupAttr($idc) {
        global $DB, $tpl;
        $sql = "SELECT * FROM group_attr ORDER BY name ASC";
        $db = $DB->query($sql);
        while ($rs = mysql_fetch_array($db)) {
            $tpl->newBlock("list_attr");
            if ($rs['setdefault'] == 1 && $idc <= 0) {
                $tpl->assign("checked", "checked='checked'");
            } elseif ($rs['id_group'] == $idc) {
                $tpl->assign("checked", "checked='checked'");
            }
            $tpl->assign("attrname", $rs['name']);
            $tpl->assign("id_attr", $rs['id_group']);
        }
    }

}

?>