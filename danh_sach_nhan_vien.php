<?php
// Function Tìm Kiếm Nhân Viên

$keyword = get_param('keyword');
$mydb->setQuery("SELECT * FROM tlb_nhanvien ORDER BY `tlb_nhanvien`.`ma_nhan_vien` ASC");

if($keyword!=''){
    $mydb->setQuery("SELECT * FROM tlb_nhanvien WHERE ho_ten LIKE '%".$keyword."%'");
}


$result = $mydb->executeQuery();
$row_RCdanh_sach = $mydb->fetch_assoc($result);
$totalRows_RCdanh_sach = $mydb->num_rows($result);
?>


<?php
$action = get_param('action');
//Thực hiện lệnh xoá nếu chọn xoá
if ($action=="del")
{
    $ma_nv = $_GET['catID'];
    $deleteSQL = "DELETE    tlb_nhanvien.* ,
                            tlb_baohiem.* ,
                            tlb_congviec.* ,
                            tlb_hinhanh.* ,
                            tlb_hopdong.* ,
                            tlb_quanhegiadinh.* ,
                            tlb_quatrinhcongtac.* ,
                            tlb_quatrinhluong.*
                FROM tlb_nhanvien
                    LEFT JOIN tlb_baohiem ON tlb_baohiem.ma_nhan_vien = tlb_nhanvien.ma_nhan_vien
                    LEFT JOIN tlb_congviec ON tlb_congviec.ma_nhan_vien = tlb_nhanvien.ma_nhan_vien
                    LEFT JOIN tlb_hinhanh ON tlb_hinhanh.ma_nhan_vien = tlb_nhanvien.ma_nhan_vien
                    LEFT JOIN tlb_hopdong ON tlb_hopdong.ma_nhan_vien = tlb_nhanvien.ma_nhan_vien
                    LEFT JOIN tlb_quanhegiadinh ON tlb_quanhegiadinh.ma_nhan_vien = tlb_nhanvien.ma_nhan_vien
                    LEFT JOIN tlb_quatrinhcongtac ON tlb_quatrinhcongtac.ma_nhan_vien = tlb_nhanvien.ma_nhan_vien
                    LEFT JOIN tlb_quatrinhluong ON tlb_quatrinhluong.ma_nhan_vien = tlb_nhanvien.ma_nhan_vien
                WHERE
                    tlb_nhanvien.ma_nhan_vien = '$ma_nv'";

    $upload_dir = "uploads";
    $mydb->setQuery("SELECT * FROM tlb_hinhanh WHERE ma_nhan_vien = '$ma_nv'");
    $RChinh_anh = $mydb->executeQuery();
    $row_RChinh_anh = $mydb->fetch_assoc($RChinh_anh);
    $totalRows_RChinh_anh = $mydb->num_rows($RChinh_anh);
    if($totalRows_RChinh_anh == 1) {
        $file = $upload_dir."/".$row_RChinh_anh['filename'];
        if (!unlink($file))
        {
            echo ("Error deleting $file");
        }
        else
        {
            echo ("$file deleted!");
        }
        $command=mysql_query("DELETE tlb_hinhanh.* FROM tlb_hinhanh WHERE `ma_nhan_vien` = '$ma_nv'");
    }                  
    
    $mydb->setQuery($deleteSQL);
    $result_d = $mydb->executeQuery();

    if($result_d) {
        $message = "Thao tác xóa thành công!";
        echo "<script type='text/javascript'>alert('$message');</script>";
        $url = "index.php?require=danh_sach_nhan_vien.php&title=Danh sách nhân viên";
        location($url);
    }
    else {
        $message = "Thao tác xóa thất bại!";
        echo "<script type='text/javascript'>alert('$message');</script>";
        $url = "index.php?require=danh_sach_nhan_vien.php&title=Danh sách nhân viên";
        location($url);
    }
}
?>

<?php
if($keyword!=''){
	echo '<div id="tieude2">Kết quả tìm nhân viên có chứa từ khóa tìm kiếm "'.$keyword.'"</div>';
    echo '<br>';
}
?>
<table id="rounded-corner" summary="Bảng Thống Kê Nhân Viên Chính" >
    <thead>
        <tr>
            <th width="30" rowspan="2" align="center" class="rounded-company"></th>
            <th width="30" rowspan="2" align="center">MÃ</th>
            <th width="300" rowspan="2" align="center">HỌ VÀ TÊN</th>
            <th width="90" rowspan="2" align="center">ĐT DI ĐỘNG</th>
            <th width="90" rowspan="2" align="center">ĐT NHÀ</th>
            <th width="120" rowspan="2" align="center">EMAIL</th>
            <th colspan="2" align="center">HỒ SƠ</th>
            <th width="30" rowspan="2" align="center" class="rounded-q4">XÓA</th>
        </tr>

        <tr>
            <td align="center" bgcolor="#CC0000">Cá nhân</td>
            <td align="center" bgcolor="#CC0000">Công ty</td>
        </tr>
    </thead>
<?php do { ?>
        <tr>
            <td width="50" align="center">
                <a href="chi_tiet_nhan_vien.php?catID=<?php echo $row_RCdanh_sach['ma_nhan_vien']; ?>">
                <?php 
                    if ($row_RCdanh_sach['nghi_viec'] == 0)
                        {
                            echo '<img src="images/Available.png" alt="Đang làm việc" title="" border="0" />';
                        }
                    if  ($row_RCdanh_sach['nghi_viec'] == 1)
                        {
                            echo '<img src="images/Offline.png" alt="Đã nghỉ việc" title="" border="0" />';
                        }
                ?>
                </a>
            </td>
            <td width="30" align="left"><a href="chi_tiet_nhan_vien.php?catID=<?php echo $row_RCdanh_sach['ma_nhan_vien']; ?> " target="_blank"><?php echo $row_RCdanh_sach['ma_nhan_vien']; ?></a></td>
            <td align="left"><?php echo $row_RCdanh_sach['ho_ten']; ?></td>
            <td align="left"><?php echo $row_RCdanh_sach['dt_di_dong']; ?></td>
            <td align="left"><?php echo $row_RCdanh_sach['dt_nha']; ?></td>
            <td align="left"><?php echo $row_RCdanh_sach['email']; ?></td>
            <td width="100" align="center" ><a href="index.php?require=cap_nhat_thong_tin_nhan_vien.php&catID=<?php echo $row_RCdanh_sach['ma_nhan_vien']; ?>&title=Thông tin nhân viên"><img src="images/user_edit.png" alt="Xem Hồ Sơ Cá Nhân" title="" border="0" /></a></td>
            <td width="100" align="center" ><a href="index.php?require=cap_nhat_thong_tin_cong_viec.php&catID=<?php echo $row_RCdanh_sach['ma_nhan_vien']; ?>&title=Thông tin công việc"><img src="images/user_edit.png" alt="Xem Hồ Sơ Công Ty" title="" border="0" /></a></td>
            <td width="50" align="center"><a href="#" onclick="ConfirmDelete()" class="delete" value="Xóa thông tin nhân viên"><img src="images/trash.png" alt="Xóa Thông tin nhân viên" title="" border="0" /></a></td> 
            <script type="text/javascript">
                function ConfirmDelete()
                {
                    if (confirm("Thao tác này sẽ không thể hoàn lại!"))
                        location.href='index.php?require=danh_sach_nhan_vien.php&catID=<?php echo $row_RCdanh_sach['ma_nhan_vien']; ?>&title=Danh sách nhân viên&action=del';
                }
            </script>
        </tr>
<?php } while ($row_RCdanh_sach = $mydb->fetch_assoc($result)); ?>

    <tfoot>
            <tr>
                <td colspan="8" class="rounded-foot-left"><em><p><b><u>Hướng Dẫn:</u></b> 
                                                            <br>&nbsp;+ Nhấn vào Mã Nhân Viên để xuất file thống kê
                                                            <br>&nbsp;&nbsp;&nbsp;&nbsp;- Trạng thái <img src="images/Available.png" alt="" title="" border="0" />: Đang làm việc
                                                            <br>&nbsp;&nbsp;&nbsp;&nbsp;- Trạng thái <img src="images/Offline.png" alt="" title="" border="0" />: Đã nghỉ việc 
                                                            <br>
                                                            <br>&nbsp;+ Nhấn vào Chi Tiết Nhân Viên để sửa thông tin về nhân viên
                                                            <br>&nbsp;+ Nhấn vào Chi Tiết Công Việc để sửa thông tin về công việc</p></em></td>
                <td class="rounded-foot-right">&nbsp;</td>

            </tr>
    </tfoot>
</table>