<input type="hidden" id="hd_username" value="<?php echo $username; ?>"> 
<!--Main Container-->
<div id="row main_container" style="margin-top:20px;">
	<div class="col-sm-10 col-sm-offset-1">
		<div class="panel panel-success">
	  		<div class="panel-heading">Summary of Straight Requests</div>
	  		<div class="panel-body">
				<div id="row">
					<div class="col-sm-10">
						
					</div>
					<div class="col-sm-2 overtime_main_button" style="padding:20px;">
						<button class="btn btn-primary btn-md fa fa-users" id="btn_add_batch_employee"> Add Employee</button>
					</div>
				</div>
				<div id="container_table_overtime_summary">
					<table class="table table-bordered table-striped" id="tbl_straight_main">
						<thead>
							<tr>
								<th>Employee Number</th>
								<th>Employee Name</th>
								<th>Date / Time In</th>
								<th>Date / Time Out</th>
								<th>Straight Date</th>
								<th>Hours Consumed</th>
								<th>Remarks</th>
								<th>System Comment</th>
								<th>Action</th>
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
						<label style="width:150px;">Date In: </label><input type="date" class="form-control" id="txt_batch_date_in" required>
						<label style="width:150px;">Date Out: </label><input type="date" class="form-control" id="txt_batch_date_out" required>
						<label style="width:150px;">Filed Straight: </label><input type="number" class="form-control" id="txt_batch_filled_overtime" min="0.5" step="0.5" required>
					</div>
					<div class="col-sm-6">
						<label style="width:150px;">Time In: </label><input type="time" class="form-control" id="txt_batch_time_in" required>
						<label style="width:150px;">Time Out: </label><input type="time" class="form-control" id="txt_batch_time_out" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<label style="width:150px;">Remarks: </label><input type="text" class="form-control" id="txt_batch_remarks">
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
<div class="modal fade" tabindex="-1" role="dialog" id="modal_update_employee_overtime">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><span class="fa fa-users"></span> Update Employee Overtime</h4>
      </div>
      <div class="modal-body">
        <div class="row">
	       	<div class="col-sm-12">
				<div class="row">
					<form id="frm-employee-update" method="post">
					<div class="col-sm-12">
						<label style="width:150px;">Date: </label><input type="date" class="form-control" id="txt_update_employee_date" name="txt_add_employee_date" required>
						<label style="width:150px;">Employee Number: </label><input type="text" class="form-control" id="txt_update_employee_number" name="txt_add_employee_number" readonly required>
						<label style="width:150px;">Employee Name: </label><input type="text" class="form-control" id="txt_update_employee_name" name="txt_add_employee_name" readonly required>
						<label style="width:150px;">Filed Overtime: </label><input type="number" class="form-control" id="txt_update_employee_filled_overtime" name="txt_add_employee_filled_overtime" min="0.5" step="0.5" required>
						<label style="width:150px;">Remarks: </label><input type="text" class="form-control" id="txt_update_employee_remarks" name="txt_add_employee_remarks">
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

<script src="../../../common_functions/common_functions.js"></script>

<script>

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
		var html  = '<table id="'+tbl_employee_list+'">';
			html += '	<thead>';
			html += '		<tr>';
			// html += '			<th></th>';
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
</script>