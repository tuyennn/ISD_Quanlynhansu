<?php require_once('includes/initialize.php'); ?>
<?php
    $table = get_param('table');
    $fulltitle = get_param('title');
    $title = mb_substr($fulltitle, 9, 20, 'utf-8');
    $column = get_param('column');
    $id_column = $column.'_id';
    $code_column = 'ma_' .$column;
    $name_column = 'ten_' .$column;
    $action = get_param('action');


    //Thực hiện lệnh xoá nếu chọn xoá
    if ($action=="del")
    {
    	$check_ID = get_param('catID');
    	$deleteSQL = "DELETE FROM $table WHERE $id_column ='$check_ID'";                     
    	
        $mydb->setQuery($deleteSQL);
        $result_d = $mydb->executeQuery();
        if($result_d) {
            $message = "Thao tác xóa thành công!";
            echo "<script type='text/javascript'>alert('$message');</script>";
            $url = 'index.php?require=them_danh_muc.php&table='.$table.'&title='.$title.'&column='.$column;
            location($url);
        }
        else {
            $message = "Thao tác xóa thất bại!";
            echo "<script type='text/javascript'>alert('$message');</script>";
            $url = 'index.php?require=them_danh_muc.php&table='.$table.'&title='.$title.'&column='.$column;
            location($url);
        }

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

    if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "new_cat_form")) {
        $currentDate = date("Y-m-d");
        $insertSQL = sprintf("INSERT INTO $table ($code_column, $name_column, ngay_tao) VALUES (%s, %s, '{$currentDate}')",
            GetSQLValueString(strtoupper($_POST['check_ID']), "text"),
            GetSQLValueString($_POST['check_Name'], "text"));

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
            if(check_ID.length >= 2) { // check if greater than 3 (minimum 3)

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
        $mydb->setQuery("SELECT * FROM $table ORDER BY `ngay_tao` ASC" );
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
            <td align="center"><a href="index.php?require=cap_nhat_danh_muc.php&table=<?php echo $table; ?>&catID=<?php echo $row[0]; ?>&title=<?php echo $fulltitle; ?>&column=<?php echo $column; ?>&action=edit">Sửa</a></td>
            <td align="center"><a href="index.php?require=them_danh_muc.php&table=<?php echo $table; ?>&catID=<?php echo $row[0]; ?>&title=<?php echo $fulltitle; ?>&column=<?php echo $column; ?>&action=del">Xoá</a></td>
        </tr>
    <?php 
            $stt = $stt + 1; 
        }  
    ?>
        </table>
    </div>

    <!--MAIN BOTTOM CONTENT -->
    <div class="detail_bottom">
        <form action="<?php echo $editFormAction; ?>" method="post" name="new_cat_form" id="new_cat_form">
            <table id="rounded-corner" width="750" align="center">
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Mã <?php echo $title?>: </td>
                    <td><input type="text" name="check_ID" id="check_ID" value="" size="54" style="text-transform:uppercase" data-validation="required" data-validation-error-msg="Thông tin bắt buộc"/></td>
                    <td width="360"><div class="check_ID_avail_result" id="check_ID_avail_result"></div></td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Tên <?php echo $title?>: </td>
                    <td><input type="text" name="check_Name" value="" size="54" /></td>
                    <td width="360"></td>
                </tr>
                <tr valign="baseline">
                    <td align="right" colspan="3">
                        <button class="btn btn-default" onclick="new_cat_form.reset();">Làm lại</button>
                        <input type="submit" onClick="ConfirmCreate()" class="btn btn-default" name="submit" id="addcat" value="Thêm mới <?php echo $title ?>" />
                        <script>
                            function ConfirmCreate(){
                                if (confirm("Bạn có chắc chắn thao tác thêm mới!"))
                                {
                                    new_cat_form.submit();
                                    return true;
                                }  
                            }
                            
                        </script> 
                    </td>
                </tr>
                <tfoot>
                    <tr>
                        <td colspan="5" class="rounded-foot-left">
                            <em><p><b><u>Hướng Dẫn:</u></b> 
                                <br>&nbsp;+ Đặt mã cho <?php echo $title ?> mục Mã <?php echo $title ?>
                                <br>&nbsp;+ Đặt tên cho <?php echo $title ?> mục Tên <?php echo $title ?>
                                <br>&nbsp;+ Nhấn vào nút Sửa trên thanh Thao tác để sửa <?php echo $title ?>
                                <br>&nbsp;+ Nhấn vào nút Xóa trên thanh Thao tác để xóa <?php echo $title ?>
                            </em></td>
                        <td class="rounded-foot-right">&nbsp;</td>

                    </tr>
                </tfoot>
            </table>
            <input type="hidden" name="MM_insert" value="new_cat_form" />
            <input type="hidden" name="check_TB" id="check_TB" value="<?php echo $table ?>" />
            <input type="hidden" name="check_CL" id="check_CL" value="<?php echo $code_column ?>" />
        </form>
        <script src="js/form-validator/jquery.form-validator.min.js"></script>
        <script>
        /* important to locate this script AFTER the closing form element, so form object is loaded in DOM before setup is called */
            $.validate({
                modules : 'security'
            });
        </script>
    </div>
