<?php require_once('includes/initialize.php'); ?>
<?php
    $table = get_param('table');
    $title = get_param('title');
    $ma_nv = get_param('catID');
    $column = get_param('column');
    $ma_column = $column . "_id";
    $ten_column = "ten_" . $column;
    $action = get_param('action');

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

    if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "update_cat_form")) {
        $updateSQL = sprintf("UPDATE $table SET $ten_column=%s WHERE $ma_column=%s",
            GetSQLValueString($_POST['2'], "text"),
            GetSQLValueString($_POST['1'], "text"));

        $mydb->setQuery($updateSQL);
        $result_u = $mydb->executeQuery();

        $updateGoTo = "them_danh_muc.php";
        if (isset($_SERVER['QUERY_STRING'])) {
            $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
            $updateGoTo .= $_SERVER['QUERY_STRING'];
        }
        sprintf("location: %s", $updateGoTo);
    }

    $mydb->setQuery("SELECT * FROM $table");
    $RCDanhmuc_DS = $mydb->executeQuery();
    $row_RCDanhmuc_DS = $mydb->fetch_assoc($RCDanhmuc_DS);
    $totalRows_RCDanhmuc_TM = $mydb->num_rows($RCDanhmuc_DS);

?>
<table width="800" border="0" cellspacing="1" cellpadding="0" align="center">
  <tr>
    <td class="row2" width="500" valign="top"><table width="500" border="0" cellspacing="1" cellpadding="1">
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
    do { ?>
    <tr>
      <td><?php echo $stt; ?></td>
      <td><?php echo $row_RCDanhmuc_DS[$ma_column]; ?></td>
      <td><?php echo $row_RCDanhmuc_DS[$ten_column]; ?></td>
  </tr>
  <?php $stt = $stt + 1; ?>
  <?php } while ($row_RCDanhmuc_DS = mysql_fetch_assoc($RCDanhmuc_DS)); ?>
</table></td>
<td class="row2" width="260" align="center" valign="top">
    <?php
        $mydb->setQuery("SELECT * FROM $table where $ma_column = '$ma_nv'");
        $RCDanhmuc_CN = $mydb->executeQuery();
        $row_RCDanhmuc_CN = $mydb->fetch_assoc($RCDanhmuc_CN);
        $totalRows_RCDanhmuc_CN = $mydb->num_rows($RCDanhmuc_CN);
    ?>
    <form action="<?php echo $editFormAction; ?>" method="post" name="update_cat_form" id="update_cat_form">
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
    <input type="hidden" name="MM_update" value="update_cat_form" />
</form>
</td>
</tr>
</table>
<?php
mysql_free_result($RCDanhmuc_CN);
mysql_free_result($RCDanhmuc_DS);
?>
