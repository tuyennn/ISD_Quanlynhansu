<?php
require_once("includes/initialize.php");	

$upload_errors = array(
UPLOAD_ERR_OK	      => "No errors.",
UPLOAD_ERR_INI_SIZE	  => "Larger than upload_max_filesize.",
UPLOAD_ERR_FORM_SIZE  => "Larger than form MAX_FILE_SIZE.",
UPLOAD_ERR_PARTIAL	  => "Partial upload.",
UPLOAD_ERR_NO_FILE    => "No file.",
UPLOAD_ERR_NO_TMP_DIR => "No temporary directory.",
UPLOAD_ERR_CANT_WRITE => "Can't write to disk.",
UPLOAD_ERR_EXTENSION  => "File upload stopped by extension.",
);



if (isset($_POST['savephoto'])){
	

			
	 $tmp_file = $_FILES['upload_file']['tmp_name'];
	 @$target_file = basename($_FILES['upload_file']['name']);
	 $upload_dir = "uploads";
	 $imgsize = $_FILES['upload_file']['size'];	
	 $imgtype = $_FILES['upload_file']['type'];
	 $member_id = $_SESSION['member_id'];	

	if (move_uploaded_file($tmp_file,$upload_dir."/".$target_file)){
			global $mydb;
			$mydb->setQuery("INSERT INTO `tlb`(`filename`, `type`, `size`, `member_id`) 
				VALUES ('{$target_file}', '{$imgtype}', '{$imgsize}', '{$member_id}')");
			$mydb->executeQuery();
			if ($mydb->affected_rows() == 1) {
				
				echo "<script type=\"text/javascript\">
							alert(\"System Information created successfully.\");
							window.location='index.php';
						</script>";
				
			} else{
				echo "<script type=\"text/javascript\">
							alert(\"System Information creation Failed!\");
						</script>";
			}
		
			//echo "File uploaded Succesfully";
			
		}else{
			$error = $_FILES['upload_file']['error'];
			$message = $upload_errors[$error];
			echo "<script type=\"text/javascript\">
							alert(\".{$message}.\");
							
						</script>";
		}
	
}
?>