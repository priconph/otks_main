<?php
/* Include employee information */
require_once('./pages/get_employee_username.php');
$fkid = $_GET['pkid'];
?>
<input type="hidden" id="hidden_username" value="<?php echo $username; ?>">
<input type="hidden" id="hidden_date_today" value="<?php echo date('Y-m-d'); ?>">

    <div class="row" style="margin-top:20px;"> <!--  panel panel-default -->
        <div class="col-sm-6 col-sm-offset-6" style="width:50%;padding-left:7%;">
            <button type="button" class="btn btn-success fa fa-thumbs-o-up" id="btn_approve"> Approve</button>
            <button type="button" class="btn btn-danger fa fa-thumbs-o-down" id="btn_disapprove"> Disapprove</button>
            <button type="button" class="btn btn-danger fa fa-remove" id="btn_cancel"> Cancel</button>
            <button type="button" class="btn btn-primary fa fa-print" id="btn_print_ot" style="width:14%"> Print</button>
            <button type="button" class="btn btn-default fa fa-remove" id="btn_close" style="width:14%"> Close </button>
        </div>
    </div>
<!--Main Container-->
<div id="row main_container" style="margin-top:10px;">
	<div class="col-sm-12">
		<div class="panel panel-success">
	  		<div class="panel-heading" id="container_summary">Summary of Overtime Requests </div>
	  		<div class="panel-body">
				<div class="row" style="padding:5px;">
					<div class="col-sm-12">
						<h3><span class="fa fa-users"></span> Employee Overtime</h3>
						<div id="container_tbl_employee_overtime"></div>
					</div>
				</div>
	 	 	</div>
		</div>
	</div>
</div>

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
<div class="modal fade" tabindex="-1" role="dialog" id="modal_system_message2">
  <div class="modal-dialog">
    <div class="modal-content">
      
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script src="../../../common_functions/common_functions.js" type="text/javascript"></script>
<script>
	/* System Variables */
	var handler = './handler/handler.php';
	
	/* Variable Table ID's */
	var table_employee_overtime = 'tbl_employee_overtime';
	var tbl_employee_list 	   = 'tbl_employee_list';
	
    /* Data table declaration */
    var dt_emp_overtime = "";
    var dt_emp_list = "";
	/* Variable */
	var username 	= $('#hidden_username').val();
	var date_today 	= $('#hidden_date_today').val();
    var fkid        = "<?php echo $fkid; ?>";
	
    function load_overtime_main_info_by_pkid() {
        var data = {
			"action" 	: "load_overtime_main_info_by_pkid",
			"pkid"		: fkid
		}
		call_ajax(data, handler, function(result){            
			if(result['req_status'] != 1) {             
                $('#btn_approve').prop('disabled',true);
                $('#btn_disapprove').prop('disabled',true);
                $('#btn_cancel').prop('disabled',true);
                if(result['req_status'] == 0) {
                    $('#container_summary').append('<div class="ui blue horizontal label">FOR EDIT</div>');
                } else if(result['req_status'] == 2) {
                    $('#container_summary').append('<div class="ui green horizontal label">APPROVED</div>');
                } else if(result['req_status'] == 3) {
                    $('#container_summary').append('<div class="ui red horizontal label">DISAPPROVED</div>');
                } else if(result['req_status'] == 4) {
                    $('#container_summary').append('<div class="ui red horizontal label">CANCELLED</div>');
                } else {
                    $('#container_summary').append('<div class="ui default horizontal label">ERROR!</div>');
                }
            } else {
                $('#btn_approve').val(fkid);
                $('#btn_disapprove').val(fkid);
                $('#btn_cancel').val(fkid);
                $('#container_summary').append('<div class="ui yellow horizontal label">FOR APPROVAL</div>');
            }
            
            
		});
    }
    
	function load_employee_overtime(){
		var container_id = 'container_tbl_employee_overtime';
		/* empty the container */
		$('#'+container_id).empty();
		/* append new table */
		var html  = '<table id="'+table_employee_overtime+'" class="table table-hover table-striped table-bordered" style="">';
			html += '	<thead>';
			html += '		<tr>';
			html += '			<th>Employee Number</th>';
			html += '			<th>Employee Name</th>';
			html += '			<th>Date / Time In</th>';
			html += '			<th>Date / Time Out</th>';
			html += '			<th>OT Date</th>';
			html += '			<th>Filed OT</th>';
			html += '			<th>Valid OT</th>';
			html += '			<th>Remarks</th>';
			html += '			<th>System Comment</th>';
			html += '		</tr>';
			html += '	</thead>';
			html += '	<tbody>';
			html += '	</tbody>';
			html += '</table>';
		$('#'+container_id).append(html);
        dt_emp_overtime = $('#'+table_employee_overtime).DataTable({
            "order": [],
            "columnDefs": [ {
              "targets"  : 'no-sort',
              "orderable": false,
            }]
        });
        
		/* append table cell values */
		var data = {
			"action" 	: "get_approved_employee_ot_details",
			"fkid"		: fkid,
			"username"	: username
		}
		call_ajax(data, handler, function(result){
			var ctr = result['ctr'];
            var msg = '';
			for(x=0;x<ctr;x++){
                if(result['system_comment'][x] == 'No record found!' || result['system_comment'][x] == 'No time in!' || result['system_comment'][x] == 'No time out!') {
                    msg = '<font color="red">'+result['system_comment'][x]+'</font>';
                } else if(result['system_comment'][x] == 'Successfully added!') {
                    msg = result['system_comment'][x];
                } else {
                    msg = '<font color="blue">'+result['system_comment'][x]+'</font>';
                }
				dt_emp_overtime.row.add([
                    result['empno'][x],
                    result['emp_name'][x],
                    result['date_time_in'][x],
                    result['date_time_out'][x],
                    result['ot_date'][x],
                    result['filed_ot'][x],
                    result['valid_ot'][x],
                    result['remarks'][x],
                    msg
                ]).draw(false);
			}
		
		});
	}
    
	function modal_approve_request(pkid){
		var title = '<span class="fa fa-settings"></span> System Message';
		var body  = '<div class="row alert alert-success">';
            body += '   <div class="col-sm-1">';
            body += '       <i class="fa fa-warning fa-2x"></i>';
            body += '   </div>';
            body += '   <div class="col-sm-11">';
            body += '       <h3>';
            body += '       	Are you sure you want to approve the request?';
            body += '       </h3>';
            body += '   </div>';
            body += '</div>'; 
		var buttons = '<button class="btn btn-success fa fa-check" type="button" value="'+pkid+'" id="btn_yes_approve_request"> YES</button>';
		system_message(title,body,buttons);
		$('#btn_yes_approve_request').click(function(){
            approve_overtime_request(pkid);
		});
	}
	
    function approve_overtime_request(pkid) {
        var data = {
			"action"       : "approve_overtime_request",
            "status"       : '2',
            "pkid"         : pkid,
            "username"     : username
		}
		call_ajax(data, handler, function(result){
            send_approved_overtime(pkid);
		});
    }
    
    function send_approved_overtime(pkid) {
        var data = {
			"action"       : "send_email_approved_ot",
            "pkid"         : pkid,
            "username"     : username
		}
		call_ajax(data, handler, function(result){
            var body = '';
            if(result['msg'] == 'Message has been sent!') {
                body += '<div class="row alert alert-success">';
                body += '   <div class="col-sm-2">';
                body += '       <i class="fa fa-info-circle fa-2x"></i> <i class="fa fa-envelope-o fa-2x"></i>';
                body += '   </div>';
                body += '   <div class="col-sm-10">';
                body += '       <h3>';
                body += '       	Overtime has been approved, an email notification has been sent to the requestor!';
                body += '       </h3>';
                body += '   </div>';
                body += '</div>'; 
            } else {
                body += '<div class="row alert alert-danger">';
                body += '   <div class="col-sm-1">';
                body += '       <i class="fa fa-info-circle fa-2x"></i>';
                body += '   </div>';
                body += '   <div class="col-sm-11">';
                body += '       <h3>ERROR: '+result['msg']+'</h3>';
                body += '   </div>';
                body += '</div>'; 
            }
            
            var title = '<span class="fa fa-settings"></span> System Message';
            $('#modal_system_message .modal-header span').hide();
            system_message(title,body,'');
            $('#btn_close_modal').click(function() {
                $('#btn_approve').prop('disabled',true);
                $('#btn_disapprove').prop('disabled',true);
                $('#btn_cancel').prop('disabled',true);
				window.location.href = "approver_index.php?page=approver_employee_overtime.php&pkid="+fkid;
            });
		});
    }
    
	function modal_disapprove_request(pkid){
		var title = '<span class="fa fa-settings"></span> System Message';
		var body  = '<div class="row alert alert-danger">';
            body += '   <div class="col-sm-1">';
            body += '       <i class="fa fa-warning fa-2x"></i>';
            body += '   </div>';
            body += '   <div class="col-sm-11">';
            body += '       <h3>';
            body += '       	Are you sure you want to disapprove the request?';
            body += '       </h3>';
            body += '   </div>';
            body += '</div>'; 
		var buttons = '<button class="btn btn-success fa fa-check" type="button" value="'+pkid+'" id="btn_yes_disapprove_request"> YES</button>';
		system_message(title,body,buttons);
		$('#btn_yes_disapprove_request').click(function(){
            disapprove_overtime_request(pkid);
		});
	}
    
    function disapprove_overtime_request(pkid) {
        var data = {
			"action"       : "disapprove_overtime_request",
            "status"       : '3',
            "pkid"         : pkid,
            "username"     : username
		}
		call_ajax(data, handler, function(result){
            send_disapproved_overtime(pkid);
		});
    }    
    
    function send_disapproved_overtime(pkid) {
        var data = {
			"action"       : "send_email_disapproved_ot",
            "pkid"         : pkid,
            "username"     : username
		}
		call_ajax(data, handler, function(result){
            var body = '';
            if(result['msg'] == 'Message has been sent!') {
                body += '<div class="row alert alert-success">';
                body += '   <div class="col-sm-2">';
                body += '       <i class="fa fa-info-circle fa-2x"></i> <i class="fa fa-envelope-o fa-2x"></i>';
                body += '   </div>';
                body += '   <div class="col-sm-10">';
                body += '       <h3>';
                body += '       	Overtime has been disapproved, an email notification has been sent to the requestor!';
                body += '       </h3>';
                body += '   </div>';
                body += '</div>'; 
            } else {
                body += '<div class="row alert alert-danger">';
                body += '   <div class="col-sm-1">';
                body += '       <i class="fa fa-info-circle fa-2x"></i>';
                body += '   </div>';
                body += '   <div class="col-sm-11">';
                body += '       <h3>ERROR: '+result['msg']+'</h3>';
                body += '   </div>';
                body += '</div>'; 
            }
            
            var title = '<span class="fa fa-settings"></span> System Message';
            $('#modal_system_message .modal-header span').hide();
            system_message(title,body,'');
            $('#btn_close_modal').click(function() {
                window.close();
				window.location.href = "approver_index.php?page=approver_employee_overtime.php&pkid="+fkid;
            });
		});
    }    
    	
	function modal_cancel_request(pkid){
		var modal  = '<div class="modal-header">';
            modal += '  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
            modal += '  <h4 class="modal-title">System Message</h4>';
            modal += '</div>';
		    modal += '<form id="frm_cancel_request">';
		    modal += ' <div class="modal-body">';
		    modal += '     <div class="row alert alert-warning">';
			modal += '        <div class="col-sm-1">';
			modal += '            <i class="fa fa-exclamation-triangle fa-3x"></i>';
			modal += '        </div>';
			modal += '        <div class="col-sm-11">';
			modal += '            <h3>Are you sure you want to cancel your request?</h3>';
			modal += '            <h3>If yes, please indicate the reason.</h3>';
			modal += '            <textarea name="txt_cancel_remarks" rows="4" cols="70%" style="color:black;" required></textarea>';
			modal += '        </div>';
			modal += '      </div>';
			modal += ' </div>';
			modal += ' <div class="modal-footer">';
		    modal += '     <button type="submit" class="btn btn-success fa fa-check"> YES</button>';
		    modal += '     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
			modal += ' </div>';
			modal += '</form>';
		system_message_validation(modal);
		
        $('#frm_cancel_request').submit(function(e){
            e.preventDefault();
            var serialized_data  = $(this).serialize();
                serialized_data += '&username='+username+'&pkid='+pkid;
            $('#modal_system_message2').modal('hide');
//            alert(serialized_data);
            cancel_request(serialized_data);
        });
	}
	    
    function cancel_request(serialized_data) {
        var data = {
			"action"              : "cancel_request"
		}
		call_ajax_serialize(data, serialized_data, handler, function(result){
            var title = '<span class="fa fa-settings"></span> System Message';
            var body = '<p>'+result['msg']+'</p>';
            $('#modal_system_message .modal-header span').hide();
            system_message(title,body,'');
            $('#btn_close_modal').click(function() {
                window.location.href = "approver_index.php?page=approver_employee_overtime.php&pkid="+fkid;
            });
		});
    }
    
	function system_message(title,body,buttons){
		/* Empty System Message Modal - Title, Body, Footer */
		$('#modal_system_message .modal-title').empty();
		$('#modal_system_message .modal-body').empty();
		$('#modal_system_message .modal-footer').empty();
		/* Append the close button */
		$('#modal_system_message .modal-footer').append('<button type="button" class="btn btn-default" data-dismiss="modal" id="btn_close_modal">Close</button>');
		/* Append parameter data */
		$('#modal_system_message .modal-title').append(title);
		$('#modal_system_message .modal-body').append(body);
		$('#modal_system_message .modal-footer').prepend(buttons);
		/* Show modal */
		$('#modal_system_message').modal('show');
	}
    
	function system_message_validation(body){
		/* Empty System Message Modal - Title, Body, Footer */
		$('#modal_system_message2 .modal-content').empty();
		/* Append parameter data */
		$('#modal_system_message2 .modal-content').append(body);
		/* Show modal */
		$('#modal_system_message2').modal('show');
	}
	
    function hide_all_button_containers(){
		$('#container_btn_add_employees').hide();
		$('#container_btn_main').hide();
		$('#container_btn_upload_employees').hide();
		$('#container_btn_other_employees').hide();
	}
	
	function hide_all_containers(){
		$('#container_add_employee').hide();
		$('#container_upload_employee').hide();
		$('#container_other_employee').hide();
	}
	
	function show_container(container){
		hide_all_containers();
		$('#'+container).toggle('slow');
		$('#container_btn_main').toggle('slow');
	}
	
	function show_main_container(){
		hide_all_containers();
		$('#container_btn_main').show();
	}
		
	/* ON LOAD FUNCTIONS */
	load_overtime_main_info_by_pkid();
	load_employee_overtime();
	show_main_container();
	
	/* CLICK FUNCTIONS */
	
	$('#btn_approve').click(function(){
		modal_approve_request($(this).val());
	});
    
	$('#btn_disapprove').click(function(){
		modal_disapprove_request($(this).val());
	});
    
    $('#btn_cancel').click(function(){
        modal_cancel_request($(this).val());
	});
    
    $('#btn_print_ot').click(function(){
        window.open("./pages/print_preview.php?pkid="+fkid+'&username='+username, '_blank');
    });
	
	$('#btn_close').click(function(){
		window.close();
		// window.location.href = "approver_index.php";
	});
    
    /* Events */
</script>