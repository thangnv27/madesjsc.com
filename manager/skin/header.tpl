<!DOCTYPE HTML>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Administrator</title>
<link rel="stylesheet" href="../css/font-awesome-4.2.0/css/font-awesome.min.css" type="text/css">
<link rel="stylesheet" href="js/jQuery-File-Upload/css/jquery.fileupload-ui.css">
<link type="text/css" href="css/ui-lightness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<script language="javascript" src="js/jquery-1.10.2.min.js"></script>
<script language="javascript" src="js/bootstrap.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>
<script type="text/javascript" src="js/timepicker.js"></script>
<script type="text/javascript" src="js/jquery.blockUI.js"></script>
<script language="javascript" src="js/script.js"></script>
<link rel="stylesheet" href="browser/css/elfinder.css" type="text/css">
<script src="browser/elfinderfull.js"></script>
<script>

	var lang = '{lang}';

</script>
</head>

<body>
<div class="wraper">
<div class="viewpage">
<div id="navbar-example" class="navbar navbar-inverse navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container" style="width: auto; margin-left:20px;"> <a class="brand" href="?page=">Administrator</a>
      <ul class="nav" role="navigation">
        <li class="dropdown"> <a id="drop1" href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-cog icon-white"></i>&nbsp;Hệ thống <b class="caret"></b></a>
          <ul class="dropdown-menu" role="menu" aria-labelledby="drop1">
            <li role="presentation"><a role="menuitem" tabindex="-1" href="?page=setting"><i class=" icon-asterisk"></i>&nbsp;Cấu hình hệ thống</a></li>
            
            <li role="presentation" style="display:none;"><a role="menuitem" tabindex="-1" href="?page=static_lang"><i class=" icon-asterisk"></i>&nbsp;Cấu hình ngôn ngữ</a></li>            
            
            <li role="presentation"><a role="menuitem" tabindex="-1" href="?page=settingshow"><i class="icon-th"></i>&nbsp;Cấu hình hiển thị</a></li>
            <li role="presentation"><a role="menuitem" tabindex="-1" href="?page=users"><i class="icon-user"></i>&nbsp;Quản lý người sử dụng</a></li>
            <li role="presentation"><a role="menuitem" tabindex="-1" href="?page=tool_system_tools"><i class="icon-user"></i>&nbsp;System tools</a></li>
          </ul>
        </li>
      </ul>
      <ul class="nav pull-right">
        <li id="fat-menu" class="dropdown"> <a href="#" id="drop3" role="button" class="dropdown-toggle" data-toggle="dropdown">Thông tin cá nhân <b class="caret"></b></a>
          <ul class="dropdown-menu" role="menu" aria-labelledby="drop3">
            <li role="presentation"><a role="menuitem" tabindex="-1" href="?page=profile"><i class="icon-user"></i>&nbsp;Thông tin cá nhân</a></li>
            <li role="presentation" class="divider"></li>
            <li role="presentation"><a role="menuitem" tabindex="-1" href="?code=logout"><i class="icon-minus-sign"></i>&nbsp;Đăng xuất</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablecontent">
<tr>
  <td valign="top" class="leftcol">
      
      
      <div class="divider1"><span></span></div>
      
      
            <div style="padding-left:15px; display:none">
                <form action="" method="get" id="changelang">
                    <select name="lang" id="lang" style="width:190px;">
                        <option value="default" {lang}>Tiếng Việt</option>
                        <option value="en" {langen}>English</option>
                    </select>
                </form>    
                <script>
                    $(function() {
                        $('#changelang').change(function() {
                            $('#changelang').submit();
                        });
                    });
                </script>
            </div>      
      
    <ul class="menuleft">
      <li><a href="?page=category"><i class="icon-folder-open"></i>Quản lý chuyên mục</a></li>
      <li><a href="?page=news"><i class="icon-list-alt"></i>Trang tin tức</a></li>
      <li><a href="?page=info"><i class="icon-file"></i>Trang nội dung</a></li>
      <li><a href="?page=logo"><i class="icon-globe"></i>Hệ thống logo-link-banner</a></li>
      <li><a href="?page=static"><i class="icon-list"></i>Nội dung tĩnh</a></li>
      <li><a href="?page=video"><i class="icon-list"></i>Videos</a></li>
      <div class="divider1"><span></span></div>
      <li><a href="?page=contactInfo"><i class="icon-list"></i>Trang liên hệ</a></li>
     <!-- <li><a href="?page=download"><i class="icon-list"></i>Tài liệu</a></li>-->
      <li><a href="?page=support"><i class="icon-list"></i>Hỗ trợ trực tuyến</a></li>
      <li><a href="?page=contact"><i class="icon-envelope"></i>Danh sách liên hệ</a></li>
      
      <li><a href="?page=comment"><i class="icon-list"></i>Duyệt bình luận</a></li>
      
      <li><a href="?page=newsletter"><i class="icon-list"></i>News Letter</a></li>
       <li><a href="?page=content_mail"><i class="icon-list"></i>Nội dung email trả lời đặt hàng</a></li>
      
    </ul>

    <!--<div class="divider1"><span></span></div>

      
  -->
    <div class="divider1"><span></span></div>

    <ul class="menuleft">
     	<li><a href="?page=product"><i class="icon-file"></i>Sản phẩm</a></li>
      	<li><a href="?page=attributePro"><i class="icon-file"></i>Thuộc tính Sản phẩm</a></li>
       <li><a href="?page=order"><i class="icon-file"></i>Danh sách đơn hàng</a></li>
    </ul>
    <div class="divider1"><span></span></div>

   
    <!--
    <ul class="menuleft">
      <li><a href="?page=order"><i class="icon-list"></i>Danh sách đơn hàng</a></li>
      <li><a href="?page=contact"><i class="icon-envelope"></i>Danh sách liên hệ</a></li>
    </ul>-->

   
    
    <div class="c"></div></td>
  <td valign="top" style="padding-left:5px;">
