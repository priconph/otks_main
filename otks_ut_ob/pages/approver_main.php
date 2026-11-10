<input type="hidden" id="hd_username" value="<?php echo $username; ?>"> 
<!--Main Container-->
<div id="row main_container" style="margin-top:20px;">
	<div class="col-sm-10 col-sm-offset-1">
		<div class="panel panel-success">
	  		<div class="panel-heading">Summary of Pass Slip Requests</div>
	  		<div class="panel-body">
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
                        <h5><p> 
                            Double click the row to view / approve / disapprove the request.<br><br>
                            <b>Legend: </b>
                                <ol><b>OB</b> - (Official Business)</ol>
                                <ol><b>UT</b> - (Undertime)</ol></p></h5>
                        <!-- <h5><p>Row in <font color="red">Red</font> are uncontrolled documents.</p></h5>
                        <h5><p>Row in <font color="green">Green</font> are unactive documents.</p></h5> -->
                      </div>
                    </div>	
                   </div>	
                </div>	
				<div id="row">
					<div class="col-sm-4">
						<button class="btn btn-default btn-md fa fa-home" id="btn_home"> Home</button>
					</div>
					<div class="col-sm-8">
						<p style="text-align:right;padding-bottom:20px;">
							<button class="btn btn-warning btn-md fa fa-file-pdf-o" id="btn_download"> User Manual</button>
						</p>
					</div>
				</div>
				<div id="container_table_overtime_summary">
					<table class="table table-bordered table-striped" id="tbl_ut_ob">
						<thead>
							<tr>
								<th>Status</th>
								<th>Type</th>
								<th>Date Requested</th>
								<th>Requestor</th>
								<th>Date UT/OB</th>
								<th>Time out</th>
								<th>Reason</th>
								<th>Cancel</th>
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
<!-- Modal edit leave request form -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_edit_leave_request">
  <div class="modal-dialog" style="width:800px;">
    <input type="hidden" id="txt_edit_action">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Pass Slip Request</h4>
      </div>
       <div class="modal-body">
        <div id="row" style="padding:0px;">
			<div class="row panel panel-default" id="2nd_row_textbox">
				<div class="col-sm-6" style="margin-top:20px;" >
					<div class="form-inline" style="padding-right:0px;">
                        <div style="padding:2px;">
							<label style="width:100px;">Employee No.</label>
							<input type="text" class="form-control" style="width:71%;" name="txt_edit_employee_number" id="txt_edit_employee_number" disabled required>
						</div>
                    </div>
                </div>
				<div class="col-sm-6" style="margin-top:20px;">
					<div class="form-inline" style="padding-right:0px;padding-left:0px;">
                        <div style="padding:2px;">
							<label style="width:100px;">Date of Request:</label>
							<input type="text" class="form-control" style="width:71%;" name="txt_edit_date_request" id="txt_edit_date_request" value="<?php echo date('M d, Y'); ?>" disabled required>
						</div>
                    </div>
                </div>
				<div class="col-sm-12" style="margin-top:2px;">
                    <div class="form-inline" style="padding-right:0px;">
                        <div style="padding:2px;">
							<label style="width:100px;">Employee Name:</label>
							<input type="text" class="form-control" style="width:86%;" name="txt_edit_requested_by" id="txt_edit_requested_by" disabled required>
						</div>
                    </div>
                </div>
				<div class="col-sm-6" style="margin-top:2px;">
                    <div class="form-inline" style="padding-right:0px;">
                        <div style="padding:2px;">
							<label style="width:100px;">Department:</label>
							<input type="text" class="form-control" style="width:71%;" name="txt_edit_department" id="txt_edit_department" disabled required>
						</div>
                    </div>
                </div>
				<div class="col-sm-6" style="margin-top:2px;">
                    <div class="form-inline" style="padding-right:0px;">
                        <div style="padding:2px;">
							<label style="width:100px;">Position:</label>
							<input type="text" class="form-control" style="width:71%;" name="txt_edit_position" id="txt_edit_position" disabled required>
						</div>
                    </div>
                </div>
				<div class="col-sm-6" style="margin-top:2px;">
                    <div class="form-inline" style="padding-right:0px;">
                        <div style="padding:2px;">
							<label style="width:100px;">Purpose of Leaving: </label>
							<input type="radio" name="rbtn_edit_group" value="0" id="rbtn_edit_ut" required disabled> Undertime <br><label style="width:100px;"></label>
							<input type="radio" name="rbtn_edit_group" value="1" id="rbtn_edit_ob" required disabled> Official Business
						</div>
                    </div>
                </div>
                <div class="col-sm-6" style="margin-top:2px;">
                    <div class="form-inline" style="padding-right:0px;">
                        <div style="padding:2px;"><br>
							<label style="width:100px;">Place of OB:</label>
							<input type="text" class="form-control" style="width:71%;" name="txt_edit_place_ob" id="txt_edit_place_ob" disabled>
						</div>
                    </div>
                </div>        
                <div class="col-sm-12" style="margin-top:2px;">
					<div class="form-inline" style="padding-right:0px;">
						<label style="width:100px;">Reason:</label>
						<textarea id="txt_edit_reason" class="form-control" style="width: 86%;" required disabled></textarea>
					</div>
				</div>     
				<div class="col-sm-6" style="margin-top:2px;">
                    <div class="form-inline" style="padding-right:0px;">
                        <div style="padding:2px;">
							<label style="width:100px;">Time-out:</label>
							<input type="time" class="form-control" style="width:71%;" name="txt_edit_time_out" id="txt_edit_time_out" disabled required>
						</div>
                    </div>
                </div>
				<div class="col-sm-6" style="margin-top:2px;">
                    <div class="form-inline" style="padding-right:0px;">
                        <div style="padding:2px;">
							<label style="width:100px;">Time return:</label>
							<input type="time" class="form-control" style="width:71%;" name="txt_edit_time_return" id="txt_edit_time_return" disabled>
						</div>
                    </div>
                </div>  
                <datalist id="txt_edit_approver_list">
				</datalist>
				<div class="col-sm-6" style="margin-top:2px;">
                    <div class="form-inline" style="padding-right:0px;">
                        <div style="padding:2px;">
							<label style="width:100px;">Approver:</label>
							<input type="text" class="form-control" style="width:71%;" name="txt_edit_approver" id="txt_edit_approver" autocomplete="off" list="txt_edit_approver_list" disabled required>
						</div>
                    </div>
                </div>
				<div class="col-sm-6" style="margin-top:2px;">
                    <div class="form-inline" style="padding-right:0px;">
                        <div style="padding:2px;">
							<label style="width:100px;">Date of Leave:</label>
							<input type="date" class="form-control" style="width:71%;" name="txt_edit_date_leave" id="txt_edit_date_leave" disabled required>
						</div>
                    </div>
                </div> 
			</div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success fa fa-thumbs-o-up" title="Click to approve the request" id="btn_approve"> Approve</button>
        <button type="button" class="btn btn-danger fa fa-thumbs-o-down" title="Click to disapprove the request" id="btn_disapprove">  Disapprove</button>
        <button type="button" class="btn btn-default fa fa-close" data-dismiss="modal" id="btn_close_update"> Close</button>
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

<script src="../../../common_functions/common_functions.js"></script>
<script>
var handler = './handler/handler.php';
var username = $('#hd_username').val();
var date_today = "<?php echo date('Y-m-d'); ?>";
var pkid = '';
var oTable = '';    
$('document').ready(function(){
	oTable = $('#tbl_ut_ob').DataTable({
                    "aaSorting": [],
					"bProcessing": true,
					"bServerSide": true,
					"sAjaxSource": "./server_side_scripts/approver_datatable.php?username="+username
				 });    
	   
    $('#btn_close_update').click(function () {
        oTable.draw(false);
    }); 
});
/* CLICK FUNCTIONS */
$('#btn_home').click(function() {
	window.location.href = '../../otks_main/otks_dashboard/index_approver.php';
});

$('#btn_download').click(function(){
	window.open('pages/manual_viewer.php','_blank');
}); 
$('#tbl_ut_ob tbody').on('click', 'tr', function () {
    $('#tbl_ut_ob tbody tr').attr('style','');
    $(this).attr('style','background:teal;color:white;');
});

$('#tbl_ut_ob tbody').on('dblclick','tr',function(){
	pkid = $(this).find('#txt_pkid').val();
    if($(this).find('td:eq()').text() != 'For Approval') {
        $('#btn_approve').hide();
        $('#btn_disapprove').hide();
    } else {
        $('#btn_approve').show(); 
        $('#btn_disapprove').show(); 
    }
//	alert('pkid1 '+pkid);
    load_request_info(pkid,function () {
        $('#modal_edit_leave_request').modal('show');
    });
});

$('#btn_approve').click(function() {
	var data = {
		"action"	    : "validate_ob_date",
		"ob_date"		: $('#txt_edit_date_leave').val()
	}
	call_ajax(data,handler,function(result){ 
		if(result['validate'] == 'YES') {
			var modal_yes  = '<div class="modal-header">';
				modal_yes += '  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
				modal_yes += '  <h4 class="modal-title">System Message</h4>';
				modal_yes += '</div>';
				modal_yes += ' <div class="modal-body">';
				modal_yes += '     <div class="row alert alert-success">';
				modal_yes += '        <div class="col-sm-1">';
				modal_yes += '            <i class="fa fa-exclamation-circle fa-3x"></i>';
				modal_yes += '        </div>';
				modal_yes += '        <div class="col-sm-11">';
				modal_yes += '            <h3>Are you sure you want to approve the request?</h3>';
				modal_yes += '        </div>';
				modal_yes += '      </div>';
				modal_yes += ' </div>';
				modal_yes += ' <div class="modal-footer">';
				modal_yes += '     <button type="button" class="btn btn-success fa fa-thumbs-o-up" id="btn_approve_yes"> YES</button>';
				modal_yes += '     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
				modal_yes += ' </div>';
			system_message_validation(modal_yes);

			$('#btn_approve_yes').click(function(){
				$('#modal_system_message2').modal('hide');
				approve_request();
			});
		} else if(result['validate'] == 'NO') {
			var modal_no  = '<div class="modal-header">';
				modal_no += '  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
				modal_no += '  <h4 class="modal-title">System Message</h4>';
				modal_no += '</div>';
				modal_no += ' <div class="modal-body">';
				modal_no += '     <div class="row alert alert-danger">';
				modal_no += '        <div class="col-sm-1">';
				modal_no += '            <i class="fa fa-warning fa-3x"></i>';
				modal_no += '        </div>';
				modal_no += '        <div class="col-sm-11">';
				modal_no += '            <h3>Invalid entry for date. Approval must within the date.</h3>';
				modal_no += '        </div>';
				modal_no += '      </div>';
				modal_no += ' </div>';
				modal_no += ' <div class="modal-footer">';
				modal_no += '     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
				modal_no += ' </div>';
			system_message_validation(modal_no);
		} else {
			alert('ERROR!');
		}
	});
});

$('#btn_disapprove').click(function() {
	var data = {
		"action"	    : "validate_ob_date",
		"ob_date"		: $('#txt_edit_date_leave').val()
	}
	call_ajax(data,handler,function(result){ 
		if(result['validate'] == 'YES') {
			var modal  = '<div class="modal-header">';
				modal += '  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
				modal += '  <h4 class="modal-title">System Message</h4>';
				modal += '</div>';
				modal += '<form id="frm_cancel_request">';
				modal += ' <div class="modal-body">';
				modal += '     <div class="row alert alert-danger">';
				modal += '        <div class="col-sm-1">';
				modal += '            <i class="fa fa-exclamation-triangle fa-3x"></i>';
				modal += '        </div>';
				modal += '        <div class="col-sm-11">';
				modal += '            <h3>Are you sure you want to disapprove the request?</h3>';
				modal += '            <h3>If yes, please indicate the reason.</h3>';
				modal += '            <textarea name="disapproved_remarks" id="disapproved_remarks" rows="4" cols="70%" style="color:black;" required></textarea>';
				modal += '        </div>';
				modal += '      </div>';
				modal += ' </div>';
				modal += ' <div class="modal-footer">';
				modal += '     <button type="submit" class="btn btn-success fa fa-thumbs-o-down" id="btn_disapprove_yes"> YES</button>';
				modal += '     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
				modal += ' </div>';
				modal += '</form>';
			system_message_validation(modal);
			
			$('#frm_cancel_request').submit(function(e){
				e.preventDefault();
				$('#modal_system_message2').modal('hide');
				disapprove_request();
			});
		} else if(result['validate'] == 'NO') {
			var modal_no  = '<div class="modal-header">';
				modal_no += '  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
				modal_no += '  <h4 class="modal-title">System Message</h4>';
				modal_no += '</div>';
				modal_no += ' <div class="modal-body">';
				modal_no += '     <div class="row alert alert-danger">';
				modal_no += '        <div class="col-sm-1">';
				modal_no += '            <i class="fa fa-warning fa-3x"></i>';
				modal_no += '        </div>';
				modal_no += '        <div class="col-sm-11">';
				modal_no += '            <h3>Invalid entry for date. Approval must within the date.</h3>';
				modal_no += '        </div>';
				modal_no += '      </div>';
				modal_no += ' </div>';
				modal_no += ' <div class="modal-footer">';
				modal_no += '     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
				modal_no += ' </div>';
			system_message_validation(modal_no);
		} else {
			alert('ERROR!');
		}
	});
});  
    
$('#tbl_ut_ob tbody').on('click','tr #btn_cancel',function(){
    var btn_pkid = this.value;
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
        modal += '            <textarea name="cancel_remarks" rows="4" cols="70%" style="color:black;" required></textarea>';
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
            serialized_data += '&username='+username+'&pkid='+btn_pkid;
        $('#modal_system_message2').modal('hide');
        cancel_request(serialized_data);
    });
});
    
 
function load_request_info(pkid, callback) {
    var data = {
		"action"	    : "load_request_info_by_pkid",
		"pkid"		    : pkid,
        "username"      : username
	}
	call_ajax(data,handler,function(result){ 
        var approver = get_datalist_value_and_text('txt_edit_approver_list',result['ob_approver']);
        if(result['ob_purpose'] == 'UT') {
            $("#rbtn_edit_ut").prop("checked", true);
            $("#txt_edit_time_return").prop("disabled", true);
        } else {
            $("#rbtn_edit_ob").prop("checked", true);
        }
        $('#txt_edit_employee_number').val(result['empno']);
		$('#txt_edit_requested_by').val(result['emp_name']);
		$('#txt_edit_position').val(result['position']);
		$('#txt_edit_department').val(result['department']);
		$('#txt_edit_date_leave').val(result['ob_date']);
		$('#txt_edit_place_ob').val(result['ob_place'])
		$('#txt_edit_reason').val(result['ob_reason']);
		$('#txt_edit_time_out').val(result['ob_time_out'])
		$('#txt_edit_time_return').val(result['ob_time_return'])
		$('#txt_edit_approver').val(approver['value']);
//        alert('db'+result['ob_approver']+' text'+approver['text']+' value'+approver['value']);
        callback();
    });
}

function approve_request() {
    var data = {
		"action"	    : "approve_disapprove_request",
		"pkid"		    : pkid,
		"status"	    : 1,
        "username"      : username
	}
	call_ajax(data,handler,function(result){ 
        if(result['msg'] == 'Message has been sent!') {
            var body  = '<div class="row alert alert-success">';
                body += '   <div class="col-sm-1">';
                body += '       <i class="fa fa-exclamation-circle fa-3x"></i>';
                body += '   </div>';
        } else {
            var body  = '<div class="row alert alert-warning">';
                body += '   <div class="col-sm-1">';
                body += '       <i class="fa fa-exclamation-triangle fa-3x"></i>';
                body += '   </div>';
        }				
                body += '   <div class="col-sm-11">';
                body += '       <h3>';
                body += '       	'+result['msg'];
                body += '       </h3>';
                body += '   </div>';
                body += '</div>';
        system_message('System Message',body,'');
        $('#btn_close_update').trigger('click');
    });
}

function disapprove_request() {
    var data = {
		"action"	                : "approve_disapprove_request",
		"pkid"		                : pkid,
		"status"	                : 2,
		"disapproved_remarks"	    : $('#disapproved_remarks').val(),
        "username"                  : username
	}
	call_ajax(data,handler,function(result){ 
        if(result['msg'] == 'Message has been sent!') {
            var body  = '<div class="row alert alert-success">';
                body += '   <div class="col-sm-1">';
                body += '       <i class="fa fa-exclamation-circle fa-3x"></i>';
                body += '   </div>';
        } else {
            var body  = '<div class="row alert alert-warning">';
                body += '   <div class="col-sm-1">';
                body += '       <i class="fa fa-exclamation-triangle fa-3x"></i>';
                body += '   </div>';
        }				
                body += '   <div class="col-sm-11">';
                body += '       <h3>';
                body += '       	'+result['msg'];
                body += '       </h3>';
                body += '   </div>';
                body += '</div>';
        system_message('System Message',body,'');
        $('#btn_close_update').trigger('click');
    });
}
    
function cancel_request(serialized_data) {
    var data = {
        "action"              : "cancel_request"
    }
    call_ajax_serialize(data, serialized_data, handler, function(result){
        if(result['msg'] == 'Message has been sent!' || result['msg'] == 'Request was successfully cancelled!') {
            var body  = '<div class="row alert alert-success">';
                body += '   <div class="col-sm-1">';
                body += '       <i class="fa fa-exclamation-circle fa-3x"></i>';
                body += '   </div>';
        } else {
            var body  = '<div class="row alert alert-warning">';
                body += '   <div class="col-sm-1">';
                body += '       <i class="fa fa-exclamation-triangle fa-3x"></i>';
                body += '   </div>';
        }				
                body += '   <div class="col-sm-11">';
                body += '       <h3>';
                body += '       	'+result['msg'];
                body += '       </h3>';
                body += '   </div>';
                body += '</div>';
        system_message('System Message',body,'');
        $('#btn_close_update').trigger('click');
    });
}
    
function system_message(title,body,buttons){
    /* Empty System Message Modal - Title, Body, Footer */
    $('#modal_system_message .modal-title').empty();
    $('#modal_system_message .modal-body').empty();
    $('#modal_system_message .modal-footer').empty();
    /* Append the close button */
    $('#modal_system_message .modal-footer').append('<button type="button" class="btn btn-default" data-dismiss="modal" id="btn_modal_close">Close</button>');
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
    
function get_datalist_value_and_text(data_list,value){
    var option_value = value;
    var option_text = '';
    $('#'+data_list+' option').each(function(){
        if(option_value == $(this).val()){
            option_text = $(this).text();
        } else {
            if(value == $(this).text()) {
                option_value = $(this).val();
            }
        }
    });
    var option = {
        "value" : option_value,
        "text" : option_text
    }
    return option;
}

    
    
    //	
//function modal_edit_straight_modal(pkid){
//	var data = {
//		"action"	: "fetch_main_data_update",
//		"pkid"		: pkid
//	}
//	call_ajax(data,handler,function(result){
//		// alert(result['req_approver']['0']);
//		$('#txt_request_date_edit').val(result['req_date']['0']);  
//		$('#txt_manpower_involved_edit').val(result['req_manpower']['0']);
//		$('#txt_date_from_edit').val(result['req_datefrom']['0']);
//		$('#txt_date_to_edit').val(result['req_dateto']['0']);
//		$('#txt_requested_by_edit').val(result['req_by']['0']);
//		$('#txt_division_edit').val('');
//		$('#txt_department_edit').val('');
//		$('#txt_approver_edit').val(result['req_approver']['0']);
//		$('#txt_justification_edit').val(result['req_justification']['0']);
//		load_employee_information('txt_requested_by_edit','txt_division_edit','txt_department_edit','txt_request_date_edit');
//		$('#modal_edit_straight_request').modal('show');
//	});
//}



</script>