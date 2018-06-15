

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

                   <th colspan="6" style="text-transform:uppercase; background-color:#ccc">Thông tin đơn hang</th>

    </tr>

                 <tr>

                    <td colspan="6" >

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

                   <th colspan="6" style="text-transform:uppercase;background-color:#ccc">Danh sách hàng đặt</th>

                  </tr>

<tr class="title">

                   <td width="30">TT</td>

                    <td>Tên sản phẩm</td>

                    <td width="120">Giá sản phẩm</td>

                   <td width="90">Số lượng</td>
                   <td width="40">Màu</td>

        <td width="120">Tổng</td>

                  </tr>

                <!-- START BLOCK : list_row_cart -->

                  <tr>

                    <td align="center">{tt}</td>

                    <td><strong><a href="{link}" target="_blank">{name}</a></strong></td>

                    <td align="center"><strong>{price} VNĐ</strong></td>

                    <td align="center" style="text-align:center"><strong>{quantity} </strong></td>
                    <td align="center" style="text-align:center"><span style="display:block;width:25px; height:25px; border:solid 1px #CCC; background:{color}"></span></td>

                    <td align="center" style="text-align:center"><strong>{total} VNĐ</strong></td>

                  </tr>

                   <!-- END BLOCK : list_row_cart -->

<tr class="title">

                    <td colspan="4" align="right" style="text-align:right !important"><strong>Tổng cộng</strong></td>
                    <td align="center" style="color:#FF0000; text-align:center">&nbsp;</td>

        <td colspan="1" align="center" style="color:#FF0000; text-align:center">{final} VNĐ</td>

                  </tr>

                 <tr>

                    <td colspan="6" align="center">&nbsp;</td>

    </tr>

                 <tr class="title">

                   <td colspan="6">

                   		Tình trạng đơn hàng: 

                   		<select  name="statusupdate" id="statusupdate">
                       	  <option value="0" {status0}>Chờ duyệt</option>
                          <option value="3" {status3}>Đang xử lý</option>
                          <option value="2" {status2}>Đã hủy</option>
                          <option value="4" {status4}>Đã duyệt</option>
                          <option value="1" {status1}>Đã hoàn thành</option>
                     </select>

                        <span id="ssssss"></span>

                        <div style="float:right"><a href="javascript:ConfirmDeleteItem({id_order});" title="Xóa đơn hàng này ">Xóa đơn hàng</a></div>

                   </td>

    </tr>
<tr class="title">

                   <td colspan="6">
                   	<form action="?page=order&code=01&id={id}&act=updatebill" method="post" id="updatebillform">
                       Mã Bill: <input name="bill" type="text" value="{bill}">
                       Dịch vụ chuyển<select name="billservice">
                        <option value="viettel" {viettel}>Viettel</option>
                        <option value="ems" {ems}>EMS</option>
                        <option value="other" {other}>Khác</option>
                       </select>
                       <button class="btn btn-primary" style="margin-left:5px; width:150px;">Cập nhật mã bill</button>
                    </form>   
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



 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-striped table-hover">

							 

  <tr>

    <th colspan="6">

        <div style="float:left"><i class="icon-list-alt"></i>&nbsp;Danh sách {item}</div>
         <a href="" id="exportecel" style="float:right"><div class="btn  btn-mini btn-primary"><i class="icon-download-alt  icon-white"></i>&nbsp;Xuất danh sách</div></a>

    </th>

  </tr>
<tr>

    <th colspan="6">
    	<form action="?page=order" method="post" id="searchform">
        <div class="input-prepend">
          <span class="add-on">Tên hoặc email</span>
          <input class="span2" id="keyword"  name="keyword" type="text" value="{keyword}">
        </div>
        <div class="input-prepend">
          <span class="add-on">Từ ngày</span>
          <input class="span2" id="fromdate"  name="fromdate" type="text" value="{fromdate}">
        </div>
         <div class="input-prepend">
          <span class="add-on">Đến ngày</span>
          <input class="span2" id="todate" name="todate" type="text" value="{todate}" >
        </div>
        <a href="" class="btn" onClick="$('#searchform').submit(); return false">Lọc</a>
        </form>
        <script type="text/javascript">
		$(function() {
			$('#exportecel').click(function(){
				$(this).attr('href','index4.php?page=export_excel_order&fromdate=' + $('#fromdate').val() +'&todate='+$('#todate').val());
			});
			$('#todate, #fromdate').datepicker({
				  duration: '',
				  showTime: false,
				  constrainInput: false,
				  dateFormat: 'dd/mm/yy',
				  changeYear: true,
				  changeMonth: true,
				  showOtherMonths: true,
				  time24h: true,
				  currentText: 'Today'							
		  });
		});
        </script>
    </th>

  </tr>

  

  <tr class="title">

    <td>Tiêu đề</td>
    <td width="150" align="center" class="center">Mã bill</td>
    <td width="150" align="center" class="center">Điện thoại</td>
    <td width="200" align="center" class="center">Email</td>

    <td width="90" align="center" class="center">Trạng thái</td>

    <td width="30" align="center">Xóa</td>

  </tr>

  <!-- START BLOCK : list_order -->

  <tr>

    <td>

      <div class="list_item_name"><a style="font-weight:{normal}" href="{link}">{name}</a> - <span style="font-size:11px; color:#333; font-weight:normal">[{time}]</span></div>
    </td>
    <td class="center">{bill}</td>
    <td class="center">{phone}</td>
    <td class="center">{email}</td>

    <td class="center">{status}</td>

    <td><a href="{linkdel}" class="trash_item btn padingleftright4"><i class="icon-trash"></i></a></td>

  </tr>

  <!-- END BLOCK : list_order -->



  <tr class="title">

    <td><a href="?page={par_page}&code=deletemulti" id="delmultiitem">Xóa tất cả mục đã chọn</a></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

  </tr>

  <tr class="search_box nonehover">

    <td colspan="6">

           {pages_items}

    </td>

  </tr>

</table>



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



