<div class="c5"></div>
<div class="breadLine">
    <ul class="breadcrumb">
        <li><a href="?"><i class="icon-home"></i></a></li>
        Danh sách đăng ký nhận mail
    </ul>
</div>

<div class="c20"></div>

<div class="wraper-content">

<!-- START BLOCK : msg -->

<div>{msg}</div>

<!-- END BLOCK : msg --> 


<!-- START BLOCK : showList -->

<form action="{action}" method="post" id="list_form">

 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-striped table-hover">

							 

  <tr>
    <th colspan="2">
        <div style="float:left"><i class="icon-list-alt icon-white"></i>&nbsp;Danh sách email khách hàng</div>
    </th>

  </tr>

  

  <tr class="title">

    <td>Email khách hàng</td>
    
    <td width="30" align="center">Xóa</td>

  </tr>

  <!-- START BLOCK : list -->

  <tr>

    <td>
     <a>{email}</a>
    </td>
    
    
    <td><a href="{linkdel}" class="trash_item btn padingleftright4"><i class="icon-trash"></i></a></td>

  </tr>

  <!-- END BLOCK : list -->
 

  <tr class="search_box nonehover">

    <td colspan="3">
           {pages}

    </td>

  </tr>

</table>

</form>

<!-- END BLOCK : showList -->

<div class="divider1"><span></span></div>

<a href="/manager/index4.php?page=export_excel" target="_blank">Xuất danh sách..</a>


</div>

               <style>
        
        .table-bordered tr.title{
            
        }

        .table-bordered tr.title td{
            text-align: center !important;
            
        }
        
        .table th{
            padding: 1px !important;
            text-align: center !important;
        }
        .table td{
            padding: 1px !important;
            padding-left: 5px !important;
        }
        
    </style>

           
<script>

	$('.trash_item').click(function(){

		if(confirm('Bạn có thật sự muốn xóa không ?')){

			window.location=$(this).attr('href');

			return false;

		}

		return false;

	});

</script>



