<?php
	if(is_ajax()) {
		if(isset($_POST["action"]) && !empty($_POST["action"])) {
			$action = $_POST["action"];
			switch($action) {
                case "get_employee_info_by_emp_no"      : get_employee_info_by_emp_no(); break;
                case "get_employee_recent_log_interval" : get_employee_recent_log_interval(); break;
                case "append_employee_attendance"       : append_employee_attendance(); break;
                case "load_log_record"                  : load_log_record(); break;
                    
					
					
//				case "load_records" 					: load_records(); break;//switch case, in using ajax an action must be set in order to choose the specific function to use
//				case "selec_users" 		    			: selec_users(); break;
//				case "add_new_record" 					: add_new_record(); break; //switch case, in using ajax an action must be set in order to choose the specific function to use
//				case "update_fetch_record" 				: update_fetch_record(); break; //switch case, in using ajax an action must be set in order to choose the specific function to use
//				case "update_record" 					: update_record(); break; //switch case, in using ajax an action must be set in order to choose the specific function to use
//				case "delete_record" 					: delete_record(); break; //switch case, in using ajax an action must be set in order to choose the specific function to use
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
        $message = view_bday_message($return['emp_no']);
        $return['message'] = strtoupper($message);
		$return['result']  = json_encode($result);
		echo json_encode($return);
	}

    function get_employee_recent_log_interval(){
        /* Get employee recent log to prevent double log within 15 mins */
		require_once('oop.php'); //OOP Path
		$return = $_POST;
		$result = "";
//        $empno = 'F014';
        $empno = $return['emp_no'];
        $time_now       = date('H:i:s');
		$array_fields = array('pkid','time AS log_time');
		$table 	   	= 'tklogs';
		$joins 	   	= '';
		$sql_where 	= 'WHERE empno = "' . $empno . '" AND date = "' .date('Y-m-d') . '"';
		$sql_order 	= 'ORDER BY date DESC,time DESC';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
        if($row = mysqli_fetch_array($result)){
            $log_time 		= $row['log_time'];
//            echo $row['pkid']."log_time: ".$log_time.' $time_now: '.$time_now;
            $time_diff      = compute_difference($log_time, $time_now);
            $return['hr_interval']      = $time_diff['hour'];
            $return['min_interval']     = $time_diff['min'];
            $return['sec_interval']     = $time_diff['sec'];
            $return['time']             = $time_now;
        } else {
            $return['hr_interval']      = 0;
            $return['min_interval']     = 0;
            $return['sec_interval']     = 0;
            $return['time']             = $time_now;
        }        
		echo json_encode($return);
	}

    function append_employee_attendance(){
        require_once('oop.php'); //OOP Path
		$return = $_POST;
//		$emp_no = 'J007';
//        $logged_mode = 'NORMAL';
//        $date_today = '2016-03-03';
//		$time_logged = '15:24:00';
		$emp_no       = $return['emp_no'];
        $logged_mode  = $return['mode'];
        $date_today   = date('Y-m-d');
		$time_logged  = $return['time_logged'];
        
        /* Check if employee filed OB or Undertime */
        $check_ob_ut_filed = check_ob_ut_filed($emp_no, $date_today);
        $ob_status = $check_ob_ut_filed['ob_filed'];
        if($ob_status == 'FOUND') {
            $ob_ut_req_type = $check_ob_ut_filed['req_type'];
            if($ob_ut_req_type == 0) { //0-undertime
                $current_mode = add_attendance_UT($emp_no,$date_today,$time_logged);
            } else { // 1-OB
                $ob_ut_time_out = strtotime($check_ob_ut_filed['ob_time_out']);
                $ob_ut_time_return = strtotime($check_ob_ut_filed['ob_time_return']);
                
                if($ob_ut_time_return == '') {
                    $current_mode = add_attendance_OB($emp_no,$date_today,$time_logged);
                } else {
                    /* if logged time is within filed OB, then save. Else, check the last log  */
                    if(($ob_ut_time_out < strtotime($time_logged)) && (strtotime($time_logged) < $ob_ut_time_return)) {
                        $current_mode = add_attendance_OB($emp_no,$date_today,$time_logged);
                    } else {
                        $current_mode = verify_employee_attendance($date_today,$emp_no,$date_today,$time_logged,$logged_mode);
                    }
                }                    
            }
        } else {
            $current_mode = verify_employee_attendance($date_today,$emp_no,$date_today,$time_logged,$logged_mode);
        }
        $return['mode'] = $current_mode;
        $return['time_log'] = date('h:i:s A',strtotime($time_logged));
		echo json_encode($return);
	}
//load_log_record();
    function load_log_record() {
        require_once('oop.php'); //OOP Path
		$return = $_POST;
		$result = "";
		$array_fields = array("date", "time_in", "mode_in", "date_out", "time_out", "mode_out");
		$table 	   	= 'tkdataraw';
		$joins 	   	= '';
//		$sql_where 	= 'WHERE (date > DATE_SUB(NOW(), INTERVAL 7 DAY)) AND empno="L005" AND status=1';
		$sql_where 	= 'WHERE (date > DATE_SUB(NOW(), INTERVAL 7 DAY)) AND empno="'.$return['emp_no'].'" AND status=1';
		$sql_order 	= 'ORDER BY pkid DESC';
		$sql_limit 	= '';
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
                $time_in = date('h:i:s A',strtotime($row['time_in']));
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
		$sql_order 	= '';
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
        $current_mode = '';
		$return = array();
		$result = "";
		$array_fields = array('mode');
		$table 	   	= 'tklogs';
		$joins 	   	= '';
		$sql_where 	= "WHERE empno = '" . $emp_no . "' AND date = '" . $date . "' ORDER by time desc, date desc;";
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
        if($row = mysqli_fetch_array($result)){            
            $previous_mode      = $row['mode'];
            if($previous_mode == 'OUT') {
                add_attendance_data_n_raw($emp_no,$date,$time,'IN','otks','otks');
                add_attendance_logs($emp_no,$date,$time,'IN','NORMAL');
                $current_mode = 'IN';
            } else {
                $emp_time = get_employee_time_in_out($emp_no,$date);
                if($emp_time['time_out'] == 'BLANK' || $emp_time['time_out'] == '' || $emp_time['time_out'] == NULL) {
                    //add time out record
                    update_attendance_data_n_raw($emp_no,$date,$time,$emp_time['date_in'],$emp_time['time_in'],'UNDERTIME','otks');
                    add_attendance_logs($emp_no,$date,$time,'UNDERTIME','NORMAL');
                    $current_mode = 'UNDERTIME';
                }
            }
        } else {
            add_attendance_data_n_raw($emp_no,$date,$time,'IN','otks','otks');
            add_attendance_logs($emp_no,$date,$time,'IN','NORMAL');
            $current_mode = 'IN';
        } 
        return $current_mode;
    }

    function add_attendance_OB($emp_no,$date,$time) {
        require_once('oop.php'); //OOP Path
        $current_mode = '';
		$return = array();
		$result = "";
		$array_fields = array('modetype');
		$table 	   	= 'tklogs';
		$joins 	   	= '';
		$sql_where 	= "WHERE empno = '" . $emp_no . "' AND date = '" . $date . "'";
		$sql_order 	= ' ORDER by time desc, date desc;';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
        if($row = mysqli_fetch_array($result)){   
            $previous_mode      = $row['modetype'];
            if($previous_mode == 'OUT' || $previous_mode == 'OB-OUT') {
                add_attendance_data_n_raw($emp_no,$date,$time,'OB','otks','otks');
                add_attendance_logs($emp_no,$date,$time,'OB','OB-IN');
                $current_mode = 'OB-IN';
            } else {
                $emp_time = get_employee_time_in_out($emp_no,$date);
                if($emp_time['time_out'] == 'BLANK' || $emp_time['time_out'] == '' || $emp_time['time_out'] == NULL) {
                    //add time out record
                    update_attendance_data_n_raw($emp_no,$date,$time,$emp_time['date_in'],$emp_time['time_in'],'OB','otks');
                    add_attendance_logs($emp_no,$date,$time,'OB','OB-OUT');
                    $current_mode = 'OB-OUT';
                }
            }
        } else {
            add_attendance_data_n_raw($emp_no,$date,$time,'OB','otks','otks');
            add_attendance_logs($emp_no,$date,$time,'OB','OB-IN');
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

    function add_attendance_logs($emp_no,$date,$time,$mode,$mode_type) {
        require_once('oop.php'); //OOP Path
		$return 		= $_POST; 
		$result 		= "";
        $last_update    = date('Y-m-d H:i:s');
		$table   	    = "tklogs"; //table name
		$array_fields 	= array("lastupdate", "empno", "date", "time", "mode", "modetype"); //table fields
		$array_values 	= array($last_update,$emp_no,$date,$time,$mode,$mode_type); //values to be saved
		$result 		= OTKS::getInstance()->insert_query($table,$array_fields,$array_values);
    }

    function update_attendance_data_n_raw($emp_no,$date,$time_out,$date_in,$time_in,$mode,$username) {
        require_once('oop.php'); //OOP Path
        $last_update = date('Y-m-d H:i:s');
		$return = $_POST; 
		$result = "";
		$table_data   	= "tkdata"; 
		$table_data_raw = "tkdataraw";
		$array_fields = array("date_out","time_out","mode_out","lastupdate","username");
		$array_values = array($date,$time_out,$mode,$last_update,$username);
        $where = "WHERE time_in = '" . $time_in . "' AND date = '" . $date_in . "' AND empno = '" . $emp_no . "' AND status=1 ORDER by time_in desc, date desc";
		$result_data = OTKS::getInstance()->update_query_detailed($table_data,$array_fields,$array_values,$where);
		$result_data_raw = OTKS::getInstance()->update_query_detailed($table_data_raw,$array_fields,$array_values,$where);
    }
//    echo verify_employee_attendance('2016-03-03','K003','2016-03-03','15:41:00','NORMAL') ;
    function verify_employee_attendance($date_today,$emp_no,$date_today,$time_logged,$logged_mode) {
        /* Check kung may naka-file na straight */
        
        // below are the code for no straight hour filed
        require_once('oop.php'); //OOP Path
		$return = $_POST;
        $result = "";
        $previous_mode = '';    // recent mode get from database
        $current_mode = '';     // current mode inserted into database
        $array_fields = array('mode','modetype');
        $table 	   	= 'tklogs';
        $joins 	   	= '';
        $sql_where 	= "WHERE empno = '" .$emp_no. "' AND logdel=0";
        $sql_order 	= 'ORDER BY date DESC';
        $sql_limit 	= '';
        $result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
        $time = array();
        if($row = mysqli_fetch_array($result)){
            $previous_mode      = $row['mode'];
            $previous_mode_type = $row['modetype'];
//            echo $previous_mode.'[]'.$previous_mode_type.'<br>';
            if($previous_mode != 'OUT') {
                if($previous_mode_type == 'UNDERTIME') {
                    if($logged_mode == 'BUS LATE') {
                        $current_mode = check_late($emp_no,$date_today,$time_logged,'BUS LATE');
                    } else if($logged_mode == 'NORMAL') {
                        $current_mode = check_late($emp_no,$date_today,$time_logged,'LATE');
                    } else {
                        $current_mode = 'ERROR';
                    }              
                } else {
                    $emp_time = get_employee_time_in_out($emp_no,$date_today);
//                    echo '<br>'.$emp_time['pkid'].']['.$emp_time['time_in'].']['.$emp_time['time_out'].']<br>';
                    if($emp_time['time_out'] == 'BLANK' || $emp_time['time_out'] == '' || $emp_time['time_out'] == NULL) {
                        if($emp_time['pkid'] != 0) {                            
                            //add time out record
                            update_attendance_data_n_raw($emp_no,$date_today,$time_logged,$emp_time['date_in'],$emp_time['time_in'],'OUT','otks');
                            add_attendance_logs($emp_no,$date_today,$time_logged,'OUT','NORMAL');
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
                    $current_mode = 'ERROR';
                }
        }
        return $current_mode;
    }

    function check_late($emp_no,$date_today,$time_logged,$late_type) {
        /* Late on employees with day-off is not same with no day-off. Late in Half day is also different */
        /* First, check the day-off type, then verify if the employee is late */
        $str_time_logged = strtotime($time_logged);
        $str_actual_time_in = strtotime($date_today.' '.$time_logged);
        $day_off_type = check_day_off_type($emp_no);
        if(date('A', $str_time_logged) == 'AM') {
            $str_reg_time_in = strtotime($date_today.' 07:30:00');
        } else {
            $str_reg_time_in = strtotime($date_today.' 19:30:00');
        }
//        echo '['.$str_actual_time_in .'<br>'.  $str_reg_time_in.']<br>';
        if($late_type == 'LATE') {
            $mode = 'IN';
        } else {
            $mode = 'BUS LATE';
        }
        if( ($str_actual_time_in >  $str_reg_time_in) ){
           $time_diff = round( ($str_actual_time_in - $str_reg_time_in) / 60);
            if($dayoff_type == 1){
                /* with day off late is within 240 minutes or 4 hours */
                if($time_diff < 240){
                    add_attendance_data_n_raw($emp_no,$date_today,$time_logged,$mode,'otks','otks');
                    add_attendance_logs($emp_no,$date_today,$time_logged,'IN',$late_type);
                    $current_mode = $late_type;
                } else {
                    add_attendance_data_n_raw($emp_no,$date_today,$time_logged,$mode,'otks','otks');
                    add_attendance_logs($emp_no,$date_today,$time_logged,'IN','NORMAL');
                    $current_mode = 'IN';
                }
            } else{
                /* with day off late is within 180 minutes hours */
                if($time_diff < 180){
                    add_attendance_data_n_raw($emp_no,$date_today,$time_logged,$mode,'otks','otks');
                    add_attendance_logs($emp_no,$date_today,$time_logged,'IN',$late_type);
                    $current_mode = $late_type;
                } else {
                    add_attendance_data_n_raw($emp_no,$date_today,$time_logged,'IN','otks','otks');
                    add_attendance_logs($emp_no,$date_today,$time_logged,'IN','NORMAL');
                    $current_mode = 'IN';
                }
            }                            
        } else {
            add_attendance_data_n_raw($emp_no,$date_today,$time_logged,'IN','otks','otks');
            add_attendance_logs($emp_no,$date_today,$time_logged,'IN','NORMAL');
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
		$sql_order 	= 'ORDER BY time_in DESC, date DESC';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$time = array();
        if($row = mysqli_fetch_array($result)){
			$time['pkid'] 		    = $row['pkid'];
			$time['date_in'] 		= $row['date'];
			$time['time_in'] 		= $row['time_in'];
			$time['time_out'] 		= $row['time_out'];
		} else {
//            $time['pkid'] 		    = '0';
//            $time['time_in'] 		= '';
//			$time['time_out'] 		= '';
            // No record found on that day. Therefor, get the last transaction
            $array_fields_old = array('pkid','date','time_in','time_out');
            $joins_old 	   	= '';
            $sql_where_old 	= "WHERE empno = '" .$emp_no. "' AND status=1";
            $sql_order_old 	= 'ORDER BY date DESC, time_in DESC';
            $sql_limit_old 	= '';
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
        require_once('oop.php'); //OOP Path
		$return = $_POST;
		$result = "";
		$array_fields = array("mode","modetype");
		$table 	   	= 'tklogs';
		$joins 	   	= '';
		$sql_where 	= "WHERE empno = '" .$emp_no. "' AND date = '" . $date . "'";
		$sql_order 	= 'ORDER BY date DESC';
		$sql_limit 	= '';
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
        require_once('oop.php'); //OOP Path
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
        require_once('oop.php'); //OOP Path
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
            $message = 'Happy Birthday!!!';
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