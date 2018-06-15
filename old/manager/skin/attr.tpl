
<div class="c5"></div>
<div class="breadLine">
    <ul class="breadcrumb">
        <li><a href="?"><i class="icon-home"></i></a></li>
      	<a href="?page={par_page}">Thuộc tính sản phẩm</a>
    </ul>
</div>
<div class="c20"></div>
  
<div class="wraper-content">
<!-- START BLOCK : msg -->
<div>{msg}</div>
<!-- END BLOCK : msg --> 

<div>
<div class="alert alert-info">
    <a href="?page={par_page}&code=showAddNew"><div class="btn-inverse btn btncreate-attr">Thêm mới thuộc tính</div></a>
    <div class="btn btn-inverse btncreate">Thêm mới nhóm thuộc tính</div>
</div>
<!-- START BLOCK : showUpdate -->
<div id="addNewAttr" class="alert alert-success" >
	<form action="{action}" method="post" id="addNewForm">
    <table width="100%" border="0" cellspacing="0" cellpadding="3">
		  <tr>
		    <td width="100"><strong>Tên thuộc tính</strong></td>
		    <td><input name="name" type="text" value="{name}"></td>
		  </tr>
		  <tr>
		    <td><strong>Giá trị mặc định</strong></td>
		    <td><input name="default_value" type="text" value="{default_value}"></td>
		  </tr>
		  <tr>
		    <td>&nbsp;</td>
		    <td><a class="btn btn-success" href="#" onclick="$('#addNewForm').submit(); return false">Lưu</a></td>
		  </tr>
		</table>
	</form>
</div>
<!-- END BLOCK : showUpdate -->
<!-- START BLOCK : showList -->
	<div class="attributeBox">
    	
    	<div class="title">Danh sách thuộc tính</div>
        <div>
        <form action="?page={par_page}&code=deletemulti" method="post" id="deleteMultiItem">
        	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableattribute table-hover">
			  <tr class="trtitle">
			    <td width="20">&nbsp;</td>
			    <td>Tên thuộc tính</td>
			    <td width="30">TT</td>
			    <td width="30">Xóa</td>
			  </tr>
              <!-- START BLOCK : list -->
			  <tr >
			    <td class="name"><input name="delmulti[{id}]" type="checkbox" value="{id}" /></td>
			    <td class="name">{name}</td>
			    <td align="center"><a href="{link_edit}" class="padingleftright4"><i class="icon-wrench"></i></a></td>
			    <td align="center"><a href="{link_delete}" class="padingleftright4 trash_item"><i class="icon-trash"></i></a></td>
			  </tr>
              <!-- END BLOCK : list -->
			  <tr>
			    <td colspan="2" class="name"><a href="#" style="color:#FF0000; font-weight:bold" id="adeleteMultiItem">Xóa những mục đã chọn</a></td>
			    <td align="center">&nbsp;</td>
			    <td align="center">&nbsp;</td>
		      </tr>
              
			</table>
		</form>
        </div>
       
    </div>
 <!-- END BLOCK : showList --> 
      <div class="attributeBox">
        <div class="title"><div class="titletext">Danh sách thuộc tính</div><div class="edit"><a href="#"><i class="icon-wrench"></i></a></div></div>
        <div>
        	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableattribute table-hover">
			  <tr class="trtitle">
			    <td>Tên thuộc tính</td>
			    <td width="30">TT</td>
			    <td width="30">Xóa</td>
			  </tr>
			  <tr>
			    <td class="name">dsfsd</td>
			    <td align="center"><input name="" type="text" style="width:30px; text-align:center"></td>
			    <td align="center"><a href="{link_delete}" class="padingleftright4 trash_item"><i class="icon-trash"></i></a></td>
			  </tr>
              
			</table>
        </div>   
    </div>
    
      
</div>
<div class="c10"></div>
<div class="divider1"><span></span></div>
</div>
<script>
	$(function(){
		$('.trash_item').click(function(){
			if(confirm('Bạn có thật sự muốn xóa không thuộc tính ?')){
				window.location=$(this).attr('href');
				return false;
			}
			return false;
		});
		
		$('#adeleteMultiItem').click(function(){
			if(confirm('Bạn có thật sự muốn xóa những mục đã chọn không ?')){
				$('#deleteMultiItem').submit();
				return false;
			}
			return false;
		});
	});
</script>
