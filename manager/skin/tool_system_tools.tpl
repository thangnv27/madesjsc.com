

<div class="c5"></div>

<div class="breadLine">

    <ul class="breadcrumb">

        <li><a href="?"><i class="icon-home"></i></a></li>

        System tools

    </ul>

</div>

<div class="c20"></div>

  

<div class="wraper-content">

<!-- START BLOCK : msg -->

<div>{msg}</div>

<!-- END BLOCK : msg --> 

<div>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-bordered tabletdnone">

  <tr>

    <td>

    	<a href="#" class="btn" id="btnClearCacheFile"><i class="icon-trash"></i>&nbsp;Xóa files Cache</a>

        <a href="#" class="btn" id="btnWriteSimap" style="margin-left:20px;"><i class="icon-list"></i>&nbsp;Cập nhật sitemap.xml</a>

        <a href="#" class="btn" id="btnRobots" style="margin-left:20px;"><i class="icon-list"></i>&nbsp;Cập nhật robots.txt</a>
        

        <!--<a href="#" class="btn" id="btnRedirect" style="margin-left:20px;"><i class="icon-wrench"></i>&nbsp;Cài đặt redirect 301</a>-->

    </td>

  </tr>

  <tr>

    <td >

    	<div id="action_show" style="position:relative; min-height:200px;"></div>

    </td>

  </tr>

</table>

</div>

<div class="divider1"><span></span></div>

<div id="divremovea" style="display:none"></div>

</div>

<script>

	$(function(){

		$('#btnClearCacheFile').click(function(){

			$('#btnClearCacheFile').attr("disabled", "disabled");

			$('#btnClearCacheFile').html('<i class="loadingbtn"></i> Đang xóa files ...');

			$('#action_show').append('<div class="loading"></div>');

			$("#action_show").load("index4.php?page=tool_clearcachefile", function(response, status, xhr) {

			  if (status == "success") {

			   		$('#btnClearCacheFile').html('<i class="icon-trash"></i> Xóa files Cache');

					$('#btnClearCacheFile').removeAttr("disabled");

			  }

			});

		});

		

		$('#btnWriteSimap').click(function(){

			$('#btnWriteSimap').attr("disabled", "disabled");

			$('#btnWriteSimap').html('<i class="loadingbtn"></i> Đang cập nhật sitemap.xml ...');

			$('#action_show').append('<div class="loading"></div>');

			$("#action_show").load("index4.php?page=tool_write_sitemap", function(response, status, xhr) {

			  if (status == "success") {

			   		$('#btnWriteSimap').html('<i class="icon-list"></i> Cập nhật sitemap.xml');

					$('#btnWriteSimap').removeAttr("disabled");

			  }

			});

		});

		

		$('#btnRobots').click(function(){

			$('#btnRobots').attr("disabled", "disabled");

			$('#btnRobots').html('<i class="loadingbtn"></i> Đang tải robots.txt ...');

			$('#action_show').append('<div class="loading"></div>');

			$("#action_show").load("index4.php?page=tool_robots", function(response, status, xhr) {

			  if (status == "success") {

			   		$('#btnRobots').html('<i class="icon-list"></i> Cập nhật robots.txt');

					$('#btnRobots').removeAttr("disabled");

			  }

			});

		});

		$('#btnRedirect').click(function(){

			$('#btnRedirect').attr("disabled", "disabled");

			$('#btnRedirect').html('<i class="loadingbtn"></i> Đang tải ...');

			$('#action_show').append('<div class="loading"></div>');

			$("#action_show").load("index4.php?page=tool_redirects", function(response, status, xhr) {

			  if (status == "success") {

			   		$('#btnRedirect').html('<i class="icon-wrench"></i> Cài đặt Redirect 301');

					$('#btnRedirect').removeAttr("disabled");

			  }

			});

		});

	})

</script>