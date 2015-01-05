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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "update_relation_form")) {
  $updateSQL = sprintf("UPDATE tlb_quanhegiadinh SET ten_nguoi_than=%s, nam_sinh=%s, moi_quan_he=%s, nghe_nghiep=%s, dia_chi=%s, dtll=%s, ghi_chu=%s WHERE id='{$id}' AND ma_nhan_vien='{$ma_nv}'",
    GetSQLValueString($_POST['ten_nguoi_than'], "text"),
    GetSQLValueString($_POST['nam_sinh'], "int"),
    GetSQLValueString($_POST['moi_quan_he'], "text"),
    GetSQLValueString($_POST['nghe_nghiep'], "text"),
    GetSQLValueString($_POST['dia_chi'], "text"),
    GetSQLValueString($_POST['dtll'], "text"),
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

    $updateGoTo = "them_moi_quan_he_gia_dinh.php";
    if (isset($_SERVER['QUERY_STRING'])) {
        $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
        $updateGoTo .= $_SERVER['QUERY_STRING'];
    }
    sprintf("location: %s", $updateGoTo);
}
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
</head>

<body text="#000000" link="#CC0000" vlink="#0000CC" alink="#000099">
    <!--MAIN TAB LINKS -->
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
            $mydb->setQuery("SELECT * FROM tlb_quanhegiadinh WHERE ma_nhan_vien = '$ma_nv'");
            $RCQuanhe_DS = $mydb->executeQuery();
            $row_RCQuanhe_DS = $mydb->fetch_assoc($RCQuanhe_DS);
            $totalRows_RCQuanhe_DS = $mydb->num_rows($RCQuanhe_DS);
        ?>

        <table id="rounded-corner" border="0" width="750">
        <thead>
            <tr>
                <th width="300" class="rounded-content">Tên người thân</th>
                <th width="180">Quan hệ</th>
                <th width="120">Năm sinh</th>
                <th width="180" class="rounded-q4">Điện thoại</th>
            </tr>
        </thead>
            <?php 
                do { 
            ?>
            <tr>
                <td><?php echo $row_RCQuanhe_DS['ten_nguoi_than']; ?></td>
                <td><?php echo $row_RCQuanhe_DS['moi_quan_he']; ?></td>
                <td><?php echo $row_RCQuanhe_DS['nam_sinh']; ?></td>
                <td><?php echo $row_RCQuanhe_DS['dtll']; ?></td>
            </tr>
            <?php 
                } while ($row_RCQuanhe_DS = $mydb->fetch_assoc($RCQuanhe_DS)); 
            ?>
        </table>
    </div>

    <!--MAIN BOTTOM CONTENT -->

    <div class="detail_bottom">
        <?php
            $mydb->setQuery("SELECT * FROM tlb_quanhegiadinh WHERE id= $id");
            $RCQuanhe_CN = $mydb->executeQuery();
            $row_RCQuanhe_CN = $mydb->fetch_assoc($RCQuanhe_CN);
            $totalRows_RCQuanhe_CN = $mydb->num_rows($RCQuanhe_CN);
        ?>

        <form action="<?php echo $editFormAction; ?>" method="post" name="update_relation_form" id="update_relation_form">
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
                    <td nowrap="nowrap" align="right">Tên người thân:</td>
                    <td><input type="text" name="ten_nguoi_than" value="<?php echo htmlentities($row_RCQuanhe_CN['ten_nguoi_than'], ENT_COMPAT, 'utf-8'); ?>" size="54" /></td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Năm sinh:</td>
                    <td><input type="text" name="nam_sinh" value="<?php echo htmlentities($row_RCQuanhe_CN['nam_sinh'], ENT_COMPAT, 'utf-8'); ?>" size="54" /></td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Mối quan hệ:</td>
                    <td><input type="text" name="moi_quan_he" value="<?php echo htmlentities($row_RCQuanhe_CN['moi_quan_he'], ENT_COMPAT, 'utf-8'); ?>" size="54" /></td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Nghề nghiệp:</td>
                    <td><input type="text" name="nghe_nghiep" value="<?php echo htmlentities($row_RCQuanhe_CN['nghe_nghiep'], ENT_COMPAT, 'utf-8'); ?>" size="54" /></td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Địa chỉ:</td>
                    <td><input type="text" name="dia_chi" value="<?php echo htmlentities($row_RCQuanhe_CN['dia_chi'], ENT_COMPAT, 'utf-8'); ?>" size="54" /></td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">ĐT Liên Hệ:</td>
                    <td><input type="text" name="dtll" value="<?php echo htmlentities($row_RCQuanhe_CN['dtll'], ENT_COMPAT, 'utf-8'); ?>" size="54" /></td>
                </tr>
                <tr valign="middle">
                    <td nowrap="nowrap" align="right">Ghi chú:</td>
                    <td><textarea name="ghi_chu" rows="5" cols="60" /><?php echo htmlentities($row_RCQuanhe_CN['ghi_chu'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
                </tr>
                <tr valign="baseline">
                    <td colspan="2">
                        <a href="#" onclick="ConfirmEdit()" class="bt_green"><span class="bt_green_lft"></span><strong>Cập nhật</strong><span class="bt_green_r"></span></a>
                        <a href="#" onclick="go_back()" class="bt_blue"><span class="bt_blue_lft"></span><strong>Quay lại</strong><span class="bt_blue_r"></span></a>
                        <script type="text/javascript">
                            function go_back()
                            {
                                location.href='index.php?require=them_moi_quan_he_gia_dinh.php&catID=<?php echo $ma_nv; ?>&title=Cập nhật quan hệ gia đình&action=new';
                            }
                            function ConfirmEdit()
                            {
                                if (confirm("Bạn có chắc chắn thao tác cập nhật!"))
                                {
                                    update_relation_form.submit();
                                    return false;
                                }  
                            }
                        </script>
                    </td>
                </tr>
            </table>
            <input type="hidden" name="MM_update" value="update_relation_form" />
            <input type="hidden" name="id" value="<?php echo $row_RCQuanhe_CN['id']; ?>" />
        </form>
    </div>
</body>
</html>