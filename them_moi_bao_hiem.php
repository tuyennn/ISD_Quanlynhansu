<?php
$ma_nv = $_GET['catID'];
$action = get_param('action');
//Thực hiện lệnh xoá nếu chọn xoá
if ($action=="del")
{
    $tomID = $_GET['tomID'];
    $deleteSQL = "DELETE FROM tlb_baohiem WHERE id=$tomID";                     
    
    $mydb->setQuery($deleteSQL);
    $result_d = $mydb->executeQuery();

    if($result_d) {
        $message = "Thao tác xóa thành công!";
        echo "<script type='text/javascript'>alert('$message');</script>";
        $url = "index.php?require=them_moi_bao_hiem.php&catID=$ma_nv&title=Bảo Hiểm";
        location($url);
    }
    else {
        $message = "Thao tác xóa thất bại!";
        echo "<script type='text/javascript'>alert('$message');</script>";
        $url = "index.php?require=them_moi_bao_hiem.php&catID=$ma_nv&title=Bảo Hiểm";
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "new_insurance_form")) {

    $sDate = str_replace('/', '-', $_POST['ngay_cap_bhxh']);
    $tDate = str_replace('/', '-', $_POST['ngay_cap_bhyt']);
    $sDate = date('Y-m-d', strtotime($sDate));
    $tDate = date('Y-m-d', strtotime($tDate));

    $insertSQL = sprintf("INSERT INTO tlb_baohiem (ma_nhan_vien, so_bhxh, ngay_cap_bhxh, noi_cap_bhxh, so_bhyt, ngay_cap_bhyt, noi_cap_bhyt) VALUES ('{$ma_nv}', %s, '{$sDate}', %s, %s, '{$tDate}', %s)",
        GetSQLValueString($_POST['so_bhxh'], "text"),
        GetSQLValueString($_POST['noi_cap_bhxh'], "text"),
        GetSQLValueString($_POST['so_bhyt'], "text"),
        GetSQLValueString($_POST['noi_cap_bhyt'], "text"));

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


    $insertGoTo = "them_moi_bao_hiem.php";
    if (isset($_SERVER['QUERY_STRING'])) {
        $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
        $insertGoTo .= $_SERVER['QUERY_STRING'];
    }
    sprintf("location: %s", $insertGoTo);
}

$mydb->setQuery("SELECT * FROM tlb_baohiem where ma_nhan_vien = '$ma_nv'");
$RCBaohiem_TM = $mydb->executeQuery();
$row_RCBaohiem_TM = $mydb->fetch_assoc($RCBaohiem_TM);
$totalRows_RCBaohiem_TM = $mydb->num_rows($RCBaohiem_TM);

/*
if ($totalRows_RCBaohiem_TM <>0)
{
    $url = "index.php?require=cap_nhat_bao_hiem.php&catID=$ma_nv&title=Cập nhật bảo hiểm";
    location($url);
}
*/
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
            $("#ngay_cap_bhxh").datepicker({showOn: 'button', buttonImage: 'images/calendar.gif', buttonImageOnly: true, dateFormat: 'dd/mm/yy', changeMonth: true, changeYear: true});
            $("#ngay_cap_bhyt").datepicker({showOn: 'button', buttonImage: 'images/calendar.gif', buttonImageOnly: true, dateFormat: 'dd/mm/yy', changeMonth: true, changeYear: true});
            $('#ui-datepicker-div').wrap('<div class="datepicker ll-skin-siena"></div>')
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
    <?php
        if ($totalRows_RCBaohiem_TM<>0)
        {
    ?>
            <table id="rounded-corner" border="0" width="750">
            <thead>
                <tr>
                    <th width="80" class="rounded-content">Số BHXH</th>
                    <th width="70">Ngày cấp</th>
                    <th width="120">Nơi cấp</th>
                    <th width="80">Số BHYT</th>
                    <th width="70">Ngày cấp</th>
                    <th width="120">Nơi cấp</th>
                    <th width="100" colspan="2" align="center" class="rounded-q4">Thao tác</th>
                </tr>
            </thead>
                <tr>
                    <td><?php echo $row_RCBaohiem_TM['so_bhxh']; ?></td>
                    <td><?php echo date("d/m/Y", strtotime($row_RCBaohiem_TM['ngay_cap_bhxh'])); ?></td>
                    <td><?php echo $row_RCBaohiem_TM['noi_cap_bhxh']; ?></td>
                    <td><?php echo $row_RCBaohiem_TM['so_bhyt']; ?></td>
                    <td><?php echo date("d/m/Y", strtotime($row_RCBaohiem_TM['ngay_cap_bhyt'])); ?></td>
                    <td><?php echo $row_RCBaohiem_TM['noi_cap_bhyt']; ?></td>
                    <td align="center">
                        <a href="index.php?require=cap_nhat_bao_hiem.php&catID=<?php echo $ma_nv; ?>&tomID=<?php echo $row_RCBaohiem_TM['id']; ?>&title=Cập nhật bảo hiểm">
                            <?php
                                echo '<img src="images/user_edit.png" alt="Sửa" title="" border="0" />';
                            ?>
                        </a>
                    </td>
                    <td align="center">
                        <a href="#" onclick="ConfirmDelete()" value="Xóa bảo hiểm">
                            <?php
                                echo '<img src="images/trash.png" alt="Xóa" title="" border="0" />';
                            ?>
                        </a>
                        <script type="text/javascript">
                            function ConfirmDelete()
                            {
                                if (confirm("Bạn có chắc chắn thao tác xóa!"))
                                    location.href='index.php?require=them_moi_bao_hiem.php&catID=<?php echo $ma_nv; ?>&tomID=<?php echo $row_RCBaohiem_TM['id']; ?>&title=Cập nhật bảo hiểm&action=del';
                            }
                        </script>
                    </td>
                </tr>
                <?php // } while ($row_RCBaohiem_TM = $mydb->fetch_assoc($row_RCBaohiem_TM)); ?>
            </table>
        <?php
            }
            else {
        ?>
            <table id="rounded-corner" border="0" width="460" align="center" cellpadding="1" cellspacing="1">
                <span><h4>Chưa có bảo hiểm được ghi nhận, mời thêm mới</h4></span>
            </table>
        <?php
            }
        ?>
    </div>

    <!--MAIN BOTTOM CONTENT -->
    <div class="detail_bottom">

        <form action="<?php echo $editFormAction; ?>" method="post" name="new_insurance_form" id="new_insurance_form">
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
                        <input type="text" name="so_bhxh" value="" size="27" data-validation="required"/>
                    </td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Ngày Cấp BHXH:</td>
                    <td>
                        <input type="text" name="ngay_cap_bhxh" id="ngay_cap_bhxh" value="" size="27" data-validation="date" data-validation-format="dd/mm/yyyy"/>
                        (dd/mm/yyyy)
                    </td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Nơi Cấp BHXH:</td>
                    <td><textarea name="noi_cap_bhxh" value="" rows="5" cols="60" data-validation="required"></textarea></td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Số BHYT:</td>
                    <td>
                        <input type="text" name="so_bhyt" value="" size="27" data-validation="required"/>
                    </td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Ngày Cấp BHYT:</td>
                    <td>
                        <input type="text" name="ngay_cap_bhyt" id="ngay_cap_bhyt" value="" size="27" data-validation="date" data-validation-format="dd/mm/yyyy"/>
                        (dd/mm/yyyy)
                    </td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Nơi Cấp BHYT:</td>
                    <td><textarea name="noi_cap_bhyt" value="" rows="5" cols="60" data-validation="required"></textarea></td>
                </tr>

                <tr>
                    <td colspan="2" align="right">
                        <button class="btn btn-default" onclick="new_insurance_form.reset();">Làm lại</button>
                        <input type="submit" onClick="ConfirmCreate()" class="btn btn-default" name="submit" id="addinsurance" value="Thêm mới bảo hiểm" />
                        <script type="text/javascript">
                        function ConfirmCreate()
                        {
                            if (confirm("Bạn có chắc chắn thao tác thêm mới!"))
                            {
                                new_insurance_form.submit();
                                return false;
                            }  
                        }
                        </script>
                    </td>
                </tr>
                <tfoot>
                    <tr>
                        <td class="rounded-foot-left">
                            <em><p><b><u>Hướng Dẫn:</u></b> 
                                <br>&nbsp;+ Các mục thêm vào là bắt buộc
                                <br>&nbsp;+ Để xóa tất cả mẫu đang thao tác nhấn nút Làm lại
                                <br>&nbsp;+ Hoàn thành bằng việc xác nhận nút Thêm mới
                            </em></td>
                        <td class="rounded-foot-right">&nbsp;</td>

                    </tr>
                </tfoot>
            </table>
            <input type="hidden" name="MM_insert" value="new_insurance_form" />
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