
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
        <th colspan="2"><i class="icon-pencil icon-white"></i>&nbsp;Form cập nhật dữ liệu</th>
      </tr>
      <tr>
        <td width="150"><strong>Họ tên</strong></td>
        <td><input type="text" name="name" class="txtform100 notNull" style="width:300px;" value="{name}" data-alert="Bạn cần nhập vào tiêu đề {item}"/></td>
      </tr>
      <tr>
        <td width="150"><strong>Điện thoại</strong></td>
        <td><input type="text" name="telephone" class="txtform100" style="width:300px;" value="{telephone}" /></td>
      </tr>
      <tr>
        <td width="150"><strong>Email</strong></td>
        <td><input type="text" name="email" class="txtform100 notNull" style="width:300px;" value="{email}" data-alert="Bạn phải nhập vào email"/> 
        </td>
      </tr>
      <tr>
        <td width="150"><strong>Địa chỉ</strong></td>
        <td><input type="text" name="address" class="txtform100" style="width:300px;" value="{address}" /></td>
      </tr>
      <tr>
        <td width="150"><strong>Chức vụ</strong></td>
        <td><input type="text" name="chucvu" class="txtform100" style="width:300px;" value="{chucvu}" /></td>
      </tr>
      <tr>
        <td width="150"><strong>Thông tin khác</strong></td>
        <td><textarea name="otherinfo" style="width:300px;" rows="5">{otherinfo}</textarea></td>
      </tr>
      <tr>
        <td width="150"><strong>Mật khẩu</strong></td>
        <td><input type="password" name="password" class="txtform100" style="width:300px;" value="{password}" /></td>
      </tr>
      <tr>
        <td width="150"><strong>Mật khẩu nhập lại</strong></td>
        <td><input type="password" name="repassword" class="txtform100" style="width:300px;" value="{repassword}" /></td>
      </tr>
      <tr>
        <td><strong>Kích hoạt</strong></td>
        <td><input type="checkbox" name="active" id="active" value="1" {active} /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><a class="btn btn-primary" onclick="$('#inputform').submit(); return false"><i class="icon-ok-circle icon-white"></i>&nbsp;Cập nhật</a><div onclick="window.location='?page={par_page}&pid={pid}'" class="btn btn-inverse" style="margin-left:10px;"><i class="icon-remove icon-white"></i>&nbsp;Đóng</div></td>
      </tr>
    </table>
</form>
<div class="divider1"><span></span></div>

<!-- END BLOCK : AddNew -->

<!-- START BLOCK : showList -->
<form action="{action}" method="post" id="list_form">
 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-striped table-hover">
							 
  <tr>
    <th colspan="5">
        <div style="float:left"><i class="icon-list-alt icon-white"></i>&nbsp;Danh sách {item}</div>
        <a href="?page={par_page}&code=showAddNew&pid={pid}" style="float:right"><div class="btn  btn-mini"><i class="icon-plus-sign"></i>&nbsp;Thêm mới {item}</div></a>
    </th>
  </tr>
   <tr class="search_box nonehover">
    <td colspan="5">
    <div class="form-search" style="margin:0px;">
      <div class="input-append">
        <input type="text" class=" search-query" id="keyword" name="keyword" style="height:20px;" placeholder="Từ khóa cần tìm...">
        <button type="submit" class="btn" id="btnSearch">Tìm</button>
      </div>
      {parentid}
    </div>
    </td>
  </tr>
  <tr class="title">
    <td width="16"><input type="checkbox" name="checkbox" id="checkbox" class="cat_check" data-check="cat_check" onclick="check_all(this)" /></td>
    <td>Tiêu đề</td>
    <td width="100" align="center" class="center">Kích hoạt</td>
    <td width="30" align="center">Sửa</td>
    <td width="30" align="center">Xóa</td>
  </tr>
  <!-- START BLOCK : list -->
  <tr>
    <td width="16"><input type="checkbox" name="delmulti[{id}]" id="checkbox" class="cat_check" value="{id}" /></td>
    <td>
      <a href="{link_edit}">{image}</a><div class="list_item_name"><a href="{link_edit}">{name}</a></div>
      <div class="info_item"><strong>Email:</strong> {email} - <strong>Điện thoại:</strong> {telephone}</div>
      <div class="info_item"><strong>Ngày đăng ký:</strong> {registtime}</div>
    </td>
    <td class="center"><input type="checkbox" name="active" value="1" data-active="{id}" {active} class="changeactive"/></td>
    <td><a href="{link_edit}" class="btn padingleftright4"><i class="icon-wrench"></i></a></td>
    <td><a href="{link_delete}" class="trash_item btn padingleftright4"><i class="icon-trash"></i></a></td>
  </tr>
  <!-- END BLOCK : list -->

  <tr class="title">
    <td width="16"><input type="checkbox" name="checkbox" id="checkbox" class="cat_check" onclick="check_all($(this))"/></td>
    <td><a href="?page={par_page}&code=deletemulti" id="delmultiitem">Xóa tất cả mục đã chọn</a></td>
    <td colspan="3"><div class="btn btn-inverse" onclick="$('#list_form').submit();" style="margin-left:30px">Cập nhật</div></td>
    </tr>
  <tr class="search_box nonehover">
    <td colspan="5">
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


</script>

<script>
$(function (){
	$('#btnSearch').click(function(){
			$('#list_form').attr('action','?page={par_page}&pid={pid}');
			$('#list_form').submit();
	});	
});

</script>