<?php require_once('includes/initialize.php'); ?>
<?php
    $table = get_param('table');
    $title = get_param('title');
    $ma_nv = get_param('catID');
    $column = get_param('column');
    $ma_column = $column . "id";
    $ten_column = "ten_dang_nhap" . $column;
    $action = get_param('action');

    $user_name = $_SESSION['user_name'];

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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
    $updateSQL = sprintf("UPDATE $table SET $ten_column=%s WHERE $ma_column=%s", $_POST['2'], $_POST['1']);
    $mydb->setQuery($updateSQL);
    $result = $mydb->executeQuery();
}
$mydb->setQuery("SELECT * FROM $table");
$RCDanhmuc_DS = $mydb->executeQuery();
$row_RCDanhmuc_DS = $mydb->fetch_assoc($RCDanhmuc_DS);
$totalRows_RCDanhmuc_DS = $mydb->num_rows($RCDanhmuc_DS);
?>
<table width="800" border="0" cellspacing="1" cellpadding="0" align="center">
    <tr>
        <td class="row2" width="500" valign="top">
            <table width="500" border="0" cellspacing="1" cellpadding="1">
                <tr>
                    <th width="25">Stt</th>
                    <th width="100">Mã <?php echo $title?></th>
                    <th width="210">Tên <?php echo $title?></th>
                    <th width="35">&nbsp;</th>
                    <th width="35">&nbsp;</th>
                    <th width="35">&nbsp;</th>
                </tr>
    <?php
       $stt = 1;
    do {    ?>
                <tr>
                    <td><?php echo $stt; ?></td>
                    <td><?php echo $row_RCDanhmuc_DS[$ma_column]; ?></td>
                    <td><?php echo $row_RCDanhmuc_DS[$ten_column]; ?></td>
                    <td><a href="index.php?require=them_danh_muc.php&table=<?php echo $table; ?>&title=<?php echo $title; ?>&column=<?php echo $column; ?>&action=new">Thêm</a></td>
                    <td><a href="index.php?require=cap_nhat_danh_muc.php&table=<?php echo $table; ?>&catID=<?php echo $row_RCDanhmuc_DS[$ma_column]; ?>&title=<?php echo $title; ?>&column=<?php echo $column; ?>">Sửa</a></td>
                    <td><a href="index.php?require=cap_nhat_danh_muc.php&table=<?php echo $table; ?>&catID=<?php echo $row_RCDanhmuc_DS[$ma_column]; ?>&title=<?php echo $title; ?>&column=<?php echo $column; ?>&action=del">Xoá</a></td>
              </tr>
    <?php 
        $stt = $stt + 1; 
    ?>
    <?php } while ($row_RCDanhmuc_DS = $mydb->fetch_assoc($RCDanhmuc_DS)); ?>
            </table>
        </td>
        <td class="row2" width="260" align="center" valign="top">
    <?php
        $mydb->setQuery("SELECT * FROM $table where $ma_column = '$ma_nv'");
        $RCDanhmuc_CN = $mydb->executeQuery();
        $row_RCDanhmuc_CN = $mydb->fetch_assoc($RCDanhmuc_CN);
        $totalRows_RCDanhmuc_CN = $mydb->num_rows($RCDanhmuc_CN);
    ?>
            <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
                <table width="260" align="center">
                    <tr valign="baseline">
                        <td nowrap="nowrap" align="right">Mã <?php echo $title?> :</td>
                        <td><input type="text" name="1" value="<?php echo $row_RCDanhmuc_CN[$ma_column]; ?>" readonly="readonly" size="24" /></td>
                    </tr>
                    <tr valign="baseline">
                        <td nowrap="nowrap" align="right">Tên <?php echo $title?> :</td>
                        <td><input type="text" name="2" value="<?php echo $row_RCDanhmuc_CN[$ten_column]; ?>" size="24" /></td>
                    </tr>
                    <tr valign="baseline">
                        <td nowrap="nowrap" align="right">&nbsp;</td>
                        <td><input type="submit" value=":|: Cập nhật :|:" /></td>
                    </tr>
                </table>
            <input type="hidden" name="MM_update" value="form1" />
            </form>
        </td>
    </tr>
</table>
