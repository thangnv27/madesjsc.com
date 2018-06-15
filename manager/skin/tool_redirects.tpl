<script src="./js/jquery.form.min.js"></script>

{msg}
<form action="index4.php?page=tool_redirects" method="post" id="update_robots_form">
  <input type="hidden" name="gone" value="1" />
  <div>
  	<div style="padding-bottom:3px;">VD: 'url cũ' => 'url mới'</div>
    <textarea name="robots_view" style="width:500px; height:400px">{content}</textarea>
  </div>
  <div style="height:10px;"></div>
  <div>
    <button class="btn btn-primary">Cập nhật</button>
  </div>
</form>
<div style="height:10px;"></div>
<script>
	$(document).ready(function() { 
    var options = { 
        target:        '#action_show',  
       // beforeSubmit:  showRequest,  
        success:       function (){ $('#btnRobots').removeAttr("disabled"); }  
    }; 

    // bind to the form's submit event 
    $('#update_robots_form').submit(function() { 
		$('#btnRobots').attr("disabled", "disabled");
		$('#action_show').append('<div class="loading"></div>');
        $(this).ajaxSubmit(options); 
        return false; 
    }); 
}); 

</script>