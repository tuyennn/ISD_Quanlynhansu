<?php
error_reporting(E_ALL);

$editFormAction = htmlspecialchars($_SERVER["PHP_SELF"]);
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "new_staff_form")) {
$insertSQL = sprintf("INSERT INTO tlb_nhanvien (ma_nhan_vien, ho_ten, gioi_tinh, gia_dinh, dt_di_dong, dt_nha, email, ngay_sinh, noi_sinh, cmnd, ngay_cap, noi_cap, que_quan, dia_chi, tam_tru) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
	strtoupper(get_param('ma_nhan_vien')),
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
        $url = "index.php?require=danh_sach_nhan_vien.php&title=Danh sách nhân viên";
        location($url);
    }
    else {
        $message = "Thao tác thêm mới thất bại!";
        echo "<script type='text/javascript'>alert('$message');</script>";
        $url = "index.php?require=danh_sach_nhan_vien.php&title=Danh sách nhân viên";
        location($url);
    }


    $insertGoTo = "danh_sach_nhan_vien.php";
    if (isset($_SERVER['QUERY_STRING'])) {
        $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
        $insertGoTo .= $_SERVER['QUERY_STRING'];
    }
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery.plugin.js"></script> 

    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/siena.datepicker.css">
    <script src="js/jquery-ui.js"></script>

    <script type="text/javascript" src="js/form-validator/jquery.form-validator.min.js"></script>
    <script type="text/javascript" src="js/jquery.ui.datepicker-vi.js"></script>


    <script>
        $(function() {
            $("#ngay_sinh").datepicker({showOn: 'button', buttonImage: 'images/calendar.gif', buttonImageOnly: true, dateFormat: 'dd/mm/yy', changeMonth: true, changeYear: true});
            $("#ngay_cap").datepicker({showOn: 'button', buttonImage: 'images/calendar.gif', buttonImageOnly: true, dateFormat: 'dd/mm/yy', changeMonth: true, changeYear: true});
            $('#ui-datepicker-div').wrap('<div class="datepicker ll-skin-siena"></div>')
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
    <script type="text/javascript">
    pic1 = new Image(16, 16); 
    pic1.src = "images/loader.gif";
    $(document).ready(function(){
        $('#ma_nhan_vien').change(function(){ // Keyup function for check the user action in input
            var ma_nhan_vien = document.getElementById("ma_nhan_vien").value.toUpperCase(); // Get the ma_nhan_vien textbox using $(this) or you can use directly $('#ma_nhan_vien')
            var code = "PT";
            var ma_nhan_vienAvailResult = $('#ma_nhan_vien_avail_result'); // Get the ID of the result where we gonna display the results
            if(ma_nhan_vien.length == 4) { // check if greater than 4 (minimum 4)

                ma_nhan_vienAvailResult.html('<img src="images/loader.gif" align="absmiddle">&nbsp;Đang kiểm tra khả dụng...'); // Preloader, use can use loading animation here
                var UrlToPass = 'action=ma_nhan_vien_availability&ma_nhan_vien='+ma_nhan_vien;
                $.ajax({ // Send the ma_nhan_vien val to another includes/checker.php using Ajax in POST menthod
                    type : 'POST',
                    data : UrlToPass,
                    url  : 'includes/checker.php',
                    success: function(responseText){ // Get the result and asign to each cases
                        if(ma_nhan_vien.slice(0, 2) != code) {
                            ma_nhan_vienAvailResult.html('<span class="error">Mã nhân viên bao gồm PTxx(PT: Mã Công ty; xx: Số gồm 2 chữ số)</span>');
                            $("#ma_nhan_vien").removeClass('object_ok'); // if necessary
                            $("#ma_nhan_vien").addClass("object_error");
                            $('#addstaff').attr('disabled','disabled');
                        }
                        else{
                            if(responseText == 0){
                                $("#ma_nhan_vien").removeClass('object_error'); // if necessary
                                $("#ma_nhan_vien").addClass("object_ok");
                                ma_nhan_vienAvailResult.html('<span class="success">&nbsp;<img src="images/tick.gif" align="absmiddle"></span>');
                                $('#addstaff').removeAttr('disabled');
                            }
                            else if(responseText > 0){
                                $("#ma_nhan_vien").removeClass('object_ok'); // if necessary
                                $("#ma_nhan_vien").addClass("object_error");
                                ma_nhan_vienAvailResult.html('<span class="error">Mã nhân viên này đã sử dụng</span>');
                                $('#addstaff').attr('disabled','disabled');
                            }

                            else{
                                alert('Lỗi cơ sở dữ liệu');
                            }
                        }
                        
                    }
                });
            }else{
                ma_nhan_vienAvailResult.html('<span class="error">Mã nhân viên bao gồm PTxx(PT: Mã Công ty; xx: Số gồm 2 chữ số)</span>');
                $("#ma_nhan_vien").removeClass('object_ok'); // if necessary
                $("#ma_nhan_vien").addClass("object_error");
            }
            if(ma_nhan_vien.length == 0) {
                ma_nhan_vienAvailResult.html('');
            }
        });
    
        $('#ma_nhan_vien').keydown(function(e) { // Dont allow users to enter spaces for their ma_nhan_vien and passwords
            if (e.which == 32) {
                return false;
            }
        });
    });
    </script>
</head>

<body text="#000000" link="#CC0000" vlink="#0000CC" alink="#000099">
    <div style="display: none;">
        <img id="calImg" src="images/calendar.gif" alt="Popup" class="trigger">
    </div>

    <form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="new_staff_form" id="new_staff_form" runat="server">
        <table id="rounded-corner" >
            <tr valign="baseline">
                <td align="right" nowrap="nowrap">Mã nhân viên(*):</td>
                <td width="300"><input type="text" id="ma_nhan_vien" name="ma_nhan_vien" value="" size="32" style="text-transform:uppercase" data-validation="required" data-validation-error-msg="Thông tin bắt buộc"/></td>
                <td colspan="2"><div class="ma_nhan_vien_avail_result" id="ma_nhan_vien_avail_result"></div></td>
            </tr>
            <tr valign="10px">
                <td nowrap="nowrap" align="right">Họ và tên(*):</td>
                <td><input type="text" name="ho_ten" value="" size="32" data-validation="length" data-validation-length="min4" data-validation-error-msg="Tên nhân viên phải dài trên 4 ký tự"/></td>
                <td>Ngày sinh:</td>
                <td>
                    <input type="text" name="ngay_sinh" id="ngay_sinh" value="" size="25" data-validation="date" data-validation-format="dd/mm/yyyy"/>
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
                <td><input type="text" name="noi_sinh" value="" size="32" data-validation="required"/></td>
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
                <td><input type="text" name="dt_di_dong" value="" size="32" data-validation="number"/></td>
                <td>CMND:</td>
                <td><input type="text" name="cmnd" value="" size="32" data-validation="number" /></td>
            </tr>
            <tr valign="baseline">
                <td nowrap="nowrap" align="right">ĐT:</td>
                <td><input type="text" name="dt_nha" value="" size="32" /></td>
                <td>Ngày cấp:</td>
                <td>
                    <input type="text" name="ngay_cap" id="ngay_cap" value="" size="25" data-validation="date" data-validation-format="dd/mm/yyyy"/>
                    (dd/mm/yyyy)
                </td>
            </tr>
            <tr valign="baseline">
                <td nowrap="nowrap" align="right">Email:</td>
                <td><input type="text" name="email" value="" size="32" data-validation="email" /></td>
                <td>Nơi cấp:</td>
                <td><input type="text" name="noi_cap" value="" size="32" /></td>
            </tr>
            <tr valign="baseline">
                <td nowrap="nowrap" align="right">Quê quán:</td>
                <td colspan="3"><input type="text" name="que_quan" value="" size="90" data-validation="required"/></td>
            </tr>
            <tr valign="baseline">
                <td nowrap="nowrap" align="right">Địa chỉ:</td>
                <td colspan="3"><input type="text" name="dia_chi" value="" size="90" data-validation="required"/></td>
            </tr>
            <tr valign="baseline">
                <td nowrap="nowrap" align="right">Tạm trú:</td>
                <td colspan="3"><input type="text" name="tam_tru" value="" size="90" data-validation="required"/></td>
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
                    <button class="btn btn-default" onclick="new_staff_form.reset();">Làm lại</button>
                    <input type="submit" onClick="ConfirmCreate()" class="btn btn-default" name="submit" id="addstaff" value="Thêm mới nhân viên" />
                    <script>
                        function ConfirmCreate(){
                            if (confirm("Bạn có chắc chắn thao tác thêm mới!"))
                            {
                                new_staff_form.submit();
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
        <input type="hidden" name="MM_insert" value="new_staff_form" />
    </form>
    <script src="js/form-validator/jquery.form-validator.min.js"></script>
    <script src="js/form-validator/locale.vi.js"></script>
    <script>
    /* important to locate this script AFTER the closing form element, so form object is loaded in DOM before setup is called */
        $.validate({
            modules : 'date, security, file',
            language : enErrorDialogs
        });
    </script>
</body>
</html>