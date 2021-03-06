<?php
	function strip_zeros_from_date($marked_string="") {
		//first remove the marked zeros
		$no_zeros = str_replace('*0','',$marked_string);
		$cleaned_string = str_replace('*0','',$no_zeros);
		return $cleaned_string;
	}
	function redirect_to($location = NULL) {
		if($location != NULL){
			header("location: {$location}");
			exit;
		}
	}
	function output_message($message="") {
	
		if(!empty($message)){
		return "<p class=\"message\">{$message}</p>";
		}else{
			return "";
		}
	}
	
	function __autoload($class_name) {
		$class_name = strtolower($class_name);
		$path = LIB_PATH.DS."{$class_name}.php";
		if(file_exists($path)){
			require_once($path);
		}else{
			die("The file {$class_name}.php could not be found.");
		}
					
	}

	function page_transfer($msg,$page="index.php") {
	    $showtext = $msg;
	    $page_transfer = $page;
	    include("transfer_page.php");
	    exit();
    }
	
	function get_param($param_name){
		$param_value = "";
		if(isset($_POST[$param_name]))
			$param_value = $_POST[$param_name];
		else if(isset($_GET[$param_name]))
			$param_value = $_GET[$param_name];
		return trim($param_value);
	}
	
	function location($url){
		echo '<script type="text/javascript">window.location = "'. $url . '";</script>';
	}
	

	function write_mysql_log($message, $db)
	{

  	// Check message
		if($message == '') {
			return array(status => false, message => 'Message is empty');
		}

  	// Get IP address
		if( ($remote_addr = $_SERVER['REMOTE_ADDR']) == '') {
			$remote_addr = "REMOTE_ADDR_UNKNOWN";
		}

  	// Get requested script
		if( ($request_uri = $_SERVER['REQUEST_URI']) == '') {
			$request_uri = "REQUEST_URI_UNKNOWN";
		}

  	// Escape values
		$message     = $db->escape_string($message);
		$remote_addr = $db->escape_string($remote_addr);
		$request_uri = $db->escape_string($request_uri);

  	// Construct query
		$sql = "INSERT INTO tlb_log (remote_addr, request_uri, message) VALUES('$remote_addr', '$request_uri','$message')";

  	// Execute query and save data
		$result = $db->query($sql);

		if($result) {
			return array(status => true);  
		}
		else {
			return array(status => false, message => 'Unable to write to the database');
		}
	}
?>