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

$mydb->setQuery("SELECT * FROM tlb_nhanvien where ma_nhan_vien= '$ma_nv'");
$RCtlb_nhanvien = $mydb->executeQuery();
$row_RCtlb_nhanvien = $mydb->fetch_assoc($RCtlb_nhanvien);
$totalRows_RCtlb_nhanvien = $mydb->num_rows($RCtlb_nhanvien);

$mydb->setQuery("SELECT * FROM tlb_phongban inner join (tlb_ctcongviec inner join (tlb_chucvu inner join (tlb_hocvan inner join (tlb_bangcap inner join (tlb_ngoaingu inner join (tlb_tinhoc inner join (tlb_dantoc inner join (tlb_quoctich inner join (tlb_tongiao inner join (tlb_tinhthanh inner join tlb_congviec on tlb_tinhthanh.tinh_thanh_id = tlb_congviec.tinh_thanh_id) on tlb_tongiao.ton_giao_id = tlb_congviec.ton_giao_id) on tlb_quoctich.quoc_tich_id = tlb_congviec.quoc_tich_id) on tlb_dantoc.dan_toc_id = tlb_congviec.dan_toc_id) on tlb_tinhoc.tin_hoc_id = tlb_congviec.tin_hoc_id) on tlb_ngoaingu.ngoai_ngu_id = tlb_congviec.ngoai_ngu_id) on tlb_bangcap.bang_cap_id =tlb_congviec.bang_cap_id) on tlb_hocvan.hoc_van_id=tlb_congviec.hoc_van_id) on tlb_chucvu.chuc_vu_id=tlb_congviec.chuc_vu_id) on tlb_ctcongviec.cong_viec_id=tlb_congviec.cong_viec_id) on tlb_phongban.phong_ban_id=tlb_congviec.phong_ban_id where tlb_congviec.ma_nhan_vien= '$ma_nv'");
$RCTTcongviec = $mydb->executeQuery();
$row_RCTTcongviec = $mydb->fetch_assoc($RCTTcongviec);
$totalRows_RCTTcongviec = $mydb->num_rows($RCTTcongviec);

$mydb->setQuery("SELECT * FROM tlb_quanhegiadinh where ma_nhan_vien= '$ma_nv'");
$RCQuanhe_GD = $mydb->executeQuery();
$row_RCQuanhe_GD = $mydb->fetch_assoc($RCQuanhe_GD);
$totalRows_RCQuanhe_GD = $mydb->num_rows($RCQuanhe_GD);

$mydb->setQuery("SELECT * FROM tlb_baohiem where ma_nhan_vien= '$ma_nv'");
$RCBaohiem = $mydb->executeQuery();
$row_RCBaohiem = $mydb->fetch_assoc($RCBaohiem);
$totalRows_RCBaohiem = $mydb->num_rows($RCBaohiem);

$mydb->setQuery("SELECT * FROM tlb_hopdong where ma_nhan_vien= '$ma_nv'");
$RCHopdong = $mydb->executeQuery();
$row_RCHopdong = $mydb->fetch_assoc($RCHopdong);
$totalRows_RCHopdong = $mydb->num_rows($RCHopdong);


$mydb->setQuery("SELECT * FROM tlb_quatrinhcongtac where ma_nhan_vien= '$ma_nv'");
$RCQuatring_CT = $mydb->executeQuery();
$row_RCQuatring_CT = $mydb->fetch_assoc($RCQuatring_CT);
$totalRows_RCQuatring_CT = $mydb->num_rows($RCQuatring_CT);

$mydb->setQuery("SELECT * FROM tlb_quatrinhluong where ma_nhan_vien= '$ma_nv'");
$RCQuatrinh_luong = $mydb->executeQuery();
$row_RCQuatrinh_luong = $mydb->fetch_assoc($RCQuatrinh_luong);
$totalRows_RCQuatrinh_luong = $mydb->num_rows($RCQuatrinh_luong);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Hồ sơ nhân viên <?php echo $row_RCtlb_nhanvien['ma_nhan_vien']; ?>: <?php echo $row_RCtlb_nhanvien['ho_ten']; ?></title>
    <style type="text/css">
        td,th {
           line-height: 1.3;
           border: solid 1px;
           padding-left: 10px;
        }
    </style>
</head>

<body text="#000000" link="#CC0000" vlink="#0000CC" alink="#000099">
    <table class="tablebg" align="center" width="900" border="0" cellspacing="1" cellpadding="1">
        <tr>
            <td class="row5" align="left" height="50" colspan="4"><h3>Thông tin nhân viên</h3></td>
        </tr>
        <tr>
            <td class="row5" width="250" >Mã nhân viên: <b><?php echo $row_RCtlb_nhanvien['ma_nhan_vien']; ?></b></td>
            <td class="row5" width="350">Họ và tên: <b><?php echo $row_RCtlb_nhanvien['ho_ten']; ?></b></td>
            <td class="row5" width="150">Giới tính: <b>
                <?php 
                    if ($row_RCtlb_nhanvien['gioi_tinh']==1) 
                    {
                        echo "Nam";	
                    }
                    else
                    {
                        echo "Nữ";
                    }
                ?></b>
            </td>
            <td class="row5" width="150">Gia đình: <b>
                <?php 
                    if ($row_RCtlb_nhanvien['gia_dinh']==1) 
                    {
                        echo "Có gia đình";	
                    }
                    else
                    {
                        echo "Chưa có";
                    }
                ?></b>
          </td>
        </tr>
        <tr>
            <td class="row5">Điện thoại DĐ: <b><?php echo $row_RCtlb_nhanvien['dt_di_dong']; ?></b></td>
            <td class="row5">Điện thoại nhà: <b><?php echo $row_RCtlb_nhanvien['dt_nha']; ?></b></td>
            <td class="row5" colspan="2">Email: <b><?php echo $row_RCtlb_nhanvien['email']; ?><b></td>
        </tr>
        <tr>
            <td class="row5">Ngày sinh: <b><?php echo $row_RCtlb_nhanvien['ngay_sinh']; ?></b></td>
            <td class="row5">Nơi sinh: <b><?php echo $row_RCtlb_nhanvien['noi_sinh']; ?></b></td>
            <td class="row5" colspan="2">Tỉnh thành: <b><?php echo $row_RCtlb_nhanvien['tinh_thanh']; ?></b></td>
        </tr>
        <tr>
            <td class="row5">Số CMND: <b><?php echo $row_RCtlb_nhanvien['cmnd']; ?></b></td>
            <td class="row5">Ngày cấp: <b><?php echo $row_RCtlb_nhanvien['ngay_cap']; ?></b></td>
            <td class="row5" colspan="2">Nơi cấp: <b><?php echo $row_RCtlb_nhanvien['noi_cap']; ?></b></td>
        </tr>
        <tr>
            <td colspan="4" class="row5" >Quê quán: <b><?php echo $row_RCtlb_nhanvien['que_quan']; ?></b></td>
        </tr>
        <tr>
            <td colspan="4" class="row5">Thường trú: <b><?php echo $row_RCtlb_nhanvien['dia_chi']; ?></b></td>
        </tr>
        <tr>
            <td class="row5" colspan="4">Tạm trú: <b><?php echo $row_RCtlb_nhanvien['tam_tru']; ?></b></td>
        </tr>
    </table>


    <table class="tablebg" align="center" width="900" border="0" cellspacing="1" cellpadding="1">
        <tr>
            <td class="row5" align="left"colspan="4"><h3>Thông tin công việc</h3></td>
        </tr>
        <tr>
            <td class="row5" width="250">Ngày vào làm: <b><?php echo $row_RCTTcongviec['ngay_vao_lam']; ?></b></td>
            <td colspan="2" class="row5">Phòng ban: <b><?php echo $row_RCTTcongviec['ten_phong_ban']; ?></b></td>
            <td class="row5" width="300">Chức vụ: <b><?php echo $row_RCTTcongviec['ten_chuc_vu']; ?></b></td>
        </tr>
        <tr>
            <td class="row5">Công việc: <b><?php echo $row_RCTTcongviec['ten_cong_viec']; ?></b></td>
            <td width="152" class="row5">Mức lương: <b><?php echo $row_RCTTcongviec['muc_luong_cb']; ?><b></td>
            <td width="134" class="row5">Hệ số: <b><?php echo $row_RCTTcongviec['he_so']; ?></b></td>
            <td class="row5">Phụ cấp: <b><?php echo $row_RCTTcongviec['phu_cap']; ?></b></td>
        </tr>
        <tr>
            <td class="row5">Sổ LĐ: <b><?php echo $row_RCTTcongviec['so_sld']; ?></b></td>
            <td colspan="2" class="row5">Ngày cấp: <b><?php echo $row_RCTTcongviec['ngay_cap']; ?></b></td>
            <td class="row5">Nơi cấp: <b><?php echo $row_RCTTcongviec['noi_cap']; ?><b></td>
        </tr>
        <tr>
            <td class="row5">Tài khoản NH: <b><?php echo $row_RCTTcongviec['tknh']; ?><b></td>
            <td class="row5"colspan="3">Ngân hàng: <b><?php echo $row_RCTTcongviec['ngan_hang']; ?></b></td>
        </tr>
        <tr>
            <td class="row5">Học vấn: <b><?php echo $row_RCTTcongviec['ten_hoc_van']; ?></b></td>
            <td colspan="2" class="row5">Bằng cấp:<b><?php echo $row_RCTTcongviec['ten_bang_cap']; ?></b></td>
            <td class="row5">Ngoại ngữ: <b><?php echo $row_RCTTcongviec['ten_ngoai_ngu']; ?></b></td>
        </tr>
        <tr>
            <td class="row5">Tin học: <b><?php echo $row_RCTTcongviec['ten_tin_hoc']; ?></b></td>
            <td colspan="2" class="row5">Dân tộc: <b><?php echo $row_RCTTcongviec['ten_dan_toc']; ?></b></td>
            <td class="row5">Quốc tịch: <b><?php echo $row_RCTTcongviec['ten_quoc_tich']; ?></b></td>
        </tr>
        <tr>
            <td class="row5">Tôn giáo: <b><?php echo $row_RCTTcongviec['ten_ton_giao']; ?></b></td>
            <td colspan="2" class="row5">Tỉnh thành: <b><?php echo $row_RCTTcongviec['ten_tinh_thanh']; ?></b></td>
            <td class="row5">&nbsp;</td>
        </tr>
    </table>


    <table class="tablebg" align="center" width="900" border="0" cellspacing="1" cellpadding="1">
        <tr>
            <td class="row5" align="left"colspan="3"><h3>Quan hệ gia đình</h3></td>
        </tr>
        <?php do { ?>
            <tr>
                <td width="250" class="row5">Họ tên: <b><?php echo $row_RCQuanhe_GD['ten_nguoi_than']; ?></b></td>
                <td width="350" class="row5">Năm sinh: <b><?php echo $row_RCQuanhe_GD['nam_sinh']; ?></b></td>
                <td width="300" class="row5">Quan hệ: <b><?php echo $row_RCQuanhe_GD['moi_quan_he']; ?></b></td>
            </tr>
            <tr>
                <td colspan="2" class="row5">Địa chỉ: <b><?php echo $row_RCQuanhe_GD['dia_chi']; ?></b></td>
                <td class="row5">Nghề nghiệp: <b><?php echo $row_RCQuanhe_GD['nghe_nghiep']; ?></b></td>
            </tr>
            <tr>
                <td colspan="3" class="row5">Điện thoại: <b><?php echo $row_RCQuanhe_GD['dtll']; ?></b></td>
            </tr>
            <tr>
                <td colspan="3" class="row5" height="100" style="vertical-align: top"><strong>(*)Ghi chú:</strong> <?php echo $row_RCQuanhe_GD['ghi_chu']; ?></td>
            </tr>
        <?php } while ($row_RCQuanhe_GD = $mydb->fetch_assoc($RCQuanhe_GD)); ?>

        <tr>
            <td align="left" colspan="3" class="row5"><h3>Bảo hiểm</h3></td>
        </tr>
        <tr>
            <td class="row5">- Số BHXH: <?php echo $row_RCBaohiem['so_bhxh']; ?></td>
            <td class="row5">- Ngày cấp: <?php echo $row_RCBaohiem['ngay_cap_bhxh']; ?></td>
            <td class="row5">- Nơi cấp: <?php echo $row_RCBaohiem['noi_cap_bhxh']; ?></td>
        </tr>
        <tr>
            <td class="row5">- Số BHYT: <?php echo $row_RCBaohiem['so_bhyt']; ?></td>
            <td class="row5">- Ngày cấp: <?php echo $row_RCBaohiem['ngay_cap_bhyt']; ?></td>
            <td class="row5">- Nơi cấp: <?php echo $row_RCBaohiem['noi_cap_bhyt']; ?></td>
        </tr>
    </table>
    
    <table class="tablebg" align="center" width="900" border="0" cellspacing="1" cellpadding="1">
        <tr>
            <td class="row5" align="left" colspan="5"><h3>Hợp đồng lao động</h3></td>
        </tr>
        <tr>
            <td width="176" class="row5">Số quyết định</td>
            <td width="86" class="row5">Từ ngày</td>
            <td width="86" class="row5">Đến ngày</td>
            <td width="105" class="row5">Loại hợp đồng</td>
            <td width="430" class="row5">Ghi chú</td>
        </tr>
        <?php do { ?>
        <tr>
            <td class="row5" width="176"><?php echo $row_RCHopdong['so_quyet_dinh']; ?></td>
            <td class="row5" width="86"><?php echo $row_RCHopdong['tu_ngay']; ?></td>
            <td class="row5" width="86"><?php echo $row_RCHopdong['den_ngay']; ?></td>
            <td class="row5" width="105"><?php echo $row_RCHopdong['loai_hop_dong']; ?></td>
            <td class="row5"><?php echo $row_RCHopdong['ghi_chu']; ?></td>
        </tr>
      <?php } while ($row_RCHopdong = $mydb->fetch_assoc($RCHopdong)); ?>
    </table>

    <table class="tablebg" align="center" width="900" border="0" cellspacing="1" cellpadding="1">
        <tr>
            <td class="row5" align="left" colspan="5"><h3>Quá trình công tác</h3></td>
        </tr>
        <tr>
            <td class="row5">Số quyết định</td>
            <td class="row5">Ngày hiệu lực</td>
            <td class="row5">Ngày ký</td>
            <td class="row5">Công việc</td>
            <td width="391" class="row5">Ghi chú</td>
        </tr>
        <?php do { ?>
        <tr>
            <td class="row5" width="156"><?php echo $row_RCQuatring_CT['so_quyet_dinh']; ?></td>
            <td class="row5" width="96"><?php echo $row_RCQuatring_CT['ngay_hieu_luc']; ?></td>
            <td class="row5" width="94"><?php echo $row_RCQuatring_CT['ngay_ky']; ?></td>
            <td class="row5" width="146"><?php echo $row_RCQuatring_CT['cong_viec']; ?></td>
            <td class="row5"><?php echo $row_RCQuatring_CT['ghi_chu']; ?></td>
        </tr>
        <?php } while ($row_RCQuatring_CT = $mydb->fetch_assoc($RCQuatring_CT)); ?>
    </table>
    
    <table class="tablebg" align="center" width="900" border="0" cellspacing="1" cellpadding="1">
        <tr>
            <td class="row5" align="left" colspan="4"><h3>Quá trình lương</h3></td>
        </tr>
        <tr>
            <td class="row5">Số quyết định</td>
            <td class="row5">Ngày chuyển</td>
            <td class="row5">Mức lương</td>
            <td class="row5">Ghi chú</td>
        </tr>
        <?php do { ?>
        <tr>
            <td class="row5" width="200"><?php echo $row_RCQuatrinh_luong['so_quyet_dinh']; ?></td>
            <td class="row5" width="100"><?php echo $row_RCQuatrinh_luong['ngay_chuyen']; ?></td>
            <td class="row5" width="100"><?php echo $row_RCQuatrinh_luong['muc_luong']; ?></td>
            <td class="row5"><?php echo $row_RCQuatrinh_luong['ghi_chu']; ?></td>
        </tr>
        <?php } while ($row_RCHopdong = $mydb->fetch_assoc($RCHopdong)); ?>
    </table>
</body>
</html>
