<?php
$ma_nv = $_GET['catID'];
$action = get_param('action');
//Thực hiện lệnh xoá nếu chọn xoá
if ($action=="del")
{
    $tomID = $_GET['tomID'];
    $deleteSQL = "DELETE FROM tlb_quatrinhluong WHERE id=$tomID";                     
    
    mysql_select_db($database_Myconnection, $Myconnection);
    $result_d = mysql_query($deleteSQL, $Myconnection) or die(mysql_error());

    if($result_d) {
        $message = "Thao tác xóa thành công!";
        echo "<script type='text/javascript'>alert('$message');</script>";
        $url = "index.php?require=them_moi_qua_trinh_luong.php&catID=$ma_nv&title=Cập nhật quá trình lương";
        location($url);
    }
    else {
        $message = "Thao tác xóa thất bại!";
        echo "<script type='text/javascript'>alert('$message');</script>";
        $url = "index.php?require=them_moi_qua_trinh_luong.php&catID=$ma_nv&title=Cập nhật quá trình lương";
        location($url);
    }
}


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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "new_salary_form")) {
    $insertSQL = sprintf("INSERT INTO tlb_quatrinhluong (ma_nhan_vien, so_quyet_dinh, ngay_chuyen, muc_luong, ghi_chu) VALUES ('{$ma_nv}', %s, %s, %s, %s)",
    GetSQLValueString($_POST['so_quyet_dinh'], "text"),
    GetSQLValueString($_POST['ngay_chuyen'], "date"),
    GetSQLValueString($_POST['muc_luong'], "text"),
    GetSQLValueString($_POST['ghi_chu'], "text"));

    mysql_select_db($database_Myconnection, $Myconnection);
    $result_c = mysql_query($insertSQL, $Myconnection) or die(mysql_error());
    if($result_c) {
        $message = "Thêm quá trình thành công!";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
    else {
        $message = "Thêm quá trình thất bại!";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }

    $insertGoTo = "them_moi_qua_trinh_luong.php";
    if (isset($_SERVER['QUERY_STRING'])) {
        $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
        $insertGoTo .= $_SERVER['QUERY_STRING'];
    }
sprintf("location: %s", $insertGoTo);
}

    mysql_select_db($database_Myconnection, $Myconnection);
    $query_RCQTluong_TM = "SELECT * FROM tlb_quatrinhluong where ma_nhan_vien = '$ma_nv'";
    $RCQTluong_TM = mysql_query($query_RCQTluong_TM, $Myconnection) or die(mysql_error());
    $row_RCQTluong_TM = mysql_fetch_assoc($RCQTluong_TM);
    $totalRows_RCQTluong_TM = mysql_num_rows($RCQTluong_TM);
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
        $('#ngay_chuyen').datepick({showOnFocus: false, showTrigger: '#calImg'});
         
        var formats = ['mm/dd/yyyy', 'M d, yyyy', 'MM d, yyyy', 
            'DD, MM d, yyyy', 'mm/dd/yy', 'dd/mm/yyyy', 
            'mm/dd/yyyy (\'w\'w)', '\'Day\' d \'of\' MM, yyyy', 
            $.datepick.ATOM, $.datepick.COOKIE, $.datepick.ISO_8601, 
            $.datepick.RFC_822, $.datepick.RFC_850, $.datepick.RFC_1036, 
            $.datepick.RFC_1123, $.datepick.RFC_2822, $.datepick.RSS, 
            $.datepick.TICKS, $.datepick.TIMESTAMP, $.datepick.W3C]; 
         
    $('#dateFormat').change(function() { 
        $('#ngay_chuyen').val('').datepick('option', 
            {dateFormat: formats[$(this).val()]}); 
    });
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
    <?php
        if ($totalRows_RCQTluong_TM<>0)
        {
    ?>
        <table id="rounded-corner" align="center" cellpadding="1" cellspacing="1">
            <tr>
                <th width="185">Số quyết định</th>
                <th width="140">Ngày chuyển mức</th>
                <th width="150">Mức lương</th>
                <th width="200">Tổng lương</th>
                <th colspan="2" align="center">Thao tác</th>
            </tr>
            <?php do { ?>
            <tr>
                <td><?php echo $row_RCQTluong_TM['so_quyet_dinh']; ?></td>
                <td><?php echo $row_RCQTluong_TM['ngay_chuyen']; ?></td>
                <td><?php echo $row_RCQTluong_TM['muc_luong']; ?></td>
                <td></td>
                <td width="35">
                    <a href="index.php?require=cap_nhat_qua_trinh_luong.php&catID=<?php echo $ma_nv; ?>&tomID=<?php echo $row_RCQTluong_TM['id']; ?>&title=Cập nhật quá trình lương">
                    <?php
                        echo '<img src="images/user_edit.png" alt="Sửa" title="" border="0" />';
                    ?>
                    </a>
                </td>
                <td align="center">
                    <a href="#" onclick="ConfirmDelete()" value="Xóa quá trình lương">
                        <?php
                            echo '<img src="images/trash.png" alt="Xóa" title="" border="0" />';
                        ?>
                    </a>
                    <script type="text/javascript">
                        function ConfirmDelete()
                        {
                            if (confirm("Bạn có chắc chắn thao tác xóa!"))
                                location.href='index.php?require=them_moi_qua_trinh_luong.php&catID=<?php echo $ma_nv; ?>&tomID=<?php echo $row_RCQTluong_TM['id']; ?>&title=Cập nhật quá trình lương&action=del';
                        }
                    </script>
                </td>
            </tr>
                <?php } while ($row_RCQTluong_TM = mysql_fetch_assoc($RCQTluong_TM)); ?>
        </table>
    <?php }
        else { ?>

        <table id="rounded-corner" border="0" width="460" align="center" cellpadding="1" cellspacing="1">
            <span><h4>Chưa có quá trình lương, mời thêm mới</h4></span>
        </table>

        <?php } ?>
    </div>

    <!--MAIN BOTTOM CONTENT -->
    <div class="detail_bottom">
        <form action="<?php echo $editFormAction; ?>" method="post" name="new_salary_form" id="new_salary_form">
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
                    <td nowrap="nowrap" align="right">Số quyết định lương:</td>
                    <td>
                        <input type="text" name="so_quyet_dinh" value="" size="54" />
                    </td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Ngày chuyển mức:</td>
                    <td>
                        <input type="text" name="ngay_chuyen" id="ngay_chuyen" value="" size="27" />
                        (dd/mm/yyyy)
                    </td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Mức lương:</td>
                    <td>
                        <input type="text" name="muc_luong" value="" size="54" />
                    </td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Ghi chú:</td>
                    <td><textarea name="ghi_chu" value="" rows="5" cols="60"></textarea></td>                 
                </tr>
                <tr>
                    <td colspan="3">
                        <a href="#" onclick="ConfirmCreate()" class="bt_green"><span class="bt_green_lft"></span><strong>Thêm mới quá trình</strong><span class="bt_green_r"></span></a>
                        <script type="text/javascript">
                        function ConfirmCreate()
                        {
                            if (confirm("Bạn có chắc chắn thao tác thêm mới!"))
                            {
                                new_salary_form.submit();
                                return false;
                            }  
                        }
                        </script>
                    </td>
                </tr>
            </table>
            <input type="hidden" name="MM_insert" value="new_salary_form" />
        </form>
    </div>
</body>
</html>
<?php
    mysql_free_result($RCQTluong_TM);
?>
