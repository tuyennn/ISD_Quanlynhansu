<?php require_once('includes/initialize.php'); ?>
<?php
    $table = get_param('table');
    $title = get_param('title');
    $user_id = $_GET['catID'];

    $current_user = $_SESSION['user_name'];

    $chkbox = array('add', 'edit', 'delete');

    $checkSQL="SELECT quyen_them, quyen_sua, quyen_xoa FROM `tlb_nguoidung` WHERE ten_dang_nhap = '{$current_user}'";
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
                <td style="color:red"><b><?php echo $row_RCDanhmuc_CN['ten_dang_nhap']; ?></b></td>
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
                    function isChecked() {
                        # perform SQL query
                        $user_id = $_GET['catID'];
                        $chkboxstr = array('Thêm', 'Sửa', 'Xóa');
                        $chkbox = array('add', 'edit', 'delete');
                        $sql = mysql_query("SELECT quyen_them, quyen_sua, quyen_xoa FROM tlb_nguoidung WHERE id = '$user_id'");
                        $row_RCChecked = mysql_fetch_row($sql);
                        //var_dump($row_RCChecked);
                        # if value exists, set $exists to true
                        $values = array(1, 1, 1);
                        $i = 0;
                        foreach ($row_RCChecked as $selection) {
                            $checked = (in_array($selection, $values))?' checked="checked"':'';
                            echo '<input type="checkbox" name="permit[]" value="' .$chkbox[$i] .'"' .$checked .'><label>' .$chkboxstr[$i] .'</label><br/>';
                            $i++;
                        }
                    }
                ?>
                <td>
                    <?php echo isChecked(); ?>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <button class="btn btn-default" onclick="update_user_form.reset();">Quay lại</button>
                    <input type="submit" onClick="#" class="btn btn-default" name="submit" id="editUser" value="Cập nhật người dùng" />
                </td>
            </tr>
        <input type="hidden" name="MM_update" value="update_user_form" />
    </form>
</table>
