<?php require_once('includes/initialize.php'); ?>
<?php
$ma_nv = get_param('catID');
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "new_job_form")) {
    $insertSQL = sprintf("INSERT INTO tlb_congviec (ma_nhan_vien, ngay_vao_lam, phong_ban_id, cong_viec_id, chuc_vu_id, muc_luong_cb, he_so, phu_cap, so_sld, ngay_cap, noi_cap, tknh, ngan_hang, hoc_van_id, bang_cap_id, ngoai_ngu_id, tin_hoc_id) VALUES ('$ma_nv', %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
        GetSQLValueString(get_param('ngay_vao_lam'), "date"),
        GetSQLValueString(get_param('phong_ban_id'), "text"),
        GetSQLValueString(get_param('cong_viec_id'), "text"),
        GetSQLValueString(get_param('chuc_vu_id'), "text"),
        GetSQLValueString(get_param('muc_luong_cb'), "text"),
        GetSQLValueString(get_param('he_so'), "text"),
        GetSQLValueString(get_param('phu_cap'), "text"),
        GetSQLValueString(get_param('so_sld'), "text"),
        GetSQLValueString(get_param('ngay_cap'), "date"),
        GetSQLValueString(get_param('noi_cap'), "text"),
        GetSQLValueString(get_param('tknh'), "text"),
        GetSQLValueString(get_param('ngan_hang'), "text"),
        GetSQLValueString(get_param('hoc_van_id'), "text"),
        GetSQLValueString(get_param('bang_cap_id'), "text"),
        GetSQLValueString(get_param('ngoai_ngu_id'), "text"),
        GetSQLValueString(get_param('tin_hoc_id'), "text"));

    $mydb->setQuery($insertSQL);
    $result = $mydb->executeQuery();

    $insertGoTo = "danh_sach_nhan_vien.php";
    if (isset($_SERVER['QUERY_STRING'])) {
        $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
        $insertGoTo .= $_SERVER['QUERY_STRING'];
    }
    //thêm mới công việc xong, chuyển sang trang danh sách nhân viêc
    $url = "index.php";
    location($url);
}


$mydb->setQuery("SELECT * FROM tlb_phongban");
$RCPhongban = $mydb->executeQuery();
$row_RCPhongban = $mydb->fetch_assoc($RCPhongban);
$totalRows_RCPhongban = $mydb->num_rows($RCPhongban);


// Lấy mã nhân viên đưa vào để cập nhật
$mydb->setQuery("SELECT * FROM tlb_nhanvien where ma_nhan_vien= '$ma_nv'");
$RCThem_congviec = $mydb->executeQuery();
$row_RCThem_congviec = $mydb->fetch_assoc($RCThem_congviec);
$totalRows_RCThem_congviec = $mydb->num_rows($RCThem_congviec);


// Lấy danh sách công việc khi tiến hành cập nhật
$mydb->setQuery("SELECT * FROM tlb_ctcongviec");
$RCctcongviec = $mydb->executeQuery();
$row_RCctcongviec = $mydb->fetch_assoc($RCctcongviec);
$totalRows_RCctcongviec = $mydb->num_rows($RCctcongviec);

// Lấy danh sách chức vụ
$mydb->setQuery("SELECT * FROM tlb_chucvu");
$RCChucvu = $mydb->executeQuery();
$row_RCChucvu = $mydb->fetch_assoc($RCChucvu);
$totalRows_RCChucvu = $mydb->num_rows($RCChucvu);

// Lấy danh sách học vấn
$mydb->setQuery("SELECT * FROM tlb_hocvan");
$RCHocvan = $mydb->executeQuery();
$row_RCHocvan = $mydb->fetch_assoc($RCHocvan);
$totalRows_RCHocvan = $mydb->num_rows($RCHocvan);

// Lấy danh sách bằng, chứng chỉ học vấn
$mydb->setQuery("SELECT * FROM tlb_bangcap");
$RCBangcap = $mydb->executeQuery();
$row_RCBangcap = $mydb->fetch_assoc($RCBangcap);
$totalRows_RCBangcap = $mydb->num_rows($RCBangcap);

// Lấy danh sách trình độ ngoại ngữ
$mydb->setQuery("SELECT * FROM tlb_ngoaingu");
$RCNgoaingu = $mydb->executeQuery();
$row_RCNgoaingu = $mydb->fetch_assoc($RCNgoaingu);
$totalRows_RCNgoaingu = $mydb->num_rows($RCNgoaingu);

// Lấy danh sách trình độ tin học
$mydb->setQuery("SELECT * FROM tlb_tinhoc");
$RCTinhoc = $mydb->executeQuery();
$row_RCTinhoc = $mydb->fetch_assoc($RCTinhoc);
$totalRows_RCTinhoc = $mydb->num_rows($RCTinhoc);

$mydb->setQuery("SELECT * FROM tlb_congviec where ma_nhan_vien = '$ma_nv'");
$RCCheck = $mydb->executeQuery();
$row_RCCheck = $mydb->fetch_assoc($RCCheck);
$totalRows_RCCheck = $mydb->num_rows($RCCheck);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
</head>

<body text="#000000" link="#CC0000" vlink="#0000CC" alink="#000099">
    <div style="display: none;">
        <img id="calImg" src="images/calendar.gif" alt="Popup" class="trigger">
    </div>

    <!--MAIN UP CONTENT -->
    <div class="detail_up">
    <?php 
        if ($totalRows_RCCheck<>0)
        {
    ?>
        <table id="rounded-corner" border="0" width="750">
            <thead>
                <tr>
                    <th width="120" class="rounded-content">Số QĐ</th>
                    <th width="80">Ngày ký</th>
                    <th width="100">Ngày hiệu lực</th>
                    <th width="300">Công việc</th>
                    <th colspan="2" align="center" class="rounded-q4">Thao tác</th>
                </tr>
            </thead>
        <?php 
            do { ?>
                <tr>
                    <td><?php echo $row_RCCheck['so_quyet_dinh']; ?></td>
                    <td><?php echo date("d/m/Y", strtotime($row_RCCheck['ngay_ky'])); ?></td>
                    <td><?php echo date("d/m/Y", strtotime($row_RCCheck['ngay_hieu_luc'])); ?></td>
                    <td><?php echo $row_RCCheck['cong_viec']; ?></td>
                    <td width="50" align="center">
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
                    while ($row_RCCheck = $mydb->fetch_assoc($RCCheck)); 
                ?>
            </table>
        <?php
            }
            else {
            ?>
                <table id="rounded-corner" border="0" width="460" align="center" cellpadding="1" cellspacing="1">
                <span><h4>Chưa có quá trình công việc được ghi lại, mời thêm mới</h4></span>
                </table>
        <?php
            }
        ?>
    </div>
    <!--MAIN BOTTOM CONTENT -->
    <div class="detail_bottom">

        <form action="<?php echo $editFormAction; ?>" method="post" name="new_job_form" id="new_job_form">
            <table id="rounded-corner" width="750" align="center">


            
      <tr valign="baseline">
        <td width="96" align="right" nowrap="nowrap">Mã nhân viên:</td>
        <td style="color:red"><b><?php echo $ma_nv; ?></b></td>
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
    <tr>
        <td width="117">Tài khoản NH:</td>
        <td width="300"><input type="text" name="tknh" value="" size="32" /></td>
        <td>Ngân hàng:</td>
        <td><input type="text" name="ngan_hang" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
        <td nowrap="nowrap" align="right">Ngày vào làm (*):</td>
        <td><input type="text" name="ngay_vao_lam" value="" size="25" /></td>
        
    </tr>
    <tr valign="baseline">
        <td nowrap="nowrap" align="right">Phòng ban:</td>
        <td><select name="phong_ban_id">
          <?php 
          do {  
            ?>
            <option value="<?php echo $row_RCPhongban['phong_ban_id']?>"><?php echo $row_RCPhongban['ten_phong_ban']?></option>
            <?php
        } while ($row_RCPhongban = $mydb->fetch_assoc($RCPhongban));
        ?>
    </select></td>
</tr>
<tr valign="baseline">
    <td nowrap="nowrap" align="right">Công việc:</td>
    <td><select name="cong_viec_id">
      <?php 
      do {  
        ?>
        <option value="<?php echo $row_RCctcongviec['cong_viec_id']?>"><?php echo $row_RCctcongviec['ten_cong_viec']?></option>
        <?php
    } while ($row_RCctcongviec = $mydb->fetch_assoc($RCctcongviec));
    ?>
</select></td>

</tr>
<tr valign="baseline">
    <td nowrap="nowrap" align="right">Chức vụ:</td>
    <td><select name="chuc_vu_id">
      <?php 
      do {  
        ?>
        <option value="<?php echo $row_RCChucvu['chuc_vu_id']?>"><?php echo $row_RCChucvu['ten_chuc_vu']?></option>
        <?php
    } while ($row_RCChucvu = $mydb->fetch_assoc($RCChucvu));
    ?>
</select></td>
</tr>
<tr valign="baseline">
    <td nowrap="nowrap" align="right">Mức lương :</td>
    <td><input type="text" name="muc_luong_cb" value="" size="32" /></td>
    
</tr>
<tr valign="baseline">
    <td nowrap="nowrap" align="right">Hệ số:</td>
    <td><input type="text" name="he_so" value="" size="32" /></td>
    <td></td>
    <td></td>
</tr>
<tr valign="baseline">
    <td nowrap="nowrap" align="right">Phụ cấp:</td>
    <td><input type="text" name="phu_cap" value="" size="32" /></td>
    <td></td>
    <td></td>
</tr>
<tr valign="baseline">
    <td nowrap="nowrap" align="right">Số sổ lao động:</td>
    <td><input type="text" name="so_sld" value="" size="32" /></td>
    <td></td>
    <td></td>
</tr>
<tr valign="baseline">
    <td nowrap="nowrap" align="right">Ngày cấp:</td>
    <td><input type="text" name="ngay_cap" value="" size="32" /></td>
    <td></td>
    <td></td>
</tr>
<tr valign="baseline">
    <td nowrap="nowrap" align="right">Nơi cấp:</td>
    <td><input type="text" name="noi_cap" value="" size="32" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>
<tr valign="baseline">
    <td colspan="4" align="center" nowrap="nowrap"><input type="submit" value="Insert record" /></td>
</tr>
</table>
<input type="hidden" name="MM_insert" value="new_job_form" />
</form>
<p>&nbsp;</p>
</body>
</html>
