
<div class="c5"></div>
<div class="breadLine">
    <ul class="breadcrumb">
        <li><a href="?"><i class="icon-home"></i></a></li>
      	Danh mục ngân hàng
    </ul>
</div>
<div class="c20"></div>
  
<div class="wraper-content">
<!-- START BLOCK : msg -->
<div>{msg}</div>
<!-- END BLOCK : msg --> 
<!-- START BLOCK : showUpdate -->
<form action="{action}" method="post" id="inputform" onSubmit="return check_null();" enctype="multipart/form-data">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-bordered tabletdnone">
      <tr>
        <th colspan="2"><i class="icon-pencil icon-white"></i>&nbsp;Cập nhật</th>
      </tr>
      <tr>
        <td width="150"><strong>Tên ngân hàng</strong></td>
        <td><input type="text" name="name" class="notNull" value="{name}" data-alert="Bạn cần nhập vào tiêu đề {item}"/></td>
      </tr>
      <tr>
        <td><strong>Kích hoạt</strong></td>
        <td><input type="checkbox" name="active" id="active" value="1" {active} /></td>
      </tr>
      <tr>
        <td><strong>Thứ tự</strong></td>
        <td><input type="text" name="thu_tu" id="thu_tu" class="txtorder" value="{thu_tu}" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><a class="btn btn-primary" onClick="$('#inputform').submit(); return false"><i class="icon-ok-circle icon-white"></i>&nbsp;Cập nhật</a><div onClick="window.location='?page={par_page}&pid={pid}'" class="btn btn-inverse" style="margin-left:10px;"><i class="icon-remove icon-white"></i>&nbsp;Đóng</div></td>
      </tr>
    </table>
</form>
<div class="divider1"><span></span></div>

<!-- END BLOCK : showUpdate -->

<!-- START BLOCK : showList -->
<form action="?page={par_page}&code=changeorder" method="post" id="list_form">
 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-striped table-hover">
							 
  <tr>
    <th colspan="6">
        <div style="float:left"><i class="icon-list-alt icon-white"></i>&nbsp;Danh sách {item}</div>
        <a href="?page={par_page}&code=showAddNew" style="float:right"><div class="btn  btn-mini"><i class="icon-plus-sign"></i>&nbsp;Thêm mới {item}</div></a>
    </th>
  </tr>
  
  <tr class="title">
    <td width="16"><input type="checkbox" name="checkbox" id="checkbox" class="cat_check" data-check="cat_check" onClick="check_all(this)" /></td>
    <td>Tiêu đề</td>
    <td width="60" align="center" class="center">Kích hoạt</td>
    <td width="80" align="center">Thứ tự</td>
    <td width="30" align="center">Sửa</td>
    <td width="30" align="center">Xóa</td>
  </tr>
  <!-- START BLOCK : list -->
  <tr>
    <td width="16"><input type="checkbox" name="delmulti[{id}]" id="checkbox" class="cat_check" value="{id}" /></td>
    <td>
      <div class="list_item_name"><a href="{link}">{name}</a></div>
     
    </td>
    <td class="center"><input type="checkbox" name="active" value="1" data-active="{id}" {active} class="changeactive"/></td>
    <td><input type="text" name="thu_tu[{id}]" class="txtorder" value="{thu_tu}"/></td>
    <td><a href="{link_edit}" class="btn padingleftright4"><i class="icon-wrench"></i></a></td>
    <td><a href="{link_delete}" class="trash_item btn padingleftright4"><i class="icon-trash"></i></a></td>
  </tr>
  <!-- END BLOCK : list -->

 <tr class="title">
    <td colspan="2"><a href="?page={par_page}&code=deletemulti" id="delmultiitem">Xóa tất cả mục đã chọn</a></td>
    
     <td>&nbsp;</td>
    <td colspan="1"><div class="btn btn-inverse" id="btnUpdate" >Cập nhật</div></td>
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
	
	$(function (){
		$('.trash_item').click(function(){
			if(confirm('Bạn có thật sự muốn xóa không ?')){
				window.location=$(this).attr('href');
				return false;
			}
			return false;
		});
		$('#delmultiitem').click(function(){
			if(confirm('Bạn có thật sự muốn xóa những mục đã chọn không ?')){
				$('#list_form').attr('action',$(this).attr('href'));
				$('#list_form').submit();
			}
			return false;
		});
		$('#btnUpdate').click(function(){
			$('#list_form').attr('action','?page={par_page}&code=changeorder');
			$('#list_form').submit();
			
			return false;
		});
		
	});
</script>

