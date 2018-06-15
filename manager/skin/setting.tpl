<div class="c5"></div>

<div class="breadLine">

    <ul class="breadcrumb">

        <li><a href="?"><i class="icon-home"></i></a></li>

        <li><a href="?page=setting">Cấu hình hệ thống</a></li>

    </ul>

</div>

<div class="c20"></div>

  

<div class="wraper-content">

<!-- START BLOCK : msg -->

<div>{msg}</div>

<!-- END BLOCK : msg --> 



<form action="?page=setting" method="post" id="inputform" onSubmit="return check_null();" enctype="multipart/form-data">

	<input type="hidden" name="gone" value="1" />

	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-bordered tabletdnone">

      <tr>

        <th colspan="2"><i class="icon-asterisk icon-white"></i>&nbsp;Cấu hình hệ thống</th>

      </tr>

      <tr class="search_box nonehover">

        <td colspan="2" style="text-transform:uppercase"><strong>Cấu hình chung</strong></td>

      </tr>

      <tr>

        <td width="150"><strong>Site title</strong></td>

        <td><input type="text" name="setting_item[site_name]" class="txtform100 notNull" value="{site_name}" data-alert="Bạn cần nhập vào tiêu đề {item}"/></td>

      </tr>

      <tr>

        <td><strong>Email </strong></td>

        <td><input type="text" name="setting_item[site_email]"  class="txtform100" value="{site_email}" /></td>

      </tr>
	  <tr>

        <td valign="top"><strong>Chế độ hoạt động</strong></td>

        <td>

        	<label class="radio"><input type="radio" name="setting_item[active_site]" id="radio" value="1" {active_yes}>Hoạt động</label>

            <label class="radio"><input type="radio" name="setting_item[active_site]" id="radio" value="0" {active_no}>Ngừng hoạt động</label>

        </td>

      </tr>

      <tr>

        <td>&nbsp;</td>

        <td>{active_site}</td>

      </tr>

     

      <tr>

        <td><strong>Description</strong></td>

        <td><textarea name="setting_item[site_description]" class="txtareakeyword-description">{site_description}</textarea></td>

      </tr>

      <tr>

        <td><strong>Keywords</strong></td>

        <td><textarea name="setting_item[site_keywords]" class="txtareakeyword-description">{site_keywords}</textarea></td>

      </tr>

       <tr>

              <td align="left" valign="top"><strong>Dán thẻ (Annalytics/webmarter tool)</strong></td>

              <td align="left"><textarea name="setting_item[toppage]" id="toppage" class="textarea txtareakeyword-description" >{toppage}</textarea></td>

            </tr>

      <tr class="search_box nonehover">

        <td colspan="2"  style="text-transform:uppercase"><strong>Cấu hình upload</strong></td>

      </tr>

      <tr>

        <td><strong>Thư mục upload ảnh</strong></td>

        <td><input type="text" name="setting_item[upload_image_path]"  style="width:300px;" value="{upload_image_path}" /></td>

      </tr>

      <tr>

        <td><strong>Watermark</strong></td>

        <td>

        	

        	<div id="pic_avatar">{image}</div><input type="file" name="image" /><br />

            <div class="input-append">

			  <input name="" type="text" id="imageurl"  style="height:20px; width:290px;"/>

			  <button class="btn" type="button" id="browserimage">Chọn ảnh trên server</button>

			</div>

            

       		<div style="margin-top:5px;">

        	<input type="text" name="setting_item[watermark_text]"   style="width:300px;" value="{watermark_text}" />

            </div>

        </td>

      </tr>

      <tr>

        <td><strong>Thư mục upload file</strong></td>

        <td><input type="text" name="setting_item[upload_media_path]"   style="width:300px;" value="{upload_media_path}" /></td>

      </tr>

      <tr>

        <td><strong>Kiểu upload</strong><br>

          <span style="font-size:11px; font-style:inherit">(Khi có file trùng tên trên server)</span>

        </td>

        <td>

        	<label class="radio"><input type="radio" name="setting_item[upload_mode]" id="radio" value="1" {upload_mode_1}>Ghi đè file</label>

            <label class="radio"><input type="radio" name="setting_item[upload_mode]" id="radio" value="2" {upload_mode_2}>Ghi file với tên khác</label>

            <label class="radio"><input type="radio" name="setting_item[upload_mode]" id="radio" value="3" {upload_mode_3}>Không ghi file mới</label>

        </td>

      </tr>

      <tr>

        <td><strong>Cỡ file lớn nhất cho phép</strong></td>

        <td><input type="text" name="setting_item[max_media_size]"  style="width:100px;" value="{max_media_size}" /> KB</td>

      </tr>

      <tr class="search_box nonehover">

        <td colspan="2"  style="text-transform:uppercase"><strong>Hệ thống</strong></td>

      </tr>

      <tr>

        <td><strong>Document root</strong></td>

        <td>

        	<input type="text" name="setting_item[document_root]"  class="txtform100" value="{document_root}" />

        	<div style="font-size:11px; font-style:italic">DOCUMENT_ROOT: {root} (không "/" ở cuối)</div>

        </td>

      </tr>

      <tr>

        <td><strong>Dir path</strong></td>

        <td>

        	<input type="text" name="setting_item[dir_path]"   style="width:300px;" value="{dir_path}" />

            <div style="font-size:11px; font-style:italic">Trường hợp dùng đường dẫn http://tendomain.com/tenthumuc thì Dir_path là /tenthumuc,

nếu dùng http://tendomain.com thì Dir_path để rỗng</div>

        </td>

      </tr>

      <tr>

        <td><strong>Mailer</strong></td>

        <td><select name="setting_item[mailer]" id="mailer" style="width:150px;">

        	<option value="SMTP" {SMTP}>SMTP</option>

            <option value="mail" {mail}>Php function</option>

            <option value="sendmail" {sendmail}>Sendmail</option>

            

        </select></td>

      </tr>

      <tr>

        <td><strong>Http host (http://)</strong></td>

        <td><input type="text" name="setting_item[http_host]"  style="width:300px;" value="{http_host}" /></td>

      </tr>

      <tr>

        <td><strong>SMTP host</strong></td>

        <td><input type="text" name="setting_item[smtp_host]"  style="width:300px;" value="{smtp_host}" /></td>

      </tr>

      <tr>

        <td><strong>SMTP username</strong></td>

        <td><input type="text" name="setting_item[smtp_username]"   style="width:300px;" value="{smtp_username}" /></td>

      </tr>

      <tr>

        <td><strong>SMTP password</strong></td>

        <td><input name="setting_item[smtp_password]" type="password"  style="width:300px;" value="{smtp_password}"></td>

      </tr>

      <tr>

        <td><strong>Time offset</strong></td>

        <td>{select_time_offsets} ({currentdate})</td>

      </tr>

      <tr>

        <td><strong>Dùng nén GZip</strong></td>

        <td><label class="radio"><input type="radio" name="setting_item[gz_compress]" id="radio" value="1" {gz_compress_yes}>Có</label>

            <label class="radio"><input type="radio" name="setting_item[gz_compress]" id="radio" value="0" {gz_compress_no}>Không</label>

        </td>

      </tr>

      <tr>

        <td>&nbsp;</td>

        <td><a class="btn btn-primary" onclick="$('#inputform').submit(); return false"><i class="icon-ok-circle icon-white"></i>&nbsp;Cập nhật</a><div onclick="window.location='?page={par_page}&pid={pid}'" class="btn btn-inverse" style="margin-left:10px;"><i class="icon-remove icon-white"></i>&nbsp;Đóng</div></td>

      </tr>

    </table>

</form>

<div class="divider1"><span></span></div>







<div class="divider1"><span></span></div>

<div id="divremovea" style="display:none"></div>

</div>



