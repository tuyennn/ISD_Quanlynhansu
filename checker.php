<?php
require_once('includes/initialize.php');
if(isset($_POST['action']) && $_POST['action'] == 'ma_nhan_vien_availability'){ // Check for the ma_nhan_vien posted
	$ma_nhan_vien 		= htmlentities($_POST['ma_nhan_vien']); // Get the ma_nhan_vien values
	$check_query	= mysql_query('SELECT ma_nhan_vien FROM tlb_nhanvien WHERE ma_nhan_vien = "'.$ma_nhan_vien.'" '); // Check the database
	echo mysql_num_rows($check_query); // echo the num or rows 0 or greater than 0
}
?>