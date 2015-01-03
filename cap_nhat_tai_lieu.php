
<?php require_once('includes/initialize.php');

    $id = $_GET['catID'];

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

    if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "update_document_form")) {
        $currentDate = date("Y-m-d");
        $updateSQL = sprintf("UPDATE tlb_tailieu SET title=%s, ngay_sua='{$currentDate}' WHERE id='{$id}'",
            GetSQLValueString($_POST['ten_tai_lieu'], "text"));

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

        $updateGoTo = "them_moi_tai_lieu.php";
        if (isset($_SERVER['QUERY_STRING'])) {
            $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
            $updateGoTo .= $_SERVER['QUERY_STRING'];
        }
        sprintf("location: %s", $updateGoTo);
    }

    $mydb->setQuery("SELECT * FROM tlb_tailieu");
    $RCtailieu_DS = $mydb->executeQuery();
    $row_RCtailieu_DS = $mydb->fetch_assoc($RCtailieu_DS);
    $totalRows_RCtailieu_DS = $mydb->num_rows($RCtailieu_DS);

?>

<!--MAIN UP CONTENT -->
    <div class="detail_up">
        

  
    <?php
        if ($totalRows_RCtailieu_DS<>0)
        {
    ?>
        <table id="rounded-corner" summary="Bảng Thống Kê Tài Liệu Công Ty" >
            <thead>
                <tr>
                    <th width="30" rowspan="2" align="center" class="rounded-content">MÃ</th>
                    <th width="380" rowspan="2" align="left">TÊN TÀI LIỆU</th>
                    <th width="120" rowspan="2" align="left">KÍCH CỠ</th>
                    <th width="80" rowspan="2" align="left">NGÀY TẠO</th>
                    <th width="80" rowspan="2" align="left">NGÀY SỬA</th>
                    <th width="160" colspan="2" align="center" class="rounded-q4">THAO TÁC</th>
                </tr>

                <tr>
                    <td align="center" bgcolor="#CC0000">Xóa</td>
                    <td width="80" align="center" bgcolor="#CC0000">Tải Về</td>
                </tr>
            </thead>
    <?php do { ?>
            <tr>
                <td width="30" align="center"><?php echo sprintf("%03d", $row_RCtailieu_DS['id']); ?></td>
                <td align="left"><?php echo $row_RCtailieu_DS['title']; ?></td>
                <td align="left"><?php echo $row_RCtailieu_DS['size']; ?> bytes</td>
                <td align="left"><?php echo htmlentities(date("d/m/Y", strtotime($row_RCtailieu_DS['ngay_tao'])), ENT_COMPAT, 'utf-8'); ?></td>
                <td align="left"><?php echo htmlentities(date("d/m/Y", strtotime($row_RCtailieu_DS['ngay_sua'])), ENT_COMPAT, 'utf-8'); ?></td>
                <td width="50" align="center"><a href="#" onclick="ConfirmDelete()" value="Xóa thông tin nhân viên"><img src="images/trash.png" alt="Xóa Tài Liệu" title="Xóa Tài Liệu" border="0" /></a></td>
                    <script type="text/javascript">
                        function ConfirmDelete()
                        {
                            if (confirm("Bạn có chắc chắn thao tác xóa?"))
                                location.href='index.php?require=them_moi_tai_lieu.php&catID=<?php echo $row_RCtailieu_DS['id']; ?>&title=Quản lý tài liệu&action=del';
                        }
                    </script>
                <td width="50" align="center" ><a href="index.php?require=them_moi_tai_lieu.php&catID=<?php echo $row_RCtailieu_DS['id']; ?>&title=Quản lý tài liệu"><img src="images/download.png" alt="Tải về tài liệu" title="Tải về tài liệu" border="0" /></a></td>
            </tr>
        <?php } while ($row_RCtailieu_DS = $mydb->fetch_assoc($RCtailieu_DS)); ?>

            <tfoot>
                <tr>
                    <td colspan="6" class="rounded-foot-left">
                        <em><p><b><u>Hướng Dẫn:</u></b> 
                            <br>&nbsp;+ Sửa lại tên tài liệu trong mục Tên tài liệu
                            <br>&nbsp;+ Thao tác Đồng ý khi đã hoàn tất việc sửa chữa.
                            <br>&nbsp;+ Nhấn vào nút Xóa trên thanh Thao tác để xóa dữ liệu
                            <br>&nbsp;+ Nhấn vào nút Tải về trên thanh Thao tác để tải về dữ liệu</p>
                        </em></td>
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
    <?php
        $mydb->setQuery("SELECT * FROM tlb_tailieu WHERE id= $id");
        $RCTailieu_CN = $mydb->executeQuery();
        $row_RCTailieu_CN= $mydb->fetch_assoc($RCTailieu_CN);
        $totalRows_RRCTailieu_CN = $mydb->num_rows($RCTailieu_CN);
    ?>

    <div class="detail_bottom">
        <form action="<?php echo $editFormAction; ?>" method="post" name="update_document_form" id="update_document_form">
            <table id="rounded-corner" width="750" align="center">
                <tr valign="baseline">
                    <td width="150">Mã tài liệu: <b><?php echo $id; ?></b></td>
                    <td nowrap="nowrap" align="right">Tên tài liệu:</td>
                    <td><input type="text" name="ten_tai_lieu" value="<?php echo htmlentities($row_RCTailieu_CN['title'], ENT_COMPAT, 'utf-8'); ?>" size="100" /></td>
                </tr>

                <tr>
                    <td colspan="4">
                        <a href="#" onclick="ConfirmEdit()" class="bt_green"><span class="bt_green_lft"></span><strong>Đồng ý</strong><span class="bt_green_r"></span></a>
                        <a href="#" onclick="go_back()" class="bt_blue"><span class="bt_blue_lft"></span><strong>Quay lại</strong><span class="bt_blue_r"></span></a>
                        <script type="text/javascript">
                            function go_back()
                                {
                                    location.href='index.php?require=them_moi_tai_lieu.php&title=Quản lý tài liệu';
                                }
                            function ConfirmEdit()
                            {
                                if (confirm("Bạn có chắc chắn thao tác cập nhật!"))
                                {
                                    update_document_form.submit();
                                    return false;
                                }  
                            }
                        </script>
                    </td>
                </tr>
            </table>
            <input type="hidden" name="MM_update" value="update_document_form" />
            <input type="hidden" name="id" value="<?php echo $row_RCtailieu['id']; ?>" />
        </form>
    </div>