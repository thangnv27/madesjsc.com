<link rel="stylesheet" type="text/css" href="css/product.css"/>
<link rel="stylesheet" type="text/css" href="css/evol.colorpicker.min.css"/>
<script src="js/evol.colorpicker.min.js"></script>
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
        <th colspan="2"><i class="icon-pencil icon-white"></i>&nbsp;Thêm/Sửa sản phẩm</th>
      </tr>
      <tr>
        <td width="150"><strong>Tiêu đề</strong></td>
        <td><input type="text" name="name" class="txtform100 notNull" value="{name}" data-alert="Bạn cần nhập vào tiêu đề {item}"/></td>
      </tr>
      <tr>
        <td><strong>Title</strong></td>
        <td><input type="text" name="title" id="title" class="txtform100" value="{title}" /></td>
      </tr>
     <!-- <tr>
        <td><strong>Mã</strong></td>
        <td><input type="text" name="ma" id="ma" class="txtform100" style="width:200px;" value="{ma}" /></td>
      </tr>-->
      <tr>
        <td><strong>Nhóm cha</strong></td>
        <td>{parentid}</td>
      </tr>
      <tr>
        <td><strong>Nhóm phụ</strong></td>
        <td><select name="groupcat[]" multiple="multiple" style="width:300px; height:200px;">
            

                        {parentid1}

                    
          </select></td>
      </tr>
      <tr>
        <td><strong>Ảnh</strong></td>
        <td><div id="pic_avatar">{image}</div>
          
          <br />
          <div class="input-append">
            <input name="imageurl" type="text" id="imageurl"  style="height:20px; width:290px;" value="{imageurl}"/>
            <button class="btn" type="button" id="browserimage">Chọn ảnh trên server</button>
          </div></td>
      </tr>
     
      <tr>
        <td><strong>Giá khuyến mại</strong></td>
        <td>
        	<input type="text" name="pricekm" id="price-km" value="{pricekm}" style="width:160px; margin-bottom:5px;"> 
        </td>
      </tr>
      
      <tr>
        <td><strong>Giá</strong></td>
        <td>
          <input type="text" name="price" id="price" class="txtform100" value="{price}" style="width:160px; margin-bottom:5px;" />
         
         </td>
      </tr>
      <tr>
        <td><strong>Màu</strong></td>
        <td>
        <style>
        	.color-cell{
				float:left; white-space:nowrap; display:block; background:#ccc; padding:4px;
				margin-bottom:3px;
				
			}
			.btn-close-color{
				width:32px;
				height:30px;
				line-height:30px;
				background:#CCC;
				float:left;
				display:block;
				text-align:center;
				font-weight:bold;
				font-size:14px;
				border-left:solid 1px #FFF;	
			}
        </style>
        <div class="color-pro">
        	{color}
        </div>
        <div class="c"></div>
       <div class=""><a href="#" id="add_color" class="btn btn-success">Thêm</a></div>
        <script>
			$('.picco').click(function(){
				change_color($(this));
			});
			function change_color(obj){
				obj.colorpicker({
					transparentColor: true
				}).on('change.color', function(evt, color){
					var cha = $(this).parent().parent();
					cha.css('background-color',color);
				});
			}
			
			$('#add_color').click(function(){
				$('.color-pro').append('<div style="width:100%;clear:both"><span class="color-cell" ><input onclick="change_color($(this));" class="picco"  name="color[]" style="width:50px;" value="#0000ffff" /></span><a href="#" class="btn-close-color" onclick="removeColor($(this)); return false;">x</span><div class="c"></div></div>');
				return false;
			});
        	/*$('#transColor').colorpicker({
				transparentColor: true
			});*/
			function removeColor(obj){
				obj.parent().remove();
			}
        </script>
         </td>
      </tr>
      <tr>
        <td colspan="2" valign="top" id="loadAttr">&nbsp;</td>
      </tr>
      <tr>
        <td valign="top"><strong>Trích dẫn</strong></td>
        <td><textarea name="ttkhuyenmai" rows="5" style="width:300px">{ttkhuyenmai}</textarea></td>
      </tr>
      <tr>
        <td valign="top"><strong>Mô tả ngắn</strong></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2"><div>{intro}</div></td>
      </tr>
      <tr>
        <td valign="top"><strong>Giới thiệu sản phẩm</strong></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2"><div>{content}</div></td>
      </tr>
      <tr>
        <td valign="top" colspan="2"><input type="text" name="tabname0" id="tabname0" value="{tabname0}" style="width:160px; margin-bottom:5px;" placeholder="Tên tab"></td>
      </tr>
      <tr>
        <td colspan="2"><div>{contenttab0}</div></td>
      </tr>
      <tr>
        <td><strong>Ảnh Slide</strong></td>
        <td><button class="btn btn-info" type="button" id="multi_browser_image">Chọn ảnh trên server</button></td>
      </tr>
      <tr>
        <td colspan="2" id="show_collection_cell">
        <!-- START BLOCK : collection_cell -->
          <div class="collection_cell2">
            <div class="image"><a href="{big_image}" class="highslide" onClick="return hs.expand(this)"><img src="{image}"></a></div>
            <input name="image_name[collection_{id}]" type="text" class="txtname name_image" placeholder="Tiêu đề..." value="{name}">
            <!--<textarea name="image_desc[collection_{id}]" cols="" class="txtname" style="height:100px;resize:none; " rows="" placeholder="Mô tả...">{image_desc}</textarea>-->
            <div style="padding-left:10px;"><span class="labelorder">Thứ tự</span>
              <input name="image_thu_tu[collection_{id}]" type="text" class="txtorder image_thu_tu" placeholder="Thứ tự..." value="{thu_tu}">
              <a class="btn btn-mini" style="margin-top:2px; margin-left:10px;" onClick="delete_multi_image($(this));

                                    return false"><i class="icon-trash"></i>&nbsp;Xóa</a>
              <div style="c"></div>
            </div>
            <input type="hidden" name="collection_image[collection_{id}]" value="{real_image}" class="collection_image">
          </div>
          
          <!-- END BLOCK : collection_cell -->
         </td>
      </tr>
      <tr >
        <td valign="top"><strong>Sản phẩm cùng loại</strong></td>
        <td>
       	  <div><input type="text" name="spcungloainame" id="spcungloainame" value="{spcungloainame}" style="width:250px; margin-bottom:5px;" placeholder="Tiêu đề SP cung loại"></div>
        	<div><textarea style="height:40px" name="spcungloai" id="spcungloai" class="txtareakeyword-description">{spcungloai}</textarea></div>
            <div style="font-size:11px; color:#666; font-style:italic">ID: sản phẩm cách nhau bởi dấu (,) (VD:123,124)</div>
            <div class="c10"></div>
            <div id="loadspcungloai"></div>
            <script>
            	$(function(){
					$('#spcungloai').blur(function(){
						$('#loadspcungloai').text('Loading...');
						$('#loadspcungloai').load("./index4.php?page=spcungloai&lstId=" + $('#spcungloai').val(), function(response, status, xhr) {
						});
					});
					$('#loadspcungloai').text('Loading...');
					$('#loadspcungloai').load("./index4.php?page=spcungloai&lstId=" + $('#spcungloai').val(), function(response, status, xhr) {
					});
				});
            </script>
        </td>
       
      </tr>
      <tr >
        <td><strong>Biểu tượng</strong></td>
        <td>
        	<div style="width:200px;">
            <div><label><input name="icon" type="radio" value="none">Không có biểu tượng</label></div>
        	<div><label><input name="icon" type="radio" value="km" {km}>Sale</label></div>
            <div><label><input name="icon" type="radio" value="new" {new}>New</label></div>
            <div><label><input name="icon" type="radio" value="hot" {hot}>Hot</label></div>
            <input name="texticon" type="text" style="width:100px" placeholder="Text..." value="{texticon}"/>
            </div>
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
        <td style="position:relative"><div class="input-prepend"> <span class="add-on">
            <input name="autourl" id="autourl" type="checkbox" value="1" {autourl}/>
            </span>
            <input class="span2" id="url" name="url" type="text" style="width:572px;" value="{url}">
          </div>
          <div style="font-size:11px; color:#666; font-style:italic">Checked tự động tạo url/Uncheck lấy url trên ô text</div></td>
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
        <td><a class="btn btn-primary" onclick="$('#inputform').submit();

                        return false"><i class="icon-ok-circle icon-white"></i>&nbsp;Cập nhật</a>
          <div onclick="window.location = '?page={par_page}&pid={pid}'" class="btn btn-inverse" style="margin-left:10px;"><i class="icon-remove icon-white"></i>&nbsp;Đóng</div></td>
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

        $(function() {

            $('#divremovea').html(CKEDITOR.instances.content.getData());

            $('#divremovea img').each(function() {

                $('#load').append('<div class="cell_multi_upload"><img src="{dir_path}/manager/image.php?w=130&h=90&src=' + $(this).attr('src') + '" /><div class="tool"><a href="#" onclick="insertimage(\'' + $(this).attr('src') + '\');return false">Chèn</a> | <a href="#" class="a_deleteimage" onclick="deleteimage(\'' + $(this).attr('src') + '\',\'' + $(this).attr('src') + '\',$(this));return false">Xóa</a></div></div>');

            });



        });



        function get_image_url() {

            var n = 0;

            $('#load .cell_multi_upload').each(function() {

                n++;

            });

            $('#divremovea').html(CKEDITOR.instances.content.getData());

            $('#divremovea img').each(function() {

                n++;

                $('#load').append('<div class="cell_multi_upload" id="uploaded_file_' + n + '"><div class="progress progress-striped active"><div class="bar" style="width: 100%;"></div></div></div>');

                $("#uploaded_file_" + n).load("index4.php?page=action_ajax&code=uploadimageurl1&url=" + $(this).attr('src'), function(response, status, xhr) {

                    if (status == "error") {

                        var msg = "Sorry but there was an error: ";

                        $("#error").html(msg + xhr.status + " " + xhr.statusText);

                    }

                    if (status == "success") {



                    }

                });

            });

        }



        function insert_image_default(url) {

            $('#imageurl').attr('value', url);

            $('#pic_avatar').html('<img src="image.php?w=150&src=' + url + '" class="img-polaroid marginright5" align="left" id="avatar" />');

        }

    </script> 
  
  <!-- END BLOCK : AddNew --> 
  
  <!-- START BLOCK : showList -->
  
  <form action="{action}" method="post" id="list_form">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-striped table-hover">
      <tr>
        <th colspan="8"> <div style="float:left"><i class="icon-list-alt icon-white"></i>&nbsp;Danh sách {item}</div>
          <a href="?page={par_page}&code=showAddNew&pid={pid}" style="float:right">
          <div class="btn  btn-mini"><i class="icon-plus-sign"></i>&nbsp;Thêm mới {item}</div>
        </a> </th>
      </tr>
      <tr class="search_box nonehover">
        <td colspan="8"><div class="form-search" style="margin:0px;">
            <div class="input-append">
              <input type="text" class=" search-query" style="height:20px;" name="keyword" id="keyword" placeholder="Từ khóa cần tìm...">
              <button type="submit" class="btn" id="btnSearch">Tìm</button>
            </div>
            {parentid} </div></td>
      </tr>
      <tr class="title">
        <td width="16"><input type="checkbox" name="checkbox" id="checkbox" class="cat_check" data-check="cat_check" onclick="check_all(this)" /></td>
        <td style="text-align:center; width:80px">ID</td>
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
        <td style="text-align:center">{id}</td>
        <td><a href="{link_edit}">{image}</a>
          <div class="list_item_name"><a href="{link_edit}">{name}</a></div>
          <div class="info_item"><strong>Người đăng:</strong> {user_name} [{username}] - <strong>Ngày:</strong> {createdate}</div>
          <div class="info_item"><strong>Nhóm phụ:</strong> [{groupcat}]</div>
          <div class="info_item"><strong>Url:</strong> <a href="{url}" target="_blank">{url}</a></div></td>
        <td align="center" class="center" valign="middle"><a href="{linkcat}">{categoryname}</a></td>
        <td class="center"><input type="checkbox" name="active" value="1" data-active="{id}" {active} class="changeactive"/></td>
        <td><input type="text" name="thu_tu[{id}]" class="txtorder" value="{thu_tu}"/></td>
        <td><a href="{link_edit}" class="btn padingleftright4"><i class="icon-wrench"></i></a></td>
        <td><a href="{link_delete}" class="trash_item btn padingleftright4"><i class="icon-trash"></i></a></td>
      </tr>
      
      <!-- END BLOCK : list -->
      
      <tr class="title">
        <td width="16"><input type="checkbox" name="checkbox" id="checkbox" class="cat_check" onclick="check_all($(this))"/></td>
        <td>&nbsp;</td>
        <td><a href="?page={par_page}&code=deletemulti" id="delmultiitem">Xóa tất cả mục đã chọn</a></td>
        <td colspan="3"><div class="btn btn-inverse" onclick="$('#list_form').submit();" style="margin-left:30px">Cập nhật</div></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr class="search_box nonehover">
        <td colspan="8"> {pages} </td>
      </tr>
    </table>
  </form>
  
  <!-- END BLOCK : showList -->
  
  <div class="divider1"><span></span></div>
  <div id="divremovea" style="display:none"></div>
</div>
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



        $('#delmultiitem').click(function() {

            if (confirm('Bạn có thật sự muốn xóa những mục đã chọn không ?')) {

                $('#list_form').attr('action', $(this).attr('href'));

                $('#list_form').submit();

            } else {

                return false;

            }

            return false;

        })

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





// block ui



// tool editor

    function remove_A() { // remove tag a

        $('#divremovea').html(CKEDITOR.instances.content.getData());

        $("#divremovea a").each(function() {

            $(this).replaceWith('<span>' + $(this).html() + '</span>');

        });

        CKEDITOR.instances.content.setData($('#divremovea').html());



    }

    function table_center() { // table to center

        $('#divremovea').html(CKEDITOR.instances.content.getData());

        $("#divremovea table").each(function() {

            //$(this).replaceWith('<span>' + $(this).html() + '</span>');

            $(this).attr('align', 'center');

        });

        CKEDITOR.instances.content.setData($('#divremovea').html());

    }

    function td_text_italic() { // text italic in td 

        $('#divremovea').html(CKEDITOR.instances.content.getData());

        $("#divremovea table td").each(function() {

            $(this).css('font-style', 'italic');

        });

        CKEDITOR.instances.content.setData($('#divremovea').html());

    }

    function td_text_center() { // text center in td

        $('#divremovea').html(CKEDITOR.instances.content.getData());

        $("#divremovea table td").each(function() {

            $(this).css('text-align', 'center');



        });

        CKEDITOR.instances.content.setData($('#divremovea').html());

    }

    function image_center() { // image to center

        $('#divremovea').html(CKEDITOR.instances.content.getData());

        $("#divremovea img").each(function() {

            if ($(this).attr('alt')) {

                var curAlt = $(this).attr('alt');

            }

            if ($(this).attr('title')) {



                var curTitle = $(this).attr('title');

            }



            $(this).replaceWith('<div align="center"><img src="' + $(this).attr('src') + '"  /></div>');

            //$(this).css('margin','0 auto');

        });

        CKEDITOR.instances.content.setData($('#divremovea').html());

    }

    function remove_P() { // remove tag p

        $('#divremovea').html(CKEDITOR.instances.content.getData());

        $("#divremovea p").each(function() {

            $(this).replaceWith('<div>' + $(this).html() + '</div>');

        });

        CKEDITOR.instances.content.setData($('#divremovea').html());

    }

</script> 
<script src="js/jQuery-File-Upload/js/vendor/jquery.ui.widget.js"></script> 
<script src="js/jQuery-File-Upload/js/jquery.iframe-transport.js"></script> 
<script src="js/jQuery-File-Upload/js/jquery.fileupload.js"></script> 
<script>

    $(function() {

        'use strict';

        var url = window.location.hostname === 'js/jQuery-File-Upload/server/php/';

        $('#fileupload').fileupload({

            url: '/manager/js/jQuery-File-Upload/server/php/index.php',

            dataType: 'json',

            done: function(e, data) {

                $.each(data.result.files, function(index, file) {

                    // $('<div/>').text(file.name).appendTo('#files');

                    $('#load').append('<div class="cell_multi_upload"><img src="image.php?w=130&h=90&src={imagedir}' + file.url + '" /><div class="tool"><a href="#" onclick="insertimage(\'{imagedir}' + file.url + '\');return false">Chèn</a> | <a href="#" class="a_deleteimage" onclick="deleteimage(\'' + file.url + '\',\'' + file.thumbnailUrl + '\',$(this));return false">Xóa</a></div></div>');



                });

            },

            progressall: function(e, data) {

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

            done: function(e, data) {

                $.each(data.result.files, function(index, file) {

                    // $('<div/>').text(file.name).appendTo('#files');

                    $('#loadimage').append('<div class="cell_multi_upload"><img src="image.php?w=130&h=90&src={imagedir}' + file.url + '" /><div class="tool"><a href="#" onclick="insertimage(\'{imagedir}' + file.url + '\');return false">Chèn</a> | <a href="#" class="a_deleteimage" onclick="deleteotherimage(\'' + file.url + '\',\'' + file.thumbnailUrl + '\',$(this));return false">Xóa</a></div><input type="hidden" name="otherimage[]" value="' + file.url + '" /></div>');



                });

            },

            progressall: function(e, data) {

                var progress = parseInt(data.loaded / data.total * 100, 10);

                $('#status .bar').css(

                        'width',

                        progress + '%'

                        ).text(progress + '%');

            }

        }).prop('disabled', !$.support.fileInput)

                .parent().addClass($.support.fileInput ? undefined : 'disabled');





    });



    function deleteimage(url, urlthumb, obj) {

        obj.parent().parent().fadeTo('fast', 0.3);

        $("#divremovea").load('index4.php?page=action_ajax&code=deleteimageurl&image=' + url + '&urlthumb=' + urlthumb, function(response, status, xhr) {

            if (status == "error") {

                var msg = "Sorry but there was an error: ";

                alert(msg + xhr.status + " " + xhr.statusText);

            }

            if (status == 'success') {

                obj.parent().parent().remove();

            }

        });

    }

    function deleteotherimage(url, id, obj) {

        obj.parent().parent().fadeTo('fast', 0.3);

        $("#divremovea").load('index4.php?page=action_ajax&code=deleteotherimageurl&image=' + url + '&id=' + id, function(response, status, xhr) {

            if (status == "error") {

                var msg = "Sorry but there was an error: ";

                alert(msg + xhr.status + " " + xhr.statusText);

            }

            if (status == 'success') {

                obj.parent().parent().remove();

            }

        });

    }

    function insertimage(url) {

        CKEDITOR.instances.content.insertHtml('<img src=' + url + ' />');

    }



    $(function() {

        $('#btnSearch').click(function() {

            $('#list_form').attr('action', '?page={par_page}&pid={pid}');

            $('#list_form').submit();

        });



        $('#idc').change(function() {

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



    $('#videobrowse').click(function() {

        var fm = $('<div/>').dialogelfinder({

            url: 'browser/php/connector.php',

            lang: 'vi',

            width: 840,

            destroyOnClose: true,

            getFileCallback: function(files, fm) {

                console.log(files);

                $('#videourl').attr('value', files.url);



            },

            commandsOptions: {

                getfile: {

                    oncomplete: 'close',

                    folders: true

                }

            }

        }).dialogelfinder('instance');

    });



    $(function() {

        $('#videourl').change(function() {

            trimUrlVideo($(this).val());

        });



    });



    function getHost(url)

    {

        var a = document.createElement('a');

        a.href = url;

        return a.hostname;

    }







    function trimUrlVideo(video) {

        if (getHost(video) == 'youtube.com' || getHost(video) == 'www.youtube.com') {

            var url = video;

            var vd = url.split("=");

            vd = vd[1];

            if (vd) {

                $('#videourl').val(url);

                $('#video_avatar').html('<img src="http://img.youtube.com/vi/' + vd + '/0.jpg" width="150" /><br />');

            } else {

                $('#videourl').val(url);

                $('#video_avatar').html('<img src="http://img.youtube.com/vi/' + url + '/0.jpg" width="150" /><br />');

            }

        }

    }







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



    function delete_multi_image(obj) {

        if (confirm("Bạn muốn xóa ảnh này?")) {

            obj.parent().parent().remove();

        } else {

            return false;

        }

    }



</script>