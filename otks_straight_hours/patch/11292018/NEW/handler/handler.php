<?php
	if(is_ajax()) {
		if(isset($_POST["action"]) && !empty($_POST["action"])) {
			$action = $_POST["action"];
			switch($action) {
				case "load_straight_main_details" 				: load_straight_main_details(); break;
				case "load_straight_details" 					: load_straight_details(); break;
				case "load_hris_record_by_username" 			: load_hris_record_by_username(); break; 
				case "load_approver_list" 						: load_approver_list(); break; 
				case "load_approver_list_all" 					: load_approver_list_all(); break; 
				case "fetch_main_data_update" 					: fetch_main_data_update(); break; 
				case "load_hris_record_by_section" 				: load_hris_record_by_section(); break;  
				case "append_new_straight_details" 				: append_new_straight_details(); break;  
				case "save_straight_main_information" 			: save_straight_main_information(); break;  
				case "update_straight_main_information"			: update_straight_main_information(); break;  
				case "update_main_status"						: update_main_status(); break;  
				case "update_main_justification"				: update_main_justification(); break;  
				case "save_straight_details"					: save_straight_details(); break;  
				case "generate_form_submit"						: generate_form_submit(); break;  
				case "approver_generate_form_submit"			: approver_generate_form_submit(); break;  
				case "load_detail_for_update"					: load_detail_for_update(); break;  
				case "update_row_details"						: update_row_details(); break;  
				case "cancel_main_request"						: cancel_main_request(); break;  
				case "remove_straight_detail"					: remove_straight_detail(); break;  
				case "send_mail"	 							: send_mail(); break; 
				case "get_email_contents"						: get_email_contents(); break; 
				case "get_email_contents_approved_request"		: get_email_contents_approved_request(); break; 
				case "get_email_contents_disapproved_request"	: get_email_contents_disapproved_request(); break; 
				case "load_records" 							: load_records(); break; 
				case "add_new_record" 							: add_new_record(); break; 
				case "update_fetch_record" 						: update_fetch_record(); break; 
				case "update_record" 							: update_record(); break; 
				case "delete_record" 							: delete_record(); break; 
				case "minus_one_day" 						 	: minus_one_day(); break; 
				case "load_hris_record_all" 	        		: load_hris_record_all(); break;  
				
				/* MANAGE BATCH START */
				case "save_batch_employee"               		: save_batch_employee(); break;  
				case "delete_batch_employee"             		: delete_batch_employee(); break;  
				case "load_hris_record_by_managed_batch"        : load_hris_record_by_managed_batch(); break;
				case "load_employee_number_by_name"        		: load_employee_number_by_name(); break;
				case "load_employee_name_by_number"        		: load_employee_name_by_number(); break;
				/* MANAGE BATCH END */
				
				/* ADD STRAIGHT 1 BY 1 START */
				case "append_straight_details_one_record"       : append_straight_details_one_record(); break;
				/* VALIDATE PAST DATES */
				case "check_past_dates"       					: check_past_dates(); break;
				
				/* ADD STRAIGHT 1 BY 1 END */
			}
		}
	}

	function is_ajax() {
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}
    
	function load_straight_main_details(){
		require_once('../class/otks.php');
		$return = $_POST;
		$result = "";
		$array_fields = array('date_from','date_to');
		$table 	   	= 'tkstraight_main';
		$joins 	   	= '';
		$sql_where 	= 'WHERE `pkid`= "'.$return['main_pkid'].'" AND `logdel` = "0"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_array($result)){
			$return['date_from']	= $row['date_from'];
			$return['date_to']		= $row['date_to'];
		}
		$return['result'] 		= json_encode($result);
		echo json_encode($return);
	}
	
	function load_straight_details(){
		require_once('../class/otks.php'); 
		$p = $_POST;
		$return = array();
		$result = "";		
		$array_fields = array('*');
		$table 	   	= 'vw_straight_details';
		$joins 	   	= '';
		$sql_where 	= 'WHERE `fkstraight_main` ="'.$p['fkstraight_main'].'" AND `logdel` = "0"';
		$sql_order 	= 'ORDER BY pkid';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$ctr = 0;
		while($row = mysqli_fetch_array($result)){
			$return['LastName'][$ctr] 		= $row['LastName'];
			$return['FirstName'][$ctr] 		= $row['FirstName'];
			$return['pkid'][$ctr] 			= $row['pkid'];
			$return['created_by'][$ctr] 	= $row['created_by'];
			$return['fkstraight_main'][$ctr]= $row['fkstraight_main'];
			$return['empno'][$ctr] 			= $row['empno'];
			$return['date_from'][$ctr] 		= $row['date_from'];
			$return['time_from'][$ctr] 		= $row['time_from'];
			$return['date_to'][$ctr] 		= $row['date_to'];
			$return['time_to'][$ctr] 		= $row['time_to'];
			$return['hours_consumed'][$ctr] = $row['hours_consumed'];
			$return['system_comment'][$ctr] = $row['system_comment'];
			$return['remarks'][$ctr] 		= $row['remarks'];
			$return['username'][$ctr] 		= $row['username'];
			$return['logdel'][$ctr] 		= $row['logdel'];
			$return['date_created'][$ctr] 	= $row['date_created'];
			$ctr++;
		}
		if( !isset($return['empno']) ){
			$return['empno'] = array();
		}
		$return['ctr']	   = $ctr;
//		$return['result']  = $result;
//		$return['result']  = json_encode($result);
		echo json_encode($return);
	}
	
	function load_hris_record_by_username(){
		require_once('../class/otks.php'); //OOP Path
		$return = $_POST;
		$result = "";
		$array_fields = array('EmpNo','lastname','firstname','middlename','lastname','Division','Department','Section');
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
		}
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}
	
	function load_approver_list() {
		require_once('../class/otks.php'); //OOP Path
		$return = $_POST;
		$result = "";
		$array_fields = array('firstname', 'lastname', 'emp_name', 'Section', 'username', 'EmpNo');
		$table 	   	= 'db_hris.vw_secheads';
		$joins 	   	= '';
		$sql_where 	= '';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$ctr = 0;
		while($row = mysqli_fetch_array($result)){
			$return['approver_name'][$ctr] 		= $row['lastname'].', '.$row['firstname'];
			$return['username'][$ctr] 			= $row['username'];
			$return['empno'][$ctr] 				= $row['EmpNo'];
			$ctr++;
		}
		$return['ctr']	  = $ctr;
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}
	
	function load_approver_list_all() {
		require_once('../class/otks.php'); //OOP Path
		$return = $_POST;
		$result = "";
		$array_fields = array('firstname', 'lastname', 'username', 'EmpNo');
		$table 	   	= 'db_hris.vw_emp_hris';
		$joins 	   	= '';
		$sql_where 	= 'WHERE SalaryType=3';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		// $script = OTKS::getInstance()->select_query_test($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$ctr = 0;
		while($row = mysqli_fetch_array($result)){
			$return['approver_name'][$ctr] 		= $row['lastname'].', '.$row['firstname'];
			$return['username'][$ctr] 			= $row['username'];
			$return['empno'][$ctr] 				= $row['EmpNo'];
			$ctr++;
		}
		$return['ctr']	  = $ctr;
		// $return['script'] = $script;
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}
	
	function load_hris_record_by_section(){
		require_once('../class/otks.php'); 
		$return = $_POST;
		$result = "";
		$array_fields = array('EmpNo','lastname','firstname','middlename','lastname','Division','Department','Section');
		$table 	   	= 'db_hris.vw_EmpInfo_Rapid';
		$joins 	   	= '';
		$sql_where 	= 'WHERE `Section` = "'.$return['section'].'"';
		$sql_order 	= 'ORDER BY lastname';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$ctr = 0;
		while($row = mysqli_fetch_array($result)){
			$return['EmpNo'][$ctr] 			= $row['EmpNo'];
			$return['lastname'][$ctr] 		= $row['lastname'];
			$return['firstname'][$ctr]		= $row['firstname'];
			$return['middlename'][$ctr] 	= $row['middlename'];
			$return['lastname'][$ctr] 		= $row['lastname'];
			$return['Division'][$ctr] 		= $row['Division'];
			$return['Department'][$ctr]		= $row['Department'];
			$return['Section'][$ctr]		= $row['Section'];
			$ctr++;
		}
		$return['ctr']	  = $ctr;
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}
	
	function fetch_main_data_update(){
		require_once('../class/otks.php');
		$return = $_POST;
		$result = "";
		$array_fields = array('*');
		$table 	   	= 'tkstraight_main';
		$joins 	   	= '';
		$sql_where 	= 'WHERE `pkid`= "'.$return['pkid'].'"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$ctr = 0;
		while($row = mysqli_fetch_array($result)){
			$return['pkid'][$ctr] 			= $row['pkid'];
			$return['status'][$ctr] 		= $row['status'];
			$new_date 						= date('Y-m-d', strtotime($row['date_created']));
			$return['req_date'][$ctr] 		= $new_date;
			$return['date_from'][$ctr] 		= $row['date_from'];
			$return['manpower'][$ctr] 		= $row['manpower'];
			$return['justification'][$ctr] 	= strip_tags($row['justification']);
			$return['date_to'][$ctr]		= $row['date_to'];
			$return['created_by'][$ctr]		= $row['created_by'];
			$return['approver'][$ctr]		= $row['approver'];
			$return['username'][$ctr] 		= $row['username'];
			$ctr++;
		}
		$return['ctr']	  	  	= $ctr;
		$return['result'] 		= json_encode($result);
		echo json_encode($return);
	}

	function save_straight_main_information	(){
		require_once('../class/otks.php');
		$p = $_POST;
		$result 		= "";
		$table   		= "tkstraight_main"; //table name
		$array_fields 	= array('date_created',
								'created_by',
								'manpower',
								'date_from',
								'date_to',
								'approver',
								'justification',
								'status',
								'username',
								'lastupdate'); //table fields
		$array_values 	= array(date('Y-m-d H:i:s'),
								$p['username'],
								$p['txt_manpower_involved'],
								$p['txt_date_from'],
								$p['txt_date_to'],
								$p['approver'],
								$p['txt_justification'],
								'0',
							   	$p['username'],
								date('Y-m-d H:i:s')
							   ); //values to be saved
		$result 		= OTKS::getInstance()->insert_query($table,$array_fields,$array_values);
		
		/* Load last pkid created by user */
		$result = "";
		$array_fields = array('MAX(`pkid`) as max_pkid');
		$table 	   	= 'tkstraight_main';
		$joins 	   	= '';
		$sql_where 	= 'WHERE `username`= "'.$p['username'].'" AND `logdel` = "0"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_array($result)){
			$max_pkid = $row['max_pkid'];
		}
		$return['max_pkid'] = $max_pkid;
		$return["result"] = json_encode($result); //return the the serialize values
		echo json_encode($return); //json encode since I used a dataType json before passing the serialized values here
	}

	function update_straight_main_information(){
		require_once('../class/otks.php');
		$p 			  = $_POST;
		$result 	  = "";
		$table        = "tkstraight_main";
		$array_fields = array('manpower',
							  'date_from',
							  'date_to',
							  'approver',
							  'justification',
							  'username',
							  'lastupdate'
							 );
		$array_values = array($p['txt_manpower_involved_edit'],
							  $p['txt_date_from_edit'],
							  $p['txt_date_to_edit'],
							  $p['approver'],
							  $p['txt_justification_edit'],
							  $p['username'],
							  date('Y-m-d H:i:s')
							 );
		$pkid = $p['pkid'];
		$result = OTKS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
		$return["result"] = json_encode($result); //return the the serialize values
		echo json_encode($return); //json encode since I used a dataType json before passing the serialized values here
	}

	function update_main_status(){
		require_once('../class/otks.php');
		$p = $_POST;
		$p 			  = $_POST;
		$result 	  = "";
		$table        = "tkstraight_main";
		$array_fields = array(	'status',
							  	'username',
							  	'lastupdate'
							 );
		$array_values = array($p['status'],
							  $p['username'],
							  date('Y-m-d H:i:s')
							 );
		$pkid = $p['main_pkid'];
		$result = OTKS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
		$return["result"] = json_encode($result); //return the the serialize values
		echo json_encode($return); //json encode since I used a dataType json before passing the serialized values here
	}
	
	function update_main_justification(){
		require_once('../class/otks.php');
		$p 			  = $_POST;
		/* Fetch last remarks */
		$result = "";
		$array_fields = array('justification');
		$table 	   	= 'tkstraight_main';
		$joins 	   	= '';
		$sql_where 	= 'WHERE `pkid`= "'.$p['pkid'].'"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_array($result)){
			$justification_recent = $row['justification'];
		}
		
		$disapproved_remarks = $justification_recent.'<br><br><b>Disapproved Remarks('.date('Y-m-d H:i:s').')</b><br>'.$p['remarks'];
		
		$result 	  = "";
		$table        = "tkstraight_main";
		$array_fields = array(	'justification',
							  	'username',
							  	'lastupdate'
							 );
		$array_values = array($disapproved_remarks,
							  $p['username'],
							  date('Y-m-d H:i:s')
							 );
		$pkid = $p['pkid'];
		$result = OTKS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
		$return["result"] = json_encode($result); //return the the serialize values
		echo json_encode($return); //json encode since I used a dataType json before passing the serialized values here
	}
	
	function generate_form_submit(){
		$p = $_POST;
		session_start();
		$user_type = $_SESSION['user_type'];
		if($user_type == 0){
			$page = 'index_requestor.php';
		}
		if($user_type == 1){
			$page = 'index_approver.php';
		}
		$html_form  = '<form id="frm-submit-details" method="post" action="'.$page.'?page=straight_hours.php">';
		$html_form .= '	<input type="hidden" value="'.$p['pkid'].'" name="pkid">';
		$html_form .= '</form>';
		$return = array();
		$return['html'] = $html_form;
		echo json_encode($return);
	}
	
	function approver_generate_form_submit(){
		$p = $_POST;
		$html_form  = '<form id="frm-submit-details" method="post" action="index_requestor.php?page=approver_straight_hours.php">';
		$html_form .= '	<input type="hidden" value="'.$p['pkid'].'" name="pkid">';
		$html_form .= '</form>';
		$return = array();
		$return['html'] = $html_form; 
		echo json_encode($return);
	}
	
	function load_detail_for_update(){
		require_once('../class/otks.php');
		$p = $_POST;
		$return = array();
		$array_fields = array('*');
		$table 	   	= 'vw_straight_details';
		$joins 	   	= '';
		$sql_where 	= 'WHERE `pkid` = "'.$p['pkid'].'" AND `logdel` = "0"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_array($result)){
			$return['LastName'] 		= $row['LastName'];
			$return['FirstName'] 		= $row['FirstName'];
			$return['pkid'] 			= $row['pkid'];
			$return['created_by'] 		= $row['created_by'];
			$return['fkstraight_main'] 	= $row['fkstraight_main'];
			$return['empno'] 			= $row['empno'];
			$return['date_from'] 		= $row['date_from'];
			$return['time_from'] 		= $row['time_from'];
			$return['date_to'] 			= $row['date_to'];
			$return['time_to'] 			= $row['time_to'];
			$return['hours_consumed'] 	= $row['hours_consumed'];
			$return['system_comment'] 	= $row['system_comment'];
			$return['remarks'] 			= $row['remarks'];
			$return['username'] 		= $row['username'];
			$return['logdel'] 			= $row['logdel'];
		}	
//		$return['query'] = $result;
		echo json_encode($return);
	}

	function update_row_details(){
		require_once('../functions/php_functions.php');
		
		$p = $_POST;
		
		$return = array();
		
		$empno 		= $p['txt_update_employee_number'];
		$emp_name 	= $p['txt_update_employee_name'];
		
			
		/* Concatinate Date In and Time in as well as Date Out and Time Out */
		$date_time_in = $p['txt_update_employee_date_in'].' '.$p['txt_update_employee_time_in'];
		$date_time_out = $p['txt_update_employee_date_out'].' '.$p['txt_update_employee_time_out'];

		/* Get time difference using a funtion this will return as an array with an index of hour and min */
		$diff = check_time_difference($date_time_in,$date_time_out);
		if( !is_array( $diff ) ){
			$valid = 0;
			$hours_consumed = $diff;
		}else{
			/* Set hours consumed based on the functions return value */
			$hours_consumed = $diff['hour']. ' hours and ' .$diff['min'].' mins';
		}			
		
		$remarks 	= $p['txt_update_employee_remarks'];
		
		/* Check if time rendered is less than 24 hours and return an error message */
		// if( $diff['hour'] < 24 ){
			// $system_message = 'Warning! Straight hours requires at least 24 hours';
			// $valid = 0;
		// }else{
			// $system_message = '';
		// }
		if( $diff['hour'] < 16 ){
			$system_message = 'Warning! Straight hours requires at least 16 hours';
			$valid = 0;
		}else{
			$system_message = '';
		}
		
		$return['empno'] 			= $empno;
		$return['emp_name'] 		= $emp_name;
		$return['date_time_in'] 	= $date_time_in;
		$return['date_time_out'] 	= $date_time_out;
		$return['hours_consumed'] 	= $hours_consumed;
		$return['system_message'] 	= $system_message;
		$return['remarks'] 			= $remarks;
		
		echo json_encode($return);
	}

	function cancel_main_request(){
		require_once('../class/otks.php');
		$p = $_POST;
		/* Fetch last remarks */
		$result = "";
		$array_fields = array('justification');
		$table 	   	= 'tkstraight_main';
		$joins 	   	= '';
		$sql_where 	= 'WHERE `pkid`= "'.$p['pkid'].'"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_array($result)){
			$justification_recent = $row['justification'];
		}
		
		$cancellation_remarks = $justification_recent.'<br><br><b>Cancellation Remarks('.date('Y-m-d H:i:s').')</b><br>'.$p['remarks'];
		$return	 	  = array();
		$result 	  = "";
		$table        = "tkstraight_main";
		$array_fields = array('status','Justification');
		$array_values = array('4',$cancellation_remarks);
		$pkid = $p['pkid'];
		$result = OTKS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
//		$return['query'] = $result;
		$return["result"] = $result; //return the the serialize values
		echo json_encode($return);
	}

	function remove_straight_detail(){
		require_once('../class/otks.php');
		$p = $_POST;
		
		$return = array();
		$result = "";
		$table        = "tkstraight_details";
		$array_fields = array('logdel');
		$array_values = array('1');
		$pkid = $p['pkid'];
		$result = OTKS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
//		$return['query'] = $result;
		$return["result"] = json_encode($result); //return the the serialize values
		echo json_encode($return); //json encode since I used a dataType json before passing the serialized values here
	}

	function send_mail(){
		require_once('../class/email.php');
		$send_mail = new SENDMAIL;
		$p 				= $_POST;
		// $from 			= 'issinfoservice@pricon.ph';
		$fromName 		= 'OTKS System';
		$recipient		= $p['recipient'];
		$CCrecipient	= $p['cc_recipient'];
		$subject		= $p['subject'];
		$message      	= $p['message'];
		$message_sent	= $send_mail->email_with_no_attachment($CCrecipient,$fromName,$recipient,$CCrecipient,$subject,$message);
		$return 		= array();
		$return['result'] = $message_sent;
		echo json_encode($return);
	}
	
	function get_email_contents(){
		require_once('../class/otks.php');
		$p = $_POST;
		$return = array();
		
		/* get approver username, date of creation, and Justification */
		$result = "";
		$array_fields = array('approver',
							  'date_created',
							  'justification' );
		$table 	   	= 'tkstraight_main';
		$joins 	   	= '';
		$sql_where 	= 'WHERE `pkid` ="'.$p['main_pkid'].'" AND `logdel` = "0"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		
		while($row = mysqli_fetch_array($result)){
			$approver 		= $row['approver'];
			$date 			= $row['date_created'];
			$justification 	= $row['justification'];
		}
		
		/* get email address approver */
		$result = "";
		$array_fields = array('hris.email_add');
		$table 	   	= 'db_hris.vw_EmpInfo_Rapid AS hris';
		$joins 	   	= '';
		$sql_where 	= 'WHERE `username` ="'.$approver.'"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_array($result)){
			$approver_email = $row['email_add'];
		}
		
		/* get requestor information */
		$result = "";
		$array_fields = array('hris.lastname',
							  'hris.firstname',
							  'hris.EmpNo',
							  'email_add');
		$table 	   	= 'db_hris.vw_EmpInfo_Rapid AS hris';
		$joins 	   	= '';
		$sql_where 	= 'WHERE `username` ="'.$p['username'].'"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_array($result)){
			$requestor_name  		= $row['lastname'] . ', ' .$row['firstname'];
			$requestor_empno 		= $row['EmpNo'];
			$requestor_email_add 	= $row['email_add'];
		}
		
		$message  = 'Please be informed that you have a <b>Straight Hours</b> request for approval.<br><br>';
		$message .= 'Below are the details: <br>';
		$message .= 'Requestor     : '.$requestor_name.'<br>';
		$date	  = date( 'M. d, Y', strtotime($date) );
		$message .= 'Date     	   : '.$date.'<br>';
		$message .= 'Justification : '.$justification.'<br><br>';
		$message .= '<i>For more info, please log-in to your systemone account. Go to http://systemone/ <br>';
		$message .= 'This E-mail is automatically generated by the OTKS Straight Hours Request Module. <br>';
		$message .= 'Do not reply to this e-mail, this is only a notification created by the system, Thank you! </i><br><br>';
		
		$message .= 'Notice of Disclaimer:';
		$message .= 'This message (including any attachments) contains confidential information intended for a specific individual and purpose, and is protected by law. If you are not the intended recipient, you should delete this message. Any disclosure,copying, or distribution of this message, or the taking of any action based on it, is strictly prohibited.';
		
		
		$return['recipient'] = $approver_email;
		$return['cc'] 		 = $requestor_email_add;
		$return['message'] 	 = $message;
		echo json_encode($return);
	}
	
	function get_email_contents_approved_request(){
		require_once('../class/otks.php');
		$p = $_POST;
		$return = array();
		
		/* get requestor username, date of creation, and Justification */
		$result = "";
		$array_fields = array('created_by',
							  'date_created',
							  'justification' );
		$table 	   	= 'tkstraight_main';
		$joins 	   	= '';
		$sql_where 	= 'WHERE `pkid` ="'.$p['main_pkid'].'" AND `logdel` = "0"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		
		while($row = mysqli_fetch_array($result)){
			$created_by		= $row['created_by'];
			$date 			= $row['date_created'];
			$justification 	= $row['justification'];
		}
		
		/* get email address approver */
		$result = "";
		$array_fields = array('hris.email_add');
		$table 	   	= 'db_hris.vw_EmpInfo_Rapid AS hris';
		$joins 	   	= '';
		$sql_where 	= 'WHERE `username` ="'.$p['username'].'"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_array($result)){
			$approver_email = $row['email_add'];
			
		}
		
		/* get requestor information */
		$result = "";
		$array_fields = array('hris.lastname',
							  'hris.firstname',
							  'hris.EmpNo',
							  'email_add');
		$table 	   	= 'db_hris.vw_EmpInfo_Rapid AS hris';
		$joins 	   	= '';
		$sql_where 	= 'WHERE `username` ="'.$created_by.'"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_array($result)){
			$requestor_name  		= $row['lastname'] . ', ' .$row['firstname'];
			$requestor_empno 		= $row['EmpNo'];
			$requestor_email_add 	= $row['email_add'];
		}
		
		$message  = 'Please be informed that your <b>Straight Hours</b> request has been <b>approved.</b><br><br>';
		$message .= 'Below are the details: <br>';
		$message .= 'Requestor     : '.$requestor_name.'<br>';
		$date	  = date( 'M. d, Y', strtotime($date) );
		$message .= 'Date     	   : '.$date.'<br>';
		$message .= 'Justification : '.$justification.'<br><br>';
		$message .= '<i>Requestor e-mail:'.$requestor_email_add.'</i><br>';
		$message .= '<i>Approver e-mail:'.$approver_email.'</i><br><br>';
		$message .= '<i>For more info, please log-in to your systemone account. Go to http://systemone/ <br>';
		$message .= 'This E-mail is automatically generated by the OTKS Straight Hours Request Module. <br>';
		$message .= 'Do not reply to this e-mail, this is only a notification created by the system, Thank you! </i><br><br>';
		
		$message .= 'Notice of Disclaimer:';
		$message .= 'This message (including any attachments) contains confidential information intended for a specific individual and purpose, and is protected by law. If you are not the intended recipient, you should delete this message. Any disclosure,copying, or distribution of this message, or the taking of any action based on it, is strictly prohibited.';
		
		
		$return['recipient'] = $requestor_email_add;
		$return['cc'] 		 = $approver_email;
		$return['message'] 	 = $message;
		echo json_encode($return);
	}
	
	function get_email_contents_disapproved_request(){
		require_once('../class/otks.php');
		$p = $_POST;
		$return = array();
		
		/* get requestor username, date of creation, and Justification */
		$result = "";
		$array_fields = array('created_by',
							  'date_created',
							  'justification' );
		$table 	   	= 'tkstraight_main';
		$joins 	   	= '';
		$sql_where 	= 'WHERE `pkid` ="'.$p['main_pkid'].'" AND `logdel` = "0"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		
		while($row = mysqli_fetch_array($result)){
			$created_by		= $row['created_by'];
			$date 			= $row['date_created'];
			$justification 	= $row['justification'];
		}
		
		/* get email address approver */
		$result = "";
		$array_fields = array('hris.email_add');
		$table 	   	= 'db_hris.vw_EmpInfo_Rapid AS hris';
		$joins 	   	= '';
		$sql_where 	= 'WHERE `username` ="'.$p['username'].'"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_array($result)){
			$approver_email = $row['email_add'];
			
		}
		
		/* get requestor information */
		$result = "";
		$array_fields = array('hris.lastname',
							  'hris.firstname',
							  'hris.EmpNo',
							  'email_add');
		$table 	   	= 'db_hris.vw_EmpInfo_Rapid AS hris';
		$joins 	   	= '';
		$sql_where 	= 'WHERE `username` ="'.$created_by.'"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_array($result)){
			$requestor_name  		= $row['lastname'] . ', ' .$row['firstname'];
			$requestor_empno 		= $row['EmpNo'];
			$requestor_email_add 	= $row['email_add'];
		}
		
		$message  = 'Please be informed that your <b>Straight Hours</b> request has been <b>disapproved.</b><br><br>';
		$message .= 'Below are the details: <br>';
		$message .= 'Requestor     : '.$requestor_name.'<br>';
		$date	  = date( 'M. d, Y', strtotime($date) );
		$message .= 'Date     	   : '.$date.'<br>';
		$message .= 'Justification : '.$justification.'<br><br>';
		$message .= '<i>Requestor e-mail:'.$requestor_email_add.'</i><br>';
		$message .= '<i>Approver e-mail:'.$approver_email.'</i><br><br>';
		$message .= '<i>For more info, please log-in to your systemone account. Go to http://systemone/ <br>';
		$message .= 'This E-mail is automatically generated by the OTKS Straight Hours Request Module. <br>';
		$message .= 'Do not reply to this e-mail, this is only a notification created by the system, Thank you! </i><br><br>';
		
		$message .= 'Notice of Disclaimer:';
		$message .= 'This message (including any attachments) contains confidential information intended for a specific individual and purpose, and is protected by law. If you are not the intended recipient, you should delete this message. Any disclosure,copying, or distribution of this message, or the taking of any action based on it, is strictly prohibited.';
		
		
		$return['recipient'] = $requestor_email_add;
		$return['cc'] 		 = $approver_email;
		$return['message'] 	 = $message;
		echo json_encode($return);
	}

	function append_new_straight_details(){
		$p = $_POST;

		$array_empno = $p['array_empno'];
		$array_emp_name = $p['array_emp_name'];
		
		$return = array();
		
		/* Array Declarations */
		$array_records = array();
		$array_records['empno'] = array();
		$array_records['emp_name'] = array();
		$array_records['date_time_in'] = array();
		$array_records['date_time_out'] = array();
		$array_records['hours_consumed'] = array();
		$array_records['system_message'] = array();
		$array_records['remarks'] = array();
		$array_records['valid'] = array();
		
		/* Array Declarations for existing records */
		$array_existing_records = array();
		$array_existing_records['empno'] = array();
		$array_existing_records['emp_name'] = array();
		$array_existing_records['date_time_in'] = array();
		$array_existing_records['date_time_out'] = array();
		
		require_once('../functions/php_functions.php');
		
		for($x=0;$x<count($array_empno);$x++){
			/* check if employee has an existing record */
			
			/* Concatinate Date In and Time in as well as Date Out and Time Out */
			$date_time_in = $p['txt_batch_date_in'].' '.$p['txt_batch_time_in'];
			$date_time_out = $p['txt_batch_date_out'].' '.$p['txt_batch_time_out'];
			
			$exist = check_existing_straight($array_empno[$x],$p['txt_batch_date_in']);
			
			if($exist == 1 ){
				array_push($array_existing_records['empno'], $array_empno[$x]);
				array_push($array_existing_records['emp_name'], $array_emp_name[$x]);
				array_push($array_existing_records['date_time_in'], $date_time_in);
				array_push($array_existing_records['date_time_out'], $date_time_out);
				continue;
			}
			
			/* checking of validation */
			$valid = 1;
			
			array_push($array_records['empno'], $array_empno[$x]);
			array_push($array_records['emp_name'], $array_emp_name[$x]);
			
			
			/* Push concatinated values into our array */
			array_push($array_records['date_time_in'], $date_time_in);
			array_push($array_records['date_time_out'], $date_time_out);
			
			/* Get time difference using a funtion this will return as an array with an index of hour and min */
			$diff = check_time_difference($date_time_in,$date_time_out);
			if( !is_array( $diff ) ){
				$valid = 0;
				$hours_consumed = $diff;
			}else{
				/* Set hours consumed based on the functions return value */
				$hours_consumed = $diff['hour']. ' hours and ' .$diff['min'].' mins';
			}			
			
			/* Push values into array */
			array_push($array_records['hours_consumed'], $hours_consumed);
			
			
			/* Check if time rendered is less than 24 hours and return an error message */
			// if( $diff['hour'] < 24 ){
				// $system_message = 'Warning! Straight hours requires at least 24 hours';
				// $valid = 0;
			// }else{
				// $system_message = '';
			// }
			if( $diff['hour'] < 16 ){
				$system_message = 'Warning! Straight hours requires at least 16 hours';
				$valid = 0;
			}else{
				$system_message = '';
			}

			/* Push records into our array */
			array_push($array_records['valid'],'<input type="hidden" value="'.$valid.'">');
			array_push($array_records['system_message'],$system_message);
			array_push($array_records['remarks'],$p['txt_batch_remarks']);
		}
		
		$return['records'] = $array_records;
		$return['existing_records'] = $array_existing_records;
		echo json_encode($return);
	}
	
	function check_existing_straight($empno,$date_in){
		require_once('../class/otks.php');
		$array_fields = array('empno','tkstraight_details.date_from');
		$table 	   	= 'tkstraight_details';
		$joins 	   	= 'INNER JOIN tkstraight_main ON tkstraight_main.pkid = tkstraight_details.fkstraight_main';
		$sql_where 	= 'WHERE `empno` = "'.$empno.'" AND tkstraight_details.`date_from` = "'.$date_in.'" AND tkstraight_details.`logdel` = "0" AND tkstraight_main.logdel=0 AND tkstraight_main.status != "4";';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_array($result)){
			return 1;
		}
		return 0;
	}

	function save_straight_details(){
		require_once('../class/otks.php');
		$p = $_POST;
		$return = array();
//		$array_existing_records['array_pkid'] = array();
//		$array_existing_records['empno'] = array();
//		$array_existing_records['emp_name'] = array();
//		$array_existing_records['date_time_in'] = array();
//		$array_existing_records['date_time_out'] = array();
		$result = '';
		for($x=0;$x<count($p['array_empno']);$x++){
			if($p['array_pkid'][$x] != 0){
				/* update if pkid != 0 */
				$result 	  = "";
				$table        = "tkstraight_details";
				$array_fields = array(	'date_from',
										'time_from',
										'date_to',
										'time_to',
										'hours_consumed',
										'system_comment',
										'remarks',
										'username',
										'lastupdate' );
				$array_values = array(	$p['array_date_in'][$x],
										$p['array_time_in'][$x],
										$p['array_date_out'][$x],
										$p['array_time_out'][$x],
										$p['array_hours_consumed'][$x],
										$p['array_system_comment'][$x],
										$p['array_remarks'][$x],
										$p['username'],
										date('Y-m-d H:i:s') );
				$pkid = $p['array_pkid'][$x];
				$result = OTKS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
			}else{
				$result 		= "";
				/* save if pkid == 0 */
//				$check_exist = check_existing_straight($p['array_empno'][$x],$p['array_date_in'][$x]);
//				if($check_exist == 1){
//					array_push($array_existing_records['empno'], $p['array_empno'][$x]);
//					array_push($array_existing_records['emp_name'], $p['array_empname'][$x]);
//					array_push($array_existing_records['date_time_in'], $p['array_date_in'][$x] . ' ' . $p['array_time_in'][$x]);
//					array_push($array_existing_records['date_time_out'], $p['array_date_out'][$x] . ' ' . $p['array_time_out'][$x]);
//					continue;
//				}
				$result 		= "";
				$table   		= "tkstraight_details"; //table name
				$array_fields 	= array('date_time_created',
										'created_by',
										'fkstraight_main',
										'empno',
										'date_from',
										'time_from',
										'date_to',
										'time_to',
										'hours_consumed',
										'system_comment',
										'remarks',
										'username',
										'lastupdate'); //table fields
				$array_values 	= array(date('Y-m-d H:i:s'),
										$p['username'],
										$p['fkstraight_main'],
										$p['array_empno'][$x],
										$p['array_date_in'][$x],
										$p['array_time_in'][$x],
										$p['array_date_out'][$x],
										$p['array_time_out'][$x],
										$p['array_hours_consumed'][$x],
										$p['array_system_comment'][$x],
										$p['array_remarks'][$x],
										$p['username'],
										date('Y-m-d H:i:s')
									   ); //values to be saved
				$result 		= OTKS::getInstance()->insert_query($table,$array_fields,$array_values);
			}
		}
		$result = "Record Saved!";
		$return["result"] = $result; //return the the serialize values
		echo json_encode($return); //json encode since I used a dataType json before passing the serialized values here
	}
	
	/* function for displaying record */
	function load_records(){
		require_once('../class/otks.php'); 
		$return = $_POST;
		$result = "";
		$array_fields = array('*');
		$table 	   	= 'tbl_records';
		$joins 	   	= '';
		$sql_where 	= '';
		$sql_order 	= 'ORDER BY pkid';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$ctr = 0;
		while($row = mysqli_fetch_array($result)){
			$return['pkid'][$ctr] 		= $row['pkid'];
			$return['name'][$ctr] 		= $row['name'];
			$return['lastname'][$ctr] 	= $row['lastname'];
			$return['address'][$ctr] 	= $row['address'];
			$return['remarks'][$ctr] 	= $row['remarks'];
			$ctr++;
		}
		$return['ctr']	  = $ctr;
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}
	
	/* function for adding record */
	function add_new_record(){
		require_once('../class/otks.php'); 
		$return 		= $_POST; 
		$result 		= "";
		$table   		= "tbl_records"; //table name
		$array_fields 	= array('name','lastname','address','remarks'); //table fields
		$array_values 	= array($return['txt_name'],$return['txt_lastname'],$return['txt_address'],$return['txt_remarks']); //values to be saved
		$result 		= OTKS::getInstance()->insert_query($table,$array_fields,$array_values);
		$return["result"] = json_encode($result); //return the the serialize values
		echo json_encode($return); //json encode since I used a dataType json before passing the serialized values here
	}
	
	/* function for fetching record */
	function update_fetch_record(){
		require_once('../class/otks.php'); 
		$return = $_POST; 
		$result = "";
		$array_fields = array('*');
		$table 	   	= 'tbl_records';
		$joins 	   	= '';
		$sql_where 	= 'WHERE `pkid` ='.$return['pkid'];
		$sql_order 	= 'ORDER BY pkid';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$ctr = 0;
		while($row = mysqli_fetch_array($result)){
			$return['pkid2'][$ctr] 		= $row['pkid'];
			$return['name'][$ctr] 		= $row['name'];
			$return['lastname'][$ctr] 	= $row['lastname'];
			$return['address'][$ctr] 	= $row['address'];
			$return['remarks'][$ctr] 	= $row['remarks'];
			$ctr++;
		}
		$return['ctr'] = $ctr;
		$return["result"] = json_encode($result); //return the the serialize values
		echo json_encode($return);//json encode since I used a dataType json before passing the serialized values here
	}
	
	/* function for updating record */
	function update_record(){
		require_once('../class/otks.php'); 
		$return = $_POST; 
		$result = "";
		$table        = "tbl_records";
		$array_fields = array('name','lastname','address','remarks');
		$array_values = array($return['txt_name_update'],$return['txt_lastname_update'],$return['txt_address_update'],$return['txt_remarks_update']);
		$pkid = $return['txt_pkid'];
		$result = OTKS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
		$return["result"] = json_encode($result); //return the the serialize values
		echo json_encode($return); //json encode since I used a dataType json before passing the serialized values here
	}
	
	/* function for deleting a record */
	function delete_record(){
		require_once('../class/otks.php'); 
		$return 	= $_POST;
		$result 	= "";
		$table   	= "tbl_records";
		$pkid 		= $return['pkid'];
		$result 	= OTKS::getInstance()->delete_query($table,$pkid);
		$return["result"] = json_encode($result); //return the the serialize values
		echo json_encode($return); //json encode since I used a dataType json before passing the serialized values here
	}

    function minus_one_day(){
        $date = $_POST['date'];
        $new_date = date('Y-m-d', strtotime('-1 day',strtotime($date)));
        $return["new_date"] = $new_date;
		echo json_encode($return); //json encode since I used a dataType json before passing the serialized values here
    }
	
	function load_hris_record_all(){
		require_once('../class/otks.php'); //OOP Path
		$return = $_POST;
		$result = "";
		$array_fields = array('EmpNo','lastname','firstname','middlename','lastname','Division','Department','Section');
		$table 	   	= 'db_hris.vw_EmpInfo_Rapid';
		$joins 	   	= '';
		$sql_where 	= '';
		$sql_order 	= 'ORDER BY lastname';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
//		$return['msg'] = $result;
		$ctr = 0;
		while($row = mysqli_fetch_array($result)){
			$return['EmpNo'][$ctr] 			= $row['EmpNo'];
			$return['lastname'][$ctr] 		= $row['lastname'];
			$return['firstname'][$ctr]		= $row['firstname'];
			$return['middlename'][$ctr] 	= $row['middlename'];
			$return['lastname'][$ctr] 		= $row['lastname'];
			$return['Division'][$ctr] 		= $row['Division'];
			$return['Department'][$ctr]		= $row['Department'];
			$return['Section'][$ctr]		= $row['Section'];
			$ctr++;
		}
		$return['ctr']	  = $ctr;
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}
	
	/* MANAGE BATCH START */
	function save_batch_employee(){
		require_once('../class/otks.php'); //OOP Path

		/* check if record already exist on the table */
		$return = $_POST;
		$result = "";
		$array_fields = array('*');
		$table 	   	= 'vw_batch_employee_list';
		$joins 	   	= '';
		$sql_where 	= 'WHERE username = "'.$return['username'].'" AND `empno` = "'.$return['emp_no'].'";';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($result->num_rows != 0){
		   $return['invalid'] = true;
		   $return['msg'] 	  = "Record already exist!";
		   echo json_encode($return);
		   exit();	
		}

		/* check if record exist in hris */
		$return = $_POST;
		$result = "";
		$array_fields = array('*');
		$table 	   	= 'db_hris.tbl_EmployeeInfo hris';
		$joins 	   	= '';
		$sql_where 	= 'WHERE hris.EmpNo = "'.$return['emp_no'].'";';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($result->num_rows == 0){
		   $return['invalid'] = true;
		   $return['msg'] 	  = "Employee does not exist in HRIS!";
		   echo json_encode($return);
		   exit();	
		}
		
		/* insert record */
		$result 		= "";
		$table   		= "tbl_batch_employee_list"; //table name
		$array_fields 	= array('empno','username'); //table fields
		$array_values 	= array($return['emp_no'],$return['username']); //values to be saved
		$result 		= OTKS::getInstance()->insert_query($table,$array_fields,$array_values);
		$return["result"] = json_encode($result); //return the the serialize values
		$return['invalid'] = false;
		echo json_encode($return); //json encode since I used a dataType json before passing the serialized values here
	}
	
	function delete_batch_employee(){
		require_once('../class/otks.php'); //OOP Path
		$return 	  = $_POST; 
		$result 	  = "";
		$table        = "tbl_batch_employee_list";
		$array_fields = array('lastupdate','username','logdel');
		$array_values = array(date('Y-m-d H:i:s'),$return['username'],'1');
		$pkid = $return['pkid'];
		$result = OTKS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
		$return["result"] = json_encode($result); //return the the serialize values
		echo json_encode($return); //json encode since I used a dataType json before passing the serialized values here
	}
	
	function load_hris_record_by_managed_batch(){
		require_once('../class/otks.php'); //OOP Path
		$return = $_POST;
		$result = "";
		$array_fields = array('empno','fullname');
		$table 	   	= 'vw_batch_employee_list';
		$joins 	   	= '';
		$sql_where 	= 'WHERE `username` = "'.$return['username'].'"';
		$sql_order 	= 'ORDER BY empno';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$ctr = 0;
		while($row = mysqli_fetch_array($result)){
			$return['empno'][$ctr] 			= $row['empno'];
			$return['fullname'][$ctr] 		= $row['fullname'];
			$return['pkid'][$ctr] 			= $row['pkid'];
			$ctr++;
		}
		$return['ctr']	  = $ctr;
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}
	
	function load_employee_number_by_name() {
		require_once('../class/otks.php'); //OOP Path
		$return = $_POST;
		$result = "";
		$array_fields = array('EmpNo');
		$table 	   	= 'db_hris.vw_EmpInfo_Rapid';
		$joins 	   	= '';
		$sql_where 	= 'WHERE CONCAT( lastname,  ", ", firstname )="'.$return['emp_name'].'"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($result->num_rows == 0) {
           $return['msg']  = 'Not found';
        } else {
            if($row = mysqli_fetch_array($result)){
                $return['emp_no'] 	    = $row['EmpNo'];
                $return['msg']          = 'Ok';
            }   
        }
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}
	
	function load_employee_name_by_number() {
		require_once('../class/otks.php'); //OOP Path
		$return = $_POST;
		$result = "";
		$array_fields = array('CONCAT(lastname,", ",firstname) as emp_name');
		$table 	   	= 'db_hris.vw_EmpInfo_Rapid';
		$joins 	   	= '';
		$sql_where 	= 'WHERE `EmpNo`="'.$return['emp_no'].'"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($result->num_rows == 0) {
           $return['msg']  = 'Not found';
        } else {
            if($row = mysqli_fetch_array($result)){
                $return['emp_name'] 	    = $row['emp_name'];
                $return['msg']              = 'Ok';
            }   
        }
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}
	
	/* MANAGE BATCH END */
	
	function append_straight_details_one_record(){
		require_once('../class/otks.php'); //OOP Path
		$return = $_POST;
		$exist = check_existing_straight($return['txt_add_employee_number'],$return['txt_add_employee_date_in']);
		
		$date_time_in = $return['txt_add_employee_date_in'] . " " . $return['txt_add_employee_time_in'];
		$date_time_out = $return['txt_add_employee_date_out'] . " " . $return['txt_add_employee_time_out'];
		
		if($exist != 0){
			/* return a validation message */
			$return['empno'] 			= strtoupper($return['txt_add_employee_number']);
			$return['emp_name'] 		= $return['txt_add_employee_name'];
			$return['date_time_in'] 	= $date_time_in;
			$return['date_time_out'] 	= $date_time_out;
		}else{
			$return['empno'] 			= strtoupper($return['txt_add_employee_number']);
			$return['emp_name'] 		= $return['txt_add_employee_name'];
			$return['date_time_in'] 	= $date_time_in;
			$return['date_time_out'] 	= $date_time_out;
			$return['remarks'] 			= $return['txt_add_employee_remarks'];
			
			require_once('../functions/php_functions.php');
			/* Get time difference using a funtion this will return as an array with an index of hour and min */
			$diff = check_time_difference($date_time_in,$date_time_out);
			if( !is_array( $diff ) ){
				$valid = 0;
				$hours_consumed = $diff;
			}else{
				/* Set hours consumed based on the functions return value */
				$hours_consumed = $diff['hour']. ' hours and ' .$diff['min'].' mins';
			}			
			
			/* Check if time rendered is less than 24 hours and return an error message */
			// if( $diff['hour'] < 24 ){
				// $system_message = 'Warning! Straight hours requires at least 24 hours';
				// $valid = 0;
			// }else{
				// $system_message = '';
			// }
			if( $diff['hour'] < 16 ){
				$system_message = 'Warning! Straight hours requires at least 16 hours';
				$valid = 0;
			}else{
				$system_message = '';
			}
			
			$return['hours_consumed'] = $hours_consumed;
			$return['system_message'] = $system_message;
		}
		$return['exist'] = $exist;
		echo json_encode($return);
	}
	
	function check_past_dates(){
		$return = array();
		$date = $_POST['date'];
		$date_today = date('Y-m-d');
		if( strtotime($date) < strtotime($date_today) ){
			$return['valid'] = 0;
		}
		echo json_encode($return);
	}
?>