<script src="js/jquery.form.min.js"></script>
<div id="status-pro"></div>
<form action="index4.php?page=action_ajax&code=updatephoto&id={id}" method="post" id="editphotoform">
<table width="100%" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td width="170" rowspan="3" align="center" valign="top"><a href="{bigimage}" class="highslide" onclick="return hs.expand(this)">{image}</a></td>
    <td align="right" valign="top"><strong>Nhóm</strong></td>
    <td>{parentid}</td>
  </tr>
  <tr>
    <td width="100px;" align="right" valign="top"><strong>Tên</strong></td>
    <td><input name="name" id="name" type="text" value="{name}" style="width:250px;"></td>
  </tr>
  <tr>
    <td align="right" valign="top"><strong>Mô tả</strong></td>
    <td>
    	<textarea name="content" id="content" cols="" rows="5" style="width:250px;">{content}</textarea>
    </td>
  </tr>
</table>
</form>
<script>
$(document).ready(function() { 
    var options = { 
      //  target:        '#output2',   // target element(s) to be updated with server response 
        beforeSubmit:  showRequest,  // pre-submit callback 
        success:       showResponse  // post-submit callback 
 
        // other available options: 
        //url:       url         // override for form's 'action' attribute 
        //type:      type        // 'get' or 'post', override for form's 'method' attribute 
        //dataType:  null        // 'xml', 'script', or 'json' (expected server response type) 
        //clearForm: true        // clear all form fields after successful submit 
        //resetForm: true        // reset the form after successful submit 
 
        // $.ajax options can be used here too, for example: 
        //timeout:   3000 
    }; 
 
    // bind to the form's submit event 
    $('#editphotoform').submit(function() { 
        $(this).ajaxSubmit(options); 
        return false; 
    }); 
}); 
 
// pre-submit callback 
function showRequest(formData, jqForm, options) { 
    // formData is an array; here we use $.param to convert it to a string to display it 
    // but the form plugin does this for you automatically when it submits the data 
    var queryString = $.param(formData); 
 
    // jqForm is a jQuery object encapsulating the form element.  To access the 
    // DOM element for the form do this: 
    // var formElement = jqForm[0]; 
 
   // alert('About to submit: \n\n' + queryString); 
    show_mes('Đang thực hiện ...');
 	$('#status-pro').html('<div class="alert alert-info">Đang tải ...</div>');
    // here we could return false to prevent the form from being submitted; 
    // returning anything other than false will allow the form submit to continue 
    return true; 
} 
 
// post-submit callback 
function showResponse(responseText, statusText, xhr, $form)  { 
    show_mes('Đã sửa xong !');
    $('#myModal').modal('hide');
} 

</script>