<?php
	if(is_ajax()) {
		if(isset($_POST["action"]) && !empty($_POST["action"])) {
			$action = $_POST["action"];
			switch($action) {
				case "load_hris_record_by_username" 	: load_hris_record_by_username(); break; 
				case "get_overtime_summary" 	        : get_overtime_summary(); break; 
				case "load_hris_record_by_section" 		: load_hris_record_by_section(); break;  
				case "load_hris_record_by_managed_batch": load_hris_record_by_managed_batch(); break;  
				case "load_approver_list" 				: load_approver_list(); break;  
				case "save_main_record" 				: save_main_record(); break;  
				case "update_main_record" 				: update_main_record(); break;  
				case "cancel_request" 				    : cancel_request(); break;  
				case "load_overtime_main_info_by_pkid" 	: load_overtime_main_info_by_pkid(); break;  
				case "load_employee_name_by_number" 	: load_employee_name_by_number(); break;  
				case "load_employee_number_by_name" 	: load_employee_number_by_name(); break;  
				case "check_ot_filed" 	                : check_ot_filed(); break;  
				case "check_ot_filed_array" 	        : check_ot_filed_array(); break;  
				case "load_hris_record_all" 	        : load_hris_record_all(); break;  
				case "remove_overtime_details_per_pkid" : remove_overtime_details_per_pkid(); break;  
				case "insert_overtime" 	           		: insert_overtime(); break;  
				case "get_employee_overtime" 	  		: get_employee_overtime(); break;  
				case "send_email_to_approver" 	   		: send_email_to_approver(); break;  
				case "approve_overtime_details"    		: approve_overtime_details(); break;  
				case "get_approver_overtime_summary"    : get_approver_overtime_summary(); break;  
				case "get_approved_employee_ot_details" : get_approved_employee_ot_details(); break;  
				case "approve_overtime_request"         : approve_overtime_request(); break;  
				case "add_approved_ot_to_data_raw"      : add_approved_ot_to_data_raw(); break;  
				case "send_email_approved_ot"           : send_email_approved_ot(); break;  
				case "disapprove_overtime_request"      : disapprove_overtime_request(); break;  
				case "send_email_disapproved_ot"        : send_email_disapproved_ot(); break;  
				case "get_day_name"                     : get_day_name(); break;  
				case "save_ot_data"                     : save_ot_data(); break;  
				case "delete_ot_details"                : delete_ot_details(); break;  
				
				/* MANAGE BATCH START */
				case "save_batch_employee"               : save_batch_employee(); break;  
				case "delete_batch_employee"             : delete_batch_employee(); break;  
               
			    /* MANAGE BATCH END */
                				
					
				case "load_records" 					: load_records(); break;//switch case, in using ajax an action must be set in order to choose the specific function to use
				case "selec_users" 		    			: selec_users(); break;
				case "add_new_record" 					: add_new_record(); break; //switch case, in using ajax an action must be set in order to choose the specific function to use
				case "update_fetch_record" 				: update_fetch_record(); break; //switch case, in using ajax an action must be set in order to choose the specific function to use
				case "update_record" 					: update_record(); break; //switch case, in using ajax an action must be set in order to choose the specific function to use
				case "delete_record" 					: delete_record(); break; //switch case, in using ajax an action must be set in order to choose the specific function to use
			}
		}
	}

	function is_ajax() {
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}
	
	function load_hris_record_by_username(){
		require_once('../class/oop.php'); //OOP Path
		$return = $_POST;
		$result = "";
		$array_fields = array('EmpNo','lastname','firstname','middlename','lastname','Division','Department','Section');
		$table 	   	= 'db_hris.vw_EmpInfo_Rapid';
		$joins 	   	= '';
		$sql_where 	= 'WHERE username = "'.$return['username'].'"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = OT::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
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

    function get_overtime_summary(){
		require_once('../class/oop.php'); //OOP Path
		$return = $_POST;
		$result = "";
		$array_fields = array("pkid","req_status","req_type","req_date","req_justification","req_manpower","req_datefrom","req_dateto");
		$table 	   	= 'tkovertime_main';
		$joins 	   	= '';
		$sql_where 	= 'WHERE created_by="'.$return['username'].'" AND logdel=0';
		$sql_order 	= 'ORDER BY pkid desc';
		$sql_limit 	= '';
		$result = OT::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
//		$return['msg'] = $result;
		$ctr = 0;
		while($row = mysqli_fetch_array($result)){
			$return['pkid'][$ctr] 	            = $row['pkid'];
			$return['req_status'][$ctr] 	    = $row['req_status'];
			$return['req_type'][$ctr] 	        = $row['req_type'];
			$return['req_date'][$ctr] 	        = date('M d, Y', strtotime($row['req_date']));
			$return['date_ot'][$ctr]		    = date('M d, Y', strtotime($row['req_datefrom'])) . " - " . date('M d, Y', strtotime($row['req_dateto']));
			$return['req_manpower'][$ctr] 		= $row['req_manpower'];
			$return['req_justification'][$ctr] 	= $row['req_justification'];
			$ctr++;
		}
		$return['ctr']	  = $ctr;
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}

	function load_hris_record_by_section(){
		require_once('../class/oop.php'); //OOP Path
		$return = $_POST;
		$result = "";
		$array_fields = array('EmpNo','lastname','firstname','middlename','lastname','Division','Department','Section');
		$table 	   	= 'db_hris.vw_EmpInfo_Rapid';
		$joins 	   	= '';
		$sql_where 	= 'WHERE `Section` = "'.$return['section'].'"';
		$sql_order 	= 'ORDER BY lastname';
		$sql_limit 	= '';
		$result = OT::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
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
	
	function load_hris_record_by_managed_batch(){
		require_once('../class/oop.php'); //OOP Path
		$return = $_POST;
		$result = "";
		$array_fields = array('empno','fullname');
		$table 	   	= 'vw_batch_employee_list';
		$joins 	   	= '';
		$sql_where 	= 'WHERE `username` = "'.$return['username'].'"';
		$sql_order 	= 'ORDER BY empno';
		$sql_limit 	= '';
		$result = OT::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
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
	
	function load_approver_list() {
		require_once('../class/oop.php'); //OOP Path
		$return = $_POST;
		$result = "";
		$array_fields = array('firstname', 'lastname', 'emp_name', 'Section', 'username', 'EmpNo');
		$table 	   	= 'db_hris.vw_secheads';
		$joins 	   	= '';
		$sql_where 	= '';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = OT::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
//		$return['msg'] = $result;
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
    
    function save_main_record(){
		require_once('../class/oop.php'); 
        $last_update = date("Y-m-d H:i:s");
		$return 		= $_POST; 
		$result 		= "";
		$table   		= "tkovertime_main"; 
		$array_fields 	= array("date_created","created_by", "req_type", "req_date", "req_by", "req_manpower", "req_datefrom", "req_dateto", "req_approver", "req_justification", "req_status", "username","lastupdate"); 
		$array_values 	= array(date("Y-m-d H:i:s"),strtolower($return['created_by']),$return['req_type'],$return['req_date'],$return['req_by'],$return['req_manpower'],$return['req_datefrom'],$return['req_dateto'],$return['req_approver'],$return['req_justification'],$return['req_status'],strtolower($return['username']),$last_update); 
		$result 		= OT::getInstance()->insert_query($table,$array_fields,$array_values,$last_update);
        
        // Return the pkid
        $array_fields_pkid = array('pkid');
		$table_pkid 	   	= 'tkovertime_main';
		$joins_pkid 	   	= '';
		$sql_where_pkid 	= 'WHERE `created_by`="' . $return['created_by'] . '" AND `req_type`="' . $return['req_type'] . '" AND `req_date`="' . $return['req_date'] . '" AND `req_by`="' . $return['req_by'] . '" AND `req_manpower`="' . $return['req_manpower'] . '" AND `req_datefrom`="' . $return['req_datefrom'] . '" AND `req_dateto`="' . $return['req_dateto'] . '" AND `req_approver`="' . $return['req_approver'] . '" AND `req_justification`="' . $return['req_justification'] . '" AND `req_status`="' . $return['req_status'] . '" AND `username`="' . $return['username'] . '"';
		$sql_order_pkid 	= '';
		$sql_limit_pkid 	= '';
		$result_pkid = OT::getInstance()->select_query($array_fields_pkid,$table_pkid,$joins_pkid,$sql_where_pkid,$sql_order_pkid,$sql_limit_pkid);
		if($row_pkid = mysqli_fetch_array($result_pkid)){
			$return['pkid']= $row_pkid['pkid'];
		} 
        
		$return["result"] = json_encode($result); //return the the serialize values
		echo json_encode($return); //json encode since I used a dataType json before passing the serialized values here
	}

    function update_main_record(){
		require_once('../class/oop.php'); //OOP Path
		$return = $_POST; 
		$result = "";
		$table = "tkovertime_main";
		$array_fields = array("req_type", "req_by", "req_manpower", "req_datefrom", "req_dateto", "req_approver", "req_justification", "username","lastupdate"); 
		$array_values = array($return['req_type'],$return['username'],$return['txt_manpower_involved_edit'],$return['txt_date_from_edit'],$return['txt_date_to_edit'],$return['approver_name'],$return['justification'],$return['username'],date('Y-m-d H:i:s'));
		$pkid = $return['pkid'];
		$result = OT::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
		$return["msg"] = $result; //return the the serialize values
		$return["result"] = json_encode($result); //return the the serialize values
		echo json_encode($return); //json encode since I used a dataType json before passing the serialized values here
	}
    
    function cancel_request(){
		require_once('../class/oop.php'); //OOP Path
        require_once('../class/send_email.php');
		$return = $_POST; 
		$result = "";
        $cancel_remarks = $return['txt_cancel_remarks'];
        $pkid =$return['pkid'];
        $username =$return['username'];
//        $cancel_remarks = 'test only';
//        $pkid ='1';
//        $username ='ronfern';
        /* Append cancel remarks on justification */
        $array_fields_justi = array('otks.req_justification');
		$table_justi 	   	= 'tkovertime_main otks';
		$joins_justi 	   	= 'INNER JOIN db_hris.vw_EmpInfo_Rapid hris ON hris.username = otks.created_by';
		$sql_where_justi 	= 'WHERE otks.pkid = "'.$pkid.'"';
		$sql_order_justi 	= '';
		$sql_limit_justi 	= '';
		$result_justi = OT::getInstance()->select_query($array_fields_justi,$table_justi,$joins_justi,$sql_where_justi,$sql_order_justi,$sql_limit_justi);
//		$return['msg'] = $result;
		$ctr = 0;
		if($row_justi = mysqli_fetch_array($result_justi)){
			$req_justification = $row_justi['req_justification']." <br> <b>Cancellation Remarks(".date('m/d/y h:i:s A')."): </b>".$cancel_remarks;
            
            /* Add remarks on justification field */
            $array_fields_update = array("req_justification","req_status", "username","lastupdate"); 
            $array_values_update = array($req_justification,'4',$return['username'],date('Y-m-d H:i:s'));
            $msg = OT::getInstance()->update_query($table_justi,$array_fields_update,$array_values_update,$pkid).' <br>';
		}
        
        $subject = 'Cancelled Overtime Request';
        $body  = 'Good day!<br>';
        $body .= 'Please be informed that the requested overtime was cancelled by '.$requestor_name.' due to '.$cancel_remarks.'. <br> Please see the information below.<br>';
        
       /*  Get overtime information */
        $array_fields_main = array("req_status","req_type","req_date","req_justification","req_manpower","req_datefrom","req_dateto","req_approver");
		$table_main 	   	= 'tkovertime_main';
		$joins_main 	   	= '';
		$sql_where_main 	= 'WHERE pkid="'.$pkid.'" AND logdel=0';
		$sql_order_main 	= '';
		$sql_limit_main 	= '';
		$result_main = OT::getInstance()->select_query($array_fields_main,$table_main,$joins_main,$sql_where_main,$sql_order_main,$sql_limit_main);
		if($row_main = mysqli_fetch_array($result_main)){
			$req_status 	    = $row_main['req_status'];
			$req_date 	        = date('M d, Y', strtotime($row_main['req_date']));
			$date_ot		    = date('M d, Y', strtotime($row_main['req_datefrom'])) . " - " . date('M d, Y', strtotime($row_main['req_dateto']));
			$req_manpower 		= $row_main['req_manpower'];
			$req_justification 	= $row_main['req_justification'];			
			$req_type 	        = $row_main['req_type'];
			$approver_username  = $row_main['req_approver'];
			if($req_type == 1) {
				$req_type = 'Regular';
			} else if($req_type == 2) {
				$req_type = 'Legal Sunday';
			} else if($req_type == 3) {
				$req_type = 'Sunday';
			} else if($req_type == 4) {
				$req_type = 'Special Non Working Holiday';
			} else if($req_type == 5) {
				$req_type = 'Sunday/Legal Holiday';
			} else if($req_type == 6) {
				$req_type = 'Sunday/Special Holiday';
			} else {
				$req_type = 'ERROR!!!';
			}
			$body .= '<br><hr><b><i>Overtime Information:</i></b><br>';
			$body .= '<b>Overtime Type: </b>'.$req_type."<br>";
			$body .= '<b>Date of Overtime: </b>'.$date_ot."<br>";
			$body .= '<b>Manpower Involved: </b>'.$req_manpower."<br>";
			$body .= '<b>Justification: </b>'.$req_justification."<br><br><hr>";
            
            /* Get the recipient email address */
            $select_query_to = get_email_add($approver_username) ;
            if($row_to = mysqli_fetch_array($select_query_to)) {
                $to = $row_to['email_add'];
            }

            $select_query_from = get_email_add($username) ;
            if($row_from = mysqli_fetch_array($select_query_from)) {
                $from = $row_from['email_add'];
            }	
		}	
		// echo $body.'<br>'.$to.'<br>'.$from;		
		$php_mailer = new email();
		$msg .= $php_mailer->send_email($to, $from, $from, $subject, $body,'');
		$return['msg'] = $msg;	        
		$return["result"] = json_encode($result); //return the the serialize values
		echo json_encode($return); //json encode since I used a dataType json before passing the serialized values here
	}

	function load_overtime_main_info_by_pkid() {
		require_once('../class/oop.php'); //OOP Path
		$return = $_POST;
		$result = "";
		$array_fields = array("pkid","req_by","req_status","req_type","req_date","req_justification","req_manpower","req_datefrom","req_dateto","req_approver");
		$table 	   	= 'tkovertime_main';
		$joins 	   	= '';
		$sql_where 	= 'WHERE `pkid`="'.$return['pkid'].'" AND `logdel`=0';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = OT::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
//		$return['msg'] = $result;
		if($row = mysqli_fetch_array($result)){
			$return['pkid'] 	        = $row['pkid'];
			$return['req_by'] 	        = $row['req_by'];
			$return['req_status'] 	    = $row['req_status'];
			$return['req_type'] 	    = $row['req_type'];
			$return['req_date'] 	    = $row['req_date'];
			$return['req_datefrom'] 	= $row['req_datefrom'];
			$return['req_dateto']     	= $row['req_dateto'];
			$return['req_manpower'] 	= $row['req_manpower'];
			$return['req_justification']= $row['req_justification'];
			$return['req_approver']     = $row['req_approver'];
		}
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}

	function load_employee_name_by_number() {
		require_once('../class/oop.php'); //OOP Path
		$return = $_POST;
		$result = "";
		$array_fields = array('CONCAT(lastname,", ",firstname) as emp_name');
		$table 	   	= 'db_hris.vw_EmpInfo_Rapid';
		$joins 	   	= '';
		$sql_where 	= 'WHERE `EmpNo`="'.$return['emp_no'].'"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = OT::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
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

	function load_employee_number_by_name() {
		require_once('../class/oop.php'); //OOP Path
		$return = $_POST;
		$result = "";
		$array_fields = array('EmpNo');
		$table 	   	= 'db_hris.vw_EmpInfo_Rapid';
		$joins 	   	= '';
		$sql_where 	= 'WHERE CONCAT( lastname,  ", ", firstname )="'.$return['emp_name'].'"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = OT::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
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
	// check_ot_filed();
	function check_ot_filed() {
		require_once('../class/oop.php'); //OOP Path
		$return = $_POST;
		$result = "";
        $date_ot = $return['txt_add_employee_date'];
        $emp_no = $return['txt_add_employee_number'];
        $emp_name = $return['txt_add_employee_name'];
        $filed_ot = $return['txt_add_employee_filled_overtime'];
        $req_remarks = $return['txt_add_employee_remarks'];
        $pkid = $return['fkid'];
        $overtime_type = $return['ot_type'];
		
		//test data
		// $date_ot = '2017-02-11';
        // $emp_no = '2292';
        // $emp_name = 'Sta. Ana, Joli';
        // $filed_ot = 4;
        // $req_remarks = '';
        // $pkid = 6321;
        // $overtime_type = 1;
		
		$ot = 0;
		$msg = '';
		$day_off = "false"; /* True=with day off. Out is 4:30 False=no day off. out is 3:30 */
		$normal_time_out = "";

		$day_off = has_day_off($emp_no);
		/* Check overtime type. If overtime is "Regular", system will block the employee who logged between 8:41 am to 1:31 pm and 8:41 pm to 1:31 pm. Because half day is not allowed to have overtime. But no restriction on other type of overtime */

		/* Get the attendance of employee based on date of log in */
		/* Get the time difference(OT) based on attendance and day-off type (with or without day-off) and if Saturday */

		$date_time_in = "";
		$date_time_out = "";
		$normal_date_time_out = "";
		$normal_time_out = "";

		$array_fields_attendance = array("date","time_in","mode_in","date_out","time_out","mode_out");
		$table_attendance 	   	= "tkdataraw";
		$joins_attendance 	   	= "";
		$sql_where_attendance 	= "WHERE empno='".$emp_no."' AND date='".$date_ot."'";
		$sql_order_attendance 	= 'ORDER BY time_out';
		$sql_limit_attendance 	= '';
		$result_attendance = OT::getInstance()->select_query($array_fields_attendance,$table_attendance,$joins_attendance,$sql_where_attendance,$sql_order_attendance,$sql_limit_attendance);
		if($result_attendance->num_rows == 0) {
			$array_fields_attendance_out = array("date","time_in","mode_in","date_out","time_out","mode_out");
			$sql_where_attendance_out 	= "WHERE empno='".$emp_no."' AND date_out='".$date_ot."'";
			$result_attendance_out = OT::getInstance()->select_query($array_fields_attendance_out,$table_attendance,$joins_attendance,$sql_where_attendance_out,$sql_order_attendance,$sql_limit_attendance);
			if($result_attendance_out->num_rows == 0) {
				$ot = 0;
				$msg = 'No record found!';
				$date_time_in = 'N/A';
				$date_time_out = 'N/A';
			} else {
				if($row_attendance_out = mysqli_fetch_array($result_attendance_out)){
					if(check_null($row_attendance_out['date']) == '' && check_null($row_attendance_out['time_in'] == '')) {
						$time_in = 'N/A';
						$date_time_in = 'N/A';
						$msg = 'No time in!';  
					} else {
						if(date('Y-m-d',strtotime('-1 days',strtotime($row_attendance_out['date_out']))) == $row_attendance_out['date']) {
							$ot = 0;
							$msg = 'No record found!';
							$date_time_in = 'N/A';
							$date_time_out = 'N/A';
						} else {
							$time_in = $row_attendance_out['time_in'];
							$date_time_in = $row_attendance_out['date'] . " ".$row_attendance_out['time_in'];
							$date_time_in = date('M d, Y h:i:s A',strtotime($date_time_in));
						}						
					}
				} 
			}
		} else if($result_attendance->num_rows == 1 || $result_attendance->num_rows == 2) {
			$time_in = "";
			if($result_attendance->num_rows == 1) { 
				if($row_attendance = mysqli_fetch_array($result_attendance)){
					if(check_null($row_attendance['date']) == '' && check_null($row_attendance['time_in'] == '')) {
						$time_in = 'N/A';
						$date_time_in = 'N/A';
					} else {
						$time_in = $row_attendance['time_in'];
						$date_time_in = $row_attendance['date'] . " ".$row_attendance['time_in'];
						$date_time_in = date('M d, Y h:i:s A',strtotime($date_time_in));
					}
					if(check_null($row_attendance['date_out']) == '' && check_null($row_attendance['time_out'] == '')) {
						$date_time_out = 'N/A';
					} else {
						$date_time_out = $row_attendance['date_out'] . " ".$row_attendance['time_out'];
						$date_time_out = date('M d, Y h:i:s A',strtotime($date_time_out));
					}
				} 
			} else { 
				$row_attendance = mysqli_fetch_array($result_attendance);
				$temp_time_in = $row_attendance['time_in'];
				if($row_attendance['mode_out'] == 'OB') {
					$array_fields_attendance = array("date","time_in","date_out","time_out","mode_out");
					$table_attendance 	   	= "tkdataraw";
					$joins_attendance 	   	= "";
					$sql_where_attendance 	= "WHERE empno='".$emp_no."' AND date='".$date_ot."'";
					$sql_order_attendance 	= 'ORDER BY time_out DESC';
					$sql_limit_attendance 	= '';
					$result_attendance = OT::getInstance()->select_query($array_fields_attendance,$table_attendance,$joins_attendance,$sql_where_attendance,$sql_order_attendance,$sql_limit_attendance);
					if($row_attendance = mysqli_fetch_array($result_attendance)){
						if(check_null($row_attendance['date']) == '' && check_null($temp_time_in == '')) {
							$time_in = 'N/A';
							$date_time_in = 'N/A';
						} else {
							$time_in = $temp_time_in;
							$date_time_in = $row_attendance['date'] . " ".$temp_time_in;
							$date_time_in = date('M d, Y h:i:s A',strtotime($date_time_in));
						}
						if(check_null($row_attendance['date_out']) == '' && check_null($row_attendance['time_out'] == '')) {
							$date_time_out = 'N/A';
						} else {
							$date_time_out = $row_attendance['date_out'] . " ".$row_attendance['time_out'];
							$date_time_out = date('M d, Y h:i:s A',strtotime($date_time_out));
						}
					} 
				} else {
					$date_time_in = 'N/A';
					$date_time_out = 'N/A';
				}                    
			}
			if($overtime_type == 1) {
				//counter check if total working hours is above 7 hrs.
				$working_hrs = compute_overtime($date_time_in, $date_time_out);		
				
				if($working_hrs['hour'] < 7) {
					if($working_hrs['hour'] >= 4) {
						$ot = 0;
						$msg = 'Half day is not allowed to file overtime!';     
					} else {
						$ot = 0;
						$msg = 'No overtime rendered!';  
					}
				} else {
					/* Validation for Regular OT */
					if(($time_in > "10:00:00" && $time_in < "13:31:00")) { //morning shift
						$ot = 0;
						$msg = 'Half day is not allowed to file overtime!';                  
					} else if(($time_in > "20:41:00" && $time_in < "01:31:00")) { //night shift
						$ot = 0;
						$msg = 'Half day is not allowed to file overtime!';   
					} else if($date_time_in == 'N/A' && $date_time_out == 'N/A') {
						$msg = 'Multiple time in / time out! System cannot validate the overtime due to multiple record found in the set overtime date. Please contact Finance Department for attendance or print the overtime using manual process.';
					} else if($time_in == 'N/A') { //night shift
						$ot = 0;
						$msg = 'No time in!';   
					} else if($date_time_out == 'N/A') { //night shift
						$ot = 0;
						$msg = 'No time out!';   
					} else {
						/* Pag Sat, ang default time-out is 3:30 PM */
						if(date('D',strtotime($date_time_in)) == 'Sat') {
							if($time_in > "00:00:00" && $time_in < "12:00:00") {
							   $normal_time_out = "15:30:00";
							} else if ($time_in > "12:00:00" && $time_in < "24:00:00") {
							   $normal_time_out = "03:30:00";
							}
						} else {
							if($time_in > "00:00:00" && $time_in < "12:00:00") {
							   if($day_off == "true") {
								   $normal_time_out = "16:30:00";
							   } else {
								   $normal_time_out = "15:30:00";
							   }
							} else if ($time_in > "12:00:00" && $time_in < "24:00:00") {
							   if($day_off == "true") {
								   $normal_time_out = "04:30:00";
							   } else {
								   $normal_time_out = "03:30:00";
							   }
							}
						}     		
						$normal_date_time_out = $date_ot . " " . $normal_time_out;

						/* Get the overtime difference based on normal time out to his/her time out */
						$ot_diff = compute_overtime($normal_date_time_out, $date_time_out);
						$ot_round_off = round_off_overtime($ot_diff['hour'],$ot_diff['min']);
						if($ot_diff['hour'] == 0 && $ot_diff['min'] == 0) {
							$ot = 0;
							$msg = 'The employee has no overtime rendered.';
						} else if((float)($ot_diff['hour'].'.'.$ot_diff['min']) < 0) {
							$ot = 0;
							$msg = 'Invalid overtime!';
						} else if($filed_ot > (float)($ot_round_off)) {
							$ot = round_off_overtime($ot_diff['hour'],$ot_diff['min']);
							$msg = 'The employee only have ' . $ot_diff['hour'] . ' hour(s) ' . $ot_diff['min'] . ' minute(s) rendered.';
						} else {
							$ot = $filed_ot;
							$msg = 'Ok!';
						}
						// echo "hr:".$ot_diff['hour']."<br>";
						// echo "min:".$ot_diff['min']."<br>";
					}
				}
			} 
			else {
				/* Condition for other type of OT */
				/* No half day restriction */
				/* Get the overtime difference based on normal time out to his/her time out */
				if($time_in == 'N/A') { //night shift
					$ot = 0;
					$msg = 'No time in!';
					$date_time_in = 'N/A';   
					$date_time_out = date('M d, Y h:i:s A',strtotime($date_time_out));
				} else if($date_time_out == 'N/A') { //night shift
					$ot = 0;
					$msg = 'No time out!';   
					$date_time_out = 'N/A';
					$date_time_in = date('M d, Y h:i:s A',strtotime($date_time_in));
				} else {	
					/* Reset the original time in of employees who are BUS LATE */
					$mode_in = $row_attendance['mode_in'];
					if($mode_in == "BUS LATE") {
						if($time_in > "07:31:00" && $time_in < "10:00:00") {
						   $date_time_in = $row_attendance['date'] . " 07:30:00";
						} else if ($time_in > "19:31:00" && $time_in < "22:00:00") {
						   $date_time_in = $row_attendance['date'] . " 19:30:00";
						}
					} 
					$ot_diff = compute_overtime($date_time_in, $date_time_out);
					$ot 	 = round_off_overtime($ot_diff['hour'],$ot_diff['min']);
					if($ot_diff['hour'] == 0 && $ot_diff['min'] == 0) {
						$ot = 0;
						$msg = 'The employee has no overtime rendered.';
					} else if($filed_ot > $ot) {
						if($ot < 0) {
							$ot = round_off_overtime($ot_diff['hour'],$ot_diff['min']);
							$msg = 'Invalid overtime!';
						} else {
							
							$msg = 'The employee only have ' . $ot_diff['hour'] . ' hour(s) ' . $ot_diff['min'] . ' minute(s) rendered.';
						}
					} else {
						$ot = $filed_ot;
						$msg = 'Ok!';
					}
					$date_time_in = $row_attendance['date'] . " ".$row_attendance['time_in'];
					$date_time_in = date('M d, Y h:i:s A',strtotime($date_time_in));
					$date_time_out = date('M d, Y h:i:s A',strtotime($date_time_out));
				}
			}
		} else {
			$ot = 0;
			$date_time_in = 'N/A';
			$date_time_out = 'N/A';
			$msg = 'Multiple time in / time out! System cannot validate the overtime due to multiple record found in the set overtime date. Please contact Finance Department for attendance or print the overtime using manual process.';
		}

		//check if overtime already filed by others
		$validate_ot = check_double_filed_ot($emp_no,$pkid,$date_ot,number_format((float)$ot, 2, '.', ''));

		$return['fkid'] = $pkid;
        $return['date_ot'] = date('M d, Y',strtotime($date_ot));
        $return['emp_no'] = strtoupper($emp_no);
        $return['emp_name'] = $emp_name;
        $return['remarks'] = $req_remarks;
        $return['date_time_in'] = $date_time_in;
        $return['date_time_out'] = $date_time_out;
		$return['filed_ot'] = number_format((float)$filed_ot, 2, '.', '');
		$return['valid_ot'] = number_format((float)$ot, 2, '.', '');
		$return['msg'] = $msg;
		$return['validate_ot'] = $validate_ot;
		echo json_encode($return);
	}

     function check_ot_filed_array() {
        require_once('../class/oop.php'); //OOP Path
		$return = $_POST;
		$result = "";
        
        $array_empno = $return['txt_add_employee_number'];
        $array_emp_name = $return['txt_add_employee_name'];
        
        $array_return = array();
         
        $array_return['fkid'] = array();
        $array_return['date_ot'] = array();
        $array_return['emp_no'] = array();
        $array_return['emp_name'] = array();
        $array_return['remarks'] = array();
        $array_return['date_time_in'] = array();
        $array_return['date_time_out'] = array();
        $array_return['filed_ot'] = array();
        $array_return['valid_ot'] = array();
        $array_return['msg'] = array();
        $array_return['validate_ot'] = array();
        
        for($x=0;$x<count($array_empno);$x++){
            $date_ot = $return['txt_add_employee_date'];
            $emp_no = $return['txt_add_employee_number'][$x];
            $emp_name = $return['txt_add_employee_name'][$x];
            $filed_ot = $return['txt_add_employee_filled_overtime'];
            $req_remarks = $return['txt_add_employee_remarks'];
            $pkid = $return['fkid'];
            $overtime_type = $return['ot_type'];

            // $date_ot = '2016-03-31';
            // $emp_no = 'K010';
            // $emp_name = 'aaaa';
            // $filed_ot = '1.5';
            // $req_remarks = 'lala';
            // $pkid = '1';
            // $overtime_type = '1';
            
            $ot = 0;
            $msg = '';
            $day_off = "false"; /* True=with day off. Out is 4:30 False=no day off. out is 3:30 */
            $normal_time_out = "";

            $day_off = has_day_off($emp_no);
            /* Check overtime type. If overtime is "Regular", system will block the employee who logged between 8:41 am to 1:31 pm and 8:41 pm to 1:31 pm. Because half day is not allowed to have overtime. But no restriction on other type of overtime */

            /* Get the attendance of employee based on date of log in */
            /* Get the time difference(OT) based on attendance and day-off type (with or without day-off) and if Saturday */

            $date_time_in = "";
            $date_time_out = "";
            $normal_date_time_out = "";
            $normal_time_out = "";

            $array_fields_attendance = array("date","time_in","mode_in","date_out","time_out","mode_out");
            $table_attendance 	   	= "tkdataraw";
            $joins_attendance 	   	= "";
            $sql_where_attendance 	= "WHERE empno='".$emp_no."' AND date='".$date_ot."'";
            $sql_order_attendance 	= 'ORDER BY time_out';
            $sql_limit_attendance 	= '';
            $result_attendance = OT::getInstance()->select_query($array_fields_attendance,$table_attendance,$joins_attendance,$sql_where_attendance,$sql_order_attendance,$sql_limit_attendance);
            if($result_attendance->num_rows == 0) {
                // $ot = 0;
                // $msg = 'No record found!';
                // $date_time_in = 'N/A';
                // $date_time_out = 'N/A';
				$array_fields_attendance_out = array("date","time_in","mode_in","date_out","time_out","mode_out");
				$sql_where_attendance_out 	= "WHERE empno='".$emp_no."' AND date_out='".$date_ot."'";
				$result_attendance_out = OT::getInstance()->select_query($array_fields_attendance_out,$table_attendance,$joins_attendance,$sql_where_attendance_out,$sql_order_attendance,$sql_limit_attendance);
				if($result_attendance_out->num_rows == 0) {
					$ot = 0;
					$msg = 'No record found!';
					$date_time_in = 'N/A';
					$date_time_out = 'N/A';
				} else {
					if($row_attendance_out = mysqli_fetch_array($result_attendance_out)){
						if(check_null($row_attendance_out['date']) == '' && check_null($row_attendance_out['time_in'] == '')) {
							$time_in = 'N/A';
							$date_time_in = 'N/A';
							$msg = 'No time in!';  
						} else {
							if(date('Y-m-d',strtotime('-1 days',strtotime($row_attendance_out['date_out']))) == $row_attendance_out['date']) {
								$ot = 0;
								$msg = 'No record found!';
								$date_time_in = 'N/A';
								$date_time_out = 'N/A';
							} else {
								$time_in = $row_attendance_out['time_in'];
								$date_time_in = $row_attendance_out['date'] . " ".$row_attendance_out['time_in'];
								$date_time_in = date('M d, Y h:i:s A',strtotime($date_time_in));
							}						
						}
					} 
				}				
            } else if($result_attendance->num_rows == 1 || $result_attendance->num_rows == 2) {
                $time_in = "";
                if($result_attendance->num_rows == 1) { 
                    if($row_attendance = mysqli_fetch_array($result_attendance)){
                        if(check_null($row_attendance['date']) == '' && check_null($row_attendance['time_in'] == '')) {
                            $time_in = 'N/A';
                            $date_time_in = 'N/A';
                        } else {
                            $time_in = $row_attendance['time_in'];
                            $date_time_in = $row_attendance['date'] . " ".$row_attendance['time_in'];
                            $date_time_in = date('M d, Y h:i:s A',strtotime($date_time_in));
                        }
                        if(check_null($row_attendance['date_out']) == '' && check_null($row_attendance['time_out'] == '')) {
                            $date_time_out = 'N/A';
                        } else {
                            $date_time_out = $row_attendance['date_out'] . " ".$row_attendance['time_out'];
                            $date_time_out = date('M d, Y h:i:s A',strtotime($date_time_out));
                        }
                    } 
                } else { 
                    $row_attendance = mysqli_fetch_array($result_attendance);
                    $temp_time_in = $row_attendance['time_in'];
                    if($row_attendance['mode_out'] == 'OB') {
                        $array_fields_attendance = array("date","time_in","date_out","time_out","mode_out");
                        $table_attendance 	   	= "tkdataraw";
                        $joins_attendance 	   	= "";
                        $sql_where_attendance 	= "WHERE empno='".$emp_no."' AND date='".$date_ot."'";
                        $sql_order_attendance 	= 'ORDER BY time_out DESC';
                        $sql_limit_attendance 	= '';
                        $result_attendance = OT::getInstance()->select_query($array_fields_attendance,$table_attendance,$joins_attendance,$sql_where_attendance,$sql_order_attendance,$sql_limit_attendance);
                        if($row_attendance = mysqli_fetch_array($result_attendance)){
                            if(check_null($row_attendance['date']) == '' && check_null($temp_time_in == '')) {
                                $time_in = 'N/A';
                                $date_time_in = 'N/A';
                            } else {
                                $time_in = $temp_time_in;
                                $date_time_in = $row_attendance['date'] . " ".$temp_time_in;
                                $date_time_in = date('M d, Y h:i:s A',strtotime($date_time_in));
                            }
                            if(check_null($row_attendance['date_out']) == '' && check_null($row_attendance['time_out'] == '')) {
                                $date_time_out = 'N/A';
                            } else {
                                $date_time_out = $row_attendance['date_out'] . " ".$row_attendance['time_out'];
                                $date_time_out = date('M d, Y h:i:s A',strtotime($date_time_out));
                            }
                        } 
                    } else {
                        $date_time_in = 'N/A';
                        $date_time_out = 'N/A';
                    }                    
                }
                if($overtime_type == 1) {
					//counter check if total working hours is above 7 hrs.
					$working_hrs = compute_overtime($date_time_in, $date_time_out);							
					if($working_hrs['hour'] < 7) {
						if($working_hrs['hour'] >= 4) {
							$ot = 0;
							$msg = 'Half day is not allowed to file overtime!';     
						} else {
							$ot = 0;
							$msg = 'No overtime rendered!';  
						}
					} else {
						/* Validation for Regular OT */
						if(($time_in > "10:00:00" && $time_in < "13:31:00")) { //morning shift
							$ot = 0;
							$msg = 'Half day is not allowed to file overtime!';                  
						} else if(($time_in > "20:41:00" && $time_in < "01:31:00")) { //night shift
							$ot = 0;
							$msg = 'Half day is not allowed to file overtime!';   
						} else if($date_time_in == 'N/A' && $date_time_out == 'N/A') {
							$msg = 'Multiple time in / time out! System cannot validate the overtime due to multiple record found in the set overtime date. Please contact Finance Department for attendance or print the overtime using manual process.';
						} else if($time_in == 'N/A') { //night shift
							$ot = 0;
							$msg = 'No time in!';   
						} else if($date_time_out == 'N/A') { //night shift
							$ot = 0;
							$msg = 'No time out!';   
						} else {
							/* Pag Sat, ang default time-out is 3:30 PM */
							if(date('D',strtotime($date_time_in)) == 'Sat') {
								if($time_in > "00:00:00" && $time_in < "12:00:00") {
								   $normal_time_out = "15:30:00";
								} else if ($time_in > "12:00:00" && $time_in < "24:00:00") {
								   $normal_time_out = "03:30:00";
								}
							} else {
								if($time_in > "00:00:00" && $time_in < "12:00:00") {
								   if($day_off == "true") {
									   $normal_time_out = "16:30:00";
								   } else {
									   $normal_time_out = "15:30:00";
								   }
								} else if ($time_in > "12:00:00" && $time_in < "24:00:00") {
								   if($day_off == "true") {
									   $normal_time_out = "04:30:00";
								   } else {
									   $normal_time_out = "03:30:00";
								   }
								}
							}                        
							$normal_date_time_out = $date_ot . " " . $normal_time_out;

							/* Get the overtime difference based on normal time out to his/her time out */
							$ot_diff = compute_overtime($normal_date_time_out, $date_time_out);
							$ot_round_off = round_off_overtime($ot_diff['hour'],$ot_diff['min']);
							if($ot_diff['hour'] == 0 && $ot_diff['min'] == 0) {
								$ot = 0;
								$msg = 'The employee has no overtime rendered.';
							} else if((float)($ot_diff['hour'].'.'.$ot_diff['min']) < 0) {
								$ot = 0;
								$msg = 'Invalid overtime!';
							} else if($filed_ot > (float)($ot_round_off)) {
								$ot = round_off_overtime($ot_diff['hour'],$ot_diff['min']);
								$msg = 'The employee only have ' . $ot_diff['hour'] . ' hour(s) ' . $ot_diff['min'] . ' minute(s) rendered.';
							} else {
								$ot = $filed_ot;
								$msg = 'Ok!';
							}
							// echo "hr:".$ot_diff['hour']."<br>";
							// echo "min:".$ot_diff['min']."<br>";
						}
					}
                } 
				else {
                    /* Condition for other type of OT */
                    /* No half day restriction */
                    /* Get the overtime difference based on normal time out to his/her time out */
                    if($time_in == 'N/A') { //night shift
                        $ot = 0;
                        $msg = 'No time in!';
                        $date_time_in = 'N/A';   
                        $date_time_out = date('M d, Y h:i:s A',strtotime($date_time_out));
                    } else if($date_time_out == 'N/A') { //night shift
                        $ot = 0;
                        $msg = 'No time out!';   
                        $date_time_out = 'N/A';
                        $date_time_in = date('M d, Y h:i:s A',strtotime($date_time_in));
                    } else {
						/* Reset the original time in of employees who are BUS LATE */
						$mode_in = $row_attendance['mode_in'];
						if($mode_in == "BUS LATE") {
							if($time_in > "07:31:00" && $time_in < "10:00:00") {
							   $date_time_in = $row_attendance['date'] . " 07:30:00";
							} else if ($time_in > "19:31:00" && $time_in < "22:00:00") {
							   $date_time_in = $row_attendance['date'] . " 19:30:00";
							}
						} 
                        $ot_diff = compute_overtime($date_time_in, $date_time_out);
						$ot 	 = round_off_overtime($ot_diff['hour'],$ot_diff['min']);
                        if($ot_diff['hour'] == 0 && $ot_diff['min'] == 0) {
                            $ot = 0;
                            $msg = 'The employee has no overtime rendered.';
                        } else if($filed_ot > $ot) {
                            if($ot < 0) {                                
                                $msg = 'Invalid overtime!';
                            } else {
                                $msg = 'The employee only have ' . $ot_diff['hour'] . ' hour(s) ' . $ot_diff['min'] . ' minute(s) rendered.';
                            }
                        } else {
                            $ot = $filed_ot;
                            $msg = 'Ok!';
                        }
						$date_time_in = $row_attendance['date'] . " ".$row_attendance['time_in'];
                        $date_time_in = date('M d, Y h:i:s A',strtotime($date_time_in));
                        $date_time_out = date('M d, Y h:i:s A',strtotime($date_time_out));
                    }
                }
            } else {
                $ot = 0;
                $date_time_in = 'N/A';
                $date_time_out = 'N/A';
                $msg = 'Multiple time in / time out! System cannot validate the overtime due to multiple record found in the set overtime date. Please contact Finance Department for attendance or print the overtime using manual process.';
            }

            //check if overtime already filed by others
            $validate_ot = check_double_filed_ot($emp_no,$pkid,$date_ot,number_format((float)$ot, 2, '.', ''));

            $array_return['fkid'][]           = $pkid;
            $array_return['date_ot'][]        = date('M d, Y',strtotime($date_ot));
            $array_return['emp_no'][]         = strtoupper($emp_no);
            $array_return['emp_name'][]       = $emp_name;
            $array_return['remarks'][]        = $req_remarks;
            $array_return['date_time_in'][]   = $date_time_in;
            $array_return['date_time_out'][]  = $date_time_out;
            $array_return['filed_ot'][]       = number_format((float)$filed_ot, 2, '.', '');
            $array_return['valid_ot'][]       = number_format((float)$ot, 2, '.', '');
            $array_return['msg'][]            = $msg;
            $array_return['validate_ot'][]    = $validate_ot;
            
        }
        echo json_encode($array_return);
    }
	
	function load_hris_record_all(){
		require_once('../class/oop.php'); //OOP Path
		$return = $_POST;
		$result = "";
		$array_fields = array('EmpNo','lastname','firstname','middlename','lastname','Division','Department','Section');
		$table 	   	= 'db_hris.vw_EmpInfo_Rapid';
		$joins 	   	= '';
		$sql_where 	= '';
		$sql_order 	= 'ORDER BY lastname';
		$sql_limit 	= '';
		$result = OT::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
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

	function remove_overtime_details_per_pkid() {
		require_once('../class/oop.php'); //OOP Path
		$return 	= $_POST; 
		$result 	= "";
		$table   	= "tk_overtime_details";
		$result 	= OT::getInstance()->delete_query_details($table,$return['fkid']);
		$return["result"] = json_encode($result); //return the the serialize values
		echo json_encode($return);
	}
	
    function insert_overtime() {
        require_once('../class/oop.php'); //OOP Path
		$return 		= $_POST; 
		$result 		= "";
		$date_time_created = date('Y-m-d H:i:s');
		$username = $return['username'];
		$fkid_ot_main = $return['fkid'];		
		$ot_date = date('Y-m-d',strtotime($return['ot_date']));
		$empno = $return['empno'];
		$filed_ot = number_format((float)$return['filed_ot'], 2, '.', '');
		$valid_ot = number_format((float)$return['valid_ot'], 2, '.', '');
		$remarks = $return['remarks'];
		$system_comment = $return['system_comment'];
		$table   		= "tk_overtime_details"; //table name
		$array_fields 	= array("date_time_created", "created_by", "fkid_ot_main", "ot_date", "empno", "filed_ot", "valid_ot", "remarks", "system_comment", "username", "lastupdate"); 
		$array_values 	= array($date_time_created,strtolower($username),$fkid_ot_main,$ot_date,$empno,$filed_ot,$valid_ot,$remarks,str_replace('FOR UPDATE!','',$system_comment),strtolower($username),$date_time_created); 
		$result 		= OT::getInstance()->insert_query($table,$array_fields,$array_values);
		$return["result"] = json_encode($result); //return the the serialize values
		echo json_encode($return); //json encode since I used a dataType json before passing the serialized values here
    }
	
    function get_employee_overtime(){
		require_once('../class/oop.php'); //OOP Path
		$return = $_POST;
		$result = "";
        $fkid = $return['fkid'];
		$array_fields = array('CONCAT(hris.lastname,", ",hris.firstname) as emp_name','ot.pkid', 'ot.ot_date', 'ot.date_time_in', 'ot.date_time_out', 'ot.empno', 'ot.filed_ot', 'ot.valid_ot', 'ot.remarks', 'ot.system_comment');
		$table 	   	= 'tk_overtime_details ot';
		$joins 	   	= 'INNER JOIN db_hris.vw_EmpInfo_Rapid hris ON hris.EmpNo = ot.empno';
		$sql_where 	= 'WHERE ot.fkid_ot_main="'.$fkid.'" AND `logdel` = "0"';
		// $sql_where 	= 'WHERE ot.fkid_ot_main="332" AND `logdel` = "0"';
		$sql_order 	= 'ORDER BY ot.pkid';
		$sql_limit 	= '';
		$result = OT::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$ctr = 0;
		$checker		= '';
		while($row = mysqli_fetch_array($result)){
			$emp_name 			= $row['emp_name'];
			$ot_date			= $row['ot_date'];
			$date_time_in_orig	= $row['date_time_in']; 
			$date_time_out_orig	= $row['date_time_out'];
			$empno 				= $row['empno'];
			$filed_ot 			= $row['filed_ot'];
			$valid_ot 			= $row['valid_ot'];
			$remarks 			= $row['remarks'];
			$system_comment 	= $row['system_comment'];
			$pkid 				= $row['pkid'];
            
			if($date_time_in_orig != '') {
				$date_time_in_orig = date('Y-m-d H:i',strtotime($date_time_in_orig));
			} else {
				$date_time_in_orig = '';
			}
			if($date_time_out_orig != '') {
				$date_time_out_orig = date('Y-m-d H:i',strtotime($date_time_out_orig));
			} else {
				$date_time_out_orig = '';
			}
			
            $array_fields_raw = array('time_in', 'date_out', 'time_out');
            $table_raw 	   	= 'tkdataraw';
            $joins_raw 	   	= '';
            $sql_where_raw 	= 'WHERE date="'.$ot_date.'" AND empno="'.$empno.'"';
            $sql_order_raw 	= '';
            $sql_limit_raw 	= '';
            $result_raw = OT::getInstance()->select_query($array_fields_raw,$table_raw,$joins_raw,$sql_where_raw,$sql_order_raw,$sql_limit_raw);
			if($result_raw->num_rows == 1) {
				if($row_raw = mysqli_fetch_array($result_raw)){
					$date_time_in  = $ot_date.' '.$row_raw['time_in'];
					$date_time_out = $row_raw['date_out'].' '.$row_raw['time_out'];
					if($date_time_in == ' ' || $date_time_in == '') {
						$date_time_in = '';
						$return['date_time_in'][$ctr] = 'N/A';
					} else {
						$date_time_in = date('Y-m-d H:i',strtotime($date_time_in));
						$return['date_time_in'][$ctr]  = date('M d, Y h:i:s A',strtotime($date_time_in));
					}
					if($date_time_out == ' ' || $date_time_out == '') {	
						$date_time_out = '';
						$return['date_time_out'][$ctr] = 'N/A';
					} else {
						$date_time_out = date('Y-m-d H:i',strtotime($date_time_out));
						$return['date_time_out'][$ctr] = date('M d, Y h:i:s A',strtotime($date_time_out));
					}
					if(($date_time_in_orig == $date_time_in) && ($date_time_out_orig == $date_time_out)) { 
						$checker = '1';
					} else {
						$checker = '0';
					} 
				} else {
					$date_time_in  = '';
					$return['date_time_in'][$ctr]  = 'N/A';
					$return['date_time_out'][$ctr] = 'N/A';
					$checker = '1';
				}

			} else if($result_raw->num_rows == 0) { 
				$array_fields_raw_date_out = array('time_in', 'date_out', 'time_out');
				$sql_where_raw_date_out 	= 'WHERE date_out="'.$ot_date.'" AND empno="'.$empno.'"';
				$result_raw_date_out = OT::getInstance()->select_query($array_fields_raw_date_out,$table_raw,$joins_raw,$sql_where_raw_date_out,$sql_order_raw,$sql_limit_raw);
				if($result_raw_date_out->num_rows == 1) {
					if($row_date_out = mysqli_fetch_array($result_raw_date_out)) {
						$date_time_in  = '';
						$date_time_out = $row_date_out['date_out'].' '.$row_date_out['time_out'];
						if($date_time_in == ' ' || $date_time_in == '') {
							$date_time_in = '';
							$return['date_time_in'][$ctr] = 'N/A';
						} else {
							$date_time_in = '';
							$return['date_time_in'][$ctr]  = 'N/A';
						}
						if($date_time_out == ' ' || $date_time_out == '') {	
							$date_time_out = '';
							$return['date_time_out'][$ctr] = 'N/A';
						} else {
							$date_time_out = date('Y-m-d H:i',strtotime($date_time_out));
							$return['date_time_out'][$ctr] = date('M d, Y h:i:s A',strtotime($date_time_out));
						}
						if(($date_time_in_orig == $date_time_in) && ($date_time_out_orig == $date_time_out)) { 
							$checker = '1';
						} else {
							$checker = '0';
						} 
					}
				} else {
					$date_time_in  = '';
					$date_time_out  = '';
					$return['date_time_in'][$ctr]  = 'N/A';
					$return['date_time_out'][$ctr] = 'N/A';	
					$checker = '1';
				}
			} else {
				$date_time_in  = '';
				$date_time_out  = '';
				$return['date_time_in'][$ctr] = 'N/A';
				$return['date_time_out'][$ctr] = 'N/A';
				$checker = '1';
			}
            $return['emp_name'][$ctr] 	   = $emp_name;
			$return['ot_date'][$ctr] 	   = date('M d, Y',strtotime($ot_date));
			$return['empno'][$ctr] 		   = $empno;
			$return['filed_ot'][$ctr] 	   = $filed_ot;
			$return['valid_ot'][$ctr] 	   = $valid_ot;
			$return['remarks'][$ctr] 	   = $remarks;
			$return['system_comment'][$ctr]= $system_comment;
			$return['pkid'][$ctr]          = $pkid;
			$return['checker'][$ctr]       = $checker;	/* variable that tells if there are adjustment in date/time in or out */
			// $return['date_time_in_orig'][$ctr]       = date('Y-m-d H:i',strtotime($date_time_in_orig));	
			// $return['date_time_out_orig'][$ctr]      = date('Y-m-d H:i',strtotime($date_time_out_orig));
			$return['date_time_in_orig'][$ctr]       = date('M d, Y h:i A',strtotime($date_time_in_orig));	
			$return['date_time_out_orig'][$ctr]      = date('M d, Y h:i A',strtotime($date_time_out_orig));
			$return['date_time_in_new'][$ctr]        = date('Y-m-d H:i',strtotime($date_time_in));	
			$return['date_time_out_new'][$ctr]       = date('Y-m-d H:i',strtotime($date_time_out));
			$ctr++;
			// echo 'EN: ['.$empno.'] Checker: ['.$checker.']date_time_in_orig'.' ['.($date_time_in_orig).'] date_time_in_new'.' ['.$date_time_in.'] date_time_out_orig'.' ['.$date_time_out_orig.'] date_time_out_new'.' ['.$date_time_out.']<br><hr><br>';
		}
		$return['ctr']	  = $ctr;
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}
	
	function send_email_to_approver() {
		require_once('../class/oop.php'); //OOP Path
		require_once('../class/send_email.php');
		$return = $_POST;
		$msg = 0;
		// $return['fkid'] = 1;
		// $return['username'] = 'ronfern';
		$body_ot_main = '';
		$body_ot_details = '';
		
        /* Update request status */
        $table_update = "tkovertime_main";
		$array_fields_update = array("req_status", "username","lastupdate"); 
		$array_values_update = array('1',$return['username'],date('Y-m-d H:i:s'));
		$pkid = $return['fkid'];
		$result = OT::getInstance()->update_query($table_update,$array_fields_update,$array_values_update,$pkid);
    
        /* Construct email content */    
		$body_header  = 'Good day!<br>';
		$body_header .= 'Please be informed that you have overtime for approval.<br>';
		$body_header .= 'Below are the overtime information:<br>';
		
		/* Get overtime main info */
		$array_fields_main = array("created_by","req_status","req_type","req_date","req_justification","req_manpower","req_datefrom","req_dateto","req_approver");
		$table_main 	   	= 'tkovertime_main';
		$joins_main 	   	= '';
		$sql_where_main 	= 'WHERE pkid="'.$pkid.'" AND logdel=0';
		$sql_order_main 	= '';
		$sql_limit_main 	= '';
		$result_main = OT::getInstance()->select_query($array_fields_main,$table_main,$joins_main,$sql_where_main,$sql_order_main,$sql_limit_main);
		if($row_main = mysqli_fetch_array($result_main)){
			$req_status 	    = $row_main['req_status'];
			$req_date 	        = date('M d, Y', strtotime($row_main['req_date']));
			$date_ot		    = date('M d, Y', strtotime($row_main['req_datefrom'])) . " - " . date('M d, Y', strtotime($row_main['req_dateto']));
			$req_manpower 		= $row_main['req_manpower'];
			$req_justification 	= $row_main['req_justification'];			
			$req_type 	        = $row_main['req_type'];
			$approver_username  = $row_main['req_approver'];
			$username 			= $row_main['created_by'];
			if($req_type == 1) {
				$req_type = 'Regular';
			} else if($req_type == 2) {
				$req_type = 'Legal Sunday';
			} else if($req_type == 3) {
				$req_type = 'Sunday';
			} else if($req_type == 4) {
				$req_type = 'Special Non Working Holiday';
			} else if($req_type == 5) {
				$req_type = 'Sunday/Legal Holiday';
			} else if($req_type == 6) {
				$req_type = 'Sunday/Special Holiday';
			} else {
				$req_type = 'ERROR!!!';
			}
			$body_ot_main .= '<hr><br><b><i>Overtime Information:</i></b><br>';
			$body_ot_main .= '<b>Overtime Type: </b>'.$req_type."<br>";
			$body_ot_main .= '<b>Date of Overtime: </b>'.$date_ot."<br>";
			$body_ot_main .= '<b>Manpower Involved: </b>'.$req_manpower."<br>";
			$body_ot_main .= '<b>Justification: </b>'.$req_justification."<br><br><hr>";
		}
		
		/* Get overtime details */
		$body_ot_details .= '<table>';
		$body_ot_details .= '	<thead>';
		$body_ot_details .= '		<th style="width:10%;">Emp No</th>';
		$body_ot_details .= '		<th style="width:20%;">Employee Name</th>';
		$body_ot_details .= '		<th style="width:10%;">OT Date</th>';
		$body_ot_details .= '		<th style="width:10%;">OT Hours</th>';
		$body_ot_details .= '		<th style="width:30%;">Remarks</th>';
		$body_ot_details .= '	<thead>';
		$body_ot_details .= '	<tbody>';
		$array_fields_details = array('otks.ot_date', 'otks.empno', 'otks.filed_ot', 'otks.remarks','CONCAT(hris.lastname,", ",hris.firstname) AS emp_name');
		$table_details 	   	= 'tk_overtime_details otks';
		$joins_details 	   	= 'INNER JOIN db_hris.vw_EmpInfo_Rapid hris ON hris.EmpNo = otks.empno';
		$sql_where_details 	= 'WHERE otks.fkid_ot_main="'.$pkid.'" AND otks.logdel=0';
		$sql_order_details 	= 'ORDER BY otks.pkid';
		$sql_limit_details 	= '';
		$result_details = OT::getInstance()->select_query($array_fields_details,$table_details,$joins_details,$sql_where_details,$sql_order_details,$sql_limit_details);
		while($row_details = mysqli_fetch_array($result_details)){
			$empno 		= $row_details['empno'];
			$emp_name	= $row_details['emp_name'];
			$ot_date 	= date('M d, Y',strtotime($row_details['ot_date']));
			$filed_ot 	= $row_details['filed_ot'];
			$remarks 	= $row_details['remarks'];
			$body_ot_details .= '		<tr>';
			$body_ot_details .= '			<td style="width:10%;"><center>'.$empno.'</center></td>';
			$body_ot_details .= '			<td style="width:20%;">'.$emp_name.'</td>';
			$body_ot_details .= '			<td style="width:10%;"><center>'.$ot_date.'</center></td>';
			$body_ot_details .= '			<td style="width:10%;"><center>'.$filed_ot.'</center></td>';
			$body_ot_details .= '			<td style="width:30%;">'.$remarks.'</td>';
			$body_ot_details .= '		</tr>';
		}
		$body_ot_details .= '	</tbody>';
		$body_ot_details .= '</table> <br><br><br>';
		
		$subject = 'For Approval: Overtime Request';
		$body = $body_header . $body_ot_main . $body_ot_details;
		
		/* Get the recipient email address */
		$select_query_to = get_email_add($approver_username) ;
		if($row_to = mysqli_fetch_array($select_query_to)) {
			$to = $row_to['email_add'];
		}
		
		$select_query_from = get_email_add($username) ;
		if($row_from = mysqli_fetch_array($select_query_from)) {
			$from = $row_from['email_add'];
		}		
		// echo $body.'<br>'.$to.'<br>'.$from;		
		$php_mailer = new email();
		$msg = $php_mailer->send_email($to, $from, $from, $subject, $body,'');
		$return['msg'] = $msg;		
		echo json_encode($return);
	}

    function get_approver_overtime_summary () {
        require_once('../class/oop.php'); //OOP Path
		$return = $_POST;
		$result = "";
//        $pkid = 1;
        $pkid = $return['pkid'];
		$array_fields = array('pkid','req_status','req_type','req_date','req_datefrom','req_dateto','req_manpower','req_justification');
		$table 	   	= 'tkovertime_main';
		$joins 	   	= '';
		$sql_where 	= 'WHERE req_approver="'.$return['username'].'" AND req_status != 0 AND logdel=0';
		$sql_order 	= 'ORDER BY pkid desc';
		$sql_limit 	= '';
		$result = OT::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
//		$return['msg'] = $result;
		$ctr = 0;
		while($row = mysqli_fetch_array($result)){
			$return['pkid'][$ctr] 	            = $row['pkid'];
			$return['req_status'][$ctr] 	    = $row['req_status'];
			$return['req_type'][$ctr] 	        = $row['req_type'];
			$return['req_date'][$ctr] 	        = date('M d, Y', strtotime($row['req_date']));
			$return['date_ot'][$ctr]		    = date('M d, Y', strtotime($row['req_datefrom'])) . " - " . date('M d, Y', strtotime($row['req_dateto']));
			$return['req_manpower'][$ctr] 		= $row['req_manpower'];
			$return['req_justification'][$ctr] 	= $row['req_justification'];
			$ctr++;
		}
		$return['ctr']	  = $ctr;
		$return['result'] = json_encode($result);
		echo json_encode($return);
    }
    
    function get_approved_employee_ot_details(){
		require_once('../class/oop.php'); //OOP Path
		$return = $_POST;
		$result = "";
        $pkid = $return['fkid'];
//        $pkid = '1';
		$array_fields = array('CONCAT(hris.lastname,", ",hris.firstname) as emp_name','ot.ot_date', 'ot.empno', 'ot.filed_ot', 'ot.valid_ot', 'ot.remarks', 'ot.system_comment');
		$table 	   	= 'tk_overtime_details ot';
		$joins 	   	= 'INNER JOIN db_hris.vw_EmpInfo_Rapid hris ON hris.EmpNo = ot.empno';
		$sql_where 	= 'WHERE ot.fkid_ot_main="'.$pkid.'" AND ot.logdel=0';
		$sql_order 	= 'ORDER BY ot.pkid';
		$sql_limit 	= '';
		$result = OT::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$ctr = 0;
		while($row = mysqli_fetch_array($result)){
			$emp_name 	= $row['emp_name'];
			$ot_date	= $row['ot_date'];
			$empno 		= $row['empno'];
			$filed_ot 	= $row['filed_ot'];
			$valid_ot 	= $row['valid_ot'];
			$remarks 	= $row['remarks'];
			$system_comment 	= $row['system_comment'];
            
            $array_fields_raw = array('time_in', 'date_out', 'time_out');
            $table_raw 	   	= 'tkdataraw';
            $joins_raw 	   	= '';
            $sql_where_raw 	= 'WHERE date="'.$ot_date.'" AND empno="'.$empno.'"';
            $sql_order_raw 	= '';
            $sql_limit_raw 	= '';
            $result_raw = OT::getInstance()->select_query($array_fields_raw,$table_raw,$joins_raw,$sql_where_raw,$sql_order_raw,$sql_limit_raw);
            if($row_raw = mysqli_fetch_array($result_raw)){
                $date_time_in  = $ot_date.' '.$row_raw['time_in'];
                $date_time_out = $row_raw['date_out'].' '.$row_raw['time_out'];
                $return['date_time_in'][$ctr]  = date('M d, Y h:i:s A',strtotime($date_time_in));
                $return['date_time_out'][$ctr] = date('M d, Y h:i:s A',strtotime($date_time_out));
            } else {
                $return['date_time_in'][$ctr]  = 'N/A';
                $return['date_time_out'][$ctr] = 'N/A';
            }
            $return['emp_name'][$ctr] 	   = $emp_name;
			$return['ot_date'][$ctr] 	   = date('M d, Y',strtotime($ot_date));
			$return['empno'][$ctr] 		   = $empno;
			$return['filed_ot'][$ctr] 	   = $filed_ot;
			$return['valid_ot'][$ctr] 	   = $valid_ot;
			$return['remarks'][$ctr] 	   = $remarks;
			$return['system_comment'][$ctr]= $system_comment;
			$return['fkid'][$ctr]          = $pkid;
			$ctr++;
		}
		$return['ctr']	  = $ctr;
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}

    function approve_overtime_details() {
        require_once('../class/oop.php'); //OOP Path
		$return = $_POST; 
		$result = "";
		$table = "tk_overtime_details";
		$array_fields = array("username","lastupdate"); 
		$array_values = array($return['username'],date('Y-m-d H:i:s'));
		$where = 'WHERE empno="'.$return[empno].'" AND ot_date="'.date('Y-m-d',strtotime($return['ot_date'])).'" AND fkid_ot_main="'.$return['fkid'].'" AND filed_ot="'.$return['filed_ot'].'" AND valid_ot="'.$return['valid_ot'].'" AND username="'.$return['username'].'" AND logdel=0';
		$result = OT::getInstance()->update_query_detailed($table,$array_fields,$array_values,$where);
		$return["msg"] = $result; //return the the serialize values
		$return["result"] = json_encode($result); //return the the serialize values
		echo json_encode($return); //json encode since I used a dataType json before passing the serialized values here
    }

    function approve_overtime_request() {
        require_once('../class/oop.php'); //OOP Path
		$return = $_POST; 
		$result = "";
		$table = "tkovertime_main";
		$array_fields = array("req_status", "username","lastupdate"); 
		$array_values = array($return['status'],$return['username'],date('Y-m-d H:i:s'));
//        $pkid = '1';
        $pkid = $return['pkid'];
		$result = OT::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
		$return["msg"] = $result; //return the the serialize values
        add_approved_ot_to_data_raw($pkid);
		$return["result"] = json_encode($result); //return the the serialize values
		echo json_encode($return); //json encode since I used a dataType json before passing the serialized values here
    }

    function add_approved_ot_to_data_raw($pkid) {        
        require_once('../class/oop.php'); //OOP Path
		$return = $_POST;
		$result = "";
		$date_today = date('Y-m-d H:i:s');
//        $pkid = $return['pkid'];
		$array_fields = array("main.req_type","details.ot_date","details.empno","details.valid_ot");
		$table 	   	= 'tk_overtime_details details';
		$joins 	   	= 'INNER JOIN tkovertime_main main ON main.pkid = details.fkid_ot_main';
		$sql_where 	= 'WHERE details.fkid_ot_main="'.$pkid.'" AND details.logdel=0 AND main.logdel=0';
		$sql_order 	= 'ORDER BY details.pkid desc';
		$sql_limit 	= '';
		$result = OT::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
//		$return['msg'] = $result;
		while($row = mysqli_fetch_array($result)){
			$req_type 	= $row['req_type'];
			$ot_date 	= $row['ot_date'];
			$empno 	    = $row['empno'];
			$valid_ot 	= $row['valid_ot'];
            $table_raw  = "tkdataraw";
            $ot_credit  = $valid_ot;
            $ot_filed   = $valid_ot;
            $ot1        = 0;
            $ot2        = 0;
            $ot2a       = 0;
            $ot3        = 0;
            $ot3a       = 0;
            $ot4        = 0;
            $ot4a       = 0;
            $ot5        = 0;
            $ot5a       = 0;
            $ot6        = 0;
            $ot6a       = 0;
            $array_fields_raw = array("ot_credit","ot_filed","ot1","ot2","ot2a","ot3","ot3a","ot4","ot4a","ot5","ot5a","ot6","ot6a","lastupdate"); 
            if($req_type == '1') {
                $ot1 = $valid_ot;
            } if($req_type == '6') {
                if($valid_ot > 8) {
                    $ot2 = 8;
                    $ot2a = $valid_ot-8;
                } else {
                    $ot2 = $valid_ot;
                }
            } if($req_type == '3') {
                if($valid_ot > 8) {
                    $ot3 = 8;
                    $ot3a = $valid_ot-8;
                } else {
                    $ot3 = $valid_ot;
                }
            } if($req_type == '5') {
                if($valid_ot > 8) {
                    $ot4 = 8;
                    $ot4a = $valid_ot-8;
                } else {
                    $ot4 = $valid_ot;
                }
            } if($req_type == '4') {
                if($valid_ot > 8) {
                    $ot5 = 8;
                    $ot5a = $valid_ot-8;
                } else {
                    $ot5 = $valid_ot;
                }
            } if($req_type == '2') {
                if($valid_ot > 8) {
                    $ot6 = 8;
                    $ot6a = $valid_ot-8;
                } else {
                    $ot6 = $valid_ot;
                }
            }
            //night diff will be adjusted on TFM Module
            $array_values_raw = array($ot_credit,$ot_filed,$ot1,$ot2,$ot2a,$ot3,$ot3a,$ot4,$ot4a,$ot5,$ot5a,$ot6,$ot6a,$date_today);
            $where_raw = 'WHERE empno="'.$empno.'" AND date="'.$ot_date.'"';
            $result_raw = OT::getInstance()->update_query_detailed($table_raw,$array_fields_raw,$array_values_raw,$where_raw);
		}
    }
    
    function send_email_approved_ot() {
        require_once('../class/oop.php'); //OOP Path
		require_once('../class/send_email.php');
		$return = $_POST;
		$msg = 0;
//        $pkid = '3';
//        $username = 'jeferrer';
        $pkid = $return['pkid'];
        $username = $return['username'];
        /* Construct email content */    
		$body_header  = 'Good day!<br>';
		$body_header .= 'Please be informed that your overtime request is already approved.<br>';
		$body_header .= 'Below are the overtime information:<br>';
		
		/* Get overtime main info */
		$array_fields_main = array("req_by","req_type","req_date","req_justification","req_manpower","req_datefrom","req_dateto","req_approver");
		$table_main 	   	= 'tkovertime_main';
		$joins_main 	   	= '';
		$sql_where_main 	= 'WHERE pkid="'.$pkid.'" AND logdel=0';
		$sql_order_main 	= '';
		$sql_limit_main 	= '';
		$result_main = OT::getInstance()->select_query($array_fields_main,$table_main,$joins_main,$sql_where_main,$sql_order_main,$sql_limit_main);
		if($row_main = mysqli_fetch_array($result_main)){
			$req_by 	        = $row_main['req_by'];
			$req_date 	        = date('M d, Y', strtotime($row_main['req_date']));
			$date_ot		    = date('M d, Y', strtotime($row_main['req_datefrom'])) . " - " . date('M d, Y', strtotime($row_main['req_dateto']));
			$req_manpower 		= $row_main['req_manpower'];
			$req_justification 	= $row_main['req_justification'];			
			$req_type 	        = $row_main['req_type'];
			$approver_username  = $row_main['req_approver'];
			if($req_type == 1) {
				$req_type = 'Regular';
			} else if($req_type == 2) {
				$req_type = 'Legal Sunday';
			} else if($req_type == 3) {
				$req_type = 'Sunday';
			} else if($req_type == 4) {
				$req_type = 'Special Non Working Holiday';
			} else if($req_type == 5) {
				$req_type = 'Sunday/Legal Holiday';
			} else if($req_type == 6) {
				$req_type = 'Sunday/Special Holiday';
			} else {
				$req_type = 'ERROR!!!';
			}
			$body_ot_main .= '<hr><br><b><i>Overtime Information:</i></b><br>';
			$body_ot_main .= '<b>Overtime Type: </b>'.$req_type."<br>";
			$body_ot_main .= '<b>Date of Overtime: </b>'.$date_ot."<br>";
			$body_ot_main .= '<b>Manpower Involved: </b>'.$req_manpower."<br>";
			$body_ot_main .= '<b>Justification: </b>'.$req_justification."<br><br><hr>";
		}
		
		/* Get overtime details */
		$body_ot_details .= '<table>';
		$body_ot_details .= '	<thead>';
		$body_ot_details .= '		<th style="width:10%;">Emp No</th>';
		$body_ot_details .= '		<th style="width:20%;">Employee Name</th>';
		$body_ot_details .= '		<th style="width:10%;">OT Date</th>';
		$body_ot_details .= '		<th style="width:10%;">OT Hours</th>';
		$body_ot_details .= '		<th style="width:30%;">Remarks</th>';
		$body_ot_details .= '	<thead>';
		$body_ot_details .= '	<tbody>';
		$array_fields_details = array('otks.ot_date', 'otks.empno', 'otks.filed_ot', 'otks.remarks','CONCAT(hris.lastname,", ",hris.firstname) AS emp_name');
		$table_details 	   	= 'tk_overtime_details otks';
		$joins_details 	   	= 'INNER JOIN db_hris.vw_EmpInfo_Rapid hris ON hris.EmpNo = otks.empno';
		$sql_where_details 	= 'WHERE otks.fkid_ot_main="'.$pkid.'"';
		$sql_order_details 	= 'ORDER BY otks.pkid';
		$sql_limit_details 	= '';
		$result_details = OT::getInstance()->select_query($array_fields_details,$table_details,$joins_details,$sql_where_details,$sql_order_details,$sql_limit_details);
		while($row_details = mysqli_fetch_array($result_details)){
			$empno 		= $row_details['empno'];
			$emp_name	= $row_details['emp_name'];
			$ot_date 	= date('M d, Y',strtotime($row_details['ot_date']));
			$filed_ot 	= $row_details['filed_ot'];
			$remarks 	= $row_details['remarks'];
			$body_ot_details .= '		<tr>';
			$body_ot_details .= '			<td style="width:10%;"><center>'.$empno.'</center></td>';
			$body_ot_details .= '			<td style="width:20%;">'.$emp_name.'</td>';
			$body_ot_details .= '			<td style="width:10%;"><center>'.$ot_date.'</center></td>';
			$body_ot_details .= '			<td style="width:10%;"><center>'.$filed_ot.'</center></td>';
			$body_ot_details .= '			<td style="width:30%;">'.$remarks.'</td>';
		}
		$body_ot_details .= '	</tbody>';
		$body_ot_details .= '</table> <br><br><br>';
		
		$subject = 'Approved Overtime Request';
		$body = $body_header . $body_ot_main . $body_ot_details;
		
		/* Get the recipient email address */
		$select_query_to = get_email_add($req_by) ;
		if($row_to = mysqli_fetch_array($select_query_to)) {
			$to = $row_to['email_add'];
		}
		
		$select_query_from = get_email_add($username) ;
		if($row_from = mysqli_fetch_array($select_query_from)) {
			$from = $row_from['email_add'];
		}		
//		 echo $body.'<br>['.$to.']<br>['.$from.']<br>';		
		$php_mailer = new email();
		$msg = $php_mailer->send_email($to, $from, $from, $subject, $body,'');
		$return['msg'] = $msg;		
		echo json_encode($return);
    }
    
    function disapprove_overtime_request() {
        require_once('../class/oop.php'); //OOP Path
		$return = $_POST; 
		$result = "";
		$table = "tkovertime_main";
		$array_fields = array("req_status", "username","lastupdate"); 
		$array_values = array($return['status'],$return['username'],date('Y-m-d H:i:s'));
        $pkid = $return['pkid'];
		$result = OT::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
		$return["msg"] = $result; //return the the serialize values
		$return["result"] = json_encode($result); //return the the serialize values
		echo json_encode($return); //json encode since I used a dataType json before passing the serialized values here
    }
    
    function send_email_disapproved_ot() {
        require_once('../class/oop.php'); //OOP Path
		require_once('send_email.php');
		$return = $_POST;
		$msg = 0;
//        $pkid = '3';
//        $username = 'jeferrer';
        $pkid = $return['pkid'];
        $username = $return['username'];
        /* Construct email content */    
		$body_header  = 'Good day!<br>';
		$body_header .= 'Please be informed that your overtime request is already disapproved.<br>';
		$body_header .= 'Below are the overtime information:<br>';
		
		/* Get overtime main info */
		$array_fields_main = array("req_by","req_type","req_date","req_justification","req_manpower","req_datefrom","req_dateto","req_approver");
		$table_main 	   	= 'tkovertime_main';
		$joins_main 	   	= '';
		$sql_where_main 	= 'WHERE pkid="'.$pkid.'" AND logdel=0';
		$sql_order_main 	= '';
		$sql_limit_main 	= '';
		$result_main = OT::getInstance()->select_query($array_fields_main,$table_main,$joins_main,$sql_where_main,$sql_order_main,$sql_limit_main);
		if($row_main = mysqli_fetch_array($result_main)){
			$req_by 	        = $row_main['req_by'];
			$req_date 	        = date('M d, Y', strtotime($row_main['req_date']));
			$date_ot		    = date('M d, Y', strtotime($row_main['req_datefrom'])) . " - " . date('M d, Y', strtotime($row_main['req_dateto']));
			$req_manpower 		= $row_main['req_manpower'];
			$req_justification 	= $row_main['req_justification'];			
			$req_type 	        = $row_main['req_type'];
			$approver_username  = $row_main['req_approver'];
			if($req_type == 1) {
				$req_type = 'Regular';
			} else if($req_type == 2) {
				$req_type = 'Legal Sunday';
			} else if($req_type == 3) {
				$req_type = 'Sunday';
			} else if($req_type == 4) {
				$req_type = 'Special Non Working Holiday';
			} else if($req_type == 5) {
				$req_type = 'Sunday/Legal Holiday';
			} else if($req_type == 6) {
				$req_type = 'Sunday/Special Holiday';
			} else {
				$req_type = 'ERROR!!!';
			}
			$body_ot_main .= '<hr><br><b><i>Overtime Information:</i></b><br>';
			$body_ot_main .= '<b>Overtime Type: </b>'.$req_type."<br>";
			$body_ot_main .= '<b>Date of Overtime: </b>'.$date_ot."<br>";
			$body_ot_main .= '<b>Manpower Involved: </b>'.$req_manpower."<br>";
			$body_ot_main .= '<b>Justification: </b>'.$req_justification."<br><br><hr>";
		}
		
		/* Get overtime details */
		$body_ot_details .= '<table>';
		$body_ot_details .= '	<thead>';
		$body_ot_details .= '		<th style="width:10%;">Emp No</th>';
		$body_ot_details .= '		<th style="width:20%;">Employee Name</th>';
		$body_ot_details .= '		<th style="width:10%;">OT Date</th>';
		$body_ot_details .= '		<th style="width:10%;">OT Hours</th>';
		$body_ot_details .= '		<th style="width:30%;">Remarks</th>';
		$body_ot_details .= '	<thead>';
		$body_ot_details .= '	<tbody>';
		$array_fields_details = array('otks.ot_date', 'otks.empno', 'otks.filed_ot', 'otks.remarks','CONCAT(hris.lastname,", ",hris.firstname) AS emp_name');
		$table_details 	   	= 'tk_overtime_details otks';
		$joins_details 	   	= 'INNER JOIN db_hris.vw_EmpInfo_Rapid hris ON hris.EmpNo = otks.empno';
		$sql_where_details 	= 'WHERE otks.fkid_ot_main="'.$pkid.'"';
		$sql_order_details 	= 'ORDER BY otks.pkid';
		$sql_limit_details 	= '';
		$result_details = OT::getInstance()->select_query($array_fields_details,$table_details,$joins_details,$sql_where_details,$sql_order_details,$sql_limit_details);
		while($row_details = mysqli_fetch_array($result_details)){
			$empno 		= $row_details['empno'];
			$emp_name	= $row_details['emp_name'];
			$ot_date 	= date('M d, Y',strtotime($row_details['ot_date']));
			$filed_ot 	= $row_details['filed_ot'];
			$remarks 	= $row_details['remarks'];
			$body_ot_details .= '		<tr>';
			$body_ot_details .= '			<td style="width:10%;"><center>'.$empno.'</center></td>';
			$body_ot_details .= '			<td style="width:20%;">'.$emp_name.'</td>';
			$body_ot_details .= '			<td style="width:10%;"><center>'.$ot_date.'</center></td>';
			$body_ot_details .= '			<td style="width:10%;"><center>'.$filed_ot.'</center></td>';
			$body_ot_details .= '			<td style="width:30%;">'.$remarks.'</td>';
		}
		$body_ot_details .= '	</tbody>';
		$body_ot_details .= '</table> <br><br><br>';
		
		$subject = 'Disapproved Overtime Request';
		$body = $body_header . $body_ot_main . $body_ot_details;
		
		/* Get the recipient email address */
		$select_query_to = get_email_add($req_by) ;
		if($row_to = mysqli_fetch_array($select_query_to)) {
			$to = $row_to['email_add'];
		}
		
		$select_query_from = get_email_add($username) ;
		if($row_from = mysqli_fetch_array($select_query_from)) {
			$from = $row_from['email_add'];
		}		
//		 echo $body.'<br>['.$to.']<br>['.$from.']<br>';		
		$php_mailer = new email();
		$msg = $php_mailer->send_email($to, $from, $from, $subject, $body,'');
		$return['msg'] = $msg;		
		echo json_encode($return);
    }
	
    function check_double_filed_ot($empno,$pkid,$ot_date,$valid_ot) {
        require_once('../class/oop.php'); //OOP Path
		$return = $_POST;
		$result = "";
		$array_fields = array('main.created_by_name');
		$table 	   	= 'tk_overtime_details det';
		$joins 	   	= 'INNER JOIN vw_overtime main ON det.`fkid_ot_main` = main.pkid';
		$sql_where 	= 'WHERE det.`ot_date`="'.date('Y-m-d',strtotime($ot_date)).'" AND det.`empno` = "'.$empno.'" AND det.`valid_ot`="'.number_format($valid_ot, 2, '.', '').'" AND main.pkid != "'.$pkid.'" AND det.`logdel`=0 AND (main.req_status BETWEEN 0 AND 3)';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = OT::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($result->num_rows == 0){
			$has_return	  = 'NO';
		} else {
            $row = mysqli_fetch_array($result);
            $has_return	  = $row['created_by_name'];
        }
        return $has_return;
    }

	function get_email_add($username) {
		require_once('../class/oop.php'); //OOP Path
		$array_fields = array('email_add');
		$table 	   	= 'db_acl.tbl_useraccnt';
		$joins 	   	= '';
		$sql_where 	= 'WHERE username="'.$username.'"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = OT::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		return $result;
	}
	
    function compute_overtime($normal_date_time_out, $actual_date_time_out) {
		$normal_date_time_out = date('Y-m-d H:i:s',strtotime($normal_date_time_out));
		$actual_date_time_out = date('Y-m-d H:i:s',strtotime($actual_date_time_out));
        $time_in = strtotime($normal_date_time_out);
        $time_out = strtotime($actual_date_time_out);

        $diff = $time_out - $time_in;
        /* seconds difference */
        $diff_in_sec = ($diff % 60); 

        $diff_in_min = $diff / 60;
        $diff_in_min = explode(".",$diff_in_min);
        /* get the minute difference */
        $diff_in_min = $diff_in_min[0];

        /* get difference in hour */
        $diff_in_hour = $diff_in_min / 60 ;

        $diff_in_min = $diff_in_min % 60;

        $diff_in_hour = explode(".",$diff_in_hour);
        $diff_in_hour = $diff_in_hour[0];

        $return = array();
        $return['hour'] = $diff_in_hour;
        $return['min'] = $diff_in_min;
        $return['sec'] = $diff_in_sec;

        return $return;
    }

	function has_day_off($emp_no) {
		/* Check if employee has day-off */
		require_once('../class/oop.php');
        $array_fields_day_off = array("dayoff_type");
		$table_day_off 	   	= "tkday_off";
		$joins_day_off 	   	= "";
		$sql_where_day_off 	= "WHERE empno='".$emp_no."' AND logdel='0'";
		$sql_order_day_off 	= '';
		$sql_limit_day_off 	= '';
		$result_day_off = OT::getInstance()->select_query($array_fields_day_off,$table_day_off,$joins_day_off,$sql_where_day_off,$sql_order_day_off,$sql_limit_day_off);
		if($result_day_off->num_rows == 0) {
           $day_off = "false";
        } else {
            if($row_day_off = mysqli_fetch_array($result_day_off)){
                if($row_day_off['dayoff_type'] == "1") { //1 means with day off
                    $day_off = "true";
                } else {
                    $day_off = "false";
                }
            }   
        }
		return $day_off;
	}
	
	function round_off_overtime($hour, $mins) {
		if($mins < 30) {
			$mins = "0";
		} else {
			$mins = "5";
		}
		return $hour.".".$mins;
	}

	function check_null($value){
		if(is_null($value)){
			return "";
		} else if($value == '') {
			return "";
		} else{
			return $value;
		}
	}

    function get_day_name() {	
        $return['day_name'] = date('l',strtotime($_POST['date_selected']));		
		echo json_encode($return);
    }

    function save_ot_data(){
        require_once('../class/oop.php'); //OOP Path
		$return 		= $_POST;
        $array_record = $return['array_record_save'];
        for($x=0;$x<count($array_record['empno']);$x++){
			if($array_record['date_time_in'][$x] == 'N/A') {
				$date_time_in       = '';
			} else {
				$date_time_in       = date('Y-m-d H:i:s',strtotime($array_record['date_time_in'][$x]));
			}
			if($array_record['date_time_out'][$x] == 'N/A') {
				$date_time_out       = '';
			} else {
				$date_time_out       = date('Y-m-d H:i:s',strtotime($array_record['date_time_out'][$x]));
			}
            $date_time_created  = date('Y-m-d H:i:s');
            $username           = $return['username'];
            $fkid_ot_main       = $return['fkid'];
            $pkid               = $array_record['pkid'][$x];
            $ot_date            = date('Y-m-d',strtotime($array_record['ot_date'][$x]));
            $empno              = $array_record['empno'][$x];
            $filed_ot           = number_format((float)$array_record['filed_ot'][$x], 2, '.', '');
            $valid_ot           = number_format((float)$array_record['valid_ot'][$x], 2, '.', '');
            $remarks            =  $array_record['remarks'][$x];
            $system_comment     = $array_record['system_comment'][$x];
            $date_time_created  = date('Y-m-d H:i:s');
            $username           = $return['username'];
            $fkid_ot_main       = $return['fkid'];
            $pkid               = $array_record['pkid'][$x];
            $ot_date            = date('Y-m-d',strtotime($array_record['ot_date'][$x]));
            $empno              = $array_record['empno'][$x];
            $filed_ot           = number_format((float)$array_record['filed_ot'][$x], 2, '.', '');
            $valid_ot           = number_format((float)$array_record['valid_ot'][$x], 2, '.', '');
            $remarks            =  $array_record['remarks'][$x];
            $system_comment     = $array_record['system_comment'][$x];
//            
            if($array_record['pkid'][$x] == 0){
                $result 		= "";
                $table   		= "tk_overtime_details"; //table name
                $array_fields 	= array("date_time_created", 
                                        "created_by", 
                                        "fkid_ot_main", 
                                        "ot_date", 
                                        "date_time_in", 
                                        "date_time_out", 
                                        "empno", 
                                        "filed_ot", 
                                        "valid_ot", 
                                        "remarks",
                                        "system_comment",
                                        "username", 
                                        "lastupdate"); 
                $array_values 	= array($date_time_created,
                                        strtolower($username),
                                        $fkid_ot_main,
                                        $ot_date,
                                        $date_time_in,
                                        $date_time_out,
                                        strtoupper($empno),
                                        $filed_ot,
                                        $valid_ot,
                                        $remarks,
                                        $system_comment,
                                        $username,
                                        $date_time_created); 
                $result 		= OT::getInstance()->insert_query($table,$array_fields,$array_values);
//                $test = 'seyb';
            }else{
                $result 		= "";
                $table   		= "tk_overtime_details"; //table name
                $array_fields 	= array(
//                                        "date_time_created", 
                                        "created_by", 
//                                        "fkid_ot_main", 
                                        "ot_date", 
                                        "date_time_in", 
                                        "date_time_out", 
                                        "empno", 
                                        "filed_ot", 
                                        "valid_ot", 
                                        "remarks",
                                        "system_comment",
                                        "username", 
                                        "lastupdate"); 
                $array_values 	= array(
//                                        $date_time_created,
                                        $username,
//                                        $fkid_ot_main,
                                        $ot_date,
                                        $date_time_in,
                                        $date_time_out,
                                        $empno,
                                        $filed_ot,
                                        $valid_ot,
                                        $remarks,
                                        str_replace('FOR UPDATE!','',$system_comment),
                                        $username,
                                        $date_time_created);
                $result 		= OT::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
//                $test = 'updeyt '.$pkid.$result;
            }
        }
            
        $return['sample'] = 'Record Saved!';
		echo json_encode($return); //json encode since I used a dataType json before
    }

    function delete_ot_details(){
        require_once('../class/oop.php'); //OOP Path
		$return 		= $_POST;
        $array_record = $return['array_delete'];
        for($x=0;$x<count($array_record);$x++){
            $username           = $return['username'];
            $date_time  = date('Y-m-d H:i:s');
            $pkid           = $array_record[$x]; 
            $result 		= "";
            $table   		= "tk_overtime_details"; //table name
            $array_fields 	= array("logdel", 
                                    "username", 
                                    "lastupdate"); 
            $array_values 	= array('1',
                                    $username,
                                    $date_time);
            $result 		= OT::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
        }
        $return['sample'] = $result;
		echo json_encode($return); //json encode since I used a dataType json before
    }
	
	/* MANAGE BATCH START */
	function save_batch_employee(){
		require_once('../class/oop.php'); //OOP Path

		/* check if record already exist on the table */
		$return = $_POST;
		$result = "";
		$array_fields = array('*');
		$table 	   	= 'vw_batch_employee_list';
		$joins 	   	= '';
		$sql_where 	= 'WHERE username = "'.$return['username'].'" AND `empno` = "'.$return['emp_no'].'";';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = OT::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
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
		$result = OT::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
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
		$array_values 	= array(strtoupper($return['emp_no']),strtolower($return['username'])); //values to be saved
		$result 		= OT::getInstance()->insert_query($table,$array_fields,$array_values);
		$return["result"] = json_encode($result); //return the the serialize values
		$return['invalid'] = false;
		echo json_encode($return); //json encode since I used a dataType json before passing the serialized values here
	}
	
	function delete_batch_employee(){
		require_once('../class/oop.php'); //OOP Path
		$return 	  = $_POST; 
		$result 	  = "";
		$table        = "tbl_batch_employee_list";
		$array_fields = array('lastupdate','username','logdel');
		$array_values = array(date('Y-m-d H:i:s'),$return['username'],'1');
		$pkid = $return['pkid'];
		$result = OT::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
		$return["result"] = json_encode($result); //return the the serialize values
		echo json_encode($return); //json encode since I used a dataType json before passing the serialized values here
	}
	
	/* MANAGE BATCH END */

/* DO NOT EDIT BELOW. FOR REFERENCE USED ONLY */
/* DO NOT EDIT BELOW. FOR REFERENCE USED ONLY */
/* DO NOT EDIT BELOW. FOR REFERENCE USED ONLY */
/* DO NOT EDIT BELOW. FOR REFERENCE USED ONLY */
/* DO NOT EDIT BELOW. FOR REFERENCE USED ONLY */
/* DO NOT EDIT BELOW. FOR REFERENCE USED ONLY */
/* DO NOT EDIT BELOW. FOR REFERENCE USED ONLY */


	/* function for displaying record */
	function load_records(){
		require_once('../class/oop.php'); //OOP Path
		$return = $_POST;
		$result = "";
		$array_fields = array('*');
		$table 	   	= 'tbl_records';
		$joins 	   	= '';
		$sql_where 	= '';
		$sql_order 	= 'ORDER BY pkid';
		$sql_limit 	= '';
		$result = OT::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
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
		require_once('../class/oop.php'); //OOP Path
		$return 		= $_POST; 
		$result 		= "";
		$table   		= "tbl_records"; //table name
		$array_fields 	= array('name','lastname','address','remarks'); //table fields
		$array_values 	= array($return['txt_name'],$return['txt_lastname'],$return['txt_address'],$return['txt_remarks']); //values to be saved
		$result 		= OT::getInstance()->insert_query($table,$array_fields,$array_values);
		$return["result"] = json_encode($result); //return the the serialize values
		echo json_encode($return); //json encode since I used a dataType json before passing the serialized values here
	}
	
	/* function for fetching record */
	function update_fetch_record(){
		require_once('../class/oop.php'); //OOP Path
		$return = $_POST; 
		$result = "";
		$array_fields = array('*');
		$table 	   	= 'tbl_records';
		$joins 	   	= '';
		$sql_where 	= 'WHERE `pkid` ='.$return['pkid'];
		$sql_order 	= 'ORDER BY pkid';
		$sql_limit 	= '';
		$result = OT::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
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
		require_once('../class/oop.php'); //OOP Path
		$return = $_POST; 
		$result = "";
		$table        = "tbl_records";
		$array_fields = array('name','lastname','address','remarks');
		$array_values = array($return['txt_name_update'],$return['txt_lastname_update'],$return['txt_address_update'],$return['txt_remarks_update']);
		$pkid = $return['txt_pkid'];
		$result = OT::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
		$return["result"] = json_encode($result); //return the the serialize values
		echo json_encode($return); //json encode since I used a dataType json before passing the serialized values here
	}
	
	/* function for deleting a record */
	function delete_record(){
		require_once('../class/oop.php'); //OOP Path
		$return 	= $_POST; 
		$result 	= "";
		$table   	= "tbl_records";
		$pkid 		= $return['pkid'];
		$result 	= OT::getInstance()->delete_query($table,$pkid);
		$return["result"] = json_encode($result); //return the the serialize values
		echo json_encode($return); //json encode since I used a dataType json before passing the serialized values here
	}


?>