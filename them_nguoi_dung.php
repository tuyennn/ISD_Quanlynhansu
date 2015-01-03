<?php require_once('includes/initialize.php'); ?>
<?php
$title = get_param('title');
$column = get_param('column');
$action = get_param('action');
//Thực hiện lệnh xoá nếu chọn xoá
if ($action=="del")
{
	$ma_nv = $_GET['catID'];
	$ma_column = $column . "_id";
	$deleteSQL = "DELETE FROM tlb_nguoidung WHERE $ma_column='$ma_nv'";                     
	
    $mydb->setQuery($deleteSQL);
    $result_e = $mydb->executeQuery();

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
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO tlb_nguoidung(id,ten_dang_nhap, mat_khau, quyen_them, quyen_sua, quyen_xoa) VALUES (NULL,'%s','%s','%s','%s','%s')",get_param('1'),md5(get_param('2')),$them,$sua,$xoa);
  $mydb->setQuery($insertSQL);
  $result = $mydb->executeQuery();

}
?>
<table width="800" border="0" cellspacing="1" cellpadding="0" align="center">
    <tr>
        <td class="row2" width="260" align="center" valign="top">
            <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
                <table width="255" align="center">
                    <tr valign="baseline">
                        <td nowrap="nowrap" align="right">Tên <?php echo $title?> :</td>
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
                    <tr valign="baseline">
                        <td nowrap="nowrap" align="right">&nbsp;</td>
                        <td><input type="submit" value="Thêm mới" /></td>
                    </tr>
                </table>
                <input type="hidden" name="MM_insert" value="form1" />
            </form>
            <p>&nbsp;</p></td>
            <td class="row2" width="500" valign="top"><table width="500" border="0" cellspacing="1" cellpadding="1">
                <tr>
                    <th width="25">Stt</th>
                    <th width="120">Mã <?php echo $title?></th>
                    <th width="230">Tên <?php echo $title?></th>
                    <th width="35">&nbsp;</th>
                    <th width="35">&nbsp;</th>
                </tr>
                <?php
                $mydb->setQuery("SELECT id, ten_dang_nhap FROM tlb_nguoidung");
                $RCDanhmuc_TM = $mydb->executeQuery();
                $totalRows_RCDanhmuc_TM = $mydb->num_rows($RCDanhmuc_TM);
                ?>
                <?php 
                $stt =1;
                while ($row = mysql_fetch_row($RCDanhmuc_TM)) {?>
                <tr>
                    <td><?php echo $stt;?></td>
                    <td><?php echo $row[0]; ?></td>
                    <td><?php echo $row[1]; ?></td>
                    <td><a href="index.php?require=cap_nhat_nguoi_dung.php&table=tlb_nguoidung&catID=<?php echo $row[0]; ?>&title=<?php echo $title; ?>&column=<?php echo $column; ?>&action=edit">Sửa</a></td>
                    <td><a href="index.php?require=them_nguoi_dung.php&table=tlb_nguoidung&catID=<?php echo $row[0]; ?>&title=<?php echo $title; ?>&column=<?php echo $column; ?>&action=del">Xoá</a></td>
                </tr>
                <?php $stt = $stt + 1; ?>
                <?php }  ?>
            </table></td>
        </tr>
    </table>
