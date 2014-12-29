<?php require_once('includes/initialize.php'); ?>
<?php
$table = get_param('table');
$title = get_param('title');
$column = get_param('column');
$action = get_param('action');
//Thực hiện lệnh xoá nếu chọn xoá
if ($action=="del")
{
	$ma_nv = get_param('catID');
	$ma_column = $column . "_id";
	$deleteSQL = "DELETE FROM $table WHERE $ma_column='$ma_nv'";                     
	
    $mydb->setQuery($deleteSQL);
    $result_d = $mydb->executeQuery();

    $deleteGoTo = "them_danh_muc.php";
    if (isset($_SERVER['QUERY_STRING'])) {
        $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
        $deleteGoTo .= $_SERVER['QUERY_STRING'];
    }
    sprintf("location: %s", $deleteGoTo);
}

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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
    $insertSQL = sprintf("INSERT INTO $table VALUES (%s, %s)",
        GetSQLValueString($_POST['1'], "text"),
        GetSQLValueString($_POST['2'], "text"));

    $mydb->setQuery($insertSQL);
    $result_i = $mydb->executeQuery();

    $insertGoTo = "them_danh_muc.php";
    if (isset($_SERVER['QUERY_STRING'])) {
        $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
        $insertGoTo .= $_SERVER['QUERY_STRING'];
    }
    sprintf("location: %s", $insertGoTo);
}
?>

    <table width="800" border="0" cellspacing="1" cellpadding="0" align="center">
      <tr>
        <td class="row2" width="260" align="center" valign="top">
          <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
            <table width="255" align="center">
              <tr valign="baseline">
                <td nowrap="nowrap" align="right">Mã <?php echo $title?> :</td>
                <td><input type="text" name="1" value="" size="24" /></td>
            </tr>
            <tr valign="baseline">
                <td nowrap="nowrap" align="right">Tên <?php echo $title?> :</td>
                <td><input type="text" name="2" value="" size="24" /></td>
            </tr>
            <tr valign="baseline">
                <td nowrap="nowrap" align="right">&nbsp;</td>
                <td><input type="submit" value=":|: Thêm mới :|:" /></td>
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


    $mydb->setQuery("SELECT * FROM $table");
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
        <td><a href="index.php?require=cap_nhat_danh_muc.php&table=<?php echo $table; ?>&catID=<?php echo $row[0]; ?>&title=<?php echo $title; ?>&column=<?php echo $column; ?>&action=edit">Sửa</a></td>
        <td><a href="index.php?require=them_danh_muc.php&table=<?php echo $table; ?>&catID=<?php echo $row[0]; ?>&title=<?php echo $title; ?>&column=<?php echo $column; ?>&action=del">Xoá</a></td>
    </tr>
    <?php $stt = $stt + 1; ?>
    <?php }  ?>
</table></td>
</tr>
</table>

