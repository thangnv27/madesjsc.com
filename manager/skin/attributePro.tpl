<style>
.attrthtitle{
	line-height:25px;
	height:25px;
	color:#333;
	padding-left:10px;
	text-transform:uppercase;
	font-weight:bold;
	border-bottom:solid 1px #CCC;	
	color:#6a6a6a;
	background: #f7f7f7;
	background: -moz-linear-gradient(top,  #f7f7f7 0%, #e6e6e6 100%);
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#f7f7f7), color-stop(100%,#e6e6e6));
	background: -webkit-linear-gradient(top,  #f7f7f7 0%,#e6e6e6 100%);
	background: -o-linear-gradient(top,  #f7f7f7 0%,#e6e6e6 100%);
	background: -ms-linear-gradient(top,  #f7f7f7 0%,#e6e6e6 100%);
	background: linear-gradient(top,  #f7f7f7 0%,#e6e6e6 100%);
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f7f7f7', endColorstr='#e6e6e6',GradientType=0 );	
}
.body-page-attribute{
	border:solid 1px #CCC;
	-webkit-border-radius:3px;
	-o-border-radius:3px;
	-moz-border-radius:3px;
	-ms-border-radius:3px;
	border-radius:3px;	  
	padding:10px;
	background:#FFF;
}
	.list-attribute{
		width:300px;
		float:left;	
		margin:0px;
		padding:3px;
		border:solid 1px #CCC;
	}
	.list-attribute li{
		list-style:none;
		border-bottom:solid 1px #CCC;	
	}
	.marginleft15{
		margin-left:15px;	
	}
	.thbackgroundblue{
		background:#EEE;	
	}
	.thbackgroundblue1{
		background:#70A8D2;	
	}
	.fl{
		float:left !important;	
		margin-right:10px;
	}
	.blockhide{
		display:none;	
	}
	.blockshow{
		display:block;	
	}
	.setdefault{
		background:#090 !important;
		color:#FFF;	
	}
</style>
<div class="c5"></div>
<div class="breadLine">
    <ul class="breadcrumb">
        <li><a href="?"><i class="icon-home"></i></a></li>
        <a href="?page=attributePro">Quản lý thuộc tính sản phẩm</a>
    </ul>
</div>
<div class="c20"></div>
<div class="body-page-attribute">
	<div class="alert alert-success">
    	<div class="btn-success btn btncreate-attr">Thêm mới thuộc tính</div>
        <div class="btn btn-success btncreate">Thêm mới nhóm thuộc tính</div>
    </div>
    <!--START BLOCK : msg -->
		<div>
		{msg}		</div>
        <div style="clear:both; height:10px;"></div>
		<!--END BLOCK : msg -->
    <script>
    	$(function(){
			$('.btncreate-attr').click(function(){
				$('#formAddAttrGroup').hide();
				$('#formAddAttr').slideToggle();
			});
			$('.btncreate').click(function(){
				$('#formAddAttr').hide();
				$('#formAddAttrGroup').slideToggle();
			});
			
			$('#btn-add-attr').click(function(){
				
			});
			
		});
    </script>
    <div class="alert alert-info {blockhide}" id="formAddAttr">
     <form action="{action}" method="post" id="AddForm">
        		<input type="hidden" name="gone" value="1" />
        		<table width="400" border="0" cellpadding="5">
				  <tr>
				    <td>Tên thuộc tính</td>
				    <td><input name="name1" id="attr-name" type="text" value="{name1}" /></td>
				  </tr>
				  <tr>
				    <td>Giá trị mặc định</td>
				    <td><input name="default_value" type="text" value="{default_value}" /></td>
				  </tr>
				 <tr>
				    <td>&nbsp;</td>
				    <td><div class="btn btn-primary" id="btn-add-attr">Thêm</div><div class="btn btn-info" id="btn-close-box-add" style="margin-left:10px;">Đóng</div></td>
				  </tr>
				</table>
      </form>
      <script>
      		$(function(){
				$('#btn-add-attr').click(function(){
					$('#AddForm').submit();
				});
				$('#btn-close-box-add').click(function(){
					$('#formAddAttr').slideUp();
				});
			});
      </script>
    </div>
    <!-- end add/edit -->
    
    
  <div class="alert alert-info {blockshowhidegroup}" id="formAddAttrGroup">
    <!-- START BLOCK : insertUpdateAttr --> 
    
    	<table  border="0" class="table table-bordered fl" id="table-list-attr" style="background:#FFF;width:300px;">
	  	  <tr class="attrthtitle">
          <th width="20">&nbsp;</th>
	  	    <th>Tên thuộc tính</th>
	  	  </tr>
	        <!-- START BLOCK : list_attribute1 -->
	  	 
          <tr>
           <td width="20"><input class="select_attr" name="attr[]" rel="{name}" type="checkbox" value="{id_attr}" id="{id_attr}" {selected}/></td>
	  	    <td><label for="{id_attr}">{name}</label></td>
	  	    
	  	  </tr>
	  	 <!-- END BLOCK : list_attribute1 -->
	  	</table>
        <form action="{actiongroupattr}" method="post" id="form_selected_attr">
        
        <table style="width:350px; background:#FFF" border="0" class="table table-bordered fl" >
          <tr >
            <th><label class="checkbox" title="Trong trường hợp không chọn nhóm thuộc tính cho nhóm sản phẩm thì mặc định nhóm thuộc tính của sản phẩm được set là nhóm mặc định (Chỉ có duy nhất 1 nhóm mặc định)"><input name="setdefault" type="checkbox" value="1" {setdefault} />Đặt nhóm làm nhóm mặc định</label></th>
            <th width="40" align="center">STT</th>
            <th width="40" align="center"><a href="#" onclick="$('#form_selected_attr').submit(); return false"><button class="btn btn-mini btn-primary" type="button">Lưu</button></a></th>
          </tr>
          <tr class="thbackgroundblue" id="thbackgroundblue">
            <td colspan="3"><input placeholder="Tên nhóm thuộc tính" name="name" style="width:285px" type="text" value="{namegroupattr}" /></td>
           
          </tr>
          <!-- START BLOCK : list_attr_edit -->
          <tr class="selected_attr_{id_attr}"><td >{attrname}</td><td ><input name="thu_tu_{id_attr}" style="width:30px; text-align:center" type="text" value="{thu_tu}" /></td><td align="center"><a href="#" onclick="remove_attr_selected('{id_attr}')"><i class="icon-trash marginleft15"></i></a><input type="hidden" name="selected_attr[]" value="{id_attr}" /></td></tr>
          <!-- END BLOCK : list_attr_edit -->
        </table>
        </form>
            <script language="javascript">
        	$(function(){
				$('.select_attr').change(function(){
					obj = $(this);
					$('.selected_attr_' + obj.val()).remove();
					if(obj.is(':checked')){
						$('<tr class="selected_attr_' + obj.val() + '"><td >' + obj.attr('rel') + '</td><td ><input name="thu_tu_' + obj.val() + '" style="width:30px; text-align:center" type="text" value="{thu_tu}" /></td><td align="center"><a href="#" onclick="remove_attr_selected(\'' + obj.val() + '\')"><i class="icon-trash marginleft15"></i></a><input type="hidden" name="selected_attr[]" value="' + obj.val() + '" /></td></tr>').insertAfter("#thbackgroundblue");
					}else{
						$('.selected_attr_' + obj.val()).remove();
					}
				});
			});
			function remove_attr_selected(id){
				$('.selected_attr_' + id).remove();
			}
        </script>
    	<div style="clear:both; height: 10px;"></div>
       <!-- END BLOCK : insertUpdateAttr -->
    </div>
    
	<table style="width:300px;" border="0" class="table table-bordered fl" id="table-list-attr">
	  <tr>
	    <th colspan="3">Danh sách thuộc tính</th>
	  </tr>
      <tr class="thbackgroundblue">
	    <td><strong>Tên thuộc tính
        </th>
	    </strong>
	    <td width="40" align="center"><strong>Sửa</strong></td>
	    <td width="40" align="center"><strong>Xóa</strong></td>
	  </tr>
      <!-- START BLOCK : list_attribute -->
	  <tr>
        <td>{name}</td>
	    <td align="center"><a href="{edit}"><i class="icon-edit marginleft15"></i></a></td>
	    <td align="center"><a href="#" onclick="confirm_del($(this),'{delete}'); return false"><i class="icon-trash marginleft15"></i></a></td>
	  </tr>
	 <!-- END BLOCK : list_attribute -->
	</table>
    <!-- START BLOCK : group_attr -->
    <table style="width:300px" border="0" class="table table-bordered fl">
	  <tr class="attrthtitle {setdefault}">
	    <td>{name}</td>
	    <td width="40" align="center"><a href="{link_edit}"><i class="icon-edit marginleft15"></i></a></td>
	    <td width="40" align="center"><a href="#" onclick="confirm_delete_group($(this),'{link_del}'); return false"><i class="icon-trash marginleft15"></i></a></td>
	  </tr>
      <!-- START BLOCK : list_attr -->
	  <tr>
	    <td colspan="2">{attrname}</td>
	    <td align="center"><a href="#" onclick="confirm_del($(this),'{link_del_attr_in_group}'); return false"><i class="icon-trash marginleft15"></i></a></td>
	  </tr>
	 <!-- END BLOCK : list_attr -->
  </table>
    <!-- END BLOCK : group_attr -->
	<div style="clear:both; height:10px;"></div>
</div>
<script>
	$(document).ready(function(){
		setTimeout('hide_alert()', 3000)
	});
	
	function hide_alert(){
		$("#box-message-alert").hide();
	}
	
	function confirm_del(obj,url){
		if(confirm('Bạn có thật sự muốn xóa không ?')){
			$(obj).parent().parent().fadeTo('slow',0.3);
			$(obj).load(url, function(response, status, xhr) {
				if (status == "error") {
					alert('Lỗi: ' + xhr.status + " " + xhr.statusText);
				}
				if (status == "success") {
					$(obj).parent().parent().remove();		  
				}
			});
			
		}
	}
	function confirm_del(obj,url){
		if(confirm('Bạn có thật sự muốn xóa thuộc tính này không ?')){
			$(obj).parent().parent().fadeTo('slow',0.3);
			$(obj).load(url, function(response, status, xhr) {
				if (status == "error") {
					alert('Lỗi: ' + xhr.status + " " + xhr.statusText);
				}
				if (status == "success") {
					$(obj).parent().parent().remove();		  
				}
			});
			
		}
	}
	
	
	
	function confirm_delete_group(obj,url){
		if(confirm('Bạn có thật sự muốn xóa nhóm thuộc tính không ?')){
			$(obj).parent().parent().parent().parent().fadeTo('slow',0.3);
			$(obj).load(url, function(response, status, xhr) {
				if (status == "error") {
					alert('Lỗi: ' + xhr.status + " " + xhr.statusText);
				}
				if (status == "success") {
					$(obj).parent().parent().parent().parent().remove();		  
				}
			});
		}
	}
	
	
</script>