
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
<form action="" method="post" id="inputform" onSubmit="return check_null();" enctype="multipart/form-data">
	<input type="hidden" name="code" value="save" />
	<!-- START BLOCK : view -->
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-bordered tabletdnone">
      <tr>
        <th colspan="2">Thông tin cá nhân</th>
      </tr>
      <tr>
        <td><strong>Mã đăng nhập</strong></td>
        <td>{username}</td>
      </tr>
      <tr>
        <td width="150"><strong>Họ tên</strong></td>
        <td><input type="text" name="name" id="name" style="width:300px;" value="{name}"></td>
      </tr>
      <tr>
        <td valign="top"><strong>Email</strong></td>
        <td><input type="text" name="email" id="email" style="width:300px;" value="{email}"></td>
      </tr>
      <tr>
        <td valign="top"><strong>Điện thoại</strong></td>
        <td><input type="text" name="telephone" id="telephone" style="width:300px;" value="{telephone}"></td>
      </tr>
      <tr>
        <td><strong>Địa chỉ</strong></td>
        <td><input type="text" name="address" id="address" style="width:300px;" value="{address}"></td>
      </tr>
      <tr>
        <td><strong>Mật khẩu hiện tại</strong></td>
        <td><input type="password" name="currentpassword" id="currentpassword" style="width:300px;"></td>
      </tr>
      <tr>
        <td><strong>Mật khẩu mới</strong></td>
        <td><input type="password" name="newpassword" id="newpassword" style="width:300px;"></td>
      </tr>
      <tr>
        <td><strong>Mật khẩu mới nhập lại</strong></td>
        <td><input type="password" name="repassword" id="repassword" style="width:300px;"></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><a class="btn btn-primary" onclick="$('#inputform').submit(); return false"><i class="icon-ok-circle icon-white"></i>&nbsp;Cập nhật</a><div onclick="window.location='?page={par_page}&pid={pid}'" class="btn btn-inverse" style="margin-left:10px;"><i class="icon-remove icon-white"></i>&nbsp;Đóng</div></td>
      </tr>
    </table>
    <!-- END BLOCK : view -->
</form>
<div class="divider1"><span></span></div>




<div class="divider1"><span></span></div>

</div>

