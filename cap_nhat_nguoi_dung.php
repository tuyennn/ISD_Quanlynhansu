<?php require_once('includes/initialize.php'); ?>
<?php
    $table = get_param('table');
    $title = get_param('title');
    $user_id = $_GET['catID'];
    $user_name = $_SESSION['user_name'];

    $chkbox = array('add', 'edit', 'delete');

    $checkSQL="SELECT quyen_them, quyen_sua, quyen_xoa FROM `tlb_nguoidung` WHERE ten_dang_nhap = '{$user_name}'";
    $mydb->setQuery($checkSQL);
    $RCCheckpermission = $mydb->executeQuery();
    $row_RCCheckpermission = $mydb->fetch_assoc($RCCheckpermission);
    $totalRows_RCcheckpermission = $mydb->num_rows($RCCheckpermission);

    if($row_RCCheckpermission['quyen_sua'] == 0) {
        $message = "Truy cập không cho phép!";
        echo "<script type='text/javascript'>alert('$message');</script>";
        $url = "index.php?require=them_nguoi_dung.php&title=Người dùng";
        location($url);
    }

    $editFormAction = htmlspecialchars($_SERVER["PHP_SELF"]);
    if (isset($_SERVER['QUERY_STRING'])) {
        $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
    }

    if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "update_user_form")) {
        $updateSQL = sprintf("UPDATE $table SET $ten_column=%s WHERE $ma_column=%s", $_POST['2'], $_POST['1']);
        $mydb->setQuery($updateSQL);
        $result = $mydb->executeQuery();
    }
    
    $mydb->setQuery("SELECT * FROM $table");
    $RCDanhmuc_DS = $mydb->executeQuery();
    $row_RCDanhmuc_DS = $mydb->fetch_assoc($RCDanhmuc_DS);
    $totalRows_RCDanhmuc_DS = $mydb->num_rows($RCDanhmuc_DS);


    $mydb->setQuery("SELECT * FROM tlb_nguoidung where id = '$user_id'");
    $RCDanhmuc_CN = $mydb->executeQuery();
    $row_RCDanhmuc_CN = $mydb->fetch_assoc($RCDanhmuc_CN);
    $totalRows_RCDanhmuc_CN = $mydb->num_rows($RCDanhmuc_CN);

?>

<table id="rounded-corner" width="750" cellpadding="2" cellspacing="2" bgcolor="#66CCFF">
    <form action="<?php echo $editFormAction; ?>" method="post" name="update_user_form" id="update_user_form">
            <tr valign="baseline">
                <td nowrap="nowrap" align="right">Tên tài khoản:</td>
                <td><input type="text" name="1" value="<?php echo $row_RCDanhmuc_CN['ten_dang_nhap']; ?>" size="24" /></td>
            </tr>
            <tr valign="baseline">
                <td nowrap="nowrap" align="right">Mật khẩu cũ:</td>
                <td><input type="password" name="2" value="<?php echo $row_RCDanhmuc_CN['mat_khau']; ?>" size="24" /></td>
            </tr>
            <tr valign="baseline">
                <td nowrap="nowrap" align="right">Mật khẩu mới:</td>
                <td><input type="password" name="3" value="" size="24" /></td>
            </tr>
            <tr valign="baseline">
                <td nowrap="nowrap" align="right">Xác nhận mật khẩu:</td>
                <td><input type="password" name="4" value="" size="24" /></td>
            </tr>
            <tr valign="baseline">
                <td nowrap="nowrap" align="right">Quyền hạn:</td>
                <?php
                    /*
                    function isChecked($user_id) {
                        # perform SQL query
                        $chkbox = array('add', 'edit', 'delete');
                        $sql = mysql_query("SELECT quyen_them, quyen_sua, quyen_xoa FROM tlb_nguoidung where id = '$user_id'");
                        $row_RCChecked = mysql_fetch_row($sql);
                        # if value exists, set $exists to true
                        $values = array();
                        foreach ($chkbox as $selection) {
                            $checked = (in_array($selection, $row_RCChecked))?' checked="checked"':'';
                            echo $checked;
                        }
                    }
                    */ 
                ?>
                <td>
                    <input type="checkbox" <?php //echo isChecked($user_id) ?> name="permit[]" value="add"><label><?php //echo isChecked($user_id) ?>Thêm</label><br/>
                    <input type="checkbox" <?php //echo isChecked($user_id) ?> name="permit[]" value="edit"><label><?php //echo isChecked($user_id) ?>Sửa</label><br/>
                    <input type="checkbox" name="permit[]" value="delete"><label><?php //echo isChecked($user_id) ?>Xóa</label><br/>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <a href="#" onclick="ConfirmUpdate()" class="bt_green"><span class="bt_green_lft"></span><strong>Thêm mới</strong><span class="bt_green_r"></span></a>
                    <script type="text/javascript">
                    function ConfirmUpdate()
                    {   
                        var addpermission = <?php echo $row_RCCheckpermission['quyen_them']; ?>;
                        if (addpermission == 0) {
                            alert('Bạn không có quyền thêm tài khoản người dùng!');
                        }
                        if (addpermission == 1) {
                            if (confirm("Bạn có chắc chắn thao tác thêm mới!"))
                            {
                                update_user_form.submit();
                                return false;
                            }
                        }
                    }
                    </script>
                </td>
            </tr>
        <input type="hidden" name="MM_update" value="update_user_form" />
    </form>
</table>
