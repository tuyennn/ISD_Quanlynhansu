<?php
$ma_nv = $_GET['catID'];
$action = get_param('action');
//Thực hiện lệnh xoá nếu chọn xoá
if ($action=="del")
{
	$tomID = $_GET['tomID'];
	$deleteSQL = "DELETE FROM tlb_quanhegiadinh WHERE id=$tomID";                     
	
    $mydb->setQuery($deleteSQL);
    $result_d = $mydb->executeQuery();

    if($result_d) {
        $message = "Thao tác xóa thành công!";
        echo "<script type='text/javascript'>alert('$message');</script>";
        $url = "index.php?require=them_moi_quan_he_gia_dinh.php&catID=$ma_nv&title=Cập nhật quan hệ gia đình";
        location($url);
    }
    else {
        $message = "Thao tác xóa thất bại!";
        echo "<script type='text/javascript'>alert('$message');</script>";
        $url = "index.php?require=them_moi_quan_he_gia_dinh.php&catID=$ma_nv&title=Cập nhật quan hệ gia đình";
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

$editFormAction = htmlspecialchars($_SERVER["PHP_SELF"]);
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "new_relationship_form")) {
    $insertSQL = sprintf("INSERT INTO tlb_quanhegiadinh (ma_nhan_vien, ten_nguoi_than, nam_sinh, moi_quan_he, nghe_nghiep, dia_chi, dtll, ghi_chu) VALUES ('{$ma_nv}', %s, %s, %s, %s, %s, %s, %s)",
        GetSQLValueString($_POST['ten_nguoi_than'], "text"),
        GetSQLValueString($_POST['nam_sinh'], "int"),
        GetSQLValueString($_POST['moi_quan_he'], "text"),
        GetSQLValueString($_POST['nghe_nghiep'], "text"),
        GetSQLValueString($_POST['dia_chi'], "text"),
        GetSQLValueString($_POST['dtll'], "text"),
        GetSQLValueString($_POST['ghi_chu'], "text"));

    $mydb->setQuery($insertSQL);
    $result_c = $mydb->executeQuery();
    if($result_c) {
        $message = "Thao tác thêm mới thành công!";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
    else {
        $message = "Thao tác thêm mới thất bại!";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }

    $insertGoTo = "them_moi_quan_he_gia_dinh.php";
    if (isset($_SERVER['QUERY_STRING'])) {
        $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
        $insertGoTo .= $_SERVER['QUERY_STRING'];
    }
    sprintf("location: %s", $insertGoTo);
}
$mydb->setQuery("SELECT * FROM tlb_quanhegiadinh where ma_nhan_vien = '$ma_nv'");
    $RCQuanHeGD = $mydb->executeQuery();
    $row_RCQuanHeGD = $mydb->fetch_assoc($RCQuanHeGD);
    $totalRows_RCQuanHeGD = $mydb->num_rows($RCQuanHeGD);

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
        if ($totalRows_RCQuanHeGD<>0)
        {
        ?>
            <table id="rounded-corner" border="0" width="750">
            <thead>
                <tr>
                    <th width="240" class="rounded-content">Tên người thân</th>
                    <th width="120">Quan hệ</th>
                    <th width="120">Năm sinh</th>
                    <th width="120">Điện thoại</th>
                    <th width="100" colspan="2" align="center" class="rounded-q4">Thao tác</th>
                </tr>
            </thead>
            <?php do { ?>
                <tr>
                    <td><?php echo $row_RCQuanHeGD['ten_nguoi_than']; ?></td>
                    <td><?php echo $row_RCQuanHeGD['moi_quan_he']; ?></td>
                    <td><?php echo $row_RCQuanHeGD['nam_sinh']; ?></td>
                    <td><?php echo $row_RCQuanHeGD['dtll']; ?></td>
                    <?php $ma_id = $row_RCQuanHeGD['id']; ?>
                    <td align="center">
                        <a href="index.php?require=cap_nhat_quan_he_gia_dinh.php&catID=<?php echo $ma_nv; ?>&tomID=<?php echo $row_RCQuanHeGD['id']; ?>&title=Cập nhật quan hệ gia đình">
                            <?php
                                echo '<img src="images/user_edit.png" alt="Sửa" title="" border="0" />';
                            ?>
                        </a>
                    </td>
                    <td align="center">
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
                <?php } while ($row_RCQuanHeGD = $mydb->fetch_assoc($RCQuanHeGD)); ?>
            </table>
        <?php
            }
            else {
            ?>
                <table id="rounded-corner" border="0" width="460" align="center" cellpadding="1" cellspacing="1">
                <span><h4>Chưa có mối quan hệ gia định, mời thêm mới...</h4></span>
                </table>
        <?php
            }
        ?>
    </div>

    <!--MAIN BOTTOM CONTENT -->

    <div class="detail_bottom">
        <form action="<?php echo $editFormAction; ?>" method="post" name="new_relationship_form" id="new_relationship_form">
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
                    <td><input type="text" name="ten_nguoi_than" value="" size="54" data-validation="required"/></td>
                </tr>
                <tr valign="baseline">
                <td nowrap="nowrap" align="right">Năm sinh:</td>
                    <td><input type="text" name="nam_sinh" value="" size="54" data-validation="date" data-validation-format="yyyy" data-validation-error-msg="Không đúng định dạng năm"/></td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Mối quan hệ:</td>
                    <td><input type="text" name="moi_quan_he" value="" size="54" data-validation="required"/></td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Nghề nghiệp:</td>
                    <td><input type="text" name="nghe_nghiep" value="" size="54" data-validation="required"/></td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Địa chỉ:</td>
                    <td><input type="text" name="dia_chi" value="" size="54" data-validation="required"/></td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">ĐT liên lạc:</td>
                    <td><input type="text" name="dtll" value="" size="54" data-validation="required"/></td>
                </tr>
                <tr valign="middle">
                    <td nowrap="nowrap" align="right">Ghi chú:</td>
                    <td><textarea name="ghi_chu" value="" rows="5" cols="60"></textarea></td>                 
                </tr>
                <tr>
                    <td colspan="2" align="right">
                    <button class="btn btn-default" onclick="new_relationship_form.reset();">Làm lại</button>
                    <input type="submit" onClick="ConfirmCreate()" class="btn btn-default" name="submit" id="addrelationship" value="Thêm mới nhân viên" />
                    <script>
                        function ConfirmCreate(){
                            if (confirm("Bạn có chắc chắn thao tác thêm mới!"))
                            {
                                new_relationship_form.submit();
                                return true;
                            }  
                        }
                        
                    </script> 
                </td>
                </tr>
            </table>
            <input type="hidden" name="MM_insert" value="new_relationship_form" />
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
    </div>
</body>
</html>

