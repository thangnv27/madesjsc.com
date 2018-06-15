
<div class="c5"></div>
<div class="breadLine">
    <ul class="breadcrumb">
        <li><a href="?"><i class="icon-home"></i></a></li>
        Cấu hình hiển thị
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
        <th colspan="2"><i class="icon-pencil icon-white"></i>Cấu hình</th>
      </tr>
      <tr>
        <td width="150"><strong>Số tin / 1 trang</strong></td>
        <td><input name="setting[newsinpage]" type="text" style="width:100px;" value="{newsinpage}"></td>
      </tr>
      
      <tr>
        <td><strong>Số sản phẩm / 1 trang</strong></td>
        <td><input name="setting[productinpage]" type="text" style="width:100px;" value="{productinpage}"></td>
      </tr>
      <tr>
        <td><strong>Số sản phẩm/1 mục/trang chủ</strong></td>
        <td><input name="setting[producthome]" type="text" style="width:100px;" value="{producthome}"></td>
      </tr>
      
      <tr>
        <td><strong>Số tin/1 mục tin/trang chủ</strong></td>
        <td><input name="setting[newshome]" type="text" style="width:100px;" value="{newshome}"></td>
      </tr>
     
     
      
      <tr>
        <td><strong>Hotline </strong></td>
        <td><input name="setting[hotline]" type="text" style="width:300px;" value="{hotline}"></td>
      </tr>
      <tr>
        <td><strong>Hotline support </strong></td>
        <td><input name="setting[hotlinesupport]" type="text" style="width:300px;" value="{hotlinesupport}"></td>
      </tr>
      <tr>
        <td><strong>Email support </strong></td>
        <td><input name="setting[emailsupport]" type="text" style="width:300px;" value="{emailsupport}"></td>
      </tr>
      
      <tr>
        <td><strong>Địa chỉ support </strong></td>
        <td><input name="setting[addresssupport]" type="text" style="width:300px;" value="{addresssupport}"></td>
      </tr>
   	   <tr>
        <td><strong>Thông điệp (Thanh menu top) </strong></td>
        <td><input name="setting[message_top]" type="text" style="width:300px;" value="{message_top}"></td>
      </tr>
      <tr>
        <td><strong>Nút đặt hàng </strong></td>
        <td><input name="setting[btn_order]" type="text" style="width:300px;" value="{btn_order}"></td>
      </tr>
      <tr>
        <td><strong>Nút thanh toán (chi tiết SP) </strong></td>
        <td><input name="setting[btn_payment_detail_pro]" type="text" style="width:300px;" value="{btn_payment_detail_pro}"></td>
      </tr>
      <tr>
        <td><strong>Nút vận chuyển (chi tiết SP) </strong></td>
        <td><input name="setting[btn_vanchuyen_detail_pro]" type="text" style="width:300px;" value="{btn_vanchuyen_detail_pro}"></td>
      </tr>
      <tr>
        <td><strong>Nút đổi trả (chi tiết SP) </strong></td>
        <td><input name="setting[btn_doitra_detail_pro]" type="text" style="width:300px;" value="{btn_doitra_detail_pro}"></td>
      </tr>
   	   
      <tr>
        <td><strong>Facebook</strong></td>
        <td><input name="setting[facebook]" type="text" style="width:300px;" value="{facebook}"></td>
      </tr>
      <tr>
        <td><strong>Linkedin</strong></td>
        <td><input name="setting[linkedin]" type="text" style="width:300px;" value="{linkedin}"></td>
      </tr>
      <tr>
        <td><strong>Twitter</strong></td>
        <td><input name="setting[twitter]" type="text" style="width:300px;" value="{twitter}"></td>
      </tr>
      <tr>
        <td><strong>Pinterest</strong></td>
        <td><input name="setting[pinterest]" type="text" style="width:300px;" value="{pinterest}"></td>
      </tr>
      <tr>
        <td><strong>Youtube</strong></td>
        <td><input name="setting[youtube]" type="text" style="width:300px;" value="{youtube}"></td>
      </tr>
      
      <tr>
        <td>&nbsp;</td>
        <td><a class="btn btn-primary" onClick="$('#inputform').submit(); return false"><i class="icon-ok-circle icon-white"></i>&nbsp;Cập nhật</a></td>
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
    <th colspan="5">
        <div style="float:left"><i class="icon-list-alt icon-white"></i>&nbsp;Danh sách {item}</div>
        <a href="?page={par_page}&code=showAddNew&pid={pid}" style="float:right"><div class="btn  btn-mini"><i class="icon-plus-sign"></i>&nbsp;Thêm mới {item}</div></a>
    </th>
  </tr>
  
  <tr class="title">
    <td width="16"><input type="checkbox" name="checkbox" id="checkbox" class="cat_check" data-check="cat_check" onClick="check_all(this)" /></td>
    <td>Tiêu đề</td>
    <td width="60" align="center" class="center">Kích hoạt</td>
    <td width="30" align="center">Sửa</td>
    <td width="30" align="center">Xóa</td>
  </tr>
  <!-- START BLOCK : list -->
  <tr>
    <td width="16"><input type="checkbox" name="delmulti[{id}]" id="checkbox" class="cat_check" value="{id}" /></td>
    <td>
      <div class="list_item_name"><a href="{link_edit}">{name}</a></div>
    </td>
    <td class="center"><input type="checkbox" name="active" value="1" data-active="{id}" {active} class="changeactive"/></td>
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
