<?php
session_start();
$user_type = $_SESSION['user_type'];
$pkid_main = $_POST['pkid'];

echo '<input type="hidden" id="hd_user_type" value="'.$user_type.'">';
?>

<input type="hidden" id="hd_main_pkid" value="<?php echo $pkid_main; ?>">
<input type="hidden" id="hd_username" value="<?php echo $username; ?>">

<!--Main Container-->
<div id="row main_container" style="margin-top:20px;">
	<div class="col-sm-12">
		<div class="row" style="padding-bottom:10px;">
			<div class="col-sm-12">
				<p style="text-align:right;">
				<?php
					echo '<button class="btn btn-success btn-md fa fa-save" id="btn_save_draft" style="margin-right:2px;"> Save Draft</button>';
					echo '<button class="btn btn-warning btn-md fa fa-envelope-o" id="btn_save_send" style="margin-right:2px;"> Save & Send</button>';
					echo '<a href="./index_requestor.php?page=main.php"><button class="btn btn-default btn-md fa fa-close"> Close</button></a>';
				?>
				</p>
			</div>
		</div>
		<div class="panel panel-success">
	  		<div class="panel-heading"><h3><span class="fa fa-calendar-check-o"></span> Request Details</h3></div>
	  		<div class="panel-body">
				<div id="row">
					<div class="col-sm-12">
						<p style="text-align:right;">
							<?php
							if($user_type == 0){
								echo '<button class="btn btn-primary btn-md fa fa-user-plus" id="btn_add_employee" style="margin-right:2px;"> Add Employee</button>';
								echo '<button class="btn btn-primary btn-md fa fa-users" id="btn_add_batch_employee" style="margin-right:2px;"> Add Employee by Batch</button>';
								//echo '<button type="button" class="btn btn-primary fa fa-street-view" id="btn_other_employee"> Other Employee</button>';
								echo '<hr>';
							}
							if($user_type == 1){
								echo '<button class="btn btn-success btn-md fa fa-thumbs-o-up" id="btn_approve_request" style="margin-right:2px;margin-left:200px;"> Approve</button>';
								echo '<button class="btn btn-danger btn-md fa fa-thumbs-o-down" id="btn_disapprove_request" style="margin-right:2px;"> Disapprove</button>';
								echo '<a href="./index_approver.php?page=main.php"><button class="btn btn-default btn-md fa fa-close"> Close</button></a>';
								echo '<hr>';
							}
							?>
						</p>
					</div>
				</div>
				<div class="col-sm-12" id="container_table_straight_summary">
					<table class="table table-bordered table-striped" id="tbl_straight_hours_details">
						<thead>
							<tr>
								<th>Employee Number</th>
								<th>Employee Name</th>
								<th>Date / Time In</th>
								<th>Date / Time Out</th>
								<th>Hours Consumed</th>
								<th>Remarks</th>
								<th>System Comment</th>
								<th>Remove Name</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
	 	 	</div>
		</div>
	</div>
</div>

<!-- Modal system message -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_batch_add_employee">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><span class="fa fa-users"></span> Add Employee by Batch</h4>
      </div>
      <div class="modal-body">
        <div class="row">
        	<div class="col-sm-12">
        		<div id="container_tbl_employee_list"></div>
	       	</div>
	       	<div class="col-sm-12">
				<div class="row">
					<form id="frm-batch-employee-add" method="post">
					<div class="col-sm-6">
						<label style="width:150px;">Date In: </label><input type="text" class="form-control datepicker" name="txt_batch_date_in" id="txt_batch_date_in" required>
						<label style="width:150px;">Date Out: </label><input type="text" class="form-control datepicker" name="txt_batch_date_out" id="txt_batch_date_out" required>
						<!--<label style="width:150px;">Filed Straight: </label><input type="number" class="form-control" id="txt_batch_filled_straight" min="0.5" step="0.5" required>-->
					</div>
					<div class="col-sm-6">
						<label style="width:150px;">Time In: </label><input type="time" class="form-control" name="txt_batch_time_in" id="txt_batch_time_in" required>
						<label style="width:150px;">Time Out: </label><input type="time" class="form-control" name="txt_batch_time_out" id="txt_batch_time_out" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<label style="width:150px;">Remarks: </label><input type="text" class="form-control" name="txt_batch_remarks" id="txt_batch_remarks">
					</div>
				</div>
	       	</div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success fa fa-save" id="btn_save_batch"> Save</button>
        <button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
					</form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal update filed straight -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_update_employee_straight">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><span class="fa fa-users"></span> Update Employee Straight</h4>
      </div>
      <div class="modal-body">
        <div class="row">
	       	<div class="col-sm-12">
				<div class="row">
					<form id="frm-straight-detail-update" method="post">
						<div class="col-sm-6">
							<label >Employee Number: </label><input type="text" class="form-control" id="txt_update_employee_number" name="txt_update_employee_number" readonly required>
							<label >Date In: </label><input type="text" class="form-control datepicker" id="txt_update_employee_date_in" name="txt_update_employee_date_in" required>
							<label >Date Out: </label><input type="text" class="form-control datepicker" id="txt_update_employee_date_out" name="txt_update_employee_date_out" required>
						</div>
						<div class="col-sm-6">
							<label >Employee Name: </label><input type="text" class="form-control" id="txt_update_employee_name" name="txt_update_employee_name" readonly required>
							<label >Time In: </label><input type="time" class="form-control" id="txt_update_employee_time_in" name="txt_update_employee_time_in" required>
							<label >Time Out: </label><input type="time" class="form-control" id="txt_update_employee_time_out" name="txt_update_employee_time_out" required>
						</div>
						<div class="col-sm-12">
							<label >Remarks: </label><input type="text" class="form-control" id="txt_update_employee_remarks" name="txt_update_employee_remarks">
						</div>
				</div>
	       	</div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success fa fa-save" id="btn_save_update_employee"> Update</button>
        <button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
					</form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal system message -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_system_message">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">System Message</h4>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal add each employee -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_add_each_employee">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><span class="fa fa-user-plus"></span> Add Employee</h4>
      </div>
      <div class="modal-body">
            <div id="">
                <form id="frm_add_employee" method="post">
                    <div class="row" style="padding:0px;">
                        <div id="container_error_message"></div>
                        <div class="col-sm-6 " class="form-inline">
							<div class="form-inline" style="padding:0px;">
								<datalist id="txt_add_employee_number_list">
								</datalist>
								<label style="width:150px;">Employee Number:</label>
								<input class="form-control" type="text" name="txt_add_employee_number" style="text-transform:uppercase" id="txt_add_employee_number" list="txt_add_employee_number_list" autocomplete="off" required>
							</div>
						</div>
                        <div class="col-sm-6">
                            <div class="form-inline" style="padding:0px;">
                                <datalist id="txt_add_employee_name_list">
                                </datalist>
                                <label style="width:150px;">Employee Name:</label>
                                <input class="form-control" type="text" name="txt_add_employee_name" id="txt_add_employee_name" list="txt_add_employee_name_list" autocomplete="off" required>
                            </div>
                        </div>
						<div class="col-sm-6" style="">
                            <div class="form-inline" style="padding:0px;">
                                <label style="width:150px;">Date In:</label>
                                <input class="form-control datepicker" type="text" name="txt_add_employee_date_in" id="txt_add_employee_date_in" required readonly>
                            </div>
                        </div>
						<div class="col-sm-6" style="">
                            <div class="form-inline" style="padding:0px;">
                                <label style="width:150px;">Date Out:</label>
                                <input class="form-control datepicker" type="text" name="txt_add_employee_date_out" id="txt_add_employee_date_out" required readonly>
                            </div>
                        </div>
						<div class="col-sm-6" style="">
                            <div class="form-inline" style="padding:0px;">
                                <label style="width:150px;">Time In:</label>
                                <input class="form-control" type="time" name="txt_add_employee_time_in" id="txt_add_employee_time_in" required>
                            </div>
                        </div>
						<div class="col-sm-6" style="">
                            <div class="form-inline" style="padding:0px;">
                                <label style="width:150px;">Time Out:</label>
                                <input class="form-control" type="time" name="txt_add_employee_time_out" id="txt_add_employee_time_out" required>
                            </div>
                        </div>
                        <div class="col-sm-12 ">
                            <div class="form-inline" style="padding:0px;">
                                <label style="width:150px;">Remarks:</label>
                                <input class="form-control" style="width:100%" type="text" name="txt_add_employee_remarks">
                            </div>
                        </div>
                    </div>
            </div><!--Add employee end-->
      </div>
      <div class="modal-footer">
        <button class="btn btn-md btn-success fa fa-save" type="submit" id="btn_save_add_employee"> Save</button>
		<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
		      </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script src="./functions/common_functions.js"></script>

<script>
var tbl_straight_hours_details 	= 'tbl_straight_hours_details';
var tbl_employee_list 	   		= 'tbl_employee_list';
var handler = './handler/handler.php';
var user_type = $('#hd_user_type').val();

var fullname		= '';
var section 		= '';
var department 		= '';
var division 		= '';
var min_date   		= '';
var max_date    	= '';
var ot_type    		= '';
var tbl_row    		= '';
var username 		= $('#hd_username').val();
var main_pkid 		= $('#hd_main_pkid').val();
var request_status 	= '';

/* Arrays */
var array_batch_employee 				= [];
var array_batch_employee_name 			= [];
var array_table_validate 				= {};
	array_table_validate.emp_no 		= [];
	array_table_validate.emp_name 		= [];
	array_table_validate.date_time_in 	= [];
	array_table_validate.date_time_out 	= [];
	array_table_validate.date_ot 		= [];
	array_table_validate.ot 			= [];
	array_table_validate.remarks 		= [];
	array_table_validate.msg 			= [];
	array_table_validate.fkid 			= [];
var validate_exist = 0;
var duplicate_rec = '';	

load_request_status();
function load_request_status(){
	var data = {
		"action"	: "fetch_main_data_update",
		"pkid"		: main_pkid
	}
	call_ajax(data, handler, function(result){
		request_status = result['status'];
		
		var user_type = "<?php echo $user_type; ?>";
		if(user_type == 0){
			if( request_status == 1){
				$('button').prop('disabled',false);
				$('.btn-success').prop('disabled',true);
				$('#modal_add_each_employee .btn-success').prop('disabled',false);
				$('#modal_batch_add_employee .btn-success').prop('disabled',false);
				$('.fa-close').prop('disabled',false);
			} 
			// if( request_status == 2 || request_status == 3 || request_status == 4){
				// $('button').prop('disabled',true);
				// $('.fa-close').prop('disabled',false);
			// } 
		}else{
			// if( request_status == 2 || request_status == 3 || request_status == 4){
				// $('button').prop('disabled',true);
				// $('.fa-close').prop('disabled',false);
			// }
		}
	});
}		

load_employee_information();

var oTable = $('#'+tbl_straight_hours_details).DataTable({
	paginate	: false
});
	
/* CLICK FUNCTIONS */
$('#btn_add_batch_employee').click(function(){
	$('input#txt_batch_date').attr({
		"min"   : min_date,
		"max"   : max_date,
		"value" : min_date
	});
	$('#modal_batch_add_employee').modal('show');
	// load_employee_via_section();
	load_employee_via_managed_batch();
});	

$('#frm-batch-employee-add').submit(function(e){
	e.preventDefault();
	var serialized_data = $(this).serialize();
	append_straight_details(serialized_data);
});

load_straight_main_details();

function load_straight_main_details(){
	var data = {
		"action"	: "load_straight_main_details",
		"main_pkid"	: main_pkid
	}
	call_ajax(data, handler, function(result){
		// $('#' + 'txt_batch_date_out').attr('min',date_from);
		// add_date_min_max('txt_batch_date_in',result['date_from'],result['date_to']);
		// add_date_min_max('txt_batch_date_out',result['date_from'],result['date_to']);
		min_date = reformat_date( result['date_from'] );
		max_date = reformat_date( result['date_to'] );
		
		/* date picker */
		$('.datepicker').datepicker({
			changeMonth: true,
			changeYear: true,
			minDate: min_date,
			maxDate: max_date
		});
		$('.datepicker').datepicker("option", "dateFormat", "yy-mm-dd");
		$('.datepicker').attr("style", "background-color:white;");
	});
}

function reformat_date(old_date){
	var new_date = old_date.split('-');
		new_date = new_date[1] + '/' + new_date[2] + '/' + new_date[0];
		return new_date;
}
// add_date_min_max('txt_batch_date_in','2016-03-10','2016-03-20');

function add_date_min_max(text_id,min_date,max_date){
	$('#' + text_id).attr('min',min_date);
	$('#' + text_id).attr('max',max_date);
}

load_straight_details();

function load_straight_details(){
	var data = {
		"action"			: "load_straight_details",
		"fkstraight_main"	: main_pkid
	}
	call_ajax(data, handler, function(result){
		oTable.clear().draw();
		if(result['empno'][0] == ""){
			return false;
		}
		var en_length = result['empno'].length;
		for(x=0;x<en_length;x++){
			var button_disabled = '';
			if(user_type == 0 || user_type == "0"){
				button_disabled = '';
			}
			if(user_type == 1 || user_type == "1"){
				button_disabled = 'disabled';
			}
			if(request_status == 2 || request_status== 4){
				button_disabled = 'disabled';
			}
			oTable.row.add( [
				result['empno'][x],
				result['LastName'][x]+', '+result['FirstName'][x],
				result['date_from'][x]+' '+result['time_from'][x],
				result['date_to'][x]+' '+result['time_to'][x],
				result['hours_consumed'][x],
				result['remarks'][x],
				result['system_comment'][x],
				'<center><button class="btn btn-warning fa fa-edit" value="'+result['pkid'][x]+'" ' + button_disabled + ' style="display:none;"></button></center><center><button class="btn btn-danger fa fa-remove" value="'+result['pkid'][x]+'" ' + button_disabled + '></button></center>'
			] ).draw( false );
		}
		highlight_invalid_rows();
	});
}

function load_employee_information(){
	var data = {
		"action" 	: "load_hris_record_by_username",
		"username"	: username
	} 
	call_ajax(data, handler, function(result){
		/* Assign Variables */
		fullname = result['lastname']+', '+result['firstname']+' '+result['middlename'];
		department = result['Department'];
		section = result['Section'];
		division = result['Division'];
	});
}

function load_employee_via_section(){
	var data = {
		"action" 	: "load_hris_record_by_section",
		"section"	: section
	} 
	call_ajax(data, handler, function(result){
		array_batch_employee_name = [];
		array_batch_employee = [];
		var html  = '<table id="'+tbl_employee_list+'">';
			html += '	<thead>';
			html += '		<tr>';
			html += '			<th><input type="checkbox" class="chk_all_employee"></th>';
			html += '			<th>Emp #</th>';
			html += '			<th>Employee Name</th>';
			html += '		</tr>';
			html += '	</thead>';
			html += '	<tbody>';
			html += '	</tbody>';
			html += '</table>';
		var container = 'container_tbl_employee_list';
		$('#'+container).empty();
		$('#'+container).append(html);
		var ctr = result['ctr'];
		
		/* append table values */
		for(x=0;x<ctr;x++){
			var html  = '<tr>';
				html += '	<td><input type="checkbox" class="chk_employee"></td>';
				html += '	<td>'+result['EmpNo'][x]+'</td>';
				html += '	<td>'+result['lastname'][x]+', '+result['firstname'][x]+'</td>';
				html += '</tr>';
			$('#'+tbl_employee_list+' tbody').append(html);
		}
		dt_emp_list = $('#'+tbl_employee_list).DataTable({
			'columnDefs': [{
			'targets': 0,
			'searchable': false,
			'orderable': false,
			'className': 'dt-body-center',
			'render': function (data, type, full, meta){
				 return '<input type="checkbox" name="id[]" value="' + $('<div/>').text(data).html() + '">';
			 }
		  }],
		  'order': [[1, 'asc']]
		});
		
		/* checkbox events */
		$('#' + tbl_employee_list + ' tbody').on('click', '.chk_employee', function(){
			re_assign_tbl_employee_array_value();
		});
		
		$('.chk_all_employee').on('click', function(){
			var rows = dt_emp_list.rows({ 'search': 'applied' }).nodes();
			// Check/uncheck checkboxes for all rows in the table
			$('input[type="checkbox"]', rows).prop('checked', this.checked);
			re_assign_tbl_employee_array_value_all();
		});
		$('#modal_batch_add_employee').modal('show');
	});
}

function load_employee_via_managed_batch(){
		var data = {
			"action" 	: "load_hris_record_by_managed_batch",
			"username"	: username
		} 
		call_ajax(data, handler, function(result){
			var html  = '<table id="'+tbl_employee_list+'">';
				html += '	<thead>';
				html += '		<tr>';
				html += '			<th><input type="checkbox" class="chk_all_employee"></th>';
				html += '			<th>Emp #</th>';
				html += '			<th>Employee Name</th>';
				html += '		</tr>';
				html += '	</thead>';
				html += '	<tbody>';
				html += '	</tbody>';
				html += '</table>';
			var container = 'container_tbl_employee_list';
			$('#'+container).empty();
			$('#'+container).append(html);
			var ctr = result['ctr'];
			
			/* append table values */
			for(x=0;x<ctr;x++){
				var html  = '<tr>';
					html += '	<td><input type="checkbox" class="chk_employee"></td>';
					html += '	<td>'+result['empno'][x]+'</td>';
					html += '	<td>'+result['fullname'][x]+'</td>';
					html += '</tr>';
				$('#'+tbl_employee_list+' tbody').append(html);
			}
			dt_emp_list = $('#'+tbl_employee_list).DataTable({
				'columnDefs': [{
				'targets': 0,
				'searchable': false,
				'orderable': false,
				'className': 'dt-body-center',
				'render': function (data, type, full, meta){
					 return '<input type="checkbox" name="id[]" value="' + $('<div/>').text(data).html() + '">';
				 }
			  }],
			  'order': [[1, 'asc']]
			});
			/* checkbox events */
			$('#' + tbl_employee_list + ' tbody').on('click', '.chk_employee', function(){
				re_assign_tbl_employee_array_value();
			});
			
			$('.chk_all_employee').on('click', function(){
                // var rows = dt_emp_list.rows({ 'search': 'applied' }).nodes();
                var rows = dt_emp_list.rows({  }).nodes();
                if($('.chk_all_employee').is(':checked')) {
                    // Check checkboxes for all rows in the table
                    $('input[type="checkbox"]', rows).prop('checked', this.checked);
                    // alert('check all');
                } else {
					// alert('clear');
                    // Uncheck checkboxes for all rows in the table
                    $('input[type="checkbox"]', rows).prop('checked', false);
                    array_batch_employee = [];
                    array_batch_employee_name = [];
                }
                re_assign_tbl_employee_array_value_all();
			});
		});
	}

function re_assign_tbl_employee_array_value_all() {
	dt_emp_list.$('input[type="checkbox"]').each(function(){
		var new_empno = $(this).closest('tr').find('td:eq(1)').text();
		var new_empname = $(this).closest('tr').find('td:eq(2)').text();
		var check_exist = check_exist_on_array(new_empno);
		if(check_exist != 1){
			array_batch_employee.push(new_empno);
			array_batch_employee_name.push(new_empname);
		}
	  });
	// alert(array_batch_employee.length);
}

function re_assign_tbl_employee_array_value(){
	$('#'+tbl_employee_list+' tbody tr').each(function(){
		if($(this).find('td:eq(0) .chk_employee').prop('checked')){
			/* check if checked values exist on array, add if not exist */
			var new_empno = $(this).find('td:eq(1)').text();
			var new_empname = $(this).find('td:eq(2)').text();
			// var check_exist = jQuery.inArray(new_empno,array_batch_employee);
			
			var check_exist = check_exist_on_array(new_empno);
			if(check_exist != 1){
				array_batch_employee.push(new_empno);
				array_batch_employee_name.push(new_empname);
			}
		}else{
			/* check if none checked values exist on array, remove if it exist */
			var new_empno = $(this).find('td:eq(1)').text();
			var new_empname = $(this).find('td:eq(2)').text();
			remove_array_value(new_empno);
			remove_array_value_name(new_empname);
		}
	});
}

function append_straight_details(serialized_data){
	var data = {
		"action"			: "append_new_straight_details",
		"array_empno"		: array_batch_employee,
		"array_emp_name"	: array_batch_employee_name,
		"fkstraight_main"	: main_pkid,
		"username"			: username
	}
	
	call_ajax_serialize(data, serialized_data, handler, function(result){
		$('#modal_batch_add_employee').modal('hide');
		var existing_rec_length = result['existing_records']['empno'].length;
		var rec_length = result['records']['empno'].length;
		var html  = '<div class="alert alert-danger"><h5>Fail to add the following record, Record already exist!</h5></div>';
			html += '<table class="table">';
			html += '	<thead>';
			html += '		<tr>';
			html += '			<th>Empno</th>';
			html += '			<th>Name</th>';
			html += '			<th>DateIn / TimeIn</th>';
			html += '			<th>DateOut / TimeOut</th>';
			html += '		</tr>';
			html += '	</thead>';
			html += '	<tbody>';
		for(x=0;x<existing_rec_length;x++){
			html += '		<tr>';				
			html += '			<td>'+result['existing_records']['empno'][x]+'</td>';				
			html += '			<td>'+result['existing_records']['emp_name'][x]+'</td>';				
			html += '			<td>'+result['existing_records']['date_time_in'][x]+'</td>';				
			html += '			<td>'+result['existing_records']['date_time_out'][x]+'</td>';				
			html += '		</tr>';		
		}
			html += '	</tbody>';
			html += '</table>';
			
		if( existing_rec_length != 0){
			$('#modal_system_message .modal-title').empty();
			$('#modal_system_message .modal-body').empty();
			$('#modal_system_message .modal-footer').empty();
			$('#modal_system_message .modal-title').append('Existing Records');
			$('#modal_system_message .modal-body').append(html);
			$('#modal_system_message .modal-footer').append('<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>');
			$('#modal_system_message').modal('show');
		}
		
		for(x=0;x<rec_length;x++){
			var exist = check_exist_on_table(result['records']['empno'][x],result['records']['date_time_in'][x]);
			if(exist == 1){
				alert('Multiple entry for employee '+result['records']['empno'][x]);
			}else{
				oTable.row.add( [
					result['records']['empno'][x],
					result['records']['emp_name'][x],
					result['records']['date_time_in'][x],
					result['records']['date_time_out'][x],
					result['records']['hours_consumed'][x],
					result['records']['remarks'][x],
					result['records']['system_message'][x],
					'<center><button class="btn btn-edit fa fa-edit" value="0" style="display:none;"></button></center><center><button class="btn btn-danger fa fa-remove" value="0"></button></center>'
				] ).draw( false );
			}
		}

		highlight_invalid_rows();
	
	});
}

function check_exist_on_table(empno,date_time_in){
	var exist = 0;
	$('#'+tbl_straight_hours_details+' tbody tr').each(function(){
		/* appended data */
		var appended_date = date_time_in;
			appended_date = appended_date.split(' ');
		var date_in = appended_date[0];
		/* table data */
		var empno_table 		= $(this).find('td:eq(0)').text();
		var date_time_in_table 	= $(this).find('td:eq(2)').text();
		date_time_in_table = date_time_in_table.split(' ');
		var date_in_table = date_time_in_table[0];
		// alert(date_in + 'vs' +date_in_table + ' and ' +empno+'vs'+empno_table);
		if(date_in == date_in_table && empno == empno_table){
			exist = 1;
		}
	});
	return exist;
}
var invalid_rows_count = 0;

function highlight_invalid_rows(){
	invalid_rows_count = 0;
	$('#'+tbl_straight_hours_details+' tbody tr').each(function(){
		var valid = $(this).find('td:eq(6)').text();
		if(valid != ''){
			$(this).attr('style','color:red;');
			invalid_rows_count++;
		}else{
			$(this).attr('style','color:black;');
		}
	});
}
	
function display_array_value(){
	for(x=0;x<array_batch_employee.length;x++){
		alert(array_batch_employee[x]+' // '+array_batch_employee_name[x]);
	}
}

function check_exist_on_array(value){
	for(x=0;x<array_batch_employee.length;x++){
		if(value == array_batch_employee[x]){
			return 1;
		}
	}
	return 0;
}

function remove_array_value(removeItem){
	array_batch_employee = jQuery.grep(array_batch_employee, function(value) {
	  return value != removeItem;
	});
}

function remove_array_value_name(removeItem){
	array_batch_employee_name = jQuery.grep(array_batch_employee_name, function(value) {
	  return value != removeItem;
	});
}

$('#btn_save_draft').click(function(){
	save_straight_details(function(){});
	var title  = 'System Message';
	var body   = '<div class="alert alert-success">';
		body  += '	<p><h4>Record has been saved as draft!</h4></p>';
		body  += '</div>';
	var button = '';
	use_modal_system_message(title,body,button);
});
	
$('#btn_save_send').click(function(){
    $('#modal_system_message .modal-header').empty();
	$('#modal_system_message .modal-body').empty();
	$('#modal_system_message .modal-footer').empty();
	var header 	 = 'System Message';
	var body	 = '<div>';
		body	+= '	<div class="alert alert-warning">';
		body	+= '		<p><h4>You are about to send the request to your corresponding approver.</h4></p>';
		body	+= '		<p><h4>Continue?</h4></p>';
		body	+= '	</div>';
		body	+= '</div>';
	var footer	 = '<button type="button" class="btn btn-success fa fa-save" id="btn_yes"> Yes</button>';
		footer  += '<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>';
	
	$('#modal_system_message .modal-header').append(header);
	$('#modal_system_message .modal-body').append(body);
	$('#modal_system_message .modal-footer').append(footer);
	$('#modal_system_message').modal('show');
	// alert(invalid_rows_count);
	$('#btn_yes').click(function(){
        if(invalid_rows_count != 0 ){
            $('#modal_system_message .modal-header').empty();
            $('#modal_system_message .modal-body').empty();
            $('#modal_system_message .modal-footer').empty();
            var header 	 = 'WARNING!';
            var body	 = '<div>';
                body	+= '	<div class="alert alert-danger">';
                body	+= '		<p><h4>Unable to send mail, There are still incorrect data!</h4></p>';
                body	+= '		<p><h4>Note: Please fix all rows highlighted in red!</h4></p>';
                body	+= '	</div>';
                body	+= '</div>';
            var footer	 = '<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>';

            $('#modal_system_message .modal-header').append(header);
            $('#modal_system_message .modal-body').append(body);
            $('#modal_system_message .modal-footer').append(footer);
            $('#modal_system_message').modal('show');
            return false;
        }
        if(username == '' || main_pkid == ''){
            alert('Session expired please relogin!');
            return false;
        }

        save_straight_details(function(){
            update_main_status('1');
            get_email_contents(function(result){
                var recipient 		= result['recipient'];
                var cc_recipient 	= result['cc'];
                var subject 		= 'OTKS straight hour request';
                var message 		= result['message'];
                send_mail(recipient,cc_recipient,subject,message);
                var title  = 'System Message';
                var body   = '<div class="alert alert-success">';
                    body  += '	<p><h4>Record Saved! Mail sent to approver!</h4></p>';
                    body  += '</div>';
                var button = '';
                use_modal_system_message(title,body,button);
                window.location.reload();
            });
        });
    });
    
    
    
//	if(!confirm('You are about to send the request to your corresponding approver.')){
//		return false;
//	}
//    if(invalid_rows_count != 0 ){
//        $('#modal_system_message .modal-header').empty();
//        $('#modal_system_message .modal-body').empty();
//        $('#modal_system_message .modal-footer').empty();
//        var header 	 = 'WARNING!';
//        var body	 = '<div>';
//            body	+= '	<div class="alert alert-danger">';
//            body	+= '		<p><h4>Unable to send mail, There are still incorrect data!</h4></p>';
//            body	+= '		<p><h4>Note: Please fix all rows highlighted in red!</h4></p>';
//            body	+= '	</div>';
//            body	+= '</div>';
//        var footer	 = '<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>';
//
//        $('#modal_system_message .modal-header').append(header);
//        $('#modal_system_message .modal-body').append(body);
//        $('#modal_system_message .modal-footer').append(footer);
//        $('#modal_system_message').modal('show');
//        return false;
//    }
//    if(username == '' || main_pkid == ''){
//        alert('Session expired please relogin!');
//        return false;
//    }
//
//    save_straight_details(function(){
//        update_main_status('1');
//        get_email_contents(function(result){
//            var recipient 		= result['recipient'];
//            var cc_recipient 	= result['cc'];
//            var subject 		= 'OTKS straight hour request';
//            var message 		= result['message'];
//            send_mail(recipient,cc_recipient,subject,message);
//            var title  = 'System Message';
//            var body   = '<div class="alert alert-success">';
//                body  += '	<p><h4>Record Saved! Mail sent to approver!</h4></p>';
//                body  += '</div>';
//            var button = '';
//            use_modal_system_message(title,body,button);
//            window.location.reload();
//        });
//    });
});
	
function update_main_status(status){
	var data = {
		"action"	: "update_main_status",
		"main_pkid"	: main_pkid,
		"username"	: username,
		"status"	: status
	}
	
	call_ajax(data, handler, function(){
		
	});
}
	
function save_straight_details(callback){
	var array_straight_details = [];
		array_straight_details.pkid = [];
		array_straight_details.empno = [];
		array_straight_details.empname = [];
		array_straight_details.DateIn = [];
		array_straight_details.TimeIn = [];
		array_straight_details.DateOut = [];
		array_straight_details.TimeOut = [];
		array_straight_details.HoursConsumed = [];
		array_straight_details.Remarks = [];
		array_straight_details.SystemComment = [];
	
	$('#'+tbl_straight_hours_details+' tbody tr').each(function(){
		array_straight_details.empno.push($(this).find('td:eq(0)').text());
		array_straight_details.empname.push($(this).find('td:eq(1)').text());
		var pkid = $(this).find('td:eq(7) .fa-remove').val();
		var date_time_in = $(this).find('td:eq(2)').text().split(' ');
		var date_in = date_time_in[0];
		var time_in = date_time_in[1];
		var date_time_out = $(this).find('td:eq(3)').text().split(' ');
		var date_out = date_time_out[0];
		var time_out = date_time_out[1];
		array_straight_details.pkid.push(pkid);
		array_straight_details.DateIn.push(date_in);
		array_straight_details.TimeIn.push(time_in);
		array_straight_details.DateOut.push(date_out);
		array_straight_details.TimeOut.push(time_out);		
		array_straight_details.HoursConsumed.push($(this).find('td:eq(4)').text());
		array_straight_details.Remarks.push($(this).find('td:eq(5)').text());
		array_straight_details.SystemComment.push($(this).find('td:eq(6)').text());
	});		
		
	if(main_pkid == ''){
		alert('Session expired please relogin!');
		return false;
	}
	
	var data = {
		"action"				: "save_straight_details",
		"array_pkid"			: array_straight_details.pkid,
		"array_empno"			: array_straight_details.empno,
		"array_empname"			: array_straight_details.empname,
		"array_date_in"			: array_straight_details.DateIn,
		"array_time_in"			: array_straight_details.TimeIn,
		"array_date_out"		: array_straight_details.DateOut,
		"array_time_out"		: array_straight_details.TimeOut,
		"array_hours_consumed"	: array_straight_details.HoursConsumed,
		"array_remarks"			: array_straight_details.Remarks,
		"array_system_comment"	: array_straight_details.SystemComment,
		"fkstraight_main"		: main_pkid,
		"username"				: username
	}
	
	call_ajax(data, handler, function(result){
		load_straight_details();
		callback();
	});
}
	
function send_mail(recipient,cc_recipient,subject,message){
	var data = {
		"action"		: "send_mail",
		"recipient"		: recipient,
		"cc_recipient"	: cc_recipient,
		"subject"		: subject,
		"message"		: message
	}
	call_ajax(data, handler, function(result){
//		alert(result['result']);
	});
}

function get_email_contents(callback){
	var data = {
		"action"  	: "get_email_contents",
		"username" 	: username,
		"main_pkid"	: main_pkid
	}
	call_ajax(data, handler, function(result){
		callback(result);
	});
}

$('#' + tbl_straight_hours_details + ' tbody').on('click','tr .fa-remove', function(){
	var pkid = $(this).val();
	var selected_row = $(this).closest('tr');
	update_straight_details_confirmation_modal(pkid,selected_row);
});

function update_straight_details_confirmation_modal(pkid,selected_row){
	$('#modal_system_message .modal-header').empty();
	$('#modal_system_message .modal-body').empty();
	$('#modal_system_message .modal-footer').empty();
	var header 	 = 'Delete Modal';
	var body	 = '<div>';
		body	+= '	<div class="alert alert-danger">';
		body	+= '		<p><h4>Warning you are about to delete a row!</h4></p>';
		body	+= '		<p><h4>Continue?</h4></p>';
		body	+= '	</div>';
		body	+= '</div>';
	var footer	 = '<button type="button" class="btn btn-danger fa fa-trash-o" id="btn_remove_row"> Continue..</button>';
		footer  += '<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>';
	
	$('#modal_system_message .modal-header').append(header);
	$('#modal_system_message .modal-body').append(body);
	$('#modal_system_message .modal-footer').append(footer);
	$('#modal_system_message').modal('show');
	
	$('#btn_remove_row').click(function(){
		var data = {
			"action"	: "remove_straight_detail",
			"pkid"		: pkid
		}
		if(pkid == '0'){
		oTable.row(selected_row).remove().draw( false );
			$('#modal_system_message .modal-body').empty();
			$('#modal_system_message .modal-body').append('<div class="alert alert-success"><p><h4>Row has been removed!</h4></p></div>');
			$('#btn_remove_row').hide();
			return false;
		}
		call_ajax(data, handler, function(result){
			oTable.row(selected_row).remove().draw( false );
			$('#modal_system_message .modal-body').empty();
			$('#modal_system_message .modal-body').append('<div class="alert alert-success"><p><h4>Row has been removed!</h4></p></div>');
			$('#btn_remove_row').hide();
            highlight_invalid_rows();
		});
	});
}
	
var selected_row_edit = '';
$('#' + tbl_straight_hours_details + ' tbody').on('dblclick','tr', function(){
	var selected_row = $(this).closest('tr');
		selected_row_edit = selected_row;
		update_newly_added_straight(selected_row);
});
$('#' + tbl_straight_hours_details + ' tbody').on('click','tr', function(){
		$('#'+tbl_straight_hours_details+' tbody tr').attr('style','');
		$(this).attr('style','background:teal;color:white;');
});
	
function update_newly_added_straight(tr){
	var empno 			= tr.find('td:eq(0)').text();
	var emp_name 	 	= tr.find('td:eq(1)').text();
	var date_time_in 	= tr.find('td:eq(2)').text();
		date_time_in 	= date_time_in.split(' ');
	var date_in 		= date_time_in[0];
	var time_in			= date_time_in[1];
	var date_time_out 	= tr.find('td:eq(3)').text();
		date_time_out 	= date_time_out.split(' ');
	var date_out 		= date_time_out[0];
	var time_out		= date_time_out[1];
	var remarks	 		= tr.find('td:eq(5)').text();
	
	$('#txt_update_employee_number').val(empno);
	$('#txt_update_employee_name').val(emp_name);
	$('#txt_update_employee_date_in').val(date_in);
	$('#txt_update_employee_time_in').val(time_in);
	$('#txt_update_employee_date_out').val(date_out);
	$('#txt_update_employee_time_out').val(time_out);
	$('#txt_update_employee_remarks').val(remarks);
	$('#modal_update_employee_straight').modal('show');
}

$('#frm-straight-detail-update').submit(function(e){
	e.preventDefault(e);
	var data = {
		"action"	: "update_row_details"
	}
	call_ajax_serialize(data, $(this).serialize(), handler, function(result){
//		alert(selected_row_edit.find('td:eq(0)').text());
		$('#modal_update_employee_straight').modal('hide');
		oTable.cell( selected_row_edit.find('td:eq(0)') ).data(result['empno']);
		oTable.cell( selected_row_edit.find('td:eq(1)') ).data(result['emp_name']);
		oTable.cell( selected_row_edit.find('td:eq(2)') ).data(result['date_time_in']);
		oTable.cell( selected_row_edit.find('td:eq(3)') ).data(result['date_time_out']);
		oTable.cell( selected_row_edit.find('td:eq(4)') ).data(result['hours_consumed']);
		oTable.cell( selected_row_edit.find('td:eq(5)') ).data(result['remarks']);
		oTable.cell( selected_row_edit.find('td:eq(6)') ).data(result['system_message']);
		selected_row_edit = '';
		highlight_invalid_rows();
	});
});
	

/* Approver Functions */
function use_modal_system_message(title,body,button){
	$('#modal_system_message .modal-title').empty();
	$('#modal_system_message .modal-body').empty();
	$('#modal_system_message .modal-footer').empty();
	var footer	 = button;
		footer  += '<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>';
	$('#modal_system_message .modal-title').append(title);
	$('#modal_system_message .modal-body').append(body);
	$('#modal_system_message .modal-footer').append(footer);
	$('#modal_system_message').modal('show');
}

$('#btn_approve_request').click(function(){
	var title  = 'Approve Request';
	var body   = '<div class="alert alert-success">';
		body  += '	<p><h4>Would you like to approve the request?</h4></p>';
		body  += '</div>';
	var button = '<button class="btn btn-success fa fa-thumbs-o-up" id="btn_confirm_approve"> Approve</button>';
	use_modal_system_message(title,body,button);
	$('#btn_confirm_approve').click(function(){
		get_email_contents_approved_request(function(result){
			var recipient 		= result['recipient'];
			var cc_recipient 	= result['cc'];
			// var cc_recipient 	= 'marlope@pricon.ph';
			var subject 		= 'OTKS straight hour request';
			var message 		= result['message'];
			send_mail(recipient,cc_recipient,subject,message);
		});
		update_main_status('2');
		var title  = 'Approve Request';
		var body   = '<div class="alert alert-success">';
			body  += '	<p><h4>Request has been approved!</h4></p>';
			body  += '</div>';
		var button = '';
		use_modal_system_message(title,body,button);
		window.location.reload();
	});
});


$('#btn_disapprove_request').click(function(){
	var title  = 'Approve Request';
	var body   = '<div class="alert alert-danger">';
		body  += '	<p><h4>Would you like to disapprove the request?</h4></p>';
		body  += '	<p><label class="label-control"><h4>Reason:</h4></label></p>';
		body  += '	<p><textarea class="form-control" id="txt_disapprove_remarks"></textarea></p>';
		body  += '</div>';
	var button = '<button class="btn btn-danger fa fa-thumbs-o-down" id="btn_confirm_disapprove"> Disapprove</button>';
	use_modal_system_message(title,body,button);
	$('#btn_confirm_disapprove').click(function(){
		var remarks = $('#txt_disapprove_remarks').val();
		if( remarks == ""){
			alert("Please add a reason for disapproval!");
			return false;
		}
		
		get_email_contents_disapproved_request(function(result){
			var recipient 		= result['recipient'];
			var cc_recipient 	= result['cc'];
			var subject 		= 'OTKS straight hour request';
			var message 		= result['message'];
			send_mail(recipient,cc_recipient,subject,message);
		});
		
		update_main_justification(remarks);
		update_main_status('3');
		var title  = 'Approve Request';
		var body   = '<div class="alert alert-danger">';
			body  += '	<p><h4>Request has been disapproved!</h4></p>';
			body  += '</div>';
		var button = '';
		use_modal_system_message(title,body,button);
		window.location.reload();
	});
});

function update_main_justification(remarks){
	var data = {
		"action"	: "update_main_justification",
		"pkid"		: main_pkid,
		"remarks"	: remarks,
		"username"	: username
	}
	call_ajax(data, handler, function(result){
		
	});
}

function get_email_contents_approved_request(callback){
	var data = {
		"action"  	: "get_email_contents_approved_request",
		"username" 	: username,
		"main_pkid"	: main_pkid
	}
	call_ajax(data, handler, function(result){
		callback(result);
	});
}

function get_email_contents_disapproved_request(callback){
	var data = {
		"action"  	: "get_email_contents_disapproved_request",
		"username" 	: username,
		"main_pkid"	: main_pkid
	}
	call_ajax(data, handler, function(result){
		callback(result);
	});
}

/* Adding straight hours one record  START */
$('#btn_add_employee').click(function(){
	$('#modal_add_each_employee').modal('show');
	populate_datalist();
});

$('#txt_add_employee_number').change(function(){
	var data = {
		"action"	: "load_employee_name_by_number",
		"emp_no"	: $(this).val()
	}
	call_ajax(data, handler, function(result){
		$('#txt_add_employee_name').val(result['emp_name']);
	});
});

$('#txt_add_employee_name').change(function(){
	var data = {
		"action"	: "load_employee_number_by_name",
		"emp_name"	: $(this).val()
	}
	call_ajax(data, handler, function(result){
		$('#txt_add_employee_number').val(result['emp_no']);
	});
});

$('#frm_add_employee').submit(function(e){
	e.preventDefault();
	append_straight_details_one_record( $(this).serialize() );
});

function append_straight_details_one_record(serialized_data){
	var data = {
		"action"			: "append_straight_details_one_record",
		"fkstraight_main"	: main_pkid,
		"username"			: username
	}
	call_ajax_serialize(data, serialized_data, handler, function(result){
		$('#container_error_message').empty();
		if(result['exist'] != '0'){
			var html  = '<div class="alert alert-danger">';
				html += '	<p><h4>Duplicate Straight Information:</h4></p>';
				html += '	<p>Empno : ' + result['empno'] + '</p>';
				html += '	<p>Employee Name : ' + result['emp_name'] + '</p>';
				html += '	<p>Date Time-In : ' + result['date_time_in'] + '</p>';
				html += '	<p>Date Time-In : ' + result['date_time_out'] + '</p>';
				html += '</div>';
			$('#container_error_message').append(html);
			return false;
		}
		$('#modal_add_each_employee').modal('hide');
		var exist = check_exist_on_table(result['empno'],result['date_time_in']);
		if(exist == 1){
			alert('Multiple entry for employee '+result['empno']);
		}else{
			oTable.row.add( [
				result['empno'],
				result['emp_name'],
				result['date_time_in'],
				result['date_time_out'],
				result['hours_consumed'],
				result['remarks'],
				result['system_message'],
				'<center><button class="btn btn-edit fa fa-edit" value="0" style="display:none;"></button></center><center><button class="btn btn-danger fa fa-remove" value="0"></button></center>'
			] ).draw( false );
		}
		highlight_invalid_rows();
	});
}

/* pupulate data list */
function populate_datalist(){
	var data = {
		"action"	: "load_hris_record_all"
	}
	call_ajax_serialize( data, $(this).serialize(), handler, function(result){
		$('#txt_add_employee_number_list').empty();
		$('#txt_add_employee_name_list').empty();
		for(x=0;x<result['ctr'];x++){
			$('#txt_add_employee_number_list').append('<option>'+result['EmpNo'][x]+'</option>');
			$('#txt_add_employee_name_list').append('<option>'+result['lastname'][x]+', '+result['firstname'][x]+'</option>');
		}
	});
}

/* Adding straight hours 1 by 1  END */


</script>
