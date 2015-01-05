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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "update_job_form")) {
    $sDate = str_replace('/', '-', $_POST['ngay_vao_lam']);
    $sDate = date('Y-m-d', strtotime($sDate));
    $muc_luong_cb = $_POST['muc_luong_cb'];
    $he_so = $_POST['he_so'];
    $phu_cap = $_POST['phu_cap'];
    $tong_luong = ($muc_luong_cb * $he_so) + $phu_cap;
    echo $tong_luong;
    $updateSQL = sprintf("UPDATE tlb_congviec SET ngay_vao_lam='{$sDate}', phong_ban_id=%s, cong_viec_id=%s, chuc_vu_id=%s, muc_luong_cb='{$muc_luong_cb}', he_so='{$he_so}', phu_cap='{$phu_cap}', tong_luong='{$tong_luong}', tknh=%s, ngan_hang=%s WHERE ma_nhan_vien='{$ma_nv}'",
        GetSQLValueString($_POST['phong_ban_id'], "text"),
        GetSQLValueString($_POST['cong_viec_id'], "text"),
        GetSQLValueString($_POST['chuc_vu_id'], "text"),
        GetSQLValueString($_POST['tknh'], "text"),
        GetSQLValueString($_POST['ngan_hang'], "text"));

    $mydb->setQuery($updateSQL);
    $result = $mydb->executeQuery();
    $updateGoTo = "danh_sach_nhan_vien.php";
    if (isset($_SERVER['QUERY_STRING'])) {
        $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
        $updateGoTo .= $_SERVER['QUERY_STRING'];
    }
    sprintf("location: %s", $updateGoTo);
}
$mydb->setQuery("SELECT * FROM tlb_congviec where ma_nhan_vien = '$ma_nv'");
$RCcapnhat_congviec = $mydb->executeQuery();
$row_RCcapnhat_congviec = $mydb->fetch_assoc($RCcapnhat_congviec);
$totalRows_RCcapnhat_congviec = $mydb->num_rows($RCcapnhat_congviec);

if ($totalRows_RCcapnhat_congviec==0)
{
    $url = "index.php?require=them_moi_cong_viec.php&catID=$ma_nv&title=Thêm mới công việc";
    location($url);
}
$mydb->setQuery("SELECT * FROM tlb_phongban inner join tlb_congviec on tlb_phongban.phong_ban_id = tlb_congviec.phong_ban_id where tlb_congviec.ma_nhan_vien = '$ma_nv'");
$RCphongban1 = $mydb->executeQuery();
$row_RCphongban1 = $mydb->fetch_assoc($RCphongban1);
$totalRows_RCphongban1 = $mydb->num_rows($RCphongban1);

// Lấy danh sách sau khi phòng ban cập nhật
$mydb->setQuery("SELECT * FROM tlb_phongban");
$RCphongban = $mydb->executeQuery();
$row_RCphongban = $mydb->fetch_assoc($RCphongban);
$totalRows_RCphongban = $mydb->num_rows($RCphongban);

// Lấy công việc hiện tại
$mydb->setQuery("SELECT * FROM tlb_ctcongviec inner join tlb_congviec on tlb_ctcongviec.cong_viec_id = tlb_congviec.cong_viec_id where tlb_congviec.ma_nhan_vien = '$ma_nv'");
$RCctcongviec1 = $mydb->executeQuery();
$row_RCctcongviec1 = $mydb->fetch_assoc($RCctcongviec1);
$totalRows_RCctcongviec1 = $mydb->num_rows($RCctcongviec1);

// Lấy danh sách công việc sau khi cập nhật
$mydb->setQuery("SELECT * FROM tlb_ctcongviec");
$RCctcongviec = $mydb->executeQuery();
$row_RCctcongviec = $mydb->fetch_assoc($RCctcongviec);
$totalRows_RCctcongviec = $mydb->num_rows($RCctcongviec);

// Lấy danh sách chức vụ hiện tại
$mydb->setQuery("SELECT * FROM tlb_chucvu inner join tlb_congviec on tlb_chucvu.chuc_vu_id = tlb_congviec.chuc_vu_id where tlb_congviec.ma_nhan_vien = '$ma_nv'");
$RCChucvu1 = $mydb->executeQuery();
$row_RCChucvu1 = $mydb->fetch_assoc($RCChucvu1);
$totalRows_RCChucvu1 = $mydb->num_rows($RCChucvu1);

// Lấy danh sách chức vụ sau khi cập nhật
$mydb->setQuery("SELECT * FROM tlb_chucvu");
$RCChucvu = $mydb->executeQuery();
$row_RCChucvu = $mydb->fetch_assoc($RCChucvu);
$totalRows_RCChucvu = $mydb->num_rows($RCChucvu);



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
<!--MAIN UP CONTENT -->
    <div class="detail_up">
        <table id="rounded-corner" border="0" width="750">
            <thead>
                <tr>
                    <th align="left" colspan="3" class="rounded-content" width="700"><h3>Thông Tin Tại Công Ty</h3></th>
                    <th align="center" class="rounded-q4"></th>
                </tr>
            </thead>
                <tr valign="baseline">
                    <td>Mã nhân viên:</td>
                    <td style="color:red"><b><?php echo $ma_nv; ?></b></td>
                </tr>
                <tr valign="baseline">
                    <td>Nhân viên:</td>
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
                    <td>Ngày vào làm:</td>
                    <td><b><?php echo date("d/m/Y", strtotime($row_RCcapnhat_congviec['ngay_vao_lam'])); ?></b></td>
                </tr>
                <tr>
                    <td>Mảng lĩnh vực:</td>
                    <td><b><?php echo $row_RCctcongviec1['ten_cong_viec']; ?></b></td>
                </tr>
                <tr>
                    <td>Phòng ban:</td>
                    <td><b><?php echo $row_RCphongban1['ten_phong_ban']; ?></b></td>
                </tr>
                <tr>
                    <td>Chức vụ:</td>
                    <td><b><?php echo $row_RCChucvu1['ten_chuc_vu']; ?></b></td>
                </tr>
                <tr>
                    <td>Mức lương:
                    <td><b><?php echo number_format($row_RCcapnhat_congviec['muc_luong_cb'],0,',','.'); ?><b></td>
                    <td>Hệ số: <b><?php echo $row_RCcapnhat_congviec['he_so']; ?></b></td>
                    <td>Phụ cấp: <b><?php echo number_format($row_RCcapnhat_congviec['phu_cap'],0,',','.'); ?></b></td>
                </tr>
                <tr>
                    <td>Tổng lương: </td>
                    <td><b><?php echo number_format($row_RCcapnhat_congviec['tong_luong'],0,',','.'); ?></b></td>
                </tr>
                <tr>
                    <td>Tài khoản NH: <b><?php echo $row_RCcapnhat_congviec['tknh']; ?><b></td>
                    <td colspan="3">Ngân hàng: <b><?php echo $row_RCcapnhat_congviec['ngan_hang']; ?></b></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="2"></td>
                    <td></td>
                </tr>
        </table>
    </div>
<!--MAIN BOTTOM CONTENT -->

    <div class="detail_bottom">
    
        <form action="<?php echo $editFormAction; ?>" method="post" name="update_job_form" id="update_job_form">
            <table class="row2" width="800" align="center" cellpadding="1" cellspacing="1" bgcolor="#66CCFF">
                <tr valign="baseline">
                    <td width="102" align="right" nowrap="nowrap">Mã nhân viên:</td>
                    <td width="219"><?php echo $row_RCcapnhat_congviec['ma_nhan_vien']; ?></td>
                    <td width="110">Tài khoản NH:</td>
                    <td width="291"><input type="text" name="tknh" value="<?php echo htmlentities($row_RCcapnhat_congviec['tknh'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Ngày vào làm *:</td>
                    <td><input type="text" name="ngay_vao_lam" value="<?php echo htmlentities($row_RCcapnhat_congviec['ngay_vao_lam'], ENT_COMPAT, 'utf-8'); ?>" size="25" /></td>
                    <td>Ngân hàng:</td>
                    <td><input type="text" name="ngan_hang" value="<?php echo htmlentities($row_RCcapnhat_congviec['ngan_hang'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Phòng ban:</td>
                    <td>
                        <select name="phong_ban_id">
                            <option selected="selected" value="<?php echo $row_RCphongban1['phong_ban_id']?>"><?php echo $row_RCphongban1['ten_phong_ban']?></option>
                        <?php 
                            do {  
                        ?>
                            <option value="<?php echo $row_RCphongban['phong_ban_id']?>"><?php echo $row_RCphongban['ten_phong_ban']?></option>
                        <?php
                            } while ($row_RCphongban = $mydb->fetch_assoc($RCphongban));
                        ?>
                        </select>   
                    </td>
                    <td></td>
                    <td></td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Công việc:</td>
                    <td>
                        <select name="cong_viec_id">
                            <option selected="selected" value="<?php echo $row_RCctcongviec1['cong_viec_id']?>"><?php echo $row_RCctcongviec1['ten_cong_viec']?></option>
                        <?php 
                            do {  
                        ?>
                            <option value="<?php echo $row_RCctcongviec['cong_viec_id']?>"><?php echo $row_RCctcongviec['ten_cong_viec']?></option>
                        <?php
                            } while ($row_RCctcongviec = $mydb->fetch_assoc($RCctcongviec));
                        ?>
                        </select>
                    </td>
                    <td></td>
                    <td></td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Chức vụ:</td>
                    <td>
                        <select name="chuc_vu_id">
                            <option selected="selected" value="<?php echo $row_RCChucvu1['chuc_vu_id']?>"><?php echo $row_RCChucvu1['ten_chuc_vu']?></option>
                        <?php 
                            do {  
                        ?>
                            <option value="<?php echo $row_RCChucvu['chuc_vu_id']?>"><?php echo $row_RCChucvu['ten_chuc_vu']?></option>
                        <?php
                            } while ($row_RCChucvu = $mydb->fetch_assoc($RCChucvu));
                        ?>
                        </select>
                    </td>
                    <td></td>
                    <td></td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Mức lương:</td>
                    <td><input type="text" name="muc_luong_cb" value="<?php echo htmlentities($row_RCcapnhat_congviec['muc_luong_cb'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Hệ số:</td>
                    <td><input type="text" name="he_so" value="<?php echo htmlentities($row_RCcapnhat_congviec['he_so'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Phụ cấp:</td>
                    <td><input type="text" name="phu_cap" value="<?php echo $row_RCcapnhat_congviec['phu_cap']; ?>" size="32" /></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr valign="baseline">
                    <td colspan="4" align="center" nowrap="nowrap"><input type="submit" value=":|: Cập nhật :|:" /></td>
                </tr>
            </table>
            <input type="hidden" name="MM_update" value="update_job_form" />
            <input type="hidden" name="ma_nhan_vien" value="<?php echo $row_RCcapnhat_congviec['ma_nhan_vien']; ?>" />
        </form>
    </div>
</body>
</html>
