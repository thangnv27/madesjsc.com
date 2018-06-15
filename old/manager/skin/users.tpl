
<div class="c5"></div>
<div class="breadLine">
    <ul class="breadcrumb">
        <li><a href="?"><i class="icon-home"></i></a></li>
         Quản lý {item}
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
        <th colspan="2"><i class="icon-pencil icon-white"></i>&nbsp;Thêm/Sửa thông {item}</th>
      </tr>
      <tr>
        <td width="150"><strong>Mã đăng nhập</strong></td>
        <td><input type="text" name="username" style="width:250px;" class="notNull" value="{username}" data-alert="Bạn cần nhập vào tiêu đề {item}"/></td>
      </tr>
      <tr>
        <td><strong>Họ tên</strong></td>
        <td><input type="text" name="name" id="name" style="width:250px;" value="{name}" /></td>
      </tr>
      <tr>
        <td><strong>Email</strong></td>
        <td><input type="text" name="email" id="email" style="width:250px;" value="{email}" /></td>
      </tr>
      <tr>
        <td><strong>Điện thoại</strong></td>
        <td><input type="text" name="telephone" id="telephone" style="width:250px;" value="{telephone}" /></td>
      </tr>
      <tr>
        <td><strong>Địa chỉ</strong></td>
        <td><input type="text" name="address" id="address" style="width:250px;" value="{address}" /></td>
      </tr>
      <tr>
        <td><strong>Mật khẩu </strong></td>
        <td><input type="password" name="password" id="password" style="width:250px;" value="" /></td>
      </tr>
      <tr>
        <td><strong>Ảnh</strong></td>
        <td>{image}<input type="file" name="image" /></td>
      </tr>
      <tr>
        <td><strong>Quyền quản trị</strong></td>
        <td>
        	<ul><li style="color:#F00; font-weight:bold"><input class="supper" name="super" type="checkbox" value="1" {1super} style="border:solid 1px #F00">
                        	Tất cả các quyền (Supper administrator)</li>
            	{module_rows}
            </ul>
        </td>
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
    <th colspan="7">
        <div style="float:left"><i class="icon-list-alt icon-white"></i>&nbsp;Danh sách {item}</div>
        <a href="?page={par_page}&code=showAddNew&pid={pid}" style="float:right"><div class="btn  btn-mini"><i class="icon-plus-sign"></i>&nbsp;Thêm mới {item}</div></a>
    </th>
  </tr>
   <tr class="search_box nonehover">
    <td colspan="7">
    <div class="form-search" style="margin:0px;">
      <div class="input-append">
        <input type="text" class=" search-query" style="height:20px;" placeholder="Từ khóa cần tìm...">
        <button type="submit" class="btn">Tìm</button>
      </div>
      {parentid}
    </div>
    </td>
  </tr>
  <tr class="title">
    <td width="100">Mã đăng nhập</td>
    <td>Tên {item}</td>
    <td width="150" align="center" class="center">Email</td>
    <td width="200" align="center" class="center">Quyền</td>
    <td width="60" align="center" class="center">Kích hoạt</td>
    <td width="30" align="center">Sửa</td>
    <td width="30" align="center">Xóa</td>
  </tr>
  <!-- START BLOCK : list -->
  <tr>
    <td>{username}</td>
    <td>
      <div class="list_item_name"><a href="{link_edit}">{name}</a></div>
    </td>
    <td class="center">{email}</td>
    <td align="left">{module}</td>
    <td class="center"><input type="checkbox" name="active" value="1" data-active="{id}" {active} class="changeactive"/></td>
    <td><a href="{link_edit}" class="btn padingleftright4"><i class="icon-wrench"></i></a></td>
    <td><a href="{link_delete}" class="trash_item btn padingleftright4"><i class="icon-trash"></i></a></td>
  </tr>
  <!-- END BLOCK : list -->

  <tr class="search_box nonehover">
    <td colspan="7">
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

