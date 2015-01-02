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
    $insertSQL = sprintf("INSERT INTO tlb_congviec (ma_nhan_vien, ngay_vao_lam, phong_ban_id, cong_viec_id, chuc_vu_id, muc_luong_cb, he_so, phu_cap, tknh, ngan_hang) VALUES ('$ma_nv', %s, %s, %s, %s, %s, %s, %s, %s, %s)",
        GetSQLValueString(get_param('ngay_vao_lam'), "date"),
        GetSQLValueString(get_param('phong_ban_id'), "text"),
        GetSQLValueString(get_param('cong_viec_id'), "text"),
        GetSQLValueString(get_param('chuc_vu_id'), "text"),
        GetSQLValueString(get_param('muc_luong_cb'), "text"),
        GetSQLValueString(get_param('he_so'), "text"),
        GetSQLValueString(get_param('phu_cap'), "text"),
        GetSQLValueString(get_param('tknh'), "text"),
        GetSQLValueString(get_param('ngan_hang'), "text"));

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
    <link rel="stylesheet" type="text/css" href="css/jquery.datepick.css" />
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery.plugin.js"></script> 
    <script type="text/javascript" src="js/jquery.datepick.js"></script>
    <script type="text/javascript" src="js/jquery.datepick-vi.js"></script>
    <script>
    $(function() {
        $('#ngay_vao_lam').datepick({showOnFocus: false, showTrigger: '#calImg'});
         
        var formats = ['mm/dd/yyyy', 'M d, yyyy', 'MM d, yyyy', 
            'DD, MM d, yyyy', 'mm/dd/yy', 'dd/mm/yyyy', 
            'mm/dd/yyyy (\'w\'w)', '\'Day\' d \'of\' MM, yyyy', 
            $.datepick.ATOM, $.datepick.COOKIE, $.datepick.ISO_8601, 
            $.datepick.RFC_822, $.datepick.RFC_850, $.datepick.RFC_1036, 
            $.datepick.RFC_1123, $.datepick.RFC_2822, $.datepick.RSS, 
            $.datepick.TICKS, $.datepick.TIMESTAMP, $.datepick.W3C]; 
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
                <tr>
                    <td width="117">Tài khoản NH:</td>
                    <td width="300"><input type="text" name="tknh" value="" size="32" /></td>
                    <td>Ngân hàng:</td>
                    <td><input type="text" name="ngan_hang" value="" size="32" /></td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Ngày vào làm (*):</td>
                    <td>
                        <input type="text" name="ngay_vao_lam" id="ngay_vao_lam" value="" size="27" data-validation="birthdate" data-validation-format="dd/mm/yyyy" data-validation-error-msg="Định dạng ngày tháng không chính xác" />
                        (dd/mm/yyyy)
                    </td>
                    <td colspan="2"></td> 
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Phòng ban:</td>
                    <td>
                        <select name="phong_ban_id">
                        <?php 
                        do {  
                        ?>
                            <option value="<?php echo $row_RCPhongban['phong_ban_id']?>"><?php echo $row_RCPhongban['ten_phong_ban']?></option>
                        <?php
                        } while ($row_RCPhongban = $mydb->fetch_assoc($RCPhongban));
                        ?>
                        </select>
                    </td>
                    <td colspan="2"></td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Công việc:</td>
                    <td>
                        <select name="cong_viec_id">
                        <?php 
                        do {  
                        ?>
                            <option value="<?php echo $row_RCctcongviec['cong_viec_id']?>"><?php echo $row_RCctcongviec['ten_cong_viec']?></option>
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
                        <select name="chuc_vu_id">
                        <?php 
                        do {  
                        ?>
                            <option value="<?php echo $row_RCChucvu['chuc_vu_id']?>"><?php echo $row_RCChucvu['ten_chuc_vu']?></option>
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
                    <td><input type="text" name="muc_luong_cb" value="<?php echo number_format($row['muc_luong'],0,',','.'); ?>" size="32" readonly="readonly" data-validation="required" data-validation-error-msg="Thông tin bắt buộc" /> VND</td>
                    <td colspan="2"></td>
                <?php } ?>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Hệ số:</td>
                    <td><input type="text" name="he_so" value="" size="32"data-validation="required" data-validation-error-msg="Thông tin bắt buộc" /></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Phụ cấp:</td>
                    <td><input type="text" name="phu_cap" value="" size="32" data-validation="required" data-validation-error-msg="Thông tin bắt buộc"/></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr valign="baseline">
                    <td colspan="4" align="center" nowrap="nowrap"><input type="submit" value="Insert record" /></td>
                </tr>
            </table>
            <input type="hidden" name="MM_insert" value="new_job_form" />
        </form>
        <script src="js/form-validator/jquery.form-validator.min.js"></script>
        <script>
        /* important to locate this script AFTER the closing form element, so form object is loaded in DOM before setup is called */
            $.validate({
                modules : 'date, security'
            });
        </script>
    </div>
</body>
</html>
