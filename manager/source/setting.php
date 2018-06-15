<?php 
// Nguyen Binh
// suongmumc@gmail.com

defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );
$tpl=new TemplatePower("skin/setting.tpl");
$tpl->prepare();
	if($_POST['gone']==1){
		$setting_item = $_POST['setting_item'];
		foreach ($setting_item as $key => $val) {
			$val = clean_value(trim($val));
			$sql = "UPDATE settings 
					SET setting_value = '$val' 
					WHERE setting_name = '$key'";
			$DB->query($sql);
		}
		
		if($_FILES['watermark_image']['size'] || compile_post('xoa')==1)
		{
			$sql = "SELECT setting_value FROM settings WHERE setting_name = 'bgimage'";
			$db=$DB->query($sql);
			$rs=mysql_fetch_array($db);
			deleteimage($rs['setting_value'],'','');
			$image=uploadimagenothumb('watermark_image');
			
			$imagename=$image['image'];
			$sql = "UPDATE settings SET setting_value ='".$imagename."' WHERE setting_name ='watermark_image'";
			$DB->query($sql);
								
		}	
		Message::showMessage("success","Cập nhật thành công !");
		
	}
	
	$info=show_settings_form();

	$tpl->assignGlobal("document_root",$info['document_root']);
	$tpl->assignGlobal("dir_path",$info['dir_path']);
	$tpl->assignGlobal($info['mailer'],"selected");
	
	$tpl->assignGlobal("http_host",$info['http_host']);
	$tpl->assignGlobal("toppage",$info['toppage']);
	$tpl->assignGlobal("date_format",$info['date_format']);
	$tpl->assignGlobal("time_format",$info['time_format']);
	$tpl->assignGlobal("root",$_SERVER['DOCUMENT_ROOT']);
	$tpl->assignGlobal("select_time_offsets",$info['select_time_offsets']);
	$tpl->assignGlobal("currentdate",date($info['date_format'].' '.$info['time_format'],time()+$info['time_offset']*3600));
	$tpl->assignGlobal("smtp_host",$info['smtp_host']);
	$tpl->assignGlobal("smtp_username",$info['smtp_username']);
	$tpl->assignGlobal("smtp_password",$info['smtp_password']);
	$tpl->assignGlobal("gz_compress_yes",$info['gz_compress_yes']);
	$tpl->assignGlobal("gz_compress_no",$info['gz_compress_no']);
	
	
	
	$tpl->assignGlobal("upload_image_path",$info['upload_image_path']);
	$tpl->assignGlobal("max_image_width",$info['max_image_width']);
	$tpl->assignGlobal("watermark_text",$info['watermark_text']);
	$tpl->assignGlobal("auto_thumbnail_dimension",$info['auto_thumbnail_dimension']);
	$tpl->assignGlobal("max_thumb_width",$info['max_thumb_width']);
	$tpl->assignGlobal("watermark_image",$info['watermark_image']);
	
	
	$tpl->assignGlobal("site_keywords",$info['site_keywords']);
	$tpl->assignGlobal("site_description",$info['site_description']);
	
	$tpl->assignGlobal("max_media_size",$info['max_media_size']);
	$tpl->assignGlobal("upload_media_path",$info['upload_media_path']);
	$tpl->assignGlobal("allowed_mediatypes",$info['allowed_mediatypes']);
	$tpl->assignGlobal("upload_mode_1",$info['upload_mode_1']);
	$tpl->assignGlobal("upload_mode_2",$info['upload_mode_2']);
	$tpl->assignGlobal("upload_mode_3",$info['upload_mode_3']);
	
	$tpl->assignGlobal("site_name",$info['site_name']);
	$tpl->assignGlobal("site_email",$info['site_email']);
	$tpl->assignGlobal("active_yes",$info['active_yes']);
	$tpl->assignGlobal("active_no",$info['active_no']);
	$tpl->assign("active_site"		,ClEditor::EditorBase('setting_item[content_active_site]',$info['content_active_site']));

$tpl->printToScreen();


function show_settings_form()
{
	global $DB,$tpl;
	$info=array();
	$sql="Select * from settings";
	$a=$DB->query($sql);
	while ($b=mysql_fetch_array($a))
	{
		$info[$b['setting_name']]=$b['setting_value'];
	}
		if (!$info['root_path'])
		{
			$info['root_path']=$_SERVER['DOCUMENT_ROOT'];
		}
		if (intval($info['use_smtp']))
		{
			$info['use_smtp_yes']='checked';
		}
		else
		{
			$info['use_smtp_no']='checked';
		}		
		if (intval($info['gz_compress']))
		{
			$info['gz_compress_yes']='checked';
		}
		else
		{
			$info['gz_compress_no']='checked';
		}
		
		if (intval($info['active_site']))
		{
			$info['active_yes']='checked';
		}
		else
		{
			$info['active_no']='checked';
		}		
		
		$info['time_offset']=intval($info['time_offset']);
		$info['select_time_offsets']="<select name='setting_item[time_offset]'>";
		for ($i=-12;$i<=12;$i++)
		{
			$info['select_time_offsets'].="\n<option value='".$i."'";
			if ($info['time_offset']==$i)
				$info['select_time_offsets'].=" selected";
			$info['select_time_offsets'].=">".$i."</option>";
		}
		$info['select_time_offsets'].="\n</select>";
		if (intval($info['upload_mode'])==1)
		{
			$info['upload_mode_1']='checked';
		}
		if (intval($info['upload_mode'])==2)
		{
			$info['upload_mode_2']='checked';
		}
		if (intval($info['upload_mode'])==3)
		{
			$info['upload_mode_3']='checked';
		}
		$info['id_country']=intval($info['id_country']);
		$info['dir_autoupload']=$info['dir_autoupload'];
		if($info['watermark_image'])
			$info['watermark_image']="<img src='../".$info['upload_image_path'].$info['watermark_image']."' width='100'><br><input type='checkbox' name='xoa' value='1' />Xóa logo";
		$info['content_active_site']=$info['content_active_site'];
		$sql="select * from country order by id_country asc";
		$x=$DB->query($sql);
		$info['country_options']='';
		while ($y=mysql_fetch_array($x))
		{
			$info['country_options'].="<option value='".$y['id_country']."'";
			if ($info['id_country']==$y['id_country'])
			{
				$info['country_options'].=" selected";
			}
			$info['country_options'].=">".$y['name']."</option>";
		}
	return $info;
}


?>