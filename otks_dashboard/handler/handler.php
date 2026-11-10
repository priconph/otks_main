<?php
	if(is_ajax()) {
		if(isset($_POST["action"]) && !empty($_POST["action"])) {
			$action = $_POST["action"];
			switch($action) {
				/* REQUESTOR FUNCTIONS */
				case "load_hris_record_all" 	        : load_hris_record_all(); break;  
				case "load_employee_name_by_number" 	: load_employee_name_by_number(); break;  
				case "load_employee_number_by_name" 	: load_employee_number_by_name(); break;  
				case "for_approval_ot"					: for_approval_ot(); break;
				case "for_approval_ps"					: for_approval_ps(); break;
				case "for_approval_sh"					: for_approval_sh(); break;
				/* MANAGE BATCH START */
				case "save_batch_employee"               : save_batch_employee(); break;  
				case "delete_batch_employee"             : delete_batch_employee(); break;  
               
			   
			   
			   /* APPROVER FUNCTIONS */
			   case "count_pending_ot"					: count_pending_ot(); break;
			   case "count_pending_ps"					: count_pending_ps(); break;
			   case "count_pending_sh"					: count_pending_sh(); break;
			   
			    /* MANAGE BATCH END */  
				case "load_records" 					: load_records(); break;//switch case, in using ajax an action must be set in order to choose the specific function to use
				case "selec_users" 		    			: selec_users(); break;
				case "add_new_record" 					: add_new_record(); break; //switch case, in using ajax an action must be set in order to choose the specific function to use
				case "update_fetch_record" 				: update_fetch_record(); break; //switch case, in using ajax an action must be set in order to choose the specific function to use
				case "update_record" 					: update_record(); break; //switch case, in using ajax an action must be set in order to choose the specific function to use
				case "delete_record" 					: delete_record(); break; //switch case, in using ajax an action must be set in order to choose the specific function to use
				
				
				case "get_attendance_viewer_access" 	: get_attendance_viewer_access(); break; //switch case, in using ajax an action must be set in order to choose the specific function to use
			}
		}
	}

	function is_ajax() {
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
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
	
	function for_approval_ot() {
		require_once('../class/oop.php'); //OOP Path
		$return = $_POST;
		$result = "";
		$array_fields = array('pkid');
		$table 	   	= 'tkovertime_main';
		$joins 	   	= '';
		$sql_where 	= 'WHERE `created_by`="'.$return['requestor'].'" AND req_status=1 AND `logdel`=0';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$pending = $result->num_rows;
		$return['ot_pending'] = $pending;
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}
	
	function for_approval_ps() {
		require_once('../class/oop.php'); //OOP Path
		$return = $_POST;
		$result = "";
		$array_fields = array('pkid');
		$table 	   	= 'tkob';
		$joins 	   	= '';
		$sql_where 	= 'WHERE `created_by`="'.$return['requestor'].'" AND ob_status=0 AND `logdel`=0';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$pending = $result->num_rows;
		$return['ot_pending'] = $pending;
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}
	
	function for_approval_sh() {
		require_once('../class/oop.php'); //OOP Path
		$return = $_POST;
		$result = "";
		$array_fields = array('pkid');
		$table 	   	= 'tkstraight_main';
		$joins 	   	= '';
		$sql_where 	= 'WHERE `created_by`="'.$return['requestor'].'" AND status=1 AND `logdel`=0';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$pending = $result->num_rows;
		$return['ot_pending'] = $pending;
		$return['result'] = json_encode($result);
		echo json_encode($return);
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
	
	/* APPROVER FUNCTIONS */
	function count_pending_ot() {
		require_once('../class/oop.php'); //OOP Path
		$return = $_POST;
		$result = "";
		$array_fields = array('pkid');
		$table 	   	= 'tkovertime_main';
		$joins 	   	= '';
		$sql_where 	= 'WHERE `req_approver`="'.$return['approver'].'" AND req_status=1 AND `logdel`=0';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$pending = $result->num_rows;
		$return['ot_pending'] = $pending;
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}
	
	function count_pending_ps() {
		require_once('../class/oop.php'); //OOP Path
		$return = $_POST;
		$result = "";
		$array_fields = array('pkid');
		$table 	   	= 'tkob';
		$joins 	   	= '';
		$sql_where 	= 'WHERE `ob_approver`="'.$return['approver'].'" AND ob_status=0 AND `logdel`=0';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$pending = $result->num_rows;
		$return['ot_pending'] = $pending;
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}
	
	function count_pending_sh() {
		require_once('../class/oop.php'); //OOP Path
		$return = $_POST;
		$result = "";
		$array_fields = array('pkid');
		$table 	   	= 'tkstraight_main';
		$joins 	   	= '';
		$sql_where 	= 'WHERE `approver`="'.$return['approver'].'" AND status=1 AND `logdel`=0';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$pending = $result->num_rows;
		$return['ot_pending'] = $pending;
		$return['result'] = json_encode($result);
		echo json_encode($return);
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
		require_once('../class/oop.php'); //OOP Path
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
		require_once('../class/oop.php'); //OOP Path
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
		require_once('../class/oop.php'); //OOP Path
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
		require_once('../class/oop.php'); //OOP Path
		$return 	= $_POST; 
		$result 	= "";
		$table   	= "tbl_records";
		$pkid 		= $return['pkid'];
		$result 	= OTKS::getInstance()->delete_query($table,$pkid);
		$return["result"] = json_encode($result); //return the the serialize values
		echo json_encode($return); //json encode since I used a dataType json before passing the serialized values here
	}

	function get_attendance_viewer_access(){
		require_once('../class/oop.php'); //OOP Path
		$return = $_POST; 
		$result = "";
		$array_fields = array('tbl_acl.fkmodname', 'tbl_useraccnt.username');
		$table 	   	= 'tbl_useraccnt';
		$joins 	   	= 'INNER JOIN tbl_acl ON tbl_useraccnt.pkid = tbl_acl.fkuser';
		$sql_where 	= 'WHERE tbl_useraccnt.username = "'.$return['session_username'].'"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = ACL::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$ctr = 0;
		while($row = mysqli_fetch_array($result)){
			$return['fkmodname'][$ctr] 		= $row['fkmodname'];
			$return['username'][$ctr] 	= $row['username'];
			$ctr++;
		}
		// $return['ctr'] = $ctr;
		// $return["result"] = json_encode($result); //return the the serialize values
		echo json_encode($return);//json encode since I used a dataType json before passing the serialized values here
	}

?>