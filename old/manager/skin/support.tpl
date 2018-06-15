
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
<!-- START BLOCK : AddNew -->
<form action="{action}" method="post" id="inputform" onSubmit="return check_null();" enctype="multipart/form-data">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-bordered tabletdnone">
      <tr>
        <th colspan="2"><i class="icon-pencil icon-white"></i>&nbsp;Thêm/Sửa nick hỗ trợ</th>
      </tr>
      <tr>
        <td width="150"><strong>Tiêu đề</strong></td>
        <td><input type="text" name="name" class="txtform100 notNull" value="{name}" data-alert="Bạn cần nhập vào tiêu đề {item}"/></td>
      </tr>
      <tr>
        <td valign="top"><strong>Nick yahoo</strong></td>
        <td><input type="text" name="nic" style="width:100px;" value="{nic}" /></td>
      </tr>
      <tr>
        <td valign="top"><strong>Nick skyper</strong></td>
        <td><input type="text" name="sky" style="width:100px;" value="{sky}" /></td>
      </tr>
      <tr>
        <td><strong>Thứ tự</strong></td>
        <td><input type="text" name="thu_tu" id="thu_tu" class="txtorder" value="{thu_tu}" /></td>
      </tr>
      <tr>
        <td><strong>Kích hoạt</strong></td>
        <td><input type="checkbox" name="active" id="active" value="1" {active} /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><a class="btn btn-primary" onClick="$('#inputform').submit(); return false"><i class="icon-ok-circle icon-white"></i>&nbsp;Cập nhật</a><div onClick="window.location='?page={par_page}&pid={pid}'" class="btn btn-inverse" style="margin-left:10px;"><i class="icon-remove icon-white"></i>&nbsp;Đóng</div></td>
      </tr>
    </table>
</form>
<div class="divider1"><span></span></div>
<script type="text/javascript">
$(function() {
    $('#ngay_dang').datepicker({
		  duration: '',
		  showTime: true,
		  constrainInput: false,
		  dateFormat: 'dd/mm/yy',
		  changeYear: true,
		  changeMonth: true,
		  showOtherMonths: true,
		  time24h: true,
		  currentText: 'Today'							
  });
});

</script>

<!-- END BLOCK : AddNew -->

<!-- START BLOCK : showList -->
<form action="{action}" method="post" id="list_form">
 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-striped table-hover">
							 
  <tr>
    <th colspan="6">
        <div style="float:left"><i class="icon-list-alt icon-white"></i>&nbsp;Danh sách {item}</div>
        <a href="?page={par_page}&code=showAddNew&pid={pid}" style="float:right"><div class="btn  btn-mini"><i class="icon-plus-sign"></i>&nbsp;Thêm mới {item}</div></a>
    </th>
  </tr>
  
  <tr class="title">
    <td width="16"><input type="checkbox" name="checkbox" id="checkbox" class="cat_check" data-check="cat_check" onClick="check_all(this)" /></td>
    <td>Tiêu đề</td>
    <td width="60" align="center" class="center">Kích hoạt</td>
    <td width="60" align="center">Thứ tự</td>
    <td width="30" align="center">Sửa</td>
    <td width="30" align="center">Xóa</td>
  </tr>
  <!-- START BLOCK : list -->
  <tr>
    <td width="16"><input type="checkbox" name="delmulti[{id}]" id="checkbox" class="cat_check" value="{id}" /></td>
    <td>
      <div class="list_item_name"><a href="{link_edit}">{name}</a></div>
      <div>Yahoo: {nic} - Skyper: {sky}</div>
    </td>
    <td class="center"><input type="checkbox" name="active" value="1" data-active="{id}" {active} class="changeactive"/></td>
    <td><input type="text" name="thu_tu[{id}]" class="txtorder" value="{thu_tu}"/></td>
    <td><a href="{link_edit}" class="btn padingleftright4"><i class="icon-wrench"></i></a></td>
    <td><a href="{link_delete}" class="trash_item btn padingleftright4"><i class="icon-trash"></i></a></td>
  </tr>
  <!-- END BLOCK : list -->

  <tr class="title">
    <td width="16"><input type="checkbox" name="checkbox" id="checkbox" class="cat_check" onClick="check_all($(this))"/></td>
    <td><a href="?page={par_page}&code=deletemulti" id="delmultiitem">Xóa tất cả mục đã chọn</a></td>
    <td>&nbsp;</td>
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
<!-- END BLOCK : showList -->
<div class="divider1"><span></span></div>
<div id="divremovea" style="display:none"></div>
</div>

<script>
$(function(){
	/// delete image
	$('#trash_image').click(function(){
		$('#trash_image').fadeTo('fast',0.3)
		show_mes('Đang thực hiện !');
		$("#divremovea").load($('#trash_image').attr('href'), function(response, status, xhr) {
		  if (status == "error") {
			var msg = "Sorry but there was an error: ";
			alert(msg + xhr.status + " " + xhr.statusText);
		  }
		  if(status == 'success'){
			  $('#avatar').remove();
			  $('#trash_image').remove();
			  show_mes('Đã xóa ảnh xong !');
		  }
		});
		return false;
	});
	
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
		window.location='?page={par_page}&pid=' + $(this).val();
	});
	
	// change active
	$('.changeactive').change(function(){
		show_mes('Đang thực hiện !');
		var obj = $(this);
		var active = 0;
		var mes ='Đã bỏ kích hoạt !';
		if(obj.is(":checked")){
			active = 1		
			mes = "Đã kích hoạt !";
		}
		obj.fadeTo('fast',0.3)
		$("#divremovea").load('index4.php?page=action_ajax&code=change_active&table={table}&id_item={id_item}&id=' + obj.attr('data-active') + '&active=' + active, function(response, status, xhr) {
		  if (status == "error") {
			var msg = "Sorry but there was an error: ";
			alert(msg + xhr.status + " " + xhr.statusText);
		  }
		  if(status == 'success'){
			  show_mes(mes);
			  obj.fadeTo('fast',1);
		  }
		});
	});
});


// block ui

// tool editor
function remove_A(){ // remove tag a
	$('#divremovea').html(CKEDITOR.instances.content.getData()) ;
	$("#divremovea a").each(function(){
		 $(this).replaceWith('<span>' + $(this).html() + '</span>');
	});
	CKEDITOR.instances.content.setData ($('#divremovea').html());
	
}
function table_center(){ // table to center
	$('#divremovea').html(CKEDITOR.instances.content.getData()) ;
	$("#divremovea table").each(function(){
		 //$(this).replaceWith('<span>' + $(this).html() + '</span>');
		 $(this).attr('align','center');
	});
	CKEDITOR.instances.content.setData ($('#divremovea').html());
}
function td_text_italic(){ // text italic in td 
	$('#divremovea').html(CKEDITOR.instances.content.getData()) ;
	$("#divremovea table td").each(function(){
		 $(this).css('font-style','italic');
	});
	CKEDITOR.instances.content.setData ($('#divremovea').html());
}
function td_text_center(){ // text center in td
	$('#divremovea').html(CKEDITOR.instances.content.getData()) ;
	$("#divremovea table td").each(function(){
		 $(this).css('text-align','center');
		
	});
	CKEDITOR.instances.content.setData ($('#divremovea').html());
}
function image_center(){ // image to center
	$('#divremovea').html(CKEDITOR.instances.content.getData()) ;
	$("#divremovea img").each(function(){
		if($(this).attr('alt')){
			var curAlt = $(this).attr('alt');		
		}
		if($(this).attr('title')){
			
			var curTitle = $(this).attr('title');		
		}
		
		$(this).replaceWith('<div align="center"><img src="'+ $(this).attr('src') +'"  /></div>');
		//$(this).css('margin','0 auto');
	});
	CKEDITOR.instances.content.setData ($('#divremovea').html());
}
function remove_P(){ // remove tag p
	$('#divremovea').html(CKEDITOR.instances.content.getData()) ;
	$("#divremovea p").each(function(){
		 $(this).replaceWith('<div>' + $(this).html() + '</div>');
	});
	CKEDITOR.instances.content.setData ($('#divremovea').html());
}
</script>

<script>

function deleteimage(url,urlthumb,obj){
	obj.parent().parent().fadeTo('fast',0.3);
	$("#divremovea").load('index4.php?page=action_ajax&code=deleteimageurl&image=' + url + '&urlthumb=' + urlthumb, function(response, status, xhr) {
	  if (status == "error") {
		var msg = "Sorry but there was an error: ";
		alert(msg + xhr.status + " " + xhr.statusText);
	  }
	  if(status == 'success'){
		  obj.parent().parent().remove();
	  }
	});
}
function insertimage(url){
	CKEDITOR.instances.content.insertHtml( '<img src=' + url + ' />' );
}

</script>