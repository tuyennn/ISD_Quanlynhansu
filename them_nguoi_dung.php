<?php 
    require_once('includes/initialize.php'); 
    require_once('includes/functions.php');
?>

<?php
    $title = get_param('title');
    $action = get_param('action');
    $user_name = $_SESSION['user_name'];

    $chkbox = array('add', 'edit', 'delete');

    $checkSQL="SELECT quyen_them, quyen_sua, quyen_xoa FROM `tlb_nguoidung` WHERE ten_dang_nhap = '{$user_name}'";
    $mydb->setQuery($checkSQL);
    $RCCheckpermission = $mydb->executeQuery();
    $row_RCCheckpermission = $mydb->fetch_assoc($RCCheckpermission);
    $totalRows_RCcheckpermission = $mydb->num_rows($RCCheckpermission);

    //Thực hiện lệnh xoá nếu chọn xoá
    if ($action=="del" && $row_RCCheckpermission['quyen_xoa'] == 1)
    {
    	$user = $_GET['catID'];
    	$deleteSQL = "DELETE FROM tlb_nguoidung WHERE id='$user'";                     
    	
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

    if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "new_user_form") && $row_RCCheckpermission['quyen_them'] == 1) {
        $permit = $_POST['permit'];
        $values = array();
        foreach ($chkbox as $selection) {
            if(in_array($selection, $permit)) {
                $values[$selection] = 1;
            }
            else {
                $values[$selection] = 0;
            }
        }
        $insertSQL = sprintf("INSERT INTO tlb_nguoidung(ten_dang_nhap, mat_khau, quyen_them, quyen_sua, quyen_xoa) VALUES ('%s', '%s', '{$values['add']}', '{$values['edit']}', '{$values['delete']}')", get_param('1'), md5(get_param('2')));
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
                        <td>
                            <input type="checkbox" name="permit[]" value="add"><label>Thêm</label><br/>
                            <input type="checkbox" name="permit[]" value="edit"><label>Sửa</label><br/>
                            <input type="checkbox" name="permit[]" value="delete"><label>Xóa</label><br/>
                        </td>
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
                    $row_RCDanhmuc_TM = $mydb->fetch_assoc($RCDanhmuc_TM);
                    $totalRows_RCDanhmuc_TM = $mydb->num_rows($RCDanhmuc_TM);
                ?>
                

                <?php 
                $stt = 1;
                $quyen_sua = $row_RCCheckpermission['quyen_sua'];
                $catID = $row_RCDanhmuc_TM['id'];

                echo $quyen_sua;

                do { ?>
                    <tr>
                        <td align="center"><?php echo $stt;?></td>
                        <td><?php echo sprintf("%03d", $row_RCDanhmuc_TM['id']); ?></td>
                        <td><?php echo $row_RCDanhmuc_TM['ten_dang_nhap']; ?></td>
                        <td align="center">
                            <a href="#" value="Sửa tài khoản người dùng">
                                <img src="images/user_edit.png" class="editbutton" alt="Sửa" title="" border="0" />
                            </a>
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
                                            location.href='index.php?require=them_nguoi_dung.php&table=tlb_nguoidung&catID=<?php echo $row_RCDanhmuc_TM['id']; ?>&title=<?php echo $title; ?>&action=del';
                                        }
                                    }
                                }
                            </script>
                        </td>
                    </tr>
                <?php 
                $stt++;
                    } while ($row_RCDanhmuc_TM = $mydb->fetch_assoc($RCDanhmuc_TM)); ?>
            </table>
        </td>
    </tr>
</table>
