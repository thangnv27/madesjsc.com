
<div class="c5"></div>
<div class="breadLine">
    <ul class="breadcrumb">
        <li><a href="?"><i class="icon-home"></i></a></li>
        Cấu hình ngôn ngữ
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
        <th colspan="2"><i class="icon-pencil icon-white"></i>Cấu hình</th>
      </tr>
      <tr>
        <td width="150"><strong>Tin khác</strong></td>
        <td>
        	<div class="divlang">FR
        	  <input name="static_lang[_othernews][vn]" type="text" class="txtlang" value="{_othernewsvn}"><span style="color:#ccc; margin-left:5px;">_othernews</span></div>
            <div class="divlang">EN<input name="static_lang[_othernews][en]" type="text" class="txtlang" value="{_othernewsen}"/></div>
        </td>
      </tr>
      <tr>
        <td width="150"><strong>Trang chủ</strong></td>
        <td>
        	<div class="divlang">FR
        	  <input name="static_lang[_home][vn]" type="text" class="txtlang" value="{_homevn}"><span style="color:#ccc; margin-left:5px;">_home</span></div>
            <div class="divlang">EN<input name="static_lang[_home][en]" type="text" class="txtlang" value="{_homeen}"></div>
        </td>
      </tr>
       <tr>
        <td width="150"><strong>Chi tiết</strong></td>
        <td>
        	<div class="divlang">FR<input name="static_lang[_detail][vn]" type="text" class="txtlang" value="{_detailvn}"><span style="color:#ccc; margin-left:5px;">_detail</span></div>
            <div class="divlang">EN<input name="static_lang[_detail][en]" type="text" class="txtlang" value="{_detailen}"></div>
        </td>
      </tr>
      <tr>
        <td width="150"><strong>Trang</strong></td>
        <td>
        	<div class="divlang">FR<input name="static_lang[_page][vn]" type="text" class="txtlang" value="{_pagevn}"><span style="color:#ccc; margin-left:5px;">_page</span></div>
            <div class="divlang">EN<input name="static_lang[_page][en]" type="text" class="txtlang" value="{_pageen}"></div>
        </td>
      </tr>
       <tr>
        <td width="150"><strong>Họ tên</strong></td>
        <td>
        	<div class="divlang">FR<input name="static_lang[_fullname][vn]" type="text" class="txtlang" value="{_fullnamevn}"><span style="color:#ccc; margin-left:5px;">_fullname</span></div>
            <div class="divlang">EN<input name="static_lang[_fullname][en]" type="text" class="txtlang" value="{_fullnameen}"></div>
        </td>
      </tr>
      <tr>
        <td width="150"><strong>Quốc tịch</strong></td>
        <td>
        	<div class="divlang">FR<input name="static_lang[_nationality][vn]" type="text" class="txtlang" value="{_nationalityvn}"><span style="color:#ccc; margin-left:5px;">_nationality</span></div>
            <div class="divlang">EN<input name="static_lang[_nationality][en]" type="text" class="txtlang" value="{_nationalityen}"></div>
        </td>
      </tr>
      <tr>
        <td width="150"><strong>Email</strong></td>
        <td>
        	<div class="divlang">FR<input name="static_lang[_email][vn]" type="text" class="txtlang" value="{_emailvn}"><span style="color:#ccc; margin-left:5px;">_email</span></div>
            <div class="divlang">EN<input name="static_lang[_email][en]" type="text" class="txtlang" value="{_emailen}"></div>
        </td>
      </tr>
      <tr>
        <td width="150"><strong>Điện thoại</strong></td>
        <td>
        	<div class="divlang">FR<input name="static_lang[_phone][vn]" type="text" class="txtlang" value="{_phonevn}"><span style="color:#ccc; margin-left:5px;">_phone</span></div>
            <div class="divlang">EN<input name="static_lang[_phone][en]" type="text" class="txtlang" value="{_phoneen}"></div>
        </td>
      </tr>
      <tr>
        <td width="150"><strong>Địa chỉ</strong></td>
        <td>
        	<div class="divlang">FR
        	  <input name="static_lang[_address][vn]" type="text" class="txtlang" value="{_addressvn}"><span style="color:#ccc; margin-left:5px;">_address</span></div>
            <div class="divlang">EN<input name="static_lang[_address][en]" type="text" class="txtlang" value="{_addressen}"></div>
        </td>
      </tr>
      <tr>
        <td width="150"><strong>Nội dung</strong></td>
        <td>
        	<div class="divlang">FR
        	  <input name="static_lang[_content][vn]" type="text" class="txtlang" value="{_contentvn}"><span style="color:#ccc; margin-left:5px;">_content</span></div>
            <div class="divlang">EN<input name="static_lang[_content][en]" type="text" class="txtlang" value="{_contenten}"></div>
        </td>
      </tr>
      <tr>
        <td width="150"><strong>Gửi</strong></td>
        <td>
        	<div class="divlang">FR
        	  <input name="static_lang[_send][vn]" type="text" class="txtlang" value="{_sendvn}"><span style="color:#ccc; margin-left:5px;">_send</span></div>
            <div class="divlang">EN<input name="static_lang[_send][en]" type="text" class="txtlang" value="{_senden}"></div>
        </td>
      </tr>
       <tr>
        <td width="150"><strong>Tiếp tục</strong></td>
        <td>
        	<div class="divlang">FR
        	  <input name="static_lang[_continue][vn]" type="text" class="txtlang" value="{_continuevn}"><span style="color:#ccc; margin-left:5px;">_send</span></div>
            <div class="divlang">EN<input name="static_lang[_continue][en]" type="text" class="txtlang" value="{_continueen}"></div>
        </td>
      </tr>
      <tr>
        <td width="150"><strong>Số người tham gia</strong></td>
        <td>
        	<div class="divlang">FR
        	  <input name="static_lang[number_of_participants][vn]" type="text" class="txtlang" value="{number_of_participantsvn}"><span style="color:#ccc; margin-left:5px;">number_of_participants</span></div>
            <div class="divlang">EN<input name="static_lang[number_of_participants][en]" type="text" class="txtlang" value="{number_of_participantsen}"></div>
        </td>
      </tr>
      <tr>
        <td width="150"><strong>Nhập lại</strong></td>
        <td>
        	<div class="divlang">FR
        	  <input name="static_lang[_reset][vn]" type="text" class="txtlang" value="{_resetvn}"><span style="color:#ccc; margin-left:5px;">_reset</span></div>
            <div class="divlang">EN<input name="static_lang[_reset][en]" type="text" class="txtlang" value="{_reseten}"></div>
        </td>
      </tr>
      <tr>
        <td><strong>Thông báo nhập họ tên</strong></td>
        <td>
       	  <div class="divlang">FR
        	  <input name="static_lang[_entername][vn]" type="text" class="txtlang" value="{_enternamevn}">
       	    <span style="color:#ccc; margin-left:5px;">_entername</span></div>
            <div class="divlang">EN<input name="static_lang[_entername][en]" type="text" class="txtlang" value="{_enternameen}"></div>	
         </td>
      </tr>
       <tr>
        <td><strong>Đăng ký nhận bản tin</strong></td>
        <td>
       	  <div class="divlang">FR
        	  <input name="static_lang[_newslater][vn]" type="text" class="txtlang" value="{_newslatervn}">
       	    <span style="color:#ccc; margin-left:5px;">_newslater</span></div>
            <div class="divlang">EN<input name="static_lang[_newslater][en]" type="text" class="txtlang" value="{_newslateren}"></div>	
         </td>
      </tr>
      <tr>
        <td><strong>Thông báo nhập điện thoại</strong></td>
        <td>
       	  <div class="divlang">FR
        	  <input name="static_lang[_entertelephone][vn]" type="text" class="txtlang" value="{_entertelephonevn}">
       	    <span style="color:#ccc; margin-left:5px;">_entertelephone</span></div>
            <div class="divlang">EN<input name="static_lang[_entertelephone][en]" type="text" class="txtlang" value="{_entertelephoneen}"></div>	</td>
      </tr>
      <tr>
        <td><strong>Thông báo nhập email</strong></td>
        <td><div class="divlang">FR
        	  <input name="static_lang[_enteremail][vn]" type="text" class="txtlang" value="{_enteremailvn}">
        	  <span style="color:#ccc; margin-left:5px;">_enteremail</span></div>
            <div class="divlang">EN<input name="static_lang[_enteremail][en]" type="text" class="txtlang" value="{_enteremailen}"></div></td>
      </tr>
      
	<tr>
        <td><strong>Thông báo email không hợp lệ</strong></td>
        <td><div class="divlang">FR
        	  <input name="static_lang[_invalid_email][vn]" type="text" class="txtlang" value="{_invalid_emailvn}">
        	  <span style="color:#ccc; margin-left:5px;">_invalid_email</span></div>
            <div class="divlang">EN<input name="static_lang[_invalid_email][en]" type="text" class="txtlang" value="{_invalid_emailen}"></div></td>
      </tr>
      
      <tr>
        <td><strong>Thông báo email nhập lại không trùng</strong></td>
        <td><div class="divlang">FR
        	  <input name="static_lang[_confirm_email_notvalid][vn]" type="text" class="txtlang" value="{_confirm_email_notvalidvn}">
        	  <span style="color:#ccc; margin-left:5px;">_confirm_email_notvalid</span></div>
            <div class="divlang">EN<input name="static_lang[_confirm_email_notvalid][en]" type="text" class="txtlang" value="{_confirm_email_notvaliden}"></div></td>
      </tr>      
      
      <tr>
        <td><strong>Thông báo nhập nội dung liên hệ</strong></td>
        <td><div class="divlang">FR
        	  <input name="static_lang[_entermessage][vn]" type="text" class="txtlang" value="{_entermessagevn}">
        	  <span style="color:#ccc; margin-left:5px;">_entermessage</span></div>
            <div class="divlang">EN<input name="static_lang[_entermessage][en]" type="text" class="txtlang" value="{_entermessageen}"></div></td>
      </tr>

      <tr>
        <td><strong>Thông báo gửi form liên hệ</strong></td>
        <td><div class="divlang">FR
        	  <input name="static_lang[_message_send][vn]" type="text" class="txtlang" value="{_message_sendvn}">
        	  <span style="color:#ccc; margin-left:5px;">_message_send</span></div>
            <div class="divlang">EN<input name="static_lang[_message_send][en]" type="text" class="txtlang" value="{_message_senden}"></div></td>
      </tr>

      <tr>
        <td><strong>Thông báo CAPTCHA không đúng</strong></td>
        <td><div class="divlang">FR
        	  <input name="static_lang[_captcha_error][vn]" type="text" class="txtlang" value="{_captcha_errorvn}">
        	  <span style="color:#ccc; margin-left:5px;">_captcha_error</span></div>
            <div class="divlang">EN<input name="static_lang[_captcha_error][en]" type="text" class="txtlang" value="{_captcha_erroren}"></div></td>
      </tr>
      
      
      <tr>
        <td><strong>Thông báo nhập địa chỉ</strong></td>
        <td><div class="divlang">FR
        	  <input name="static_lang[_enteraddress][vn]" type="text" class="txtlang" value="{_enteraddressvn}">
        	  <span style="color:#ccc; margin-left:5px;">_enteraddress</span></div>
            <div class="divlang">EN<input name="static_lang[_enteraddress][en]" type="text" class="txtlang" value="{_enteraddressen}"></div></td>
      </tr>
      <tr>
        <td><strong>Tìm kiếm </strong></td>
        <td><div class="divlang">FR
        	  <input name="static_lang[_searchsite][vn]" type="text" class="txtlang" value="{_searchsitevn}">
        	  <span style="color:#ccc; margin-left:5px;">_search</span></div>
            <div class="divlang">EN<input name="static_lang[_searchsite][en]" type="text" class="txtlang" value="{_searchsiteen}"></div></td>
      </tr>
      <tr>
        <td><strong>Từ khóa </strong></td>
        <td><div class="divlang">FR
        	  <input name="static_lang[_keywords][vn]" type="text" class="txtlang" value="{_keywordsvn}">
        	  <span style="color:#ccc; margin-left:5px;">_keywords</span></div>
            <div class="divlang">EN<input name="static_lang[_keywords][en]" type="text" class="txtlang" value="{_keywordsen}"></div></td>
      </tr>
       <tr>
        <td><strong>Loại tour</strong></td>
        <td><div class="divlang">FR
        	  <input name="static_lang[_tourtype][vn]" type="text" class="txtlang" value="{_tourtypevn}">
        	  <span style="color:#ccc; margin-left:5px;">_tourtype</span></div>
            <div class="divlang">EN<input name="static_lang[_tourtype][en]" type="text" class="txtlang" value="{_tourtypeen}"></div></td>
      </tr>
      <tr>
        <td><strong>Điểm đến</strong></td>
        <td><div class="divlang">FR
        	  <input name="static_lang[_destination][vn]" type="text" class="txtlang" value="{_destinationvn}">
        	  <span style="color:#ccc; margin-left:5px;">_destination</span></div>
            <div class="divlang">EN<input name="static_lang[_destination][en]" type="text" class="txtlang" value="{_destinationen}"></div></td>
      </tr>
      <tr>
        <td><strong>Tìm kiếm tour</strong></td>
        <td><div class="divlang">FR
        	  <input name="static_lang[_searchtour][vn]" type="text" class="txtlang" value="{_searchtourvn}">
        	  <span style="color:#ccc; margin-left:5px;">_searchtour</span></div>
            <div class="divlang">EN<input name="static_lang[_searchtour][en]" type="text" class="txtlang" value="{_searchtouren}"></div></td>
      </tr>
      <tr>
        <td><strong>Đăng ký</strong></td>
        <td><div class="divlang">FR
        	  <input name="static_lang[_signup][vn]" type="text" class="txtlang" value="{_signupvn}">
        	  <span style="color:#ccc; margin-left:5px;">_searchtour</span></div>
            <div class="divlang">EN<input name="static_lang[_signup][en]" type="text" class="txtlang" value="{_signupen}"></div></td>
      </tr>
      <tr>
        <td><strong>Giới thiệu</strong></td>
        <td><div class="divlang">FR
        	  <input name="static_lang[_aboutus][vn]" type="text" class="txtlang" value="{_aboutusvn}">
        	  <span style="color:#ccc; margin-left:5px;">_aboutus</span></div>
            <div class="divlang">EN<input name="static_lang[_aboutus][en]" type="text" class="txtlang" value="{_aboutusen}"></div></td>
      </tr>
       <tr>
        <td><strong>Khách của chúng tôi</strong></td>
        <td><div class="divlang">FR
        	  <input name="static_lang[_orutravellers][vn]" type="text" class="txtlang" value="{_orutravellersvn}">
        	  <span style="color:#ccc; margin-left:5px;">_orutravellers</span></div>
            <div class="divlang">EN<input name="static_lang[_orutravellers][en]" type="text" class="txtlang" value="{_orutravellersen}"></div></td>
      </tr>
      <tr>
        <td><strong>Nhập ngày đề nghị</strong></td>
        <td><div class="divlang">FR
        	  <input name="static_lang[_proposalarrivaldate][vn]" type="text" class="txtlang" value="{_proposalarrivaldatevn}">
        	  <span style="color:#ccc; margin-left:5px;">_proposalarrivaldate</span></div>
            <div class="divlang">EN<input name="static_lang[_proposalarrivaldate][en]" type="text" class="txtlang" value="{_proposalarrivaldateen}"></div></td>
      </tr>
      <tr>
        <td><strong>Nhập độ dài chuyến đi</strong></td>
        <td><div class="divlang">FR
        	  <input name="static_lang[_totallengthofyourtrip][vn]" type="text" class="txtlang" value="{_totallengthofyourtripvn}">
        	  <span style="color:#ccc; margin-left:5px;">_totallengthofyourtrip</span></div>
            <div class="divlang">EN<input name="static_lang[_totallengthofyourtrip][en]" type="text" class="txtlang" value="{_totallengthofyourtripen}"></div></td>
      </tr>
      <tr>
        <td><strong>Nhập ngày dự kiến khởi hành</strong></td>
        <td><div class="divlang">FR
        	  <input name="static_lang[_proposalstartdate][vn]" type="text" class="txtlang" value="{_proposalstartdatevn}">
        	  <span style="color:#ccc; margin-left:5px;">_proposalstartdate</span></div>
            <div class="divlang">EN<input name="static_lang[_proposalstartdate][en]" type="text" class="txtlang" value="{_proposalstartdateen}"></div></td>
      </tr>
      <tr>
        <td><strong>Số người lớn</strong></td>
        <td><div class="divlang">FR
        	  <input name="static_lang[_numberofadults][vn]" type="text" class="txtlang" value="{_numberofadultsvn}">
        	  <span style="color:#ccc; margin-left:5px;">_numberofadults</span></div>
            <div class="divlang">EN<input name="static_lang[_numberofadults][en]" type="text" class="txtlang" value="{_numberofadultsen}"></div></td>
      </tr>
       <tr>
        <td><strong>Số trẻ em</strong></td>
        <td><div class="divlang">FR
        	  <input name="static_lang[_numberofchildren][vn]" type="text" class="txtlang" value="{_numberofchildrenvn}">
        	  <span style="color:#ccc; margin-left:5px;">_numberofchildren</span></div>
            <div class="divlang">EN<input name="static_lang[_numberofchildren][en]" type="text" class="txtlang" value="{_numberofchildrenen}"></div></td>
      </tr>
      <tr>
        <td><strong>Nhập vào title</strong></td>
        <td><div class="divlang">FR
        	  <input name="static_lang[_entertitle][vn]" type="text" class="txtlang" value="{_entertitlevn}">
        	  <span style="color:#ccc; margin-left:5px;">_entertitle</span></div>
            <div class="divlang">EN<input name="static_lang[_entertitle][en]" type="text" class="txtlang" value="{_entertitleen}"></div></td>
      </tr>
      <tr>
        <td><strong>Nhập vào câu hỏi</strong></td>
        <td><div class="divlang">FR
        	  <input name="static_lang[enterquestion][vn]" type="text" class="txtlang" value="{enterquestionvn}">
        	  <span style="color:#ccc; margin-left:5px;">enterquestion</span></div>
            <div class="divlang">EN<input name="static_lang[enterquestion][en]" type="text" class="txtlang" value="{enterquestionen}"></div></td>
      </tr>
      <tr>
        <td><strong>Thông báo trang 404</strong></td>
        <td><div class="divlang">FR
        	  <textarea name="static_lang[page404][vn]" style="width:300px;" rows="5">{page404vn}</textarea>
        	  <span style="color:#ccc; margin-left:5px;">page404</span></div>
            <div class="divlang">EN
            	<textarea name="static_lang[page404][en]" style="width:300px;" rows="5">{page404en}</textarea>
          </div>
        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><a class="btn btn-primary" onClick="$('#inputform').submit(); return false"><i class="icon-ok-circle icon-white"></i>&nbsp;Cập nhật</a></td>
      </tr>
    </table>
</form>


<!-- END BLOCK : AddNew -->


<div class="divider1"><span></span></div>

</div>
