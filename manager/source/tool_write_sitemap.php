<?php

// Create 26/5/2011

// suongmumc@gmail.com

//	RewriteCond %{HTTP_HOST} !^www\.hoaianh\.info 

//	RewriteRule (.*) http://www.hoaianh.info/$1 [L,R=301]

defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );

$table_array = array(

	'news' 		=> 'id_news',

	'info' 		=> 'id_info',

	'product' 	=> 'id_product'

);

$data_type_not_write = array(

	'logo'

);

write_sitmap();

function write_sitmap(){

	global $DB,$CONFIG,$lang,$table_array,$data_type_not_write,$site_address;

	if($CONFIG['dir_path']=='')

		$rootpath='/';

	else

		$rootpath=$CONFIG['dir_path'];

	$File = "../"."sitemap.xml"; 

	$Handle = fopen($File, 'w');

	$Data = '<?xml version="1.0" encoding="UTF-8"?>

		<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

			<url>

				<loc>'.$site_address.'</loc>

				<lastmod>'.date('c', time()).'</lastmod>

				<changefreq>daily</changefreq>

			</url>

	  ';

	  $Data.= getUrlCategory($data_type_not_write);

	  	foreach($table_array as $key=>$val){

	 		$Data.= getUrlItem($key,$val);

		}

	  

	  $Data.='

</urlset>

	'; 



	$ok=fwrite($Handle, $Data); 

	fclose($Handle); 	

	echo "<div class=\"alert alert-success\" style=\"text-align:center;\"><strong>Đã cập nhật xong !</strong></div>";

}



function getUrlItem($table,$id){

	global $DB,$site_address,$dir_path,$clsUrl;

	$sql = "SELECT * FROM $table WHERE active=1 ORDER BY $id DESC";

	$db = $DB->query($sql);

	$str='';

	while($rs = mysql_fetch_array($db)){
		$cat_url = url_process::getUrlCategory($rs['id_category']);
		if($cat_url!=''){

		$str.='<url>';

	    	$str.='<loc>'.$site_address.$dir_path.'/'.$cat_url.$rs['url'].'</loc>';

			$str.='</url>

		';	

		}

	}

	return $str;

}



function getUrlCategory($data_type_not_write){

	global $DB,$site_address,$dir_path;

	$sql = "SELECT * FROM category WHERE active=1 ORDER BY name ASC";

	$db = $DB->query($sql);

	$str='';

	while($rs = mysql_fetch_array($db)){

		if(!in_array($rs['data_type'],$data_type_not_write)){

			if($rs['url'] != ''){

				$str.='<url>';

		    	$str.='<loc>'.$site_address.$dir_path.'/'.$rs['url'].'</loc>';

				$str.='</url>

			';

			}

		}

	}

	return $str;

}





?>