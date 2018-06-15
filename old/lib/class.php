<?php 
error_reporting(0);
defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );
  	class paging{
		public function pagingAdmin($p,$url,$sql,$maxpage,$maxitem,$get='p') { 
			global $DB, $tpl;
			$p=isset($p) ? intval($p):1;
			
			$db=$DB->query($sql);
			$cac_trang=array();
			$total=mysql_num_rows($db);
			$total=ceil($total/$maxitem);
			if ($p>$maxpage) { 
				$num_page=ceil($p/$maxpage); 
				$showpage=($num_page-1)*$maxpage; 
				$end=$showpage+$maxpage; 
				$showpage++; 
			}else  	{ 
				$thispage=1; 
				$showpage=1; 
				$end=$maxpage; 
			} 
			$startpage=$showpage; 
			for ($showpage;$showpage<$end+1;$showpage++) 
			{ 
				if ($showpage<=$total) { 
					if ($p==$showpage) { 
						$list_page.='<li class="disabled"><a href="#">'.$showpage.'</a></li>'; 
					}else { 
						$list_page.="<li><a href='$url&$get=$showpage'>".$showpage."</a></li>"; 
					} 
				} 
			} 
			if ($num_page>1) { 
				$back=$startpage-1; 
				if ($num_page>2) { 
					$list_page1="<li><a href='$url&$get=1'><i class='icon-step-backward'></i>&nbsp;</a></li>"; 
				} 
				$list_page1.="<li><a href='$url&$get=$back'><i class='icon-backward'></i>&nbsp;</a></li>"; 
			} 
			if ($num_page<ceil($total/$maxpage)&&($total>$maxpage)) { 
				$next=$showpage; 
				$list_page2.="<li><a href='$url&$get=$next'><i class='icon-forward'></i>&nbsp;</a></li>"; 
				$list_page2.="<li><a href='$url&$get=$total'><i class='icon-step-forward'></i></a></li>"; 
			} 
			$list_page=$list_page1.$list_page.$list_page2; 
			if($total > 1){
				if($list_page){
					$ps['pages']='<div class="pagination pagination-small"><ul><li class="disabled"><a href="#">Trang: '.$p.'/'.$total.'&nbsp;&nbsp;</a></li>'.$list_page.'</ul></div>';
				 }
			}
			$ps['pre']=$list_page1;
			$ps['next']=$list_page2;
			$ps['page']=$list_page;
			$a=$maxitem*$p-$maxitem;
			$sql=$sql." limit ".$a.",".$maxitem;
			$ps['db']=$DB->query($sql);
			return $ps;
		}	
		
		
		public function pagingFonten($p,$url,$sql,$maxpage,$maxitem) 
		{ 
			global $DB, $tpl, $lang,$site_address;
			if($lang=='_eng'){
				$trang="Page(s)";
			}else{
				$trang="Trang";
			}
			$p=isset($p) ? intval($p):1;
			$db=$DB->query($sql);
			$cac_trang=array();
			$total=mysql_num_rows($db);
			$total=ceil($total/$maxitem);
			if ($p>$maxpage) { 
				$num_page=ceil($p/$maxpage); 
				$showpage=($num_page-1)*$maxpage; 
				$end=$showpage+$maxpage; 
				$showpage++; 
			}else  	{ 
				$thispage=1; 
				$showpage=1; 
				$end=$maxpage; 
			} 
			$startpage=$showpage; 
			for ($showpage;$showpage<$end+1;$showpage++) 
			{ 
				if ($showpage<=$total) { 
					if ($p==$showpage) { 
						$list_page.="<span class='clicked'>&nbsp;".$showpage."&nbsp;</span>"; 
					}else { 
						if($showpage<=1){
							$list_page.="<a href='".$url."' class='cactrang' >&nbsp;".$showpage."&nbsp;</a>"; 
						}else{
							$list_page.="<a href='".$url."page-".$showpage."/' class='cactrang' >&nbsp;".$showpage."&nbsp;</a>"; 
						}
					} 
				} 
			} 
			if ($num_page>1) { 
				$back=$startpage-1; 
				if ($num_page>2) { 
					$list_page1="<a href='".$url."page-"."1/' class='cactrang' ><strong>|<</strong></a>"; 
				} 
				$list_page1.="<a href='$url"."page-"."/' class='cactrang' ><strong><<</strong></a>"; 
			} 
			if ($num_page<ceil($total/$maxpage)&&($total>$maxpage)) { 
				$next=$showpage; 
				$list_page2.=" <a href='".$url."page-".$next."/'  class='cactrang'><strong>>></strong></a>"; 
				$list_page2.=" <a href='".$url."page-".$total."/'  class='cactrang'><strong>>>|</strong></a>"; 
			} 
			$list_page=$list_page1.$list_page.$list_page2; 
			if($total > 1)
			{
				if($list_page){
					$cac_trang['pages']="&nbsp;".$trang.":  &nbsp;&nbsp;".$list_page;
				 }
			}
			$cac_trang['p']=$p;
			$cac_trang['total']=$total;
			$cac_trang['pre']=$list_page1;
			$cac_trang['next']=$list_page2;
			/*if($total>1){
				$cac_trang['pages']=$list_page;
			}*/
			$a=$maxitem*$p-$maxitem;
			$sql=$sql." limit ".$a.",".$maxitem;
			$cac_trang['db']=$DB->query($sql);
			return $cac_trang;
		}
		public function pagingAjax($p,$url,$sql,$maxpage,$maxitem) 
		{ 
			global $DB, $tpl, $lang,$site_address;
			if($lang=='_eng'){
				$trang="Page(s)";
			}else{
				$trang="Trang";
			}
			$p=isset($p) ? intval($p):1;
			$db=$DB->query($sql);
			$cac_trang=array();
			$total=mysql_num_rows($db);
			$total=ceil($total/$maxitem);
			if ($p>$maxpage) { 
				$num_page=ceil($p/$maxpage); 
				$showpage=($num_page-1)*$maxpage; 
				$end=$showpage+$maxpage; 
				$showpage++; 
			}else  	{ 
				$thispage=1; 
				$showpage=1; 
				$end=$maxpage; 
			} 
			$startpage=$showpage; 
			for ($showpage;$showpage<$end+1;$showpage++) 
			{ 
				if ($showpage<=$total) { 
					
						$list_page.="<a href='".$url."&p=".$showpage."' class='cactrang' >&nbsp;".$showpage."&nbsp;</a>"; 
					
				} 
			} 
			if ($num_page>1) { 
				$back=$startpage-1; 
				if ($num_page>2) { 
					$list_page1="<a href='".$url."&p="."1' class='cactrang' ><strong>|<</strong></a>"; 
				} 
				$list_page1.="<a href='$url"."&p="."' class='cactrang' ><strong><<</strong></a>"; 
			} 
			if ($num_page<ceil($total/$maxpage)&&($total>$maxpage)) { 
				$next=$showpage; 
				$list_page2.=" <a href='".$url."&p=".$next."'  class='cactrang'><strong>>></strong></a>"; 
				$list_page2.=" <a href='".$url."&p=".$total."'  class='cactrang'><strong>>>|</strong></a>"; 
			} 
			$list_page=$list_page1.$list_page.$list_page2; 
			if($total > 1)
			{
				if($list_page){
					$cac_trang['cac_trang']="&nbsp;".$trang.":  &nbsp;&nbsp;".$list_page;
				 }
			}
			$cac_trang['p']=$p;
			$cac_trang['total']=$total;
			$cac_trang['pre']=$list_page1;
			$cac_trang['next']=$list_page2;
			if($total>1)
			$cac_trang['pages']=$list_page;
			$a=$maxitem*$p-$maxitem;
			$sql=$sql." limit ".$a.",".$maxitem;
			$cac_trang['db']=$DB->query($sql);
			return $cac_trang;
		}
	}
	
	class ClEditor{
		public function Editor($id,$value){
			global $_SESSION;
			
			$CKEditor = new CKEditor();
			$CKEditor->returnOutput = true;
			$CKEditor->basePath = '';
			$CKEditor->config['width'] = '770';
			$CKEditor->config['height'] = '350';
			$CKEditor->textareaAttributes = array("cols" => 60, "rows" => 10);
			$initialValue = $value;
			
			$config['toolbar'] = array(
				 array('Source','-','Save','NewPage','DocProps','Preview','Print','-','Templates'
				, 'clipboard',  'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ,
				 'editing',  'Find','Replace','-','SelectAll','-','SpellChecker', 'Maximize', 'ShowBlocks','Smiley','SpecialChar' ),
				array(
				 'basicstyles',  'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ,
				 'paragraph', 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv',
				'-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl',
				 'links',  'Link','Unlink','Anchor' ),
				array( 'insert', 'Image','Flash','Table','HorizontalRule','PageBreak','Iframe' ,
				 'styles', 'Styles','Format','Font','FontSize',
				'colors',  'TextColor','BGColor',
				 'tools' )
			);
			
			$config['skin'] = 'v2';
			$ckfinder = new CKFinder();
			
			$ckfinder->BasePath = 'inputcontent/ckfinder/'; // Note: the BasePath property in the CKFinder class starts with a capital letter.
			$ckfinder->SetupCKEditorObject($CKEditor);
			$code = $CKEditor->editor($id, $initialValue,$config);
			return $code;
		}
		public function EditorBase($id,$value){
			global $_SESSION;
			$CKEditor = new CKEditor();
			$CKEditor->returnOutput = true;
			$CKEditor->basePath = '';
			$CKEditor->config['width'] = '770';
			$CKEditor->config['height'] = '200';
			$CKEditor->textareaAttributes = array("cols" => 60, "rows" => 10);
			$initialValue = $value;
			$config['skin'] = 'v2';
			$config['toolbar'] = array(
			array( 'Source', '-', 'Bold', 'Italic', 'Underline', 'Strike','Save','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','Image', 'Link', 'Unlink', 'Anchor','Paste','PasteText','PasteFromWord' ,'basicstyles','RemoveFormat' ),
			array( 'styles', 'Styles','Format','Font','FontSize','colors', 'TextColor','BGColor')
			);
			
			$ckfinder = new CKFinder();
			$ckfinder->BasePath = 'inputcontent/ckfinder/'; // Note: the BasePath property in the CKFinder class starts with a capital letter.
			$ckfinder->SetupCKEditorObject($CKEditor);
			$code = $CKEditor->editor($id, $initialValue,$config);
			return $code;
		}
	
	}
	
	
class cat_tree{
	var $n;
	var $current_idcat;
	var $navcat;
	var $subcatlist;
	function cat_tree($current_idcat=0)
	{
		$this->current_idcat=$current_idcat;
		$this->navcat=array();
		$this->subcatlist=array();
	}
	function get_cat_tree($parent = 0,$data_type='')
	{
		global $DB,$tree; // add $cat_old
		if($data_type==''){
			$dataType='';
		}else{
			$dataType = " AND data_type='".$data_type."'";	
		}
		$sql = "SELECT * FROM category WHERE parentid='$parent' $dataType ORDER BY thu_tu ASC,id_category DESC";
		$raw = $DB->query($sql);
		
		// add -- if it has childs
		if ($DB->get_affected_rows() > 0) {
			$this->n++;
		} else {
			return;
		} 
		while ($result = mysql_fetch_array($raw)) {
		/*
			if ($result['pcatid'] == $childcat_old['pcatid']) {
				continue; // remove  cats from list
			}
			*/
			for($i = 0;$i < $this->n;$i++) {
				$tree[$result['id_category']]['name'] .= '-- ';
			}
			$tree[$result['id_category']]['name'] .= $result['name'];
			$this->get_cat_tree($result['id_category'],$data_type);
		}
		// all childs listed, remove --
		$this->n--;
	}
	function get_cat_string($id_cat)
	{
		global $DB,$catstring;
		if ($id_cat==0)
			return;
		else{
			$sql="select * from category where id_category=".$id_cat;
			$a=$DB->query($sql);
			if ($b=mysql_fetch_array($a)){
				$catstring = $b['name']." > ".$catstring;
				$this->get_cat_string($b['parentid']);
			}
		}
	
	}
	function get_cat_string_admin($id_cat,$par_page)
	{
		global $DB,$catstring2;
		if ($id_cat==0)
			return;
		else{
			
			$sql="select * from category where id_category=".$id_cat;
			$a=$DB->query($sql);
			if ($b=mysql_fetch_array($a)){
				$catstring2 = '<li><a href="main.php?page='.$par_page.'&pid='.$id_cat.'" $showclass>'.$b['name'].'</a> <span class="divider">></span></li>'.$catstring2;
				$this->get_cat_string_admin($b['parentid'],$par_page);
			}
			return $catstring2;
		}
		
	}
	function get_cat_nav($id_cat){
		global $DB;
		if ($id_cat==0){
			ksort($this->navcat);
			return;
		}else{
			$sql="select * from id_category where id_category=".$id_cat;
			$a=$DB->query($sql);
			if ($b=mysql_fetch_array($a)){
				$this->navcat[$b['id_category']]['name']=$b['name'];
				$this->get_cat_nav($b['parentid']);
			}
		}
	
	}
	function get_sub_cat_list($id_cat)	{
		global $DB;
		$raw = $DB->query("select * from category where parentid='$id_cat' order by thu_tu asc,id_category desc");
		if ($DB->get_affected_rows() == 0) {
			return;
		} 
		while ($result = mysql_fetch_array($raw)) {
			$this->subcatlist[$result['id_category']]['name'] = $result['name'];
			$this->get_sub_cat_list($result['id_category']);
		}
	}
}


// xử lý ảnh
class Image{
	public function uploadImage($inputname,$thumnail='yes',$dich=''){
		global $CONFIG,$_FILES,$tpl,$category,$par_page;
		$a=array();
			$dich=$CONFIG['root_path'].$CONFIG['upload_image_path'];
			$dich1=$CONFIG['upload_image_path'];
		
		if ($_FILES[$inputname]['size']){
			$in_image=get_new_file_name($_FILES[$inputname]['name'],clean_url(get_file_name($_FILES[$inputname]['name'])));
			$file_upload=new Upload($dich,'jpg,jpeg,gif,png,bmp,swf');
			//echo "kq=".$file_upload->upload_file($inputname,2,$in_image)."<br />";
			if ($file_upload->upload_file($inputname,2,$in_image))
			{
	
				$a['image']=$file_upload->file_name;
				
				if($CONFIG['watermark_image']){
					$watermark = WideImage::load($CONFIG['root_path'].$CONFIG['upload_image_path'].$CONFIG['watermark_image']);
					$base = WideImage::load($dich1.$a['image']);
					$result = $base->merge($watermark, "right - 10", "bottom - 10", 100);
				    $result->saveToFile($dich1.$a['image']);
				}elseif($CONFIG['watermark_text']){
					 $img = WideImage::load($dich.$a['image']);
					 $canvas = $img->getCanvas();
					
					 $canvas->useFont('VARISON.TTF', 9, $img->allocateColor(255, 255, 255));
					 $canvas->writeText("right - 9", "top + 11", $CONFIG['watermark_text']);
					 $canvas->useFont('VARISON.TTF', 9, $img->allocateColor(9, 171, 25));
					 $canvas->writeText("right - 10", "top + 10", $CONFIG['watermark_text']);
					 $img->saveToFile($dich.$a['image']);	
					
				}
			  
				if($thumnail=='yes'){
					$thumbnail=create_thumb($dich, $file_upload->file_name);
					if ($thumbnail)
					{
						$a['small_image']=$dich1.$thumbnail['thumb'];
						$a['normal_image']=$dich1.$thumbnail['normal'];
					}
					else
					{
						$msg.="Kh&#244;ng t&#7841;o &#273;&#432;&#7907;c &#7843;nh thumbnail ! Xem l&#7841;i &#273;&#7883;nh d&#7841;ng file !<br>";
					}
				}
				$a['image']=$dich1.$a['image'];
				
			}
			else
			{
				$msg.=$file_upload->get_upload_errors()."<br>";
			}			
		}
		//$tpl->newBlock("msg");
		echo $msg;
		return $a;
	}
	
	public function url_upload_image($file_url)
	{
	    global $CONFIG,$dir_image_upload;
		//$file_name1=get_file_name($file_url);
		$file_name=basename($file_url);
		$file_extension=get_file_extension($file_name);
		$vowels = array("autopro-","vnm");
	 	$file_name = str_replace($vowels, "", $file_name);
		$file_name=get_new_file_name($file_name,$file_name);
		
		$filepath=$CONFIG['root_path'].$dir_image_upload;
		
		$image=$file_url;
		$len=strlen($file_name);
		
		$len1=strlen($file_extension);
	  	$binh_filename=time().'-'.substr($file_name,0,$len-$len1);
		 $image1 = $filepath .  $binh_filename;
	  
		$imagesize = getimagesize($image);
		if (!file_exists($image)) {
			if($imagesize[0]>600){
				resize_image($image, $image1, '600', 'gd2', 'wd', '');
				$urlimage['image']='' . $binh_filename.'jpeg';
			}else{
				resize_image($image, $image1, $imagesize[0], 'gd2', 'wd', '');	
				$urlimage['image']='' . $binh_filename.'jpeg';
			}
		}
	   
	    return $urlimage;
	}	
	
	function deleteimage($lastfile='',$lastnormal='',$lastsmall='',$dich=''){ 
		global $CONFIG;
		if($dich==''){
			$dich=$CONFIG['root_path'];
		}else {
			$dich=$dich;
		}
		if ($lastfile||$lastnormal||$lastsmall)
		{
			if ($lastfile && file_exists($dich.$lastfile))
			{
				unlink($dich.$lastfile);
			}
			if ($lastnormal && file_exists($dich.$lastnormal))
			{
				unlink($dich.$lastnormal);
			}
			if ($lastsmall && file_exists($dich.$lastsmall))
			{
				unlink($dich.$lastsmall);
			}						
		}
	}
	
}

class Message{
	function showMessage($type,$msg){
		global $tpl;
		switch($type){
			case 'warning':
				$mes = '<div class="alert fade in">
				            <button type="button" class="close" data-dismiss="alert">×</button>
				            <i class=" icon-warning-sign" style="margin-right:10px;"></i><strong>'.$msg.'</strong>
				          </div><script>show_mes($(".alert").text());</script>';
				break;
			case 'success':
				$mes = '<div class="alert alert-success fade in">
				            <button type="button" class="close" data-dismiss="alert">×</button>
				            <i class="icon-ok" style="margin-right:10px;"></i><strong>'.$msg.'</strong>
				          </div><script>show_mes($(".alert").text());</script>';
				break;
			case 'info':
				$mes = '<div class="alert alert-info fade in">
				            <button type="button" class="close" data-dismiss="alert">×</button>
				            <i class="icon-info-sign" style="margin-right:10px;"></i><strong>'.$msg.'</strong>
				          </div><script>show_mes($(".alert").text());</script>';
				break;
			case 'error':
				$mes = '<div class="alert alert-error fade in">
				            <button type="button" class="close" data-dismiss="alert">×</button>
				            <i class="icon-minus-sign" style="margin-right:10px;"></i><strong>'.$msg.'</strong>
				          </div><script>show_mes($(".alert").text());</script>';
				break;
			default:
				$mes = '<div class="alert alert-info fade in">
				            <button type="button" class="close" data-dismiss="alert">×</button>
				            <i class="icon-info-sign" style="margin-right:10px;"></i><strong>'.$msg.'</strong>
				          </div><script>show_mes($(".alert").text());</script>';
				break;
			
		}
		$tpl->newBlock("msg");
		$tpl->assign("msg",$mes);
		
	}	
}

class Category{
  	public function getParentId($idc){
		global $DB, $dklang;
		$idc = intval($idc);
		$idc=intval($idc);
		$list_id.=$idc;
		$sql="SELECT * FROM category WHERE parentid=$idc $dklang";
		$db=$DB->query($sql);
		while($rs=mysql_fetch_array($db)){
			$list_id.=",".Category::getParentId($rs['id_category']);	
		}
		return $list_id;
	}
	
	public function categoryName($idc){
		global $DB;
		$idc = intval($idc);
		$sql = "SELECT * FROM category WHERE id_category = $idc";
		$db = $DB->query($sql);
		if($rs = mysql_fetch_array($db)){
			return $rs['name'];
		}
	}	
	public function categoryInfo($idc){
		global $DB;
		$idc = intval($idc);
		$sql = "SELECT * FROM category WHERE id_category = $idc";
		$db = $DB->query($sql);
		$str = '';
		if($rs = mysql_fetch_array($db)){
			$str['name'] = $rs['name'];
			$str['content'] = $rs['content'];
			if($rs['image']){
				$str['image']=$rs['image'];
			}
		}
		return $str;
	}	
}

class Order{
	public function getOrderCat($table){
		global $DB,$dklang;	
		if($table){
			$sql = "SELECT MAX(thu_tu) AS thutu FROM ".$table;
			$db = $DB->query($sql);
			if($rs = mysql_fetch_array($db)){
				return $rs['thutu']	+ 1;
			}
		}
	}
}


?>