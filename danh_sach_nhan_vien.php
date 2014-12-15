<?php
$keyword = get_param('keyword');
$mydb->setQuery("SELECT * FROM tlb_nhanvien");
if($keyword!=''){
    $mydb->setQuery("SELECT * FROM tlb_nhanvien WHERE ho_ten LIKE '%".$keyword."%'");
}


$result = $mydb->executeQuery();
$row_RCdanh_sach = $mydb->fetch_assoc($result);
$totalRows_RCdanh_sach = $mydb->num_rows($result);
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
            <th colspan="2" align="center">THÔNG TIN</th>
            <th width="30" rowspan="2" align="center" class="rounded-q4">XÓA</th>
        </tr>

        <tr>
            <td align="center" bgcolor="#CC0000">Nhân viên</td>
            <td align="center" bgcolor="#CC0000">Công việc</td>
        </tr>
    </thead>
<?php do { ?>
        <tr class="row">
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
            <td width="100" align="center" ><a href="index.php?require=cap_nhat_thong_tin_nhan_vien.php&catID=<?php echo $row_RCdanh_sach['ma_nhan_vien']; ?>&title=Thông tin nhân viên"><img src="images/user_edit.png" alt="Xóa" title="" border="0" /></a></td>
            <td width="100" align="center" ><a href="index.php?require=cap_nhat_thong_tin_cong_viec.php&catID=<?php echo $row_RCdanh_sach['ma_nhan_vien']; ?>&title=Thông tin công việc"><img src="images/user_edit.png" alt="Xóa" title="" border="0" /></a></td>
            <td width="50" align="center"><a href="chi_tiet_nhan_vien.php?catID=<?php echo $row_RCdanh_sach['ma_nhan_vien']; ?>">
                <?php 
                    echo '<img src="images/trash.png" alt="Xóa" title="" border="0" />';
                ?>
                </a>
            </td>
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