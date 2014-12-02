<?php
$keyword = get_param('keyword');
mysql_select_db($database_Myconnection, $Myconnection);
$query_RCdanh_sach = "SELECT * FROM tlb_nhanvien";
if($keyword!=''){
	$query_RCdanh_sach .= " WHERE ho_ten LIKE '%".$keyword."%'";
}

$RCdanh_sach = mysql_query($query_RCdanh_sach, $Myconnection) or die(mysql_error());
$row_RCdanh_sach = mysql_fetch_assoc($RCdanh_sach);
$totalRows_RCdanh_sach = mysql_num_rows($RCdanh_sach);
?>

<!--SEARCH BOX-->
<!--   
<div style="padding:10px; text-align:right;">
  <form name="fsearch">
    <input type="text" name="keyword" value="" />
    <input type="submit" value="Tìm kiếm" />
</form>
</div>
-->
<?php
if($keyword!=''){
	echo '<div id="tieude2">Kết quả tìm nhân viên có chứa từ khóa tìm kiếm "'.$keyword.'"</div>';
    echo '<br>';
}
?>
<table id="rounded-corner" summary="Bảng Thống Kê Nhân Viên Chính" >
    <thead>
        <tr>
            <th width="50" rowspan="2" align="center" class="rounded-company">TRẠNG THÁI</th>
            <th width="30" rowspan="2" align="center">MÃ</th>
            <th width="260" rowspan="2" align="center">HỌ VÀ TÊN</th>
            <th width="90" rowspan="2" align="center">ĐT DI ĐỘNG</th>
            <th width="90" rowspan="2" align="center">ĐT NHÀ</th>
            <th width="150" rowspan="2" align="center">EMAIL</th>
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
            <td class="row1" width="50" align="center">
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
            <td class="row1" width="30" align="left"><a href="chi_tiet_nhan_vien.php?catID=<?php echo $row_RCdanh_sach['ma_nhan_vien']; ?>"><?php echo $row_RCdanh_sach['ma_nhan_vien']; ?></a></td>
            <td class="row1" align="left"><?php echo $row_RCdanh_sach['ho_ten']; ?></td>
            <td class="row1" align="left"><?php echo $row_RCdanh_sach['dt_di_dong']; ?></td>
            <td class="row1" align="left"><?php echo $row_RCdanh_sach['dt_nha']; ?></td>
            <td class="row1" align="left"><?php echo $row_RCdanh_sach['email']; ?></td>
            <td class="row1" width="100" align="center" ><a href="index.php?require=cap_nhat_thong_tin_nhan_vien.php&catID=<?php echo $row_RCdanh_sach['ma_nhan_vien']; ?>&title=Thông tin nhân viên"><img src="images/user_edit.png" alt="Xóa" title="" border="0" /></a></td>
            <td class="row1" width="100" align="center" ><a href="index.php?require=cap_nhat_thong_tin_cong_viec.php&catID=<?php echo $row_RCdanh_sach['ma_nhan_vien']; ?>&title=Thông tin công việc"><img src="images/user_edit.png" alt="Xóa" title="" border="0" /></a></td>
            <td class="row1" width="50" align="center"><a href="chi_tiet_nhan_vien.php?catID=<?php echo $row_RCdanh_sach['ma_nhan_vien']; ?>">
                <?php 
                    echo '<img src="images/trash.png" alt="Xóa" title="" border="0" />';
                ?>
                </a>
            </td>
        </tr>
<?php } while ($row_RCdanh_sach = mysql_fetch_assoc($RCdanh_sach)); ?>

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

<?php
mysql_free_result($RCdanh_sach);
?>
