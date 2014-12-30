<?php
error_reporting(E_ALL);

$editFormAction = htmlspecialchars($_SERVER["PHP_SELF"]);
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "new_staff")) {
$insertSQL = sprintf("INSERT INTO tlb_nhanvien (ma_nhan_vien, ho_ten, gioi_tinh, gia_dinh, dt_di_dong, dt_nha, email, ngay_sinh, noi_sinh, cmnd, ngay_cap, noi_cap, que_quan, dia_chi, tam_tru) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
	get_param('ma_nhan_vien'),
	get_param('ho_ten'),
	get_param('gioi_tinh'),
	get_param('gia_dinh'),
	get_param('dt_di_dong'),
	get_param('dt_nha'),
	get_param('email'),
	get_param('ngay_sinh'),
	get_param('noi_sinh'),
	get_param('cmnd'),
	get_param('ngay_cap'),
	get_param('noi_cap'),
	get_param('que_quan'),
	get_param('dia_chi'),
	get_param('tam_tru'));
    

    $ma_nv = get_param('ma_nhan_vien');
    $tmp_file = $_FILES['upload_file']['tmp_name'];
    @$target_file = basename($_FILES['upload_file']['name']);
    $upload_dir = "uploads";
    $imgsize = $_FILES['upload_file']['size']; 
    $imgtype = $_FILES['upload_file']['type'];

    if(move_uploaded_file($tmp_file,$upload_dir."/".$target_file)) {
        $command=mysql_query("INSERT INTO `tlb_hinhanh` (`filename`, `type`, `size`, `ma_nhan_vien`) VALUES ('{$target_file}', '{$imgtype}', '{$imgsize}', '{$ma_nv}')");
        echo "The file ". basename($_FILES['upload_file']['name']) . " has been uploaded";
    }
    else {
        echo "There was an error uploading the file, please try again!";
    }


    $mydb->setQuery($insertSQL);
    $result_c = $mydb->executeQuery();
    if($result_c) {
        $message = "Thao tác thêm mới thành công!";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
    else {
        $message = "Thao tác thêm mới thất bại!";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }

    $insertGoTo = "danh_sach_nhan_vien.php";
    if (isset($_SERVER['QUERY_STRING'])) {
        $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
        $insertGoTo .= $_SERVER['QUERY_STRING'];
    }

    //thêm mới thành công chuyển sang nhập công việc
    
    if ($ma_nv <>""){
       $url = "index.php?require=them_moi_cong_viec.php&catID=$ma_nv&title=Thêm mới công việc";
       location($url);
    }
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <link rel="stylesheet" type="text/css" href="css/jquery.datepick.css" />
    <script type="text/javascript" src="js/jquery.min.js"></script>
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
        function PreviewImage(no) {
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("uploadImage"+no).files[0]);

            oFReader.onload = function (oFREvent) {
                document.getElementById("uploadPreview"+no).src = oFREvent.target.result;
            };
        }
    </script>
</head>

<body text="#000000" link="#CC0000" vlink="#0000CC" alink="#000099">
    <div style="display: none;">
        <img id="calImg" src="images/calendar.gif" alt="Popup" class="trigger">
    </div>

    <form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="new_staff" id="new_staff" runat="server">
        <table id="rounded-corner" >
            <tr valign="baseline">
              <td width="127" align="right" nowrap="nowrap">Mã nhân viên(*):</td>
              <td width="227"><input type="text" name="ma_nhan_vien" value="" size="32" /></td>
              <td width="117">&nbsp;</td>
              <td width="301">&nbsp;</td>
            </tr>
            <tr valign="10px">
                <td nowrap="nowrap" align="right">Họ và tên(*):</td>
                <td><input type="text" name="ho_ten" value="" size="32" data-validation="length" data-validation-length="min4" data-validation-error-msg="Tên nhân viên phải dài trên 4 ký tự"/></td>
                <td>Ngày sinh:</td>
                <td>
                    <input type="text" name="ngay_sinh" id="ngay_sinh" value="" size="25" data-validation="birthdate" data-validation-format="dd/mm/yyyy" data-validation-error-msg="Định dạng ngày tháng không chính xác"/>
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
                <td nowrap="nowrap" align="right">Hôn nhân:</td>
                <td><select name="gia_dinh">
                    <option value="1" <?php if (!(strcmp(1, ""))) {echo "SELECTED";} ?>>Có gia đình</option>
                    <option value="0" <?php if (!(strcmp(0, ""))) {echo "SELECTED";} ?>>Chưa có</option>
                    </select>
                </td>
                <td></td>
                <td></td>
            </tr>
            <tr valign="baseline">
                <td nowrap="nowrap" align="right">ĐTDĐ:</td>
                <td><input type="text" name="dt_di_dong" value="" size="32" data-validation="number" data-validation-error-msg="Thông tin bắt buộc"/></td>
                <td>CMND:</td>
                <td><input type="text" name="cmnd" value="" size="32" data-validation="number" data-validation-error-msg="Thông tin bắt buộc" /></td>
            </tr>
            <tr valign="baseline">
                <td nowrap="nowrap" align="right">ĐT:</td>
                <td><input type="text" name="dt_nha" value="" size="32" /></td>
                <td>Ngày cấp:</td>
                <td>
                    <input type="text" name="ngay_cap" id="ngay_cap" value="" size="25" data-validation="birthdate" data-validation-format="dd/mm/yyyy" data-validation-error-msg="Định dạng ngày tháng không chính xác"/>
                    (dd/mm/yyyy)
                </td>
            </tr>
            <tr valign="baseline">
                <td nowrap="nowrap" align="right">Email:</td>
                <td><input type="text" name="email" value="" size="32" data-validation="email" data-validation-error-msg="Định dạng email không chính xác"/></td>
                <td>Nơi cấp:</td>
                <td><input type="text" name="noi_cap" value="" size="32" /></td>
            </tr>
            <tr valign="baseline">
                <td nowrap="nowrap" align="right">Quê quán:</td>
                <td colspan="3"><input type="text" name="que_quan" value="" size="90" data-validation="required" data-validation-error-msg="Thông tin bắt buộc"/></td>
            </tr>
            <tr valign="baseline">
                <td nowrap="nowrap" align="right">Địa chỉ:</td>
                <td colspan="3"><input type="text" name="dia_chi" value="" size="90" /></td>
            </tr>
            <tr valign="baseline">
                <td nowrap="nowrap" align="right">Tạm trú:</td>
                <td colspan="3"><input type="text" name="tam_tru" value="" size="90" data-validation="required" data-validation-error-msg="Thông tin bắt buộc"/></td>
            </tr>
            <tr style="height: 200px" valign="middle">
                <td nowrap="nowrap" align="right">Hình ảnh:</td>
                <td colspan="3">
                    <label class="filebutton">
                        <a class="bt_blue"><span class="bt_blue_lft"></span><strong>Tìm ảnh</strong><span class="bt_blue_r"></span></a>
                        <span>
                            <input id="uploadImage1" type="file" name="upload_file" onchange="PreviewImage(1);" data-validation="mime size" data-validation-allowing="jpg, png" data-validation-max-size="512kb" data-validation-help="Định dạng JPG, PNG & không quá 512KB"/>
                        </span>
                    </label>

                    <div class="avatar">
                        <img id="uploadPreview1" class="img-thumbnail" src="./uploads/p.jpg" /><br />
                    </div>
                </td>
            </tr>
            <tr valign="baseline">
                <td colspan="3"></td>
                <td align="right">
                    <button class="btn btn-default" onclick="new_staff.reset();">Làm lại</button>
                    <input type="submit" onClick="ConfirmCreate()" class="btn btn-default" name="submit" id="submit" value="Thêm mới nhân viên" />
                    <script>
                        function ConfirmCreate(){
                            if (confirm("Bạn có chắc chắn thao tác thêm mới!"))
                            {
                                new_staff.submit();
                                return true;
                            }  
                        }
                        
                    </script> 
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
    <script src="js/form-validator/jquery.form-validator.min.js"></script>
    <script>
    /* important to locate this script AFTER the closing form element, so form object is loaded in DOM before setup is called */
        $.validate({
            modules : 'date, security, file'
        });
    </script>
</body>
</html>