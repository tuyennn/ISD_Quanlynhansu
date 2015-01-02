<?php
$ma_nv = $_GET['catID'];
$action = get_param('action');
//Thực hiện lệnh xoá nếu chọn xoá
if ($action=="del")
{
    $tomID = $_GET['tomID'];
    $deleteSQL = "DELETE FROM tlb_quatrinhcongtac WHERE id=$tomID";                     
    
    $mydb->setQuery($deleteSQL);
    $result_d = $mydb->executeQuery();

    if($result_d) {
        $message = "Thao tác xóa thành công!";
        echo "<script type='text/javascript'>alert('$message');</script>";
        $url = "index.php?require=them_moi_qua_trinh_cong_tac.php&catID=$ma_nv&title=Cập nhật quá trình công tác";
        location($url);
    }
    else {
        $message = "Thao tác xóa thất bại!";
        echo "<script type='text/javascript'>alert('$message');</script>";
        $url = "index.php?require=them_moi_qua_trinh_cong_tac.php&catID=$ma_nv&title=Cập nhật quá trình công tác";
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "new_workingprocess_form")) {
    $sDate = str_replace('/', '-', $_POST['ngay_ky']);
    $tDate = str_replace('/', '-', $_POST['ngay_hieu_luc']);
    $sDate = date('Y-m-d', strtotime($sDate));
    $tDate = date('Y-m-d', strtotime($tDate));

    $insertSQL = sprintf("INSERT INTO tlb_quatrinhcongtac (ma_nhan_vien, so_quyet_dinh, ngay_ky, ngay_hieu_luc, cong_viec, ghi_chu) VALUES ('{$ma_nv}', %s, '{$sDate}', '{$tDate}', %s, %s)",
        GetSQLValueString($_POST['so_quyet_dinh'], "text"),
        GetSQLValueString($_POST['cong_viec'], "text"),
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

    $insertGoTo = "them_moi_qua_trinh_cong_tac.php";
    if (isset($_SERVER['QUERY_STRING'])) {
        $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
        $insertGoTo .= $_SERVER['QUERY_STRING'];
    }
    sprintf("location: %s", $insertGoTo);
}
    $mydb->setQuery("SELECT * FROM tlb_quatrinhcongtac where ma_nhan_vien = '$ma_nv'");
    $RCQuatrinh_TM = $mydb->executeQuery();
    $row_RCQuatrinh_TM = $mydb->fetch_assoc($RCQuatrinh_TM);
    $totalRows_RCQuatrinh_TM = $mydb->num_rows($RCQuatrinh_TM);
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
        if ($totalRows_RCQuatrinh_TM<>0)
            {
        ?>
            <table id="rounded-corner" border="0" width="750">
                <thead>
                    <tr>
                        <th width="120" class="rounded-content">Số QĐ</th>
                        <th width="80">Ngày ký</th>
                        <th width="100">Ngày hiệu lực</th>
                        <th width="300">Công việc</th>
                        <th width="100" colspan="2" align="center" class="rounded-q4">Thao tác</th>
                    </tr>
                </thead>
                    <?php 
                        do { ?>
                <tr>
                    <td><?php echo $row_RCQuatrinh_TM['so_quyet_dinh']; ?></td>
                    <td><?php echo date("d/m/Y", strtotime($row_RCQuatrinh_TM['ngay_ky'])); ?></td>
                    <td><?php echo date("d/m/Y", strtotime($row_RCQuatrinh_TM['ngay_hieu_luc'])); ?></td>
                    <td><?php echo $row_RCQuatrinh_TM['cong_viec']; ?></td>
                    <td align="center">
                        <a href="index.php?require=cap_nhat_qua_trinh_cong_tac.php&catID=<?php echo $ma_nv; ?>&tomID=<?php echo $row_RCQuatrinh_TM['id']; ?>&title=Cập nhật quá trình công tác">
                            <?php
                                echo '<img src="images/user_edit.png" alt="Sửa" title="" border="0" />';
                            ?>
                        </a>
                    </td>

                    <td align="center">
                        <a href="#" onclick="ConfirmDelete()" value="Xóa quá trình công tác">
                            <?php
                                echo '<img src="images/trash.png" alt="Xóa" title="" border="0" />';
                            ?>
                        </a>
                        <script type="text/javascript">
                            function ConfirmDelete()
                            {
                                if (confirm("Bạn có chắc chắn thao tác xóa!"))
                                    location.href='index.php?require=them_moi_qua_trinh_cong_tac.php&catID=<?php echo $ma_nv; ?>&tomID=<?php echo $row_RCQuatrinh_TM['id']; ?>&title=Cập nhật quá trình công tác&action=del';
                            }
                        </script>
                    </td>
                <?php } 
                    while ($row_RCQuatrinh_TM = $mydb->fetch_assoc($RCQuatrinh_TM)); 
                ?>
            </table>
        <?php
            }
            else {
            ?>
                <table id="rounded-corner" border="0" width="460" align="center" cellpadding="1" cellspacing="1">
                <span><h4>Chưa có quá trình công tác, mời thêm mới</h4></span>
                </table>
        <?php
            }
        ?>
    </div>

    <!--MAIN BOTTOM CONTENT -->
    <div class="detail_bottom">

        <form action="<?php echo $editFormAction; ?>" method="post" name="new_workingprocess_form" id="new_workingprocess_form">
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
                    <td nowrap="nowrap" align="right">Ngày ký:</td>
                    <td>
                        <input type="text" name="ngay_ky" id="ngay_ky" value="" size="27" />
                        (dd/mm/yyyy)
                    </td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Số quyết định công tác:</td>
                    <td>
                        <input type="text" name="so_quyet_dinh" value="" size="54" />
                    </td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Ngày hiệu lực:</td>
                    <td>
                        <input type="text" name="ngay_hieu_luc" id="ngay_hieu_luc" value="" size="27" />
                        (dd/mm/yyyy)
                    </td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Công việc:</td>
                    <td colspan="3"><input type="text" name="cong_viec" value="" size="54" /></td>
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
                                new_workingprocess_form.submit();
                                return false;
                            }  
                        }
                        </script>
                    </td>
                </tr>
            </table>
            <input type="hidden" name="MM_insert" value="new_workingprocess_form" />
        </form>
    </div>
</body>
</html>