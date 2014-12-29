<?php

    $mydb->setQuery("SELECT * FROM tlb_tailieu");
    $RCtailieu = $mydb->executeQuery();
    $row_RCtailieu = $mydb->fetch_assoc($RCtailieu);
    $totalRows_RCtailieu = $mydb->num_rows($RCtailieu);



?>
<!--MAIN UP CONTENT -->
    <div class="detail_up">
        

  
    <?php
        if ($totalRows_RCtailieu<>0)
        {
    ?>
        <table id="rounded-corner" summary="Bảng Thống Kê Tài Liệu Công Ty" >
            <thead>
                <tr>
                    <th width="30" rowspan="2" align="center" class="rounded-company"></th>
                    <th width="30" rowspan="2" align="left">MÃ</th>
                    <th width="320" rowspan="2" align="left">TÊN TÀI LIỆU</th>
                    <th width="120" rowspan="2" align="left">KÍCH CỠ</th>
                    <th colspan="3" align="center" class="rounded-q4">THAO TÁC</th>
                </tr>

                <tr>
                    <td align="center" bgcolor="#CC0000">Sửa</td>
                    <td align="center" bgcolor="#CC0000">Xóa</td>
                    <td width="100" align="center" bgcolor="#CC0000">Tải Về</td>
                </tr>
            </thead>
    <?php do { ?>
            <tr class="row">
                <td width="30" align="center"></th>
                <td width="30" align="left"><?php echo $row_RCtailieu['id']; ?></td>
                <td align="left"><?php echo $row_RCtailieu['title']; ?></td>
                <td align="left"><?php echo $row_RCtailieu['size']; ?> bytes</td>
                <td width="50" align="center" ><a href="index.php?require=them_moi_tai_lieu.php&catID=<?php echo $row_RCtailieu['id']; ?>&title=Quản lý tài liệu"><img src="images/user_edit.png" alt="Sửa tài liệu" title="Sửa tài liệu" border="0" /></a></td>
                <td width="50" align="center"><a href="#" onclick="ConfirmDelete()" value="Xóa thông tin nhân viên"><img src="images/trash.png" alt="Xóa Tài Liệu" title="Xóa Tài Liệu" border="0" /></a></td>
                    <script type="text/javascript">
                        function ConfirmDelete()
                        {
                            if (confirm("Bạn có chắc chắn thao tác xóa?"))
                                location.href='index.php?require=them_moi_tai_lieu.php&catID=<?php echo $row_RCtailieu['id']; ?>&title=Quản lý tài liệu&action=del';
                        }
                    </script>
                <td width="50" align="center" ><a href="index.php?require=them_moi_tai_lieu.php&catID=<?php echo $row_RCtailieu['id']; ?>&title=Quản lý tài liệu"><img src="images/download.png" alt="Tải về tài liệu" title="Tải về tài liệu" border="0" /></a></td>
            </tr>
        <?php } while ($row_RCtailieu = $mydb->fetch_assoc($RCtailieu)); ?>

            <tfoot>
                <tr>
                    <td colspan="6" class="rounded-foot-left"><em><p><b><u>Hướng Dẫn:</u></b> 
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
            }
            else {
            ?>
                <table id="rounded-corner" border="0" width="460" align="center" cellpadding="1" cellspacing="1">
                <span><h4>Chưa có tài liệu được tải lên, mời thêm mới...</h4></span>
                </table>
        <?php
            }
        ?>
    </div>

    <!--MAIN BOTTOM CONTENT -->

    <div class="detail_bottom">
        <form enctype="multipart/form-data" action="them_moi_tailieu.php" method="post" name="new_document_form" id="new_document_form">
            <table id="rounded-corner" width="750" align="center">
                <tr valign="baseline">
                    <td nowrap="nowrap" align="left" colspan="3">Tên tài liệu:</td>
                    <td><input type="text" name="ten_tailieu" value="" size="100" /></td>
                </tr>

                <tr>
                    <td colspan="4">
                        <a href="#" onclick="ConfirmCreate()" class="bt_green"><span class="bt_green_lft"></span><strong>Tải lên</strong><span class="bt_green_r"></span></a>
                        <input type="file" name="upload_file" />
                        <input type="submit" name="submit" value="Create">
                        <script type="text/javascript">
                        function ConfirmCreate()
                        {
                            if (confirm("Bạn có chắc chắn thao tác thêm mới!"))
                            {
                                new_document_form.submit();
                                return false;
                            }  
                        }
                        </script>
                    </td>
                </tr>
            </table>
            <input type="hidden" name="MM_insert" value="new_document_form" />
        </form>
    </div>