<?php
session_start();
$user_type = $_SESSION['user_type'];
?>
<input type="hidden" id="hd_username" value="<?php echo $username; ?>"> 
<!--Main Container-->
<div id="row main_container" style="margin-top:20px;">
	<div class="col-sm-12">
		<div class="panel panel-success">
	  		<div class="panel-heading"><h3><span class="fa fa-calendar-check-o"></span> Straight Hours Request Summary</h3></div>
	  		<div class="panel-body">
				<div id="row">
					<div class="col-sm-4">
						<button class="btn btn-default btn-md fa fa-home" id="btn_home"> Home</button>
					</div>
					<div class="col-sm-8">
						<p style="text-align:right;padding-bottom:20px;">
						<button class="btn btn-default btn-md fa fa-file-pdf-o" id="btn_download"> User Manual</button>
						<button class="btn btn-primary btn-md fa fa-gear" id="btn_manage_batch"> Manage Batch</button>
						<?php
							if($user_type == 0){
								echo '<button class="btn btn-primary btn-md fa fa-plus" id="btn_new_straight_request"> New Request</button>';
							}
						?>
						</p>
					</div>
					<div class="col-sm-12" id="container_table_overtime_summary">
						<table class="table table-bordered table-striped" id="tbl_straight_main">
							<thead>
								<tr>
									<th>Status</th>
									<th>Date Requested</th>
									<th>Date of Straight Hours</th>
									<th>Manpower</th>
									<th>Justification</th>
									<?php
										if($user_type == 0){
											echo '<th>Edit Details</th>';
										}
										if($user_type == 1){
											echo '<th>View Details</th>';
										}
									?>								
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
</div>

<datalist id="txt_approver_list">
</datalist>
<!-- Modal new overtime request form -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_new_straight_request">
  <div class="modal-dialog" style="width:800px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">New Straight Request</h4>
      </div>
      <form id="frm_new_straight_request" method="post">
       <div class="modal-body">
		
			<div class="row panel panel-default" id="2nd_row_textbox">
				<div class="col-sm-6" style="margin-top:20px;">
					<div class="form-inline" style="padding-right:0px;">
						<div style="padding:2px;">
							<label style="width:150px;">Request Date:</label>
							<input type="date" class="form-control" name="txt_request_date" id="txt_request_date" disabled required>
						</div>
						<div style="padding:2px;">
							<label style="width:150px;">Manpower Involved:</label>
							<input type="number" style="width:51.5%;" class="form-control" name="txt_manpower_involved" id="txt_manpower_involved" min=1 required>
						</div>
						<div style="padding:2px;">
							<label style="width:150px;">Date From:</label>
							<input type="text" style="width:51.5%;" class="form-control datepicker" name="txt_date_from" id="txt_date_from" required readonly>
						</div>
						<div style="padding:2px;">
							<label style="width:150px;">Date To:</label>
							<input type="text" style="width:51.5%;" class="form-control datepicker" name="txt_date_to" id="txt_date_to" min="<?php echo date('Y-m-d'); ?>" required readonly>
						</div>
					</div>
				</div>
				<div class="col-sm-6" style="margin-top:20px;">
					<div class="form-inline" style="padding-right:0px;">
						<div style="padding:2px;">
							<label style="width:150px;">Request By:</label>
							<input type="text" style="width:57%;" class="form-control" name="txt_requested_by" id="txt_requested_by" required readonly>
						</div>
						<div style="padding:2px;">
								<label style="width:150px;">Division:</label>
							<input type="text" style="width:57%;" class="form-control" name="txt_division" id="txt_division" required readonly>
						</div>
						<div style="padding:2px;">
							<label style="width:150px;">Department:</label>
							<input type="text" style="width:57%;" class="form-control" name="txt_department" id="txt_department" required readonly>
						</div>
						<div style="padding:2px;">
							<label style="width:150px;">Approver:</label>
							<select data-placeholder="Select Approver" class="chosen-select"  name="txt_approver" id="txt_approver" style="margin:3px;">
								<option value=''></option>
							</select>
						</div>
					</div>
				</div>
				<div class="col-sm-12" style="margin-top:2px;">
					<div class="form-inline" style="padding-right:0px;">
						<label style="width:152px;">Justification:</label>
						<textarea name ="txt_justification" id="txt_justification" class="form-control" style="width: 79%;" required></textarea>
					</div>
				</div>
			</div>
        </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary fa fa-save"> Save</button>
        <button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal edit overtime request form -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_edit_straight_request">
  <div class="modal-dialog" style="width:800px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Overtime Request</h4>
      </div>
      <form id="frm_edit_straight_request" method="post"> 
       <div class="modal-body">
        <div id="row" style="padding:0px;">
			<div class="row panel panel-default" id="2nd_row_textbox">
				<div class="col-sm-6" style="margin-top:20px;">
					<div class="form-inline" style="padding-right:0px;">
						<div style="padding:2px;">
							<label style="width:150px;">Request Date:</label>
							<input type="date" class="form-control" name="txt_request_date_edit" id="txt_request_date_edit" disabled required>
						</div>
						<div style="padding:2px;">
							<label style="width:150px;">Manpower Involved:</label>
							<input type="number" style="width:51.5%;" class="form-control" name="txt_manpower_involved_edit" id="txt_manpower_involved_edit" min=1 required>
						</div>
						<div style="padding:2px;">
							<label style="width:150px;">Date From:</label>
							<input type="date" style="width:51.5%;" class="form-control" name="txt_date_from_edit" id="txt_date_from_edit" min="<?php echo date('Y-m-d'); ?>" required>
						</div>
						<div style="padding:2px;">
							<label style="width:150px;">Date To:</label>
							<input type="date" style="width:51.5%;" class="form-control" name="txt_date_to_edit" id="txt_date_to_edit" min="<?php echo date('Y-m-d'); ?>" required>
						</div>
					</div>
				</div>
				<div class="col-sm-6" style="margin-top:20px;">
					<div class="form-inline" style="padding-right:0px;">
						<div style="padding:2px;">
							<label style="width:150px;">Request By:</label>
							<input type="text" style="width:57%;" class="form-control" name="txt_requested_by_edit" id="txt_requested_by_edit" required readonly>
						</div>
						<div style="padding:2px;">
								<label style="width:150px;">Division:</label>
							<input type="text" style="width:57%;" class="form-control" name="txt_division_edit" id="txt_division_edit" required readonly>
						</div>
						<div style="padding:2px;">
							<label style="width:150px;">Department:</label>
							<input type="text" style="width:57%;" class="form-control" name="txt_department_edit" id="txt_department_edit" required readonly>
						</div>
						<datalist id="txt_approver_edit_list">
						</datalist>
						<div style="padding:2px;">
							<label style="width:150px;">Approver:</label>
							<!-- <input type="text" style="width:57%;" class="form-control" list="txt_approver_list" name="txt_approver_edit" id="txt_approver_edit" required> -->
							<select data-placeholder="Select Approver" class="chosen-select"  name="txt_approver_edit" id="txt_approver_edit" style="margin:3px;">
								<option value=''></option>
							</select>
						</div>
					</div>
				</div>
				<div class="col-sm-12" style="margin-top:2px;">
					<div class="form-inline" style="padding-right:0px;">
						<label style="width:152px;">Justification:</label>
						<textarea id="txt_justification_edit" name="txt_justification_edit" class="form-control" style="width: 79%;" required></textarea>
					</div>
				</div>
			</div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary fa fa-save" id="btn_update_request"> Update</button>
        <button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal manage batch -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_manage_batch">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><span class="fa fa-user"> Manage Batch</span></h4>
      </div>
      <div class="modal-body">
        <div style="margin-bottom:50px;">
			<button class="btn btn-primary fa fa-user-plus pull-right" id="btn_show_add_new"> Add New Employee</button>
		</div>
		<div id="container_add_batch">
			<div class="row">
				<div class="col-sm-6">
					<datalist id="list_empno"></datalist>
					<label class="control-label">Employee Number</label>
					<input type="text" class="form-control" id="txt_add_batch_empno" list="list_empno">
				</div>
				<div class="col-sm-6">
					<datalist id="list_empname"></datalist>
					<label class="control-label">Employee Name</label>
					<input type="text" class="form-control" id="txt_add_batch_empname" list="list_empname">
				</div>
				<div class="pull-right" style="margin-bottom:10px;margin-top:20px;padding-right:15px;">
					<button class="btn btn-success fa fa-save" id="btn_save_batch"> Add to batch</button>
					<hr>
				</div>
			</div>
		</div>
		<div id="container_table_batch">
			<table class="table" id="tbl_batch">
				<thead>
					<tr>
						<th>Empno</th>
						<th>Employee Name</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
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

<!-- Modal system message -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_system_message2">
  <div class="modal-dialog">
    <div class="modal-content">
      
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script src="./functions/common_functions.js"></script>
<script>
var handler = './handler/handler.php';
var username = $('#hd_username').val();
var date_today = "<?php echo date('Y-m-d'); ?>";
var user_type  = "<?php echo $user_type; ?>";

/* date picker */
$('.datepicker').datepicker({
	changeMonth: true,
	changeYear: true
});
$('.datepicker').datepicker("option", "dateFormat", "yy-mm-dd");
$('.datepicker').attr("style", "background-color:white;");

//$('document').ready(function(){
if(user_type == 0){
	var oTable = $('#tbl_straight_main').DataTable({
					"bProcessing": true,
					"bServerSide": true,
					"sAjaxSource": "./server_side_scripts/straight_main.php?username="+username
				 });
}

if(user_type == 1){
	var oTable = $('#tbl_straight_main').DataTable({
					"bProcessing": true,
					"bServerSide": true,
					"sAjaxSource": "./server_side_scripts/approver_straight_main.php?username="+username
				 });
}
//});

/* SUBMIT FUNCTIONS */
$('#frm_new_straight_request').submit(function(e){
	e.preventDefault();
	var serialized_data = $(this).serialize();
	
	// validate_save_main_record(function(result){
		// if(result['valid'] == 0){
			// return false;
		// }
		save_main_record(serialized_data);
	// });
	
});

/* CLICK FUNCTIONS */
$('#btn_new_straight_request').click(function(){
    load_approver_list('txt_approver',function () {
		$('.chosen-select#txt_approver').chosen({width:"57%"});
		minus_one_day('txt_date_from');

		$('#modal_new_straight_request').modal('show');
	});
});

function minus_one_day(txt_date_from){
    var data = {
		"action" 	: "minus_one_day",
        "date"      : date_today
	} 
	call_ajax(data, handler, function(result){
        $('#'+txt_date_from).attr({
            "min"   : result['new_date']
        });
	});
}
    
$('#btn_new_straight_request').click(function(){
	load_approver_list('txt_approver_list',function () {
		load_employee_information('txt_requested_by','txt_division','txt_department','txt_request_date');
		$('#txt_request_date').val(date_today);
		$('#modal_new_straight_request').modal('show');
	});
});

function load_approver_list(txt_approver_list,callback){
	$('#'+txt_approver_list).empty();
	var data = {
		"action" 	: "load_approver_list"
	} 
	call_ajax(data, handler, function(result){
		$('#'+txt_approver_list).append('<option></option>');
		for(var i=0; i<result['ctr'];i++) {
			$('#'+txt_approver_list).append('<option value="'+result['username'][i]+'">'+result['approver_name'][i]+'</option>');
		}
		callback();
	});
}

function load_approver_list_all(txt_approver_list,callback){
	$('#'+txt_approver_list).empty();
	var data = {
		"action" 	: "load_approver_list_all"
	} 
	call_ajax(data, handler, function(result){
		$('#'+txt_approver_list).append('<option></option>');
		for(var i=0; i<result['ctr'];i++) {
			$('#'+txt_approver_list).append('<option value="'+result['username'][i]+'">'+result['approver_name'][i]+'</option>');
		}
		callback();
	});
}

function load_employee_information(txt_requested_by,txt_division,txt_department,txt_request_date){
	var data = {
		"action" 	: "load_hris_record_by_username",
		"username"	: username
	} 
	call_ajax(data, handler, function(result){
		$('#'+txt_requested_by).val(result['lastname']+', '+result['firstname']+' '+result['middlename']);
		$('#'+txt_division).val(result['Division']);
		$('#'+txt_department).val(result['Department']);
		/* Add a date today */
	});
}

$('#tbl_straight_main tbody').on('dblclick','tr',function(){
	var pkid = $(this).find('.btn-warning').val();
	generate_form_submit(pkid);
});
$('#tbl_straight_main tbody').on('click','tr', function(){
	$('#tbl_straight_main tbody tr').attr('style','');
	$(this).attr('style','background:teal;color:white;');
});
	
var pkid_edit = 0;
function modal_edit_straight_modal(pkid){
	var data = {
		"action"	: "fetch_main_data_update",
		"pkid"		: pkid
	}
	pkid_edit = pkid;
	call_ajax(data,handler,function(result){
		$('#txt_request_date_edit').val(result['req_date']['0']);
		$('#txt_manpower_involved_edit').val(result['manpower']['0']);
		$('#txt_date_from_edit').val(result['date_from']['0']);
		$('#txt_date_to_edit').val(result['date_to']['0']);
		$('#txt_requested_by_edit').val(result['created_by']['0']);
		$('#txt_division_edit').val('');
		$('#txt_department_edit').val('');
		load_approver_list_all('txt_approver_edit',function () {
			$('.chosen-select#txt_approver_edit').chosen({width:"57%"});
			$('#txt_approver_edit').val(result['approver']['0']).trigger('chosen:updated');
		});
		$('#txt_justification_edit').val(result['justification']['0']);
		load_employee_information('txt_requested_by_edit','txt_division_edit','txt_department_edit','txt_request_date_edit');
		if(result['status']['0'] == 0 || result['status']['0'] == 1) {
			$('#btn_update_request').show();
			$('#txt_approver_edit').prop('disabled', false).trigger("chosen:updated");
		} else {
			$('#btn_update_request').hide();
			$('#txt_approver_edit').prop('disabled', true).trigger("chosen:updated");
		}
		$('#modal_edit_straight_request').modal('show');
	});
}

function validate_save_main_record(callback){
	call_ajax("action=check_past_dates&date="+$('#txt_date_from').val(),handler, function(result){
		callback(result);
	});
}

function save_main_record(serialized_data){
	var approver = get_datalist_text($('#txt_approver').val());
	var data = {
		"action"	: "save_straight_main_information",
		"username"	: username,
		"approver"	: approver
	}
	
	if(username == ""){
		alert("Session expired please relogin!");
		return false;
	}
	call_ajax_serialize(data, serialized_data, handler, function(result){
		oTable.draw(false);
		$('#modal_new_straight_request').modal('hide');
		generate_form_submit(result['max_pkid']);
	});
}

$('#frm_edit_straight_request').submit(function(e){
	e.preventDefault();
	var serialized_data = $(this).serialize();
	update_main_record(serialized_data);
});
	
function update_main_record(serialized_data){
	var approver = ($('#txt_approver_edit').val());
	var data = {
		"action"	: "update_straight_main_information",
		"username"	: username,
		"pkid"		: pkid_edit,
		"approver"	: approver
	}
	if(username == ""){
		alert("Session expired please relogin!");
		return false;
	}
	call_ajax_serialize(data, serialized_data, handler, function(result){
		oTable.draw(false);
		$('#modal_edit_straight_request').modal('hide');
	});
}
	
function get_datalist_text(value_of_datalist){
	var option_text = '';
	$('#txt_approver_list option').each(function(){
		if($(this).val() == value_of_datalist){
			option_text = $(this).text();
		}
	});
	return option_text;
}
	
function get_datalist_value(text_of_datalist){
	var option_val = '';
	$('#txt_approver_list option').each(function(){
		if($(this).text() == text_of_datalist){
			option_val = $(this).val();
		}
	});
	return option_val;
}

$('#tbl_straight_main tbody').on('click',' tr .fa-edit',function(){
	// var pkid = $(this).find('.btn-warning').val();
	var pkid = $(this).val();
	var status = $(this).closest('tr').find('td:eq(0)').text();
	// if(status != 'For Edit'){
		// alert('Request is already '+ status +' status! Cannot edit content!');
		// return false;
	// }
	load_approver_list('txt_approver_list',function () {
        minus_one_day('txt_date_from_edit');
		modal_edit_straight_modal(pkid);
	});
});

$('#tbl_straight_main tbody').on('click',' tr .fa-remove',function(){
	var pkid = $(this).val();
	modal_cancel_request_show(pkid);
});

function generate_form_submit(pkid){
	var data = {
		"action"	: "generate_form_submit",
		"pkid"		: pkid
	}
	
	call_ajax(data, handler, function(result){
		$('body').append(result['html']);
		$('#frm-submit-details').submit();
	});
}
	
function modal_cancel_request_show(pkid){
	$('#modal_system_message .modal-title').empty();
	$('#modal_system_message .modal-body').empty();
	$('#modal_system_message .modal-footer').empty();
	
	var title = 'Cancel Request';
	$('#modal_system_message .modal-title').append(title);
	
	var body  = '<div class="alert alert-danger">';
		body += '	<p><h4>Warning! You are about to cancel a request.</h4></p>';
		body += '	<p><label class="control-label"><b>Reason</b></label><textarea class="form-control" id="txt_cancellation_remarks"></textarea></p>';
		body += '</div>';
	
	$('#modal_system_message .modal-body').append(body);
	var buttons = '<button type="submit" class="btn btn-danger fa fa-trash" id="btn_cancel_request"> Cancel Request</button><button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>';
	$('#modal_system_message .modal-footer').append(buttons);
	$('#modal_system_message').modal('show');
	
	$('#btn_cancel_request').click(function(){
		var cancellation_remarks = $('#txt_cancellation_remarks').val();
		if(cancellation_remarks == ''){
			alert("Please state your reason for cancellation!");
			return false;
		}
		cancel_request(pkid,cancellation_remarks);
	});
}
	
function cancel_request(pkid,cancellation_remarks){
	var data ={
		"action"	: "cancel_main_request",
		"pkid"		: pkid,
		"remarks" 	: cancellation_remarks
	}
	
	call_ajax(data, handler, function(result){
		$('#modal_system_message .modal-body').empty();
		$('#modal_system_message .modal-footer').empty();
		var body = '<div class="alert alert-success"><p><h4>Request has been cancelled!</h4></p></div>';
		$('#modal_system_message .modal-body').append(body);
		var buttons = '<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>';
		$('#modal_system_message .modal-footer').append(buttons);
		oTable.draw(false);
	});
}

	/* MANAGE BATCH START*/
	/*  Load datatable server side script  */
	oTable_batch_list = $('#tbl_batch').DataTable({
		"aaSorting"	 : [],			
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "./server_side_scripts/manage_batch_list_datatable.php?username="+username
	});
	
	$('#btn_home').click(function() {
		if(user_type == 0){
			window.location.href = '../../otks_main/otks_dashboard/index_requestor.php';
		} else if(user_type == 1){
			window.location.href = '../../otks_main/otks_dashboard/index_approver.php';
		}
		
	});
	$('#btn_download').click(function(){
		window.open('pages/manual_viewer.php','_blank');
	});
	$('#btn_manage_batch').click(function(){
		$('#container_add_batch').hide();
		$('#btn_show_add_new').text(' Add New Employee');
		$('#modal_manage_batch').modal('show');
	});
	
	$('#btn_show_add_new').click(function(){
		var button_text = $(this).text();
		populate_datalist();
		if(button_text == " Add New Employee"){
			$('#container_add_batch').toggle(200);
			$(this).text(' Done Adding Batch');
		}else{
			$('#container_add_batch').toggle(200);
			$(this).text(' Add New Employee');
		}		
	});
	
	$('#btn_save_batch').click(function(){
		var data = {
			"action"	: "save_batch_employee",
			"emp_no"	: $('#txt_add_batch_empno').val(),
			"username"	: username
		}
		call_ajax(data, handler, function(result){
			if(result['invalid']){
				alert(result['msg']);
			}
			oTable_batch_list.ajax.reload();
			$('#txt_add_batch_empno').val('');
			$('#txt_add_batch_empname').val('');
		});
	});
	
	$('#tbl_batch tbody').on('click','tr #btn_remove_batch', function(){
		var empno 	= $(this).closest('tr').find('td:eq(0)').text();
		var empname = $(this).closest('tr').find('td:eq(1)').text();
		if( !confirm("You are about to remove: \n EmpNo: "+empno+" \n Employee Name: "+empname) ){
			return false;
		}
		var data = {
			"action"	: "delete_batch_employee",
			"pkid"		: $(this).val(),
			"username"	: username
		}
		call_ajax(data, handler, function(result){
			oTable_batch_list.ajax.reload();
		});
	});
	
	$('#txt_add_batch_empno').change(function(){
		var data = {
			"action"	: "load_employee_name_by_number",
			"emp_no"	: $(this).val()
		}
		call_ajax(data, handler, function(result){
			$('#txt_add_batch_empname').val(result['emp_name']);
		});
	});
	
	$('#txt_add_batch_empname').change(function(){
		var data = {
			"action"	: "load_employee_number_by_name",
			"emp_name"	: $(this).val()
		}
		call_ajax(data, handler, function(result){
			$('#txt_add_batch_empno').val(result['emp_no']);
		});
	});
	
	/* pupulate data list */
	function populate_datalist(){
		var data = {
			"action"	: "load_hris_record_all"
		}
		call_ajax(data, handler, function(result){
			$('#list_empno').empty();
			$('#list_empname').empty();
			for(x=0;x<result['ctr'];x++){
				$('#list_empno').append('<option>'+result['EmpNo'][x]+'</option>');
				$('#list_empname').append('<option>'+result['lastname'][x]+', '+result['firstname'][x]+'</option>');
			}
		});
	}

	/* MANAGE BATCH END */
	
</script>