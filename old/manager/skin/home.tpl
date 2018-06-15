<div style="padding-top:30px;">
	<a href="?page=contact">
	    <div class="cellContact">
        	<div class="icon"><span class="badge badge-warning">{countcontact}</span></div>
	    	<div class="name">Danh sách liên hệ</div>
	    </div>
    </a>
    <a href="?page=order">
	    <div class="cellCart">
        	<div class="icon"><span class="badge badge-warning">{countcart}</span></div>
	    	<div class="name">Danh sách đặt hàng</div>
	    </div>
    </a>
	<!-- START BLOCK : cell -->
    <a href="{link}">
	    <div class="cellHome">
        	<div class="name">{name}</div>
	    </div>
    </a>
    <!-- END BLOCK : cell -->
    <div class="c10"></div>
    <button id="btn_update_sitemap" class="btn">Cập nhật sitemap.xml</button>
    <script>
    	$(function(){
			$('#btn_update_sitemap').click(function(){
				$('#btn_update_sitemap').text('Đang cập nhật...');
				$("#btn_update_sitemap").load("index4.php?page=tool_write_sitemap", function(response, status, xhr) {
			  if (status == "error") {
				$('#btn_update_sitemap').text('Cập nhật sitemap.xml');
			  }
			});
			});
		});
    </script>
</div> 