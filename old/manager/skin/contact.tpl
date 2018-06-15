
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
<form action="{action}" method="post" id="inputform" onSubmit="return check_null();" enctype="multipart/form-data">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-bordered tabletdnone">
      <tr>
        <th colspan="2">Thông tin liên hệ</th>
      </tr>
      <tr>
        <td width="150" valign="top"><strong>Ngày</strong></td>
        <td>{createdate}</td>
      </tr>
      <tr>
        <td colspan="2" valign="top">{content}</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><div onClick="window.location='?page=contact'" class="btn btn-inverse" style="margin-left:10px;"><i class="icon-remove icon-white"></i>&nbsp;Đóng</div></td>
      </tr>
    </table>
</form>
<div class="divider1"><span></span></div>


<!-- END BLOCK : view -->

<!-- START BLOCK : showList -->
<form action="{action}" method="post" id="list_form">
 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-striped table-hover">
							 
  <tr>
    <th colspan="2">
        <div style="float:left"><i class="icon-list-alt icon-white"></i>&nbsp;Danh sách liên hệ</div>
        
    </th>
  </tr>
  
  <tr class="title">
    <td>Tiêu đề</td>
    <td width="30" align="center">Xóa</td>
  </tr>
  <!-- START BLOCK : list -->
  <tr>
    <td>
     <a href="{link}">{name}</a>
     
    </td>
    <td><a href="{linkdel}" class="trash_item btn padingleftright4"><i class="icon-trash"></i></a></td>
  </tr>
  <!-- END BLOCK : list -->

 
  <tr class="search_box nonehover">
    <td colspan="2">
           {pages}
    </td>
  </tr>
</table>
</form>
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

