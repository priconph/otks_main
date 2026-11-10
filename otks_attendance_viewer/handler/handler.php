<?php
	if(is_ajax()) {
		if(isset($_POST["action"]) && !empty($_POST["action"])) {
			$action = $_POST["action"];
			switch($action) {
				case "add_31_days"         					: add_31_days(); break; 
				case "load_hris_record_by_username"         : load_hris_record_by_username(); break; 
			}
		}
	}

	function is_ajax() {
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}
	
	function load_hris_record_by_username(){
		require_once('../class/otks.php'); //OOP Path
		$return = $_POST;
		$result = "";
		$array_fields = array('EmpNo','lastname','firstname','middlename','lastname','Division','Department','Section','Position');
		$table 	   	= 'db_hris.vw_EmpInfo_Rapid';
		$joins 	   	= '';
		$sql_where 	= 'WHERE username = "'.$return['username'].'"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_array($result)){
			$return['EmpNo'] 			= $row['EmpNo'];
			$return['lastname'] 		= $row['lastname'];
			$return['firstname'] 		= $row['firstname'];
			$middle_initial 			= $row['middlename'];
			$return['middlename'] 		= $middle_initial[0].'.';
			$return['lastname'] 		= $row['lastname'];
			$return['Division'] 		= $row['Division'];
			$return['Department'] 		= $row['Department'];
			$return['Section'] 			= $row['Section'];
			$return['Position'] 		= $row['Position'];
		}
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}
	function add_31_days() {
		$return = $_POST;
		$return['date_to'] = date('Y-m-d', strtotime($_POST['date_from']. ' + 185 days'));
		echo json_encode($return);
	}
?>