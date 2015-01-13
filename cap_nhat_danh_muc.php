<?php require_once('includes/initialize.php'); ?>
<?php
    $table = get_param('table');
    $fulltitle = get_param('title');
    $title = mb_substr($fulltitle, 9, 20, 'utf-8');
    $check_ID = get_param('catID');
    $column = get_param('column');
    $check_column = 'ma_' .$column;
    $name_column = 'ten_' .$column;
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
            GetSQLValueString($_POST['check_Name'], "text"),
            GetSQLValueString($_POST['check_ID'], "text"));
        echo $updateSQL;
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

    $mydb->setQuery("SELECT * FROM $table where $check_column = '$check_ID'");
    $RCDanhmuc_CN = $mydb->executeQuery();
    $row_RCDanhmuc_CN = $mydb->fetch_assoc($RCDanhmuc_CN);
    $totalRows_RCDanhmuc_CN = $mydb->num_rows($RCDanhmuc_CN);

?>


<script type="text/javascript" src="js/form-validator/jquery.form-validator.min.js"></script>
    <script type="text/javascript">
    pic1 = new Image(16, 16); 
    pic1.src = "images/loader.gif";
    $(document).ready(function(){
        $('#check_ID').change(function(){ // Keyup function for check the user action in input
            var check_ID = document.getElementById("check_ID").value.toUpperCase(); // Get the check_ID textbox using $(this) or you can use directly $('#check_ID')
            var check_TB = document.getElementById("check_TB").value; // Get the check_table value
            var check_CL = document.getElementById("check_CL").value; // Get the check_column value 
            var check_IDAvailResult = $('#check_ID_avail_result'); // Get the ID of the result where we gonna display the results
            if(check_ID.length >= 3) { // check if greater than 3 (minimum 3)

                check_IDAvailResult.html('<img src="images/loader.gif" align="absmiddle">&nbsp;Đang kiểm tra khả dụng...'); // Preloader, use can use loading animation here
                var UrlToPass = 'action=check_ID_availability&check_ID='+check_ID+'&check_TB='+check_TB+'&check_CL='+check_CL;
                $.ajax({ // Send the all val to another includes/checker.php using Ajax in POST method
                    type : 'POST',
                    data : UrlToPass,
                    url  : 'includes/checker.php',
                    success: function(responseText){ // Get the result and asign to each cases
                        if(responseText == 0){
                            $("#check_ID").removeClass('object_error'); // if necessary
                            $("#check_ID").addClass("object_ok");
                            check_IDAvailResult.html('<span class="success">&nbsp;<img src="images/tick.gif" align="absmiddle"></span>');
                            $('#addcat').removeAttr('disabled');
                        }
                        else if(responseText > 0){
                            $("#check_ID").removeClass('object_ok'); // if necessary
                            $("#check_ID").addClass("object_error");
                            check_IDAvailResult.html('<span class="error">Mã này này đã sử dụng</span>');
                            $('#addcat').attr('disabled','disabled');
                        }

                        else{
                            alert('Lỗi cơ sở dữ liệu');
                        }
                    
                    }
                });
            }else{
                check_IDAvailResult.html('<span class="error">Mã <?php $title ?> chỉ được viết tắt, hoa những chữ cái đầu</span>');
                $("#check_ID").removeClass('object_ok'); // if necessary
                $("#check_ID").addClass("object_error");
            }
            if(check_ID.length == 0) {
                check_IDAvailResult.html('');
            }
        });
    
        $('#check_ID').keydown(function(e) { // Dont allow users to enter spaces for their check_ID
            if (e.which == 32) {
                return false;
            }
        });
    });
    </script>
    <!--MAIN UP CONTENT -->
    <div class="detail_up">
        <table id="rounded-corner" border="0" width="750">
            <thead>
                <tr>
                    <th width="25" class="rounded-content">STT</th>
                    <th width="180">Mã <?php echo $title?></th>
                    <th width="360">Tên <?php echo $title?></th>
                    <th width="120" colspan="2" align="center" class="rounded-q4">Thao tác</th>
                </tr>
            </thead>
    <?php 
        $mydb->setQuery("SELECT * FROM $table");
        $RCDanhmuc_TM = $mydb->executeQuery();
        $totalRows_RCDanhmuc_TM = $mydb->num_rows($RCDanhmuc_TM);
    ?>
    <?php 
        $stt =1;
        while ($row = mysql_fetch_row($RCDanhmuc_TM)) {
    ?>
        <tr>
            <td align="center"><?php echo sprintf("%03d", $stt); ?></td>
            <td><?php echo $row[1]; ?></td>
            <td><?php echo $row[2]; ?></td>
            <td align="center"><a href="index.php?require=cap_nhat_danh_muc.php&table=<?php echo $table; ?>&catID=<?php echo $row[1]; ?>&title=<?php echo $fulltitle; ?>&column=<?php echo $column; ?>&action=edit">Sửa</a></td>
            <td align="center"><a href="index.php?require=them_danh_muc.php&table=<?php echo $table; ?>&catID=<?php echo $row[1]; ?>&title=<?php echo $fulltitle; ?>&column=<?php echo $column; ?>&action=del">Xoá</a></td>
        </tr>
    <?php 
            $stt = $stt + 1; 
        }  
    ?>
        </table>
    </div>

    <!--MAIN BOTTOM CONTENT -->
    <div class="detail_bottom">
        <form action="<?php echo $editFormAction; ?>" method="post" name="update_cat_form" id="update_cat_form">
            <table id="rounded-corner" width="750" align="center">
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Mã <?php echo $title?>: </td>
                    <td><input type="text" name="check_ID" id="check_ID" value="<?php echo $row_RCDanhmuc_CN[$check_column]; ?>" size="54" style="text-transform:uppercase" data-validation="required" data-validation-error-msg="Thông tin bắt buộc"/></td>
                    <td width="360"><div class="check_ID_avail_result" id="check_ID_avail_result"></div></td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Tên <?php echo $title?>: </td>
                    <td><input type="text" name="check_Name" value="<?php echo $row_RCDanhmuc_CN[$name_column]; ?>" size="54" /></td>
                    <td width="360"></td>
                </tr>
                <tr valign="baseline">
                    <td align="right" colspan="3">
                        <button class="btn btn-default" onclick="update_cat_form.reset();">Quay lại</button>
                        <input type="submit" onClick="ConfirmCreate()" class="btn btn-default" name="submit" id="addcat" value="Cập nhật <?php echo $title ?>" />
                        <script>
                            function ConfirmCreate(){
                                if (confirm("Bạn có chắc chắn thao tác thêm mới!"))
                                {
                                    update_cat_form.submit();
                                    return true;
                                }  
                            }
                            
                        </script> 
                    </td>
                </tr>
            </table>
            <input type="hidden" name="MM_update" value="update_cat_form" />
            <input type="hidden" name="check_TB" id="check_TB" value="<?php echo $table ?>" />
            <input type="hidden" name="check_CL" id="check_CL" value="<?php echo $ma_column ?>" />
        </form>
        <script src="js/form-validator/jquery.form-validator.min.js"></script>
        <script>
        /* important to locate this script AFTER the closing form element, so form object is loaded in DOM before setup is called */
            $.validate({
                modules : 'security'
            });
        </script>
    </div>

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
