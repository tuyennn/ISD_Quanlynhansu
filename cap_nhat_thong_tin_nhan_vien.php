<?php
$ma_nv = $_GET['catID'];
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "edit_staff")) {
   $updateSQL = sprintf("UPDATE tlb_nhanvien SET ho_ten=%s, gioi_tinh=%s, gia_dinh=%s, dt_di_dong=%s, dt_nha=%s, email=%s, ngay_sinh=%s, noi_sinh=%s, tinh_thanh=%s, cmnd=%s, ngay_cap=%s, noi_cap=%s, que_quan=%s, dia_chi=%s, tam_tru=%s, nghi_viec=%s WHERE ma_nhan_vien=%s",
     GetSQLValueString($_POST['ho_ten'], "text"),
     GetSQLValueString($_POST['gioi_tinh'], "int"),
     GetSQLValueString($_POST['gia_dinh'], "int"),
     GetSQLValueString($_POST['dt_di_dong'], "text"),
     GetSQLValueString($_POST['dt_nha'], "text"),
     GetSQLValueString($_POST['email'], "text"),
     GetSQLValueString($_POST['ngay_sinh'], "date"),
     GetSQLValueString($_POST['noi_sinh'], "text"),
     GetSQLValueString($_POST['tinh_thanh'], "text"),
     GetSQLValueString($_POST['cmnd'], "text"),
     GetSQLValueString($_POST['ngay_cap'], "date"),
     GetSQLValueString($_POST['noi_cap'], "text"),
     GetSQLValueString($_POST['que_quan'], "text"),
     GetSQLValueString($_POST['dia_chi'], "text"),
     GetSQLValueString($_POST['tam_tru'], "text"),
     GetSQLValueString($_POST['nghi_viec'], "int"),
     GetSQLValueString($_POST['ma_nhan_vien'], "text"));

mysql_select_db($database_Myconnection, $Myconnection);
$Result1 = mysql_query($updateSQL, $Myconnection) or die(mysql_error());


$updateGoTo = "danh_sach_nhan_vien.php";
if (isset($_SERVER['QUERY_STRING'])) {
  $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
  $updateGoTo .= $_SERVER['QUERY_STRING'];
}
location($$updateGoTo);
}

mysql_select_db($database_Myconnection, $Myconnection);
$query_RCcapnhat_nhanvien = "SELECT * FROM tlb_nhanvien where ma_nhan_vien = '$ma_nv'";
$RCcapnhat_nhanvien = mysql_query($query_RCcapnhat_nhanvien, $Myconnection) or die(mysql_error());
$row_RCcapnhat_nhanvien = mysql_fetch_assoc($RCcapnhat_nhanvien);
$totalRows_RCcapnhat_nhanvien = mysql_num_rows($RCcapnhat_nhanvien);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <link rel="stylesheet" type="text/css" href="css/jquery.datepick.css" />
    <script type="text/javascript" src="js/jquery.plugin.js"></script> 
    <script type="text/javascript" src="js/jquery.datepick.js"></script>
    <script type="text/javascript" src="js/jquery.datepick-vi.js"></script>
    <script>
        $(function() {
            $('#ngay_sinh').datepick({showOnFocus: false, showTrigger: '#calImg'});
            $('#ngay_cap').datepick({showOnFocus: false, showTrigger: '#calImg'});
             
            var formats = ['mm/dd/yyyy', 'M d, yyyy', 'MM d, yyyy', 
                'DD, MM d, yyyy', 'mm/dd/yy', 'dd/mm/yyyy', 
                'mm/dd/yyyy (\'w\'w)', '\'Day\' d \'of\' MM, yyyy', 
                $.datepick.ATOM, $.datepick.COOKIE, $.datepick.ISO_8601, 
                $.datepick.RFC_822, $.datepick.RFC_850, $.datepick.RFC_1036, 
                $.datepick.RFC_1123, $.datepick.RFC_2822, $.datepick.RSS, 
                $.datepick.TICKS, $.datepick.TIMESTAMP, $.datepick.W3C]; 
             
            $('#dateFormat').change(function() { 
                $('#ngay_cap').val('').datepick('option', 
                    {dateFormat: formats[$(this).val()]}); 
                });
            });
    </script>

</head>

    <body text="#000000" link="#CC0000" vlink="#0000CC" alink="#000099">
        <div style="display: none;">
            <img id="calImg" src="images/calendar.gif" alt="Popup" class="trigger">
        </div>

        <form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="edit_staff" id="edit_staff">
            <table id="rounded-corner" width="750" cellpadding="2" cellspacing="2" bgcolor="#66CCFF">
                <thead>
                    <tr>
                        <th width="200" class="rounded-company" rowspan="2" align="center"><a href="index.php?require=them_moi_quan_he_gia_dinh.php&catID=<?php echo $ma_nv; ?>&title=Quan hệ gia đình&action=new">Quan hệ gia đình</a></td>
                        <th width="200" rowspan="2" align="center"><a href="index.php?require=them_moi_qua_trinh_cong_tac.php&catID=<?php echo $ma_nv; ?>&title=Quá trình công tác&action=new">Quá trình công tác</a></td>
                        <th width="150" rowspan="2" align="center"><a href="index.php?require=them_moi_qua_trinh_luong.php&catID=<?php echo $ma_nv; ?>&title=Quá trình lương&action=new">Quá trình lương</a></td>
                        <th width="120" rowspan="2" align="center"><a href="index.php?require=them_moi_hop_dong.php&catID=<?php echo $ma_nv; ?>&title=Hợp đồng&action=new">Hợp đồng</a></td>
                        <th width="112" class="rounded-q4" rowspan="2" align="center"><a href="index.php?require=them_moi_bao_hiem.php&catID=<?php echo $ma_nv; ?>&title=Bảo hiểm&action=new">Bảo hiểm</a></td>
                    </tr>
                </thead>
            </table>

            <table id="rounded-corner" width="750" align="center" cellpadding="2" cellspacing="2" bgcolor="#66CCFF">
                <tr valign="baseline">
                    <td width="127" align="right" nowrap="nowrap">Mã nhân viên(*):</td>
                    <td width="227"><?php echo $row_RCcapnhat_nhanvien['ma_nhan_vien']; ?></td>
                    <td nowrap="nowrap" align="right" width="68">Tình trạng:</td>
                    <td width="271">
                        <?php
                            if ($row_RCcapnhat_nhanvien['nghi_viec']==0)
                            {
                        ?>
                        <select name="nghi_viec">
                            <option selected="selected" value="0">Làm việc </option>
                            <option value="1">Nghỉ việc </option>
                        </select>
                        <?php
                            }
                            else
                                {
                        ?>
                        <select name="nghi_viec">
                            <option selected="selected" value="1">Nghỉ việc </option>
                            <option value="0">Làm việc </option>
                        </select>
                        <?php
                            }
                        ?>
                    </td>
                </tr>
                <tr valign="10px">
                    <td nowrap="nowrap" align="right">Họ và tên(*):</td>
                    <td><input type="text" name="ho_ten" value="<?php echo htmlentities($row_RCcapnhat_nhanvien['ho_ten'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
                    <td>Ngày sinh:</td>
                    <td>
                        <input type="text" name="ngay_sinh" id="ngay_sinh" value="<?php echo $row_RCcapnhat_nhanvien['ngay_sinh']; ?>" size="25" />
                        (dd/mm/yyyy)
                    </td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Giới tính</td>
                    <td>
                        <select name="gioi_tinh">
                            <option value="1" <?php if (!(strcmp(1, htmlentities($row_RCcapnhat_nhanvien['gioi_tinh'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>Nam</option>
                            <option value="0" <?php if (!(strcmp(0, htmlentities($row_RCcapnhat_nhanvien['gioi_tinh'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>Nữ</option>
                        </select>
                    </td>
                    <td>Nơi sinh:</td>
                    <td><input type="text" name="noi_sinh" value="<?php echo htmlentities($row_RCcapnhat_nhanvien['noi_sinh'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Gia đình:</td>
                    <td>
                        <select name="gia_dinh">
                            <option value="1" <?php if (!(strcmp(1, htmlentities($row_RCcapnhat_nhanvien['gia_dinh'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>Có gia đình</option>
                            <option value="0" <?php if (!(strcmp(0, htmlentities($row_RCcapnhat_nhanvien['gia_dinh'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>Chưa có</option>
                        </select>
                    </td>
                    <td>Tỉnh thành:</td>
                    <td><input type="text" name="tinh_thanh" value="<?php echo htmlentities($row_RCcapnhat_nhanvien['tinh_thanh'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">ĐTDĐ:</td>
                    <td><input type="text" name="dt_di_dong" value="<?php echo htmlentities($row_RCcapnhat_nhanvien['dt_di_dong'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
                    <td>CMND:</td>
                    <td><input type="text" name="cmnd" value="<?php echo htmlentities($row_RCcapnhat_nhanvien['cmnd'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">ĐT:</td>
                    <td><input type="text" name="dt_nha" value="<?php echo htmlentities($row_RCcapnhat_nhanvien['dt_nha'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
                    <td>Ngày cấp:</td>
                    <td>
                        <input type="text" name="ngay_cap" id="ngay_cap" value="<?php echo htmlentities($row_RCcapnhat_nhanvien['ngay_cap'], ENT_COMPAT, 'utf-8'); ?>" size="25" />
                        (dd/mm/yyyy)
                    </td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Email:</td>
                    <td><input type="text" name="email" value="<?php echo htmlentities($row_RCcapnhat_nhanvien['email'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
                    <td>Nơi cấp:</td>
                    <td><input type="text" name="noi_cap" value="<?php echo htmlentities($row_RCcapnhat_nhanvien['noi_cap'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Quê quán:</td>
                    <td colspan="3"><input type="text" name="que_quan" value="<?php echo htmlentities($row_RCcapnhat_nhanvien['que_quan'], ENT_COMPAT, 'utf-8'); ?>" size="90" /></td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Địa chỉ:</td>
                    <td colspan="3"><input type="text" name="dia_chi" value="<?php echo htmlentities($row_RCcapnhat_nhanvien['dia_chi'], ENT_COMPAT, 'utf-8'); ?>" size="90" /></td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Tạm trú:</td>
                    <td colspan="3"><input type="text" name="tam_tru" value="<?php echo htmlentities($row_RCcapnhat_nhanvien['tam_tru'], ENT_COMPAT, 'utf-8'); ?>" size="90" /></td>
                </tr>
                <tr style="height: 200px" valign="middle">
                    <td nowrap="nowrap" align="right">Hình ảnh:</td>
                    <td colspan="3">
                    <div class="avatar">
                        <a data-target="#myModal" data-toggle="modal" href="" title="Click here to Change Image.">

                            <?php
            
                                //echo $ma_nv;
                                $mydb->setQuery("SELECT * FROM tlb_hinhanh WHERE `ma_nhan_vien`='$ma_nv'");
                                $cur = $mydb->loadResultList();
                                if ($mydb->affected_rows()== 0){
                                    echo '<img src="./uploads/p.jpg" class="img-thumbnail" width="200px" height="100px" />';    
                                
                                } 
                                foreach($cur as $object){
                                   
                                        echo '<img src="./uploads/'. $object->filename.'" class="img-thumbnail" width="200px" height="100px" />';
                                    
                                    }

                                $hinh_anh   
                            ?> 

                            <!--
                                <?php
                                    if ($row_RCcapnhat_nhanvien['hinh_anh'] == 0){
                                        echo '<img src="./uploads/p.jpg" class="img-thumbnail" width="200px" height="100px" />';    
                                    
                                    } 
                                    else
                                       
                                        echo '<img src="./uploads/'. $row_RCcapnhat_nhanvien['hinh_anh']. '" class="img-thumbnail" width="200px" height="100px" />';
                                          
                                ?>
                            -->
                            </a>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="myModal" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button class="close" data-dismiss="modal" type="button">×</button>

                                        <h4 class="modal-title" id="myModalLabel">Choose a picture for Profile.</h4>
                                    </div>
                                    <form action="save_photo.php" enctype="multipart/form-data" method="post">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <div class="rows">
                                                    <div class="col-md-12">
                                                        <div class="rows">
                                                            <div class="col-md-8">
                                                                <input name="MAX_FILE_SIZE" type="hidden" value="1000000"> 
                                                                <input id="upload_file" name="upload_file" type="file">
                                                            </div>

                                                            <div class="col-md-4"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-default" data-dismiss="modal" type="button">Close</button> 
                                            <button class="btn btn-primary"name="savephoto" type="submit">Save Photo</button>
                                        </div>
                                    </form>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->                     
                    </td>
                </tr>

                <tfoot>
                    <tr>
                        <td colspan="3" class="rounded-foot-left"><em><b><u>Hướng Dẫn:</u></b> 
                                                                    <br>&nbsp;+ Các trường gắn (*) bắt buộc phải có 
                                                                    <br>&nbsp;+ Sửa các thông tin bằng cách chọn sẵn hoặc gõ bằng bàn phím
                                                                    <br>&nbsp;+ Nhấn Cập nhật thông tin để hoàn tất thao tác</em></td>
                        <td class="rounded-foot-right">&nbsp;</td>

                    </tr>
                </tfoot>

            </table>
            <input type="hidden" name="MM_update" value="edit_staff" />
            <input type="hidden" name="ma_nhan_vien" value="<?php echo $row_RCcapnhat_nhanvien['ma_nhan_vien']; ?>" />
        </form>
        <a href="#" onClick="fn_submit();" class="bt_green"><span class="bt_green_lft"></span><strong>Cập nhật thông tin</strong><span class="bt_green_r"></span></a>
        <a href="#" class="bt_red"><span class="bt_red_lft"></span><strong>Quay lại</strong><span class="bt_red_r"></span></a>
        <script>
            function fn_submit()
            {
                document.edit_staff.submit();
                alert("I am an alert box!");
            }
        </script> 
        <p>&nbsp;</p>
    </body>
</html>
<?php
    mysql_free_result($RCcapnhat_nhanvien);
?>
