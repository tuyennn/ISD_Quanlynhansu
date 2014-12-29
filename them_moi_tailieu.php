
<?php
    require_once("includes/initialize.php");
    if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "new_document_form")) {
        $tmp_file = $_FILES['upload_file']['tmp_name'];
        @$target_file = basename($_FILES['upload_file']['name']);
        $upload_dir = "uploads/documents";
        $filesize = $_FILES['upload_file']['size']; 
        $filetype = $_FILES['upload_file']['type'];

        if(move_uploaded_file($tmp_file,$upload_dir."/".$target_file)) {
            
            $insertSQL="INSERT INTO `tlb_tailieu` (`title`, `filename`, `type`, `size`) VALUES ('{$_POST['ten_tailieu']}', '{$target_file}', '{$filetype}', '{$filesize}')";
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
        else {
            mysql_error();
            echo "There was an error uploading the file, please try again!";
        }
    }

    $insertGoTo = "danh_sach_tailieu.php";
    if (isset($_SERVER['QUERY_STRING'])) {
        $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
        $insertGoTo .= $_SERVER['QUERY_STRING'];
    }
    $url = "index.php?require=danh_sach_tailieu.php&title=Quản lý tài liệu";
    location($url);
?> 