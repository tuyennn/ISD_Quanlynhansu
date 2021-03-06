<?php
$ma_nv = $_GET['catID'];
$id = $_GET['tomID'];
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "update_salary_form")) {
    $tDate = str_replace('/', '-', $_POST['ngay_chuyen']);
    $tDate = date('Y-m-d', strtotime($tDate));
    $currentDate = date("Y-m-d");

    $updateSQL = sprintf("UPDATE tlb_quatrinhluong SET so_quyet_dinh=%s, ngay_chuyen='{$tDate}', muc_luong=%s, ghi_chu=%s, ngay_sua='{$currentDate}' WHERE id='{$id}' AND ma_nhan_vien='{$ma_nv}'",
        GetSQLValueString($_POST['so_quyet_dinh'], "text"),
        GetSQLValueString($_POST['muc_luong'], "text"),
        GetSQLValueString($_POST['ghi_chu'], "text"));
    $mydb->setQuery($updateSQL);
    $result_e = $mydb->executeQuery();
    if($result_e) {
        $message = "Thao tác cập nhật thành công!";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
    else {
        $message = "Thao tác cập nhật thất bại!";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }

    $updateGoTo = "them_moi_qua_trinh_luong.php";
    if (isset($_SERVER['QUERY_STRING'])) {
        $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
        $updateGoTo .= $_SERVER['QUERY_STRING'];
    }
    sprintf("location: %s", $updateGoTo);
}

$mydb->setQuery("SELECT * FROM tlb_quatrinhluong where ma_nhan_vien = '$ma_nv' ORDER BY `tlb_quatrinhluong`.`ngay_chuyen` DESC");
$RCQTluong_DS = $mydb->executeQuery();
$row_RCQTluong_DS = $mydb->fetch_assoc($RCQTluong_DS);
$totalRows_RCQTluong_DS = $mydb->num_rows($RCQTluong_DS);
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
            $("#ngay_chuyen").datepicker({showOn: 'button', buttonImage: 'images/calendar.gif', buttonImageOnly: true, dateFormat: 'dd/mm/yy', changeMonth: true, changeYear: true});
            $('#ui-datepicker-div').wrap('<div class="datepicker ll-skin-siena"></div>')
        });
    </script>
</head>

<body text="#000000" link="#CC0000" vlink="#0000CC" alink="#000099">
    <div style="display: none;">
        <img id="calImg" src="images/calendar.gif" alt="Popup" class="trigger">
    </div>
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

    <!--MAIN UP CONTENT -->
    <div class="detail_up">
        <table id="rounded-corner" align="center" cellpadding="1" cellspacing="1">
            <thead>
            <tr>
                <th width="200" class="rounded-content">Số quyết định</th>
                <th width="150">Ngày chuyển mức</th>
                <th width="150">Ngày sửa</th>
                <th align="right" width="200"  class="rounded-q4">Mức lương</th>
            </tr>
            </thead>
            <?php do { ?>
            <tr>
                <td><?php echo $row_RCQTluong_DS['so_quyet_dinh']; ?></td>
                <td><?php echo date("d/m/Y", strtotime($row_RCQTluong_DS['ngay_chuyen'])); ?></td>
                <td><?php echo date("d/m/Y", strtotime($row_RCQTluong_DS['ngay_sua'])); ?></td>
                <td align="right"><?php echo number_format($row_RCQTluong_DS['muc_luong'],0,',','.'); ?> VND</td>
            </tr>
            <?php } while ($row_RCQTluong_DS = $mydb->fetch_assoc($RCQTluong_DS)); ?>
        </table>
    </div>
    <!--MAIN BOTTOM CONTENT -->

    <div class="detail_bottom">
        <?php
            $mydb->setQuery("SELECT * FROM tlb_quatrinhluong where id = $id");
            $RCQTluong_CN = $mydb->executeQuery();
            $row_RCQTluong_CN = $mydb->fetch_assoc($RCQTluong_CN);
            $totalRows_RCQTluong_CN = $mydb->num_rows($RCQTluong_CN);	
        ?>
        <form action="<?php echo $editFormAction; ?>" method="post" name="update_salary_form" id="update_salary_form">
            <table id="rounded-corner" width="750" align="center">
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right" width="380">Mã nhân viên:</td>
                    <td style="color:red"><b><?php echo $ma_nv; ?></b></td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Nhân viên:</td>
                    <td style="color:red"><b>
                    <?php
            
                        //echo $ma_nv;
                        $mydb->setQuery("SELECT ho_ten FROM tlb_nhanvien WHERE `ma_nhan_vien`='$ma_nv' ");
                        $cur = $mydb->loadResultList();
                        foreach($cur as $object){
                           
                                echo $object->ho_ten;
                            
                            }

                    ?></b>
                    </td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Số quyết định:</td>
                    <td>
                        <input type="text" name="so_quyet_dinh" value="<?php echo htmlentities($row_RCQTluong_CN['so_quyet_dinh'], ENT_COMPAT, 'utf-8'); ?>" size="54" data-validation="required"/>
                    </td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Ngày chuyển mức:</td>
                    <td>
                        <input type="text" name="ngay_chuyen" id="ngay_chuyen" value="<?php echo htmlentities(date("d/m/Y", strtotime($row_RCQTluong_CN['ngay_chuyen'])), ENT_COMPAT, 'utf-8'); ?>" size="27" data-validation="date" data-validation-format="dd/mm/yyyy"/>
                        (dd/mm/yyyy)
                    </td>
                </tr>

                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Mức lương:</td>
                    <td>
                        <input type="text" name="muc_luong" value="<?php echo $row_RCQTluong_CN['muc_luong']; ?>" size="54" data-validation="number"/>
                    </td>
                </tr>
                <tr valign="middle">
                    <td nowrap="nowrap" align="right">Ghi chú:</td>
                    <td><textarea name="ghi_chu" rows="5" cols="60"><?php echo htmlentities($row_RCQTluong_CN['ghi_chu'], ENT_COMPAT, 'utf-8'); ?></textarea></td>                 
                </tr>
                <tr valign="baseline">
                    <td colspan="2" align="right">
                        <input onClick="go_back()" class="btn btn-default" value="Quay lại" />
                        <input type="submit" class="btn btn-default" name="submit" id="editsalary" value="Cập nhật quá trình lương" />
                        <script type="text/javascript">
                            function go_back()
                            {
                                location.href='index.php?require=them_moi_qua_trinh_luong.php&catID=<?php echo $ma_nv; ?>&title=Cập nhật quá trình lương&action=new';
                            }
                        </script>
                    </td>
                </tr>
                <tfoot>
                    <tr>
                        <td class="rounded-foot-left">
                            <em><p><b><u>Hướng Dẫn:</u></b> 
                                <br>&nbsp;+ Các mục cập nhật vào là bắt buộc
                                <br>&nbsp;+ Để quay lại trang thống kê nhấn nút Quay lại
                                <br>&nbsp;+ Hoàn thành bằng việc xác nhận nút Cập nhật
                            </em></td>
                        <td class="rounded-foot-right">&nbsp;</td>

                    </tr>
                </tfoot>
            </table>
            <input type="hidden" name="MM_update" value="update_salary_form" />
            <input type="hidden" name="id" value="<?php echo $row_RCQTluong_CN['id']; ?>" />
    </form>
    <script src="js/form-validator/jquery.form-validator.min.js"></script>
    <script src="js/form-validator/locale.vi.js"></script>
    <script>
    /* important to locate this script AFTER the closing form element, so form object is loaded in DOM before setup is called */
        $.validate({
            modules : 'date, security',
            language : enErrorDialogs
        });
    </script>
</body>
</html>
