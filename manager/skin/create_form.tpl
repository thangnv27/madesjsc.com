
<div class="c5"></div>
<div class="breadLine">
    <ul class="breadcrumb">
        <li><a href="?"><i class="icon-home"></i></a></li>
        {pathpage}
    </ul>
</div>
<div class="c20"></div>
  
<div class="wraper-content">
<!-- START BLOCK : msg -->
<div>{msg}</div>
<!-- END BLOCK : msg -->
<!-- START BLOCK : create_form -->
<div class="tab_form">
	<ul>
    	<li rel="#tabgeneral" class="{tabgeneral}">General</li>
        <!-- START BLOCK : showNextTab -->
        <li rel="#tabfield" class="{tabfield}" id="create_field" data-href="">Fields</li>
      	<li rel="#tabform" class="{tabform}">Form</li>
        <li rel="#tabemail" class="{tabemail}">Notification E-mail</li>
        <li rel="#autorespondersemail" class="{autorespondersemail}">Auto responders E-mail</li>
        <!-- END BLOCK : showNextTab -->
    </ul>
</div> 
<script>
	$(function(){
		$('.tab_form li').click(function(){
			$('.tab_form li').removeClass('active');
			$(this).addClass('active');
			$('.tabcontent_form').hide();
			$($(this).attr('rel')).fadeIn();
			if($(this).attr('rel') == '#tabform'){
			  	$("#reloadField").append('<div class="loading"></div>');
				$("#field_insert").load('index4.php?page=create_form&act=load_field_list&id={id}', function(response, status, xhr){
					if (status == "error") {
						var msg = "Sorry but there was an error: ";
						$("#error").html(msg + xhr.status + " " + xhr.statusText);
					}
					if(status == "success"){
						$("#reloadField .loading").remove();
					}
				});
			}
			if($(this).attr('rel') == '#tabemail'){
			  	$("#reloadField_notifi").append('<div class="loading"></div>');
				$("#field_insert_notifi").load('index4.php?page=create_form&act=load_field_list&id={id}', function(response, status, xhr){
					if (status == "error") {
						var msg = "Sorry but there was an error: ";
						$("#error").html(msg + xhr.status + " " + xhr.statusText);
					}
					if(status == "success"){
						$("#reloadField_notifi .loading").remove();
					}
				});
			}
		});
		$('#create_field, #add_field').click(function(){
			$("#create_field_form").append('<div class="loading"></div>');
			$("#create_field_form").load('{action_tabfield}', function(response, status, xhr) {
			  if (status == "error") {
			    var msg = "Sorry but there was an error: ";
			    $("#error").html(msg + xhr.status + " " + xhr.statusText);
			  }
			});
			return false;
		});
		
		
	});
</script>
<!-- START BLOCK : tabgeneral -->
<form action="{action}" method="post" id="tabgeneral_form" style="margin:0;padding:0">
<div id="tabgeneral" class="tabcontent_form">

	<input type="hidden" name="save" value="1" />
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-bordered tabletdnone" style="border-radius:0px 0px 4px 4px" >
      <tr>
        <td width="150"><strong>Form name</strong></td>
        <td><input type="text" name="form_name" class="txtform100 notNull" style="width:300px;" value="{form_name}" data-alert="Bạn cần nhập vào tên form"/></td>
      </tr>
      <tr>
        <td><strong>Title</strong></td>
        <td><input type="text" name="title" id="title" class="txtform100"  style="width:300px;" value="{title}" /></td>
      </tr>
      <tr>
        <td><strong>Category</strong></td>
        <td>{parentid}</td>
      </tr>
      <tr>
        <td><strong>Sub category</strong></td>
        <td>
        <select name="groupcat[]" multiple="multiple" style="width:300px; height:200px;">
        	{parentid1}
        </select>
        </td>
      </tr>
      <tr>
        <td valign="top">
        	<strong>After submit</strong>
	        <div  style="padding-top:5px;">
	        	<label class="radio"><input type="radio" class="after_submit" name="after_submit" id="after_submit_text" value="text" {after_submit_text}>
	        	Show text</label></div>
	        <div style="padding-top:3px;">
	          <label class="radio"><input type="radio" class="after_submit" name="after_submit" id="after_submit_url" value="url" {after_submit_url}>
	        Redirect to url</label>
	        </div>
            <script>
            	$(function(){
					check_affer_submit($('.after_submit:checked').val());
					$('.after_submit').change(function(){
						check_affer_submit($(this).val());
					});
				});
				
				function check_affer_submit(val){
					$('#url_redirect').attr('disabled',true);
					$('#display_text').attr('disabled',true);	
					if( val == 'text'){
						$('#display_text').attr('disabled',false);
						$('#url_redirect').attr('disabled',true);		
					}else{
						$('#url_redirect').attr('disabled',false);
						$('#display_text').attr('disabled',true);	
					}
				}
            </script>
        </td>
        <td>
	        <div style="padding-top:15px;">
	        	<div><input name="display_text" id="display_text" style="width:300px;" type="text" value="{display_text}"></div>
                
                <div style="padding-top:5px;"><input name="url_redirect" style="width:300px;" id="url_redirect" type="text" value="{url_redirect}"></div>
	        </div>
        	
        </td>
      </tr>
      <tr>
        <td valign="top"><strong>Button send</strong></td>
        <td><input type="text" name="submit_button_text" class="txtform100 notNull" style="width:300px;" value="{submit_button_text}" /></td>
      </tr>
      <tr>
        <td valign="top"><strong>Image backgroud button send</strong></td>
        <td><input type="text" name="submit_button_image" class="txtform100 notNull" style="width:300px;" value="{submit_button_image}" /></td>
      </tr>
      <tr>
        <td valign="top"><strong>Description</strong></td>
        <td><textarea name="description" id="description" cols="45" rows="5" style="width:300px">{description}</textarea></td>
      </tr>
      <tr>
        <td><strong>Keywords</strong></td>
        <td style="position:relative"><textarea name="keywords" id="keywords" cols="45" rows="5" style="width:300px">{keywords}</textarea></td>
      </tr>
      <tr>
        <td><strong>Url</strong></td>
        <td style="position:relative">
            <div class="input-prepend">
              <span class="add-on"><input name="autourl" id="autourl" type="checkbox" value="1" {autourl}/></span>
              <input class="span2" id="url" name="url" type="text" style="width:572px;" value="{url}">
            </div>
            <div style="font-size:11px; color:#666; font-style:italic">Checked tự động tạo url/Uncheck lấy url trên ô text</div>
        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><a class="btn btn-primary" onclick="$('#tabgeneral_form').submit(); return false"><i class="icon-ok-circle icon-white"></i>&nbsp;Cập nhật</a><div onclick="window.location='?page={adminpage}&pid={pid}'" class="btn btn-inverse" style="margin-left:10px;"><i class="icon-remove icon-white"></i>&nbsp;Đóng</div></td>
      </tr>
    </table>
</div>
<div id="tabform" class="tabcontent_form display_none">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-bordered tabletdnone" style="border-radius:0px 0px 4px 4px" >
      <tr>
        <td colspan="2">
        	<div style="width:773px; float:left">
            	{layout}
            </div>
            <script>
			$(function(){
				$('#labelInsert').click(function(){
					var val = '{label:' + $('#field_insert option:selected').val() + ':' + $('#field_insert option:selected').text() + '}';
					insertInput(val);
					return false;
				});
				$('#inputInsert').click(function(){
					var val = '{input:' + $('#field_insert option:selected').val() + ':' + $('#field_insert option:selected').text() + '}';
					insertInput(val);
					return false;
				});
			});
            	function insertInput(val){
					CKEDITOR.instances.layout.insertHtml( val );
				}
            </script>
            <div style="float:left; width:210px; position:relative" id="reloadField">
            
            	<select name="field_insert" id="field_insert" style="width:100%; height:300px;" multiple>{field_dropdownlist}</select>
                <div class="c5"></div>
                <button class="btn btn-info btn-mini" name="labelInsert" id="labelInsert" style="width:100%">Chèn nhãn</button>
                <div class="c5"></div>
                <button class="btn btn-primary btn-mini" name="inputInsert" id="inputInsert" style="width:100%">Chèn input</button>
            </div>
        </td>
      </tr>
      <tr>
        <td width="150">&nbsp;</td>
        <td><a class="btn btn-primary" onclick="$('#inputform').submit(); return false"><i class="icon-ok-circle icon-white"></i>&nbsp;Cập nhật</a><div onclick="window.location='?page={par_page}&pid={pid}'" class="btn btn-inverse" style="margin-left:10px;"><i class="icon-remove icon-white"></i>&nbsp;Đóng</div></td>
      </tr>
    </table>
</div>
<div id="tabemail" class="tabcontent_form display_none">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-bordered tabletdnone" style="border-radius:0px 0px 4px 4px" >
      <tr>
        <td>
        	<div style="padding:10px 0px 10px 10px;"><label class="checkbox"><input name="send_to_email" id="send_to_email" type="checkbox" value="1" {send_to_email}>Send form data to e-mail</label></div>
            <div id="text_email_noitifi">
	           	<div style="padding:5px 0px 5px 10px;">
	            	<div style="float:left; width:100px;">From e-mail:</div>
	                <div style="float:left;"><input name="from_email" type="text" style="width:300px;" value="{from_email}"></div>
	                <div class="c5"></div>
	            </div>
                <div class="c"></div>
	            <div style="padding:5px 0px 5px 10px;">
	            	<div style="float:left; width:100px;">To e-mail:</div>
	                <div style="float:left;"><input name="to_email" type="text" style="width:300px;" value="{to_email}"></div>
	                <div class="c5"></div>
	            </div>
                <div class="c"></div>
	            <div style="padding:5px 0px 5px 10px;">
	            	<div style="float:left; width:100px;">Subject:</div>
	                <div style="float:left;"><input name="subject_email" type="text" style="width:300px;" value="{subject_email}"></div>
	                <div class="c5"></div>
	            </div>
            </div>
            <div style="padding:10px 0px 10px 10px;"><label class="checkbox"><input name="custom_layout" id="custom_notifi_layout" type="checkbox" value="1" {custom_layout}>Use custom layout</label></div>
        </td>
        <td>&nbsp;</td>
        </tr>
        <tr id="custom_noitifi_layout" class="display_none">
        <td colspan="2">
        <script>
				$(function(){
					if($('#send_to_email').prop('checked') == true){
						$('#text_email_noitifi input').prop('disabled',false);
						$('#custom_notifi_layout').prop('disabled',false);
					}else{
						$('#text_email_noitifi input').prop('disabled',true);	
						$('#custom_notifi_layout').prop('disabled',true);
					}
					$('#send_to_email').change(function(){
						if($(this).prop('checked') == true){
							$('#text_email_noitifi input').prop('disabled', false);
							$('#custom_notifi_layout').prop('disabled',false);
						}else{
							$('#text_email_noitifi input').prop('disabled',true);	
							$('#custom_notifi_layout').prop('disabled',true);
						}
					});
					if($('#custom_notifi_layout').prop('checked') == true){
						$('#custom_noitifi_layout').fadeIn();
					}else{
						$('#custom_noitifi_layout').fadeOut();	
					}
					$('#custom_notifi_layout').change(function(){
						if($(this).prop('checked') == true){
							$('#custom_noitifi_layout').fadeIn();
						}else{
							$('#custom_noitifi_layout').fadeOut();	
						}
					});
					$('#labelInsert_notifi').click(function(){
						var val = '{label:' + $('#field_insert_notifi option:selected').val() + ':' + $('#field_insert_notifi option:selected').text() + '}';
						insertInput_notifi(val);
						return false;
					});
					$('#inputInsert_notifi').click(function(){
						var val = '{input:' + $('#field_insert_notifi option:selected').val() + ':' + $('#field_insert_notifi option:selected').text() + '}';
						insertInput_notifi(val);
						return false;
					});
				});
				function insertInput_notifi(val){
					CKEDITOR.instances.notifi_email.insertHtml( val );
				}
            </script>
        <div>
        	
        	<div style="width:773px; float:left">
            	{notifi_email}
            </div>
            <div style="float:left; width:205px; position:relative" id="reloadField_notifi">
            
            	<select name="field_insert_notifi" id="field_insert_notifi" style="width:100%; height:300px;" multiple>{field_dropdownlist}</select>
                <div class="c5"></div>
                <button class="btn btn-info btn-mini" name="labelInsert" id="labelInsert_notifi" style="width:100%">Chèn nhãn</button>
                <div class="c5"></div>
                <button class="btn btn-primary btn-mini" name="inputInsert" id="inputInsert_notifi" style="width:100%">Chèn input</button>
            </div>
         </div>   
        </td>
      </tr>
      
      <tr>
      	<td><a class="btn btn-primary" onclick="$('#tabgeneral_form').submit(); return false"><i class="icon-ok-circle icon-white"></i>&nbsp;Cập nhật</a><div onclick="window.location='?page={adminpage}&pid={pid}'" class="btn btn-inverse" style="margin-left:10px;"><i class="icon-remove icon-white"></i>&nbsp;Đóng</div></td>
        <td>&nbsp;</td>
        
      </tr>
    </table>
</div>


<div id="autorespondersemail" class="tabcontent_form display_none">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-bordered tabletdnone" style="border-radius:0px 0px 4px 4px" >
     
        <tr >
        <td colspan="2">
        <div style="padding:10px;"><label class="checkbox"><input name="autoresponder" id="autoresponder" type="checkbox" value="1" {autoresponder}><strong>Auto responders</strong></label></div>
        <div>Subject: <input name="autoresponder_subject" style="width:700px;" type="text" value="{autoresponder_subject}"></div>
        <div class="c5"></div>
        <script>
				$(function(){
					$('#labelInsert_autoresponder').click(function(){
						var val = '{label:' + $('#field_insert_autoresponder option:selected').val() + ':' + $('#field_insert_autoresponder option:selected').text() + '}';
						insertInput_autoresponder(val);
						return false;
					});
					$('#inputInsert_autoresponder').click(function(){
						var val = '{input:' + $('#field_insert_autoresponder option:selected').val() + ':' + $('#field_insert_autoresponder option:selected').text() + '}';
						insertInput_autoresponder(val);
						return false;
					});
				});
				function insertInput_autoresponder(val){
					CKEDITOR.instances.autoresponder_email.insertHtml( val );
				}
            </script>
        <div>
        	
        	<div style="width:773px; float:left">
            	{autoresponder_email}
            </div>
            <div style="float:left; width:205px; position:relative" id="reloadField_notifi">
            
            	<select name="field_insert_autoresponder" id="field_insert_autoresponder" style="width:100%; height:300px;" multiple>{field_dropdownlist}</select>
                <div class="c5"></div>
                <button class="btn btn-info btn-mini" name="labelInsert_autoresponder" id="labelInsert_autoresponder" style="width:100%">Chèn nhãn</button>
                <div class="c5"></div>
                <button class="btn btn-primary btn-mini" name="inputInsert_autoresponder" id="inputInsert_autoresponder" style="width:100%">Chèn input</button>
            </div>
         </div>   
        </td>
      </tr>
      
      <tr>
      	<td><a class="btn btn-primary" onclick="$('#tabgeneral_form').submit(); return false"><i class="icon-ok-circle icon-white"></i>&nbsp;Cập nhật</a><div onclick="window.location='?page={adminpage}&pid={pid}'" class="btn btn-inverse" style="margin-left:10px;"><i class="icon-remove icon-white"></i>&nbsp;Đóng</div></td>
        <td>&nbsp;</td>
        
      </tr>
    </table>
</div>
</form>

<div id="tabfield" class="tabcontent_form display_none">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-bordered tabletdnone" style="border-radius:0px 0px 4px 4px" >
      <tr>
        <td colspan="2" valign="top" id="create_field_form" style="position:relative;">
        	<div >&nbsp;</div>
        </td>
        <td width="300" valign="top" style="border-left:solid 1px #cdcdcd;box-shadow: -1px 0px 1px #fff;">
        	<div style="position:relative" id="load_field_list">
            	<div><a href="{action_tabfield}" class="btn" id="add_field"><i class="icon-plus-sign"></i> Add field</a>&nbsp;<a href="#" class="btn" id="btn_delete_field"><i class="icon-trash"></i> Delete field</a></div>
                <div class="c5"></div>
        	  <select name="field" id="field" style="width:290px; margin:0 auto; height:298px" multiple >
        	    	{field_dropdownlist}
    	        </select>
                <div>Double click để sửa</div>
                 <div class="c5"></div>
            </div>
          <script>
            	$('#field option').click(function(){
					$('#field option').prop('selected',false);
					$(this).prop("selected",true);
				});
				$('#field option').dblclick(function(){
						$("#create_field_form").append('<div class="loading"></div>');
						$("#create_field_form").load('index4.php?page=create_form&act=create_field_form&code=showupdate&field_id=' + $(this).val() + '&id={id}', function(response, status, xhr) 						{
						  if (status == "error") {
						    var msg = "Sorry but there was an error: ";
						    $("#error").html(msg + xhr.status + " " + xhr.statusText);
						  }
						});
						return false;
					
				});
				$('#btn_delete_field').click(function(){
					$("#load_field_list").append('<div class="loading"></div>');
					$("#field").load('index4.php?page=create_form&act=delete_field&field_id=' + $('#field option:selected').val(), function(response, status, xhr){
						if (status == "error") {
							var msg = "Sorry but there was an error: ";
							$("#error").html(msg + xhr.status + " " + xhr.statusText);
						}
						if(status == "success"){
							$("#load_field_list .loading").remove();
							load_field_list();
						}
					});
				});
				function load_field_list(){
					$("#load_field_list").append('<div class="loading"></div>');
					$("#field").load('index4.php?page=create_form&act=load_field_list&id={id}', function(response, status, xhr){
						if (status == "error") {
							var msg = "Sorry but there was an error: ";
							$("#error").html(msg + xhr.status + " " + xhr.statusText);
						}
						if(status == "success"){
							$("#load_field_list .loading").remove();
						}
					});
				}
            </script>
        </td>
      </tr>
      
    </table>
</div>

<!-- END BLOCK : tabgeneral -->
<div class="divider1"><span></span></div>
<!-- END BLOCK : create_form -->
<!-- START BLOCK : showlist -->
<form action="{action}" method="post" id="list_form">
 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-striped table-hover">
  <tr>
    <th colspan="6">
        <div style="float:left"><i class="icon-list-alt"></i>&nbsp;Danh sách {item}</div>
        <a href="?page={adminpage}&code=tabgeneral&pid={pid}" style="float:right"><div class="btn  btn-mini"><i class="icon-plus-sign"></i>&nbsp;Thêm mới {item}</div></a>
    </th>
  </tr>
   <tr class="search_box nonehover">
    <td colspan="8">
    <div class="form-search" style="margin:0px;">
      {parentid}
    </div>
    </td>
  </tr>
  <tr class="title">
    <td width="16"><input type="checkbox" name="checkbox" id="checkbox" class="cat_check" data-check="cat_check" onclick="check_all(this)" /></td>
    <td>Tiêu đề</td>
    <td width="130" align="center" class="center">Nhóm</td>
    <td width="130"  style="text-align:center">Nhóm phụ</td>
    <td width="30" align="center">Sửa</td>
    <td width="30" align="center">Xóa</td>
  </tr>
  <!-- START BLOCK : list_forms -->
  <tr>
    <td width="16"><input type="checkbox" name="delmulti[{id}]" id="checkbox" class="cat_check" value="{id}" /></td>
    <td>
        <div class="list_item_name"><a href="{link_edit}">{form_name}</a></div>
        <div class="info_item"><strong>Người đăng:</strong> {username} - <strong>Ngày:</strong> {createdate}</div>
        <div class="info_item"><strong>Url:</strong> <a href="{url}" target="_blank">{url}</a></div>
    </td>
    <td align="center" class="center" valign="middle"><a href="{linkcat}">{categoryname}</a></td>
    <td style="text-align:center">{groupcatname}</td>
    <td><a href="{link_edit}" class="btn padingleftright4"><i class="icon-wrench"></i></a></td>
    <td><a href="{link_delete}" class="trash_item btn padingleftright4"><i class="icon-trash"></i></a></td>
  </tr>
  <!-- END BLOCK : list_forms -->

  <tr class="title">
    <td width="16"><input type="checkbox" name="checkbox" id="checkbox" class="cat_check" onclick="check_all($(this))"/></td>
    <td><a href="?page={par_page}&code=deletemulti" id="delmultiitem">Xóa tất cả mục đã chọn</a></td>
    <td><div class="btn btn-inverse" onclick="$('#list_form').submit();" style="margin-left:30px">Cập nhật</div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr class="search_box nonehover">
    <td colspan="6">
           {pages}
    </td>
  </tr>
</table>
</form>
<!-- END BLOCK : showlist -->
<div id="divremovea"></div>
</div>
<script>
$(function(){
	// delete record
	$('.trash_item').click(function(){
		if(confirm('Bạn có thật sự muốn xóa không ?')){
			obj=$(this);
			show_mes('Đang thực hiện !');
			obj.parent().parent().fadeTo('fast', 0.3);
			$("#divremovea").load('index4.php' + obj.attr('href'), function(response, status, xhr) {
			  if (status == "error") {
				var msg = "Sorry but there was an error: ";
				alert(msg + xhr.status + " " + xhr.statusText);
			  }
			  if(status == 'success'){
				  obj.parent().parent().remove();
				   show_mes('Đã xóa xong');
			  }
			});
			return false;
		}else{
			return false;	
			show_mes('Đã hủy lệnh !');
		}
		
	});
	
	$('#delmultiitem').click(function(){
		if(confirm('Bạn có thật sự muốn xóa những mục đã chọn không ?')){
			$('#list_form').attr('action',$(this).attr('href'));
			$('#list_form').submit();
		}else{
			return false;	
		}
		return false;
	})
	// go to category
	$('#parentid').change(function(){
		window.location='?page={adminpage}&pid=' + $(this).val();
	});
});
</script>

