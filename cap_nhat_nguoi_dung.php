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
        if (isset($_POST['permit'])) {
            $values = array();
            foreach ($chkbox as $selection) {
                if(in_array($selection, $_POST['permit'])) {
                    $values[$selection] = 1;
                }
                else {
                    $values[$selection] = 0;
                }
            }
        }
        else {
            $values = array();
            foreach ($chkbox as $selection) {
                $values[$selection] = 0;
            }
        }

        $password = md5(get_param('pass_confirmation'));
        $updateSQL = "UPDATE tlb_nguoidung SET mat_khau='{$password}', quyen_them='{$values['add']}', quyen_sua='{$values['edit']}', quyen_xoa='{$values['delete']}' WHERE id='{$user_id}'";
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
<!-- Check Permission Function -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#editUser').click(function(e) {
            e.preventDefault();
            var userID = '<?php echo $user_id; ?>';
            var oldPass = $("#old_password").val();
            $.ajax({
                type : 'POST',
                url  : 'includes/checker.php',
                data : {
                    action : 'old_pass_check',
                    userID : userID,
                    oldPass : oldPass
                },
                success: function(result){
                    if (result == 0) {
                        alert('Bạn không điền đúng mật khẩu cũ!');
                    }
                    else if (result > 0){
                        if (confirm("Bạn có chắc chắn thao tác cập nhật!!")){
                            update_user_form.submit();
                            return false;
                        }
                    }
                    else {
                        alert('Database error!!!');
                    }
                }
            });
        });
    });
</script>
<form action="<?php echo $editFormAction; ?>" method="post" name="update_user_form" id="update_user_form">
    <table id="rounded-corner" width="750" cellpadding="2" cellspacing="2" bgcolor="#66CCFF">
        <tr valign="baseline">
            <td nowrap="nowrap" align="right" width="300">Tên tài khoản:</td>
            <td style="color:red" colspan="2" width="450"><b><?php echo $row_RCDanhmuc_CN['ten_dang_nhap']; ?></b></td>
        </tr>
        <tr valign="baseline">
            <td nowrap="nowrap" align="right">Mật khẩu cũ:</td>
            <td colspan="2"><input type="password" name="old_password" id="old_password" value="<?php echo md5($row_RCDanhmuc_CN['mat_khau']); ?>" size="54" /></td>
        </tr>
        <tr valign="baseline">
            <td nowrap="nowrap" align="right">Mật khẩu mới:</td>
            <td colspan="2"><input type="password" name="pass_confirmation" id="pass_confirmation" value="" size="54" data-validation="length" data-validation-length="min4" data-validation-error-msg="Mật khẩu phải dài trên 4 ký tự"/></td>
        </tr>
        <tr valign="baseline">
            <td nowrap="nowrap" align="right">Xác nhận mật khẩu:</td>
            <td colspan="2"><input type="password" name="pass" id="pass" value="" size="54" data-validation="confirmation"/></td>
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
            <td colspan="3" align="right">
                <button class="btn btn-default" onclick="go_back()" >Quay lại</button>
                <input id="editUser" type="submit" class="btn btn-default" value="Cập nhật người dùng" />
            </td>
        </tr>
        <input type="hidden" name="MM_update" value="update_user_form" />
    </table>
</form>

<script type="text/javascript" src="js/jquery.min.js"></script>
<script src="js/form-validator/jquery.form-validator.min.js"></script>
<script src="js/form-validator/locale.vi.js"></script>
<script>
/* important to locate this script AFTER the closing form element, so form object is loaded in DOM before setup is called */
    $.validate({
        modules : 'security',
        language : enErrorDialogs
    });
</script>
<script>
    function go_back()
    {
        location.href='index.php?require=them_nguoi_dung.php&title=Người dùng';
    }
</script>

