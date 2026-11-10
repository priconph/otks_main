<?php
	if(is_ajax()) {
		if(isset($_POST["action"]) && !empty($_POST["action"])) {
			$action = $_POST["action"];
			switch($action) {
				case "load_hris_record_by_username"         : load_hris_record_by_username(); break; //switch case, in using ajax an action must be set in order to choose the specific function to used
				case "load_approver_list" 			        : load_approver_list(); break; //switch case, in using ajax an action must be set in order to choose the specific function to used
				case "fetch_main_data_update" 		        : fetch_main_data_update(); break; //switch case, in using ajax an action must be set in order to choose the specific function to used
				case "add_new_request" 		                : add_new_request(); break; 
				case "update_request" 		                : update_request(); break; 
				case "load_request_info_by_pkid" 	        : load_request_info_by_pkid(); break; 
				case "cancel_request" 	                    : cancel_request(); break; 
				case "approve_disapprove_request"           : approve_disapprove_request(); break; 
				case "check_employee_salary_type"           : check_employee_salary_type(); break; 
				case "load_hris_record_by_managed_batch"    : load_hris_record_by_managed_batch(); break; 
				case "load_employee_info_by_name"           : load_employee_info_by_name(); break; 
				case "load_employee_info_by_number"         : load_employee_info_by_number(); break; 
				case "load_supervisor_name_list"            : load_supervisor_name_list(); break; 
				case "load_hris_record_by_empno"            : load_hris_record_by_empno(); break; 
				case "check_employee_details"            	: check_employee_details(); break; 
				case "send_email_to_approver"            	: send_email_to_approver(); break; 
				case "add_new_request_kiosk"            	: add_new_request_kiosk(); break; 
				case "check_systemone_account"            	: check_systemone_account(); break; 
				case "send_email_to_approver_kiosk"         : send_email_to_approver_kiosk(); break; 
				case "validate_ob_date"         			: validate_ob_date(); break; 
                    
				case "load_hris_record_by_section" 		: load_hris_record_by_section(); break;  
				case "load_records" 				: load_records(); break; //switch case, in using ajax an action must be set in order to choose the specific function to use
				case "add_new_record" 				: add_new_record(); break; //switch case, in using ajax an action must be set in order to choose the specific function to use
				case "update_fetch_record" 			: update_fetch_record(); break; //switch case, in using ajax an action must be set in order to choose the specific function to use
				case "update_record" 				: update_record(); break; //switch case, in using ajax an action must be set in order to choose the specific function to use
				case "delete_record" 				: delete_record(); break; //switch case, in using ajax an action must be set in order to choose the specific function to use
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
		
	function load_hris_record_by_empno(){
		require_once('../class/otks.php'); //OOP Path
		$return = $_POST;
		$result = "";
		$array_fields = array('EmpNo','lastname','firstname','middlename','lastname','Division','Department','Section','Position');
		$table 	   	= 'db_hris.vw_EmpInfo_Rapid';
		$joins 	   	= '';
		$sql_where 	= 'WHERE EmpNo = "'.$return['empno'].'"';
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
	
	function load_approver_list() {
		require_once('../class/otks.php'); //OOP Path
		$return = $_POST;
		$result = "";
		$array_fields = array('firstname', 'lastname', 'emp_name', 'Section', 'username', 'EmpNo');
		// $table 	   	= 'db_hris.vw_secheads'; //04022022
		$table 	   	= 'db_hris.vw_secheads_new';
		$joins 	   	= '';
		$sql_where 	= '';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
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

    function add_new_request() {
//        $return['empno']='J005';
//        $return['ob_date']='2016-03-11';
//        $return['ob_purpose']='0';
//        $return['ob_place']='mcl';
//        $return['ob_reason']='test';
//        $return['ob_time_out']='09:00';
//        $return['ob_time_return']='';
//        $return['ob_approver']='jeferrer';
//        $return['ob_status']='0';
//        $return['username']='ronfern';

		/**
		 * For Sir Pau onlu
		 */
		// $return['empno']='O103';
		// $return['ob_date']='2022-09-23';
		// $return['ob_purpose']='0';
		// $return['ob_place']='TSS';
		// $return['ob_reason']='Recounting of IT Equipment for PEZA requirements';
		// $return['ob_time_out']='13:00';
		// $return['ob_time_return']='14:00';
		// $return['ob_approver']='esmolina';
		// $return['ob_status']='0';
		// $return['username']='jnpineda';
        
        require_once('../class/otks.php'); 
		$return['ob_purpose']  = str_replace("'","",$return['ob_purpose']);
		$return['ob_place'] = str_replace("'","",$return['ob_place']);
		$return['ob_reason'] = str_replace("'","",$return['ob_reason']);
		
        $date_time_created = date('Y-m-d H:i:s');
        $return 		= $_POST; 
		$result 		= "";
		$table   		= "tkob"; //table name
		$array_fields_select = array("pkid");
		$joins 	   	= '';
		$sql_where_select 	= 'WHERE empno="'.$return['empno'].'" AND ob_date = "'.$return['ob_date'].'" AND ob_time_out = "'.$return['ob_time_out'].'" AND logdel=0 AND ob_status!=3';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result_select = OTKS::getInstance()->select_query($array_fields_select,$table,$joins,$sql_where_select,$sql_order,$sql_limit);
        if($result_select->num_rows==0) {
            $array_fields 	= array("date_time_created", "created_by", "empno", "ob_date", "ob_purpose", "ob_place", "ob_reason", "ob_time_out", "ob_time_return", "ob_approver", "ob_status", "lastupdate", "username"); //table fields
            $array_values 	= array($date_time_created,$return['username'],$return['empno'],$return['ob_date'],$return['ob_purpose'],$return['ob_place'],$return['ob_reason'],$return['ob_time_out'],$return['ob_time_return'],$return['ob_approver'],$return['ob_status'],$date_time_created,$return['username']); //values to be saved
            $pkid 		= OTKS::getInstance()->insert_query_id($table,$array_fields,$array_values);
			/* Return pkid for sending email */
			// $array_fields_pkid = array("pkid");
			// $sql_where_pkid 	= 'WHERE empno="'.$return['empno'].'" AND ob_date = "'.$return['ob_date'].'" AND ob_time_out = "'.$return['ob_time_out'].'" AND created_by = "'.$return['username'].'" AND ob_purpose = "'.$return['ob_purpose'].'" AND ob_approver = "'.$return['ob_approver'].'" AND logdel=0 AND ob_status!=3';
			// $result_pkid = OTKS::getInstance()->select_query($array_fields_pkid,$table,$joins,$sql_where_pkid,$sql_order,$sql_limit);
			// if($row_pkid = mysqli_fetch_array($result_pkid)) {
				// $pkid = $row_pkid['pkid'];
			// }
        } else {
            $msg = 'Request already exists!';
			$pkid = 0;
        } 
		$return["msg"] = $msg;		
		$return["new_pkid"] = $pkid;		
		$return["result"] = json_encode($result); //return the the serialize values
		echo json_encode($return); //json encode since I used a dataType json before passing the serialized values here
    }
   
	function add_new_request_kiosk() {        
        require_once('../class/otks.php'); 
				
        $date_time_created = date('Y-m-d H:i:s');
        $return 		= $_POST; 
		$result 		= "";
		$table   		= "tkob"; //table name
		$array_fields_select = array("pkid");
		$joins 	   	= '';
		$sql_where_select 	= 'WHERE empno="'.$return['empno'].'" AND ob_date = "'.$return['ob_date'].'" AND ob_time_out = "'.$return['ob_time_out'].'" AND logdel=0 AND ob_status!=3';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result_select = OTKS::getInstance()->select_query($array_fields_select,$table,$joins,$sql_where_select,$sql_order,$sql_limit);
        if($result_select->num_rows==0) {
            $array_fields 	= array("date_time_created", "created_by", "empno", "ob_date", "ob_purpose", "ob_place", "ob_reason", "ob_time_out", "ob_time_return", "ob_approver", "ob_status", "supervisor_username", "lastupdate", "username"); //table fields
            $array_values 	= array($date_time_created,'kiosk',$return['empno'],$return['ob_date'],$return['ob_purpose'],$return['ob_place'],$return['ob_reason'],$return['ob_time_out'],$return['ob_time_return'],$return['ob_approver'],$return['ob_status'],$return['js_ss_username'],$date_time_created,'kiosk'); //values to be saved
            $msg 		= OTKS::getInstance()->insert_query($table,$array_fields,$array_values);
			/* Return pkid for sending email */
			$array_fields_pkid = array("pkid");
			$sql_where_pkid 	= 'WHERE empno="'.$return['empno'].'" AND ob_date = "'.$return['ob_date'].'" AND ob_time_out = "'.$return['ob_time_out'].'" AND created_by = "kiosk" AND ob_purpose = "'.$result['ob_purpose'].'" AND ob_approver = "'.$return['ob_approver'].'" AND logdel=0 AND ob_status!=3';
			$result_pkid = OTKS::getInstance()->select_query($array_fields_pkid,$table,$joins,$sql_where_pkid,$sql_order,$sql_limit);
			if($row_pkid = mysqli_fetch_array($result_pkid)) {
				$pkid = $row_pkid['pkid'];
			}
        } else {
            $msg = 'Request already exists!';
			$pkid = 0;
        } 
		$return["msg"] = $msg;		
		$return["new_pkid"] = $pkid;		
		$return["result"] = json_encode($result); //return the the serialize values
		echo json_encode($return); //json encode since I used a dataType json before passing the serialized values here
    }

    function update_request() {
        require_once('../class/otks.php'); 
        $date_time_created = date('Y-m-d H:i:s');
        $return 		= $_POST; 
		$result 		= "";
		$table   		= "tkob"; //table name
        $array_fields 	= array("date_time_created", "created_by", "empno", "ob_date", "ob_purpose", "ob_place", "ob_reason", "ob_time_out", "ob_time_return", "ob_approver", "ob_status", "lastupdate", "username"); //table fields
        $array_values 	= array($date_time_created,$return['username'],$return['empno'],$return['ob_date'],$return['ob_purpose'],$return['ob_place'],$return['ob_reason'],$return['ob_time_out'],$return['ob_time_return'],$return['ob_approver'],$return['ob_status'],$date_time_created,$return['username']); //values to be saved
        $pkid = $return['pkid'];
        $result = OTKS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
        $return["msg"] = $result;		
		$return["result"] = json_encode($result); //return the the serialize values
		echo json_encode($return); //json encode since I used a dataType json before passing the serialized values here
    }
	
    function send_email_to_approver() {
        require_once('../class/otks.php'); 
        require_once('../class/send_email.php');
		
		$array_fields = array('created_by','Position','empno','emp_name','ob_date','ob_purpose','ob_place','ob_reason','ob_time_out','ob_time_return','ob_approver' );
		$table 	   	= 'vw_ut_ob';
		$joins 	   	= '';
		$sql_where 	= 'WHERE `ob_pkid` = "'.$_POST['pkid'].'"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$ctr = 0;
		$leave_type = '';
		if($row = mysqli_fetch_array($result)){
			$ob_purpose 	= $row['ob_purpose'];
			$empno 			= $row['empno'];
			$emp_name		= $row['emp_name'];
			$position 		= $row['Position'];
			$ob_date		= $row['ob_date'];
			$ob_reason		= $row['ob_reason'];
			$ob_time_out	= $row['ob_time_out'];
			$ob_time_return	= $row['ob_time_return'];
			$ob_approver	= $row['ob_approver'];
			$username		= $row['created_by'];
			$ob_place		= $row['ob_place'];
			
			if($ob_purpose == 'UT') {
				$leave_type = "Undertime";
			} else {
				$leave_type = 'Official Business';
			}
			
			/* Construct email content */    
			if($_POST['req_type'] == 'new') {
				$subject = 'For Approval: '.$leave_type.' Request';
			} else {
				$subject = 'For Approval: Revised '.$leave_type.' Request';
			}       
		}	
		
        
         
		$body  = 'Good day! <br>';
		$body .= 'Please be informed that you have <b>'.$leave_type.'</b> request for approval.<br><br>';
		$body .= 'Below are the details:<br>';
		$body .= 'Employee Number: '.$empno.'<br>';
		$body .= 'Employee Name: '.$emp_name.'<br>';
		$body .= 'Position: '.$position.'<br>';
		$body .= 'Date of Leave: '.date('M d, Y',strtotime($ob_date)).'<br>';
        if($ob_purpose != 0) {
            $body .= 'Place of OB: '.$ob_place.'<br>';
        }
		$body .= 'Reason: '.$ob_reason.'<br>';
		$body .= 'Time out: '.date('h:i A',strtotime($ob_time_out)).'<br>';
        if($ob_time_return != '') {
            $body .= 'Time return: '.date('h:i A',strtotime($ob_time_return)).'<br>';
        }
        /* Get the recipient email address */
		$select_query_to = get_email_add($ob_approver) ;
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
		$return["msg_email"] = $msg;
		// $return["msg_email"] = 'rona';
		echo json_encode($return);
    }
	
    function load_request_info_by_pkid() {
        require_once('../class/otks.php'); //OOP Path
		$return = $_POST;
		$result = "";
		$array_fields = array("empno", "emp_name", "Position", "Department", "ob_date", "ob_purpose", "ob_place", "ob_reason", "ob_time_out", "ob_time_return", "ob_approver", "ob_status_name", "date_time_created");
		$table 	   	= 'vw_ut_ob';
		$joins 	   	= '';
		$sql_where 	= 'WHERE ob_pkid="'.$return['pkid'].'"';
//		$sql_where 	= 'WHERE ob_pkid="12" AND created_by = "ronfern"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_array($result)){
            $row['ob_reason'] = str_replace("<br><b>","",$row['ob_reason']);
            $row['ob_reason'] = str_replace("</b>","",$row['ob_reason']);
			$return['empno'] 			 = $row['empno'];
			$return['emp_name'] 		 = $row['emp_name'];
			$return['position'] 		 = $row['Position'];
			$return['department'] 		 = $row['Department'];
			$return['ob_date']           = $row['ob_date'];
			$return['ob_purpose']        = $row['ob_purpose'];
			$return['ob_place']          = $row['ob_place'];
			$return['ob_reason']         = $row['ob_reason'];
			$return['ob_time_out'] 	     = $row['ob_time_out'];
			$return['ob_time_return']    = $row['ob_time_return'];
			$return['ob_approver']       = $row['ob_approver'];
			$return['ob_status_name']    = $row['ob_status_name'];
			$return['date_time_created'] = date('M d, Y g:i A', strtotime($row['date_time_created']));
		}
		$return['result'] = json_encode($result);
		echo json_encode($return);
    }

    function cancel_request() {
        require_once('../class/otks.php'); //OOP Path
        require_once('../class/send_email.php');
        $return = $_POST;
//        $return['pkid'] = '5';
//        $return['username'] = 'jeferrer';
//        $return['cancel_remarks'] = 'jeferrer';
		/* Append cancel remarks on justification */
        $array_fields_justi = array('ob_status','ob_reason');
		$table_justi 	   	= 'tkob';
		$joins_justi 	   	= '';
		$sql_where_justi 	= 'WHERE pkid = "'.$return['pkid'].'" AND logdel=0';
		$sql_order_justi 	= '';
		$sql_limit_justi 	= '';
		$result_justi = OTKS::getInstance()->select_query($array_fields_justi,$table_justi,$joins_justi,$sql_where_justi,$sql_order_justi,$sql_limit_justi);
        if($row_justi = mysqli_fetch_array($result_justi)){
			$ob_status = $row_justi['ob_status']; 
			$ob_reason = $row_justi['ob_reason']." 
            <br><b>Cancellation Remarks(".date('m/d/y h:i:s A')."): </b>".$return['cancel_remarks'];            
            /* Add remarks on justification field */
            $array_fields_update = array("ob_reason","ob_status", "username","lastupdate"); 
            $array_values_update = array($ob_reason,'3',$return['username'],date('Y-m-d H:i:s'));
            $update = OTKS::getInstance()->update_query($table_justi,$array_fields_update,$array_values_update,$return['pkid']);
		}  
        if($ob_status != 4) {
            /* Get the request details */
            $result = "";
            $array_fields = array('created_by', 'emp_name', 'Position', 'empno', 'ob_date', 'ob_purpose', 'ob_place', 'ob_reason', 'ob_time_out', 'ob_time_return', 'ob_approver');
            $table 	   	= 'vw_ut_ob';
            $joins 	   	= '';
            $sql_where 	= 'WHERE ob_pkid = "'.$return['pkid'].'"';
            $sql_order 	= '';
            $sql_limit 	= '';
            $result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
            if($row = mysqli_fetch_array($result)){
                $created_by		= $row['created_by'];
                $emp_name 		= $row['emp_name'];
                $position 		= $row['Position'];
                $empno 			= $row['empno'];
                $ob_date 		= $row['ob_date'];
                $ob_purpose 	= $row['ob_purpose'];
                $ob_place       = $row['ob_place'];
                $ob_reason      = $row['ob_reason'];
                $ob_time_out 	= $row['ob_time_out'];
                $ob_time_return = $row['ob_time_return'];
                $ob_approver 	= $row['ob_approver'];
            }

            //get the name of the user who cancel the request
            $array_fields = array('lastname','firstname');
            $table 	   	= 'db_hris.vw_EmpInfo_Rapid';
            $joins 	   	= '';
            $sql_where 	= 'WHERE username = "'.$return['username'].'"';
            $sql_order 	= '';
            $sql_limit 	= '';
            $result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
            while($row = mysqli_fetch_array($result)){
                $user_name 	= $row['firstname'].' '.$row['lastname'];
            }

            if($ob_purpose == "UT") {
                $leave_type = "Undertime";
            } else {
                $leave_type = 'Official Business';
            }
            /* Construct email content */    
            $subject = 'Cancelled '.$leave_type.' Request';
            $body  = 'Good day!<br>';
            $body .= 'Please be informed that the <b>'.$leave_type.'</b> request was cancelled by '.$user_name.'.<br>';
            $body .= 'Below are the details:<br>';
            $body .= 'Employee Number: '.$empno.'<br>';
            $body .= 'Employee Name: '.$emp_name.'<br>';
            $body .= 'Position: '.$position.'<br>';
            $body .= 'Date of Leave: '.date('M d, Y',strtotime($ob_date)).'<br>';
            if($ob_purpose != 0) {
                $body .= 'Place of OB: '.$ob_place.'<br>';
            }
            $body .= 'Reason: '.$ob_reason.'<br>';
            $body .= 'Time out:'.date('h:i A',strtotime($ob_time_out)).'<br>';
            if($ob_time_return != '') {
                $body .= 'Time return: '.date('H:i A',strtotime($ob_time_return)).'<br>';
            }
            /* Get the recipient email address */
            if($return['username'] != $ob_approver) {
                $select_query_to = get_email_add($ob_approver) ;
                if($row_to = mysqli_fetch_array($select_query_to)) {
                    $to = $row_to['email_add'];
                }
            } else {
                $select_query_to = get_email_add($created_by) ;
                if($row_to = mysqli_fetch_array($select_query_to)) {
                    $to = $row_to['email_add'];
                }
            }
            $select_query_from = get_email_add($return['username']) ;
            if($row_from = mysqli_fetch_array($select_query_from)) {
                $from = $row_from['email_add'];
            }		
    //		 echo $body.'<br>to: '.$to.'<br>from: '.$from;		
            $php_mailer = new email();
            $msg = $php_mailer->send_email($to, $from, $from, $subject, $body,'');   
        } else {
            $msg = 'Request was successfully cancelled!';
        }
        $return["msg"] = $msg; //return the the serialize values
        $return["result"] = json_encode($result); //return the the serialize values
		echo json_encode($return); //json encode since I used a dataType json before passing the serialized values here
    }
	
    function approve_disapprove_request() {
        require_once('../class/otks.php'); //OOP Path
        require_once('../class/send_email.php');
        $return = $_POST;
       // $return['pkid'] = '3';
       // $return['username'] = 'jeferrer';
       // $return['status'] = 1;
        /* Append cancel remarks on justification */
        $array_fields_justi = array('ob_reason');
		$table_update 	   	= 'tkob';
		$joins_justi 	   	= '';
		$sql_where_justi 	= 'WHERE pkid = "'.$return['pkid'].'" AND logdel=0';
		$sql_order_justi 	= '';
		$sql_limit_justi 	= '';
		$result_justi = OTKS::getInstance()->select_query($array_fields_justi,$table_update,$joins_justi,$sql_where_justi,$sql_order_justi,$sql_limit_justi);
        if($row_justi = mysqli_fetch_array($result_justi)){
            if($return['status'] == 2) {
                $ob_reason = $row_justi['ob_reason']."
                <br><b>Disapproved Remarks(".date('m/d/y h:i:s A')."): </b>".$return['disapproved_remarks'];   
            } else {
                $ob_reason = $row_justi['ob_reason'];
            }		         
            /* Add remarks on disapproved request on justification field and Update the status of request */
            $array_fields_update = array("ob_reason","ob_status", "date_time_approved","username","lastupdate"); 
            $array_values_update = array($ob_reason,$return['status'],date('Y-m-d H:i:s'),$return['username'],date('Y-m-d H:i:s'));
            $update = OTKS::getInstance()->update_query($table_update,$array_fields_update,$array_values_update,$return['pkid']);    
		}  
        
        /* Get the request details */
		$result = "";
		$array_fields = array('created_by', 'emp_name', 'Position', 'empno', 'ob_date', 'ob_purpose', 'ob_place', 'ob_reason', 'ob_time_out', 'ob_time_return', 'ob_approver');
		$table 	   	= 'vw_ut_ob';
		$joins 	   	= '';
		$sql_where 	= 'WHERE ob_pkid = "'.$return['pkid'].'"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			$created_by		= $row['created_by'];
			$emp_name 		= $row['emp_name'];
			$position 		= $row['Position'];
			$empno 			= $row['empno'];
			$ob_date 		= $row['ob_date'];
			$ob_purpose 	= $row['ob_purpose'];
			$ob_place       = $row['ob_place'];
			$ob_reason      = $row['ob_reason'];
			$ob_time_out 	= $row['ob_time_out'];
			$ob_time_return = $row['ob_time_return'];
			$ob_approver 	= $row['ob_approver'];
		}
        
        //get the name of the user who approved / disapproved the request
        $array_fields = array('lastname','firstname');
		$table 	   	= 'db_hris.vw_EmpInfo_Rapid';
		$joins 	   	= '';
		$sql_where 	= 'WHERE username = "'.$return['username'].'"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_array($result)){
			$user_name 	= $row['firstname'].' '.$row['lastname'];
		}
        
        if($ob_purpose == "UT") {
            $leave_type = "Undertime";
        } else {
            $leave_type = 'Official Business';
        }
        if($return['status'] == 1) {
            $action = "Approved";
        } else {
            $action = 'Disapproved';
        }
        /* Construct email content */    
        $subject = $action.' '.$leave_type.' Request';
		$body  = 'Good day!<br>';
		$body .= 'Please be informed that the <b>'.$leave_type.'</b> request was '.strtolower($action).' by '.$user_name.'.<br><br>';
		$body .= 'Below are the details: <br>';
		$body .= 'Employee Number: '.$empno.'<br>';
		$body .= 'Employee Name: '.$emp_name.'<br>';
		$body .= 'Position: '.$position.'<br>';
		$body .= 'Date of Leave: '.date('M d, Y',strtotime($ob_date)).'<br>';
        if($ob_purpose != 0) {
            $body .= 'Place of OB: '.$ob_place.'<br>';
        }
		$body .= 'Reason: '.$ob_reason.'<br>';
		$body .= 'Time out:'.date('h:i A',strtotime($ob_time_out)).'<br>';
        if($ob_time_return != '') {
            $body .= 'Time return: '.date('H:i A',strtotime($ob_time_return)).'<br>';
        }
        /* Get the recipient email address */
        if($return['username'] != $ob_approver) {
            $select_query_to = get_email_add($ob_approver) ;
            if($row_to = mysqli_fetch_array($select_query_to)) {
                $to = $row_to['email_add'];
            }
        } else {
            $select_query_to = get_email_add($created_by) ;
            if($row_to = mysqli_fetch_array($select_query_to)) {
                $to = $row_to['email_add'];
            }
        }
		$select_query_from = get_email_add($return['username']) ;
		if($row_from = mysqli_fetch_array($select_query_from)) {
			$from = $row_from['email_add'];
		}		
		 // echo $body.'<br>to: '.$to.'<br>from: '.$from;		
		$php_mailer = new email();
		$msg = $php_mailer->send_email($to, $from, $from, $subject, $body,'');
        $return["msg"] = $msg; //return the the serialize values
        $return["result"] = json_encode($result); //return the the serialize values
		echo json_encode($return); //json encode since I used a dataType json before passing the serialized values here
    }

    function check_employee_salary_type() {
        require_once('../class/otks.php'); //OOP Path
		$return = $_POST;
		$result = "";
		$array_fields = array('SalaryType');
		$table 	   	= 'db_hris.tbl_EmployeeInfo';
		$joins 	   	= '';
		$sql_where 	= 'WHERE EmpNo = "'.$return['empno'].'"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			$return['salary_type'] 			= $row['SalaryType'];
		}
		$return['result'] = json_encode($result);
		echo json_encode($return);
    }
    
	function check_employee_details() {
        require_once('../class/otks.php'); //OOP Path
		$return = $_POST;
		$result = "";
		$array_fields = array('EmpNo','email_add','username');
		$table 	   	= 'db_hris.vw_EmpInfo_Rapid';
		$joins 	   	= '';
		$sql_where 	= 'WHERE EmpNo = "'.$return['empno'].'"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($result->num_rows == 0) {
			$email_add 	= '';
			$username 	= '';
			$exists 	= 'NO';
		} else {
			if($row = mysqli_fetch_array($result)) {
				$email_add 	= $row['email_add'];
				$username 	= $row['username'];
				$exists 	= 'YES';
			}
		}
		
		$return['validate'] = $exists;
		$return['email_add'] = $email_add;
		$return['username'] = $username;
		$return['result'] = json_encode($result);
		echo json_encode($return);
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
			$ctr++;
		}
		$return['ctr']	  = $ctr;
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}

    function load_employee_info_by_name() {
		require_once('../class/otks.php'); //OOP Path
		$return = $_POST;
		$result = "";
		$array_fields = array('EmpNo','Department','Position');
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

    function load_employee_info_by_number() {
		require_once('../class/otks.php'); //OOP Path
		$return = $_POST;
		$result = "";
		$array_fields = array('CONCAT(lastname,", ",firstname) as emp_name','Department','Position');
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

	function load_supervisor_name_list() {
        require_once('../class/otks.php'); //OOP Path
		$return = $_POST;
		$result = "";
		$array_fields = array('firstname', 'lastname', 'emp_name', 'Section', 'username', 'EmpNo');
		$table 	   	= 'db_hris.vw_supervisors';
		$joins 	   	= '';
		$sql_where 	= '';
		$sql_order 	= 'ORDER BY lastname';
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

	function check_systemone_account() {
		require_once('../class/otks.php'); //OOP Path
		$return = $_POST;
		$result = "";
		$array_fields = array('b.username');
		$table 	   	= 'db_hris.tbl_EmployeeInfo a';
		$joins 	   	= 'INNER JOIN db_acl.tbl_useraccnt b ON a.pkid = b.fkemployee';
		$sql_where 	= 'WHERE a.EmpNo="'.$return['empno'].'"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$ctr = 0;
		if($result->num_rows == 0) {
			$has_account = 'NONE';
		} else {
			$has_account = 'YES';
		}
		$return['has_account'] = $has_account;
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}
	
	function send_email_to_approver_kiosk() {
        require_once('../class/otks.php'); 
        require_once('../class/send_email.php');
		
		$array_fields = array('supervisor_username','Position','empno','emp_name','ob_date','ob_purpose','ob_place','ob_reason','ob_time_out','ob_time_return','ob_approver' );
		$table 	   	= 'vw_ut_ob';
		$joins 	   	= '';
		$sql_where 	= 'WHERE `ob_pkid` = "'.$_POST['pkid'].'"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$ctr = 0;
		if($row = mysqli_fetch_array($result)){
			$ob_purpose 	= $row['ob_purpose'];
			$empno 			= $row['empno'];
			$emp_name		= $row['emp_name'];
			$position 		= $row['Position'];
			$ob_date		= $row['ob_date'];
			$ob_reason		= $row['ob_reason'];
			$ob_time_out	= $row['ob_time_out'];
			$ob_time_return	= $row['ob_time_return'];
			$ob_approver	= $row['ob_approver'];
			$js_ss_username	= $row['supervisor_username'];
			$ob_place		= $row['ob_place'];
		}	
		
        if($ob_purpose == 'UT') {
            $leave_type = "Undertime";
        } else {
            $leave_type = 'Official Business';
        }
        /* Construct email content */    
		if($_POST['req_type'] == 'new') {
			$subject = 'For Approval: '.$leave_type.' Request';
		} else {
			$subject = 'For Approval: Revised '.$leave_type.' Request';
		}        
		$body  = 'Good day! <br>';
		$body .= 'Please be informed that you have <b>'.$leave_type.'</b> request for approval.<br><br>';
		$body .= 'Below are the details:<br>';
		$body .= 'Employee Number: '.$empno.'<br>';
		$body .= 'Employee Name: '.$emp_name.'<br>';
		$body .= 'Position: '.$position.'<br>';
		$body .= 'Date of Leave: '.date('M d, Y',strtotime($ob_date)).'<br>';
        if($ob_purpose != 0) {
            $body .= 'Place of OB: '.$ob_place.'<br>';
        }
		$body .= 'Reason: '.$ob_reason.'<br>';
		$body .= 'Time out: '.date('h:i A',strtotime($ob_time_out)).'<br>';
        if($ob_time_return != '') {
            $body .= 'Time return: '.date('h:i A',strtotime($ob_time_return)).'<br>';
        }
		$body .= '<br><i>This is a request generated from Kiosk Pass Slip Module</i>';
        /* Get the recipient email address */
		$select_query_to = get_email_add($ob_approver) ;
		if($row_to = mysqli_fetch_array($select_query_to)) {
			$to = $row_to['email_add'];
		}
		
		$select_query_from = get_email_add($js_ss_username) ;
		if($row_from = mysqli_fetch_array($select_query_from)) {
			$from = $row_from['email_add'];
		}		
		// echo $body.'<br>'.$to.'<br>'.$from;		
		$php_mailer = new email();
		$msg = $php_mailer->send_email($to, $from, $from, $subject, $body,'');
		$return["msg_email"] = $msg;
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
			$return['justification'][$ctr] 	= $row['justification'];
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
	
	function validate_ob_date(){
		$return = $_POST;
		$current_date = date('Y-m-d');
		if(strtotime($current_date) > strtotime($return['ob_date'])) {
			$return['validate'] = 'NO';
		} else {
			$return['validate'] = 'YES';
		}
		echo json_encode($return);
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

	function get_email_add($username) {
		require_once('../class/otks.php'); 
		$array_fields = array('email_add');
		$table 	   	= 'db_acl.tbl_useraccnt';
		$joins 	   	= '';
		$sql_where 	= 'WHERE username="'.$username.'"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		return $result;
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

?>