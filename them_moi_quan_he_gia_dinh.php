<?php
$ma_nv = get_param('catID');
$action = get_param('action');
//Thực hiện lệnh xoá nếu chọn xoá
if ($action=="del")
{
	$tomID = $_GET['tomID'];
	$deleteSQL = "DELETE FROM tlb_quanhegiadinh WHERE id=$tomID";                     
	
 mysql_select_db($database_Myconnection, $Myconnection);
 $Result1 = mysql_query($deleteSQL, $Myconnection) or die(mysql_error());

 $deleteGoTo = "them_danh_muc.php";
 if (isset($_SERVER['QUERY_STRING'])) {
  $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
  $deleteGoTo .= $_SERVER['QUERY_STRING'];
}
sprintf("Location: %s", $deleteGoTo);
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO tlb_quanhegiadinh (ma_nhan_vien, ten_nguoi_than, nam_sinh, moi_quan_he, nghe_nghiep, dia_chi, dtll, ghi_chu) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
     GetSQLValueString($_POST['ma_nhan_vien'], "text"),
     GetSQLValueString($_POST['ten_nguoi_than'], "text"),
     GetSQLValueString($_POST['nam_sinh'], "int"),
     GetSQLValueString($_POST['moi_quan_he'], "text"),
     GetSQLValueString($_POST['nghe_nghiep'], "text"),
     GetSQLValueString($_POST['dia_chi'], "text"),
     GetSQLValueString($_POST['dtll'], "text"),
     GetSQLValueString($_POST['ghi_chu'], "text"));

  mysql_select_db($database_Myconnection, $Myconnection);
  $Result1 = mysql_query($insertSQL, $Myconnection) or die(mysql_error());

  $insertGoTo = "cap_nhat_quan_he_gia_dinh.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
}
sprintf("Location: %s", $insertGoTo);
}

mysql_select_db($database_Myconnection, $Myconnection);
$query_RCQuanHeGD = "SELECT * FROM tlb_quanhegiadinh where ma_nhan_vien = '$ma_nv'";
$RCQuanHeGD = mysql_query($query_RCQuanHeGD, $Myconnection) or die(mysql_error());
$row_RCQuanHeGD = mysql_fetch_assoc($RCQuanHeGD);
$totalRows_RCQuanHeGD = mysql_num_rows($RCQuanHeGD);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
</head>

<body text="#000000" link="#CC0000" vlink="#0000CC" alink="#000099">

    <!--MAIN TAB LINKS -->
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


    <!--MAIN LEFT COLUMN -->
    <div class="detail_left"> 
  
        <?php
        if ($totalRows_RCQuanHeGD<>0)
        {
        ?>
            <table id="rounded-corner" border="0" width="460" align="center" cellpadding="1" cellspacing="1">
                <tr>
                    <th width="180" class="rounded-company">Tên người thân</th>
                    <th width="80">Quan hệ</th>
                    <th width="80">Điện thoại</th>
                    <th width="120" colspan="2" align="center" class="rounded-q4">Thao tác</th>
                </tr>
                <?php do { ?>
                    <tr>
                        <td class="row1"><?php echo $row_RCQuanHeGD['ten_nguoi_than']; ?></td>
                        <td class="row1"><?php echo $row_RCQuanHeGD['moi_quan_he']; ?></td>
                        <td class="row1"><?php echo $row_RCQuanHeGD['dtll']; ?></td>
                        <?php $ma_id = $row_RCQuanHeGD['id']; ?>
                        <td class="row1" align="center">
                            <a href="index.php?require=cap_nhat_quan_he_gia_dinh.php&catID=<?php echo $ma_nv; ?>&tomID=<?php echo $row_RCQuanHeGD['id']; ?>&title=Cập nhật quan hệ gia đình">
                                <?php
                                    echo '<img src="images/user_edit.png" alt="Sửa" title="" border="0" />';
                                ?>
                            </a>
                        </td>
                        <td class="row1" align="center">
                            <a href="#" onclick="ConfirmDelete()" value="Xóa quan hệ gia đình">
                                <?php
                                    echo '<img src="images/trash.png" alt="Xóa" title="" border="0" />';
                                ?>
                            </a>
                            <script type="text/javascript">
                                function ConfirmDelete()
                                {
                                    if (confirm("Bạn có chắc chắn thao tác xóa!"))
                                        location.href='index.php?require=them_moi_quan_he_gia_dinh.php&catID=<?php echo $ma_nv; ?>&tomID=<?php echo $row_RCQuanHeGD['id']; ?>&title=Cập nhật quan hệ gia đình&action=del';
                                }
                            </script>
                        </td>
                    </tr>
                <?php } while ($row_RCQuanHeGD = mysql_fetch_assoc($RCQuanHeGD)); ?>
            </table>
        <?php
            }
        ?>
    </div>

    <!--MAIN RIGHT COLUMN -->
    <div class="detail_right">
        <form action="<?php echo $editFormAction; ?>" method="post" name="new_relationship_form" id="new_relationship_form">
            <table width="290" align="center">
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Mã nhân viên:</td>
                    <td><input type="text" name="ma_nhan_vien" value="<?php echo $ma_nv; ?>" readonly="readonly" size="29" /></td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Tên người thân:</td>
                    <td><input type="text" name="ten_nguoi_than" value="" size="29" /></td>
                </tr>
                <tr valign="baseline">
                <td nowrap="nowrap" align="right">Năm sinh:</td>
                    <td><input type="text" name="nam_sinh" value="" size="29" /></td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Mối quan hệ:</td>
                    <td><input type="text" name="moi_quan_he" value="" size="29" /></td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Nghề nghiệp:</td>
                    <td><input type="text" name="nghe_nghiep" value="" size="29" /></td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Địa chỉ:</td>
                    <td><input type="text" name="dia_chi" value="" size="29" /></td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">ĐT liên lạc:</td>
                    <td><input type="text" name="dtll" value="" size="29" /></td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Ghi chú:</td>
                    <td><input type="text" name="ghi_chu" value="" size="29" /></td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">&nbsp;</td>
                    <td>
                        <a href="#" onclick="new_relationship_form.submit();return true;" class="bt_green"><span class="bt_green_lft"></span><strong>Thêm mới quan hệ</strong><span class="bt_green_r"></span></a>
                    </td>
                </tr>
            </table>
            <input type="hidden" name="MM_insert" value="form1" />
        </form>
    </div>
</body>
</html>
<?php
    mysql_free_result($RCQuanHeGD);
?>
