<?php
	if(is_ajax()) {
		if(isset($_POST["action"]) && !empty($_POST["action"])) {
			$action = $_POST["action"];
			switch($action) {
				case "add_31_days"         					: add_31_days(); break; 
				case "return_batch_list"         			: return_batch_list(); break; 
				case "get_email_list"         			    : get_email_list(); break; 
				case "adjust_time"         			        : adjust_time(); break; 
                
                /* MANAGE TIME START */
				case "save_set_time"         			    : save_set_time(); break; 
				case "return_monitoring_data"         		: return_monitoring_data(); break; 
                /* MANAGE TIME END */
                    
                /* MANAGE BATCH START */
				case "load_hris_record_all"         		: load_hris_record_all(); break; 
				case "load_employee_name_by_number" 	    : load_employee_name_by_number(); break;  
				case "load_employee_number_by_name" 	    : load_employee_number_by_name(); break;  
				case "save_batch_employee"                  : save_batch_employee(); break;  
				case "delete_batch_employee"                : delete_batch_employee(); break;  
                /* MANAGE BATCH END */
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
	function return_batch_list(){
		require_once('../class/oop.php'); //OOP Path
		$return = $_POST;
		$result = "";
		$array_fields = array('empno','fullname');
		$table 	   	= 'vw_batch_employee_list';
		$joins 	   	= '';
		$sql_where 	= 'WHERE username="'.$_POST['username'].'"';
		$sql_order 	= '';
		$sql_limit 	= '';
        $ctr        = 0;
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_array($result)){
			$return['empno'][$ctr] 		= $row['empno'];
			$return['fullname'][$ctr] 	= $row['fullname'];
            $ctr++;
		}
        $return['ctr'] = $ctr;
		echo json_encode($return);
	}
	function get_email_list(){
		require_once('../class/oop.php'); //OOP Path
		$return = $_POST;
		$result = "";
		$array_fields = array('username','email_add','CONCAT(`firstname`," ", `lastname`) as emp_name');
		$table 	   	= 'db_hris.vw_EmpInfo_Rapid';
		$sql_where 	= '';
		$sql_order 	= '';
		$sql_limit 	= '';
        $ctr        = 0;
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_array($result)){
			$return['username'][$ctr] 		= $row['username'];
			$return['email_add'][$ctr] 		= $row['email_add'];
			$return['emp_name'][$ctr] 	    = $row['emp_name'];
            $ctr++;
		}
        $return['ctr'] = $ctr;
		echo json_encode($return);
	}
    function adjust_time() {
        $return = $_POST;
		$return['adjusted_time'] = date('H:i:s', strtotime($_POST['set_time']. ' +' . $_POST['time_adjustment'] . ' minutes'));
		echo json_encode($return);
    }
    function save_set_time() {
        require_once('../class/oop.php'); //OOP Path
        $date_time_today      = date('Y-m-d H:i:s');
		$return               = $_POST;
        $username             = $_POST['username'];
        $late_morning_start   = $_POST['late_morning_start'].':00';
        $late_morning_end     = $_POST['late_morning_end'].':59';
        $late_night_start     = $_POST['late_night_start'].':00';
        $late_night_end       = $_POST['late_night_end'].':59';
        $notification_morning = $_POST['notification_morning'];
        $notification_night   = $_POST['notification_night'];
        $email_recipients     = $_POST['email_recipients'];
        $pkid                 = $_POST['pkid'];
		$table 	   	          = 'tbl_tardiness_reminder';
        $send_to              = array();
        
        if(is_null($email_recipients) || $email_recipients == '') {
            $send_to = '';
        } else {            
            $send_to = implode(',',$email_recipients);  
			$send_to = substr($send_to, 1);
        }
        if( $pkid == 0 ) {            
            $array_fields 	= array('date_time_created', 'created_by', 'late_morning_start', 'late_morning_end', 'late_night_start', 'late_night_end', 'notification_morning', 'notification_night', 'email_recipients', 'lastupdate', 'username'); 
            $array_values 	= array($date_time_today,$username, $late_morning_start, $late_morning_end, $late_night_start, $late_night_end, $notification_morning, $notification_night, $send_to, $date_time_today,$username);
            $msg 			= OTKS::getInstance()->insert_query($table,$array_fields,$array_values);
            $script 		= OTKS::getInstance()->insert_query_script($table,$array_fields,$array_values);
            $pkid           = return_monitoring_pkid($username);
        } else {
            $array_fields 	= array('late_morning_start', 'late_morning_end', 'late_night_start', 'late_night_end', 'notification_morning', 'notification_night', 'email_recipients', 'lastupdate', 'username'); 
            $array_values 	= array($late_morning_start, $late_morning_end, $late_night_start, $late_night_end, $notification_morning, $notification_night, $send_to, $date_time_today,$username);
            $msg 			= OTKS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
            $script 		= OTKS::getInstance()->update_query_script($table,$array_fields,$array_values,$pkid);
        }
        $result['pkid']   = $pkid;
        $result['msg']    = $msg;
        $result['script'] = $script;
		echo json_encode($result);
    }
    function return_monitoring_data() {
        require_once('../class/oop.php'); //OOP Path
		$username = $_POST['username'];
		$result = "";
		$array_fields = array('pkid','late_morning_start', 'late_morning_end', 'late_night_start', 'late_night_end', 'notification_morning', 'notification_night', 'email_recipients');
		$table 	   	= 'tbl_tardiness_reminder';
		$joins 	   	= '';
		$sql_where 	= 'WHERE username = "'.$username.'"';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0,1';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = OTKS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			$return['pkid'] 			    = $row['pkid'];
			$return['late_morning_start'] 	= substr($row['late_morning_start'],0,-3);
			$return['late_morning_end'] 	= substr($row['late_morning_end'],0,-3);
			$return['late_night_start'] 	= substr($row['late_night_start'],0,-3);
			$return['late_night_end'] 		= substr($row['late_night_end'],0,-3);
			$return['notification_morning'] = $row['notification_morning'];
			$return['notification_night'] 	= $row['notification_night'];
			$email_recipients 	            = explode(',', $row['email_recipients']);
            for($i=0;$i<count($email_recipients);$i++) {
                $recipients[] = $email_recipients[$i];
            }
            $return['email_recipients']     = $recipients;
		} else {
            $return['pkid'] 			    = 0;
            $return['late_morning_start'] 	= '';
            $return['late_morning_end'] 	= '';
			$return['late_night_start'] 	= '';
			$return['late_night_end'] 		= '';
			$return['notification_morning'] = '';
			$return['notification_night'] 	= '';
			$return['email_recipients'] 	= '';
        }
        $return['script'] = $script;
		echo json_encode($return);
    }
    function return_monitoring_pkid($username) {
        require_once('../class/oop.php'); 
		$result = "";
		$array_fields = array('pkid');
		$table 	   	= 'tbl_tardiness_reminder';
		$joins 	   	= '';
		$sql_where 	= 'WHERE username = "'.$username.'"';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0,1';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = OTKS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			$pkid 			 = $row['pkid'];
		} else {
            $pkid 			 = 0;
        }
        return $pkid;
    }
    function send_email_to_issued_docs() {
		require_once('../class/oop.php'); 
		require_once('../class/send_email.php');
		$pkid			= $_POST['req_pkid'];
		$username		= $_POST['username'];
		$date_time		= $_POST['date_time'];
		$issued_by	 	= $_POST['issued_by'];
		$date_issued	= $_POST['date_issued'];
		// $username		= 'dormarm';
		// $date_time		= '2017-01-25 18:22:00';
		// $issued_by	 	= 'jossarm';
		// $date_issued	= '2016-12-06';
		$issued_docs	= '';
				
		$table 	   		= 'tbl_doc_request_details';				
		$result 		= "";
		$array_fields 	= array('requested_by', 'doc_no', 'doc_title', 'rev_no', 'no_of_copy', 'issued_to', 'issued_by', 'date_issued', 'issued_dept_section', 'issued_remarks');
		$joins 	   		= '';
		$sql_where 		= 'WHERE fkrequest ='.$pkid . ' AND lastupdate="'.$date_time.'" AND issued_by="'.$issued_by.'" AND date_issued="'.$date_issued.'" AND username="'.$username.'"';
		$sql_order 		= '';
		$sql_limit 		= '';
		$result = DIRS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = DIRS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		
		while($row = mysqli_fetch_array($result)){
			$requestor 			 = $row['requested_by'];
			$issued_to 			 = $row['issued_to'];
			$issued_by 			 = $row['issued_by'];
			$date_issued		 = $row['date_issued'];
			$issued_dept_section = $row['issued_dept_section'];
			$issued_remarks 	 = $row['issued_remarks'];
			$doc_no 	 		 = $row['doc_no'];
			$doc_title 	 		 = $row['doc_title'];
			$rev_no 	 		 = $row['rev_no'];
			$no_of_copy 		 = $row['no_of_copy'];
			$issued_docs 	.= '	  <tr>';
			$issued_docs 	.= '		<td>'.$doc_no.'</td>';
			$issued_docs 	.= '		<td>'.$doc_title.'</td>';
			$issued_docs 	.= '		<td><center>'.$rev_no.'</center></td>';
			$issued_docs 	.= '		<td><center>'.$no_of_copy.'</center></td>';
			$issued_docs 	.= '	  </tr>';
		}
		
		$requestor	= return_emp_info_by_username($requestor);
		$to = $requestor['email_add'] == '' ? '' : $requestor['email_add'];
		$issued_to	= return_emp_info_by_username($issued_to);
		$to = $to == '' ? $issued_to['email_add'] : (($to == $issued_to['email_add']) || ($issued_to['email_add'] == 'kiosk@pricon.ph') ? $to : $to . ','. $issued_to['email_add']);
		$issued_by_array	= return_emp_info_by_username($issued_by);
		$from = $issued_by_array['email_add'];
		//include issued_to on to recipient
		$dcc_name = get_dcc_name($issued_by);
		
		$subject = 'List of Issued Documents'; 
		$body 	 = 'Good day!<br>';
		$body 	.= 'Please be informed that the following documents were issued by <b>'.$dcc_name.'</b>. <br><br>';
		$body 	.= '<table border=1>';
		$body 	.= '	<thead>';
		$body 	.= '	  <tr>';
		$body 	.= '		<th>Document Number</th>';
		$body 	.= '		<th>Document Title</th>';
		$body 	.= '		<th>Rev No.</th>';
		$body 	.= '		<th>Quantity</th>';
		$body 	.= '	  </tr>';
		$body 	.= '	</thead>';
		$body 	.= '	<tbody>';
		$body 	.= 		$issued_docs;
		$body 	.= '	</tbody>';
		$body 	.= '</table><br>';
		$body	.= 'Date Issued : <b>'.date('M d, Y',strtotime($date_issued)).'</b><br>';
		$body	.= 'Issued to Department - Section : <b>'.$issued_dept_section.'</b><br>';
		$body	.= 'Remarks : <b>'.$issued_remarks.'</b><br>';
		
		$php_mailer = new email();
		$msg = $php_mailer->send_email($to, $from, $from, $subject, $body,'');
		$return["msg_email"] = $msg;
		$return["script"] = $script;
		echo json_encode($return); 
	}
    /* MANAGE BATCH START */
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
		$array_values 	= array(strtoupper($return['emp_no']),strtolower($return['username'])); //values to be saved
		$result 		= OTKS::getInstance()->insert_query($table,$array_fields,$array_values);
        $return['msg'] 	  = $result;
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
		$result = OTKS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
		$return["result"] = json_encode($result); //return the the serialize values
		echo json_encode($return); //json encode since I used a dataType json before passing the serialized values here
	}
	
	/* MANAGE BATCH END */
?>