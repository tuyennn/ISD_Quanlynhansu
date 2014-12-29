<?php require_once('includes/initialize.php'); ?>
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "update_insurance_form")) {

    $sDate = str_replace('/', '-', $_POST['ngay_cap_bhxh']);
    $tDate = str_replace('/', '-', $_POST['ngay_cap_bhyt']);
    $sDate = date('Y-m-d', strtotime($sDate));
    $tDate = date('Y-m-d', strtotime($tDate));

    $updateSQL = sprintf("UPDATE tlb_baohiem SET so_bhxh=%s, ngay_cap_bhxh='{$sDate}', noi_cap_bhxh=%s, so_bhyt=%s, ngay_cap_bhyt='{$tDate}', noi_cap_bhyt=%s WHERE id='{$id}' AND ma_nhan_vien='{$ma_nv}'",
        GetSQLValueString($_POST['so_bhxh'], "text"),
        GetSQLValueString($_POST['noi_cap_bhxh'], "text"),
        GetSQLValueString($_POST['so_bhyt'], "text"),
        GetSQLValueString($_POST['noi_cap_bhyt'], "text"));

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

    $updateGoTo = "them_moi_bao_hiem.php";
    if (isset($_SERVER['QUERY_STRING'])) {
        $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
        $updateGoTo .= $_SERVER['QUERY_STRING'];
}
sprintf("location: %s", $updateGoTo);
}

$mydb->setQuery("SELECT * FROM tlb_baohiem");
$RCBaohiem_DS = $mydb->executeQuery();
$row_RCBaohiem_DS = $mydb->fetch_assoc($RCBaohiem_DS);
$totalRows_RCBaohiem_DS = $mydb->num_rows($RCBaohiem_DS);

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
            $('#ngay_cap_bhxh').datepick({showOnFocus: false, showTrigger: '#calImg'});
            $('#ngay_cap_bhyt').datepick({showOnFocus: false, showTrigger: '#calImg'});

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
    <!--MAIN TAB LINKS -->
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
        <table id="rounded-corner" border="0" width="750">
            <thead>
                <tr>
                    <th width="120" class="rounded-content">Số BHXH</th>
                    <th width="90">Ngày cấp</th>
                    <th width="140">Nơi cấp</th>
                    <th width="120">Số BHYT</th>
                    <th width="90">Ngày cấp</th>
                    <th width="140" class="rounded-q4">Nơi cấp</th>
                </tr>
            </thead>
        <tr class="row">
            <td><?php echo $row_RCBaohiem_DS['so_bhxh']; ?></td>
            <td><?php echo date("d/m/Y", strtotime($row_RCBaohiem_DS['ngay_cap_bhxh'])); ?></td>
            <td><?php echo $row_RCBaohiem_DS['noi_cap_bhxh']; ?></td>
            <td><?php echo $row_RCBaohiem_DS['so_bhyt']; ?></td>
            <td><?php echo date("d/m/Y", strtotime($row_RCBaohiem_DS['ngay_cap_bhyt'])); ?></td>
            <td><?php echo $row_RCBaohiem_DS['noi_cap_bhyt']; ?></td>
        </tr>
    </table>
    
    <?php
        $mydb->setQuery("SELECT * FROM tlb_baohiem inner join tlb_nhanvien on tlb_baohiem.ma_nhan_vien = tlb_nhanvien.ma_nhan_vien where tlb_baohiem.ma_nhan_vien = '$ma_nv'");
        $RCBaohiem_CN = $mydb->executeQuery();
        $row_RCBaohiem_CN = $mydb->fetch_assoc($RCBaohiem_CN);
        $totalRows_RCBaohiem_CN = $mydb->num_rows($RCBaohiem_CN);
    ?>
    <form action="<?php echo $editFormAction; ?>" method="post" name="update_insurance_form" id="update_insurance_form">
        <table id="rounded-corner" width="750" align="center">
            <tr valign="baseline">
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
                    <td nowrap="nowrap" align="right">Số BHXH:</td>
                    <td>
                        <input type="text" name="so_bhxh" value="<?php echo htmlentities($row_RCBaohiem_CN['so_bhxh'], ENT_COMPAT, 'utf-8'); ?>" size="27" />
                    </td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Ngày Cấp BHXH:</td>
                    <td>
                        <input type="text" name="ngay_cap_bhxh" id="ngay_cap_bhxh" value="<?php echo htmlentities(date("d/m/Y", strtotime($row_RCBaohiem_CN['ngay_cap_bhxh'])), ENT_COMPAT, 'utf-8'); ?>" size="27" />
                        (dd/mm/yyyy)
                    </td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Nơi Cấp BHXH:</td>
                    <td>
                        <input type="text" name="noi_cap_bhxh" value="<?php echo htmlentities($row_RCBaohiem_CN['noi_cap_bhxh'], ENT_COMPAT, 'utf-8'); ?>" size="54" />
                    </td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Số BHYT:</td>
                    <td>
                        <input type="text" name="so_bhyt" value="<?php echo htmlentities($row_RCBaohiem_CN['so_bhyt'], ENT_COMPAT, 'utf-8'); ?>" size="27" />
                    </td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Ngày Cấp BHYT:</td>
                    <td>
                        <input type="text" name="ngay_cap_bhyt" id="ngay_cap_bhyt" value="<?php echo htmlentities(date("d/m/Y", strtotime($row_RCBaohiem_CN['ngay_cap_bhyt'])), ENT_COMPAT, 'utf-8'); ?>" size="27" />
                        (dd/mm/yyyy)
                    </td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Nơi Cấp BHYT:</td>
                    <td>
                        <input type="text" name="noi_cap_bhyt" value="<?php echo htmlentities($row_RCBaohiem_CN['noi_cap_bhyt'], ENT_COMPAT, 'utf-8'); ?>" size="54" />
                    </td>
                </tr>
                <tr valign="baseline">
                    <td colspan="2">
                        <a href="#" onclick="ConfirmEdit()" class="bt_green"><span class="bt_green_lft"></span><strong>Cập nhật</strong><span class="bt_green_r"></span></a>
                        <a href="#" onclick="go_back()" class="bt_blue"><span class="bt_blue_lft"></span><strong>Quay lại</strong><span class="bt_blue_r"></span></a>
                        <script type="text/javascript">
                            function go_back()
                                {
                                    location.href='index.php?require=them_moi_bao_hiem.php&catID=<?php echo $ma_nv; ?>&title=Bảo Hiểm&action=new';
                                }
                            function ConfirmEdit()
                            {
                                if (confirm("Bạn có chắc chắn thao tác cập nhật!"))
                                {
                                    update_insurance_form.submit();
                                    return false;
                                }  
                            }
                        </script>
                    </td>
                </tr>
            </table>
            <input type="hidden" name="MM_update" value="update_insurance_form" />
            <input type="hidden" name="id" value="<?php echo $row_RCBaohiem_CN['id']; ?>" />
        </form>
    </div>
</body>
</html>

