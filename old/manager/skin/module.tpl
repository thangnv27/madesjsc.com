<div class="c5"></div>
<div class="breadLine">
    <ul class="breadcrumb">
        <li><a href="#"><i class="icon-home"></i></a></li>
        <li><a href="?page={par_page}">Quản lý module</a> </li>
    </ul>
</div>
<div class="c20"></div>
                        
<div class="wraper-content">
<!-- START BLOCK : AddNew -->
<form action="{action}" method="post" id="inputform" onSubmit="return check_null();">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-bordered tabletdnone">
      <tr>
        <th colspan="2"><i class="icon-pencil icon-white"></i>&nbsp;Thêm/Sửa Module</th>
       </tr>
      <tr>
        <td width="150"><strong>Tên module</strong></td>
        <td><input type="text" name="name" id="module_name" class="txtform250 notNull" data-alert="Bạn cần nhập vào tên module !" value="{name}"/></td>
      </tr>
      <tr>
        <td><strong>File module admin</strong></td>
        <td><input type="text" name="gia_tri" id="modulefile" class="txtform250 notNull" data-alert="Bạn cần nhập vào file module !" value="{gia_tri}"/></td>
      </tr>
      <tr>
        <td><strong>File module fontend</strong></td>
        <td><input type="text" name="filefontend" id="filefontend" class="txtform250"  value="{filefontend}"/></td>
      </tr>
      <tr>
        <td><label for="active"><strong>Kích hoạt</strong></label></td>
        <td><input type="checkbox" name="active" id="active" value="1" {active}/></td>
       </tr>
      <tr>
        <td><strong>Thứ tự</strong></td>
        <td><input type="text" name="thu_tu" id="thu_tu" class="txtorder" value="{thu_tu}"/></td>
       </tr>
      <tr>
        <td>&nbsp;</td>
        <td>
        	<input name="btnsubmit" type="submit" value="Cập nhật" class="btn btn-primary"/>
        </td>
       </tr>
    </table>
</form>
<div class="divider1"><span></span></div>
<!-- END BLOCK : AddNew -->

<!-- START BLOCK : showList -->
<form action="{action}" id="list_form" method="post">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-striped table-hover">
      <tr>
        <th colspan="5">
        	<div style="float:left"><i class="icon-book icon-white"></i>&nbsp;Danh sách chuyên mục</div>
        	<a href="?page=module&code=showAddNew" style="float:right"><div class="btn  btn-mini"><i class="icon-plus-sign"></i>&nbsp;Thêm mới</div></a>
        </th>
      </tr>
      <tr class="title">
        <td>Tiêu đề</td>
        <td width="60" class="center">Kích hoạt</td>
        <td width="60" class="center">Thứ tự</td>
        <td width="30">Sửa</td>
        <td width="30">Xóa</td>
      </tr>
      <!-- START BLOCK : list -->
      <tr>
        <td><strong>{name}</strong></td>
        <td class="center"><input type="checkbox" name="active" value="1" data-active="{id}" {active} class="changeactive"/></td>
        <td><input type="text" name="thu_tu[{id}]"  class="txtorder" value="{thu_tu}" /></td>
        <td><a href="{link_edit}" class="btn padingleftright4"><i class="icon-wrench"></i></a></td>
        <td><a href="{link_delete}" class="btn padingleftright4 trash_item"><i class="icon-trash"></i></a></td>
      </tr>
      <!-- END BLOCK : list -->
      <tr class="title">
        <td>&nbsp;</td>
        <td colspan="2"><div class="btn btn-inverse" style="margin-left:30px" id="btnupdateorder">Cập nhật</div></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
     
  </table>
  </form>
<!-- END BLOCK : showList -->
<div class="divider1"><span></span></div>
<div id="divremovea"></div>
</div>

<script>

$(function(){
	$('#btnupdateorder').click(function(){
		$('#list_form').attr('action','?page={par_page}&code=ordering');
		$('#list_form').submit();
	});
});

function check_null(){
	var ok=true;
	$('.spanalert').remove();
	$('.notNull').each(function(){
		
		if($(this).val()==''){
			$('<span class="spanalert">' + $(this).attr('data-alert') + '</span>').insertAfter($(this)); 
			ok=false;
		}		
	});
	return ok;
}

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
		$("#divremovea").load('index4.php?page=action_ajax&code=change_active&table=module&id_item=id_module&id=' + obj.attr('data-active') + '&active=' + active, function(response, status, xhr) {
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