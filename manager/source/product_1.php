<?php

// Nguyen Binh
// suongmumc@gmail.com

defined('_VALID_NVB') or die('Direct Access to this location is not allowed.');
$tpl = new TemplatePower("skin/product.tpl");
$tpl->prepare();
$id = intval($_GET['id']);
$idc = intval($_GET['idc']);
$pid = intval($_GET['pid']);

include_once ('./dataprovider/db_sys_image.php');
$objSysImage = new dbSysImage();


$module = new News;
$module->_int();

$tpl->printToScreen();

class News extends cat_tree {

    private $page = "Sản phẩm";
    private $item = "sản phẩm";
    private $table = "product";
    private $id_item = "id_product";
    private $par_page = "product";
    private $numberPageShow = 8;
    private $numberItemPage = 30;
    private $thumbwidth = 80;
    private $data_type = 'product';

    public function _int() {
        global $tpl, $id, $pid, $imagedir;
        $this->get_cat_tree(0, $this->data_type);
        $pathpage = '<li><a href="?page=' . $this->par_page . '">' . $this->page . '</a> <span class="divider">></span></li>' . $this->get_cat_string_admin($pid, $this->par_page);
        $tpl->assignGlobal('pathpage', $pathpage);
        $tpl->assignGlobal("item", $this->item);
        $tpl->assignGlobal("table", $this->table);
        $tpl->assignGlobal("id_item", $this->id_item);
        $tpl->assignGlobal("par_page", $this->par_page);
        $tpl->assignGlobal("pid", $pid);
        $tpl->assignGlobal("imagedir", $imagedir);

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
            case "deletemulti":
                $this->deleteMultiItem();
                break;
        }
        $this->showList();
    }

    private function showAddNew() {
        global $DB, $tpl, $lang, $dklang, $tree, $pid, $CONFIG;
        $pid = intval($pid);
        $tpl->newBlock("AddNew");
        $tpl->assign("action", '?page=' . $this->par_page . '&code=save&pid=' . $pid);
        // list category
        $info['parentid1'] = $pid;
        $info['parentid'] .= '<select name="parentid" style="WIDTH: 300px" id="idc" >';
        $info['parentid'] .= '<option value="0">Root</option>';
        if ($tree)
            foreach ($tree as $k => $v) {
                foreach ($v as $i => $j) {
                    $selectstr = '';
                    if ($info['parentid1'] == $k)
                        $selectstr = " selected ";
                    $info['parentid'] .= '<option value="' . $k . '"' . $selectstr . '>' . $j . '</option>';
                }
            }
        $info['parentid'] .= '</select>';
        $tpl->assign("parentid", $info['parentid']);

        // in group	
        $str = $rs['groupcat'];
        $gr = explode(':', $str);
        $info1['parentid'] .= '<option value="0">None</option>';
        if ($tree)
            foreach ($tree as $k => $v) {
                foreach ($v as $i => $j) {
                    $info1['parentid'] .= '<option value="' . $k . '">' . $j . '</option>';
                }
            }
        $tpl->assign("parentid1", $info1['parentid']);

            $tpl->assign("intro", ClEditor::EditorBase("intro", '&nbsp;'));
			$tpl->assign("content", ClEditor::Editor("content", '&nbsp;'));
			$tpl->assign("tabcontent0", ClEditor::Editor("tabcontent0", '&nbsp;'));
			
        $tpl->assign("lstSize",$this->lstSize());
        
        $tpl->assign("active", "checked");
        $tpl->assign("autourl", "checked");
        $tpl->assign("ngay_dang", date('d/m/Y H:i', time() + $CONFIG['time_offset']));
        $tpl->assign("thu_tu", Order::getOrderCat($this->table));
    }

    private function showUpdate() {
        global $DB, $tpl, $lang, $dklang, $id, $imagedir, $tree, $pid, $cache_image_path,$dir_path;
        $tpl->newBlock("AddNew");
        if ($_GET['p'] > 1) {
            $pa = '&p=' . $_GET['p'];
        }
        $tpl->assignGlobal("id", $id);
        $tpl->assign("action", '?page=' . $this->par_page . '&code=update&id=' . $id . '&pid=' . $pid . $pa);
        $sql = "SELECT * FROM " . $this->table . " WHERE " . $this->id_item . " = " . $id;
        $db = $DB->query($sql);
        if ($rs = mysql_fetch_array($db)) {

            // list category
            $info['parentid1'] = $pid;
            $info['parentid'] .= '<select name="parentid" style="WIDTH: 300px"  id="idc" >';
            $info['parentid'] .= '<option value="0">Root</option>';
            if ($tree)
                foreach ($tree as $k => $v) {
                    foreach ($v as $i => $j) {
                        $selectstr = '';
                        if ($info['parentid1'] == $k)
                            $selectstr = " selected ";
                        $info['parentid'] .= '<option value="' . $k . '"' . $selectstr . '>' . $j . '</option>';
                    }
                }
            $info['parentid'] .= '</select>';
            $tpl->assign("parentid", $info['parentid']);

            // in group	
            $str = $rs['groupcat'];
            $gr = explode(':', $str);
            $info1['parentid'] .= '<option value="0">None</option>';
            if ($tree)
                foreach ($tree as $k => $v) {
                    foreach ($v as $i => $j) {
                        if (in_array($k, $gr)) {
                            $selectstr1 = 'selected="selected"';
                        } else {
                            $selectstr1 = '';
                        }
                        $info1['parentid'] .= '<option value="' . $k . '"' . $selectstr1 . '>' . $j . '</option>';
                    }
                }
            $tpl->assign("parentid1", $info1['parentid']);
            $tpl->assign("name", $rs['name']);
            $tpl->assign("ma", $rs['ma']);
            $tpl->assign("title", $rs['title']);
            $tpl->assign("description", $rs['description']);
            $tpl->assign("keywords", $rs['keywords']);
            $tpl->assign("thu_tu", $rs['thu_tu']);
            $tpl->assign("ttkhuyenmai",  $rs['ttkhuyenmai']); 
			$tpl->assign("spcungloai",  $rs['spcungloai']); 
			$tpl->assign("spcungloainame",  $rs['spcungloainame']); 
            $tpl->assign("intro", ClEditor::EditorBase("intro", $rs['intro']));
			$tpl->assign("content", ClEditor::Editor("content", $rs['content']));
			$tpl->assign("tabname0",  $rs['tabname0']); 
			$tpl->assign("contenttab0", ClEditor::Editor("contenttab0", $rs['contenttab0']));
			

            $tpl->assign("url", $rs['url']);
            
            $tpl->assign("price", $rs['price']);
			$tpl->assign("pricekm", $rs['pricekm']);
           	
            $tpl->assign("km", $rs['km']);
            $tpl->assign("star_rate".$rs['star_rate'],"selected" );
            
            $tpl->assign("videourl", $rs['videourl']);
            $tpl->assign("imageurl360", $rs['folder360']);
            
            if ($rs['status'] == 1)
	            $tpl->assign("status", "checked");
            $tpl->assign($rs['icon'], "checked");
			$tpl->assign("texticon", $rs['texticon']);
            $tpl->assign("ngay_dang", date('d/m/Y H:i', $rs['ngay_dang']));
            $link_delete_image = "index4.php?page=action_ajax&code=delete&id=" . $rs[$this->id_item] . "&table=" . $this->table . "&id_item=" . $this->id_item;
            if ($rs['image']) {
                $tpl->assign("image", '<img src="'.$cache_image_path.resizeimage(150,200,$dir_path.'/'.$rs['image']).'" class="img-polaroid marginright5" align="left" id="avatar" /><br /><a href="' . $link_delete_image . '" id="trash_image" class="icon-trash" title="Xóa ảnh"></a>');
            }
            $tpl->assign("imageurl", $rs['image']);
            if ($rs['active'] == 1)
                $tpl->assign("active", "checked");

            $this->show_multi_image($id);
            
            
        }
    }

    private function showList() {
        global $DB, $tpl, $lang, $dklang, $pid, $site_address, $dir_path, $imagedir, $tree,$cache_image_path,$clsUrl;
        $tpl->newBlock("showList");
        if (intval($_GET['p']) < 1)
            $p = 1;
        else
            $p = intval($_GET['p']);
        $tpl->assign("pid", $pid);
        $tpl->assign("par_page", $this->par_page);
        $tpl->assign("action", "?page=" . $this->par_page . "&code=ordering&pid=" . $pid . "&p=" . $p);
        // list category
        $info['parentid1'] = $pid;
        $info['parentid'] .= '<select name="parentid" style="WIDTH: 300px" id="parentid" >';
        $info['parentid'] .= '<option value="0">Category</option>';
        if ($tree)
            foreach ($tree as $k => $v) {
                foreach ($v as $i => $j) {
                    $selectstr = '';
                    if ($info['parentid1'] == $k)
                        $selectstr = " selected ";
                    $info['parentid'] .= '<option value="' . $k . '"' . $selectstr . '>' . $j . '</option>';
                }
            }
        $info['parentid'] .= '</select>';
        $tpl->assign("parentid", $info['parentid']);


        if ($pid == 0 && $dk == '') {
            $dk = " 1 = 1 ";
        } else {
            $dk = "(" . $this->table . ".id_category=" . $pid . " OR " . $this->table . ".groupcat LIKE '%:" . $pid . ":%')";
        }

        if ($_REQUEST['keyword']) {
            $keyword = clean_value($_REQUEST['keyword']);
            $dk.=" AND " . $this->table . ".name LIKE '%" . $keyword . "%' ";
            $kw = "&keyword=" . $keyword;
        }

        $sql = "SELECT " . $this->table . ".*,users.name as user_name, users.username as username FROM " . $this->table . " LEFT JOIN users ON(" . $this->table . ".id_user=users.id_users) WHERE  $dk ORDER BY " . $this->table . ".thu_tu DESC, " . $this->id_item . " DESC";
        $db = paging::pagingAdmin($p, "?page=" . $this->par_page . $kw, $sql, $this->numberPageShow, $this->numberItemPage);
        while ($rs = mysql_fetch_array($db['db'])) {
            $tpl->newBlock("list");
            $tpl->assign(array(
                name => $rs['name'],
				km 	=> $rs['km'],
                thu_tu => $rs['thu_tu'],
                id => $rs[$this->id_item],
                username => $rs['username'],
                user_name => $rs['user_name'],
                createdate => @date('d/m/Y | H:i', $rs['ngay_dang']),
                //url => $site_address  .$clsUrl->getUrl('product',$rs['id_category'],$rs[$this->id_item]),
				url => $site_address.$dir_path."/".url_process::getUrlCategory($rs['id_category']).$rs['url'],
                groupcat => $this->getGroupCatName($rs['groupcat'])
            ));
            $tpl->assign("categoryname", Category::categoryName($rs['id_category']));
            $tpl->assign("linkcat", "?page=" . $this->par_page . "&pid=" . $rs['id_category']);
            if ($rs['image']) {
                $tpl->assign("image", '<img src="'.$cache_image_path.  resizeimage(100, 120, $dir_path . '/' . $rs['image']) . '"  class="thumblistnews" />');
            }
            if ($rs['active'] == 1)
                $tpl->assign("active", "checked");
            $tpl->assign("link_edit", '?page=' . $this->par_page . '&code=showUpdate&pid=' . $rs['id_category'] . '&id=' . $rs[$this->id_item]);
            $tpl->assign("link_delete", '?page=action_ajax&code=deleteitem&id=' . $rs[$this->id_item] . '&table=' . $this->table . '&id_item=' . $this->id_item);
        }
        $tpl->assign("showList.pages", $db['pages']);
    }

    private function showListCate() {
        global $DB, $tpl, $lang, $dklang, $pid;
        $tpl->newBlock("showListCate");
        $sql = "SELECT * FROM category WHERE parentid = $pid $dklang ORDER BY thu_tu ASC, name ASC";
        $db = $DB->query($sql);
        while ($rs = mysql_fetch_array($db)) {
            $tpl->newBlock("listCate");
            $tpl->assign(array(
                name => $rs['name'],
                thu_tu => $rs['thu_tu']
            ));
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
            $this->insert_multi_image($lastid);
            $id= mysql_insert_id();
			$clsUrl->delete($this->table,$data['id_category'],$id);
			$clsUrl->insert($data['url'],$this->table,$data['id_category'],$id,$this->data_type);
            Message::showMessage("success", "Thêm mới thành công !");
        }
    }

    private function update($id) {
        global $DB, $tpl, $lang, $dklang,$clsUrl;
        $id = intval($id);
        $data = $this->getData();
        if ($data) {
            $b = $DB->compile_db_update_string($data);
            $sql = "UPDATE " . $this->table . " SET " . $b . " WHERE " . $this->id_item . "=" . $id;
            $db = $DB->query($sql);

            $clsUrl->delete($this->table,$data['id_category'],$id);
			$clsUrl->insert($data['url'],$this->table,$data['id_category'],$id,$this->data_type);
			$this->insert_multi_image($id);
            Message::showMessage("success", "Sửa chữa thành công !");
        }
    }

    private function getGroupCatName($groupcat) {
        global $DB;
        $i = 0;
        $str = '';
        if ($groupcat)
            $gr = explode(":", $groupcat);
        if ($gr)
            foreach ($gr as $idgroup) {
                if ($idgroup) {
                    $sql = "SELECT * FROM category WHERE id_category=$idgroup";
                    $db = $DB->query($sql);
                    if ($rs = mysql_fetch_array($db)) {
                        $i++;
                        if ($i == 1) {
                            $str.=$rs['name'];
                        } else {
                            $str.=", " . $rs['name'];
                        }
                    }
                }
            }
        return $str;
    }

    private function deleteMultiItem() {
        global $DB;
        $multi = $_POST['delmulti'];
        if ($multi) {
            foreach ($multi as $mtId) {
                $sql = "SELECT * FROM " . $this->table . " WHERE " . $this->id_item . "=" . $mtId;
                $db = $DB->query($sql);
                if ($rs = mysql_fetch_array($db)) {
                    deleteimage($rs['image']);
                }
                $DB->query("DELETE FROM " . $this->table . " WHERE " . $this->id_item . "=" . $mtId);
                Message::showMessage("success", "Đã xóa xong !");
            }
        }
    }

    private function getData($update = 0, $id = 0) {
        global $my, $_FILES, $imagedir,$clsUrl,$url_extension_article;
        $id = intval($id);
        $data = array();
        $data['name'] = compile_post('name');
        $data['ma'] = compile_post('ma');

        if (compile_post('title')) {
            $data['title'] = compile_post('title');
        } else {
            $data['title'] = compile_post('name');
        }
        $data['id_category'] = compile_post('parentid');
        $groupcat = $_POST['groupcat'];
        $data['intro'] = mysql_real_escape_string($_POST['intro']);
		$data['ttkhuyenmai'] = mysql_real_escape_string($_POST['ttkhuyenmai']);
        $data['content'] = mysql_real_escape_string($_POST['content']);
		$data['tabname0'] = compile_post('tabname0');
		$data['contenttab0'] = mysql_real_escape_string($_POST['contenttab0']);
        $data['description'] = compile_post('description');
        $data['keywords'] = compile_post('keywords');
        $data['active'] = intval(compile_post('active'));
        $data['thu_tu'] = intval(compile_post('thu_tu'));
        
        $data['price'] = compile_post('price');
        $data['pricekm'] = compile_post('pricekm');
        
        $data['km'] = intval(compile_post('km'));
       	$data['icon'] = compile_post('icon');
		$data['texticon'] = compile_post('texticon');
		$data['spcungloai'] = compile_post('spcungloai');
		$data['spcungloainame'] = compile_post('spcungloainame');
		
        if (compile_post('ngay_dang') != '') {
            $data['ngay_dang'] = string_to_microtime(compile_post('ngay_dang'));
        } else {
            $data['ngay_dang'] = time();
        }
        if(compile_post('autourl')==1){
			$url =$clsUrl->builUrl(compile_post('name'),$url_extension_article,compile_post('autourl'));
		}else{
			$url =$clsUrl->builUrl(compile_post('url'),'',0);
		}
        $data['url'] = $url;

        $group = ":";
        $gr = $groupcat;
        if ($gr) {
            foreach ($gr as $gro) {
                $group.=$gro . ":";
            }
        }
        $data['groupcat'] = $group;
        $attr = $_POST['attribute'];
        $data['attr'] = addslashes(json_encode($attr));
		
		$size_price = $_POST['size_price'];
        $data['size_price'] = addslashes(json_encode($size_price));
		
        // xử lý ảnh
        if ($_FILES['image']['size']) {
            $image = Image::uploadImage('image', 'no');
            $data['image'] = $imagedir . "/" . $image['image'];
        } else {
            $data['image'] = compile_post('imageurl');
        }
        $data['id_user'] = $my['id'];


        return $data;
    }

    //Insert slide images
    function insert_multi_image($id_product){
        global $DB, $objSysImage;
        $objSysImage->deleteMulti('','product','id_product',$id_product,"slide");
        
        $collection_image = $_POST['collection_image'];
        $image_name = $_POST['image_name'];
        $image_desc = $_POST['image_desc'];

        $image_thu_tu = $_POST['image_thu_tu'];
        $a = array();
        foreach($collection_image as $k=>$v){
            $a['name'] = $image_name[$k];
            $a['image_desc'] = $image_desc[$k];
            $a['thu_tu'] = $image_thu_tu[$k];
            $a['table_name'] = "product";
            $a['id_item'] = "id_product";
            $a['type_code'] = "slide";
            $a['id_value'] = $id_product;
            $a['image'] = $v;
            $objSysImage->insertImage($a);
        }
    }
    

    function show_multi_image($id_product){
        global $DB,$tpl,$dir_path,$cache_image_path,$objSysImage;
        
        $db =  $objSysImage->getList('',"product","id_product",$id_product,"slide");
        foreach ($db as $rs){
            $tpl->newBlock("collection_cell");
            $tpl->assign(array(
                big_image => $dir_path.'/'.trim_url_image($rs['image']),
                image => $cache_image_path.resizeimage(192,130,$dir_path.'/'.$rs['image']),
                real_image => trim_url_image($rs['image']),
                thu_tu => $rs['thu_tu'],
                name => $rs['name'],
                image_desc => $rs['image_desc'],
                id => $rs['id']
            ));
        }
    }    
    
	function lstSize($id_product){
		global $DB,$tpl;
		$sql = "SELECT * FROM dm_size ORDER BY thu_tu DESC";
		$db = $DB->query($sql);
		$str='';
		while($rs = mysql_fetch_array($db)){
			$str.='<div><strong>'.$rs['name'].':</strong> <input  name="price_size[]" placeholder="Giá..." type="text"> VNĐ</div><div class="c5"></div>';	
		}
		return $str;
	}
}

?>