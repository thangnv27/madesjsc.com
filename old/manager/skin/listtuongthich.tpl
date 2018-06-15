<!-- START BLOCK : list -->
<li><label class="checkbox"><input name="listpk[{id_product}]" class="selectList" type="checkbox" value="{id_product}" />{name}</label></li>
<!-- END BLOCK : list -->
<script language="javascript">
	$('.selectList').change(function(){
		if($(this).is(":checked")){
			$('#slt_' + $(this).val()).remove();
			$('<li id="slt_' + $(this).val() + '"><input type="hidden" name="phukien[' + $(this).val() +']" value="' + $(this).val() + '" /><div class="listname">' + $(this).parent().text() + '</div><div class="icondelete"><a onclick="deletephukien($(this)); return false" href="" class="icon-trash"></a></div><div class="c"></div></li>').appendTo("#lstSeleted");
		}else{
			$('#slt_' + $(this).val()).remove();
		}
	});
	
	function deletephukien(obj){
	  	obj.parent().parent().remove();
	}
</script>