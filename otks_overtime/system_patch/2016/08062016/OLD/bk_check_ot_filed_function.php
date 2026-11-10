<?php

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
		/* test data start */
        // $date_ot = '2016-07-16';
        // $emp_no = '5221';
        // $emp_name = 'Meneses, Ana Liza';
        // $filed_ot = '40';
        // $req_remarks = 'test';
        // $pkid = '5604';
        // $overtime_type = '1';
		/* test data end */
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
        
		$array_fields_attendance = array("date","time_in","date_out","time_out","mode_out");
		$table_attendance 	   	= "tkdataraw";
		$joins_attendance 	   	= "";
		$sql_where_attendance 	= "WHERE empno='".$emp_no."' AND date='".$date_ot."'";
		$sql_order_attendance 	= 'ORDER BY time_out';
		$sql_limit_attendance 	= '';
		// echo OT::getInstance()->select_query_test($array_fields_attendance,$table_attendance,$joins_attendance,$sql_where_attendance,$sql_order_attendance,$sql_limit_attendance);
		$result_attendance = OT::getInstance()->select_query($array_fields_attendance,$table_attendance,$joins_attendance,$sql_where_attendance,$sql_order_attendance,$sql_limit_attendance);
		if($result_attendance->num_rows == 0) {      
			if($overtime_type == 1) {
				$ot = 0;
				$msg = 'No record found!';
				$date_time_in = 'N/A';
				$date_time_out = 'N/A';
			} else {
				/* 
					Special case for other type of overtime (except regular). Employee who render straight hour then the next day is holiday or Sunday 
					Example: Employee attend last May 7 (Saturday) 7:30 pm - May 8 (Sunday) 3:30 pm
					Regular OT: 3hours-with day off (May 8 - 4:30am - 7:30am) OR 4hours-no day off (May 8 - 3:30am - 7:30am)
					Sunday OT: will count start on 7:30 am onwards
				*/
				/* Check if employee has attendance (date out) on the said date */
				$array_fields_ot_special = array("time_out","mode_out");
				$table_ot_special 	   	= "tkdataraw";
				$joins_ot_special 	   	= "";
				$sql_where_ot_special 	= "WHERE empno='".$emp_no."' AND date_out='".$date_ot."'";
				$sql_order_ot_special 	= 'ORDER BY time_out';
				$sql_limit_ot_special 	= '';
				$result_ot_special 		= OT::getInstance()->select_query($array_fields_ot_special,$table_ot_special,$joins_ot_special,$sql_where_ot_special,$sql_order_ot_special,$sql_limit_ot_special);
				
				if($result_ot_special->num_rows == 0) {
					$ot = 0;
					$msg = 'No record found!';
					$date_time_in = 'N/A';
					$date_time_out = 'N/A';
				} else if($result_ot_special->num_rows == 1 || $result_ot_special->num_rows == 2) {
					if($row_special = mysqli_fetch_array($result_ot_special)){
						$time_out = $row_special['time_out'];
					}
					$time_in = '07:30:00';	/* default time in is 7:30am */
					$date_time_in = $date_ot . " ".$time_in;
					$date_time_out = $date_ot . " ".$time_out;
					// echo 'time in: ['.$date_time_in.'] and out is ['.$date_time_out.']';
					$ot_diff = compute_overtime($date_time_in, $date_time_out);
					if($ot_diff['hour'] == 0 && $ot_diff['min'] == 0) {
						$ot = 0;
						$msg = 'The employee has no overtime rendered.';
					} else if($filed_ot > (float)($ot_diff['hour'].'.'.$ot_diff['min'])) {
						if((float)($ot_diff['hour'].'.'.$ot_diff['min']) < 0) {
							$ot = round_off_overtime($ot_diff['hour'],$ot_diff['min']);
							$msg = 'Invalid overtime!';
						} else {
							$ot = round_off_overtime($ot_diff['hour'],$ot_diff['min']);
							$msg = 'The employee only have ' . $ot_diff['hour'] . ' hour(s) ' . $ot_diff['min'] . ' minute(s) rendered.';
						} 
					} else {
						$ot = $filed_ot;
						$msg = 'Ok!';
					}				
					$date_time_in = date('M d, Y h:i:s A',strtotime($date_time_in));
					$date_time_out = date('M d, Y h:i:s A',strtotime($date_time_out));
				} else {
					$ot = 0;
					$date_time_in = 'N/A';
					$date_time_out = 'N/A';
					$msg = 'Multiple time in / time out! System cannot validate the overtime due to multiple record found in the set overtime date. Please contact Finance Department for attendance or print the overtime using manual process.';
				}
			}
        } else if($result_attendance->num_rows == 1 || $result_attendance->num_rows == 2) {
			/* Condition for regular attendance */
            $time_in = "";
			$date_out = '';
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
						$date_out = $row_attendance['date_out'];
                        $date_time_out = $date_out . " ".$row_attendance['time_out'];
                        $date_time_out = date('M d, Y h:i:s A',strtotime($date_time_out));
                    }
                } 
            } else { 
				/* Special case for employee who rendered OB with OT */
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
						$ot_type_checker = 'OB';
                    } 
                } else {
                    $date_time_in = 'N/A';
                    $date_time_out = 'N/A';
                }                    
            }             
			/* Check the overtime type */
            if($overtime_type == 1) {
                /* Validation for Regular OT */
                if(($time_in > "08:41:00" && $time_in < "13:31:00")) { //morning shift
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
					if($ot_type_checker == 'OB' ) {
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
					} else {
						/* Compute the date diff from date and time in to date and time out to check if the employee rendered straight hours 
						   If time diff is greater than 20 hours meaning he/she rendered straight */
						$time_diff = compute_overtime(date('Y-m-d H:i:s',strtotime($date_time_in)), date('Y-m-d H:i:s',strtotime($date_time_out)));
						if($time_diff['hour'] >= 20) {	
							$normal_date_time_out = date('Y-m-d',strtotime($date_ot . "+1 days")) . " " . $normal_time_out;
							/* Get the overtime difference based on normal time out to his/her time out */
							$ot_diff = compute_overtime($normal_date_time_out, date('Y-m-d H:i:s',strtotime($date_time_out))); 
						} else {
							$normal_date_time_out = $date_out . " " . $normal_time_out;
							/* Get the overtime difference based on normal time out to his/her time out */
							$ot_diff = compute_overtime($normal_date_time_out, date('Y-m-d H:i:s',strtotime($date_time_out))); 
						}
						// echo 'valid ot is:'.$ot_diff['hour'].':'.$ot_diff['min'].'<br>';	
						$ot_round_off = round_off_overtime($ot_diff['hour'],$ot_diff['min']);
						if($ot_diff['hour'] < 0) {
							$ot = 0;
							$msg = 'The employee has no overtime rendered.';
						} else if($ot_diff['hour'] == 0 && $ot_diff['min'] == 0) {
							$ot = 0;
							$msg = 'The employee has no overtime rendered.';
						} else if($filed_ot == (float)($ot_round_off)) {
							$ot = $filed_ot;
							$msg = 'Ok!';
						} else if($filed_ot > (float)($ot_round_off)) {
							$ot = round_off_overtime($ot_diff['hour'],$ot_diff['min']);
							$msg = 'The employee only have ' . $ot_diff['hour'] . ' hour(s) ' . $ot_diff['min'] . ' minute(s) rendered.';
						} else {
							$ot = $filed_ot;
							$msg = 'Ok!';
						}
					}
                }
            } else { /* OT != 1 */
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
					$ot_diff = compute_overtime($date_time_in, $date_time_out);
					$ot = round_off_overtime($ot_diff['hour'],$ot_diff['min']);
					if($ot_diff['hour'] == 0 && $ot_diff['min'] == 0) {
						$ot = 0;
						$msg = 'The employee has no overtime rendered.';
					} else if($filed_ot == (float)($ot)) {
						$ot = $filed_ot;
						$msg = 'Ok!';
					} else if($filed_ot > (float)($ot)) {
                        if((float)($ot) < 0) {
                            $ot = round_off_overtime($ot_diff['hour'],$ot_diff['min']);
                            $msg = 'Invalid overtime!';
                        } else {
                            $ot = round_off_overtime($ot_diff['hour'],$ot_diff['min']);
                            $msg = 'The employee only have ' . $ot_diff['hour'] . ' hour(s) ' . $ot_diff['min'] . ' minute(s) rendered.';
                        }
                            $ot = round_off_overtime($ot_diff['hour'],$ot_diff['min']);
                            $msg = 'The employee only have ' . $ot_diff['hour'] . ' hour(s) ' . $ot_diff['min'] . ' minute(s) rendered.';
					} else {
						$ot = $filed_ot;
						$msg = 'Ok!';
					}
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
	
?>