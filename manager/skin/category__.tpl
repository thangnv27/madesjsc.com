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

        $(function() {

            action_select_type($('.data_type:checked').val());



            if ($('#boxmenufooter input').is(":checked")) {

                $('#colfooter').show();

            } else {

                $('#colfooter').hide();

            }

            $('#boxmenufooter input').change(function() {

                if ($(this).is(":checked")) {

                    $('#colfooter').show();

                } else {

                    $('#colfooter').hide();

                }

            });

			

			if ($('#menuhome input').is(":checked")) {

                $('#iconmenu').show();

            } else {

                $('#iconmenu').hide();

            }

            $('#menuhome input').change(function() {

                if ($(this).is(":checked")) {

                    $('#iconmenu').show();

                } else {

                    $('#iconmenu').hide();

                }

            });

			

			

            if ($('#menubar input').is(":checked")) {

                $('#stylebar').show();

            } else {

                $('#stylebar').hide();

            }

            $('#menubar input').change(function() {

                if ($(this).is(":checked")) {

                    $('#stylebar').show();

                } else {

                    $('#stylebar').hide();

                }

            });

            if ($('#inhome input').is(":checked") && $('.data_type:checked').val() == 'news') {

                $('#homescroll').show();

            } else {

                $('#homescroll').hide();

            }

            $('#left input').change(function() {

                if ($(this).is(":checked") && $('.data_type:checked').val() == 'logo') {

                    $('#logotitleleft').show();

                } else {

                    $('#logotitleleft').hide();

                }

            });
			
			$('#cathome input').change(function() {

                if ($(this).is(":checked") && $('.data_type:checked').val() == 'news') {

                    $('#home_zone').show();

                } else {

                    $('#home_zone').hide();

                }

            });

            $('#inhome input').change(function() {

                if ($(this).is(":checked") && $('.data_type:checked').val() == 'news') {

                    $('#homescroll').show();

                } else {

                    $('#homescroll').hide();

                }

            });

        });



        function action_select_type(data_type) {

            $('#chooselocation li input').attr('disabled', true);

            $('#chooselocation li label').addClass('classdisable');

            if (data_type == 'news') {
                var arr = ["menubar", "menufooter","menuright", "inhome", "menutop", "inright", "boxmenufooter", "menuhome","newsfooter","cathome","mainmenu","menufootercol","chinhsach"];
            }

            if (data_type == 'video') {
                var arr = ["menubar", "menufooter", "menutop","menuright", "boxmenufooter","cathome","inright","menufootercol","chinhsach"];
            }

            if (data_type == 'photo') {
                var arr = ["menubar", "menufooter", "inright", "menutop", "rightslideshow", "boxmenufooter", "menuhome","cathome","inhome","menufootercol","chinhsach"];
            }

            if (data_type == 'faq') {
                var arr = ["menubar", "menufooter", "menutop", "inright", "boxmenufooter", "rightslideshow", "inhome", "menuhome","cathome","menufootercol","chinhsach"];
            }

            if (data_type == 'download') {
                var arr = ["menubar", "menufooter", "menutop", "inright", "boxmenufooter", "rightslideshow", "inhome", "menuhome","cathome","chinhsach"];
            }

            if (data_type == 'product') {
                var arr = ["menubar", "menufooter", "menutop", "inright","menuright", "boxmenufooter", "cathome", "menuhome","showincatpro","cathome","mainmenu","menufootercol","chinhsach"];
            }

            if (data_type == 'info') {
                var arr = ["menubar", "menufooter", "menutop", "boxmenufooter","menuright", "cathome", "menuhome","cathome","mainmenu","menufootercol","chinhsach"];
            }

            if (data_type == 'support') {
                var arr = ["inright"];
            }

            if (data_type == 'logo') {
                var arr = ["slideshow", "logo", "inright", "banner", "boxmenufooter", "rightslideshow", "inhome", "weblink","advhome1","advhome2","logoscrollhome","cathome","partner","chinhsach"];
            }

            if (data_type == 'link') {
                var arr = ["menubar", "menufooter", "menutop", "inright", "boxmenufooter", "menuhome"];

            }

			


            if (data_type == 'contact' || data_type == 'contactinfo' || data_type == 'home' || data_type == 'sitemap' ) {

                var arr = ["menutop", "menubar", "menufooter", "menutop", "boxmenufooter","menuright","mainmenu","chinhsach"];

            }



            if (arr) {

                jQuery.each(arr, function() {

                    $('#' + this + ' label').removeClass('classdisable');

                    $('#' + this + ' input').attr('disabled', false);

                });

            }

            if (data_type == 'product') {

                $('#stypeshow').show();

            } else {

                $('#stypeshow').hide();

            }
			
			
            if ($('#left input').is(":checked") && $('.data_type:checked').val() == 'logo') {

                $('#logotitleleft').show();

            } else {

                $('#logotitleleft').hide();

            }
			
			if($('#cathome input').prop("checked") && $('.data_type:checked').val()=='news'){
				$('#home_zone').show();	
			}else{
				$('#home_zone').hide();		
			}

        }

    </script>
  <form action="{action}" method="post" id="inputform" onSubmit="return check_null();" enctype="multipart/form-data" >
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-bordered tabletdnone">
      <tr>
        <th colspan="2"><i class="icon-pencil"></i>&nbsp;Quản lý {item}</th>
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
        <td><ul class="fr_location borderright-FFF" id="choose_datatype">
            <li class="title">Kiểu dữ liệu</li>
            <div class="divline"></div>
            <li id="news">
              <label class="radio">
                <input type="radio" name="data_type" value="news" class="data_type" {news}/>
                Tin tức</label>
            </li>
            <li id="product">
              <label class="radio">
                <input type="radio" name="data_type" value="product" class="data_type" {product}/>
                Sản phẩm</label>
            </li>
            <li id="info">
              <label class="radio">
                <input type="radio" name="data_type" value="info" class="data_type" {info}/>
                Nội dung</label>
            </li>
            
            <li id="photo">
              <label class="radio">
                <input type="radio" name="data_type" value="photo" class="data_type" {photo}/>
                Gallery</label>
            </li>    

            <!--<li id="download">
              <label class="radio">
                <input type="radio" name="data_type" value="download" class="data_type" {download}/>
                Tài liệu</label>
            </li>    -->
            
            
            <li id="video">
              <label class="radio">
                <input type="radio" name="data_type" value="video" class="data_type" {video}/>
                Video</label>
            </li>

            
            <li id="home">
              <label class="radio">
                <input type="radio" name="data_type" value="home" class="data_type" {home}/>
                Trang chủ</label>
            </li>
            <li id="contact">
              <label class="radio">
                <input type="radio" name="data_type" value="contact" class="data_type" {contact}/>
                Trang liên hệ</label>
            </li>
            <li id="logo">
              <label class="radio">
                <input type="radio" name="data_type" value="logo" class="data_type" {logo}/>
                Logo - Liên kết web</label>
            </li>
            <li id="support">
              <label class="radio">
                <input type="radio" name="data_type" value="support" class="data_type" {support}/>
                Hỗ trợ trực tuyến</label>
            </li> 
            <li id="sitemap">
              <label class="radio">
                <input type="radio" name="data_type" value="sitemap" class="data_type" {sitemap}/>
                Sitemap</label>
            </li>
          
           
           
          </ul>
          <ul class="fr_location borderleft-dddddd" id="chooselocation">
            <li class="title">Vị trí hiển thị</li>
            <div class="divline"></div>
            
            <li id="menutop">
              <label class="checkbox">
                <input name="vitri[menutop]" type="checkbox" value="menutop" {menutop}/>
                Menu top</label>
            </li>
           
            <li id="menubar">
              <label class="checkbox">
                <input name="vitri[menubar]" type="checkbox" value="menubar" {menubar}/>
                Menu ngang</label>
            </li>
            <li id="menufooter">
              <label class="checkbox">
                <input name="vitri[menufooter]" type="checkbox" value="menufooter" {menufooter}/>
                Menu chân trang</label>
            </li>
            <li id="menuright">
              <label class="checkbox">
                <input name="vitri[menuright]" type="checkbox" value="menuright" {menuright}/>
                Menu phải</label></li>
            <li id="mainmenu">
              <label class="checkbox">
                <input name="vitri[mainmenu]" type="checkbox" value="mainmenu" {mainmenu}/>
                Menu chính <em>(Hiển thị khi cuộn trang)</em></label></li>
            <li id="boxmenufooter">
              <label class="checkbox">
                <input name="vitri[boxmenufooter]" type="checkbox" value="boxmenufooter" {boxmenufooter}/>
                Menu cột chân trang</label></li>
            <div id="colfooter" style="padding-left:15px;">
              <label class="radio" style="float:left; margin-right:10px;">
                <input name="footercol" type="radio" value="1" {footercol1}>
                Cột 1</label>
              <label class="radio" style="float:left; margin-right:10px;">
                <input name="footercol" type="radio" value="2" {footercol2}>
                Cột 2</label>
              
              <div class="c"></div>
            </div>	
            <li id="logo">
              <label class="checkbox">
                <input name="vitri[logo]" type="checkbox" value="logo" {logo}/>
                Logo</label>
            </li>
            <li id="banner">
              <label class="checkbox">
                <input name="vitri[banner]" type="checkbox" value="banner" {banner}/>
                Banner</label>
            </li>
            <li id="partner">
              <label class="checkbox">
                <input name="vitri[partner]" type="checkbox" value="partner" {partner}/>
                Đối tác</label> 
            </li>
            <li id="slideshow">
              <label class="checkbox">
                <input name="vitri[slideshow]" type="checkbox" value="slideshow" {slideshow}/>
                Slide show</label>
            </li>
            
            <li id="chinhsach">
              <label class="checkbox">
                <input name="vitri[chinhsach]" type="checkbox" value="chinhsach" {chinhsach}/>
                Chính sách & nội quy chung</label>
            </li>
            <li id="cathome">
              <label class="checkbox">
                <input name="vitri[cathome]" type="checkbox" value="cathome" {cathome}/>
                Hiển trị ở trang chủ</label>
                </li>
            
            <li id="inright">
              <label class="checkbox">
                <input name="vitri[inright]" type="checkbox" value="inright" {inright}/>
                Cột phải</label></li>
            
          </ul></td>
      </tr>
      <tr>
        <td><strong>Nhóm cha</strong></td>
        <td><div id="cls_category" >{parentid}</div></td>
      </tr>
      <tr id="stypeshow" style="display:none;">
        <td><strong>Nhóm thuộc tính</strong></td>
        <td>
        	<div>
            <!-- START BLOCK : list_attr -->
          
          <label class="radio" style="float:left;margin-right:10px;">
            <input name="id_attr" type="radio" value="{id_attr}" {checked}/>
            {attrname}</label>
          
          <!-- END BLOCK : list_attr -->
          </div>
          </td>
      </tr>
      <tr>
        <td><strong>Ảnh</strong></td>
        <td><div id="pic_avatar">{image}</div>
          <input type="file" name="image" />
          <br />
          <div class="input-append">
            <input name="imageurl" type="text" id="imageurl"  style="height:20px; width:290px;" value="{imageurl}"/>
            <button class="btn" type="button" id="browserimage">Chọn ảnh trên server</button>
          </div></td>
      </tr>
      <tr>
        <td><strong>Mô tả</strong></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2">{content}</td>
      </tr>
      <tr>
        <td><strong>Ảnh Slide</strong></td>
        <td><button class="btn btn-info" type="button" id="multi_browser_image">Chọn ảnh trên server</button></td>
      </tr>
      <tr>
        <td colspan="2" id="show_collection_cell"><!-- START BLOCK : collection_cell -->
          
          <div class="collection_cell">
            <div class="image"><a href="{big_image}" class="highslide" onClick="return hs.expand(this)"><img src="{image}"></a></div>
            <input name="image_name[collection_{id}]" type="text" class="txtname name_image" placeholder="Tiêu đề..." value="{name}">
            <div style="padding-left:10px;"><span class="labelorder">Thứ tự</span>
              <input name="image_thu_tu[collection_{id}]" type="text" class="txtorder image_thu_tu" placeholder="Thứ tự..." value="{thu_tu}">
              <a class="btn btn-mini" style="margin-top:2px; margin-left:10px;" onClick="delete_multi_image($(this));

                        return false"><i class="icon-trash"></i>&nbsp;Xóa</a>
              <div style="c"></div>
            </div>
            <input type="hidden" name="collection_image[collection_{id}]" value="{real_image}" class="collection_image">
          </div>
          
          <!-- END BLOCK : collection_cell --></td>
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
        <td style="position:relative"><div class="input-prepend"> <span class="add-on">
            <input name="autourl" id="autourl" type="checkbox" value="1" {autourl}/>
            </span>
            <input class="span2" id="url" name="url" type="text" style="width:572px;" value="{url}">
          </div>
          <div style="font-size:11px; color:#666; font-style:italic">Checked tự động tạo url/Uncheck lấy url trên ô text</div></td>
      </tr>
      <tr>
        <td><strong>Kích hoạt</strong></td>
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
        <td><div onclick="$('#inputform').submit();

            return false" class="btn btn-primary"><i class="icon-ok-circle icon-white"></i>&nbsp;Cập nhật</div>
          <div onclick="window.location = '?page={par_page}&pid={pid}'" class="btn btn-inverse" style="margin-left:10px;"><i class="icon-remove icon-white"></i>&nbsp;Đóng</div></td>
      </tr>
    </table>
  </form>
  <div class="divider1"><span></span></div>
  
  <!-- END BLOCK : AddNew --> 
  
  <!-- START BLOCK : showList -->
  
  <form action="{action}" method="post" id="list_form">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-striped table-hover" id="tablelist">
      <tr>
        <th colspan="7"> <div style="float:left"><i class="icon-list-alt"></i>&nbsp;Danh sách {item}</div>
          <a href="?page={par_page}&code=showAddNew&pid={pid}" style="float:right">
          <div class="btn  btn-mini"><i class="icon-plus-sign"></i>&nbsp;Thêm mới {item}</div>
          </a> </th>
      </tr>
      <tr class="title">
        <td>Tiêu đề</td>
        <td width="150" class="center">Vị trí<br />
          {pos}</td>
        <td width="120" class="center">Kiểu dữ liệu<br />
          {dtype}</td>
        <td width="60" class="center">Kích hoạt</td>
        <td width="60" class="center">Thứ tự</td>
        <td width="30">Sửa</td>
        <td width="30">Xóa</td>
      </tr>
      
      <!-- START BLOCK : listCate -->
      
      <tr>
        <td class="showurl">
        	<strong class="list_item_name"><a href="{link}">{name}</a></strong>
            <div style="font-size:11px; color:#666; display:none" class="urlview">{url}</div>
        </td>
        <td class="center">{vitri}</td>
        <td class="center">{datatype}</td>
        <td class="center"><input type="checkbox" name="active" value="1" data-active="{id}" {active} class="changeactive"/></td>
        <td><input type="text" name="thu_tu[{id}]" class="txtorder" value="{thu_tu}"/></td>
        <td><a href="{link_edit}" class="btn padingleftright4"><i class="icon-wrench"></i></a></td>
        <td><a href="{link_delete}" class="btn padingleftright4 trash_item"><i class="icon-trash"></i></a></td>
      </tr>
      
      <!-- END BLOCK : listCate -->
      
      <tr class="title">
        <td colspan="3">Xóa tất cả mục đã chọn</td>
        <td colspan="2" ><a href="#" onclick="$('#list_form').submit();

            return false" class="btn btn-inverse" style="margin-left:30px">Cập nhật</a></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
  </form>
  <script>
  	$(function(){
		$('.showurl').hover(function(){
			$('.urlview',this).delay(300).show();
		},function(){
			$('.urlview',this).stop().hide();	
		});
	})
  </script>
  <!-- END BLOCK : showList --> 
  
</div>
<div id="divremovea"></div>
<script>

    $(function() {

        /// delete image

        $('#trash_image').click(function() {

            $('#trash_image').fadeTo('fast', 0.3)

            show_mes('Đang thực hiện !');

            $("#divremovea").load($('#trash_image').attr('href'), function(response, status, xhr) {

                if (status == "error") {

                    var msg = "Sorry but there was an error: ";

                    alert(msg + xhr.status + " " + xhr.statusText);

                }

                if (status == 'success') {

                    $('#avatar').remove();

                    $('#trash_image').remove();

                    show_mes('Đã xóa ảnh xong !');

                }

            });

            return false;

        });



        // delete record

        $('.trash_item').click(function() {

            if (confirm('Bạn có thật sự muốn xóa không ?')) {

                obj = $(this);

                show_mes('Đang thực hiện !');

                obj.parent().parent().fadeTo('fast', 0.3);

                $("#divremovea").load('index4.php' + obj.attr('href'), function(response, status, xhr) {

                    if (status == "error") {

                        var msg = "Sorry but there was an error: ";

                        alert(msg + xhr.status + " " + xhr.statusText);

                    }

                    if (status == 'success') {

                        obj.parent().parent().remove();

                        show_mes('Đã xóa xong');

                    }

                });

                return false;

            } else {

                return false;

                show_mes('Đã hủy lệnh !');

            }



        });





        // go to category

        $('#parentid').change(function() {

            window.location = '?page={par_page}&pid=' + $(this).val();

        });



        // change active

        $('.changeactive').change(function() {

            show_mes('Đang thực hiện !');

            var obj = $(this);

            var active = 0;

            var mes = 'Đã bỏ kích hoạt !';

            if (obj.is(":checked")) {

                active = 1

                mes = "Đã kích hoạt !";

            }

            obj.fadeTo('fast', 0.3)

            $("#divremovea").load('index4.php?page=action_ajax&code=change_active&table={table}&id_item={id_item}&id=' + obj.attr('data-active') + '&active=' + active, function(response, status, xhr) {

                if (status == "error") {

                    var msg = "Sorry but there was an error: ";

                    alert(msg + xhr.status + " " + xhr.statusText);

                }

                if (status == 'success') {

                    show_mes(mes);

                    obj.fadeTo('fast', 1);

                }

            });

        });

    });



    $(function() {



        var xxx = 1;

        $('#multi_browser_image').click(function() {

            var fm = $('<div/>').dialogelfinder({

                url: 'browser/php/connector.php',

                lang: 'vi',

                width: 840,

                destroyOnClose: true,

                getFileCallback: function(files, fm) {

                    xxx++;



                    $('<div class="collection_cell"><div class="image"><a href="' + files.url + '" class="highslide" onclick="return hs.expand(this)"><img src="image.php?w=192&h=132&src=' + files.url + '"  /></a></div> <input name="image_name[' + xxx + ']" type="text" class="txtname name_image" placeholder="Tiêu đề..."><div style="padding-left:10px;"><span class="labelorder" >Thứ tự</span><input name="image_thu_tu[' + xxx + ']" type="text" class="txtorder image_thu_tu" placeholder="Thứ tự..."><a class="btn btn-mini" style="margin-top:2px; margin-left:10px;" onclick="delete_multi_image($(this)); return false"><i class="icon-trash"></i>&nbsp;Xóa</a><div style="c"></div></div><input type="hidden" name="collection_image[' + xxx + ']" value="' + files.url + '" class="collection_image" /></div>').appendTo('#show_collection_cell');

                },

                commandsOptions: {

                    getfile: {

                        oncomplete: 'close',

                        folders: true

                    }

                }

            }).dialogelfinder('instance');

        });



    });



function delete_multi_image(obj){

	if(confirm("Bạn muốn xóa ảnh này?")){

		obj.parent().parent().remove();

	}else{

		return false;	

	}

}





</script>