<?php
    $ma_nv = $_GET['catID'];
    if (!function_exists("GetSQLValueString")) {
        function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
        {
            if (PHP_VERSION < 6) {
                $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
            }

            $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

            switch ($theType) {
                case "text":
                    $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
                    break;    
                case "long":
                case "int":
                    $theValue = ($theValue != "") ? intval($theValue) : "NULL";
                    break;
                case "double":
                    $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
                    break;
                case "date":
                    $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
                    break;
                case "defined":
                    $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
                    break;
            }
            return $theValue;
        }
    }

    $editFormAction = htmlspecialchars($_SERVER["PHP_SELF"]);
    if (isset($_SERVER['QUERY_STRING'])) {
        $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
    }

    if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "edit_staff_form")) {
        $sDate = str_replace('/', '-', $_POST['ngay_sinh']);
        $tDate = str_replace('/', '-', $_POST['ngay_cap']);
        $sDate = date('Y-m-d', strtotime($sDate));
        $tDate = date('Y-m-d', strtotime($tDate));

        $updateSQL = sprintf("UPDATE tlb_nhanvien SET ho_ten=%s, gioi_tinh=%s, gia_dinh=%s, dt_di_dong=%s, dt_nha=%s, email=%s, ngay_sinh='{$sDate}', noi_sinh=%s, cmnd=%s, ngay_cap='{$tDate}', noi_cap=%s, que_quan=%s, dia_chi=%s, tam_tru=%s, nghi_viec=%s WHERE ma_nhan_vien='{$ma_nv}'",
            GetSQLValueString($_POST['ho_ten'], "text"),
            GetSQLValueString($_POST['gioi_tinh'], "int"),
            GetSQLValueString($_POST['gia_dinh'], "int"),
            GetSQLValueString($_POST['dt_di_dong'], "text"),
            GetSQLValueString($_POST['dt_nha'], "text"),
            GetSQLValueString($_POST['email'], "text"),
            GetSQLValueString($_POST['noi_sinh'], "text"),
            GetSQLValueString($_POST['cmnd'], "text"),
            GetSQLValueString($_POST['noi_cap'], "text"),
            GetSQLValueString($_POST['que_quan'], "text"),
            GetSQLValueString($_POST['dia_chi'], "text"),
            GetSQLValueString($_POST['tam_tru'], "text"),
            GetSQLValueString($_POST['nghi_viec'], "int"));


    
        $tmp_file = $_FILES['upload_file']['tmp_name'];
        @$target_file = basename($_FILES['upload_file']['name']);
        $upload_dir = "uploads";
        $imgsize = $_FILES['upload_file']['size']; 
        $imgtype = $_FILES['upload_file']['type'];

        if(move_uploaded_file($tmp_file,$upload_dir."/".$target_file)) {
            $result = mysql_query("SELECT * FROM tlb_hinhanh WHERE ma_nhan_vien = '$ma_nv'");
            if(mysql_num_rows($result) == 1) {
                echo "User's already exist, run an update query....";
                $command=mysql_query("UPDATE `tlb_hinhanh` SET `filename`= {$target_file}, `type`={$imgtype}, `size`= {$imgsize} WHERE `ma_nhan_vien` = '$ma_nv'");
                echo "The file ". basename($_FILES['upload_file']['name']) . " has been uploaded";
            }
            else{
                $command=mysql_query("INSERT INTO `tlb_hinhanh` (`filename`, `type`, `size`, `ma_nhan_vien`) VALUES ('{$target_file}', '{$imgtype}', '{$imgsize}', '{$ma_nv}')");
                echo "The file ". basename($_FILES['upload_file']['name']) . " has been uploaded";
            }  
        }
        else {
            //echo "There was an error uploading the file, please try again!";
        }

        $mydb->setQuery($updateSQL);
        $result_e = $mydb->executeQuery();

        if($result_e) {
            $message = "Thao tác cập nhật thành công!";
            echo "<script type='text/javascript'>alert('$message');</script>";
            $url = "index.php?require=cap_nhat_thong_tin_nhan_vien.php&catID=" .$ma_nv ."&title=Thông tin nhân viên";
            location($url);
        }
        else {
            $message = "Thao tác cập nhật thất bại!";
            echo "<script type='text/javascript'>alert('$message');</script>";
            $url = "index.php?require=cap_nhat_thong_tin_nhan_vien.php&catID=" .$ma_nv ."&title=Thông tin nhân viên";
            location($url);
        }


        $updateGoTo = "danh_sach_nhan_vien.php";
        if (isset($_SERVER['QUERY_STRING'])) {
            $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
            $updateGoTo .= $_SERVER['QUERY_STRING'];
        }
        $url = "index.php?require=cap_nhat_thong_tin_nhan_vien.php&catID=$ma_nv&title=Thông tin nhân viên";
        location($url);
    }

    $mydb->setQuery("SELECT * FROM tlb_nhanvien where ma_nhan_vien = '$ma_nv'");
    $RCcapnhat_nhanvien = $mydb->executeQuery();
    $row_RCcapnhat_nhanvien = $mydb->fetch_assoc($RCcapnhat_nhanvien);
    $totalRows_RCcapnhat_nhanvien = $mydb->num_rows($RCcapnhat_nhanvien);

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
        $(window).load(function() {
        $('.avatar').find('img').each(function() {
            var imgClass = (this.width / this.height > 1) ? 'wide' : 'tall';
            $(this).addClass(imgClass);
            })
        })
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

    <form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="edit_staff_form" id="edit_staff_form">
        <table id="rounded-corner" width="750" cellpadding="2" cellspacing="2" bgcolor="#66CCFF">
            <thead>
                <tr>
                    <th width="200" class="rounded-company" rowspan="2" align="center"><a href="index.php?require=them_moi_quan_he_gia_dinh.php&catID=<?php echo $ma_nv; ?>&title=Quan hệ gia đình&action=new">Quan hệ gia đình</a></td>
                    <th width="200" rowspan="2" align="center"><a href="index.php?require=them_moi_qua_trinh_cong_tac.php&catID=<?php echo $ma_nv; ?>&title=Quá trình công tác&action=new">Quá trình công tác</a></td>
                    <th width="150" rowspan="2" align="center"><a href="index.php?require=them_moi_qua_trinh_luong.php&catID=<?php echo $ma_nv; ?>&title=Quá trình lương&action=new">Quá trình lương</a></td>
                    <th width="120" rowspan="2" align="center"><a href="index.php?require=them_moi_hop_dong.php&catID=<?php echo $ma_nv; ?>&title=Ký Hợp Đồng&action=new">Ký Hợp Đồng</a></td>
                    <th width="112" class="rounded-q4" rowspan="2" align="center"><a href="index.php?require=them_moi_bao_hiem.php&catID=<?php echo $ma_nv; ?>&title=Bảo hiểm&action=new">Bảo hiểm</a></td>
                </tr>
            </thead>
        </table>

        <table id="rounded-corner" width="750" align="center" cellpadding="2" cellspacing="2" bgcolor="#66CCFF">
            <tr valign="baseline">
                <td width="127" align="right" nowrap="nowrap">Mã nhân viên(*):</td>
                <td style="color:red" width="227"><b><?php echo $row_RCcapnhat_nhanvien['ma_nhan_vien']; ?></b></td>
                <td nowrap="nowrap" align="right" width="68">Tình trạng:</td>
                <td width="271">
                    <?php
                        if ($row_RCcapnhat_nhanvien['nghi_viec']==0)
                        {
                    ?>
                    <select name="nghi_viec">
                        <option selected="selected" value="0">Làm việc </option>
                        <option value="1">Nghỉ việc </option>
                    </select>
                    <?php
                        }
                        else
                            {
                    ?>
                    <select name="nghi_viec">
                        <option selected="selected" value="1">Nghỉ việc </option>
                        <option value="0">Làm việc </option>
                    </select>
                    <?php
                        }
                    ?>
                </td>
            </tr>
            <tr valign="10px">
                <td nowrap="nowrap" align="right">Họ và tên(*):</td>
                <td><input type="text" name="ho_ten" value="<?php echo htmlentities($row_RCcapnhat_nhanvien['ho_ten'], ENT_COMPAT, 'utf-8'); ?>" size="32" data-validation="length" data-validation-length="min4" data-validation-error-msg="Tên nhân viên phải dài trên 4 ký tự"/></td>
                <td>Ngày sinh:</td>
                <td>
                    <input type="text" name="ngay_sinh" id="ngay_sinh" value="<?php echo htmlentities(date("d/m/Y", strtotime($row_RCcapnhat_nhanvien['ngay_sinh'])), ENT_COMPAT, 'utf-8'); ?>" size="25" data-validation="birthdate" data-validation-format="dd/mm/yyyy" data-validation-error-msg="Định dạng ngày tháng không chính xác"/>
                        (dd/mm/yyyy)
                </td>
            </tr>
            <tr valign="baseline">
                <td nowrap="nowrap" align="right">Giới tính</td>
                <td>
                    <select name="gioi_tinh">
                        <option value="1" <?php if (!(strcmp(1, htmlentities($row_RCcapnhat_nhanvien['gioi_tinh'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>Nam</option>
                        <option value="0" <?php if (!(strcmp(0, htmlentities($row_RCcapnhat_nhanvien['gioi_tinh'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>Nữ</option>
                    </select>
                </td>
                <td>Nơi sinh:</td>
                <td><input type="text" name="noi_sinh" value="<?php echo htmlentities($row_RCcapnhat_nhanvien['noi_sinh'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
            </tr>
            <tr valign="baseline">
                <td nowrap="nowrap" align="right">Hôn nhân:</td>
                <td>
                    <select name="gia_dinh">
                        <option value="1" <?php if (!(strcmp(1, htmlentities($row_RCcapnhat_nhanvien['gia_dinh'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>Có gia đình</option>
                        <option value="0" <?php if (!(strcmp(0, htmlentities($row_RCcapnhat_nhanvien['gia_dinh'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>Chưa có</option>
                    </select>
                </td>
                <td></td>
                <td></td>
            </tr>
            <tr valign="baseline">
                <td nowrap="nowrap" align="right">ĐTDĐ:</td>
                <td><input type="text" name="dt_di_dong" value="<?php echo htmlentities($row_RCcapnhat_nhanvien['dt_di_dong'], ENT_COMPAT, 'utf-8'); ?>" size="32" data-validation="number" data-validation-error-msg="Thông tin bắt buộc"/></td>
                <td>CMND:</td>
                <td><input type="text" name="cmnd" value="<?php echo htmlentities($row_RCcapnhat_nhanvien['cmnd'], ENT_COMPAT, 'utf-8'); ?>" size="32" data-validation="number" data-validation-error-msg="Thông tin bắt buộc"/></td>
            </tr>
            <tr valign="baseline">
                <td nowrap="nowrap" align="right">ĐT:</td>
                <td><input type="text" name="dt_nha" value="<?php echo htmlentities($row_RCcapnhat_nhanvien['dt_nha'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
                <td>Ngày cấp:</td>
                <td>
                    <input type="text" name="ngay_cap" id="ngay_cap" value="<?php echo htmlentities(date("d/m/Y", strtotime($row_RCcapnhat_nhanvien['ngay_cap'])), ENT_COMPAT, 'utf-8'); ?>" size="25" data-validation="birthdate" data-validation-format="dd/mm/yyyy" data-validation-error-msg="Định dạng ngày tháng không chính xác"/>
                    (dd/mm/yyyy)
                </td>
            </tr>
            <tr valign="baseline">
                <td nowrap="nowrap" align="right">Email:</td>
                <td><input type="text" name="email" value="<?php echo htmlentities($row_RCcapnhat_nhanvien['email'], ENT_COMPAT, 'utf-8'); ?>" size="32" data-validation="email" data-validation-error-msg="Định dạng email không chính xác"/></td>
                <td>Nơi cấp:</td>
                <td><input type="text" name="noi_cap" value="<?php echo htmlentities($row_RCcapnhat_nhanvien['noi_cap'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
            </tr>
            <tr valign="baseline">
                <td nowrap="nowrap" align="right">Quê quán:</td>
                <td colspan="3"><input type="text" name="que_quan" value="<?php echo htmlentities($row_RCcapnhat_nhanvien['que_quan'], ENT_COMPAT, 'utf-8'); ?>" size="90" data-validation="required" data-validation-error-msg="Thông tin bắt buộc"/></td>
            </tr>
            <tr valign="baseline">
                <td nowrap="nowrap" align="right">Địa chỉ:</td>
                <td colspan="3"><input type="text" name="dia_chi" value="<?php echo htmlentities($row_RCcapnhat_nhanvien['dia_chi'], ENT_COMPAT, 'utf-8'); ?>" size="90" /></td>
            </tr>
            <tr valign="baseline">
                <td nowrap="nowrap" align="right">Tạm trú:</td>
                <td colspan="3"><input type="text" name="tam_tru" value="<?php echo htmlentities($row_RCcapnhat_nhanvien['tam_tru'], ENT_COMPAT, 'utf-8'); ?>" size="90" data-validation="required" data-validation-error-msg="Thông tin bắt buộc"/></td>
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
                        <?php
            
                            //echo $ma_nv;
                            $mydb->setQuery("SELECT * FROM tlb_hinhanh WHERE `ma_nhan_vien`='$ma_nv'");
                            $cur = $mydb->loadResultList();
                            if ($mydb->affected_rows()== 0){
                                echo '<img id="uploadPreview1" src="./uploads/p.jpg" class="img-thumbnail" width="200px" height="100px" />';    
                            
                            } 
                            foreach($cur as $object){
                               
                                    echo '<img id="uploadPreview1" src="./uploads/'. $object->filename.'" class="img-thumbnail" width="200px" height="100px" />';
                                
                                }
 
                        ?>
                    </div>
                </td>
            </tr>
            <tr valign="baseline">
                <td colspan="3"></td>
                <td align="right">
                    <input onClick="ConfirmEdit()" type="submit" class="btn btn-default" name="submit" id="submit" value="Cập nhật thông tin" />
                </td>
            </tr>
            <tfoot>
                <tr>
                    <td colspan="3" class="rounded-foot-left"><em><b><u>Hướng Dẫn:</u></b> 
                                                                <br>&nbsp;+ Các trường gắn (*) bắt buộc phải có 
                                                                <br>&nbsp;+ Sửa các thông tin bằng cách chọn sẵn hoặc gõ bằng bàn phím
                                                                <br>&nbsp;+ Nhấn Cập nhật thông tin để hoàn tất thao tác</em></td>
                    <td class="rounded-foot-right"><a href="#" onclick="go_back()" class="bt_red"><span class="bt_red_lft"></span><strong>Quay lại</strong><span class="bt_red_r"></span></a></td>

                </tr>
            </tfoot>

        </table>
        <input type="hidden" name="MM_update" value="edit_staff_form" />
        <input type="hidden" name="ma_nhan_vien" value="<?php echo $row_RCcapnhat_nhanvien['ma_nhan_vien']; ?>" />
    </form>
    <script src="js/form-validator/jquery.form-validator.min.js"></script>
    <script>
    /* important to locate this script AFTER the closing form element, so form object is loaded in DOM before setup is called */
        $.validate({
            modules : 'date, security, file'
        });
    </script>
    
    <script>
        function go_back()
        {
            location.href='index.php?require=danh_sach_nhan_vien.php&title=Danh sách nhân viên';
        }
        function ConfirmEdit()
        {
            if (confirm("Bạn có chắc chắn thao tác cập nhật!"))
            {
                edit_staff_form.submit();
                return true;
            }  
        }
    </script> 
</body>
</html>
