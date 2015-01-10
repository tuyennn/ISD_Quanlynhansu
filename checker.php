<?php
	require_once('includes/initialize.php');
	if (isset($_POST['action'])) {
	    switch ($_POST['action']) {
	        case 'ma_nhan_vien_availability':
	            $ma_nhan_vien 		= htmlentities($_POST['ma_nhan_vien']); // Get the ma_nhan_vien values
				$check_query	= mysql_query('SELECT ma_nhan_vien FROM tlb_nhanvien WHERE ma_nhan_vien = "'.$ma_nhan_vien.'" '); // Check the database
				echo mysql_num_rows($check_query); // echo the num or rows 0 or greater than 0
	            break;
	        case 'check_ID_availability':
	            $check_ID 		= htmlentities($_POST['check_ID']); // Get the check_ID values
				$check_tlb		= htmlentities($_POST['check_TB']);
				$check_column	= htmlentities($_POST['check_CL']);
				$check_query	= 'SELECT ' . $check_column .' FROM ' .$check_tlb .' WHERE ' .$check_column .' = "' .$check_ID .'"';  
				$run_query	= mysql_query($check_query); // Check the database
				echo mysql_num_rows($run_query); // echo the num or rows 0 or greater than 0
	            break;
	        case 'variable':
	        	# code...
	        	break;
	    }
	}

?>