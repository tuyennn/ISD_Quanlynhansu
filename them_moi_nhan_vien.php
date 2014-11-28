<?php
error_reporting(E_ALL);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
/*tai hinh anh len
if ($_FILES["hinh_anh"]["error"] > 0)
{
echo "Error: " . $_FILES["hinh_anh"]["error"] . "<br />";
exit;
}
else
	move_uploaded_file($_FILES["hinh_anh"][tmp_name],"images/" . $_FILES["hinh_anh"]["name"]);
$luutru = "luu tru tai: " . "images/" . $_FILES["hinh_anh"]["name"];
$hinhanh = $_FILES["hinh_anh"]["name"]; */
$insertSQL = sprintf("INSERT INTO tlb_nhanvien (ma_nhan_vien, ho_ten, gioi_tinh, gia_dinh, dt_di_dong, dt_nha, email, ngay_sinh, noi_sinh, tinh_thanh, cmnd, ngay_cap, noi_cap, que_quan, dia_chi, tam_tru, hinh_anh) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
	get_param('ma_nhan_vien'),
	get_param('ho_ten'),
	get_param('gioi_tinh'),
	get_param('gia_dinh'),
	get_param('dt_di_dong'),
	get_param('dt_nha'),
	get_param('email'),
	get_param('ngay_sinh'),
	get_param('noi_sinh'),
	get_param('tinh_thanh'),
	get_param('cmnd'),
	get_param('ngay_cap'),
	get_param('noi_cap'),
	get_param('que_quan'),
	get_param('dia_chi'),
	get_param('tam_tru'),
	get_param('hinh_anh'));

mysql_select_db($database_Myconnection, $Myconnection);
$Result1 = mysql_query($insertSQL, $Myconnection) or die(mysql_error());

$insertGoTo = "danh_sach_nhan_vien.php";
if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
}
	//thêm mới thành công chuyển sang nhập công việc
$ma_nv = get_param('ma_nhan_vien');
if ($ma_nv <>"")
{
   $url = "index.php?require=them_moi_cong_viec.php&catID=$ma_nv&title=Thêm mới công việc";
   location($url);
}
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery.datepick.css" />
<script type="text/javascript" src="js/jquery.plugin.js"></script> 
<script type="text/javascript" src="js/jquery.datepick.js"></script>
<script type="text/javascript" src="js/jquery.datepick-vi.js"></script>
<script>
$(function() {
    $('#ngay_sinh').datepick({showOnFocus: false, showTrigger: '#calImg'});
    $('#ngay_cap').datepick({showOnFocus: false, showTrigger: '#calImg'});
     
    var formats = ['mm/dd/yyyy', 'M d, yyyy', 'MM d, yyyy', 
        'DD, MM d, yyyy', 'mm/dd/yy', 'dd/mm/yyyy', 
        'mm/dd/yyyy (\'w\'w)', '\'Day\' d \'of\' MM, yyyy', 
        $.datepick.ATOM, $.datepick.COOKIE, $.datepick.ISO_8601, 
        $.datepick.RFC_822, $.datepick.RFC_850, $.datepick.RFC_1036, 
        $.datepick.RFC_1123, $.datepick.RFC_2822, $.datepick.RSS, 
        $.datepick.TICKS, $.datepick.TIMESTAMP, $.datepick.W3C]; 
     
$('#dateFormat').change(function() { 
    $('#ngay_cap').val('').datepick('option', 
        {dateFormat: formats[$(this).val()]}); 
});
});
</script>

<script type="text/javascript">
    $(window).load(function() {
    $('.avatarbox').find('img').each(function() {
        var imgClass = (this.width / this.height > 1) ? 'wide' : 'tall';
        $(this).addClass(imgClass);
    })
})
</script>
</head>

<body text="#000000" link="#CC0000" vlink="#0000CC" alink="#000099">
    <div style="display: none;">
        <img id="calImg" src="images/calendar.gif" alt="Popup" class="trigger">
    </div>

    <form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="new_staff" id="new_staff">
        <table id="rounded-corner" width="750" align="center" cellpadding="2" cellspacing="2" bgcolor="#66CCFF">
            <tr valign="baseline">
              <td width="127" align="right" nowrap="nowrap">Mã nhân viên(*):</td>
              <td width="227"><input type="text" name="ma_nhan_vien" value="" size="32" /></td>
              <td width="117">&nbsp;</td>
              <td width="301">&nbsp;</td>
            </tr>
            <tr valign="10px">
                <td nowrap="nowrap" align="right">Họ và tên(*):</td>
                <td><input type="text" name="ho_ten" value="" size="32" /></td>
                <td>Ngày sinh:</td>
                <td>
                    <input type="text" name="ngay_sinh" id="ngay_sinh" value="" size="25" />
                    (dd/mm/yyyy)
                </td>
            </tr>
            <tr valign="baseline">
                <td nowrap="nowrap" align="right">Giới tính</td>
                <td><select name="gioi_tinh">
                    <option value="1" <?php if (!(strcmp(1, ""))) {echo "SELECTED";} ?>>Nam</option>
                    <option value="0" <?php if (!(strcmp(0, ""))) {echo "SELECTED";} ?>>Nữ</option>
                    </select>
                </td>
                <td>Nơi sinh:</td>
                <td><input type="text" name="noi_sinh" value="" size="32" /></td>
            </tr>
            <tr valign="baseline">
                <td nowrap="nowrap" align="right">Gia đình:</td>
                <td><select name="gia_dinh">
                    <option value="1" <?php if (!(strcmp(1, ""))) {echo "SELECTED";} ?>>Có gia đình</option>
                    <option value="0" <?php if (!(strcmp(0, ""))) {echo "SELECTED";} ?>>Chưa có</option>
                    </select>
                </td>
                <td>Tỉnh thành:</td>
                <td><input type="text" name="tinh_thanh" value="" size="32" /></td>
            </tr>
            <tr valign="baseline">
                <td nowrap="nowrap" align="right">ĐTDĐ:</td>
                <td><input type="text" name="dt_di_dong" value="" size="32" /></td>
                <td>CMND:</td>
                <td><input type="text" name="cmnd" value="" size="32" /></td>
            </tr>
            <tr valign="baseline">
                <td nowrap="nowrap" align="right">ĐT:</td>
                <td><input type="text" name="dt_nha" value="" size="32" /></td>
                <td>Ngày cấp:</td>
                <td>
                    <input type="text" name="ngay_cap" id="ngay_cap" value="" size="25" />
                    (dd/mm/yyyy)
                </td>
            </tr>
            <tr valign="baseline">
                <td nowrap="nowrap" align="right">Email:</td>
                <td><input type="text" name="email" value="" size="32" /></td>
                <td>Nơi cấp:</td>
                <td><input type="text" name="noi_cap" value="" size="32" /></td>
            </tr>
            <tr valign="baseline">
                <td nowrap="nowrap" align="right">Quê quán:</td>
                <td colspan="3"><input type="text" name="que_quan" value="" size="90" /></td>
            </tr>
            <tr valign="baseline">
                <td nowrap="nowrap" align="right">Địa chỉ:</td>
                <td colspan="3"><input type="text" name="dia_chi" value="" size="90" /></td>
            </tr>
            <tr valign="baseline">
                <td nowrap="nowrap" align="right">Tạm trú:</td>
                <td colspan="3"><input type="text" name="tam_tru" value="" size="90" /></td>
            </tr>
            <tr style="height: 200px" valign="middle">
                <td nowrap="nowrap" align="right">Hình ảnh:</td>
                <td colspan="3">
                    <div class="avatarbox">
                        <div class="avatar">
                            
                        </div>
                        <div class="avar_button">
                            <a target="_blank" href="quan_ly_anh.php" onclick="new_staff.reset();" class="bt_blue"><span class="bt_blue_lft"></span><strong>Duyệt Ảnh</strong><span class="bt_blue_r"></span></a>
                        </div>
                    </div>
                    
                </td>
            </tr>
            <tr valign="baseline">
                <td colspan="4" align="center" nowrap="nowrap">
                    <a href="#" onclick="new_staff.submit();return false;" class="bt_green"><span class="bt_green_lft"></span><strong>Thêm mới nhân viên</strong><span class="bt_green_r"></span></a>
                    <a href="#" onclick="new_staff.reset();" class="bt_red"><span class="bt_red_lft"></span><strong>Xóa làm lại</strong><span class="bt_red_r"></span></a>
                </td>
            </tr>

            <tfoot>
                <tr>
                    <td colspan="3" class="rounded-foot-left"><em><b><u>Hướng Dẫn:</u></b> 
                                                                <br>&nbsp;+ Các trường gắn (*) bắt buộc phải có 
                                                                <br>&nbsp;+ Sửa các thông tin bằng cách chọn sẵn hoặc gõ bằng bàn phím
                                                                <br>&nbsp;+ Nhấn Đồng Ý để hoàn tất thao tác</em></td>
                    <td class="rounded-foot-right">&nbsp;</td>

                </tr>
            </tfoot>

        </table>
        <input type="hidden" name="MM_insert" value="new_staff" />
    </form>
    <p>&nbsp;</p>

</body>
</html>