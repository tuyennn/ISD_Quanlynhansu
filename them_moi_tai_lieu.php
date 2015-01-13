<?php
$action = get_param('action');
//Thực hiện lệnh xoá nếu chọn xoá
if ($action=="del")
{
    $ma_tailieu = $_GET['catID'];

    $upload_dir = "uploads/documents";
    $mydb->setQuery("SELECT * FROM tlb_tailieu WHERE id = '$ma_tailieu'");
    $RCtailieu_DS = $mydb->executeQuery();
    $row_RCtailieu_DS = $mydb->fetch_assoc($RCtailieu_DS);
    $totalRows_RCtailieu_DS = $mydb->num_rows($RCtailieu_DS);
    if($totalRows_RCtailieu_DS == 1) {
        $file = $upload_dir."/".$row_RCtailieu_DS['filename'];
        if (!unlink($file))
        {
            echo ("Error deleting $file");
        }
        else
        {
            echo ("$file deleted!");
        }
        $deleteSQL="DELETE tlb_tailieu.* FROM tlb_tailieu WHERE `id` = '$ma_tailieu'";
        $mydb->setQuery($deleteSQL);
        $result_d = $mydb->executeQuery();

        if($result_d) {
            $message = "Thao tác xóa thành công!";
            echo "<script type='text/javascript'>alert('$message');</script>";
            $url = "index.php?require=them_moi_tai_lieu.php&title=Cập nhật tài liệu";
            location($url);
        }
        else {
            $message = "Thao tác xóa thất bại!";
            echo "<script type='text/javascript'>alert('$message');</script>";
            $url = "index.php?require=them_moi_tai_lieu.php&title=Cập nhật tài liệu";
            location($url);
        }
    }                  
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "new_document_form")) {
    $tmp_file = $_FILES['upload_file']['tmp_name'];
    @$target_file = basename($_FILES['upload_file']['name']);
    $upload_dir = "uploads/documents";
    $filesize = $_FILES['upload_file']['size']; 
    $filetype = $_FILES['upload_file']['type'];

    if(move_uploaded_file($tmp_file,$upload_dir."/".$target_file)) {

        $currentDate = date("Y-m-d");
        
        $insertSQL="INSERT INTO `tlb_tailieu` (`title`, `filename`, `type`, `size`, `ngay_tao`) VALUES ('{$_POST['ten_tailieu']}', '{$target_file}', '{$filetype}', '{$filesize}', '{$currentDate}')";
        $mydb->setQuery($insertSQL);
        $result_c = $mydb->executeQuery();
        if($result_c) {
            $message = "Thao tác thêm mới thành công!";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
        else {
            $message = "Thao tác thêm mới thất bại!";
            echo "<script type='text/javascript'>alert('$message');</script>";
            echo $insertSQL;
        }
    }
    else {
        mysql_error();
        echo $insertSQL;
        //echo "There was an error uploading the file, please try again!";
    }

    $insertGoTo = "them_moi_tai_lieu.php";
    if (isset($_SERVER['QUERY_STRING'])) {
        $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
        $insertGoTo .= $_SERVER['QUERY_STRING'];
    }
    sprintf("location: %s", $insertGoTo);
}

    $mydb->setQuery("SELECT * FROM tlb_tailieu");
    $RCtailieu_DS = $mydb->executeQuery();
    $row_RCtailieu_DS = $mydb->fetch_assoc($RCtailieu_DS);
    $totalRows_RCtailieu_DS = $mydb->num_rows($RCtailieu_DS);



?> 
<!--MAIN UP CONTENT -->
    <div class="detail_up">
        

  
    <?php
        if ($totalRows_RCtailieu_DS<>0)
        {
    ?>
        <table id="rounded-corner" summary="Bảng Thống Kê Tài Liệu Công Ty" >
            <thead>
                <tr>
                    <th width="30" rowspan="2" align="center" class="rounded-company">MÃ</th>
                    <th width="340" rowspan="2" align="left">TÊN TÀI LIỆU</th>
                    <th width="100" rowspan="2" align="left">KÍCH CỠ</th>
                    <th width="80" rowspan="2" align="left">NGÀY TẠO</th>
                    <th colspan="3" align="center" class="rounded-q4">THAO TÁC</th>
                </tr>

                <tr>
                    <td align="center" bgcolor="#CC0000">Sửa</td>
                    <td align="center" bgcolor="#CC0000">Xóa</td>
                    <td width="80" align="center" bgcolor="#CC0000">Tải Về</td>
                </tr>
            </thead>
    <?php do { ?>
            <tr>
                <td width="30" align="center"><?php echo sprintf("%03d", $row_RCtailieu_DS['id']); ?></td>
                <td align="left"><?php echo $row_RCtailieu_DS['title']; ?></td>
                <td align="left"><?php echo $row_RCtailieu_DS['size']; ?> bytes</td>
                <td align="left"><?php echo htmlentities(date("d/m/Y", strtotime($row_RCtailieu_DS['ngay_tao'])), ENT_COMPAT, 'utf-8'); ?></td>
                <td width="50" align="center" ><a href="index.php?require=cap_nhat_tai_lieu.php&catID=<?php echo $row_RCtailieu_DS['id']; ?>&title=Cập nhật tài liệu"><img src="images/user_edit.png" alt="Sửa tài liệu" title="Sửa tài liệu" border="0" /></a></td>
                <td width="50" align="center"><a href="#" onclick="ConfirmDelete()" value="Xóa tài liệu"><img src="images/trash.png" alt="Xóa Tài Liệu" title="Xóa Tài Liệu" border="0" /></a></td>
                    <script type="text/javascript">
                        function ConfirmDelete()
                        {
                            if (confirm("Bạn có chắc chắn thao tác xóa?"))
                                location.href='index.php?require=them_moi_tai_lieu.php&catID=<?php echo $row_RCtailieu_DS['id']; ?>&title=Cập nhật tài liệu&action=del';
                        }
                    </script>
                <td width="50" align="center" >
                    <?php
                    $upload_dir = 'uploads/documents/';
                    $sql="SELECT * FROM tlb_tailieu ORDER BY id LIMIT 4";
                    $rs=mysql_query($sql) or die('Cannot select document');
                    while($row=mysql_fetch_array($rs)){
                        echo '<a href="../'.FOLDER.'/'.$upload_dir.$row['filename'].'">';
                    }
                    ?>
                        <img src="images/download.png" alt="Tải về tài liệu" title="Tải về tài liệu" border="0" />
                    </a>
                </td>
            </tr>
        <?php } while ($row_RCtailieu_DS = $mydb->fetch_assoc($RCtailieu_DS)); ?>
        </table>
        <?php
            }
            else {
            ?>
                <table id="rounded-corner" border="0" width="460" align="center" cellpadding="1" cellspacing="1">
                <span><h4>Chưa có tài liệu được tải lên, mời thêm mới...</h4></span>
                </table>
        <?php
            }
        ?>
    </div>

    <!--MAIN BOTTOM CONTENT -->

    <div class="detail_bottom">
        <form enctype="multipart/form-data" action="<?php echo $editFormAction; ?>" method="post" name="new_document_form" id="new_document_form">
            <table id="rounded-corner" width="750" align="center">
                <tr valign="baseline">
                    <td nowrap="nowrap" align="left" colspan="3">Tên tài liệu:</td>
                    <td><input type="text" name="ten_tailieu" value="" size="120" /></td>
                    <td width="20"></td>
                </tr>

                <tr>
                    <td colspan="5">
                        <a href="#" onclick="ConfirmCreate()" class="bt_green"><span class="bt_green_lft"></span><strong>Tải lên</strong><span class="bt_green_r"></span></a>
                            <span>
                                <input id="upload_file" type="file" name="upload_file" />
                            </span>
                        <script type="text/javascript">
                        function ConfirmCreate()
                        {
                            if (confirm("Bạn có chắc chắn thao tác thêm mới!"))
                            {
                                new_document_form.submit();
                                return false;
                            }  
                        }
                        </script>
                    </td>
                </tr>
            </table>
            <input type="hidden" name="MM_insert" value="new_document_form" />
        </form>
    </div>