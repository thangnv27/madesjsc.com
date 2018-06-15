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
        </table>

<table width="100%" id="myTable" border="0" cellspacing="0" cellpadding="0" class="table-bordered tabletdnone">        
<!--START BLOCK : label_list -->
            <tr>
                <td width="150"><strong>{labelname}</strong>
                    <br/>
                    <span style="color:#ccc; margin-left:5px;">{labelcode}</span>
                </td>
                <td>
                    <div class="divlang">Default
                        <input name="static_lang[{labelcode}][default]" type="text" class="txtlang" value="{labelvalue_default}">
                    </div>
                    <div class="divlang">English<input name="static_lang[{labelcode}][en]" type="text" class="txtlang" value="{labelvalue_en}"></div>
                    
                    {xoanhan}
                    
                </td>
            </tr>
<!--END BLOCK : label_list -->
            

            
</table>

<!-- START BLOCK : label_add -->
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-bordered tabletdnone">                    
            <tr>
                <td>Add new label</td>
                <td>
                    
                    <table width="450" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="120" height="30">Tên nhãn</td>
                        <td><input id="label_name" type="text" class="txtlang"></td>
                      </tr>
                      <tr>
                        <td height="30">Mã nhãn</td>
                        <td><input id="label_code" type="text" value="_" class="txtlang"></td>
                      </tr>
                      <tr>
                        <td height="30">Giá trị</td>
                        <td><input id="label_value" type="text" class="txtlang"></td>
                      </tr>
                    </table>
                    
                    
                    <input type="button" id="addlabel" name="addLabel" value="Thêm nhãn" />
                    
                </td>
            </tr>
            
</table>
<!-- END BLOCK : label_add -->                
                
                
            <a class="btn btn-primary" onClick="$('#inputform').submit();
                return false"><i class="icon-ok-circle icon-white"></i>&nbsp;Cập nhật</a>
            
    </form>

            <script>
                $(function(){
                    $('#addlabel').click(function(){
                        
                        if ($('#label_code').val()=='_'){
                            alert('Chưa nhập mã nhãn');
                            return false;
                        }
                            
                        var label_name_default =  $('#label_name').val() + 'default';
                        var label_name_lang = $('#label_name').val() + 'en';
                        
                        $('#myTable > tbody:first').append('<tr><td width="150"><strong>'+$('#label_name').val()+'</strong><br/><span style="color:#ccc; margin-left:5px;">'+$('#label_code').val()+'</span></td><td><div class="divlang">Default<input name="static_lang['+ $('#label_code').val() +'][default]" type="text" class="txtlang" value="'+$('#label_name').val()+'"></div><div class="divlang">English<input name="static_lang['+$('#label_code').val()+'][en]" type="text" class="txtlang" value="'+$('#label_value').val()+'"></div><a href="#" class="remove_lable" onclick="DeleteRow();">Xóa nhãn</a></td></tr>');
                        
                        $('#label_name').val('');
                        $('#label_code').val('_');
                        $('#label_value').val('');
                        
                    });
                    
                    $('.remove_lable').click(DeleteRow);
                    
                    
                });
                
function DeleteRow(){ 
    var par = $(this).parent().parent(); 
    par.remove();
    return false;
}; 

             
                
            </script>                    

    <!-- END BLOCK : AddNew -->


    <div class="divider1"><span></span></div>

</div>