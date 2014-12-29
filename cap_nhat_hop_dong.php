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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "update_salary_form")) {
    $sDate = str_replace('/', '-', $_POST['tu_ngay']);
    $tDate = str_replace('/', '-', $_POST['den_ngay']);
    $sDate = date('Y-m-d', strtotime($sDate));
    $tDate = date('Y-m-d', strtotime($tDate));

    $updateSQL = sprintf("UPDATE tlb_hopdong SET so_quyet_dinh=%s, tu_ngay='{$sDate}', den_ngay='{$tDate}', loai_hop_dong=%s, ghi_chu=%s WHERE id='{$id}' AND ma_nhan_vien='{$ma_nv}'",
        GetSQLValueString($_POST['so_quyet_dinh'], "text"),
        GetSQLValueString($_POST['loai_hop_dong'], "int"),
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

    $updateGoTo = "them_moi_hop_dong.php";
    if (isset($_SERVER['QUERY_STRING'])) {
        $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
        $updateGoTo .= $_SERVER['QUERY_STRING'];
    }
    sprintf("location: %s", $updateGoTo);
}

$mydb->setQuery("SELECT * FROM tlb_hopdong where ma_nhan_vien = '$ma_nv'");
$RCHopdong_DS = $mydb->executeQuery();
$row_RCHopdong_DS = $mydb->fetch_assoc($RCHopdong_DS);
$totalRows_RCHopdong_DS = $mydb->num_rows($RCHopdong_DS);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<head>
    <link rel="stylesheet" type="text/css" href="css/jquery.datepick.css" />
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery.plugin.js"></script> 
    <script type="text/javascript" src="js/jquery.datepick.js"></script>
    <script type="text/javascript" src="js/jquery.datepick-vi.js"></script>
    <script>
        $(function() {
            $('#tu_ngay').datepick({showOnFocus: false, showTrigger: '#calImg'});
            $('#den_ngay').datepick({showOnFocus: false, showTrigger: '#calImg'});

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
                    <th width="280" class="rounded-content">Số Quyết Định HĐ</th>
                    <th width="140">Hiệu lực từ</th>
                    <th width="120">Đến hết</th>
                    <th width="280" colspan="2" class="rounded-q4">Loại hợp đồng</th>
                </tr>
            </thead>

        <?php do { ?>
                <tr>
                    <td><?php echo $row_RCHopdong_DS['so_quyet_dinh']; ?></td>
                    <td><?php echo date("d/m/Y", strtotime($row_RCHopdong_DS['tu_ngay'])); ?></td>
                    <td><?php echo date("d/m/Y", strtotime($row_RCHopdong_DS['den_ngay'])); ?></td>
                    <td>
                    <?php 
                        if ($row_RCHopdong_DS['loai_hop_dong']==0)
                        {
                            echo "Không thời hạn"; 
                        }
                        else
                        {
                            echo $row_RCHopdong_DS['loai_hop_dong'];
                            echo " Năm";
                        }
                    ?>
                    </td>
                </tr>
        <?php } while ($row_RCHopdong_DS = $mydb->fetch_assoc($RCHopdong_DS)); ?>
        </table>
    </div>
    <!--MAIN BOTTOM CONTENT -->

    <div class="detail_bottom">

    <?php
        $mydb->setQuery("SELECT * FROM tlb_hopdong where ma_nhan_vien = '$ma_nv' and id = $id");
        $RCHopdong_CN = $mydb->executeQuery();
        $row_RCHopdong_CN = $mydb->fetch_assoc($RCHopdong_CN);
        $totalRows_RCHopdong_CN = $mydb->num_rows($RCHopdong_CN);
    ?>
    <form action="<?php echo $editFormAction; ?>" method="post" name="update_salary_form" id="update_salary_form">
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
                    <td nowrap="nowrap" align="right">Hiệu lực từ:</td>
                    <td>
                        <input type="text" name="tu_ngay" id="tu_ngay" value="<?php echo htmlentities(date("d/m/Y", strtotime($row_RCHopdong_CN['tu_ngay'])), ENT_COMPAT, 'utf-8'); ?>" size="27" />
                        (dd/mm/yyyy)
                    </td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Đến hết:</td>
                    <td>
                        <input type="text" name="den_ngay" id="den_ngay" value="<?php echo htmlentities(date("d/m/Y", strtotime($row_RCHopdong_CN['den_ngay'])), ENT_COMPAT, 'utf-8'); ?>" size="27" />
                        (dd/mm/yyyy)
                    </td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Số quyết định HĐ:</td>
                    <td>
                        <input type="text" name="so_quyet_dinh" value="<?php echo htmlentities($row_RCHopdong_CN['so_quyet_dinh'], ENT_COMPAT, 'utf-8'); ?>" size="54" />
                    </td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Loại Hợp Đồng:</td>
                    <td>
                        <select name="loai_hop_dong">
                            <option selected="selected" value="<?php echo $row_RCHopdong_CN['loai_hop_dong']?>">
                            <?php 
                                if ($row_RCHopdong_CN['loai_hop_dong']==0)
                                {
                                    echo "Không thời hạn";
                                }
                                else
                                {
                                    echo $row_RCHopdong_CN['loai_hop_dong'];
                                    echo " Năm";
                                }
                            ?>
                            </option>  
                            <option value="0" >Không thời hạn</option>
                            <option value="1" >1 Năm</option>
                            <option value="2" >2 Năm</option>
                            <option value="3" >3 Năm</option>
                            <option value="4" >4 Năm</option>
                        </select>
                    </td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Ghi chú:</td>
                    <td><textarea name="ghi_chu" value="<?php echo htmlentities($row_RCHopdong_CN['ghi_chu'], ENT_COMPAT, 'utf-8'); ?>" rows="5" cols="60"></textarea></td>
                </tr>
                <tr valign="baseline">
                    <td colspan="2">
                        <a href="#" onclick="ConfirmEdit()" class="bt_green"><span class="bt_green_lft"></span><strong>Cập nhật</strong><span class="bt_green_r"></span></a>
                        <a href="#" onclick="go_back()" class="bt_blue"><span class="bt_blue_lft"></span><strong>Quay lại</strong><span class="bt_blue_r"></span></a>
                        <script type="text/javascript">
                            function go_back()
                                {
                                    location.href='index.php?require=them_moi_hop_dong.php&catID=<?php echo $ma_nv; ?>&title=Ký Hợp Đồng&action=new';
                                }
                            function ConfirmEdit()
                            {
                                if (confirm("Bạn có chắc chắn thao tác cập nhật!"))
                                {
                                    update_salary_form.submit();
                                    return false;
                                }  
                            }
                        </script>
                    </td>
                </tr>
            </table>
            <input type="hidden" name="MM_update" value="update_salary_form" />
            <input type="hidden" name="id" value="<?php echo $row_RCHopdong_CN['id']; ?>" />
        </form>
    </div>
</body>
</html>