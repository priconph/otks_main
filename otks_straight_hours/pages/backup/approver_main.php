<input type="hidden" id="hd_username" value="<?php echo $username; ?>"> 
<!--Main Container-->
<div id="row main_container" style="margin-top:20px;">
	<div class="col-sm-10 col-sm-offset-1">
		<div class="panel panel-success">
	  		<div class="panel-heading">Summary of Overtime Requests</div>
	  		<div class="panel-body">
				<div id="row">
					<div class="col-sm-10">
						
					</div>
					<div class="col-sm-2 overtime_main_button" style="padding:20px;">
						
					</div>
				</div>
				<div id="container_table_overtime_summary">
					<table class="table table-bordered table-striped" id="tbl_straight_main">
						<thead>
							<tr>
								<th>Status</th>
								<th>Date Requested</th>
								<th>Date of Straight Hours</th>
								<th>Manpower</th>
								<th>Justification</th>
								<th>Edit Details</th>
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
        <div id="row" style="padding:0px;">
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
							<input type="date" style="width:51.5%;" class="form-control" name="txt_date_from" id="txt_date_from" max="<?php echo date('Y-m-d'); ?>" required>
						</div>
						<div style="padding:2px;">
							<label style="width:150px;">Date To:</label>
							<input type="date" style="width:51.5%;" class="form-control" name="txt_date_to" id="txt_date_to" required >
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
							<input type="text" style="width:57%;" class="form-control" list="txt_approver_list" name="txt_approver" id="txt_approver" autocomplete="off" required>
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
							<input type="date" style="width:51.5%;" class="form-control" name="txt_date_from_edit" id="txt_date_from_edit" max="<?php echo date('Y-m-d'); ?>" required>
						</div>
						<div style="padding:2px;">
							<label style="width:150px;">Date To:</label>
							<input type="date" style="width:51.5%;" class="form-control" name="txt_date_to_edit" id="txt_date_to_edit" required >
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
							<input type="text" style="width:57%;" class="form-control" list="txt_approver_list" name="txt_approver_edit" id="txt_approver_edit" required>
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
        <button type="submit" class="btn btn-primary fa fa-save"> Update</button>
        <button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
      </div>
      </form>
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

//$('document').ready(function(){
var oTable = $('#tbl_straight_main').DataTable({
				"bProcessing": true,
				"bServerSide": true,
				"sAjaxSource": "./server_side_scripts/approver_straight_main.php?username="+username
			 });
	
//});

/* SUBMIT FUNCTIONS */
$('#frm_new_straight_request').submit(function(e){
	e.preventDefault();
	var serialized_data = $(this).serialize();
	save_main_record(serialized_data);
});

/* CLICK FUNCTIONS */
$('#btn_new_straight_request').click(function(){
	$('#modal_new_straight_request').modal('show');
});

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
		for(var i=0; i<result['ctr'];i++) {
			$('#'+txt_approver_list).append('<option value="'+result['approver_name'][i]+'">'+result['username'][i]+'</option>');
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
	load_approver_list('txt_approver_list',function () {
		modal_edit_straight_modal(pkid);
	});	
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
		var approver = get_datalist_value(result['approver']['0']);
		$('#txt_approver_edit').val(approver);
		$('#txt_justification_edit').val(result['justification']['0']);
		load_employee_information('txt_requested_by_edit','txt_division_edit','txt_department_edit','txt_request_date_edit');
		
		$('#modal_edit_straight_request').modal('show');
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
	});
}

$('#frm_edit_straight_request').submit(function(e){
	e.preventDefault();
	var serialized_data = $(this).serialize();
	update_main_record(serialized_data);
});
	
function update_main_record(serialized_data){
	var approver = get_datalist_text($('#txt_approver_edit').val());
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
	var data = {
		"action"	: "approver_generate_form_submit",
		"pkid"		: $(this).val()
	}
	call_ajax(data, handler, function(result){
		$('body').append(result['html']);
		$('#frm-submit-details').submit();
	});
});

$('#tbl_straight_main tbody').on('click',' tr .fa-remove',function(){
	var pkid = $(this).val();
	modal_cancel_request_show(pkid);
});
	
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
</script>