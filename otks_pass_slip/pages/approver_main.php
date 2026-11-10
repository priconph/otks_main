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
                        <!-- <div style="padding:2px;">
							<label style="width:100px;">Approver:</label>
							<input type="text" class="form-control" style="width:71%;" name="txt_edit_approver" id="txt_edit_approver" autocomplete="off" list="txt_edit_approver_list" disabled required>
						</div> -->
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

<div class="modal fade" tabindex="-1" role="dialog" id="modal_batch_request">
  <div class="modal-dialog" style="width:800px;">
    <input type="hidden" id="txt_edit_batch_action">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">View Pass Slip Request</h4>
      </div>
      <form id="frm_edit_batch_request" method="post"> 
       <div class="modal-body">
	   <center><div id="div_msg_edit_batch" style="display:none;color:white;font-weight:bold;text-align:center;width:100%" class="row alert alert-danger"></div></center>
        <div id="row" style="">
			<div class="col-m-12">
        		<div id="container_tbl_employee_list_edit"></div>
	       	</div>
		</div><br>
        <div id="row" style="padding:0px;">
			<div class="row panel panel-default" id="2nd_row_textbox">
				<div class="col-sm-6" style="margin-top:2px;">
                    <div class="form-inline" style="padding-right:0px;">
                        <div style="padding:2px;">
							<label style="width:100px;">Purpose of Leaving: </label>
							<input type="radio" name="rbtn_edit_group_batch" value="0" id="rbtn_edit_ut_batch" required disabled> Undertime <br><label style="width:100px;"></label>
							<input type="radio" name="rbtn_edit_group_batch" value="1" id="rbtn_edit_ob_batch" required disabled> Official Business
						</div>
                    </div>
                </div>
                <div class="col-sm-6" style="margin-top:2px;">
                    <div class="form-inline" style="padding-right:0px;">
                        <div style="padding:2px;"><br>
							<label style="width:100px;">Place of OB:</label>
							<input type="text" class="form-control" style="width:71%;" name="txt_edit_place_ob_batch" id="txt_edit_place_ob_batch" disabled>
						</div>
                    </div>
                </div>        
                <div class="col-sm-12" style="margin-top:2px;">
					<div class="form-inline" style="padding-right:0px;">
						<label style="width:100px;">Reason:</label>
						<textarea id="txt_edit_reason_batch" class="form-control" style="width: 86%;" required disabled></textarea>
					</div>
				</div>     
				<div class="col-sm-6" style="margin-top:2px;">
                    <div class="form-inline" style="padding-right:0px;">
                        <div style="padding:2px;">
							<label style="width:100px;">Time-out:</label>
							<input type="time" class="form-control" style="width:71%;" name="txt_edit_time_out_batch" id="txt_edit_time_out_batch" required disabled>
						</div>
                    </div>
                </div>
				<div class="col-sm-6" style="margin-top:2px;">
                    <div class="form-inline" style="padding-right:0px;">
                        <div style="padding:2px;">
							<label style="width:100px;">Time return:</label>
							<input type="time" class="form-control" style="width:71%;" name="txt_edit_time_return_batch" id="txt_edit_time_return_batch" disabled>
						</div>
                    </div>
                </div>  
				<div class="col-sm-12" style="margin-top:2px;">
                   <div class="form-inline" style="padding-right:0px;">
                        <div style="padding:2px;">
							<label style="width:100px;">Date of Leave:</label>
							<input type="date" class="form-control" style="width:34%;" name="txt_edit_date_leave_batch" id="txt_edit_date_leave_batch" min="<?php echo date("Y-m-d"); ?>" required disabled>
						</div>
                    </div>
                </div>
				<div class="col-sm-12" style="margin-top:2px;">
					<div class="form-inline" style="padding-right:0px;">
						<div style="padding:2px;">
							<label style="width:100px;">Approver Remarks:</label>
							<textarea class="form-control" style="width:86%;" name="txt_approver_remarks" id="txt_approver_remarks"></textarea>
						</div>
					</div>
                </div> 
			</div>
        </div>	
		<div id="container_buttons" style="margin-bottom:1%;">
			<center>
			<button type="button" class="btn btn-success fa fa-thumbs-o-up" title="Click to approve the request" id="btn_approve_batch"> Approve</button>
			<button type="button" class="btn btn-danger fa fa-thumbs-o-down" title="Click to disapprove the request" id="btn_disapprove_batch">  Disapprove</button>
			<button type="button" class="btn btn-danger fa fa-close" title="Click to cancel the request" id="btn_cancel_batch">  Cancel</button>
			</center>
		</div>
      </div>
      <div class="modal-footer">     
        <button type="button" class="btn btn-warning fa fa-envelope" title="Click to save and send the record for approval" id="btn_save_n_send_batch"> Save & Send</button>
        <button type="button" class="btn btn-default fa fa-close" data-dismiss="modal" id="btn_close"> Close</button>
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

<script src="../../../common_functions/common_functions.js"></script>
<script>
var handler = './handler/handler.php';
var username = $('#hd_username').val();
var date_today = "<?php echo date('Y-m-d'); ?>";
var pkid = '';
var oTable = '';  
var dt_emp_list_edit = '';  
var tbl_employee_list_edit = 'tbl_employee_list_edit'; 
/* Arrays */
var array_batch_employee = [];
var array_batch_employee_approve = [];
var array_batch_employee_disapprove = [];
var array_batch_employee_cancel = [];
var array_batch_employee_name = [];
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
	var req_type = $(this).find('#txt_req_type').val();
	if(req_type == 0) {
		if($(this).find('td:eq()').text() != 'For Approval') {
			$('#btn_approve').hide();
			$('#btn_disapprove').hide();
		} else {
			$('#btn_approve').show(); 
			$('#btn_disapprove').show(); 
		}
		load_request_info(pkid,function () {
			$('#modal_edit_leave_request').modal('show');
		});
	} else if(req_type == 1) {
		if(($(this).find('td:eq()').text() == 'For Approval')) {
			$('#container_buttons').show();
			$('#btn_save_n_send_batch').show(); 	
			
		} else if(($(this).find('td:eq()').text() == 'Approved')) {
			$('#container_buttons').hide();
			$('#btn_save_n_send_batch').hide(); 
		} else if(($(this).find('td:eq()').text() == 'Disapproved')) {
			$('#container_buttons').hide();
			$('#btn_save_n_send_batch').hide(); 
		} else if(($(this).find('td:eq()').text() == 'Cancelled')) {
			$('#container_buttons').hide();
		} else {
			$('#container_buttons').hide();
			$('#btn_save_n_send_batch').hide(); 
		}
		load_request_info_batch(pkid,req_type,function () {
			$('#modal_batch_request').modal('show');
		});
	}
});

$('#btn_approve').click(function() {
    var modal  = '<div class="modal-header">';
        modal += '  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
        modal += '  <h4 class="modal-title">System Message</h4>';
        modal += '</div>';
        modal += ' <div class="modal-body">';
        modal += '     <div class="row alert alert-success">';
        modal += '        <div class="col-sm-1">';
        modal += '            <i class="fa fa-exclamation-circle fa-3x"></i>';
        modal += '        </div>';
        modal += '        <div class="col-sm-11">';
        modal += '            <h3>Are you sure you want to approve the request?</h3>';
        modal += '        </div>';
        modal += '      </div>';
        modal += ' </div>';
        modal += ' <div class="modal-footer">';
        modal += '     <button type="button" class="btn btn-success fa fa-thumbs-o-up" id="btn_approve_yes"> YES</button>';
        modal += '     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
        modal += ' </div>';
    system_message_validation(modal);

    $('#btn_approve_yes').click(function(){
        $('#modal_system_message2').modal('hide');
        approve_request();
    });
});

$('#btn_disapprove').click(function() {
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

$('#btn_approve_batch').click(function() {
	dt_emp_list_edit.rows().every( function () {
		var d = this.data();
		var n = this.nodes();
		var new_val = [];
			new_val.push(d[0]);
			new_val.push(d[1]);
			new_val.push(d[2]);
			new_val.push('<a class="ui green label">APPROVED</a>');
		if( $( n[0] ).find(':checkbox').prop('checked') ) {
			this.data(new_val);
			var check_exist = check_exist_on_array(array_batch_employee_approve,d[1]);
			
			if(check_exist != 1){
				array_batch_employee_approve.push(d[1]);
			}
		}
	} );
	console.log('approved '+array_batch_employee_approve);
	dt_emp_list_edit.draw(false);
	// array_batch_employee_approve = [];
});    

$('#btn_disapprove_batch').click(function() {
	dt_emp_list_edit.rows().every( function () {
		var d = this.data();
		var n = this.nodes();
		var new_val = [];
			new_val.push(d[0]);
			new_val.push(d[1]);
			new_val.push(d[2]);
			new_val.push('<a class="ui red label">DISAPPROVED</a>');
		if( $( n[0] ).find(':checkbox').prop('checked') ) {
			this.data(new_val);
			var check_exist = check_exist_on_array(array_batch_employee_disapprove,d[1]);
			
			if(check_exist != 1){
				array_batch_employee_disapprove.push(d[1]);
			}
		}
	} );
	console.log('disapproved '+array_batch_employee_disapprove);
	dt_emp_list_edit.draw(false);
	// array_batch_employee_disapprove = [];
});

$('#btn_cancel_batch').click(function() {
	dt_emp_list_edit.rows().every( function () {
		var d = this.data();
		var n = this.nodes();
		var new_val = [];
			new_val.push(d[0]);
			new_val.push(d[1]);
			new_val.push(d[2]);
			new_val.push('<a class="ui red label">CANCELLED</a>');
		if( $( n[0] ).find(':checkbox').prop('checked') ) {
			this.data(new_val);
			var check_exist = check_exist_on_array(array_batch_employee_cancel,d[1]);
			
			if(check_exist != 1){
				array_batch_employee_cancel.push(d[1]);
			}
		}
	} );
	console.log('cancelled '+array_batch_employee_cancel);
	dt_emp_list_edit.draw(false);
	// array_batch_employee_cancel = [];
});

$('#btn_save_n_send_batch').click(function(){
	var modal  = '<div class="modal-header">';
        modal += '  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
        modal += '  <h4 class="modal-title">System Message</h4>';
        modal += '</div>';
        modal += ' <div class="modal-body">';
        modal += '     <div class="row alert alert-success">';
        modal += '        <div class="col-sm-1">';
        modal += '            <i class="fa fa-exclamation-circle fa-3x"></i>';
        modal += '        </div>';
        modal += '        <div class="col-sm-11">';
        modal += '            <h3>Are you sure you want to approve the request?</h3>';
        modal += '        </div>';
        modal += '      </div>';
        modal += ' </div>';
        modal += ' <div class="modal-footer">';
        modal += '     <button type="button" class="btn btn-success fa fa-thumbs-o-up" id="btn_approve_yes"> YES</button>';
        modal += '     <button type="button" class="btn btn-default"  id="btn_modal_clse" data-dismiss="modal">Close</button>';
        modal += ' </div>';
    system_message_validation(modal);

	$('#btn_approve_yes').click(function(){
		$('#modal_batch_request').modal('hide');
		array_batch_employee_approve = [];
		array_batch_employee_disapprove = [];
		array_batch_employee_cancel = [];
		var status = '';
		var new_empno = '';
		var empno_status = '';
		dt_emp_list_edit.rows().every( function () {
			var d = this.data();
			new_empno = d[1];
			if(d[3] == '<a class="ui yellow label">FOR APPROVAL</a>') {
				status = 0;
			} else if(d[3] == '<a class="ui green label">APPROVED</a>') {
				status = 1;
			} else if(d[3] == '<a class="ui red label">DISAPPROVED</a>') {
				status = 2;
			} else if(d[3] == '<a class="ui red label">CANCELLED</a>') {
				status = 3;
			}
			empno_status += new_empno+'_'+status+',';
		} );
		
		// $('#'+tbl_employee_list_edit+' tbody tr').each(function(){
			// var new_empno = $(this).find('td:eq(1)').text();
			// var status = $(this).find('td:eq(3)').text();
			// if(status == 'FOR APPROVAL') {
				// status = 0;
			// } else if(status == 'APPROVED') {
				// status = 1;
			// } else if(status == 'DISAPPROVED') {
				// status = 2;
			// } else if(status == 'CANCELLED') {
				// status = 3;
			// }
			// empno_status += new_empno+'_'+status+',';
			// console.log(empno_status);
			
		// });
		console.log(empno_status);
		$('#btn_modal_clse').trigger('click');
		submit_batch_request(empno_status);
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

function submit_batch_request(empno_status) {
    var data = {
		"action"	    : "approve_disapprove_request_batch",
		"pkid"		    : pkid,
		"empno_status"  : empno_status,
		"remarks"  		: $('#txt_approver_remarks').val(),
        "username"      : username
	}
	call_ajax(data,handler,function(result){ 
		$('#btn_close_update').trigger('click');
        if(result['msg'] == 'Message has been sent!') {
            var body_content  = '<div class="row alert alert-success">';
                body_content += '   <div class="col-sm-1">';
                body_content += '       <i class="fa fa-exclamation-circle fa-3x"></i>';
                body_content += '   </div>';
        } else {
            var body_content  = '<div class="row alert alert-warning">';
                body_content += '   <div class="col-sm-1">';
                body_content += '       <i class="fa fa-exclamation-triangle fa-3x"></i>';
                body_content += '   </div>';
        }				
                body_content += '   <div class="col-sm-11">';
                body_content += '       <h3>';
                body_content += '       	'+result['msg'];
                body_content += '       </h3>';
                body_content += '   </div>';
                body_content += '</div>';
        system_message('System Message',body_content,'');
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
 
function load_request_info_batch(pkid, req_type, callback) {
     var data = {
		"action"	    : "load_request_info_by_pkid",
		"pkid"		    : pkid,
        "username"      : username
	}
	call_ajax(data,handler,function(result){
        if(result['ob_purpose'] == 'UT') {
            $("#rbtn_edit_ut_batch").prop("checked", true);
            $("#txt_edit_time_return_batch").prop("disabled", true);
        } else {
            $("#rbtn_edit_ob_batch").prop("checked", true);
			$('#txt_edit_place_ob_batch').prop("disabled", false);
        }        
		$('#txt_edit_date_leave_batch').val(result['ob_date']);
		$('#txt_edit_place_ob_batch').val(result['ob_place'])
		$('#txt_edit_reason_batch').val(result['ob_reason']);
		$('#txt_edit_time_out_batch').val(result['ob_time_out'])
		$('#txt_edit_time_return_batch').val(result['ob_time_return']);
		$('#txt_approver_remarks').text(result['approver_remarks']);
		$('#txt_edit_approver_batch').val(result['ob_approver']).trigger('chosen:updated');	
		if(req_type == 0) {
			$('#txt_edit_employee_number_batch').val(result['empno']);
			$('#txt_edit_requested_by_batch').val(result['emp_name']);
		} else if(req_type == 1) {
			load_employee_to_assess(result['empno'],result['emp_name'],result['ob_status']);
		} 
        callback();
    });
}

function load_employee_to_assess(empno_batch, empname_batch,ob_status){
	var empno_batch = (empno_batch).split('<br>');
	var empname_batch = (empname_batch).split('<br>');
	var ob_status_batch = (ob_status).split(',');
	var container = 'container_tbl_employee_list_edit';
	var tbl_employee_list_edit = 'tbl_employee_list_edit';
	var html  = '<table id="'+tbl_employee_list_edit+'">';
		html += '	<thead>';
		html += '		<tr>';
		html += '			<th><input type="checkbox" class="chk_all_employee"></th>';
		html += '			<th>Emp #</th>';
		html += '			<th>Employee Name</th>';
		html += '			<th>Status</th>';
		html += '		</tr>';
		html += '	</thead>';
		html += '	<tbody>';
		html += '	</tbody>';
		html += '</table>';		
	$('#'+container).empty();
	$('#'+container).append(html);
	/* append table values */
	for(x=0;x<empno_batch.length;x++){
		var status = '';
		if(empno_batch[x] != '') {
			var html  = '<tr>';		
				if(ob_status_batch.indexOf(',') != -1) {	
					// alert('here '+ob_status);
					if(ob_status == 0) {						
						status = '	<td><a class="ui yellow label">FOR APPROVAL</a></td>';
						html += '	<td><input type="checkbox" class="chk_employee"></td>';
					} else if(ob_status == 1) {				
						status = '	<td><a class="ui green label">APPROVED</a></td>';
						html += '	<td><input type="checkbox" disabled class="chk_employee"></td>';
					} else if(ob_status == 2) {				
						status = '	<td><a class="ui red label">DISAPPROVED</a></td>';
						html += '	<td><input type="checkbox" disabled class="chk_employee"></td>';
					} else if(ob_status == 3) {				
						status = '	<td><a class="ui red label">CANCELLED</a></td>';
						html += '	<td><input type="checkbox" disabled class="chk_employee"></td>';
					} else if(ob_status == 4) {				
						status = '	<td><a class="ui blue label">FOR EDIT</a></td>';
					} else {				
						status = '	<td><a class="ui red label">ERROR'+ob_status_batch[x]+'</a></td>';
						html += '	<td><input type="checkbox" disabled class="chk_employee"></td>';
					}
				} else {
					if(ob_status_batch[x] == 0) {						
						status = '	<td><a class="ui yellow label">FOR APPROVAL</a></td>';
						html += '	<td><input type="checkbox" class="chk_employee"></td>';
						$('#container_buttons').show();
						$('#btn_save_n_send_batch').show();
					} else if(ob_status_batch[x] == 1) {				
						status = '	<td><a class="ui green label">APPROVED</a></td>';
						html += '	<td><input type="checkbox" disabled class="chk_employee"></td>';
					} else if(ob_status_batch[x] == 2) {				
						status = '	<td><a class="ui red label">DISAPPROVED</a></td>';
						html += '	<td><input type="checkbox" disabled class="chk_employee"></td>';
					} else if(ob_status_batch[x] == 3) {				
						status = '	<td><a class="ui red label">CANCELLED</a></td>';
						html += '	<td><input type="checkbox" disabled class="chk_employee"></td>';
					} else if(ob_status_batch[x] == 4) {				
						status = '	<td><a class="ui blue label">FOR EDIT</a></td>';
						html += '	<td><input type="checkbox" disabled class="chk_employee"></td>';
					} else {				
						status = '	<td><a class="ui red label">ERROR</a></td>';
						html += '	<td><input type="checkbox" disabled class="chk_employee"></td>';
					}	
		
					// alert('hasss '+empno_batch[x]+' '+ob_status_batch[x]);		
				}
				// array_batch_employee.push(empno_batch[x]);
				// array_batch_employee_name.push(empname_batch[x]);
				html += '	<td>'+empno_batch[x]+'</td>';
				html += '	<td>'+empname_batch[x]+'</td>';
				html += status;
				html += '</tr>';
			$('#'+tbl_employee_list_edit+' tbody').append(html);
		}
	}
	dt_emp_list_edit = $('#'+tbl_employee_list_edit).DataTable({
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
	$('#' + tbl_employee_list_edit + ' tbody').on('click', '.chk_employee', function(){			
		$('#'+tbl_employee_list_edit+' tbody tr').each(function(){
			if($(this).find('td:eq(0) .chk_employee').prop('checked')){
				/* check if checked values exist on array, add if not exist */
				var new_empno = $(this).find('td:eq(1)').text();
				var new_empname = $(this).find('td:eq(2)').text();
				// var check_exist = jQuery.inArray(new_empno,array_batch_employee);
				
				var check_exist = check_exist_on_array(array_batch_employee,new_empno);
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
	});
	
	$('.chk_all_employee').on('click', function(){
		// var rows = dt_emp_list.rows({ 'search': 'applied' }).nodes();
		var rows = dt_emp_list_edit.rows({  }).nodes();
		if($('.chk_all_employee').is(':checked')) {
			// Check checkboxes for all rows in the table
			// $('input[type="checkbox"]:not(:disabled)', rows).prop('checked', this.checked);
			$('input[type="checkbox"]:not(:disabled)', rows).prop('checked', this.checked);
			// alert('check all');
		} else {
			// alert('clear');
			// Uncheck checkboxes for all rows in the table
			$('input[type="checkbox"]', rows).prop('checked', false);
			array_batch_employee = [];
			array_batch_employee_name = [];
		}
		dt_emp_list_edit.$('input[type="checkbox"]:checked').each(function(){
			var new_empno = $(this).closest('tr').find('td:eq(1)').text();
			var new_empname = $(this).closest('tr').find('td:eq(2)').text();
			var check_exist = check_exist_on_array(array_batch_employee,new_empno);
			if(check_exist != 1){
				array_batch_employee.push(new_empno);
				array_batch_employee_name.push(new_empname);
			}
		});
	console.log('checked batch: '+array_batch_employee);
	});
}

function check_exist_on_array(array_batch,value){
	for(x=0;x<array_batch.length;x++){
		if(value == array_batch[x]){
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