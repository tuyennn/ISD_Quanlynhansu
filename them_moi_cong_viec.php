<?php require_once('includes/initialize.php'); ?>
<?php
$ma_nv = get_param('catID');
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "new_job_form")) {
    $sDate = str_replace('/', '-', $_POST['ngay_vao_lam']);
    $sDate = date('Y-m-d', strtotime($sDate));
    $muc_luong_cb = $_POST['muc_luong_cb'];
    $he_so = $_POST['he_so'];
    $phu_cap = $_POST['phu_cap'];
    $tong_luong = ($muc_luong_cb * $he_so) + $phu_cap;


    $insertSQL = sprintf("INSERT INTO tlb_congviec (ma_nhan_vien, ngay_vao_lam, ma_phong_ban, ma_cong_viec, ma_chuc_vu, muc_luong_cb, he_so, phu_cap, tong_luong, tknh, ngan_hang) VALUES ('{$ma_nv}', '{$sDate}', %s, %s, %s, '{$muc_luong_cb}', '{$he_so}', '{$phu_cap}', '{$tong_luong}', %s, %s)",
        GetSQLValueString(get_param('ma_phong_ban'), "text"),
        GetSQLValueString(get_param('ma_cong_viec'), "text"),
        GetSQLValueString(get_param('ma_chuc_vu'), "text"),
        GetSQLValueString(get_param('tknh'), "text"),
        GetSQLValueString(get_param('ngan_hang'), "text"),
        GetSQLValueString(get_param('ghi_chu'), "text"));

    $mydb->setQuery($insertSQL);
    $result_c = $mydb->executeQuery();
    if($result_c) {
        $message = "$.growl('<strong>Thao tác thêm mới thành công!</strong> ', { 
                        type: 'success'
                    });";
        $url = "index.php?require=cap_nhat_thong_tin_cong_viec.php&catID=".$ma_nv."&title=Thông tin công việc";
        location($url);
        echo "<script type='text/javascript'>$(function() {" . $message . "});</script>";
    }
    else {
        $message = "$.growl('<strong>Thao tác thêm mới thất bại!</strong> ', { 
                        type: 'danger'
                    });";
        $url = "index.php?require=danh_sach_nhan_vien.php&title=Danh sách nhân viên";
        location($url);
        echo "<script type='text/javascript'>$(function() {" . $message . "});</script>";
    }

    $insertGoTo = "danh_sach_nhan_vien.php";
    if (isset($_SERVER['QUERY_STRING'])) {
        $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
        $insertGoTo .= $_SERVER['QUERY_STRING'];
    }
}


$mydb->setQuery("SELECT * FROM tlb_phongban");
$RCPhongban = $mydb->executeQuery();
$row_RCPhongban = $mydb->fetch_assoc($RCPhongban);
$totalRows_RCPhongban = $mydb->num_rows($RCPhongban);


// Lấy mã nhân viên đưa vào để cập nhật
$mydb->setQuery("SELECT * FROM tlb_nhanvien where ma_nhan_vien= '$ma_nv'");
$RCThem_congviec = $mydb->executeQuery();
$row_RCThem_congviec = $mydb->fetch_assoc($RCThem_congviec);
$totalRows_RCThem_congviec = $mydb->num_rows($RCThem_congviec);


// Lấy danh sách công việc khi tiến hành cập nhật
$mydb->setQuery("SELECT * FROM tlb_ctcongviec");
$RCctcongviec = $mydb->executeQuery();
$row_RCctcongviec = $mydb->fetch_assoc($RCctcongviec);
$totalRows_RCctcongviec = $mydb->num_rows($RCctcongviec);

// Lấy danh sách chức vụ
$mydb->setQuery("SELECT * FROM tlb_chucvu");
$RCChucvu = $mydb->executeQuery();
$row_RCChucvu = $mydb->fetch_assoc($RCChucvu);
$totalRows_RCChucvu = $mydb->num_rows($RCChucvu);


$mydb->setQuery("SELECT * FROM tlb_congviec where ma_nhan_vien = '$ma_nv'");
$RCCheck = $mydb->executeQuery();
$row_RCCheck = $mydb->fetch_assoc($RCCheck);
$totalRows_RCCheck = $mydb->num_rows($RCCheck);

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
            $("#ngay_vao_lam").datepicker({showOn: 'button', buttonImage: 'images/calendar.gif', buttonImageOnly: true, dateFormat: 'dd/mm/yy', changeMonth: true, changeYear: true});
            $('#ui-datepicker-div').wrap('<div class="datepicker ll-skin-siena"></div>')
        });
    </script>
</head>

<body text="#000000" link="#CC0000" vlink="#0000CC" alink="#000099">
    <div style="display: none;">
        <img id="calImg" src="images/calendar.gif" alt="Popup" class="trigger">
    </div>

    <!--MAIN UP CONTENT -->
    <div class="detail_up">
        <table id="rounded-corner" border="0" width="460" align="center" cellpadding="1" cellspacing="1">
            <span><h4>Chưa có quá trình công việc được ghi lại, mời thêm mới</h4></span>
        </table>
    </div>
    <!--MAIN BOTTOM CONTENT -->
    <div class="detail_bottom">

        <form action="<?php echo $editFormAction; ?>" method="post" name="new_job_form" id="new_job_form">
            <table id="rounded-corner" width="750" align="center">
                <tr valign="baseline">
                    <td width="96" align="right" nowrap="nowrap">Mã nhân viên:</td>
                    <td style="color:red"><b><?php echo $ma_nv; ?></b></td>
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
                    <td nowrap="nowrap" align="right">Ngày vào làm (*):</td>
                    <td>
                        <input type="text" name="ngay_vao_lam" id="ngay_vao_lam" value="" size="27" data-validation="date" data-validation-format="dd/mm/yyyy"/>
                        (dd/mm/yyyy)
                    </td>
                    <td colspan="2"></td> 
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Phòng ban:</td>
                    <td>
                        <select name="ma_phong_ban">
                        <?php 
                        do {  
                        ?>
                            <option value="<?php echo $row_RCPhongban['ma_phong_ban']?>"><?php echo $row_RCPhongban['ten_phong_ban']?></option>
                        <?php
                        } while ($row_RCPhongban = $mydb->fetch_assoc($RCPhongban));
                        ?>
                        </select>
                    </td>
                    <td colspan="2"></td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Mảng lĩnh vực:</td>
                    <td>
                        <select name="ma_cong_viec">
                        <?php 
                        do {  
                        ?>
                            <option value="<?php echo $row_RCctcongviec['ma_cong_viec']?>"><?php echo $row_RCctcongviec['ten_cong_viec']?></option>
                        <?php
                        } while ($row_RCctcongviec = $mydb->fetch_assoc($RCctcongviec));
                        ?>
                        </select>
                    </td>
                    <td colspan="2"></td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Chức vụ:</td>
                    <td>
                        <select name="ma_chuc_vu">
                        <?php 
                        do {  
                        ?>
                            <option value="<?php echo $row_RCChucvu['ma_chuc_vu']?>"><?php echo $row_RCChucvu['ten_chuc_vu']?></option>
                        <?php
                        } while ($row_RCChucvu = $mydb->fetch_assoc($RCChucvu));
                        ?>
                        </select>
                    </td>
                    <td colspan="2"></td>
                </tr>
                <?php
                    $sql="SELECT muc_luong FROM `tlb_quatrinhluong` ORDER BY `tlb_quatrinhluong`.`ngay_chuyen` DESC LIMIT 1";
                    $rs=mysql_query($sql) or die('Cannot select tlb_quatrinhluong');
                    while($row=mysql_fetch_array($rs)){
                        
                ?>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Mức lương :</td>
                    <td><input type="text" name="muc_luong_cb" value="<?php echo $row['muc_luong']; ?>" size="32" readonly="readonly" data-validation="required" data-validation-error-msg="Thông tin bắt buộc" /> VND</td>
                    <td colspan="2"></td>
                <?php } ?>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Hệ số:</td>
                    <td><input type="text" name="he_so" value="" size="32" data-validation="required"/></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Phụ cấp:</td>
                    <td><input type="text" name="phu_cap" value="" size="32" data-validation="number"/></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Tài khoản NH:</td>
                    <td><input type="text" name="tknh" value="" size="32" data-validation="number"/></td>
                    <td>Ngân hàng:</td>
                    <td><input type="text" name="ngan_hang" value="" size="32" data-validation="required"/></td>
                </tr>
                <tr valign="middle">
                    <td nowrap="nowrap" align="right">Ghi chú:</td>
                    <td colspan="3"><textarea name="ghi_chu" value="" rows="5" cols="60"></textarea></td>
                </tr>
                <tr valign="baseline">
                    <td colspan="4" align="center" nowrap="nowrap">
                        <input type="submit" onClick="ConfirmCreate()" class="btn btn-default" name="submit" id="addjob" value="Thêm mới công việc" />
                    </td>
                </tr>
            </table>
            <input type="hidden" name="MM_insert" value="new_job_form" />
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
    </div>
</body>
</html>
