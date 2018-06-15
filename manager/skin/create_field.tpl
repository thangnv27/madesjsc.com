<script src="./js/jquery.form.min.js"></script>
<form action="{action}" method="post" id="add_form_field">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-bordered tabletdnone" >
      <tr>
        <td width="150"><strong>Field name</strong></td>
        <td><input type="text" name="column_name" class="txtform100 notNull" style="width:250px;" value="{column_name}" data-alert="Bạn cần nhập vào tiêu đề tên trường" /> 
          <span class="noteform">Ex: HoTen</span></td>
      </tr>
      <tr>
        <td><strong>Placeholder</strong></td>
        <td><input type="text" name="placeholder" class="txtform100 notNull" style="width:250px;" value="{placeholder}" /></td>
      </tr>
      <tr>
        <td><strong>Allow empty value</strong></td>
        <td><label><input name="allow_empty_value" type="checkbox" value="1" {allow_empty_value}> 
        <span class="noteform">Checked is allow empty value</span></label></td>
        </tr>
      <tr>
        <td><strong>Default value</strong></td>
        <td><input type="text" name="default_value" class="txtform100" style="width:250px;" value="{default_value}"/></td>
        </tr>
      <tr>
        <td><strong>Caption</strong></td>
        <td><input type="text" name="field_caption" class="txtform100" style="width:250px;" value="{field_caption}"/></td>
        </tr>
      <tr>
        <td valign="top"><strong>Control</strong></td>
        <td>
          <div>
            <select name="control_type" id="control_type" style="width:260px;">
              <option value="text" {text}>Text</option>
              <option value="textarea" {textarea}>Text area</option>
              <option value="dropdownlist" {dropdownlist}>Dropdown list</option>
              <option value="radio" {radio}>Radio</option>
              <option value="checkbox" {checkbox}>Checkbox</option>
              <option value="email" {email}>Email</option>
              <!--<option value="date" {date}>Date</option>-->
              <option value="captcha" {captcha}>CAPTCHA</option>
              <option value="submitbuttom" {submitbuttom}>Submit button</option>
            </select>
            </div>
          <script>
		  		
          		$(function(){
					
					show_data_source_option($('#control_type option:selected').val());
					$('#control_type').change(function(){
						show_data_source_option($(this).val());
					});
				});
				
				function show_data_source_option(type){
					if(type == 'dropdownlist' || type == 'checkbox' || type == 'radio'){
						$('#data_source_option').slideDown();
					}else{
						$('#data_source_option').slideUp();							
					}
				}
          </script>
          <div style="padding-top:5px;" id="data_source_option" class="display_none">
            <div><label class="radio"><input name="data_source_type" type="radio" value="option" {option}>
              Option</label></div>
            <div><label class="radio"><input name="data_source_type" type="radio" value="sqlquery" {sqlquery}>SQL query</label></div>
            <div class="c5"></div>
            <div>
            	<textarea name="data_source_text"  rows="5" style="width:250px; max-width:500px; max-height:300px; float:left">{data_source_text}</textarea>
                <div class="noteform" style="float:left; margin-left:5px; width:230px">
                	<strong>Ex:</strong><br />
                	Option - Value:name;<br />
                    SQL query - select tow field: value and name</div>
            </div>
            </div>
        </td>
        </tr>
      <tr>
        <td><strong>Error message</strong></td>
        <td><input type="text" name="error_message" class="txtform100" style="width:250px;" value="{error_message}"/></td>
        </tr>
      <tr>
        <td><strong>Class name caption</strong></td>
        <td><input type="text" name="caption_css_class" class="txtform100" style="width:250px;" value="{caption_css_class}"/></td>
      </tr>
      <tr>
        <td><strong>Caption style</strong></td>
        <td><input type="text" name="caption_style" class="txtform100" style="width:250px;" value="{caption_style}"/></td>
      </tr>
      <tr>
        <td><strong>Class name control</strong></td>
        <td><input type="text" name="control_css_class" class="txtform100" style="width:250px;" value="{control_css_class}"/></td>
        </tr>
      <tr>
        <td><strong>Control style</strong></td>
        <td><input type="text" name="input_style" class="txtform100" style="width:250px;" value="{input_style}"/> 
          <span class="noteform"><strong>Ex:</strong> width:250px; height: 30px;</span></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td><a class="btn btn-primary" onclick="$('#add_form_field').submit(); return false"><i class="icon-ok-circle icon-white"></i>&nbsp;Cập nhật</a><div onclick="window.location='?page=create_field_form&pid={pid}'" class="btn btn-inverse" style="margin-left:10px;"><i class="icon-remove icon-white"></i>&nbsp;Đóng</div></td>
      </tr>
    </table>
</form>
<script>
	$(document).ready(function() { 
		var options = { 
			target:        '#create_field_form', 
			success: submit_form_success
		}; 
		$('#add_form_field').submit(function() { 
			$("#create_field_form").append('<div class="loading"></div>');
			$(this).ajaxSubmit(options); 
			return false; 
		}); 
	}); 
	function submit_form_success(){
		$("#create_field_form .loading").remove();
		load_field_list();
	}
	
</script>