<?php require_once('includes/initialize.php'); ?>
<?php //require_once('header.php'); ?>
<?php
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

mysql_select_db($database_Myconnection, $Myconnection);
$query_RCdanh_sach = "SELECT * FROM tlb_nhanvien where nghi_viec = 1";
$RCdanh_sach = mysql_query($query_RCdanh_sach, $Myconnection) or die(mysql_error());
$row_RCdanh_sach = mysql_fetch_assoc($RCdanh_sach);
$totalRows_RCdanh_sach = mysql_num_rows($RCdanh_sach);
?>
<table id="rounded-corner" summary="Bảng Thống Kê Nhân Viên Đã Nghỉ Việc" >
    <thead>
        <tr>
            <th width="50" rowspan="2" align="center" class="rounded-company">TRẠNG THÁI</th>
            <th width="30" rowspan="2" align="center">MÃ</th>
            <th width="260" rowspan="2" align="center">HỌ VÀ TÊN</th>
            <th width="90" rowspan="2" align="center">ĐT DI ĐỘNG</th>
            <th width="90" rowspan="2" align="center">ĐT NHÀ</th>
            <th width="150" rowspan="2" align="center">EMAIL</th>
            <th colspan="2" align="center">THÔNG TIN</th>
            <th width="30" rowspan="2" align="center" class="rounded-q4">XÓA</th>
        </tr>

        <tr>
            <td align="center" bgcolor="#CC0000">Nhân viên</td>
            <td align="center" bgcolor="#CC0000">Công việc</td>
        </tr>

    </thead>
    <?php do { ?>
        <tr class="row">
            <td class="row1" width="50" align="center">
                <a href="chi_tiet_nhan_vien.php?catID=<?php echo $row_RCdanh_sach['ma_nhan_vien']; ?>">
                    <img src="images/Offline.png" alt="Đã nghỉ việc" title="" border="0" />
                </a>
            </td>
            <td class="row1" width="30" align="left"><a href="chi_tiet_nhan_vien.php?catID=<?php echo $row_RCdanh_sach['ma_nhan_vien']; ?>"><?php echo $row_RCdanh_sach['ma_nhan_vien']; ?></a></td>
            <td class="row1" align="left"><?php echo $row_RCdanh_sach['ho_ten']; ?></td>
            <td class="row1" align="left"><?php echo $row_RCdanh_sach['dt_di_dong']; ?></td>
            <td class="row1" align="left"><?php echo $row_RCdanh_sach['dt_nha']; ?></td>
            <td class="row1" align="left"><?php echo $row_RCdanh_sach['email']; ?></td>
            <td class="row1" width="100" align="center" ><a href="index.php?require=cap_nhat_thong_tin_nhan_vien.php&catID=<?php echo $row_RCdanh_sach['ma_nhan_vien']; ?>&title=Thông tin nhân viên"><img src="images/user_edit.png" alt="Xóa" title="" border="0" /></a></td>
            <td class="row1" width="100" align="center" ><a href="index.php?require=cap_nhat_thong_tin_cong_viec.php&catID=<?php echo $row_RCdanh_sach['ma_nhan_vien']; ?>&title=Thông tin công việc"><img src="images/user_edit.png" alt="Xóa" title="" border="0" /></a></td>
            <td class="row1" width="50" align="center">
                <a href="chi_tiet_nhan_vien.php?catID=<?php echo $row_RCdanh_sach['ma_nhan_vien']; ?>">
                    <img src="images/trash.png" alt="Xóa" title="" border="0" />
                </a>
            </td>
        </tr>
    <?php } while ($row_RCdanh_sach = mysql_fetch_assoc($RCdanh_sach)); ?>
    <tfoot>
            <tr>
                <td colspan="8" class="rounded-foot-left"><em><b><u>Hướng Dẫn:</u></b> 
                                                            <br>&nbsp;+ Nhấn vào Mã Nhân Viên để xuất file thống kê 
                                                            <br>&nbsp;+ Nhấn vào Chi Tiết Nhân Viên để sửa thông tin về Nhân Viên
                                                            <br>&nbsp;+ Nhấn vào Chi Tiết Công Việc để sửa thông tin về Công Việc</em></td>
                <td class="rounded-foot-right">&nbsp;</td>

            </tr>
    </tfoot>
</table>
<?php
    mysql_free_result($RCdanh_sach);
?>
