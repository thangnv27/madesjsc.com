
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
	<div>
    <!-- START BLOCK : addNew -->
    	<form action="?page=photo&code=save" id="uploadformphoto" method="post">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-bordered tabletdnone">
      <tr>
        <th ><i class="icon-pencil icon-white"></i>&nbsp;Form cập nhật dữ liệu</th>
      </tr>
      <tr>
        <td>
        	<div style="float:left; margin-right:5px;">{parentid}</div><span class="btn btn-success fileinput-button" style="float:left">
	        	<i class="icon-plus icon-white"></i>
	        	<span>Up nhiều file ảnh</span>
	        	<input id="fileupload" type="file" name="files[]" multiple>
    		</span>
            <div style="float:left; width:300px; padding-top:5px; margin-left:10px;">
            <div id="progress" class="progress progress-success progress-striped" >
        		<div class="bar"></div>
    		</div>
            </div>
        </td>
      </tr>
      <tr>
        <td id="uploadShow">
        </td>
      </tr>
      <tr>
        <td><a href="#" onclick="$('#uploadformphoto').submit(); return false" class="btn btn-primary">Cập nhật</a></td>
      </tr>
      </table>
	     </form>
          <div class="divider1"><span></span></div>
    <!-- END BLOCK : addNew -->     
        
 <!-- START BLOCK : CellPhoto -->        
 		<form action="" id="listformphoto" method="get">
        <input type="hidden" name="page" id="page" value="photo" />
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-bordered tabletdnone">
      <tr>
        <th>
        	<div style="float:left"><i class="icon-picture icon-white"></i>&nbsp;Danh sách {item}
            
            </div>
        <a href="?page={par_page}&code=addNew&pid={pid}" style="float:right; margin-right:10px;"><div class="btn  btn-mini"><i class="icon-plus-sign"></i>&nbsp;Thêm mới {item}</div></a>
        </th>
      </tr>
      
     <tr>
        <td>
     		{parentid} 
     	</td>
     </tr>
     
      <tr>
        <td>
        <script type="text/javascript" src="../highslide/highslide-with-gallery.js"></script>
		<link rel="stylesheet" type="text/css" href="../highslide/highslide.css" />
        <script type="text/javascript">
		hs.graphicsDir = '../highslide/graphics/';
		hs.align = 'center';
		hs.transitions = ['expand', 'crossfade'];
		hs.outlineType = 'rounded-white';
		
		hs.wrapperClassName = 'dark';
		hs.fadeInOut = true;
		hs.dimmingOpacity = 0.75;
		
		// Add the controlbar
		if (hs.addSlideshow) hs.addSlideshow({
			//slideshowGroup: 'group1',
			interval: 5000,
			repeat: false,
			useControls: true,
			fixedControls: 'fit',
			overlayOptions: {
				opacity: .6,
				position: 'bottom center',
				hideOnMouseOut: true
			}
		});
		
		</script>
		
        <!-- START BLOCK : cell_photo -->
        	<div class="cellPhotoList">
              	<div class="btn-group  tool">
                  <a class="btn btn-mini btn-info aeditphoto" data-content="index4.php?page=editphoto&id={id}&pid={id_category}" href="#">Sửa</a>
	              <a href="#" class="btn btn-mini btn-info" onclick="deleteimage1('{id}',$(this)); return false;">Xóa</a>
	            </div>	              
            	<div class="image">
			    	<a href="{bigimage}" class="highslide" onclick="return hs.expand(this)">{image}</a>
                </div>
                <div class="name">{name} {filetime}</div>
            </div>
          <!-- END BLOCK : cell_photo -->
        </td>
      </tr>
      <tr>
        <td>{pages}</td>
      </tr>
      </table>
  
        <!-- Modal -->
        <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 id="myModalLabel">Sửa</h4>
          </div>
          <div class="modal-body" id="editphoto">
            Đang tải ...
          </div>
          <div class="modal-footer">
            <button class="btn btn-primary" onclick="$('#editphotoform').submit();">Lưu</button>
            <button class="btn" data-dismiss="modal" aria-hidden="true">Đóng</button>
          </div>
        </div>
		</form>
 <!-- END BLOCK : CellPhoto -->     
    <div id="divremovea"></div>
</div>
  </div>
<script src="js/jQuery-File-Upload/js/vendor/jquery.ui.widget.js"></script>
<script src="js/jQuery-File-Upload/js/jquery.iframe-transport.js"></script>
<script src="js/jQuery-File-Upload/js/jquery.fileupload.js"></script>
<script language="javascript">
$(function(){
	
	$('#parentid').change(function(){
		window.location='?page={par_page}&pid=' + $(this).val();
	});
	
	
	
	$('.cellPhotoList').hover(function(){
		$('.tool',this).show();
		$('.name',this).show();
	},function(){
		$('.tool',this).hide();	
		$('.name',this).hide();	
	});
	
	$('.aeditphoto').click(function(){
	
		$("#editphoto").load($(this).attr('data-content'), function(response, status, xhr) {
		  if (status == "error") {
		    var msg = "Sorry but there was an error: ";
		   alert(msg + xhr.status + " " + xhr.statusText);
		  }
		});
			$('#myModal').modal('show');
		return false;
	});
	$('#myModal').on('hidden', function () {
	  	$("#editphoto").html('Đang tải ...');
	})
});

$(function () {
	
    'use strict';
    var url = window.location.hostname ===  'js/jQuery-File-Upload/server/php/index.php';
    $('#fileupload').fileupload({
        url: 'js/jQuery-File-Upload/server/php/index.php',
        dataType: 'json',
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
				$.get('index4.php?page=action_ajax&code=addphoto&url=' + file.url + '&pid=' + $('#parentid').val(), function(data) {
				 // $('.result').html(data);
				 // alert('Load was performed.');
				 	$('#uploadShow').append('<div class="cellPhoto"><div class="image"><a href="#" onclick="deleteimage1(\'' + parseInt(data) +'\',$(this)); return false" class="trash_item  padingleftright4 absolute"><i class="icon-trash"></i></a><img src="image.php?w=196&h=156&src={imagedir}' + file.url + '" /></div><div><input name="name1['+ parseInt(data) +']" type="text" class="txtname" placeholder="name ..."></div><div><textarea name="description[' + parseInt(data) + ']" class="txtname textarea" placeholder="description ..."></textarea><input type="hidden" name="id_photo[' + parseInt(data) + ']" value="'+ parseInt(data) +'" /></div></div>');
				});
				
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
});


function deleteimage1(id,obj){
	obj.parent().parent().fadeTo('fast',0.3);
	$("#divremovea").load('index4.php?page=action_ajax&code=deletePhoto&id=' + id, function(response, status, xhr) {
	  if (status == "error") {
		var msg = "Sorry but there was an error: ";
		alert(msg + xhr.status + " " + xhr.statusText);
	  }
	  if(status == 'success'){
		  obj.parent().parent().remove();
	  }
	});
}

</script>