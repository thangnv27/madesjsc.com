<!-- START BLOCK : show_list_form -->
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
<!-- START BLOCK : view -->
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-bordered tabletdnone">
      <tr>
        <th colspan="2">Thông tin liên hệ</th>
      </tr>
      <tr>
        <td colspan="2" valign="top"><strong>Ngày</strong>: {createdate}</td>
      </tr>
      <tr>
        <td colspan="2" valign="top">{content}</td>
      </tr>
      <tr>
        <td width="150">&nbsp;</td>
        <td><div onClick="window.location='?page=forms'" class="btn btn-inverse" style="margin-left:10px;"><i class="icon-remove icon-white"></i>&nbsp;Đóng</div></td>
      </tr>
    </table>

<div class="divider1"><span></span></div>


<!-- END BLOCK : view -->

<!-- START BLOCK : showList -->
<form action="" method="get" id="list_form">
<input type="hidden" name="page" value="forms">
 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-striped table-hover">
							 
  <tr>
    <th colspan="3">
        <div style="float:left"><i class="icon-list-alt icon-white"></i>&nbsp;Danh sách liên hệ</div>
        
    </th>
  </tr>
  <tr class="search_box nonehover"><td colspan="3">
  		<div class="input-prepend">
		  <span class="add-on">Từ ngày</span>
		  <input class="span2" id="fromdate" name="fromdate" type="text" placeholder="" value="{fromdate}" style="width:80px">
		</div>
        <div class="input-prepend">
		  <span class="add-on">Đến ngày</span>
		  <input class="span2" id="todate" name="todate" type="text" placeholder="" value="{todate}" style="width:80px">
		</div>
        <button class="btn btn-info" style="height:28px; line-height:18px;">Lọc</button>
        <a href="#myModal" role="button" class="btn" data-toggle="modal">Xuất danh sách</a>
  </td></tr>
  <script type="text/javascript">
$(function() {
    $('#fromdate, #todate, #fromdate1, #todate1').datepicker({
		  duration: '',
		  showTime: false,
		  constrainInput: false,
		  dateFormat: 'dd/mm/yy',
		  changeYear: true,
		  changeMonth: true,
		  showOtherMonths: true,
		  time24h: false,
		  currentText: 'Today',
		  maxDate: 0		
  });
});
</script>
  <tr class="title">
    <td>Tiêu đề</td>
    <td width="110" style="text-align:center">Ngày</td>
    <td width="30"  style="text-align:center">Xóa</td>
  </tr>
  <!-- START BLOCK : list -->
  <tr>
    <td>
     <a href="{link}" style="color:#000;">{name}</a>
     
    </td>
    <td>{createdate}</td>
    <td><a href="{linkdel}" class="trash_item btn padingleftright4"><i class="icon-trash"></i></a></td>
  </tr>
  <!-- END BLOCK : list -->

 
  <tr class="search_box nonehover">
    <td colspan="3">
           {pages}
    </td>
  </tr>
</table>
</form>
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Chọn những trường cần xuất</h3>
  </div>
  <div class="modal-body">
    	<form action="index4.php?page=export_list_customer" method="post" id="exprot_list_customer" target="_blank">
        <input type="hidden" name="exportTo" id="exportTo" value="screen" >
    	<div>
        	<div class="input-prepend">
			  <span class="add-on" style="width:60px;">Từ ngày</span>
			  <input class="span2" id="fromdate1" name="fromdate" type="text" placeholder="" value="{fromdate}" style="width:80px">
			</div>
	        <div class="input-prepend" style="margin-left:30px;">
			  <span class="add-on" style="width:60px;">Đến ngày</span>
			  <input class="span2" id="todate1" name="todate" type="text" placeholder="" value="{todate}" style="width:80px">
			</div>
        </div>
        <div class="10"></div>
        <div style="padding-top:10px;">
        	<select name="formId" id="fieldlist" style="width:360px;">
            <!-- START BLOCK : listForms -->
            	<option value="{form_id}">{form_name}</option>
            <!-- END BLOCK : listForms -->
            </select>
        </div>
        <div id="loadfield"></div>
        <div class="c5"></div>
        </form>
  </div>
  <div class="modal-footer">
    <button class="btn btn-primary" id="exportToScreen" >Xuất ra màn hình</button>
    <button class="btn btn-primary" id="exportToExcel" >Xuất ra file excel</button>
    <button class="btn" data-dismiss="modal" aria-hidden="true">Đóng</button>
  </div>
</div>
<script>
	$(function(){
		loadField($('#fieldlist option:selected').val());
		$('#fieldlist').change(function(){
			loadField($('#fieldlist option:selected').val())
		});
		
	});
	function loadField(id){
		$('#loadfield').text("Đang tải...");
		$("#loadfield").load("index4.php?page=forms&act=getField&form_id=" + id, function(response, status, xhr) {
		  if (status == "error") {
			var msg = "Sorry but there was an error: ";
			$("#error").html(msg + xhr.status + " " + xhr.statusText);
		  }
		});
	}
	
	$('#exportToScreen').click(function(){
		$('#exportTo').val("screen");
		$('#exprot_list_customer').submit();
		
	});
	$('#exportToExcel').click(function(){
		$('#exportTo').val("excel");
		$('#exprot_list_customer').submit();
		
	});
	$('#myModal').on('show', function () {
		$('#todate1').val($('#todate').val());
		$('#fromdate1').val($('#fromdate').val());
	});
	
</script>
<!-- END BLOCK : showList -->
<div class="divider1"><span></span></div>

</div>
<script>
	$('.trash_item').click(function(){
		if(confirm('Bạn có thật sự muốn xóa không ?')){
			window.location=$(this).attr('href');
			return false;
		}
		return false;
	});
</script>
<!-- END BLOCK : show_list_form -->
<!-- START BLOCK : list_field_of_form -->
<div style="padding-top:5px; padding-bottom:5px;">
	<!-- START BLOCK : list_field -->
	<div><label class="checkbox"><input name="fieldId[]" type="checkbox" value="{field_id}"><strong>{field_caption}</label></div>
    <!-- END BLOCK : list_field -->
</div>
<!-- END BLOCK : list_field_of_form -->
