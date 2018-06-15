<div>
<form action="" method="post" id="redirect_form">
  	<table width="730" border="0" cellspacing="0" cellpadding="0" class="table-bordered tabletdnone">
	  <tr>
	    <td width="300">
        	<div class="input-prepend">
				  <span class="add-on">Url</span>
				  <input class="span2" name="url[]" type="text" placeholder="Username" style="width:250px">
			</div>
		</td>
	    <td width="400">
        	<div class="input-prepend">
				  <span class="add-on">Url chuyển đến</span>
				  <input class="span2" id="prependedInput" type="text" placeholder="Username" style="width:270px">
			</div>
        </td>
        <td width="30px;"><span class="label label-info"><a href="#" class="icon-trash icon-white"></a></span></td>
	  </tr>
	  <tr>
	    <td width="300">
        	<div class="input-prepend">
				  <span class="add-on">Url</span>
				  <input class="span2" id="prependedInput" type="text" placeholder="Username" style="width:250px">
			</div>
		</td>
	    <td width="400">
        	<div class="input-prepend">
				  <span class="add-on">Url chuyển đến</span>
				  <input class="span2" id="prependedInput" type="text" placeholder="Username" style="width:270px">
			</div>
        </td>
        <td width="30px;"><span class="label label-info"><a href="#" class="icon-trash icon-white"></a></span></td>
	  </tr>
      <tr>
	    <td width="300">
        	<div class="input-prepend">
				  <span class="add-on">Url</span>
				  <input class="span2" id="prependedInput" type="text" placeholder="Username" style="width:250px">
			</div>
		</td>
	    <td width="400">
        	<div class="input-prepend">
				  <span class="add-on">Url chuyển đến</span>
				  <input class="span2" id="prependedInput" type="text" placeholder="Username" style="width:270px">
			</div>
        </td>
        <td width="30px;"><span class="label label-info"><a href="#" class="icon-trash icon-white"></a></span></td>
	  </tr>
      <tr>
	    <td width="300">
        	<div class="input-prepend">
				  <span class="add-on">Url</span>
				  <input class="span2" id="prependedInput" type="text" placeholder="Username" style="width:250px">
			</div>
		</td>
	    <td width="400">
        	<div class="input-prepend">
				  <span class="add-on">Url chuyển đến</span>
				  <input class="span2" id="prependedInput" type="text" placeholder="Username" style="width:270px">
			</div>
        </td>
        <td width="30px;"><span class="label label-info"><a href="#" class="icon-trash icon-white"></a></span></td>
	  </tr>
	  <tr>
	    <td><a href="#" class="btn" id="btnAdd"><i class="icon-plus"></i>&nbsp;Thêm</a></td>
	    <td>&nbsp;</td>
        <td>&nbsp;</td>
	  </tr>
      <tr>
	    <td><button class="btn btn-primary"><i class="icon-ok-sign icon-white"></i>&nbsp;Cập nhật</button></td>
	    <td>&nbsp;</td>
        <td>&nbsp;</td>
	  </tr>
	</table>
</form>
</div>
<script>
	$(function(){
		$('#redirect_form a.icon-trash').click(function(){
			$(this).parent().parent().parent().remove();
		});
		
		$('#redirect_form #btnAdd').click(function(){
				
		});
	});
</script>