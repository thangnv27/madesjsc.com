<?php 
defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );
	
class url_process{
	public function type_Info($type){
		$str=array();
		switch($type){
			case 'news':	
				$str['page']='news';
				$str['tableitem']='news';
				$str['id_item']='id_news';
				$str['adminpage']='news';
				$str['titlemenu']='tin tức';
				$str['data_type']="news";
				break;
			case 'product':	
				$str['page']='product';
				$str['tableitem']='product';
				$str['id_item']='id_product';
				$str['adminpage']='product';
				$str['titlemenu']='Sản phẩm';
				$str['data_type']="product";
				break;
			case 'info':	
				$str['page']='info';
				$str['tableitem']='info';
				$str['id_item']='id_info';
				$str['adminpage']='info';
				$str['titlemenu']='nội dung';
				$str['data_type']="info";
				
				break;
			case 'logo':	
				$str['page']='logo';
				$str['tableitem']='logo';
				$str['id_item']='id_logo';
				$str['adminpage']='logo';
				$str['titlemenu']='logo';
				$str['data_type']="logo";
				break;
			case 'home':	
				$str['page']='home';
				$str['tableitem']='';
				$str['id_item']='';
				$str['adminpage']='';
				$str['titlemenu']='';
				$str['data_type']="home";
				break;
			case 'contact':	
				$str['page']='contact';
				$str['tableitem']='';
				$str['id_item']='';
				$str['adminpage']='';
				$str['titlemenu']='';
				$str['data_type']="contact";
				break;
		}
		return $str;
	}
	function cont_page($uri){
		$page['p'] = 1;	
		if(intval($this->get_number_page($url))>0){
			$page['p'] = intval($this->get_number_page($url));	
			$url=substr($url,0,strlen($url)-1);
			$a=explode("/",$url);
			$url = substr($url,0,strlen($url) - strlen(end($a)));
		}
		if($this->get_dir($uri)){ // category
			switch ($this->get_dir($uri)){
				case 'addcart/':
					$page['page']='cart';
					$page['code']='add';	
					$page['prod_cat']='product';
					$page['id_product'] = $this -> get_id_item($uri);
					break;
				case 'search/':
					$page['page']='product';
					break;
				
				case 'sitemap/':
					$page['page']='sitemap';
					break;
				case 'update_cat/':
					$page['page']='cart';
					$page['code']='proadd';
					break;
				case 'cart_checkout/':
					$page['page']='cart';
					$page['code']='checkout0';
					break;
				
			}	
		}else{ //no category
			switch ($uri){
				case 'cart.htm':
					$page['page']='cart';
					$page['code']='add';
					break;
				case 'update_cat.html':
					$page['page']='cart';
					$page['code']='proadd';
					break;
				case 'cart_checkout.html':
					$page['page']='cart';
					$page['code']='checkout0';
					break;
				case 'logout1.html':
					$page['page']='home';
					$page['code']='logout';
					break;
			
			}
		}
		
		return $page;
	}
	public function Url_Type($url){
		global $DB,$dir_path,$dklang;
		$uri=$url;
		

		$cateinfo=array();
		$url=$this->get_dir($url);

		if($url){
			$cateinfo['p'] = 1;	
			if(intval($this->get_number_page($url))>0){
				$cateinfo['p'] = intval($this->get_number_page($url));	
				$url=substr($url,0,strlen($url)-1);
				$a=explode("/",$url);
				$url = substr($url,0,strlen($url) - strlen(end($a)));
			}

			$sql="SELECT * FROM category WHERE url='".$url."' $dklang"	;
			
			$db=$DB->query($sql);
			if($rs=mysql_fetch_array($db)){
				if($rs['data_type']==''){
					$cateinfo['data_type'] = 'home';
					
				}else{
					$cateinfo['data_type'] = $rs['data_type'];
				}
				
				$cateinfo['id_category'] = $rs['id_category'];
				$cateinfo['name'] 	= $rs['name'];
				$cateinfo['description'] 	= $rs['description'];
				$cateinfo['keyword'] 	= $rs['keyword'];
				if($rs['title']){
					$cateinfo['title'] 	= $rs['title'];
				}else{
					$cateinfo['title'] 	= $rs['name'];	
				}
				
				$page= $this -> type_Info($rs['data_type']);
				$cateinfo['page']  = $page['page'];
			}else{
				$cateinfo=$this->cont_page($uri);	
			}
			
		}else{
			$uri=$this->trimdirpath($uri);
			$cateinfo=$this->cont_page($uri);
		}
		return $cateinfo;
	}
	 function trimdirpath($uri){
		global $dir_path;
		$lendirpath=strlen($dir_path)+1;
		$uri=substr($uri,$lendirpath,strlen($uri));
		return $uri;
	}
	public function get_dir($uri){
		$uri=$this -> trimdirpath($uri);
		
		$str = explode('/', $uri);
		$dir = substr($uri,0,strlen($uri)-strlen(end($str)));
		return $dir;
	}
	function get_number_page($uri){
		$uri=substr($uri,0,strlen($uri)-1);
		$str = explode('/', $uri);	
		$strtrang=end($str);
		$x=explode('-', $strtrang);
		if($x[0]=='trang' || $x[0]=='page'){
			return $x[1];
		}
	}
	 function get_filename($uri){
		global $dir_path;
		$lendirpath=strlen($dir_path);
		$uri=substr($uri,$lendirpath,strlen($uri));
		$str = explode('/', $uri);
		return $filename=end($str);
	}
	public function get_id_item($uri){
		$filename=$this->get_filename($uri);
		$str = explode('_', $filename);
		$a = explode('.', end($str));
		return $a[0];
		
	}
	function get_id_article($data_type,$filename){
		global $DB;
		$article = $this->type_Info($data_type);	
		$table= $article['tableitem'];
		if($table){
			if($filename){
				$sql="SELECT * FROM $table WHERE url='".$filename."'";
				$db=$DB->query($sql)	;
				if($rs=mysql_fetch_array($db)){
					return $rs[$article['id_item']]	;			
				}
			}
		}
	}
	function get_meta_item($type){
		global $DB,$id,$idc, $CONFIG,$dklang;	
		$typeinfo=$this->type_Info($type);
		$str=array();
		
		if($id){
			if($typeinfo['tableitem'] && $typeinfo['id_item']){
				$sql="SELECT * FROM ".$typeinfo['tableitem']." WHERE ".$typeinfo['id_item']."=".$id;
				$db=$DB->query($sql);
				if($rs=mysql_fetch_array($db)){
					if($rs['title']){
						$str['title'] = strip_tags($rs['title'])." - ".$CONFIG['site_name'];
					}else{
						$str['title'] = strip_tags($rs['name'])." - ".$CONFIG['site_name'];
					}
					if(strlen(strip_tags($rs['description']))>2){
						$str['description'] = strip_tags($rs['description']);	
					}elseif(strlen(strip_tags($rs['ttkhuyenmai']))>7){
						$str['description'] = strip_tags($rs['ttkhuyenmai']);	
					}elseif(strlen(strip_tags($rs['intro']))>7){
						$str['description'] = strip_tags($rs['intro']);	
					}elseif(strlen(strip_tags($rs['content']))>7){
						$str['description'] = strstrim(strip_tags($rs['content']),160);	
					}else{
						$str['description'] = strip_tags($CONFIG['site_description'])	;
					}
					if($rs['keyword']){
						$str['keyword'] = $rs['keyword'];
					}else{
						$str['keyword']	= $CONFIG['site_keywords'];
					}
				}
			}
		}else{
			$sql="SELECT * FROM category WHERE id_category=$idc $dklang";
			$db=$DB->query($sql);
			if($rs=mysql_fetch_array($db)){
				if($rs['title'])	{
					$str['title'] = strip_tags($rs['title']);
				}else{
					$str['title'] = strip_tags($rs['name']);
				}
				if(strlen(strip_tags($rs['description']))>7){
					$str['description'] = strip_tags($rs['description']);
				}else{
					$str['description']	= strip_tags($CONFIG['site_description']);
				}
				if($rs['keyword']){
					$str['keyword'] = $rs['keyword'];
				}else{
					$str['keyword']	= $CONFIG['site_keywords'];
				}
			}
		}
		return $str;
	}
	
	public function builUrl($idc){
		global $DB, $lang,$dir_path;
		$idc = intval($idc);
		$sql = "SELECT * FROM category WHERE id_category = $idc ";
		$db = $DB->query($sql);
		if($rs = mysql_fetch_array($db)){
			$link = url_process::type_Info($rs['data_type']);
			if($lang=='jp'){
				$url = $dir_path."/index.php?page=".$link['page']."&idc=".$rs['id_category'];
			}else{
				$url = $dir_path."/".$rs['url'];
			}
		}
		return $url;
	}
	public function builUrlArticle($id,$idc){
		global $DB, $lang,$dir_path;
		$idc = intval($idc);
		$id = intval($id);
		if($idc){
	  		$item = url_process::type_Info(url_process::idCatToDataType($idc));
	  		$sql = "SELECT * FROM ".$item['tableitem']." WHERE ".$item['id_item']." = $id ";
	  		$db = $DB->query($sql);
	  		if($rs = mysql_fetch_array($db)){
	  			if($lang=='jp'){
	  				$url = $dir_path."/index.php?page=".$item['page']."&idc=".$rs['id_category']."&id=$id";
	  			}else{
	  				$url = $dir_path."/".url_process::getUrlCategory($idc).$rs['url'];
	  			}
	  		}
		}
		return $url;
	}
	
	public function idCatToDataType($idc){
		global $DB;
		$idc = intval($idc);
		$sql = "SELECT * FROM category WHERE id_category = $idc";
		$db = $DB->query($sql);
		if($rs = mysql_fetch_array($db)){
			return $rs['data_type']	;
		}
	}
	
	public function getUrlCategory($idc){
		global $DB, $tpl, $lang, $dir_lang;
		$idc = intval($idc)	;
		$sql = "SELECT * FROM category WHERE id_category = $idc";
		$db = $DB->query($sql);
		if($rs = mysql_fetch_array($db)){
			return $rs['url'];
		}
	}
	
	
}

?>