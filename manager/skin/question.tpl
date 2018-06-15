<div class="c5"></div>
<div class="breadLine">
    <ul class="breadcrumb">
        <li><a href="?"><i class="icon-home"></i></a></li>
      	<li><a href="?page={par_page}">Nhóm câu hỏi</a></li>
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
      <tr class="title">
        <td width="150"><strong>Câu hỏi</strong></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2">{question}</td>
      </tr>
      <tr>
        <td><strong>Nhóm câu hỏi</strong></td>
        <td>
        <select name="catquestion" id="catquestion">
        	{catQuestion}
        </select>
        </td>
      </tr>
      <tr>
        <td><strong>Thứ tự</strong></td>
        <td><input type="text" name="thu_tu1" id="thu_tu" class="txtorder" value="{thu_tu1}" /></td>
      </tr>
      <tr>
        <td><strong>Kích hoạt</strong></td>
        <td><input type="checkbox" name="active" id="active" value="1" {active} /></td>
      </tr>
      <tr class="title">
        <td colspan="2"><strong>Đáp án</strong></td>
      </tr>
      <!-- START BLOCK : lstAnswer -->
      <tr>
        <td colspan="2"><div class="input-prepend">
          <span class="add-on">Đáp án</span>
          <input class="span2" name="answer[{n}]" type="text" style="width:320px;" value="{answer}">
          <span class="add-on marginleft5">Điểm</span>
          <input class="span2" type="text" style="width:70px;" name="point[{n}]" value="{point}">
          <span class="add-on marginleft5">Thứ tự</span>
          <input class="span2" type="text" style="width:40px;" name="thu_tu[{n}]" value="{thu_tu}">
          <span class="add-on marginleft5"><label>Đáp án đúng&nbsp;<input name="istrue[{n}]"  type="checkbox" value="1" {istrue} /></label></span>
          <span class="add-on marginleft5 cursorpointer" onclick="removeRow($(this))"><i class="icon-trash"></i></span>
        </div></td>
      </tr>
      <!-- END BLOCK : lstAnswer -->
      <tr id="addAn">
        <td><div class="btn" id="addAnswer" rel="{totalanswer}"><i class="icon-plus-sign"></i>&nbsp;Thêm đáp án</div></td>
        <td>
        	&nbsp;
            <script>
			$(function(){
            	$('#addAnswer').click(function(){
					var i = parseInt($(this).attr('rel'));
					var n = i + 1;
					$(this).attr('rel',n);
					$('<tr><td colspan="2"><div class="input-prepend"> <span class="add-on">Đáp án</span><input class="span2" name="answer[' + n + ']" type="text" style="width:320px;" value=""><span class="add-on marginleft5">Điểm</span> <input class="span2" type="text" style="width:70px;" name="point[' + n + ']" value="0"><span class="add-on marginleft5">Thứ tự</span><input class="span2" type="text" style="width:40px;" name="thu_tu[' + n + ']" value="' + n + '"><span class="add-on marginleft5"><label>Đáp án đúng&nbsp;<input name="istrue[' + n + ']"  type="checkbox" value="1" /></label></span> <span class="add-on marginleft5 cursorpointer" onclick="removeRow($(this))"><i class="icon-trash"></i></span> </div></td></tr>').insertBefore("#addAn");
				});	
			});
			function removeRow(obj){
				obj.parent().parent().parent().remove();
			}
            </script>
        </td>
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
        <div style="float:left"><i class="icon-list-alt icon-white"></i>&nbsp;Danh sách câu hỏi</div>
        <a href="?page={par_page}&code=showAddNew&pid={pid}" style="float:right">
        <div class="btn  btn-mini"><i class="icon-plus-sign"></i>&nbsp;Thêm mới nhóm câu hỏi</div></a>
    </th>
  </tr>
  <tr class="search_box nonehover">
    <td colspan="7">
    <div class="form-search" style="margin:0px;">
      <div class="input-append">
        <input type="text" id="keyword" name="keyword" class="search-query" style="height:20px;" placeholder="Từ khóa cần tìm...">
        <button type="submit" class="btn" id="btnSearch">Tìm</button>
      </div>
      <select id="catq" name="catquestion">
	      	<option value="0">Tất cả</option>
	      	{catQuestion}
      </select>
    </div>
    </td>
  </tr>
  <tr class="title">
    <td width="16"><input type="checkbox" name="checkbox" id="checkbox" class="cat_check" data-check="cat_check" onClick="check_all(this)" /></td>
    <td>Tên nhóm</td>
    <td width="60" style="text-align:center">Kích hoạt</td>
    <td width="60" style="text-align:center">Thứ tự</td>
    <td width="30" align="center">Sửa</td>
    <td width="30" align="center">Xóa</td>
  </tr>
  <!-- START BLOCK : list -->
  <tr>
    <td width="16"><input type="checkbox" name="delmulti[{id}]" id="checkbox" class="cat_check" value="{id}" /></td>
    <td>
      <div class="list_item_name"><a href="{link_edit}">{question} ({point})</a></div>
      
    </td>
    <td style="text-align:center"><input type="checkbox" name="active" value="1" data-active="{id}" {active} class="changeactive"/></td>
    <td><input type="text" name="thu_tu[{id}]" class="txtorder" value="{thu_tu}"/></td>
    <td><a href="{link_edit}" class="btn padingleftright4"><i class="icon-wrench"></i></a></td>
    <td><a href="{link_delete}" class="trash_item btn padingleftright4"><i class="icon-trash"></i></a></td>
  </tr>
  <!-- END BLOCK : list -->

 <tr class="title">
    <td colspan="2"><a href="?page={par_page}&code=deletemulti" id="delmultiitem">Xóa tất cả mục đã chọn</a></td>
    <td colspan="2"><div class="btn btn-inverse" onclick="$('#list_form').submit();" style="margin-left:30px">Cập nhật</div></td>
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
		
		$(function(){
			$('#catq').change(function(){
				window.location='?page={par_page}&pid=' + $(this).val();
			});
		});
		
	});
	
	$(function (){
		$('#btnSearch').click(function(){
				$('#list_form').attr('action','?page={par_page}&pid={pid}');
				$('#list_form').submit();
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

