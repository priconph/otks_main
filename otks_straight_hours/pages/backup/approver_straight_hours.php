<?php
$pkid_main = $_POST['pkid'];
?>

<input type="hidden" id="hd_main_pkid" value="<?php echo $pkid_main; ?>">
<input type="hidden" id="hd_username" value="<?php echo $username; ?>">

<!--Main Container-->
<div id="row main_container" style="margin-top:20px;">
	<div class="col-sm-10 col-sm-offset-1">
		<div class="panel panel-success">
	  		<div class="panel-heading">Summary of Straight Requests</div>
	  		<div class="panel-body">
				<div id="row">
					<div class="col-sm-6">
						
					</div>
					<div class="col-sm-6 overtime_main_button" style="padding:20px;">
						<button class="btn btn-primary btn-md fa fa-users" id="btn_add_batch_employee"> Add Employee</button>
						<button class="btn btn-primary btn-md fa fa-save" id="btn_save_draft"> Save/Draft</button>
						<button class="btn btn-primary btn-md fa fa-envelope-o" id="btn_save_send"> Save/Send</button>
						<a href="./index_requestor.php?page=requestor_main.php"><button class="btn btn-primary btn-md fa fa-close"> Close</button></a>
					</div>
				</div>
				<div id="container_table_straight_summary">
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
								<th>Edit Request</th>
								<th>Cancel Request</th>
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
						<label style="width:150px;">Date In: </label><input type="date" class="form-control" name="txt_batch_date_in" id="txt_batch_date_in" required>
						<label style="width:150px;">Date Out: </label><input type="date" class="form-control" name="txt_batch_date_out" id="txt_batch_date_out" required>
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
        <button type="submit" class="btn btn-success fa fa-save" id="btn_save_batch">Save</button>
        <button type="button" class="btn btn-default fa fa-close" data-dismiss="modal">Close</button>
					</form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal update filed OT -->
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
							<label >Date In: </label><input type="date" class="form-control" id="txt_update_employee_date_in" name="txt_update_employee_date_in" required>
							<label >Date Out: </label><input type="date" class="form-control" id="txt_update_employee_date_out" name="txt_update_employee_date_out" required>
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

<script src="./functions/common_functions.js"></script>

<script>

var tbl_straight_hours_details = 'tbl_straight_hours_details';
var tbl_employee_list 	   = 'tbl_employee_list';
var handler = './handler/handler.php';

var fullname	= '';
var section 	= '';
var department 	= '';
var division 	= '';
var min_date    = '';
var max_date    = '';
var ot_type    = '';
var tbl_row    = '';
var username = $('#hd_username').val();
var main_pkid = $('#hd_main_pkid').val();

/* Arrays */
var array_batch_employee = [];
var array_batch_employee_name = [];
var array_table_validate = {};
	array_table_validate.emp_no = [];
	array_table_validate.emp_name = [];
	array_table_validate.date_time_in = [];
	array_table_validate.date_time_out = [];
	array_table_validate.date_ot = [];
	array_table_validate.ot = [];
	array_table_validate.remarks = [];
	array_table_validate.msg = [];
	array_table_validate.fkid = [];
var validate_exist = 0;
var duplicate_rec = '';	

load_employee_information();

//var oTable = $('#'+tbl_straight_hours_details).DataTable({
//				"bProcessing": true,
//				"bServerSide": true,
//				"sAjaxSource": "./server_side_scripts/straight_details.php?username=" + username + "&fkstraight_main="+main_pkid,
//				"initComplete": function() {
//					highlight_invalid_rows();
//				},"drawCallback": function() {
//					highlight_invalid_rows();
//				}
//			  });

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
	load_employee_via_section();
});	

$('#frm-batch-employee-add').submit(function(e){
//	display_array_value();
	e.preventDefault();
	var serialized_data = $(this).serialize();
	append_straight_details(serialized_data);
});

load_straight_details();

function load_straight_details(){
	var data = {
		"action"			: "load_straight_details",
		"fkstraight_main"	: main_pkid
	}
	call_ajax(data, handler, function(result){
		for(x=0;x<result['empno'].length;x++){
			oTable.row.add( [
				result['empno'][x],
				result['LastName'][x]+', '+result['FirstName'][x],
				result['date_from'][x]+' '+result['time_from'][x],
				result['date_to'][x]+' '+result['time_to'][x],
				result['hours_consumed'][x],
				result['remarks'][x],
				result['system_comment'][x],
				'<center><button class="btn btn-warning fa fa-edit" value="'+result['pkid'][x]+'"></button></center>',
				'<center><button class="btn btn-danger fa fa-remove" value="'+result['pkid'][x]+'"></button></center>'
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
		for(x=0;x<result['existing_records']['empno'].length;x++){
			html += '		<tr>';				
			html += '			<td>'+result['existing_records']['empno'][x]+'</td>';				
			html += '			<td>'+result['existing_records']['emp_name'][x]+'</td>';				
			html += '			<td>'+result['existing_records']['date_time_in'][x]+'</td>';				
			html += '			<td>'+result['existing_records']['date_time_out'][x]+'</td>';				
			html += '		</tr>';				
		}
			html += '	</tbody>';
			html += '</table>';
			
		if(result['existing_records']['empno'].length != 0){
			$('#modal_system_message .modal-title').empty();
			$('#modal_system_message .modal-body').empty();
			$('#modal_system_message .modal-footer').empty();
			$('#modal_system_message .modal-title').append('Existing Records');
			$('#modal_system_message .modal-body').append(html);
			$('#modal_system_message .modal-footer').append('<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>');
			$('#modal_system_message').modal('show');
		}
		
		for(x=0;x<result['records']['empno'].length;x++){
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
					'<center><button class="btn btn-edit fa fa-edit" value="0"></button></center>',
					'<center><button class="btn btn-danger fa fa-remove" value="0"></button></center>'
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
	alert('Record Saved!');
});
	
$('#btn_save_send').click(function(){
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
		update_main_status();
		get_email_contents(function(result){
			var recipient 		= 'marlope@pricon.ph';
			var cc_recipient 	= result['cc'];
			var subject 		= 'OTKS straight hour request';
			var message 		= result['message'];
			send_mail(recipient,cc_recipient,subject,message);
			alert('Record Saved! Mail sent to approver!');
		});
	});
});
	
function update_main_status(){
	var data = {
		"action"	: "update_main_status",
		"main_pkid"	: main_pkid
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
		var pkid = $(this).find('td:eq(7) .fa-edit').val();
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
//		alert(result['result']);
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
	update_straight_details_confirmation_modal(pkid);
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
		});
	});
}
	
var selected_row_edit = '';
$('#' + tbl_straight_hours_details + ' tbody').on('click','tr .fa-edit', function(){
	var selected_row = $(this).closest('tr');
		selected_row_edit = selected_row;
		
		update_newly_added_straight(selected_row);
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
	
</script>
