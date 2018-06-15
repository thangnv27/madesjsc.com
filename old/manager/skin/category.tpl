
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
<script>
	$(function(){
		action_select_type($('.data_type:checked').val());
		if($('#menufooter input').is(":checked")){
			$('#colfooter').show();
		}else{
			$('#colfooter').hide();	
		}
		$('#menufooter input').change(function(){
			if($(this).is(":checked"))	{
				$('#colfooter').show();
			}else{
				$('#colfooter').hide();	
			}
		});
		
		if($('#left input').is(":checked") && $('.data_type:checked').val() == 'logo'){
			$('#logotitleleft').show();
		}else{
			$('#logotitleleft').hide();	
		}
		if($('#inhome input').is(":checked") && $('.data_type:checked').val() == 'logo'){
			$('#logotitlehome').show();
		}else{
			$('#logotitlehome').hide();	
		}
		$('#left input').change(function(){
			if($(this).is(":checked") && $('.data_type:checked').val() == 'logo'){
				$('#logotitleleft').show();
			}else {
				$('#logotitleleft').hide();	
			}
		});
		$('#inhome input').change(function(){
			if($(this).is(":checked") && $('.data_type:checked').val() == 'logo'){
				$('#logotitlehome').show();
			}else {
				$('#logotitlehome').hide();	
			}
		});
	});

	function action_select_type(data_type){
		$('#chooselocation li input').attr('disabled',true);							
		$('#chooselocation li label').addClass('classdisable');
		
		if(data_type=='news'){
			var arr=["menubar","menufooter","menuleft","inhome","menutop","left"];
		}
		
		if(data_type=='product'){
			var arr=["menubar","menuleft","menufooter","menutop","inhome","scroll","left"];
		}
		if(data_type=='info'){
			var arr=["menubar","menufooter","menutop","inhome"];
		}
		if(data_type=='support'){
			var arr=["left"];
		}
		if(data_type=='logo'){
			var arr=["menubar","inhome","menufooter","menutop","slideshow","logo","left"];
		}
		if(data_type=='link'){
			var arr=["menubar","menufooter","menutop"];
		}
		if(data_type=='contact' || data_type=='home' || data_type=='photo' || data_type=='sitemap'){
			var arr=["intop","menubar","menufooter","menutop"];
		}
	
		if(arr){
			jQuery.each(arr, function() {							  
			  $('#'+this + ' label').removeClass('classdisable');
			  $('#'+this+' input').attr('disabled',false);
			});
		}
		if(data_type == 'product'){
			$('#stypeshow').show();	
		}else{
			$('#stypeshow').hide();		
		}
		
		if($('#left input').is(":checked") && $('.data_type:checked').val() == 'logo'){
			$('#logotitleleft').show();
		}else{
			$('#logotitleleft').hide();	
		}
  	}
	</script>
<form action="{action}" method="post" id="inputform" onSubmit="return check_null();" enctype="multipart/form-data" >
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-bordered tabletdnone">
  <tr>
    <th colspan="2"><i class="icon-pencil icon-white"></i>&nbsp;Quản lý {item}</th>
   </tr>
  <tr>
    <td width="150"><strong>Tiêu đề</strong></td>
    <td><input type="text" name="name" id="name" class="txtform100 notNull" data-alert="Bạn cần nhập vào tiêu đề {item}" value="{name}"/></td>
  </tr>
  <tr>
    <td><strong>Title</strong></td>
    <td><input type="text" name="title" id="title" class="txtform100" value="{title}"/></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td>
        <ul class="fr_location borderright-FFF" id="choose_datatype">
          	<li class="title">Kiểu dữ liệu</li>
            <div class="divline"></div>
           	<li id="product"><label class="radio"><input type="radio" name="data_type" value="product" class="data_type" {product}/>Sản phẩm</label></li>
           	<li id="news"><label class="radio"><input type="radio" name="data_type" value="news" class="data_type" {news}/>Tin tức</label></li>
           
            <li id="info"><label class="radio"><input type="radio" name="data_type" value="info" class="data_type" {info}/>Nội dung</label></li>
            <li id="home"><label class="radio"><input type="radio" name="data_type" value="home" class="data_type" {home}/>Trang chủ</label></li>
            <li id="contact"><label class="radio"><input type="radio" name="data_type" value="contact" class="data_type" {contact}/>Trang liên hệ</label></li>
            <li id="logo"><label class="radio"><input type="radio" name="data_type" value="logo" class="data_type" {logo}/>Logo</label></li>
             <li id="link"><label class="radio"><input type="radio" name="data_type" value="link" class="data_type" {link}/>link</label></li>
           
          
      </ul>
      <ul class="fr_location borderleft-dddddd" id="chooselocation">
            <li class="title">Vị trí hiển thị</li>
            <div class="divline"></div>
            <li id="menutop"><label class="checkbox"><input name="vitri[menutop]" type="checkbox" value="menutop" {menutop}/>Menu top</label></li>
            <li id="menubar"><label class="checkbox"><input name="vitri[menubar]" type="checkbox" value="menubar" {menubar}/>Menu bar</label></li>
            <li id="menuleft"><label class="checkbox"><input name="vitri[menuleft]" type="checkbox" value="menuleft" {menuleft}/>Menu left</label></li>
            <li id="menufooter"><label class="checkbox"><input name="vitri[menufooter]" type="checkbox" value="menufooter" {menufooter}/>Menu footer</label></li>
            <div id="colfooter" style="padding-left:15px;">
            	<label style="float:left; margin-right:5px;"><input name="colfooter" type="radio" value="1" {colfooter1}/>&nbsp;Cột 1</label>
                <label style="float:left; margin-right:5px;"><input name="colfooter" type="radio" value="2" {colfooter2}/>&nbsp;Cột 2</label>
                <label style="float:left"><input name="colfooter" type="radio" value="3" {colfooter3}/>&nbsp;Cột 3</label>
                <div class="c"></div>
            </div>
            <li id="slideshow"><label class="checkbox"><input name="vitri[slideshow]" type="checkbox" value="slideshow" {slideshow}/>Slideshow</label></li>
            <li id="logo"><label class="checkbox"><input name="vitri[logo]" type="checkbox" value="logo" {logo1}/>Logo</label></li>
            <li id="inhome"><label class="checkbox"><input name="vitri[inhome]" type="checkbox" value="inhome" {inhome}/>
            Trang chủ</label></li>
            <div id="logotitlehome" style="padding-left:15px;">
            	<label style="float:left; margin-right:5px;"><input name="logotitlehome" type="radio" value="1" {logotitlehome1}/>&nbsp;Hiển thị tên nhóm</label>
                <label style="float:left;"><input name="logotitlehome" type="radio" value="0" {logotitlehome0}/>&nbsp;Không hiển thị tên nhóm</label>
                
                <div class="c"></div>
            </div>
            <li id="left"><label class="checkbox"><input name="vitri[left]" type="checkbox" value="left" {left}/>Cột trái</label>
            </li>
           <div id="logotitleleft" style="padding-left:15px;">
            	<label style="float:left; margin-right:5px;"><input name="logotitleleft" type="radio" value="1" {logotitleleft1}/>&nbsp;Hiển thị tên nhóm</label>
                <label style="float:left;"><input name="logotitleleft" type="radio" value="0" {logotitleleft0}/>&nbsp;Không hiển thị tên nhóm</label>
                
                <div class="c"></div>
            </div>
      </ul>
    </td>
  </tr>
  <tr>
    <td><strong>Nhóm cha</strong></td>
    <td>
    	<div id="cls_category" >{parentid}</div></td>
  </tr>
  <tr id="stypeshow" style="display:none;">
    <td><strong>Nhóm thuộc tính</strong></td>
    <td>
    <!-- START BLOCK : list_attr -->
    	<label class="radio" style="float:left;margin-right:10px;"><input name="id_attr" type="radio" value="{id_attr}" {checked}/>{attrname}</label>
    <!-- END BLOCK : list_attr -->    
    </td>
  </tr>
  <tr>
    <td><strong>Ảnh</strong></td>
    <td>
    	{image}<input type="file" name="image" /><br />
            <div class="input-append">
			  <input name="imageurl1" type="text" id="imageurl1"  style="height:20px; width:290px;" value="{imageurl}"/>
			  <button class="btn" type="button" id="browserimage">Chọn ảnh trên server</button>
			</div>
    </td>
   </tr>
  <tr>
    <td><strong>Mô tả</strong></td>
    <td>&nbsp;</td>
   </tr>
  <tr>
    <td colspan="2">{content}</td>
    </tr>
  <tr>
    <td><strong>Description</strong></td>
    <td><textarea name="description" id="description" class="txtareakeyword-description">{description}</textarea></td>
   </tr>
  <tr>
    <td><strong>Keywords</strong></td>
    <td><textarea name="keywords" class="txtareakeyword-description">{keywords}</textarea></td>
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
    <td><strong>Thứ tự</strong></td>
    <td><input type="checkbox" name="active" id="active" value="1" {active}/></td>
   </tr>
  <tr>
    <td><strong>Thứ tự</strong></td>
    <td><input type="text" name="thu_tu" id="thu_tu" class="txtorder" value="{thu_tu}" /></td>
   </tr>
  <tr>
    <td><strong>Shortcut ra trang chủ quản trị</strong></td>
    <td><input type="checkbox" name="shortinhome" id="shortinhome" value="1" {shortinhome}/></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><div onclick="$('#inputform').submit(); return false" class="btn btn-primary"><i class="icon-ok-circle icon-white"></i>&nbsp;Cập nhật</div><div onclick="window.location='?page={par_page}&pid={pid}'" class="btn btn-inverse" style="margin-left:10px;"><i class="icon-remove icon-white"></i>&nbsp;Đóng</div></td>
   </tr>
</table>
</form>
<div class="divider1"><span></span></div>
<!-- END BLOCK : AddNew -->

<!-- START BLOCK : showList -->
<form action="{action}" method="post" id="list_form">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-striped table-hover" id="tablelist">
    <tr>
    <th colspan="8">
    	<div style="float:left"><i class="icon-list-alt icon-white"></i>&nbsp;Danh sách {item}</div>
        <a href="?page={par_page}&code=showAddNew&pid={pid}" style="float:right"><div class="btn  btn-mini"><i class="icon-plus-sign"></i>&nbsp;Thêm mới {item}</div></a>
    </th>
  </tr>
  <tr class="title">
    <td width="16"><input type="checkbox" name="checkbox" id="checkbox" class="cat_check" data-check="cat_check" onclick="check_all(this)" /></td>
    <td>Tiêu đề</td>
    <td width="120" class="center">Vị trí</td>
    <td width="100" class="center">Kiểu dữ liệu</td>
    <td width="60" class="center">Kích hoạt</td>
    <td width="60" class="center">Thứ tự</td>
    <td width="30">Sửa</td>
    <td width="30">Xóa</td>
  </tr>
  <!-- START BLOCK : listCate -->
  <tr>
    <td width="16"><input type="checkbox" name="checkbox" id="checkbox" class="cat_check" /></td>
    <td><strong class="list_item_name"><a href="{link}">{name}</a></strong></td>
    <td class="center">{vitri}</td>
    <td class="center">{datatype}</td>
    <td class="center"><input type="checkbox" name="active" value="1" data-active="{id}" {active} class="changeactive"/></td>
    <td><input type="text" name="thu_tu[{id}]" class="txtorder" value="{thu_tu}"/></td>
    <td><a href="{link_edit}" class="btn padingleftright4"><i class="icon-wrench"></i></a></td>
    <td><a href="{link_delete}" class="btn padingleftright4 trash_item"><i class="icon-trash"></i></a></td>
  </tr>
  <!-- END BLOCK : listCate -->
  <tr class="title">
    <td width="16"><input type="checkbox" name="checkbox" id="checkbox" class="cat_check" onclick="check_all($(this))"/></td>
    <td colspan="3">Xóa tất cả mục đã chọn</td>
    
    <td colspan="2" ><a href="#" onclick="$('#list_form').submit(); return false" class="btn btn-inverse" style="margin-left:30px">Cập nhật</a></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
 
</table>
</form>
<!-- END BLOCK : showList -->
</div>
<div id="divremovea"></div>
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