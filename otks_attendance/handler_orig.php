<?php
	if(is_ajax()) {
		if(isset($_POST["action"]) && !empty($_POST["action"])) {
			$action = $_POST["action"];
			switch($action) {
                case "get_employee_info_by_emp_no"      : get_employee_info_by_emp_no(); break;
                case "get_employee_recent_log_interval" : get_employee_recent_log_interval(); break;
                case "append_employee_attendance"       : append_employee_attendance(); break;
                case "load_log_record"                  : load_log_record(); break;
			}
		}
	}

	function is_ajax() {
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}
	
    function get_employee_info_by_emp_no() {
		require_once('oop.php'); //OOP Path
		$return = $_POST;
		$result = "";
		$array_fields = array('lastname','firstname','middlename','Section','Position');
		$table 	   	= 'db_hris.vw_EmpInfo_Rapid';
		$joins 	   	= '';
		$sql_where 	= 'WHERE EmpNo = "'.$return['emp_no'].'"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
        if($result->num_rows == 0) {
            $return['last_name'] 		= 'NOT FOUND';
            $return['first_name'] 		= '';
            $return['middle_name'] 		= '';
            $return['section'] 		    = '';
            $return['position'] 		= '';
        } else {
           while($row = mysqli_fetch_array($result)){
                $return['last_name'] 		= strtoupper($row['lastname']);
                $return['first_name'] 		= strtoupper($row['firstname']);
                $return['middle_name'] 		= strtoupper($row['middlename']);
                $return['section'] 		    = strtoupper($row['Section']);
                $return['position'] 		= strtoupper($row['Position']);
            } 
        } 
		/* Display system message */
        $bday_message = view_bday_message($return['emp_no']);
        $hrd_message = view_hrd_message($return['emp_no']);
        $leave_message = view_leave_message($return['emp_no']);
		$message = $bday_message . $hrd_message . $leave_message;
        $return['message'] = strtoupper($message);
		$return['result']  = json_encode($result);
		echo json_encode($return);
	}
	
    function get_employee_recent_log_interval(){
        /* Get employee recent log to prevent double log within 15 mins */
		require_once('oop.php'); //OOP Path
		$return 	= $_POST;
		$result 	= "";
		// $empno 		= 'J005';
        $empno 		 = $return['emp_no'];
        $time_now    = date('H:i:s');
        $log_checker = 'OFF'; 
		$array_fields = array('pkid','time AS log_time');
		$table 	   	 = 'tklogs';
		$joins 	   	 = '';
		$sql_where 	 = 'WHERE empno = "' . $empno . '" AND date = "' .date('Y-m-d') . '" AND logdel=0';
		$sql_order 	 = 'ORDER BY date DESC,time DESC';
		$sql_limit 	 = 'LIMIT 0,1'; // added by Nessa 06152024
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
        if($row = mysqli_fetch_array($result)){
            $log_time 		= $row['log_time'];
            $time_diff      = compute_difference($log_time, $time_now);
			if($time_diff['hour'] == 0) {
				if($time_diff['min'] <= 14 && $time_diff['sec'] <= 59) {
					$log_checker      = 'ON';
					$time            = $time_now;
				} else {
					$log_checker      = 'OFF';
					$time            = $time_now;
				}
			} else {
				$log_checker      = 'OFF';
				$time            = $time_now;
			}
        } else {
			$log_checker      = 'OFF';
            $time            = $time_now;
        }        
		$return['log_checker']    = $log_checker;
		$return['time_now']       = $time_now;
		echo json_encode($return);
	}
	// append_employee_attendance();
    function append_employee_attendance(){
        require_once('oop.php'); //OOP Path
		$return = $_POST;
		// $emp_no = 'M007';
		// $logged_mode = 'NORMAL';
		// $date_today = '2017-05-19';
		// $time_logged = '13:45:20';
		$emp_no       = $return['emp_no'];
        $logged_mode  = $return['mode'];
        $date_today   = date('Y-m-d');
		$time_logged  = $return['time_logged'];
        $current_mode = '';
        /* Check if employee filed OB or Undertime */
		$get_ob_ut_filed = array();
        $get_ob_ut_filed = check_ob_ut_filed($emp_no, $date_today);
		$ob_status = $get_ob_ut_filed['ob_filed'];
		
		
		$ob_ut_req_type = $get_ob_ut_filed['req_type'];
		
        if($ob_status == 'FOUND') {
			$checker = check_if_has_in($emp_no,$date_today);
			// echo 'pumasok '.check_if_has_in($emp_no,$date_today);
			if($checker == 'HAS') {
				if($ob_ut_req_type == 0) { //0- Undertime
					$current_mode = add_attendance_UT($emp_no,$date_today,$time_logged);
					// echo '0<br>';
				} else if($ob_ut_req_type == 1) { // 1-OB
					$ob_ut_time_out = strtotime($get_ob_ut_filed['ob_time_out']);
					$ob_ut_time_return = strtotime($get_ob_ut_filed['ob_time_return']);
					// echo '<br> $ob_ut_time_out '. $ob_ut_time_out .' $ob_ut_time_return '.$ob_ut_time_return.' $time_logged '.strtotime($time_logged).'<br>';
					if($ob_ut_time_return == '') {
						if($ob_ut_time_out > strtotime($time_logged)){
							$current_mode = 'OUT-EARLY';
							// echo '000<br>';
						} else {
							$current_mode = check_attendance_OB($emp_no,$date_today,$time_logged,'NO RETURN',$logged_mode);
							// echo '000<br>';
						}
					} else {
						
						/* if logged time is within filed OB, then save. Else, check the last log  */
						if($ob_ut_time_out > strtotime($time_logged)){
							// echo '1<br>';
							$current_mode = 'OUT-EARLY';
							// system will not save the transaction
						} else if((($ob_ut_time_out) < strtotime($time_logged)) && (strtotime($time_logged) < ($ob_ut_time_return))) {
							// echo '12<br>';
							$current_mode = check_attendance_OB($emp_no,$date_today,$time_logged,'WITH RETURN',$logged_mode); 
						} else if(strtotime($time_logged) > $ob_ut_time_return){
							// echo '13<br>';
							 // $current_mode = check_attendance_OB($emp_no,$date_today,$time_logged,'OUT',$logged_mode); 
							 $current_mode = check_attendance_OB($emp_no,$date_today,$time_logged,'WITH RETURN',$logged_mode); 
						} else {
							// echo '14<br>';
						}
					}                    
				} else {
					// echo '15<br>';
					$current_mode = "ERROR!";
				}
			} else {
				// $current_mode = verify_employee_attendance($date_today,$emp_no,$date_today,$time_logged,$logged_mode);
				$current_mode = verify_employee_attendance($date_today,$emp_no,$time_logged,$logged_mode); // Updated by Nessa 06152024 removed dup. $date_today
			}
        } else {
			// echo '16<br>';
            // $current_mode = verify_employee_attendance($date_today,$emp_no,$date_today,$time_logged,$logged_mode);
            $current_mode = verify_employee_attendance($date_today,$emp_no,$time_logged,$logged_mode); // Updated by Nessa 06152024 removed dup. $date_today
        }
        $return['mode'] = $current_mode;
        $return['time_log'] = date('h:i:s A',strtotime($time_logged));
		echo json_encode($return);
	}
	
	function load_log_record() {
        require_once('oop.php'); //OOP Path
		$return = $_POST;
		$result = "";
		$array_fields = array("date", "time_in", "mode_in", "date_out", "time_out", "mode_out");
		$table 	   	= 'tkdataraw';
		$joins 	   	= '';
		// $sql_where 	= 'WHERE (date > DATE_SUB(NOW(), INTERVAL 3 DAY) OR date_out > DATE_SUB(NOW(), INTERVAL 3 DAY)) AND empno="'.$return['emp_no'].'" AND status=1';
		$sql_where 	= 'WHERE empno="'.$return['emp_no'].'" AND status=1'; // Updated by Nessa 06152024
		$sql_order 	= 'ORDER BY `date` DESC, `time_in` DESC, `date_out` DESC,`time_out` DESC';
		$sql_limit 	= 'LIMIT 0,1'; // Added by Nessa 06152024
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$ctr = 0;
		while($row = mysqli_fetch_array($result)){
            if($row['date'] == '') {
                $date_in = '';
            } else {
                $date_in = date('M d, Y',strtotime($row['date']));
            }
            if($row['time_in'] == '') {
                $time_in = '';
            } else {
				 if(strpos($row['time_in'],':') !== false) {
					$time_in = date('h:i:s A',strtotime($row['time_in']));
				 } else {
					$time_in = $row['time_in'];
				 }
            }
            if($row['date_out'] == '') {
                $date_out = '';
            } else {
                $date_out = date('M d, Y',strtotime($row['date_out']));
            }
            if($row['time_out'] == '') {
                $time_out = '';
            } else {
                $time_out = date('h:i:s A',strtotime($row['time_out']));
            }
			$return['date_in'][$ctr]    = $date_in;
			$return['time_in'][$ctr] 	= $time_in;
			$return['mode_in'][$ctr] 	= $row['mode_in'];
			$return['date_out'][$ctr] 	= $date_out;
			$return['time_out'][$ctr] 	= $time_out;
			$return['mode_out'][$ctr] 	= $row['mode_out'];
			$ctr++;
		}
		$return['ctr']	  = $ctr;
		echo json_encode($return);
    }

    function check_ob_ut_filed($empno, $date) {
        require_once('oop.php'); //OOP Path
		$return = array();
		$result = "";
		$array_fields = array('ob_time_out','ob_time_return','ob_purpose as req_type');
		$table 	   	= 'tkob';
		$joins 	   	= '';
		$sql_where 	= "WHERE tkob.empno = '" . $empno . "' AND tkob.ob_date = '" . $date . "' AND tkob.ob_status = 1";
		$sql_order 	= 'ORDER BY ob_time_out DESC LIMIT 0,1';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
        if($row = mysqli_fetch_array($result)){            
            $return['ob_time_out']      = $row['ob_time_out'];
            $return['ob_time_return']   = $row['ob_time_return'];
            $return['req_type']         = $row['req_type'];
            $return['ob_filed']         = 'FOUND';
        } else {
            $return['ob_time_out']      = '';
            $return['ob_time_return']   = '';
            $return['req_type']       = '';
            $return['ob_filed']         = 'NOT FOUND';
        } 
        return $return;
    }
    
	function add_attendance_UT($emp_no,$date,$time) {
        require_once('oop.php'); //OOP Path
		$return = array();
		$result = "";
		/* Check if he has inconsistent record */		
		$array_fields_raw = array('pkid','date_out','time_out','mode_out');
		$table_raw 	   	= 'tkdataraw';
		$joins_raw 	   	= '';
		$sql_where_raw 	= "WHERE empno = '" . $emp_no . "' AND date = '" . $date . "' ORDER BY pkid DESC LIMIT 0,1";
		$sql_order_raw 	= '';
		$sql_limit_raw 	= '';
		$result_raw = OTKS::getInstance()->select_query($array_fields_raw,$table_raw,$joins_raw,$sql_where_raw,$sql_order_raw,$sql_limit_raw);
		$current_mode = '';
		
		$array_fields_slip = array('ob_time_out');
		$table_slip 	   	= 'tkob';
		$sql_where_slip 	= "WHERE empno = '" . $emp_no . "' AND ob_date = '" . $date . "' AND ob_status=1";
		$result_slip = OTKS::getInstance()->select_query($array_fields_slip,$table_slip,$joins_raw,$sql_where_slip,$sql_order_raw,$sql_limit_raw);
		if($row_slip = mysqli_fetch_array($result_slip)){
			$time_out_slip = $row_slip['ob_time_out'];
		}
		// echo 'time logged ['.($time) .'] time out Slip ['. ($time_out_slip).']<br>';
		if($result_raw->num_rows != 0) {
			/* Query if employee has a record on the said date */
			if($row_raw = mysqli_fetch_array($result_raw)){ 
				if(strtotime($time) < strtotime($time_out_slip)) {
					/* Query for early time out of UNDERTIME */
					update_attendance_data_n_raw($row_raw['pkid'],$date,$time,'OUT','otks');
					add_attendance_logs(0,$emp_no,$date,$time,'OUT','NORMAL');
					$current_mode = 'OUT-EARLY';
				} else {			
					if($row_raw['date_out'] == '' && $row_raw['time_out'] == '' && $row_raw['mode_out'] == '') {
						update_attendance_data_n_raw($row_raw['pkid'],$date,$time,'UNDERTIME','otks');
						add_attendance_logs($row_raw['pkid'],$emp_no,$date,$time,'UNDERTIME','NORMAL');
					} else {
						add_attendance_data_n_raw_out($emp_no,$date,$time,'UNDERTIME','otks','otks');
						add_attendance_logs($row_raw['pkid'],$emp_no,$date,$time,'UNDERTIME','NORMAL');
					}
					$current_mode = 'UNDERTIME';
				}
			}
		} else {
			/* Query if employee forgot to time in on the said date */
			if(strtotime($time) < strtotime($time_out_slip)) {			
				/* Query for early time out of UNDERTIME */
				add_attendance_data_n_raw_out($emp_no,$date,$time,'OUT','otks','otks');
				add_attendance_logs(0,$emp_no,$date,$time,'OUT','NORMAL');
				$current_mode = 'OUT-EARLY';		
			} else {
				add_attendance_data_n_raw_out($emp_no,$date,$time,'UNDERTIME','otks','otks');
				add_attendance_logs(0,$emp_no,$date,$time,'UNDERTIME','NORMAL');
				$current_mode = 'UNDERTIME';
			}
		}		
		return $current_mode;
    }
	
	function check_if_has_in($emp_no,$date) {
		require_once('oop.php'); //OOP Path
		$checker = 'NONE';
		$return = array();
		$result = "";
		/* Check if he has inconsistent record */		
		$array_fields_raw = array('pkid');
		$table_raw 	   	= 'tkdataraw';
		$joins_raw 	   	= '';
		$sql_where_raw 	= "WHERE empno = '" . $emp_no . "' AND date = '" . $date . "' AND status=1 ORDER BY pkid DESC";
		$sql_order_raw 	= '';
		$sql_limit_raw 	= 'LIMIT 0,1'; // Updated by Nessa 06152024
		$result_raw = OTKS::getInstance()->select_query($array_fields_raw,$table_raw,$joins_raw,$sql_where_raw,$sql_order_raw,$sql_limit_raw);
		if($result_raw->num_rows != 0) {
			$checker = 'HAS';
		}
		return $checker;
	}
	
	// echo check_attendance_OB('J005','2016-08-10','13:42','WITH RETURN');
	function check_attendance_OB($emp_no,$date,$time,$ob_type,$logged_mode) {
        require_once('oop.php'); //OOP Path
		$current_mode = '';
		$return = array();
		$result = "";
		/* Check if he has inconsistent record */		
		$array_fields_raw = array('pkid','date_out','time_out','mode_out');
		$table_raw 	   	= 'tkdataraw';
		$joins_raw 	   	= '';
		$sql_where_raw 	= "WHERE empno = '" . $emp_no . "' AND date = '" . $date . "' ORDER BY pkid DESC LIMIT 0,1";
		$sql_order_raw 	= '';
		$sql_limit_raw 	= '';
		$result_raw = OTKS::getInstance()->select_query($array_fields_raw,$table_raw,$joins_raw,$sql_where_raw,$sql_order_raw,$sql_limit_raw);
		if($result_raw->num_rows != 0) {
			if($row_raw = mysqli_fetch_array($result_raw)){ 
				if($ob_type == 'NO RETURN' || $ob_type == 'WITH RETURN' || $ob_type == 'RETURN') {
					$current_mode = add_attendance_OB($row_raw['pkid'],$emp_no,$date,$time);
				} else if($ob_type == 'EARLY') {
					if($row_raw['date_out'] == '' && $row_raw['time_out'] == '' && $row_raw['mode_out'] == '') {
						update_attendance_data_n_raw($row_raw['pkid'],$date,$time,'OUT','otks');
						add_attendance_logs($row_raw['pkid'],$emp_no,$date,$time,'OUT','NORMAL');
						$current_mode = 'OUT-EARLY';
					} else {
						add_attendance_data_n_raw_out($emp_no,$date,$time,'OUT','otks','otks');
						add_attendance_logs(0,$emp_no,$date,$time,'OUT','NORMAL');
						$current_mode = 'OUT-EARLY';		
					}
				} else if($ob_type == 'OUT') {
					update_attendance_data_n_raw($row_raw['pkid'],$date,$time,'OUT','otks');
					add_attendance_logs($row_raw['pkid'],$emp_no,$date,$time,'OUT','NORMAL');
					$current_mode = 'OUT';
				} else {
					$current_mode = 'ERROR!';	
				}
			}
		} else {
			$array_fields_raw2 = array('pkid');
			$sql_where_raw2 	= "WHERE empno = '" . $emp_no . "' AND date_out = '" . $date . "' ORDER BY pkid DESC LIMIT 0,1";
			$result_raw2 = OTKS::getInstance()->select_query($array_fields_raw2,$table_raw,$joins_raw,$sql_where_raw2,$sql_order_raw,$sql_limit_raw);
			if($result_raw2->num_rows == 0){ 
				// if($ob_type == 'EARLY') {
					// add_attendance_data_n_raw_out($emp_no,$date,$time,'OUT','otks','otks');
					// add_attendance_logs(0,$emp_no,$date,$time,'OUT','NORMAL');
					// $current_mode = 'OUT-EARLY';	
				// } else {
					// add_attendance_data_n_raw_out($emp_no,$date,$time,'OB','otks','otks');
					// add_attendance_logs(0,$emp_no,$date,$time,'OB','OB-OUT');
					// $current_mode = 'OB-OUT';
				// }
				$current_mode = verify_employee_attendance($date,$emp_no,$date,$time,$logged_mode);
			} else {
				add_attendance_data_n_raw($emp_no,$date,$time,'OB','otks','otks');
				add_attendance_logs(0,$emp_no,$date,$time,'OB','OB-IN');
				$current_mode = 'OB-IN';
			}
		}
		return $current_mode;
    }
	
	function add_attendance_OB($fkid,$emp_no,$date,$time) {
		require_once('oop.php'); //OOP Path
		$current_mode = '';
		$return = array();
		$result = "";
		$array_fields = array('modetype', 'mode');
		$table 	   	= 'tklogs';
		$joins 	   	= '';
		$sql_where 	= "WHERE fkid_tkdata='".$fkid."' AND logdel=0";
		$sql_order 	= ' ORDER by time desc, date desc LIMIT 0,1';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
        if($row = mysqli_fetch_array($result)){   
			$previous_mode = $row['mode'];
			$previous_mode_type = $row['modetype'];
			// echo '<br> prev mode: '.$previous_mode.'<br>';
            if($previous_mode == 'OUT' || $previous_mode_type == 'OB-OUT') {
                add_attendance_data_n_raw($emp_no,$date,$time,'OB','otks','otks');
                add_attendance_logs(0,$emp_no,$date,$time,'OB','OB-IN');
                $current_mode = 'OB-IN';
            } else if($previous_mode_type == 'OB-IN') {
                update_attendance_data_n_raw($fkid,$date,$time,'OUT','otks');
                add_attendance_logs($fkid,$emp_no,$date,$time,'OUT','NORMAL');
                $current_mode = 'OUT';
            } else {
                update_attendance_data_n_raw($fkid,$date,$time,'OB','otks');
                add_attendance_logs($fkid,$emp_no,$date,$time,'OB','OB-OUT');
				$current_mode = 'OB-OUT';
            }
        } else {
            add_attendance_data_n_raw($emp_no,$date,$time,'OB','otks','otks');
            add_attendance_logs(0,$emp_no,$date,$time,'OB','OB-IN');
            $current_mode = 'OB-IN';
        } 
        return $current_mode;
	}
    
    function add_attendance_data_n_raw($emp_no,$date_in,$time_in,$mode_in,$approver,$username) {
        require_once('oop.php'); //OOP Path
		$return 		= $_POST; 
		$result 		= "";
        $last_update    = date('Y-m-d H:i:s');
		$table_data   	= "tkdata"; //table name
		$table_data_raw = "tkdataraw"; //table name
		$array_fields 	= array("lastupdate","empno","date","time_in","mode_in","status","approver","username"); //table fields
		$array_values 	= array($last_update,$emp_no,$date_in,$time_in,$mode_in,'1',$approver,$username); //values to be saved
		$result_data 		= OTKS::getInstance()->insert_query($table_data,$array_fields,$array_values);
		$result_data_raw	= OTKS::getInstance()->insert_query($table_data_raw,$array_fields,$array_values);
    }
    
    function add_attendance_data_n_raw_out($emp_no,$date_out,$time_out,$mode_out,$approver,$username) {
        require_once('oop.php'); //OOP Path
		$return 		= $_POST; 
		$result 		= "";
        $last_update    = date('Y-m-d H:i:s');
		$table_data   	= "tkdata"; //table name
		$table_data_raw = "tkdataraw"; //table name
		$array_fields 	= array("lastupdate","empno","date_out","time_out","mode_out","status","approver","username"); //table fields
		$array_values 	= array($last_update,$emp_no,$date_out,$time_out,$mode_out,'1',$approver,$username); //values to be saved
		$result_data 		= OTKS::getInstance()->insert_query($table_data,$array_fields,$array_values);
		$result_data_raw	= OTKS::getInstance()->insert_query($table_data_raw,$array_fields,$array_values);
    }

    function add_attendance_logs($fkid,$emp_no,$date,$time,$mode,$mode_type) {
        require_once('oop.php'); //OOP Path
		$result 				= "";
		$array_fields_select 	= array('pkid');
        $table_raw 	   			= 'tkdataraw';
        $joins 	   				= '';
		/* Get the pkid of tkdata raw then insert on tklogs */
		if($fkid == 0) {
			if($mode == 'IN') {
				$sql_where 	= "WHERE empno='".$emp_no."' AND date= '".$date."' AND time_in= '".$time."'";
			} else if($mode == 'OUT' || $mode == 'UNDERTIME') {
				$sql_where 	= "WHERE empno='".$emp_no."' AND date_out= '".$date."' AND time_out= '".$time."'";
			} else if($mode == 'OB') {
				if($mode_type == 'OB-IN') {
					$sql_where 	= "WHERE empno='".$emp_no."' AND date= '".$date."' AND time_in= '".$time."'";
				} else if($mode_type == 'OB-OUT') {
					$sql_where 	= "WHERE empno='".$emp_no."' AND date_out= '".$date."' AND time_out= '".$time."'";
				}
			}        
			$sql_order 	= '';
			$sql_limit 	= '';
			$result_raw = OTKS::getInstance()->select_query($array_fields_select,$table_raw,$joins,$sql_where,$sql_order,$sql_limit);
			$validate = false;
			if($row = mysqli_fetch_array($result_raw)){
				$fkid = $row['pkid'];
			} else {
				$fkid = 0;
			}

		}
		
        $last_update    = date('Y-m-d H:i:s');
		$table   	    = "tklogs"; //table name
		$array_fields 	= array("lastupdate", "fkid_tkdata", "empno", "date", "time", "mode", "modetype"); //table fields
		$array_values 	= array($last_update,$fkid,$emp_no,$date,$time,$mode,$mode_type); //values to be saved
		$result 		= OTKS::getInstance()->insert_query($table,$array_fields,$array_values);
    }

    function update_attendance_data_n_raw($pkid,$date_out,$time_out,$mode_out,$username) {
        require_once('oop.php'); //OOP Path
        $last_update = date('Y-m-d H:i:s');
		$return = $_POST; 
		$result = "";
		$table_data   	= "tkdata"; 
		$table_data_raw = "tkdataraw";
		$array_fields = array("date_out","time_out","mode_out","lastupdate","username");
		$array_values = array($date_out,$time_out,$mode_out,$last_update,$username);
        $where = "WHERE pkid='".$pkid."' AND status=1";
		$result_data = OTKS::getInstance()->update_query_detailed($table_data,$array_fields,$array_values,$where);
		$result_data_raw = OTKS::getInstance()->update_query_detailed($table_data_raw,$array_fields,$array_values,$where);
    }
    // echo verify_employee_attendance('2016-10-21','I002','2016-10-21','0730:40:00','NORMAL') ;
    function verify_employee_attendance($date_today,$emp_no,$time_logged,$logged_mode) {
		$previous_mode 				= '';
		$previous_modetype 			= '';
		$previous_logged 			= '';
		$current_mode 				= '';
		$previous_logged_date 		= '';
        $actual_logged      		= $date_today.' '.$time_logged;
        $time 						= array();
        /* Check the last transaction of employee, if last mode is out then the next is IN. If the last mode is IN check if the current mode is undertime (out next), ob(check if ob in or out), late (add in), normal (add in) */
		/* if time diff is greater than 20hours, check if has straight hour request. Else proceed to next transaction */
		require_once('oop.php'); //OOP Path
		$return = $_POST;
        $result = "";
		$array_fields = array('date','time','mode','modetype');
        $table 	   	= 'tklogs';
        $joins 	   	= '';
        $sql_where 	= "WHERE empno = '" .$emp_no. "' AND logdel=0";
        $sql_order 	= 'ORDER BY date DESC, time DESC ';
        $sql_limit 	= 'LIMIT 0,1'; // Updated by Nessa 06152024
        $result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
        if($row = mysqli_fetch_array($result)){	
			$previous_mode 			= $row['mode'];
			$previous_modetype 		= $row['modetype'];
            $previous_logged   		= $row['date'].' '.$row['time'];
            $previous_logged_date 	= $row['date'];
			if($previous_mode != 'OUT') { //in, ob and undertime
                if($previous_modetype == 'UNDERTIME') {
                    if($logged_mode == 'BUS LATE') {
                        $current_mode = check_late($emp_no,$date_today,$time_logged,'BUS LATE');
                    } else if($logged_mode == 'NORMAL') {
                        $current_mode = check_late($emp_no,$date_today,$time_logged,'LATE');
                    } else {
                        $current_mode = 'ERROR';
                    }       
                } else {
					/* Check for the time diff of attendance. 20hours interval is considered straight */
					$str_time_logged = strtotime($previous_logged);
					if(date('A', $str_time_logged) == 'AM') {
						$str_reg_time_in = ($previous_logged_date.' 07:30:00');
					} else {
						$str_reg_time_in = ($previous_logged_date.' 19:30:00');
					}
					// echo $str_reg_time_in;
					$time_diff = compute_difference($str_reg_time_in, $actual_logged);
					$emp_time = get_employee_time_in_out($emp_no,$date_today);
					// echo 'time_diff '.$time_diff['hour'].':'.$time_diff['min'].':'.$time_diff['sec'].'<br>';
					if($time_diff['hour'] < 20) {
						if($emp_time['time_out'] == 'BLANK' || $emp_time['time_out'] == '' || $emp_time['time_out'] == NULL) {
                            if($emp_time['pkid'] != 0) {                            
                                /* add time out record */
                                update_attendance_data_n_raw($emp_time['pkid'],$date_today,$time_logged,'OUT','otks');
								add_attendance_logs($emp_time['pkid'],$emp_no,$date_today,$time_logged,'OUT','NORMAL');
                                $current_mode = 'OUT';
                            } else {
                                if($logged_mode == 'BUS LATE') {
                                    $current_mode = check_late($emp_no,$date_today,$time_logged,'BUS LATE');
                                } else if($logged_mode == 'NORMAL') {
                                    $current_mode = check_late($emp_no,$date_today,$time_logged,'LATE');
                                } else {
                                    $current_mode = 'ERROR';
                                }
                            }
                        } else {
                            if($logged_mode == 'BUS LATE') {
                                $current_mode = check_late($emp_no,$date_today,$time_logged,'BUS LATE');
                            } else if($logged_mode == 'NORMAL') {
                                $current_mode = check_late($emp_no,$date_today,$time_logged,'LATE');
                            } else {
                                $current_mode = 'ERROR';
                            }
                        }
					} else {
						/* Check if has Straight Request */
                        $has_straight_hour_filed = validate_filled_straight_hours($emp_no,$previous_logged_date);
						// echo '<hr><br>Has Straight: ['.$has_straight_hour_filed.'] <br>';
                        if($has_straight_hour_filed != 0) {
							update_attendance_data_n_raw($emp_time['pkid'],$date_today,$time_logged,'OUT','otks');
							add_attendance_logs($emp_time['pkid'],$emp_no,$date_today,$time_logged,'OUT','NORMAL');
                            $current_mode = 'OUT';
                        } else {    
                            if($logged_mode == 'BUS LATE') {
                                $current_mode = check_late($emp_no,$date_today,$time_logged,'BUS LATE');
                            } else if($logged_mode == 'NORMAL') {
                                $current_mode = check_late($emp_no,$date_today,$time_logged,'LATE');
                            } else {
                                $current_mode = 'ERROR';
                            }
                        }
					}    
				}
			} else {
				if($logged_mode == 'BUS LATE') {
					$current_mode = check_late($emp_no,$date_today,$time_logged,'BUS LATE');
				} else if($logged_mode == 'NORMAL') {
					$current_mode = check_late($emp_no,$date_today,$time_logged,'LATE');
				} else {
					$current_mode = 'ERROR';
				}   
			}
		} else {
			if($logged_mode == 'BUS LATE') {
				$current_mode = check_late($emp_no,$date_today,$time_logged,'BUS LATE');
			} else if($logged_mode == 'NORMAL') {
				$current_mode = check_late($emp_no,$date_today,$time_logged,'LATE');
			} else {
				$current_mode = 'ERROR'.$logged_mode.']';
			} 
		}    
		return $current_mode;
    }
	
	function validate_filled_straight_hours($empno,$date_in){
        $validate = 0;
		/* check if employee file straight request - pending and approved request is accepted. */
        require_once('oop.php'); //OOP Path
        $return = $_POST;
        $result = "";
        $array_fields = array('td.pkid');
        $table 	   	= 'tkstraight_details td';
        $joins 	   	= 'INNER JOIN tkstraight_main tm ON td.fkstraight_main = tm.pkid';
        // $sql_where 	= "WHERE td.empno='".$empno."' AND td.date_from= '".$date_in."' AND tm.status = '2'";
        $sql_where 	= "WHERE td.empno='".$empno."' AND td.date_from= '".$date_in."' AND (tm.status BETWEEN 0 AND 2)";
        $sql_order 	= '';
        $sql_limit 	= '';
        $result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
        if($result->num_rows != 0) {
            $validate = 1;
        } else {
			$validate = 0;
		}		
        return $validate;
    }
	
	function check_late($emp_no,$date_today,$time_logged,$late_type) {
        /* Late on employees with day-off is not same with no day-off. Late in Half day is also different */
        /* First, check the day-off type, then verify if the employee is late */
        $str_time_logged = strtotime($time_logged);
        $str_actual_time_in = strtotime($date_today.' '.$time_logged);
        if(date('A', $str_time_logged) == 'AM') {
            $str_reg_time_in = strtotime($date_today.' 07:30:00');
        } else {
            $str_reg_time_in = strtotime($date_today.' 19:30:00');
        }
        if($late_type == 'LATE') {
            $mode = 'IN';
        } else {
            $mode = 'BUS LATE';
        }
		/* Condition for late employees */
		$dayoff_type = check_day_off_type($emp_no);
        if( ($str_actual_time_in >  $str_reg_time_in) ){
           $time_diff = round( ($str_actual_time_in - $str_reg_time_in) / 60);
			if($dayoff_type == 1){
                /* with day off late is within 240 minutes or 4 hours */
                if($time_diff < 240){
                    add_attendance_data_n_raw($emp_no,$date_today,$time_logged,$mode,'otks','otks');
					add_attendance_logs(0,$emp_no,$date_today,$time_logged,'IN',$late_type);
                    $current_mode = $late_type;
                } else {
                    add_attendance_data_n_raw($emp_no,$date_today,$time_logged,$mode,'otks','otks');
					add_attendance_logs(0,$emp_no,$date_today,$time_logged,'IN','NORMAL');
                    $current_mode = 'IN';
                }
            } else{
                /* with day off late is within 180 minutes hours */
                if($time_diff < 180){
                    add_attendance_data_n_raw($emp_no,$date_today,$time_logged,$mode,'otks','otks');
					add_attendance_logs(0,$emp_no,$date_today,$time_logged,'IN',$late_type);
                    $current_mode = $late_type;
                } else {
                    add_attendance_data_n_raw($emp_no,$date_today,$time_logged,'IN','otks','otks');
					add_attendance_logs(0,$emp_no,$date_today,$time_logged,'IN','NORMAL');
                    $current_mode = 'IN';
                }
            }                            
        } else {
			/* Condition for punctual employees */
            add_attendance_data_n_raw($emp_no,$date_today,$time_logged,'IN','otks','otks');
			add_attendance_logs(0,$emp_no,$date_today,$time_logged,'IN','NORMAL');
            $current_mode = 'IN';
        }
        return $current_mode;
    }

	function get_employee_time_in_out($emp_no,$date) {
        require_once('oop.php'); //OOP Path
		$return = $_POST;
		$result = "";
		$array_fields = array('pkid','date','time_in','time_out');
		$table 	   	= 'tkdataraw';
		$joins 	   	= '';
		$sql_where 	= "WHERE empno = '" .$emp_no. "' AND date = '" . $date . "' AND status=1";
		$sql_order 	= 'ORDER BY date DESC,time_in DESC ';
		$sql_limit 	= 'LIMIT 0,1'; //Updated by Nessa 06152024
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$time = array();
        if($row = mysqli_fetch_array($result)){
			$time['pkid'] 		    = $row['pkid'];
			$time['date_in'] 		= $row['date'];
			$time['time_in'] 		= $row['time_in'];
			$time['time_out'] 		= $row['time_out'];
		} else {
            /* No record found on that day. Therefor, get the last transaction */
            $array_fields_old = array('pkid','date','time_in','time_out');
            $joins_old 	   	= '';
            $sql_where_old 	= "WHERE empno = '" .$emp_no. "' AND status=1";
            $sql_order_old 	= 'ORDER BY date DESC, time_in DESC ';
            $sql_limit_old 	= 'LIMIT 0,1'; //Updated by Nessa 06152024
            $result_old = OTKS::getInstance()->select_query($array_fields_old,$table,$joins_old,$sql_where_old,$sql_order_old,$sql_limit_old);
            if($row = mysqli_fetch_array($result_old)){
                $time['pkid'] 		    = $row['pkid'];
                $time['date_in'] 		= $row['date'];
                $time['time_in'] 		= $row['time_in'];
                $time['time_out'] 		= $row['time_out'];
            } else {
                $time['pkid'] 		    = '0';
                $time['time_in'] 		= '';
                $time['time_out'] 		= '';
            }
        }
        return $time;
    }

    function get_employee_recent_log($emp_no,$date) {
        require_once('oop.php');
		$return = $_POST;
		$result = "";
		$array_fields = array("mode","modetype");
		$table 	   	= 'tklogs';
		$joins 	   	= '';
		$sql_where 	= "WHERE empno = '" .$emp_no. "' AND date = '" . $date . "' AND logdel=0";
		$sql_order 	= 'ORDER BY date DESC';
		$sql_limit 	= 'LIMIT 0,1'; //Updated by Nessa 06152024
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$mode = array();
        if($row = mysqli_fetch_array($result)){
			$mode['mode'] 		    = $row['mode'];
			$mode['modetype'] 		= $row['modetype'];
		} else {
            $mode['mode'] 		    = '0';
            $mode['modetype'] 		= '';
        }
        return $mode;
    }

    function compute_difference($normal_date_time_out, $actual_date_time_out) {
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

    function check_day_off_type($emp_no) {
        require_once('oop.php'); 
		$return = $_POST;
		$result = "";
		$array_fields = array("dayoff_type");
		$table 	   	= 'tkday_off';
		$joins 	   	= '';
		$sql_where 	= "WHERE empno = '" .$emp_no. "' AND logdel=0";
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$mode = array();
        if($row = mysqli_fetch_array($result)){
			$dayoff_type 	= $row['dayoff_type'];
		} else {
            $dayoff_type 	= 0;
        }
        return $dayoff_type;
    }

    function view_bday_message($emp_no){
        require_once('oop.php'); 
        $return = $_POST;
        $message = '';
		$result = "";
		$array_fields = array('NickName');
		$table 	   	= 'db_hris.tbl_EmployeeInfo';
		$joins 	   	= '';
		$sql_where 	= "WHERE tbl_EmployeeInfo.EmpNo ='" . $emp_no . "' AND tbl_EmployeeInfo.DOBirth LIKE'%-" . date('m-d') . "%';";
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$ctr = 0;
		if($result->num_rows != 0) {
            $message = 'Happy Birthday!!! <br>';
        }
        return $message;
    }

    function view_hrd_message($emp_no){
        require_once('oop.php'); 
        $return = $_POST;
        $message = '';
		$result = "";
		$array_fields = array('message');
		$table 	   	= 'tkmessage';
		$joins 	   	= '';
		$sql_where 	= "WHERE empno='".$emp_no."' AND dateview='".date('Y-m-d')."' AND status=0";
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$ctr = 0;
		if($result->num_rows != 0) {
			$row = mysqli_fetch_array($result);
            $message =  $row['message'].' <br>';
        }
        return $message;
    }
	
	function view_leave_message($emp_no){
        require_once('oop.php'); 
        $return = $_POST;
        $message = '';
		$result = "";
		/* check first if employee has attendance, kapag wala pa ibig sabihin di pa dapat i-check ung pass request nya */
		$array_fields_checker = array('pkid');
		$table_checker 	   	= 'tkdataraw';
		$joins_checker 	   	= '';
		$sql_where_checker 	= "WHERE time_in != '' AND mode_in != '' AND date='".date('Y-m-d')."' and empno='".$emp_no."'";
		$sql_order_checker 	= '';
		$sql_limit_checker 	= '';
		$result_checker = OTKS::getInstance()->select_query($array_fields_checker,$table_checker,$joins_checker,$sql_where_checker,$sql_order_checker,$sql_limit_checker);
		if($result_checker->num_rows != 0) {
			$array_fields = array('ob_status','ob_purpose','ob_time_out','ob_time_return');
			$table 	   	= 'tkob';
			$joins 	   	= '';
			$sql_where 	= "WHERE empno='".$emp_no."' AND ob_date='".date('Y-m-d')."' AND logdel=0";
			$sql_order 	= '';
			$sql_limit 	= '';
			$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
			$time_now = date('H:i:s');
			if($result->num_rows != 0) {
				while($row = mysqli_fetch_array($result)) {
					if($row['ob_status'] == 0) {
						$message = 'FOR APPROVAL PASS REQUEST (system will not save the transaction) <br>';
					} else if($row['ob_status'] == 1) {
						if($row['ob_purpose'] == 0) { //undertime
							if(strtotime($time_now) < strtotime($row['ob_time_out'])) {
								$message = 'EARLY TIME OUT FOR UNDERTIME REQUEST (system will not save the transaction. Please wait for the set time-out on request) <br>';
							} else {
								$message = 'APPROVED PASS REQUEST - UNDERTIME <br>';
							}
						} else if($row['ob_purpose'] == 1) { //ob
							if(strtotime($time_now) < strtotime($row['ob_time_out'])) {
								$message = 'EARLY TIME OUT FOR OFFICIAL BUSINESS REQUEST (system will not save the transaction. Please wait for the set time-out on request) <br>';
							} else if((strtotime($time_now) >= strtotime($row['ob_time_out'])) && (strtotime($time_now) <= strtotime($row['ob_time_return']))) {
								$message = 'APPROVED PASS REQUEST - OFFICIAL BUSINESS <br>';
							} else if(strtotime($time_now) > strtotime($row['ob_time_return'])) {
								$message = 'LATE TIME RETURN <br>';
							} else {
								$message = 'ERROR! <br>';
							}
						} else {
							$message = 'ERROR! <br>';
						}
					} else if($row['ob_status'] == 2) {
						$message = 'DISAPPROVED PASS REQUEST <br>';
					} else if($row['ob_status'] == 3) {
						$message = 'CANCELLED PASS REQUEST <br>';
					} else if($row['ob_status'] == 4) {
						$message = 'DRAFT PASS REQUEST <br>';
					} else {
						$message = 'ERROR! <br>';
					}
				}
			} else {
				$message = '';
			}
		} else {
			$message = '';
		}
        return $message;
    }

/* DO NOT EDIT BELOW. FOR REFERENCE USED ONLY */
/* DO NOT EDIT BELOW. FOR REFERENCE USED ONLY */
/* DO NOT EDIT BELOW. FOR REFERENCE USED ONLY */
/* DO NOT EDIT BELOW. FOR REFERENCE USED ONLY */
/* DO NOT EDIT BELOW. FOR REFERENCE USED ONLY */
/* DO NOT EDIT BELOW. FOR REFERENCE USED ONLY */
/* DO NOT EDIT BELOW. FOR REFERENCE USED ONLY */


	/* function for displaying record */
	function load_records(){
		require_once('oop.php'); //OOP Path
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
		require_once('oop.php'); //OOP Path
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
		require_once('oop.php'); //OOP Path
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
		require_once('oop.php'); //OOP Path
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
		require_once('oop.php'); //OOP Path
		$return 	= $_POST; 
		$result 	= "";
		$table   	= "tbl_records";
		$pkid 		= $return['pkid'];
		$result 	= OT::getInstance()->delete_query($table,$pkid);
		$return["result"] = json_encode($result); //return the the serialize values
		echo json_encode($return); //json encode since I used a dataType json before passing the serialized values here
	}

	
?>