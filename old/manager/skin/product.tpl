<link rel="stylesheet" type="text/css" href="css/product.css"/>
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
        <td width="150"><strong>Tiêu đề</strong></td>
        <td><input type="text" name="name" class="txtform100 notNull" value="{name}" data-alert="Bạn cần nhập vào tiêu đề {item}"/></td>
      </tr>
      <tr>
        <td><strong>Title</strong></td>
        <td><input type="text" name="title" id="title" class="txtform100" value="{title}" /></td>
      </tr>
      <tr>
        <td><strong>Mã</strong></td>
        <td><input type="text" name="ma" id="ma" class="txtform100" style="width:200px;" value="{ma}" /></td>
      </tr>
      <tr>
        <td><strong>Nhóm cha</strong></td>
        <td>{parentid}</td>
      </tr>
      <tr>
        <td><strong>Nhóm phụ</strong></td>
        <td>
        <select name="groupcat[]" multiple="multiple" style="width:300px; height:200px;">
        	{parentid1}
        </select>
        </td>
      </tr>
      <tr>
        <td><strong>Ảnh</strong></td>
        <td>
        	<div id="pic_avatar">{image}</div><input type="file" name="image" /><br />
            <div class="input-append">
			  <input name="imageurl" type="text" id="imageurl"  style="height:20px; width:290px;" value="{imageurl}"/>
			  <button class="btn" type="button" id="browserimage">Chọn ảnh trên server</button>
			</div>
            
        </td>
      </tr>
      <tr>
        <td valign="top"><strong>Giá</strong></td>
        <td><input type="text" name="price" id="price" class="txtform100" value="{price}" style="width:100px;" /> Đơn vị <input type="text" name="don_vi" id="don_vi" class="txtform100" value="{don_vi}" style="width:100px;" /></td>
      </tr>
      <tr>
        <td valign="top"><strong>Giá khuyến mại</strong></td>
        <td><input type="text" name="pricekm" id="pricekm" class="txtform100" value="{pricekm}" style="width:100px;" /></td>
      </tr>
      <tr>
        <td colspan="2" valign="top" id="loadAttr">&nbsp;</td>
      </tr>
      <tr>
        <td valign="top"><strong>Mô tả</strong></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" valign="top">{intro}</td>
      </tr>
      <tr>
        <td valign="top"><strong>Chi tiết</strong></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2">
          	<div>{content}</div>
            
        </td>
      </tr>
     <tr>
        <td colspan="2" valign="top"><input type="text" name="tab2" class="txtform100 notNull" style="width:200px;" value="{tab2}" placeholder="Tab 2 (Bạn cần biết)" /></td>
      </tr>
      <tr>
        <td colspan="2">
          	<div>{tab2content}</div>
            
        </td>
      </tr>
      <tr>
        <td colspan="2" valign="top"><input type="text" name="tab3" class="txtform100 notNull" style="width:200px;" value="{tab3}" placeholder="Tab 3 (Videos)" /></td>
      </tr>
      <tr>
        <td colspan="2">
          	<div>{tab3content}</div>
            
        </td>
      </tr>
      <tr>
        <td><strong>Phụ kiện tương thích</strong></td>
        <td>&nbsp;</td>
      </tr>
       <tr>
        <td colspan="2">
          <div style="width:758px;">
          		<div id="selectedlist">
                	<div class="title">Danh sách phụ kiện tương thích</div>
                	<ul id="lstSeleted">
                    	<!-- START BLOCK : phukien -->
                        <li id="slt_{phukienid}"><input type="hidden" name="phukien[{phukienid}]" value="3"><div class="listname">{phukienname}</div><div class="icondelete"><a onclick="deletephukien($(this)); return false" href="" class="icon-trash"></a></div><div class="c"></div></li>
                        <!-- END BLOCK : phukien -->
                       
                    </ul>
                </div>
                <div id="selectlist">
                	<div class="title">
                    	<div style="float:left; width:175px;">Chọn phụ kiện tương thích</div>
                        <div style="float:right; width:200px;">
                        	{catphukien}
                        </div>
                        <div class="c"></div>
                    </div>
                	<ul id="lstPhuKien">
                    	
                    </ul>
                </div>
          </div>
          <script language="javascript">
		  	$(function(){
		  		$("#lstPhuKien").text('đang tải...')
          		$("#lstPhuKien").load("index4.php?page=listtuongthich", function(response, status, xhr) {
				  if (status == "error") { 
				  }
				});
				
				$('#listcatphukien').change(function(){
					$("#lstPhuKien").text('Đang tải...');
					$("#lstPhuKien").load("index4.php?page=listtuongthich&idc=" + $(this).val(), function(response, status, xhr) {
					  if (status == "error") { 
					  }
					});
				});
				
			});
          </script>
        </td>
      </tr>
      <tr>
        <td><strong>Description</strong></td>
        <td><textarea name="description" class="txtareakeyword-description">{description}</textarea></td>
      </tr>
      <tr>
        <td><strong>Keywords</strong></td>
        <td><textarea name="keywords" class="txtareakeyword-description">{keywords}</textarea></td>
      </tr>
      <tr>
        <td><strong>Ngày đăng </strong></td>
        <td style="position:relative"><input type="text" name="ngay_dang" id="ngay_dang" style="width:100px;" value="{ngay_dang}" /></td>
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
        <td><strong>Kích hoạt</strong></td>
        <td><input type="checkbox" name="active" id="active" value="1" {active} /></td>
      </tr>
      <tr>
        <td><strong>Thứ tự</strong></td>
        <td><input type="text" name="thu_tu" id="thu_tu" class="txtorder" value="{thu_tu}" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><a class="btn btn-primary" onclick="$('#inputform').submit(); return false"><i class="icon-ok-circle icon-white"></i>&nbsp;Cập nhật</a><div onclick="window.location='?page={par_page}&pid={pid}'" class="btn btn-inverse" style="margin-left:10px;"><i class="icon-remove icon-white"></i>&nbsp;Đóng</div></td>
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
$(function(){
	$('#divremovea').html(CKEDITOR.instances.content.getData()) ;
	$('#divremovea img').each(function(){
		$('#load').append('<div class="cell_multi_upload"><img src="{dir_path}/manager/image.php?w=130&h=90&src=' + $(this).attr('src') + '" /><div class="tool"><a href="#" onclick="insertimage(\'' + $(this).attr('src') + '\');return false">Chèn</a> | <a href="#" class="a_deleteimage" onclick="deleteimage(\'' + $(this).attr('src') + '\',\'' + $(this).attr('src') + '\',$(this));return false">Xóa</a></div></div>');
	});
	
});

function get_image_url(){
	var n = 0;
	$('#load .cell_multi_upload').each(function(){
		n++;
	});
	$('#divremovea').html(CKEDITOR.instances.content.getData()) ;
	$('#divremovea img').each(function(){
		n++;
		 $('#load').append('<div class="cell_multi_upload" id="uploaded_file_' + n + '"><div class="progress progress-striped active"><div class="bar" style="width: 100%;"></div></div></div>');
		$("#uploaded_file_" + n ).load("index4.php?page=action_ajax&code=uploadimageurl1&url=" + $(this).attr('src'), function(response, status, xhr) {
		  if (status == "error") {
			    var msg = "Sorry but there was an error: ";
			    $("#error").html(msg + xhr.status + " " + xhr.statusText);
		  }
		  if (status == "success") {
			  
		  }
		});
	});	
}

function insert_image_default(url){
	$('#imageurl').attr('value',url);
	$('#pic_avatar').html('<img src="image.php?w=150&src=' + url + '" class="img-polaroid marginright5" align="left" id="avatar" />');
}
</script>

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
        <input type="text" class=" search-query" style="height:20px;" name="keyword" id="keyword" placeholder="Từ khóa cần tìm...">
        <button type="submit" class="btn" id="btnSearch">Tìm</button>
      </div>
      {parentid}
    </div>
    </td>
  </tr>
  <tr class="title">
    <td width="16"><input type="checkbox" name="checkbox" id="checkbox" class="cat_check" data-check="cat_check" onclick="check_all(this)" /></td>
    <td>Tiêu đề</td>
    <td width="130" align="center" class="center">Danh mục</td>
    <td width="60" align="center" class="center">Kích hoạt</td>
    <td width="60" align="center" class="center">Thứ tự</td>
    <td width="30" align="center">Sửa</td>
    <td width="30" align="center">Xóa</td>
  </tr>
  <!-- START BLOCK : list -->
  <tr>
    <td width="16"><input type="checkbox" name="delmulti[{id}]" id="checkbox" class="cat_check" value="{id}" /></td>
    <td>
        <a href="{link_edit}">{image}</a><div class="list_item_name"><a href="{link_edit}">{name}</a></div>
        <div class="info_item"><strong>Người đăng:</strong> {user_name} [{username}] - <strong>Ngày:</strong> {createdate}</div>
        <div class="info_item"><strong>Nhóm phụ:</strong> [{groupcat}]</div>
        <div class="info_item"><strong>Url:</strong> <a href="{url}" target="_blank">{url}</a></div>
    </td>
    <td align="center" class="center" valign="middle"><a href="{linkcat}">{categoryname}</a></td>
    <td class="center"><input type="checkbox" name="active" value="1" data-active="{id}" {active} class="changeactive"/></td>
    <td><input type="text" name="thu_tu[{id}]" class="txtorder" value="{thu_tu}"/></td>
    <td><a href="{link_edit}" class="btn padingleftright4"><i class="icon-wrench"></i></a></td>
    <td><a href="{link_delete}" class="trash_item btn padingleftright4"><i class="icon-trash"></i></a></td>
  </tr>
  <!-- END BLOCK : list -->

  <tr class="title">
    <td width="16"><input type="checkbox" name="checkbox" id="checkbox" class="cat_check" onclick="check_all($(this))"/></td>
    <td><a href="?page={par_page}&code=deletemulti" id="delmultiitem">Xóa tất cả mục đã chọn</a></td>
    <td colspan="3"><div class="btn btn-inverse" onclick="$('#list_form').submit();" style="margin-left:30px">Cập nhật</div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
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

<script src="js/jQuery-File-Upload/js/vendor/jquery.ui.widget.js"></script>
<script src="js/jQuery-File-Upload/js/jquery.iframe-transport.js"></script>
<script src="js/jQuery-File-Upload/js/jquery.fileupload.js"></script>
<script>
$(function () {
    'use strict';
    var url = window.location.hostname ===  'js/jQuery-File-Upload/server/php/';
    $('#fileupload').fileupload({
        url: '/manager/js/jQuery-File-Upload/server/php/index.php',
        dataType: 'json',
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
               // $('<div/>').text(file.name).appendTo('#files');
				$('#load').append('<div class="cell_multi_upload"><img src="image.php?w=130&h=90&src={imagedir}' + file.url + '" /><div class="tool"><a href="#" onclick="insertimage(\'{imagedir}' + file.url + '\');return false">Chèn</a> | <a href="#" class="a_deleteimage" onclick="deleteimage(\'' + file.url + '\',\'' + file.thumbnailUrl + '\',$(this));return false">Xóa</a></div></div>');
			
            });
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .bar').css(
                'width',
                progress + '%'
            ).text(progress + '%');
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
		
	
	$('#otherimagepro').fileupload({
        url: '/manager/js/jQuery-File-Upload/server/php/index.php',
        dataType: 'json',
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
               // $('<div/>').text(file.name).appendTo('#files');
				$('#loadimage').append('<div class="cell_multi_upload"><img src="image.php?w=130&h=90&src={imagedir}' + file.url + '" /><div class="tool"><a href="#" onclick="insertimage(\'{imagedir}' + file.url + '\');return false">Chèn</a> | <a href="#" class="a_deleteimage" onclick="deleteotherimage(\'' + file.url + '\',\'' + file.thumbnailUrl + '\',$(this));return false">Xóa</a></div><input type="hidden" name="otherimage[]" value="'+  file.url +'" /></div>');
			
            });
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#status .bar').css(
                'width',
                progress + '%'
            ).text(progress + '%');
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
	
	
});

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
function deleteotherimage(url,id,obj){
	obj.parent().parent().fadeTo('fast',0.3);
	$("#divremovea").load('index4.php?page=action_ajax&code=deleteotherimageurl&image=' + url + '&id=' + id, function(response, status, xhr) {
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

$(function (){
	$('#btnSearch').click(function(){
			$('#list_form').attr('action','?page={par_page}&pid={pid}');
			$('#list_form').submit();
	});
		
	$('#idc').change(function(){
		$("#loadAttr").text('Đang tải...');
		$("#loadAttr").load("index4.php?page=excu_attr&code=loadAttr&idpro={id}&id=" + $(this).val(), function(response, status, xhr) {
		  if (status == "error") {
		  		
		  }
		});	  
	});
	$("#loadAttr").load("index4.php?page=excu_attr&code=loadAttr&idpro={id}&id={pid}", function(response, status, xhr) {
	  if (status == "error") {
	  		
	  }
	});
});



</script>