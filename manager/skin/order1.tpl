

<div class="c5"></div>

<div class="breadLine">

    <ul class="breadcrumb">

        <li><a href="?"><i class="icon-home"></i></a></li>

        {pathpage}

    </ul>

</div>

<div class="c20"></div>

  

<div class="wraper-content">

<!-- START BLOCK : msg -->

<div>{msg}</div>

<!-- END BLOCK : msg --> 

<!-- START BLOCK : viewcart -->

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-striped">

                 <tr class="title">

                   <th colspan="5" style="text-transform:uppercase; background-color:#ccc">Thông tin đơn hang</th>

    </tr>

                 <tr>

                    <td colspan="5" >

                    	<table width="100%" class="table table-bordered table-striped">

                          

                          <tr>

                            <td width="150"><strong>Ngày đặt:</strong></td>

                            <td><strong>{time}</strong></td>

                          </tr>

                           <tr>

                            <td colspan="2" style="background-color:#eee" ><strong>Thông tin người đặt hàng</strong></td>

                          </tr>

                          

                          <tr>

                            <td><strong>Họ tên:</strong></td>

                            <td><strong>{name}</strong></td>

                          </tr>

                          <tr>

                            <td><strong>Điện thoại:</strong></td>

                            <td><strong>{phone}</strong></td>

                          </tr>

                          <tr>

                            <td><strong>Email:</strong></td>

                            <td><strong>{email}</strong></td>

                          </tr>

                          <tr>

                            <td><strong>Địa chỉ:</strong></td>

                            <td><strong>{address}</strong></td>

                          </tr>

                          <tr>

                            <td><strong>Thông tin thêm:</strong></td>

                            <td><strong>{addinfo}</strong></td>

                          </tr>

                         <!-- <tr>

                            <td colspan="2" style="background-color:#eee" ><strong>Thông tin người nhận hàng</strong></td>

                          </tr>

                          <tr>

                            <td><strong>Họ tên:</strong></td>

                            <td><strong>{g_name}</strong></td>

                          </tr>

                          <tr>

                            <td><strong>Điện thoại:</strong></td>

                            <td><strong>{g_phone}</strong></td>

                          </tr>

                          <tr>

                            <td><strong>Email:</strong></td>

                            <td><strong>{g_email}</strong></td>

                          </tr>

                          <tr>

                            <td><strong>Địa chỉ:</strong></td>

                            <td><strong>{g_address}</strong></td>

                          </tr>

                          <tr>

                            <td><strong>Thông tin thêm:</strong></td>

                            <td><strong>{g_addinfo}</strong></td>

                          </tr>
							-->
                      </table>

                   </td>

    </tr>

                  <tr class="title">

                   <th colspan="5" style="text-transform:uppercase;background-color:#ccc">Danh sách hàng đặt</th>

                  </tr>

<tr class="title">

                   <td width="30">TT</td>

                    <td>Tên sản phẩm</td>

                    <td width="120">Giá sản phẩm</td>

                   <td width="90">Số lượng</td>

        <td width="120">Tổng</td>

                  </tr>

                <!-- START BLOCK : list_row_cart -->

                  <tr>

                    <td align="center">{tt}</td>

                    <td><strong><a href="{link}" target="_blank">{name}</a></strong></td>

                    <td align="center"><strong>{price} VNĐ</strong></td>

                    <td align="center" style="text-align:center"><strong>{quantity} </strong></td>

                    <td align="center" style="text-align:center"><strong>{total} VNĐ</strong></td>

                  </tr>

                   <!-- END BLOCK : list_row_cart -->

<tr class="title">

                    <td colspan="4" align="right" style="text-align:right !important"><strong>Tổng cộng</strong></td>

        <td colspan="1" align="center" style="color:#FF0000; text-align:center">{final} VNĐ</td>

                  </tr>

                 <tr>

                    <td colspan="5" align="center">&nbsp;</td>

    </tr>

                 <tr class="title">

                   <td colspan="5">

                   		Tình trạng đơn hàng: 

                   		<select name="statusupdate" id="statusupdate">

                        	<option value="0" {status0}>Chờ duyệt</option>

                             <option value="3" {status3}>Đang xử lý</option>

                            <option value="2" {status2}>Đã hủy</option>

                            <option value="1" {status1}>Đã hoàn thành</option>

                        </select>

                        <span id="ssssss"></span>

                        <div style="float:right"><a href="javascript:ConfirmDeleteItem({id_order});" title="Xóa đơn hàng này "><img src="images/trash.png" width="16" height="16" border="0" /></a></div>

                   </td>

    </tr>

  </table>

                <script language="javascript">

				$('#statusupdate').change(function(){

                	$('#ssssss').load('index4.php?page=action_ajax&code=updateorder&id={id_order}&status='+$(this).val());

				});

                </script>

<div id="ssssss"></div>

<div class="divider1"><span></span></div>



<!-- END BLOCK : viewcart -->



<!-- START BLOCK : showList -->

<form action="{action}" method="post" id="list_form">

 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-striped table-hover">

							 

  <tr>

    <th colspan="3">

        <div style="float:left"><i class="icon-list-alt icon-white"></i>&nbsp;Danh sách {item}</div>

        <a href="?page={par_page}&code=showAddNew&pid={pid}" style="float:right"><div class="btn  btn-mini"><i class="icon-plus-sign"></i>&nbsp;Thêm mới {item}</div></a>

    </th>

  </tr>

  

  <tr class="title">

    <td>Tiêu đề</td>

    <td width="60" align="center" class="center">Trạng thái</td>

    <td width="30" align="center">Xóa</td>

  </tr>

  <!-- START BLOCK : list_order -->

  <tr>

    <td>

      <div class="list_item_name"><a href="{link}">{name}</a></div>

      <div>{createdate}</div>

    </td>

    <td class="center">{status}</td>

    <td><a href="{linkdel}" class="trash_item btn padingleftright4"><i class="icon-trash"></i></a></td>

  </tr>

  <!-- END BLOCK : list_order -->



  <tr class="title">

    <td><a href="?page={par_page}&code=deletemulti" id="delmultiitem">Xóa tất cả mục đã chọn</a></td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

  </tr>

  <tr class="search_box nonehover">

    <td colspan="3">

           {pages}

    </td>

  </tr>

</table>

</form>

<!-- END BLOCK : showList -->



</div>



<script>

	$('.trash_item').click(function(){

		if(confirm('Bạn có thật sự muốn xóa không ?')){

			window.location=$(this).attr('href');

			return false;

		}

		return false;

	});

</script>



