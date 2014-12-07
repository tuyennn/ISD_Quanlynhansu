<?php require_once('includes/initialize.php'); ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "new_workingprocess_form")) {
    $insertSQL = sprintf("INSERT INTO tlb_quatrinhcongtac (ma_nhan_vien, so_quyet_dinh, ngay_ky, ngay_hieu_luc, cong_viec, ghi_chu) VALUES (%s, %s, %s, %s, %s, %s)",
    GetSQLValueString($_POST['ma_nhan_vien'], "text"),
    GetSQLValueString($_POST['so_quyet_dinh'], "text"),
    GetSQLValueString($_POST['ngay_ky'], "date"),
    GetSQLValueString($_POST['ngay_hieu_luc'], "date"),
    GetSQLValueString($_POST['cong_viec'], "text"),
    GetSQLValueString($_POST['ghi_chu'], "text"));

    mysql_select_db($database_Myconnection, $Myconnection);
    $Result1 = mysql_query($insertSQL, $Myconnection) or die(mysql_error());

    $insertGoTo = "them_moi_qua_trinh_cong_tac.php";
    if (isset($_SERVER['QUERY_STRING'])) {
        $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
        $insertGoTo .= $_SERVER['QUERY_STRING'];
    }
    sprintf("location: %s", $insertGoTo);
    }

    mysql_select_db($database_Myconnection, $Myconnection);
    $query_RCQuatrinh_TM = "SELECT * FROM tlb_quatrinhcongtac where ma_nhan_vien = '$ma_nv'";
    $RCQuatrinh_TM = mysql_query($query_RCQuatrinh_TM, $Myconnection) or die(mysql_error());
    $row_RCQuatrinh_TM = mysql_fetch_assoc($RCQuatrinh_TM);
    $totalRows_RCQuatrinh_TM = mysql_num_rows($RCQuatrinh_TM);
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
        $('#ngay_ky').datepick({showOnFocus: false, showTrigger: '#calImg'});
        $('#ngay_hieu_luc').datepick({showOnFocus: false, showTrigger: '#calImg'});
         
        var formats = ['mm/dd/yyyy', 'M d, yyyy', 'MM d, yyyy', 
            'DD, MM d, yyyy', 'mm/dd/yy', 'dd/mm/yyyy', 
            'mm/dd/yyyy (\'w\'w)', '\'Day\' d \'of\' MM, yyyy', 
            $.datepick.ATOM, $.datepick.COOKIE, $.datepick.ISO_8601, 
            $.datepick.RFC_822, $.datepick.RFC_850, $.datepick.RFC_1036, 
            $.datepick.RFC_1123, $.datepick.RFC_2822, $.datepick.RSS, 
            $.datepick.TICKS, $.datepick.TIMESTAMP, $.datepick.W3C]; 
         
    $('#dateFormat').change(function() { 
        $('#ngay_ky').val('').datepick('option', 
            {dateFormat: formats[$(this).val()]}); 
    });
    });
    </script>
</head>
<body text="#000000" link="#CC0000" vlink="#0000CC" alink="#000099">
    <table id="rounded-corner" width="750" cellpadding="2" cellspacing="2" bgcolor="#66CCFF">
        <thead>
            <tr>
                <th width="200" class="rounded-company" rowspan="2" align="center"><a href="index.php?require=them_moi_quan_he_gia_dinh.php&catID=<?php echo $ma_nv; ?>&title=Quan hệ gia đình&action=new">Quan hệ gia đình</a></td>
                <th width="200" rowspan="2" align="center"><a href="index.php?require=them_moi_qua_trinh_cong_tac.php&catID=<?php echo $ma_nv; ?>&title=Quá trình công tác&action=new">Quá trình công tác</a></td>
                <th width="150" rowspan="2" align="center"><a href="index.php?require=them_moi_qua_trinh_luong.php&catID=<?php echo $ma_nv; ?>&title=Quá trình lương&action=new">Quá trình lương</a></td>
                <th width="120" rowspan="2" align="center"><a href="index.php?require=them_moi_hop_dong.php&catID=<?php echo $ma_nv; ?>&title=Hợp đồng&action=new">Hợp đồng</a></td>
                <th width="112" class="rounded-q4" rowspan="2" align="center"><a href="index.php?require=them_moi_bao_hiem.php&catID=<?php echo $ma_nv; ?>&title=Bảo hiểm&action=new">Bảo hiểm</a></td>
            </tr>
        </thead>
    </table>

<?php 
if ($totalRows_RCQuatrinh_TM<>0)
    {
?>
    <table id="rounded-corner" width="750" align="center" cellpadding="2" cellspacing="2" bgcolor="#66CCFF">
        <tr>
            <th width="120">Số QĐ</th>
            <th width="80">Ngày ký</th>
            <th width="100">Ngày hiệu lực</th>
            <th width="150">Công việc</th>
            <th width="200">Ghi chú</th>
            <th colspan="3">&nbsp;</th>
        </tr>
        <?php 
            do { ?>
                <tr>
                    <td class="row1"><?php echo $row_RCQuatrinh_TM['so_quyet_dinh']; ?></td>
                    <td class="row1"><?php echo $row_RCQuatrinh_TM['ngay_ky']; ?></td>
                    <td class="row1"><?php echo $row_RCQuatrinh_TM['ngay_hieu_luc']; ?></td>
                    <td class="row1"><?php echo $row_RCQuatrinh_TM['cong_viec']; ?></td>
                    <td class="row1"><?php echo $row_RCQuatrinh_TM['ghi_chu']; ?></td>
                    <td width="50" class="row1"><a href="index.php?require=them_moi_qua_trinh_cong_tac.php&catID=<?php echo $ma_nv; ?>&title=Quá trình công tác">Thêm</a></td>
                    <td width="50" class="row1"><a href="index.php?require=cap_nhat_qua_trinh_cong_tac.php&catID=<?php echo $ma_nv; ?>&tomID=<?php echo $row_RCQuatrinh_TM['id']; ?>&title=Cập nhật quá trình công tác">Sửa</a></td>
                    <td width="50" class="row1">Xoá</td>
                </tr>
        <?php } 
            while ($row_RCQuatrinh_TM = mysql_fetch_assoc($RCQuatrinh_TM)); 
        ?>
    </table>
<?php
    }
?>

    <form action="<?php echo $editFormAction; ?>" method="post" name="new_workingprocess_form" id="new_workingprocess_form">
        <table id="rounded-corner" width="750" align="center" cellpadding="2" cellspacing="2" bgcolor="#66CCFF">
            <tr valign="baseline">
                <td width="137" align="right" nowrap="nowrap">Mã nhân viên:</td>
                <td width="229"><?php echo $ma_nv; ?></td>
                <td>Ngày ký:</td>
                <td>
                    <input type="text" name="ngay_ky" id="ngay_ky" value="" size="25" />
                    (dd/mm/yyyy)
                </td>
            </tr>
            <tr valign="baseline">
                <td nowrap="nowrap" align="right">Số quyết định:</td>
                <td>
                    <input type="text" name="so_quyet_dinh" value="" size="32" />
                </td>
                <td>Ngày hiệu lực:</td>
                <td>
                    <input type="text" name="ngay_hieu_luc" id="ngay_hieu_luc" value="" size="25" />
                    (dd/mm/yyyy)
                </td>
            </tr>
            <tr valign="baseline">
                <td nowrap="nowrap" align="right">Công việc:</td>
                <td colspan="3"><input type="text" name="cong_viec" value="" size="80" /></td>
            </tr>
            <tr valign="baseline">
                <td nowrap="nowrap" align="right">Ghi chú:</td>
                <td colspan="3"><input type="text" name="ghi_chu" value="" size="80" /></td>
            </tr>
        </table>
        <input type="hidden" name="MM_insert" value="new_workingprocess_form" />
    </form>
    <a href="#" onclick="new_workingprocess_form.submit();return true;" class="bt_green"><span class="bt_green_lft"></span><strong>Thêm mới quá trình công tác</strong><span class="bt_green_r"></span></a>
</body>
</html>
<?php
    mysql_free_result($RCQuatrinh_TM);
?>
