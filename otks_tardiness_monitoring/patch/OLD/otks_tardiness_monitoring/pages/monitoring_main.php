<input type="hidden" id="hd_username" value="<?php echo $username; ?>">
<!--Main Container-->
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  <div class="panel panel-default box box-info">
    <div class="panel-heading" role="tab" id="headingOne">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="color:blue;">
          <i class="fa fa-lightbulb-o"></i> Additional Information
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
      <div class="panel-body">
        <h5>
            <p>Use Manage Employees button to add / remove employees you want to monitor the attendance. <br></p>
            <p>System will depend on the set time of notification.</p>
        </h5> 
      </div>
    </div>	
   </div>	
</div>	
<div id="row main_container" style="margin-top:20px;width:100%">
	<form class="form-inline" action="#" id="">
      <div class="form-group" style="margin-left:5px;">
        <button type="button" class="btn btn-default fa fa-home" id="btn_home"> Home</button>
      </div>
      <div class="form-group" style="position:relative;float:right;padding-top:8px;">
        <button type="button" class="btn btn-default btn-md fa fa-download" id="btn_dl_user_manual"> User Manual</button>
        <button type="button" class="btn btn-primary fa fa-users" id="btn_manage_batch_main"> Manage Employees</button>
        <button type="button" style="margin-right:5px;" class="btn btn-success fa fa-clock-o" id="btn_set_time_main"> Set Time</button>
      </div>      
    </form>
        </div>
<div class="panel panel-success" style="margin-left:5px;margin-right:5px;">
    <div class="panel-heading">Employee Attendance</div>
    <div class="panel-body">
        <div id="row " style="width:100%">
            <form class="form-inline" action="#" id="frm_search_attendance">
              <div class="form-group">
                <label class="" for="txtStartDate">Start Date</label>
                <input type="date" class="form-control" id="txtStartDate" value="<?php echo date('Y-m-d'); ?>" name="txtStartDate" title="Start Date" required>
              </div>
              <div class="form-group">
                <label class="" for="txtEndDate">End Date</label>
                <input type="date" class="form-control" id="txtEndDate" value="<?php echo date('Y-m-d'); ?>" name = "txtEndDate" title="End Date" required>
                <label class="" for="">EN: </label>
              </div>
              <div class="form-group">
                <select data-placeholder="Select Employee Number" title="Add employee on Manage Employees button" id="txtEmpNo" style="width:100%; height:38px;">
                    <option value=''></option>
                </select>
              </div>
              <div class="form-group" style="position:relative;float:right;padding-top:8px;">
                <label class="" style="color:red;font-size:14px;padding-right:10px;">[Time] - Late</label>
                <label class="" style="color:blue;font-size:14px;">[Time] - Bus Late</label>
              </div>      
              <button type="submit" class="btn btn-primary" id="set_date_1"><span class="fa fa-calendar"></span> Search</button>
            </form>
        </div>
		
        <div id="">
            <table class="table" id="tblMain" border="1">
                <thead>
                    <tr>
                        <th>Inconsistency</th>
                        <th>Date IN</th>
                        <th>Time In</th>
                        <th>Mode IN</th>
                        <th>Date OUT</th>
                        <th>Time Out</th>
                        <th>Mode OUT</th>
                        <th>EN</th>
                        <th>Name</th>
<!--                        <th>Department</th>-->
                        <th>Position</th>
<!--                        <th>Section</th>-->
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal of Set Time -->
<div class="modal fade" tabindex="-1" role="dialog" id="mdl_set_time">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-clock-o"> Set Time</h4>
      </div>
      <form id="frm_set_time">
      <div class="modal-body">
        <div class="container-fluid">
            <div class="alert alert-success" role="alert" style="display:none;" id="div_message_set_time">			
		    </div>
            <div class="row" style="padding-top:2px;">
                <div class="col-sm-12">
                    <label style="padding-top:5px;">Considered Time of Late:</label>
                </div>                
            </div>
            <div class="row" style="padding-top:2px;">
                <div class="col-sm-3">
                    <label style="padding-top:10px;padding-left:10px;">Morning Shift:</label>
                </div>     
                <div class="col-sm-4">
                    <input type="time" class="form-control" style="width:100%;" min="07:00:00" max="11:45:00" name="late_morning_start" id="txt_late_morning_start" required>
                </div>    
                <div class="col-sm-1">
                    <label style="padding-top:10px;"> to </label>
                </div>     
                <div class="col-sm-4">
                    <input type="time" class="form-control" style="width:100%;" name="late_morning_end" id="txt_late_morning_end" disabled required>
                </div>                
            </div>
            <div class="row" style="padding-top:2px;">
                <div class="col-sm-3">
                    <label style="padding-top:10px;padding-left:10px;">Night Shift:</label>
                </div>     
                <div class="col-sm-4">
                    <input type="time" class="form-control" style="width:100%;" min="19:00:00" max="23:45:00" name="late_night_start" id="txt_late_night_start" required>
                </div>    
                <div class="col-sm-1">
                    <label style="padding-top:10px;"> to </label>
                </div>     
                <div class="col-sm-4">
                    <input type="time" class="form-control" style="width:100%;" name="late_night_end" id="txt_late_night_end" disabled required>
                </div>                
            </div>
            <div class="row" style="padding-top:2px;">
                <div class="col-sm-12">
                    <label style="padding-top:5px;">Notification will send everyday every:</label>
                </div>                
            </div>
            <div class="row" style="padding-top:2px;">
                <div class="col-sm-3">
                    <label style="padding-top:10px;padding-left:10px;">Morning Shift:</label>
                </div>     
                <div class="col-sm-9">
                    <input type="time" class="form-control" style="width:100%;" name="notification_morning" id="txt_notification_morning" disabled required>
                </div>             
            </div>
            <div class="row" style="padding-top:2px;">
                <div class="col-sm-3">
                    <label style="padding-top:10px;padding-left:10px;">Night Shift:</label>
                </div>     
                <div class="col-sm-9">
                    <input type="time" class="form-control" style="width:100%;" name="notification_night" id="txt_notification_night" required>
                </div>   
            </div>
            <div class="row" style="padding-top:2px;">
                <div class="col-sm-12">
                    <label style="padding-top:5px;">Carbon copy email to:</label>
                </div>                
            </div>
            <div class="row" style="padding-top:2px;">
                <div class="col-sm-3">
                    <label style="padding-top:10px;padding-left:10px;">Recipients:</label>
                </div>     
                <div class="col-sm-9">
                    <select data-placeholder="Select Recipients" multiple class="chosen-select" name="send_to" id="cmb_send_to">
                        <option value=''></option>
                    </select>
                </div>             
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success fa fa-save" id="btn_save"> Save changes</button>
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
					<input type="text" class="form-control" id="txt_add_batch_empno" style="text-transform:uppercase" list="list_empno">
				</div>
				<div class="col-sm-6">
					<datalist id="list_empname"></datalist>
					<label class="control-label">Employee Name</label>
					<input type="text" class="form-control" id="txt_add_batch_empname" list="list_empname">
				</div>
				<div class="pull-right" style="margin-bottom:10px;margin-top:20px;padding-right:15px;">
					<button class="btn btn-success fa fa-save" id="btn_save_batch"> Add to batch</button>
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

<script src="../../../common_functions/common_functions.js"></script>
<script>
var oTable     = '';    
var oTable_batch_list = '';    
var handler    = './handler/handler.php';
var table_id   = 'tblMain';
var start_date = '<?php echo date('Y-m-d'); ?>';
var end_date   = '<?php echo date('Y-m-d'); ?>';
var empno 	   = '';
var username   = $('#hd_username').val();
var global_pkid = '';

$('document').ready(function(){
	oTable = $('#'+table_id).DataTable( {
        "autoWidth": false,
		"bProcessing": true,
		"bServerSide": true,
		"aaSorting"	 : [ [1,"asc"] ],
		"pageLength" : 10,
		"sAjaxSource": "./server_side_scripts/raw_data.php?date_start="+start_date+"&date_end="+end_date+"&empno="+empno+"&username="+username,
		"columnDefs": [
			{ className: "hide_column", "targets": [ 1 ] }
		  ]
	} );
    load_batch_list_dropdown('txtEmpNo');
    
    oTable_batch_list = $('#tbl_batch').DataTable({
		"aaSorting"	 : [],			
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "./server_side_scripts/manage_batch_list_datatable.php?username="+username
	});
});

$('#txtStartDate').change(function () {
	var data = {
		"action" 		: "add_31_days",
		"date_from"		: $('#txtStartDate').val()
	} 
	call_ajax(data, handler, function(result){		
		$('input#txtEndDate').attr({
			"min"   : $('#txtStartDate').val(),
			"max"   : result['date_to'],
			"value" : $('#txtStartDate').val()
		});
	});
});

$('#frm_search_attendance').on('submit',(function(e) {
	e.preventDefault();
	start_date 	= $('#txtStartDate').val();
	end_date 	= $('#txtEndDate').val();
	empno 		= $('#txtEmpNo').val();
	oTable.ajax.url( "./server_side_scripts/raw_data.php?date_start="+start_date+"&date_end="+end_date+"&empno="+empno+"&username="+username ).load();
    $('#modal_advance_search').modal('hide');
})); 

$('#btn_set_time_main').click(function() {    
    get_email_list('cmb_send_to', function() {
        $('.chosen-select#cmb_send_to').chosen({width:"100%", height: "100%"});
        return_monitoring_data(function() {   
            $('#div_message_set_time').html('');
            $('#div_message_set_time').hide();
            $('#btn_save').show();
            $('#mdl_set_time').modal();
        });    
    });        
});  
    
$('#txt_late_morning_start').change(function() {
    if( $(this).val() != '' ) {
        $('#txt_late_morning_end').prop('disabled',false);
        adjust_time_max('txt_late_morning_end', $(this).val(), 180);
    } else {
        $('#txt_late_morning_end').prop('disabled',true);
    }
});
    
$('#txt_late_night_start').change(function() {
    if( $(this).val() != '' ) {
        $('#txt_late_night_end').prop('disabled',false);
        adjust_time_max('txt_late_night_end', $(this).val(), 180);
    } else {
        $('#txt_late_night_end').prop('disabled',true);
    }
});
    
$('#txt_late_morning_end').change(function() {
    if( $(this).val() != '' ) {
        $('#txt_notification_morning').prop('disabled',false);
        adjust_time_min('txt_notification_morning', $(this).val(), 1);
    } else {
        $('#txt_notification_morning').prop('disabled',true);
    }
});
    
$('#txt_late_night_end').change(function() {
    if( $(this).val() != '' ) {
        $('#txt_notification_night').prop('disabled',false);
        adjust_time_min('txt_notification_night', $(this).val(), 1);
    } else {
        $('#txt_notification_night').prop('disabled',true);
    }
});
    
$('#frm_set_time').on('submit',(function(e) {
	e.preventDefault();
    var serialized_data = $(this).serialize();
    save_set_time(global_pkid, serialized_data);
})); 
$('#btn_manage_batch_main').click(function(){
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
        } else {
            alert(result['msg']);
        }
        oTable_batch_list.ajax.reload();
        $('#txt_add_batch_empno').val('');
        $('#txt_add_batch_empname').val('');
        oTable.ajax.url( "./server_side_scripts/raw_data.php?date_start="+start_date+"&date_end="+end_date+"&empno=All&username="+username ).load();
		load_batch_list_dropdown('txtEmpNo');
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
        oTable.ajax.url( "./server_side_scripts/raw_data.php?date_start="+start_date+"&date_end="+end_date+"&empno=All&username="+username ).load();
		load_batch_list_dropdown('txtEmpNo');
    });
});

$('#txt_employee_number').change(function(){
    var data = {
        "action"	: "load_employee_name_by_number",
        "emp_no"	: $(this).val()
    }
    call_ajax(data, handler, function(result){
        $('#txt_requested_by').val(result['emp_name']);
    });
});
$('#txt_employee_number').change(function(){
    var data = {
        "action"	: "load_employee_name_by_number",
        "emp_no"	: $(this).val()
    }
    call_ajax(data, handler, function(result){
        $('#txt_requested_by').val(result['emp_name']);
    });
});

$('#txt_requested_by').change(function(){
    var data = {
        "action"	: "load_employee_number_by_name",
        "emp_name"	: $(this).val()
    }
    call_ajax(data, handler, function(result){
        $('#txt_employee_number').val(result['emp_no']);
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

$('#txt_edit_employee_number').change(function(){
    var data = {
        "action"	: "load_employee_name_by_number",
        "emp_no"	: $(this).val()
    }
    call_ajax(data, handler, function(result){
        $('#txt_edit_requested_by').val(result['emp_name']);
    });
});

$('#txt_edit_requested_by').change(function(){
    var data = {
        "action"	: "load_employee_number_by_name",
        "emp_name"	: $(this).val()
    }
    call_ajax(data, handler, function(result){
        $('#txt_edit_employee_number').val(result['emp_no']);
    });
});
$('#btn_home').click(function() {
    window.location.href = '../../otks_main/otks_dashboard/index_requestor.php';
});
$('#btn_dl_user_manual').click(function() {
    window.location.href = './pages/dl_user_manual.php';
});
    
function load_batch_list_dropdown(dropdown_id) {
    $('#' + dropdown_id ).empty();
    var data = {
        "action"    : "return_batch_list",
        "username"  : username
    }
    call_ajax(data, handler, function(result){
		if(result['ctr'] == 0) {
			$('#' + dropdown_id ).append('<option value="" selected> - Please add employees - </option>');
			$('#set_date_1').attr('disabled', true);
		} else {
			$('#' + dropdown_id ).append('<option value="All" selected>All</option>');
			for(var i=0; i<result['ctr']; i++) {
				$('#' + dropdown_id ).append('<option value="'+result['empno'][i]+'">'+result['fullname'][i]+'</option>');
			} 
			$('#set_date_1').attr('disabled', false);
		}
    });
}  
function get_email_list(cmb_recipients, callback) {
	$('#'+cmb_recipients).empty();
	var data = {
		"action" 			: "get_email_list"
	} 
	call_ajax(data, handler, function(result){	
		$('#'+cmb_recipients).append('<option value=""></option>');
		for(var i=0;i<result['ctr'];i++) {
            if(username != result['username'][i]) {
                $('#'+cmb_recipients).append('<option value="'+result['username'][i]+'">'+result['emp_name'][i]+'</option>');
            }			
		}
		$('#'+cmb_recipients).trigger("chosen:updated");
		callback();
	});
}   
function save_set_time(global_pkid, serialized_data) {
    var data = {
        "action"            : "save_set_time",
        "pkid"              : global_pkid,
        "email_recipients"  : $('#cmb_send_to').val(),
        "username"          : username
    }
    call_ajax_serialize(data, serialized_data, handler, function(result){	
        $('#div_message_set_time').attr('class','alert alert-success');
		$('#div_message_set_time').html('<span class="fa fa-warning"> </span> ' + result['msg']);
		$('#div_message_set_time').show();
        $('#btn_save').hide();
        global_pkid = result['pkid'];
    });
}
function adjust_time_max(txt_id, set_time, adjustment) {
    var data = {
        "action"            : "adjust_time",
        "set_time"          : set_time,
        "time_adjustment"   : adjustment
    }
    call_ajax(data, handler, function(result){	
        $('input#' + txt_id).attr({
			"min"   : set_time,
            "max"   : result['adjusted_time']
		});
    });
}
function adjust_time_min(txt_id, set_time, adjustment) {
    var data = {
        "action"            : "adjust_time",
        "set_time"          : set_time,
        "time_adjustment"   : adjustment
    }
    call_ajax(data, handler, function(result){	
        $('input#' + txt_id).attr({
			"min"   : result['adjusted_time']
		});
    });
}
function return_monitoring_data(callback) {
    var data = {
        "action"    : "return_monitoring_data",
        "username"  : username
    }
    call_ajax(data, handler, function(result){
        global_pkid = result['pkid'];
        $('#txt_late_morning_start').val( result['late_morning_start'] );
        $('#txt_late_morning_end').val( result['late_morning_end'] );
        $('#txt_late_night_start').val( result['late_night_start'] );
        $('#txt_late_night_end').val( result['late_night_end'] );
        $('#txt_notification_morning').val( result['notification_morning'] );
        $('#txt_notification_night').val( result['notification_night'] );
        $('#cmb_send_to').val( result['email_recipients'] ).trigger("chosen:updated");
        
        
        $('#txt_late_morning_end').prop('disabled',false);
        $('#txt_late_night_end').prop('disabled',false);
        $('#txt_notification_morning').prop('disabled',false);
        callback();
    });
}  
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

</script>