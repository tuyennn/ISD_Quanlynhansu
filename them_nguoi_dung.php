<?php require_once('includes/initialize.php'); ?>
<?php
    $title = get_param('title');
    $column = get_param('column');
    $action = get_param('action');

    $user_name = $_SESSION['user_name'];

    $checkSQL="SELECT quyen_them, quyen_sua, quyen_xoa FROM `tlb_nguoidung` WHERE ten_dang_nhap = '{$user_name}'";
    $mydb->setQuery($checkSQL);
    $RCCheckpermission = $mydb->executeQuery();
    $row_RCCheckpermission = $mydb->fetch_assoc($RCCheckpermission);
    $totalRows_RCcheckpermission = $mydb->num_rows($RCCheckpermission);

    //Thực hiện lệnh xoá nếu chọn xoá
    if ($action=="del" && $row_RCCheckpermission['quyen_xoa'] == 1)
    {
    	$ma_nv = $_GET['catID'];
    	$ma_column = $column . "id";
    	$deleteSQL = "DELETE FROM tlb_nguoidung WHERE $ma_column='$ma_nv'";                     
    	
        $mydb->setQuery($deleteSQL);
        $result_e = $mydb->executeQuery();
        if($result_e) {
            $message = "Thao tác xóa thành công!";
            echo "<script type='text/javascript'>alert('$message');</script>";
            $url = "index.php?require=them_nguoi_dung.php&title=Người dùng";
            location($url);
        }
        else {
            $message = "Thao tác xóa thất bại!";
            echo "<script type='text/javascript'>alert('$message');</script>";
            $url = "index.php?require=them_nguoi_dung.php&title=Người dùng";
            location($url);
        }

        $deleteGoTo = "them_danh_muc.php";
        if (isset($_SERVER['QUERY_STRING'])) {
            $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
            $deleteGoTo .= $_SERVER['QUERY_STRING'];
        }
        sprintf("location: %s", $deleteGoTo);
    }

    $editFormAction = htmlspecialchars($_SERVER["PHP_SELF"]);
    if (isset($_SERVER['QUERY_STRING'])) {
      $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
    }


    $them = get_param('3');if($them=="them"){$them=1;}else{$them=0;}
    $sua = get_param('4');if($sua=="sua"){$sua=1;}else{$sua=0;}
    $xoa = get_param('5');if($xoa=="them"){$xoa=1;}else{$xoa=0;}
    if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "new_user_form") && $row_RCCheckpermission['quyen_them'] == 1) {
        $insertSQL = sprintf("INSERT INTO tlb_nguoidung(id,ten_dang_nhap, mat_khau, quyen_them, quyen_sua, quyen_xoa) VALUES (NULL,'%s','%s','%s','%s','%s')",get_param('1'),md5(get_param('2')),$them,$sua,$xoa);
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

    }
?>
<table id="rounded-corner" width="750" cellpadding="2" cellspacing="2" bgcolor="#66CCFF">
    <tr>
        <td class="row2" width="260" align="center" valign="top">
            <form action="<?php echo $editFormAction; ?>" method="post" name="new_user_form" id="new_user_form">
                <table width="250" align="center">
                    <tr valign="baseline">
                        <td nowrap="nowrap" align="right">Tên tài khoản:</td>
                        <td><input type="text" name="1" value="" size="24" /></td>
                    </tr>
                    <tr valign="baseline">
                        <td nowrap="nowrap" align="right">Mật khẩu:</td>
                        <td><input type="password" name="2" value="" size="24" /></td>
                    </tr>
                    <tr valign="baseline">
                        <td nowrap="nowrap" align="right">Quyền hạn:</td>
                        <td>Thêm <input type="checkbox" name="3" value="them" /> Sửa <input type="checkbox" value="sua" name="4" /> Xóa <input type="checkbox" value="xoa" name="5" /></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <a href="#" onclick="ConfirmCreate()" class="bt_green"><span class="bt_green_lft"></span><strong>Thêm mới</strong><span class="bt_green_r"></span></a>
                            <script type="text/javascript">
                            function ConfirmCreate()
                            {   
                                var addpermission = <?php echo $row_RCCheckpermission['quyen_them']; ?>;
                                if (addpermission == 0) {
                                    alert('Bạn không có quyền thêm tài khoản người dùng!');
                                }
                                if (addpermission == 1) {
                                    if (confirm("Bạn có chắc chắn thao tác thêm mới!"))
                                    {
                                        new_user_form.submit();
                                        return false;
                                    }
                                }
                            }
                            </script>
                        </td>
                    </tr>
                </table>
                <input type="hidden" name="MM_insert" value="new_user_form" />
            </form>
        </td>
            <td class="row2" width="460" valign="top"><table width="460" border="0" cellspacing="1" cellpadding="1">
                <thead>
                    <tr>
                        <th width="25" class="rounded-content">STT</th>
                        <th width="100">Mã</th>
                        <th width="200">Tài khoản</th>
                        <th width="100" colspan="2" align="center" class="rounded-q4">Thao tác</th>
                    </tr>
                </thead>
                <?php
                    $mydb->setQuery("SELECT id, ten_dang_nhap FROM tlb_nguoidung");
                    $RCDanhmuc_TM = $mydb->executeQuery();
                    $totalRows_RCDanhmuc_TM = $mydb->num_rows($RCDanhmuc_TM);
                ?>
                <?php 
                $stt = 1;
                while ($row = mysql_fetch_row($RCDanhmuc_TM)) {?>
                <tr>
                    <td align="center"><?php echo $stt;?></td>
                    <td><?php echo sprintf("%03d", $row[0]); ?></td>
                    <td><?php echo $row[1]; ?></td>
                    <td align="center">
                        <a href="#" onclick="ConfirmEdit()" value="Sửa tài khoản người dùng">
                            <?php
                                echo '<img src="images/user_edit.png" alt="Sửa" title="" border="0" />';
                            ?>
                        </a>
                        <script type="text/javascript">
                            function ConfirmEdit()
                            {   
                                var editpermission = <?php echo $row_RCCheckpermission['quyen_sua']; ?>;
                                if (editpermission == 0) {
                                    alert('Bạn không có quyền sửa tài khoản người dùng!');
                                }
                                if (editpermission == 1) {
                                    location.href='index.php?require=cap_nhat_nguoi_dung.php&table=tlb_nguoidung&catID=<?php echo $row[0]; ?>&title=<?php echo $title; ?>&column=<?php echo $column; ?>&action=edit';
                                }
                            }
                        </script>
                    </td>

                    <td align="center">
                        <a href="#" onclick="ConfirmDelete()" value="Xóa tài khoản người dùng">
                            <?php
                                echo '<img src="images/trash.png" alt="Xóa" title="" border="0" />';
                            ?>
                        </a>

                        <script type="text/javascript">
                            function ConfirmDelete()
                            {   
                                var delpermission = <?php echo $row_RCCheckpermission['quyen_xoa']; ?>;
                                if (delpermission == 0) {
                                    alert('Bạn không có quyền xóa tài khoản người dùng!');
                                }
                                if (delpermission == 1) {
                                    if (confirm("Bạn có chắc chắn thao tác xóa!!"))
                                    {
                                        location.href='index.php?require=them_nguoi_dung.php&table=tlb_nguoidung&catID=<?php echo $row[0]; ?>&title=<?php echo $title; ?>&column=<?php echo $column; ?>&action=del';
                                    }
                                }
                            }
                        </script>
                    </td>
                </tr>
                <?php $stt = $stt + 1; ?>
                <?php }  ?>
            </table>
        </td>
    </tr>
</table>
