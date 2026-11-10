<?php
	if(is_ajax()) {
		if(isset($_POST["action"]) && !empty($_POST["action"])) {
			$action = $_POST["action"];
			switch($action) {
                /* DAILY NOTIFICATION START */
                case "load_tardiness_notif"         		: load_tardiness_notif(); break; /* WRITE YOUR DAILY NOTIFICATION HERE */
                case "draw_reminder_design"         		: draw_reminder_design(); break; /* DO NOT REMOVE / CHANGE */
                case "return_reminder_info"         		: return_reminder_info(); break; /* DO NOT REMOVE / CHANGE */
                /* DAILY NOTIFICATION END */
			}
		}
	}

	function is_ajax() {
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}
	
    /* WRITE YOUR DAILY NOTIFICATION HERE */
//    load_tardiness_notif();
    function load_tardiness_notif() {
        require_once('../class/oop.php'); //OOP Path
        $date_today           = date('Y-m-d');
        $time_today           = date('H:i');
//        $time_today           = '11:02';
//        $date_today           = '2017-02-01';
		$username 		= $_POST['username'];
		$mailer_link 	= $_POST['mailer_link']; 
		$result = "";
		$array_fields = array('created_by','late_morning_start', 'late_morning_end', 'late_night_start', 'late_night_end', 'notification_morning', 'notification_night', 'email_recipients');
		$table 	   	= 'tbl_tardiness_reminder';
		$joins 	   	= '';
		$sql_where 	= 'WHERE logdel=0';
		$sql_order 	= '';
		$sql_limit 	= '';
		$return_msg = '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = OTKS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
        if($result -> num_rows != 0) {
            while($row = mysqli_fetch_array($result)){
                $created_by           = $row['created_by'];
                $late_morning_start   = $row['late_morning_start'];
                $late_morning_end     = $row['late_morning_end'];
                $late_night_start     = $row['late_night_start'];
                $late_night_end       = $row['late_night_end'];
                $notification_morning = $row['notification_morning'];
                $notification_night   = $row['notification_night'];
                $email_recipients     = $row['email_recipients'];

                /* Check if there is schedule for notification */
                if($time_today == $notification_morning || $time_today == $notification_night) {
                   /* Get all the employees under Batch list */
                    $late_employees = return_emp_batch_list($date_today, $created_by, $late_morning_start, $late_morning_end, $late_night_start, $late_night_end);
                    $body_late = '';
//                    echo $created_by.count($late_employees['en']) . '<br>';
                    if( count($late_employees['en']) != 0 ) {
                        for($i=0;$i< count($late_employees['en']); $i++ ) {
                            $body_late  .= '<tr>';
                            $body_late  .= '    <td>'.$late_employees['en'][$i].'</td>';
                            $body_late  .= '    <td>'.$late_employees['emp_name'][$i].'</td>';
                            $body_late  .= '    <td>'.$late_employees['in'][$i].'</td>';
                            $body_late  .= '</tr>';
                        }
                        if(date('A', strtotime($time_today)) == 'AM') {
                            $late_start = $late_morning_start;
                            $late_end   = $late_morning_end;
                        } else if(date('A', strtotime($time_today)) == 'PM') {
                            $late_start = $late_night_start;
                            $late_end   = $late_night_end;
                        } else {
                            $late_start = 'N/A';
                            $late_end   = 'N/A';
                        }
                        $email_msg = send_email_notification($date_today, $created_by, $body_late, $late_start, $late_end, $email_recipients);
                        if($email_msg != "Message has been sent!") {
                            send_invalid_emails($date_today, $created_by);
                            $email_status = 'NG';
                            $remarks = '';
                        } else {
                            $email_status = 'SENT';
                            $remarks = $created_by.' - Total late for '.$date_today.' is '.count($late_employees['en']) ;
                        }

                    } else {
                        $email_status = 'SENT';
                        $remarks = 'No late!';
                    }  
					
					/* Save transaction log */
					$return_msg = add_daily_transactions_direct_call($username, $email_status, $remarks, $mailer_link);
                }
            }
        } else {
            $email_status = 'SENT';
            $remarks = 'No record found!';
        }
        $return['status']       = $email_status;
        $return['remarks']      = $remarks;
        $return['date_today']   = $date_today;
        $return['trans_msg']    = $return_msg;
//        $return['script']       = $script;
        $return['time_today']       = $time_today;
		echo json_encode($return);
    }
    function return_emp_batch_list($date_today, $username, $late_morning_start, $late_morning_end, $late_night_start, $late_night_end){
		require_once('../class/oop.php'); //OOP Path
		$return               = $_POST;
		$late_employees       = array();
		$late_employees['en'] = array();
		$late_employees['emp_name'] = array();
		$late_employees['in'] = array();
		$result               = "";
		$array_fields         = array('empno','fullname');
		$table 	   	          = 'vw_batch_employee_list';
		$joins 	   	          = '';
		$sql_where 	          = 'WHERE username="'.$username.'"';
		$sql_order 	          = '';
		$sql_limit 	          = '';
        $empno                = array();
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_array($result)){
			$empno 	  = $row['empno'];
			$emp_name = $row['fullname'];
            
            /* Get employee attendance */
            $array_fields2       = array('time_in', 'mode_in');
            $table_tardiness  	 = 'vw_raw_data';
            $joins2 	   	     = '';
//            $sql_where2 	     = 'WHERE empno="'.$empno.'" AND ((date BETWEEN "' . $date_today . '" AND "' . $date_today . '") OR (date_out BETWEEN "' . $date_today . '" AND "' . $date_today . '"))';
            $sql_where2 	     = 'WHERE empno="'.$empno.'" AND ((date BETWEEN "' . $date_today . '" AND "' . $date_today . '"))';
            $sql_order2 	     = '';
            $sql_limit2 	     = 'LIMIT 0, 10';
            $result2             = OTKS::getInstance()->select_query($array_fields2,$table_tardiness,$joins2,$sql_where2,$sql_order2,$sql_limit2);
            while($row2 = mysqli_fetch_array($result2)){
                if($row2['mode_in'] == 'IN') {
                    $status = check_if_late($empno, $row2['time_in'], $late_morning_start, $late_morning_end, $late_night_start, $late_night_end);
                    if($status == 'LATE') {
                        $late_employees['en'][] 	  = $empno;
                        $late_employees['emp_name'][] = $emp_name;
                        $late_employees['in'][] 	  = date('h:i:s A',strtotime($row2['time_in']));
                    }
                }                
            }
		}
        return $late_employees;
	}
    function check_if_late($empno, $time_in, $late_morning_start, $late_morning_end, $late_night_start, $late_night_end){
		require_once('../class/oop.php'); //OOP Path
        
        $status = "";
        // if( date('A', strtotime($time_in)) == 'AM' ) {
            // if(strtotime($time_in) >= (strtotime($late_morning_start)) && strtotime($time_in) <= (strtotime($late_morning_end))) {
                // $status = 'LATE';
            // }
        // } else if( date('A', strtotime($time_in)) == 'PM' ) {
            // if(strtotime($time_in) >= (strtotime($late_night_start)) && strtotime($time_in) <= (strtotime($late_night_end))) {
                // $status = 'LATE';
            // }
        // } 
		
        if( date('A', strtotime($time_in)) == 'AM' ) {
            if(strtotime($time_in) >= (strtotime($late_morning_start)) && strtotime($time_in) <= (strtotime($late_morning_end))) {
                $status = 'LATE';
            }
        } if( date('A', strtotime($time_in)) == 'PM' ) {
            if(strtotime($time_in) >= (strtotime($late_night_start)) && strtotime($time_in) <= (strtotime($late_night_end))) {
                $status = 'LATE';
            }
        } 
		return $status;
	}
    function send_email_notification($date, $created_by, $body_late, $late_start, $late_end, $email_recipients) {
        require_once('../class/oop.php'); //OOP Path
        require_once('../class/send_email.php');
        
        $subject = 'List of Late Employees as of '.date('M d, Y', strtotime($date));
        $body = 'List of Late Employees as of '.date('M d, Y', strtotime($date)) . '<br><br>';
        // $body .= $email_recipients;
        $body .= '<table border=1>';
        $body .= '  <tr>';
        $body .= '      <th>Employee Number</th>';
        $body .= '      <th>Employee Name</th>';
        $body .= '      <th> Time In </th>';
        $body .= '  </tr>';
        $body .=    $body_late;
        $body .= '</table><br><br>';
        $body .= 'Considered Time of Late : '.date('h:i A', strtotime($late_start)).' to '.date('h:i A', strtotime($late_end)).'<br>';
       
        $to = return_email_add($created_by);
        $er = explode(',',$email_recipients);
        for($i=0;$i<count($er);$i++) {
            if(return_email_add($er[$i]) != 'kiosk@pricon.ph') {
                $cc[] = return_email_add($er[$i]);
            }
        }
        
        $cc = implode(',',$cc);
        $from = 'otks_system@pricon.ph';
        
        $php_mailer = new email();
		$msg = $php_mailer->send_email($to, $from, $cc, $subject, $body,'');
        return $msg;
    }
    function send_invalid_emails($date, $created_by) {
        require_once('../class/oop.php'); //OOP Path
        require_once('../class/send_email.php');
        
        $subject = 'EMAIL PROBLEM!!! Tardiness Notification as of '.date('M d, Y', strtotime($date));
        
        $body = 'There was a problem on sending email notification<br>';
        $body .= 'Created by : '.$created_by.'<br>';
        $body .= 'Date : '.$date.'<br>';
       
        $to = return_email_add('ronfern@pricon.ph');        
        $from = 'otks_system@pricon.ph';
        
        $php_mailer = new email();
		$msg = $php_mailer->send_email($to, $from, $from, $subject, $body,'');
        return $msg;
    }
    function return_email_add($username) {
        require_once('../class/oop.php'); //OOP Path
		$email_add = '';
		$result = "";
		$array_fields = array('email_add');
		$table 	   	= 'db_acl.tbl_useraccnt';
		$joins 	   	= '';
		$sql_where 	= 'WHERE username="'.$username.'"';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0,1';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
            $email_add = $row['email_add'];
        }
        return $email_add;
    }
    
    /* DO NOT CHANGE STARTING HERE!!!! */
    function draw_reminder_design(){
		require_once('../class/oop.php'); 
		$result     = "";
		$date_today = $_POST['date_today'];
		$system_name= $_POST['system_name'];
		$fk_mailer  = $_POST['fk_mailer'];
		$icon       = $_POST['icon'];
		$array_fields = array('DISTINCT(`status`) as status');
		$table 	   	= 'db_mailer_dashboard.tbl_daily_email_status';
		$joins 	   	= '';
		$sql_where 	= 'WHERE date_email="' . $date_today . '" AND fk_mailer=' . $fk_mailer. ' AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = OTKS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
        if($result->num_rows > 1) {
            $status = 'NG';
        } else {
            if($row = mysqli_fetch_array($result)){
                $status = $row['status'];
            }
        }
		
        if($status == 'SENT') {
            $panel_color = 'success';
            $color = '#5cb85c;';
        } else if($status == 'NG') {
            $panel_color = 'danger';
            $color = 'red;';
        } else {
            $panel_color = 'default';
            $color = '#f5f5f5;';
        }

        $html  = '
            <div class="col-sm-3">
                <div class="panel panel-' . $panel_color . '" data-toggle="tooltip" data-placement="bottom">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-' . $icon . ' fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><font style="color:' . $color . '">0</font></div>
                                <div>'. $system_name . '</div>
                            </div>
                        </div>
                    </div>
                    <a href="" id="">
                        <div class="panel-footer">
                            <span class="pull-left">'. $system_name . '</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>          
        ';
        $return['html'] = $html;
        echo json_encode($return);
	}
    function return_reminder_info() {
        require_once('../class/oop.php'); 
		$result     = "";
		$mailer_link= $_POST['mailer_link'];
        
		$array_fields = array('pkid','system_name', 'icon');
		$table 	   	= 'db_mailer_dashboard.tbl_mailer';
		$joins 	   	= '';
		$sql_where 	= 'WHERE mailer_link = "' . $mailer_link . '" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
        if($row = mysqli_fetch_array($result)) {
            $return['fk_mailer']    = $row['pkid'];
            $return['system_name']  = $row['system_name'];
            $return['icon']         = $row['icon'];
        }
        echo json_encode($return);
    }
    function add_daily_transactions_direct_call($username, $status, $remarks, $mailer_link){
		require_once('../class/oop.php'); 
		$date_time_today= date('Y-m-d H:i:s');
		$date_email     = date('Y-m-d');
		$result 		= "";
		$table1   		= "db_mailer_dashboard.tbl_mailer";
		$table2   		= "db_mailer_dashboard.tbl_daily_email_status";
        $array_fields1 	= array('pkid','system_name','icon');
        $joins 	      	= '';
		$sql_where 	    = 'WHERE `mailer_link` ="'.$mailer_link.'"';
		$sql_order 	    = '';
		$sql_limit    	= '';
		$result         = OTKS::getInstance()->select_query($array_fields1,$table1,$joins,$sql_where,$sql_order,$sql_limit);
		echo $script         = OTKS::getInstance()->select_query_script($array_fields1,$table1,$joins,$sql_where,$sql_order,$sql_limit);
        
		if($row = mysqli_fetch_array($result) ) {
            $fk_mailer      = $row['pkid'];
            $system_name    = $row['system_name'];
            $icon           = $row['icon'];
            $array_fields2 	= array('date_time_created', 'created_by', 'fk_mailer', 'date_email', 'status', 'remarks', 'lastupdate', 'username');		
            $array_values 	= array($date_time_today,$username,$fk_mailer,$date_email,$status,$remarks,$date_time_today,$username); 
            $result 		= OTKS::getInstance()->insert_query($table2,$array_fields2,$array_values);
            $script 	   .= OTKS::getInstance()->insert_query_script($table2,$array_fields2,$array_values);
			$msg			= 'SAVE';
        } else {
			$msg			= 'ERROR!';
		}
        // $return['script']       = $script;
		return $script;
	}
	/* UP TO HERE!!!! */
?>