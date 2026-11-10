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
                            - Double click the row to view / edit the record.<br>
							- JS and SS account can file the pass slip request (undertime or OB) of their subordinates. Just type the Employee Number or Employee Name of the employee in the form. <br><br>
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
							<button class="btn btn-primary btn-md fa fa-plus" id="btn_new_request" > New Request</button>
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
								<th>Date UT/OB</th>
								<th>Reason</th>
								<th>Time out</th>
								<th>Approver</th>
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

<!-- Modal new overtime request form -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_new_leave_request">
  <div class="modal-dialog" style="width:800px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">New Pass Slip Request</h4>
      </div>
      <form id="frm_new_leave_request" method="post"> 
          <input type="hidden" id="txt_action">
       <div class="modal-body">
        <div id="row" style="padding:0px;">
			<div class="row panel panel-default" id="2nd_row_textbox">
				<div class="col-sm-6" style="margin-top:20px;" >
					<div class="form-inline" style="padding-right:0px;">
                        <div style="padding:2px;">
							<label style="width:100px;">Employee No.</label>
                            <datalist id="txt_employee_number_list">
                            </datalist>
							<input type="text" class="form-control" style="width:71%;" name="txt_employee_number" id="txt_employee_number" list="txt_employee_number_list" autocomplete="off" required>
						</div>
                    </div>
                </div>
				<div class="col-sm-6" style="margin-top:20px;">
					<div class="form-inline" style="padding-right:0px;padding-left:0px;">
                        <div style="padding:2px;">
							<label style="width:100px;">Date of Request:</label>
							<input type="text" class="form-control" style="width:71%;" name="txt_date_request" id="txt_date_request" value="<?php echo date('M d, Y'); ?>" disabled required>
						</div>
                    </div>
                </div>
				<div class="col-sm-12" style="margin-top:2px;">
                    <div class="form-inline" style="padding-right:0px;">
                        <div style="padding:2px;">
							<label style="width:100px;">Employee Name:</label>
                            <datalist id="txt_requested_by_list">
                            </datalist>
							<input type="text" class="form-control" style="width:86%;" name="txt_requested_by" id="txt_requested_by" list="txt_requested_by_list" autocomplete="off" disabled required>
						</div>
                    </div>
                </div>
				<div class="col-sm-6" style="margin-top:2px;">
                    <div class="form-inline" style="padding-right:0px;">
                        <div style="padding:2px;">
							<label style="width:100px;">Department:</label>
							<input type="text" class="form-control" style="width:71%;" name="txt_department" id="txt_department" disabled required>
						</div>
                    </div>
                </div>
				<div class="col-sm-6" style="margin-top:2px;">
                    <div class="form-inline" style="padding-right:0px;">
                        <div style="padding:2px;">
							<label style="width:100px;">Position:</label>
							<input type="text" class="form-control" style="width:71%;" name="txt_position" id="txt_position" disabled required>
						</div>
                    </div>
                </div>
				<div class="col-sm-6" style="margin-top:2px;">
                    <div class="form-inline" style="padding-right:0px;">
                        <div style="padding:2px;">
							<label style="width:100px;">Purpose of Leaving: </label>
							<input type="radio" name="rbtn_group" value="0" id="rbtn_ut" required> Undertime <br><label style="width:100px;"></label>
							<input type="radio" name="rbtn_group" value="1" id="rbtn_ob" required> Official Business
						</div>
                    </div>
                </div>
                <div class="col-sm-6" style="margin-top:2px;">
                    <div class="form-inline" style="padding-right:0px;">
                        <div style="padding:2px;"><br>
							<label style="width:100px;">Place of OB:</label>
							<input type="text" class="form-control" style="width:71%;" name="txt_place_ob" id="txt_place_ob" disabled>
						</div>
                    </div>
                </div>        
                <div class="col-sm-12" style="margin-top:2px;">
					<div class="form-inline" style="padding-right:0px;">
						<label style="width:100px;">Reason:</label>
						<textarea id="txt_reason" class="form-control" style="width: 86%;" required></textarea>
					</div>
				</div>     
				<div class="col-sm-6" style="margin-top:2px;">
                    <div class="form-inline" style="padding-right:0px;">
                        <div style="padding:2px;">
							<label style="width:100px;">Time-out:</label>
							<input type="time" class="form-control" style="width:71%;" name="txt_time_out" id="txt_time_out" required>
						</div>
                    </div>
                </div>
				<div class="col-sm-6" style="margin-top:2px;">
                    <div class="form-inline" style="padding-right:0px;">
                        <div style="padding:2px;">
							<label style="width:100px;">Time return:</label>
							<input type="time" class="form-control" style="width:71%;" name="txt_time_return" id="txt_time_return">
						</div>
                    </div>
                </div>  
<!--
                <datalist id="txt_approver_list">
				</datalist>
-->
				<div class="col-sm-6" style="margin-top:2px;">
                    <div class="form-inline" style="padding-right:0px;">
                        <div style="padding:2px;">
							<label style="width:100px;">Approver:</label>
<!--							<input type="text" class="form-control" style="width:71%;" name="txt_approver" id="txt_approver" list="txt_approver_list" placeholder="Last Name, First Name" autocomplete="off" required>-->
                            <select data-placeholder="Select Approver" class="chosen-select"  name="txt_approver" id="txt_approver">
                                <option value=''></option>
                            </select>
						</div>
                    </div>
                </div>
				<div class="col-sm-6" style="margin-top:2px;">
                    <div class="form-inline" style="padding-right:0px;">
                        <div style="padding:2px;">
							<label style="width:100px;">Date of Leave:</label>
							<input type="date" class="form-control" style="width:71%;" name="txt_date_leave" id="txt_date_leave" min="<?php echo date("Y-m-d"); ?>" required>
						</div>
                    </div>
                </div> 
			</div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success fa fa-save" title="Click to save the record as draft" id="btn_save"> Save</button>
        <button type="button" class="btn btn-warning fa fa-envelope" title="Click to save and send the record for approval" id="btn_save_n_send"> Save & Send</button>
        <button type="button" class="btn btn-default fa fa-close" data-dismiss="modal" id="btn_close_new"> Close</button>
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal edit leave request form -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_edit_leave_request">
  <div class="modal-dialog" style="width:800px;">
    <input type="hidden" id="txt_edit_action">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Pass Slip Request</h4>
      </div>
      <form id="frm_edit_leave_request" method="post"> 
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
							<input type="text" class="form-control" style="width:71%;" name="txt_edit_date_request" id="txt_edit_date_request" disabled required>
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
							<input type="radio" name="rbtn_edit_group" value="0" id="rbtn_edit_ut" required> Undertime <br><label style="width:100px;"></label>
							<input type="radio" name="rbtn_edit_group" value="1" id="rbtn_edit_ob" required> Official Business
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
						<textarea id="txt_edit_reason" class="form-control" style="width: 86%;" required></textarea>
					</div>
				</div>     
				<div class="col-sm-6" style="margin-top:2px;">
                    <div class="form-inline" style="padding-right:0px;">
                        <div style="padding:2px;">
							<label style="width:100px;">Time-out:</label>
							<input type="time" class="form-control" style="width:71%;" name="txt_edit_time_out" id="txt_edit_time_out" required>
						</div>
                    </div>
                </div>
				<div class="col-sm-6" style="margin-top:2px;">
                    <div class="form-inline" style="padding-right:0px;">
                        <div style="padding:2px;">
							<label style="width:100px;">Time return:</label>
							<input type="time" class="form-control" style="width:71%;" name="txt_edit_time_return" id="txt_edit_time_return">
						</div>
                    </div>
                </div>  
				<div class="col-sm-6" style="margin-top:2px;">
                    <div class="form-inline" style="padding-right:0px;">
                        <div style="padding:2px;">
							<label style="width:100px;">Approver:</label>
                            <select data-placeholder="Select Approver" class="chosen-select"  name="txt_edit_approver" id="txt_edit_approver">
                                <option value=''></option>
                            </select>
						</div>
                    </div>
                </div>
				<div class="col-sm-6" style="margin-top:2px;">
                    <div class="form-inline" style="padding-right:0px;">
                        <div style="padding:2px;">
							<label style="width:100px;">Date of Leave:</label>
							<input type="date" class="form-control" style="width:71%;" name="txt_edit_date_leave" id="txt_edit_date_leave" min="<?php echo date("Y-m-d"); ?>" required>
						</div>
                    </div>
                </div> 
			</div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success fa fa-save" title="Click to save the record as draft" id="btn_update"> Update</button>
        <button type="button" class="btn btn-warning fa fa-envelope" title="Click to save and send the record for approval" id="btn_update_send"> Save & Send</button>
        <button type="button" class="btn btn-info fa fa-envelope" title="Click to update and send the record for approval" id="btn_update_revised"> Save & Send Revised </button>
        <button type="button" class="btn btn-default fa fa-close" data-dismiss="modal" id="btn_close_update"> Close</button>
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

<!-- Modal system message -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_announcement">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">What's new?</h4>
      </div>
      <div class="modal-body">
        <div class="row alert alert-info">
			<h3> 
				What's new? <br> 
				What: JS and SS account can file the pass slip request (undertime or OB) of their subordinates. <br>
				How: Just type the Employee Number or Employee Name of the employee in the form. <br>
			</h3>
		</div>
      </div>
      <div class="modal-footer">
        
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script src="../../../common_functions/common_functions.js"></script>
<script>
var handler = './handler/handler.php';
var username = $('#hd_username').val();
var date_today = "<?php echo date('Y-m-d'); ?>";
var time_today = "<?php echo date('H:i'); ?>";
var pkid = '';
var oTable = '';    
$('document').ready(function(){
	oTable = $('#tbl_ut_ob').DataTable({
                    "aaSorting": [],
					"bProcessing": true,
					"bServerSide": true,
					"sAjaxSource": "./server_side_scripts/requestor_datatable.php?username="+username
				 });    
	   
    $('#btn_close_new').click(function () {
        oTable.draw(false);
    });  

    $('#btn_close_update').click(function () {
        oTable.draw(false);
    }); 
});
// $('#modal_announcement').modal();
$('[name="rbtn_group"]').on('click',function () {
   if($('[name="rbtn_group"]:checked').val() == 0) {
       $('#txt_place_ob').prop('required',false);
       $('#txt_place_ob').prop('disabled',true);
       $('#txt_place_ob').val('');
       $('#txt_time_return').prop('disabled',true);
       $('#txt_time_return').val('');
   } else {
       $('#txt_place_ob').prop('required',true);
       $('#txt_place_ob').prop('disabled',false);
       $('#txt_time_return').prop('disabled',false);
       $('#txt_time_return').val('');
   }
});
$('[name="rbtn_edit_group"]').on('click',function () {
   if($('[name="rbtn_edit_group"]:checked').val() == 0) {
       $('#txt_edit_place_ob').prop('required',false);
       $('#txt_edit_place_ob').prop('disabled',true);
       $('#txt_edit_place_ob').val('');
       $('#txt_edit_time_return').prop('disabled',true);
       $('#txt_edit_time_return').val('');
   } else {
       $('#txt_edit_place_ob').prop('required',true);
       $('#txt_edit_place_ob').prop('disabled',false);
       $('#txt_edit_time_return').prop('disabled',false);
       $('#txt_edit_time_return').val('');
   }
});
/* CLICK FUNCTIONS */
$('#btn_new_request').click(function(){
//	load_approver_list('txt_approver_list',function () {
	$('#txt_action').val('');	
	load_approver_list('txt_approver',function () {
        $('.chosen-select').chosen({width:"71%", height: "100%"});
		load_employee_information('txt_employee_number','txt_requested_by','txt_position','txt_department','txt_request_date');
		$('#modal_new_leave_request').modal('show');
	});
});

$('#btn_home').click(function() {
	window.location.href = '../../otks_main/otks_dashboard/index_requestor.php';
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
    if($(this).find('td:eq()').text() == 'For Edit') {
		$('#btn_update').show(); 
        $('#btn_update_send').show(); 
        $('#btn_update_revised').hide(); 
    } else if($(this).find('td:eq()').text() == 'For Approval') {
        $('#btn_update').hide();
        $('#btn_update_send').hide();
        $('#btn_update_revised').show();
    } else {
        $('#btn_update').hide();
        $('#btn_update_send').hide();
        $('#btn_update_revised').hide();
    }
	
	load_approver_list('txt_edit_approver',function () {   
        load_request_info(pkid,function () {
            $('.chosen-select#txt_edit_approver').chosen({width:"71%", height: "100%"});
            $('#modal_edit_leave_request').modal('show');
        });
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
 
$('#txt_date_leave').change(function () {
	if($('#txt_date_leave').val() == date_today) {
		$('#txt_time_out').attr({ "min" : time_today });
	}
});
	
//submit functions    
$('#frm_new_leave_request').submit(function (e) {
    if($('#txt_action').val() == '') {
        $('#txt_action').val('save');
    } else {
        $('#txt_action').val('save_n_send');
    }  
    if($('#txt_action').val() != '') {
        e.preventDefault();    
        if($('#txt_approver').val() == '') {
            alert('Please select your approver.');
        } else {
            if($('#txt_action').val() == 'save') {
                save_new_request();
            } else {
                var verify_body  = '<div class="row alert alert-warning">';
                    verify_body += '   <div class="col-sm-1">';
                    verify_body += '       <i class="fa fa-exclamation-triangle fa-3x"></i>';
                    verify_body += '   </div>';
                    verify_body += '   <div class="col-sm-11">';
                    verify_body += '       <h3>';
                    verify_body += '       	Are you sure you want to send your request?';
                    verify_body += '       </h3>';
                    verify_body += '   </div>';
                    verify_body += '</div>';
                var verify_btn = '<button id="btn_verify_yes" class="btn btn-success fa fa-check">YES</button>';
                system_message('System Validation',verify_body,verify_btn);     
                $('#btn_verify_yes').click(function() {
                    save_new_request();
                });  
				$('#btn_modal_close').click(function() {
					$('#txt_action').val('');
				});
            }            
        }        
    }
});
$('#btn_save_n_send').click(function () {
    $('#txt_action').val('save_n_send');
    $('#btn_save').trigger('click');
});
$('#frm_edit_leave_request').submit(function (e) {
    if($('#txt_edit_action').val() == '') {
        $('#txt_edit_action').val('save');
    } else if($('#txt_edit_action').val() == 'save_n_send') {
        $('#txt_edit_action').val('save_n_send');
    } else if($('#txt_edit_action').val() == 'save_n_send_revised') {
        $('#txt_edit_action').val('save_n_send_revised');
    } else {
        $('#txt_edit_action').val('error');
    }  
    if($('#txt_edit_action').val() != '') {
        e.preventDefault();    
        if($('#txt_edit_action').val() == 'save') {
           save_edit_request();
        } else {
            var verify_body  = '<div class="row alert alert-warning">';
                verify_body += '   <div class="col-sm-1">';
                verify_body += '       <i class="fa fa-exclamation-triangle fa-3x"></i>';
                verify_body += '   </div>';
                verify_body += '   <div class="col-sm-11">';
                verify_body += '       <h3>';
                verify_body += '       	Are you sure you want to send your request?';
                verify_body += '       </h3>';
                verify_body += '   </div>';
                verify_body += '</div>';
            var verify_btn = '<button id="btn_verify_yes" class="btn btn-success fa fa-check">YES</button>';
            system_message('System Validation',verify_body,verify_btn);     
            $('#btn_verify_yes').click(function() {
                save_edit_request();
            });     
            $('#btn_modal_close').click(function() {
                $('#txt_edit_action').val('');
            });
        }
    }
});
$('#btn_update_send').click(function () {
    $('#txt_edit_action').val('save_n_send');
    $('#btn_update').trigger('click');
});
$('#btn_update_revised').click(function () {
    $('#txt_edit_action').val('save_n_send_revised');
    $('#btn_update').trigger('click');
});
    
$('#txt_employee_number').change(function(){
    var en = $(this).val();
    var data = {
        "action"	: "load_employee_info_by_number",
        "emp_no"	: $(this).val()
    }
    call_ajax(data, handler, function(result){
        $('#txt_requested_by').val(result['emp_name']);
        $('#txt_employee_number').val(en.toUpperCase());
        $('#txt_department').val(result['department']);
        $('#txt_position').val(result['position']);
    });
});

$('#txt_requested_by').change(function(){
    var nme = $(this).val();
    var data = {
        "action"	: "load_employee_info_by_name",
        "emp_name"	: $(this).val()
    }
    call_ajax(data, handler, function(result){
        $('#txt_employee_number').val(result['emp_no']);
        $('#txt_requested_by').val(nme.toUpperCase());
        $('#txt_department').val(result['department']);
        $('#txt_position').val(result['position']);
    });
});
 
$('input[type="text"]').keydown(function(e){
   var ingnore_key_codes = [222];
   if ($.inArray(e.keyCode, ingnore_key_codes) >= 0){
      alert('Single quote is not allowed');	  
   }
});		
$('textarea').keydown(function(e){
   var ingnore_key_codes = [222,186];
   var str = $(this).val();
   if ($.inArray(e.keyCode, ingnore_key_codes) >= 0){
      alert('Single quote is not allowed');	  
   }
});	
 
function load_approver_list(txt_approver_list,callback){
	$('#'+txt_approver_list).empty();
	var data = {
		"action" 	: "load_approver_list"
	} 
	call_ajax(data, handler, function(result){
        $('#'+txt_approver_list).append('<option value=""></option>'); 
		for(var i=0; i<result['ctr'];i++) {
			$('#'+txt_approver_list).append('<option value="'+result['username'][i]+'">'+result['approver_name'][i]+'</option>');       
		}
        $('#'+txt_approver_list).append('<option value="litoped">De Pedro, Angelito Jr.</option>');
        $('#'+txt_approver_list).append('<option value="jdfarcon">Farcon, Jeffrey</option>');
		$('#txt_edit_approver').val('');
		callback();
	});
}

function load_employee_information(txt_employee_number,txt_requested_by,txt_position,txt_department,txt_request_date){
	var data = {
		"action" 	: "load_hris_record_by_username",
		"username"	: username
	} 
	call_ajax(data, handler, function(result){
		$('#'+txt_employee_number).val(result['EmpNo']);
		$('#'+txt_requested_by).val(result['lastname']+', '+result['firstname']+' '+result['middlename']);
		$('#'+txt_position).val(result['Position']);
		$('#'+txt_department).val(result['Department']);
		/* Add a date today */
		$('#'+txt_request_date).val(date_today);
        check_employee_salary_type(result['EmpNo']);
	});
}

function check_employee_salary_type(empno) {
    var data = {
		"action" 	: "check_employee_salary_type",
		"empno"	    : empno
	} 
	call_ajax(data, handler, function(result){
		if(result['salary_type'] == 3 || result['salary_type'] == 4) {
            load_hris_record_by_managed_batch();
            // $('#txt_employee_number').prop('disabled', false);
            $('#txt_requested_by').prop('disabled', false);
        } else {
            // $('#txt_employee_number').prop('disabled', true);
            $('#txt_requested_by').prop('disabled', true);
        }
	});
}

function load_hris_record_by_managed_batch() {
    $('#txt_employee_number_list').empty();
    $('#txt_requested_by_list').empty();
    var data = {
		"action" 	: "load_hris_record_by_managed_batch",
		"username"	: username
	} 
	call_ajax(data, handler, function(result){
		for(var i=0; i<result['ctr'];i++) {
            $('#txt_employee_number_list').append('<option>'+result['empno'][i]+'</option>');
            $('#txt_requested_by_list').append('<option>'+result['fullname'][i]+'</option>');
        }
	});
}    
    
function save_new_request() {
    if($('#txt_action').val() == 'save') {
        var ob_status = 4;
    } else {
        var ob_status = 0;
    }
	var ob_place = $('#txt_place_ob').val();
	var ob_reason = $('#txt_reason').val();
	var ob_place_replace = ob_place.replace("'", " ");
	var ob_reason_replace = ob_reason.replace("'", " ");
	
    var data = {
		"action"	    : "add_new_request",
		"empno"		    : $('#txt_employee_number').val(),
		"empname"		: $('#txt_requested_by').val(),
		"position"      : $('#txt_position').val(),
		"ob_date"	    : $('#txt_date_leave').val(),
		"ob_purpose"  	: $('[name="rbtn_group"]:checked').val(),
		"ob_place"		: ob_place_replace,
		"ob_reason"		: ob_reason_replace,
		"ob_time_out"	: $('#txt_time_out').val(),
		"ob_time_return": $('#txt_time_return').val(),
		"ob_approver"	: $('#txt_approver').val(),
		"ob_status"		: ob_status,
		"username"		: username
	}
	call_ajax(data,handler,function(result){
		var body = '';
        $('#btn_close_new').trigger('click');
		if(ob_status == 4) {
			if(result['msg'] == 'New request has been saved') {
				body  = '<div class="row alert alert-success">';
				body += '   <div class="col-sm-1">';
				body += '       <i class="fa fa-exclamation-circle fa-3x"></i>';
				body += '   </div>';		
				body += '   <div class="col-sm-11">';
				body += '       <h3>';
				body += '       	'+result['msg'];
				body += '       </h3>';
				body += '   </div>';
				body += '</div>';
			} else { 
				body += '<div class="row alert alert-danger">';
				body += '   <div class="col-sm-1">';
				body += '       <i class="fa fa-info-circle fa-2x"></i>';
				body += '   </div>';
				body += '   <div class="col-sm-11">';
				body += '       <h3>'+result['msg']+'</h3>';
				body += '   </div>';
				body += '</div>'; 
			}
			system_message('System Message',body,'');
		} else if(ob_status == 0) {
			if(result['new_pkid'] != 0) {
				send_email_to_approver(result['new_pkid']);
			} else {
				body = '<div class="row alert alert-danger">';
				body += '   <div class="col-sm-1">';
				body += '       <i class="fa fa-info-circle fa-2x"></i>';
				body += '   </div>';
				body += '   <div class="col-sm-11">';
				body += '       <h3>ERROR! Invalid record!</h3>';
				body += '   </div>';
				body += '</div>'; 
				system_message('System Message',body,'');
			}
			
		} else {
				body += '<div class="row alert alert-danger">';
				body += '   <div class="col-sm-1">';
				body += '       <i class="fa fa-info-circle fa-2x"></i>';
				body += '   </div>';
				body += '   <div class="col-sm-11">';
				body += '       <h3>'+result['msg']+'</h3>';
				body += '   </div>';
				body += '</div>'; 
			system_message('System Message',body,'');
		}
	});
}
    
function save_edit_request() {
	var ob_place = $('#txt_edit_place_ob').val();
	var ob_reason = $('#txt_edit_reason').val();
	var ob_place_replace = ob_place.replace("'", " ");
	var ob_reason_replace = ob_reason.replace("'", " ");
    if($('#txt_edit_action').val() == 'save') {
        var ob_status = 4;
    } else if($('#txt_edit_action').val() == 'save_n_send') {
        var ob_status = 0;
    } else if($('#txt_edit_action').val() == 'save_n_send_revised') {
        var ob_status = 0;
    } else {
        var ob_status = 5;
    }
	if(ob_status == 5) {
		var error_msg  = '<div class="row alert alert-danger">';
			error_msg += '   <div class="col-sm-1">';
			error_msg += '       <i class="fa fa-info-circle fa-2x"></i>';
			error_msg += '   </div>';
			error_msg += '   <div class="col-sm-11">';
			error_msg += '       <h3>ERROR!</h3>';
			error_msg += '   </div>';
			error_msg += '</div>'; 
	system_message('System Message',error_msg,'');
	} else {
		var data = {
			"action"	    : "update_request",
			"pkid"		    : pkid,
			"empno"		    : $('#txt_edit_employee_number').val(),
			"empname"		: $('#txt_edit_requested_by').val(),
			"position"      : $('#txt_edit_position').val(),
			"ob_date"	    : $('#txt_edit_date_leave').val(),
			"ob_purpose"  	: $('[name="rbtn_edit_group"]:checked').val(),
			"ob_place"		: ob_place_replace,
			"ob_reason"		: ob_reason_replace,
			"ob_time_out"	: $('#txt_edit_time_out').val(),
			"ob_time_return": $('#txt_edit_time_return').val(),
			"ob_approver"	: $('#txt_edit_approver').val(),
			"ob_status"		: ob_status,
			"username"		: username
		}
		call_ajax(data,handler,function(result){
			$('#modal_edit_leave_request').modal('hide');
			var body = '';
			if($('#txt_edit_action').val() == 'save') {
					body += '<div class="row alert alert-success">';
					body += '   <div class="col-sm-1">';
					body += '       <i class="fa fa-exclamation-circle fa-3x"></i>';
					body += '   </div>';		
					body += '   <div class="col-sm-11">';
					body += '       <h3>';
					body += '       	'+result['msg'];
					body += '       </h3>';
					body += '   </div>';
					body += '</div>';
				system_message('System Message',body,'');
			} else if($('#txt_edit_action').val() == 'save_n_send'){
			   send_email_to_approver(pkid);
			} else if($('#txt_edit_action').val() == 'save_n_send_revised'){
			   send_email_to_approver_revised(pkid);
			} else {
					body += '<div class="row alert alert-danger">';
					body += '   <div class="col-sm-1">';
					body += '       <i class="fa fa-info-circle fa-2x"></i>';
					body += '   </div>';
					body += '   <div class="col-sm-11">';
					body += '       <h3>'+result['msg']+'</h3>';
					body += '   </div>';
					body += '</div>'; 
				system_message('System Message',body,'');
			}
			$('#btn_modal_close').click(function () {
				$('#btn_close_new').trigger('click');
			});  
		});
	}
}
 
function load_request_info(pkid, callback) {
     var data = {
		"action"	    : "load_request_info_by_pkid",
		"pkid"		    : pkid,
        "username"      : username
	}
	call_ajax(data,handler,function(result){
        if(result['ob_purpose'] == 'UT') {
            $("#rbtn_edit_ut").prop("checked", true);
            $("#txt_edit_time_return").prop("disabled", true);
        } else {
            $("#rbtn_edit_ob").prop("checked", true);
        }

        $('#txt_edit_employee_number').val(result['empno']);
        $('#txt_edit_requested_by').val(result['emp_name']);
		$('#txt_edit_date_request').val(result['date_time_created']);
		$('#txt_edit_position').val(result['position']);
		$('#txt_edit_department').val(result['department']);
		$('#txt_edit_date_leave').val(result['ob_date']);
		$('#txt_edit_place_ob').val(result['ob_place'])
		$('#txt_edit_reason').val(result['ob_reason']);
		$('#txt_edit_time_out').val(result['ob_time_out'])
		$('#txt_edit_time_return').val(result['ob_time_return']);
		$('#txt_edit_approver').val(result['ob_approver']).trigger('chosen:updated');		
        callback();
    });
}

function send_email_to_approver(pkid) {
	var data = {
        "action"              : "send_email_to_approver",
		"req_type"			  : "new",
		"pkid"				  : pkid
    }
    call_ajax(data,handler,function(result){
		var email_msg = '';
		var body = '';
		$('#btn_close_new').trigger('click');
		if(result['msg_email'] == 'Message has been sent!') {
				email_msg = 'Record was successfully saved and sent to approver';
				body += '<div class="row alert alert-success">';
				body += '   <div class="col-sm-1">';
				body += '       <i class="fa fa-exclamation-circle fa-3x"></i>';
				body += '   </div>';
		} else {	
				email_msg = 'ERROR: '+result['msg_email'];
				body += '<div class="row alert alert-warning">';
				body += '   <div class="col-sm-1">';
				body += '       <i class="fa fa-exclamation-triangle fa-3x"></i>';
				body += '   </div>';
		}				
				body += '   <div class="col-sm-11">';
				body += '       <h3>';
				body += '       	'+email_msg;
				body += '       </h3>';
				body += '   </div>';
				body += '</div>';
		system_message('System Message',body,'');
	});
}

function send_email_to_approver_revised(pkid) {
	var data = {
        "action"              : "send_email_to_approver",
		"req_type"			  : "revised",
		"pkid"				  : pkid
    }
    call_ajax(data,handler,function(result){
		$('#btn_close_new').trigger('click');
		var email_msg = '';
		var body = '';
		if(result['msg_email'] == 'Message has been sent!') {
				email_msg = 'Record was successfully updated and sent to approver';
				body += '<div class="row alert alert-success">';
				body += '   <div class="col-sm-1">';
				body += '       <i class="fa fa-exclamation-circle fa-3x"></i>';
				body += '   </div>';
		} else {	
				email_msg = 'ERROR: '+result['msg_email'];
				body += '<div class="row alert alert-warning">';
				body += '   <div class="col-sm-1">';
				body += '       <i class="fa fa-exclamation-triangle fa-3x"></i>';
				body += '   </div>';
		}				
				body += '   <div class="col-sm-11">';
				body += '       <h3>';
				body += '       	'+email_msg;
				body += '       </h3>';
				body += '   </div>';
				body += '</div>';
		system_message('System Message',body,'');
	});
}

function cancel_request(serialized_data) {
    var data = {
        "action"              : "cancel_request"
    }
    call_ajax_serialize(data, serialized_data, handler, function(result){
		var msg = result['msg'];
        if(result['msg'] == 'Message has been sent!' || result['msg'] == 'Request was successfully cancelled!') {
            var body  = '<div class="row alert alert-success">';
                body += '   <div class="col-sm-1">';
                body += '       <i class="fa fa-exclamation-circle fa-3x"></i>';
                body += '   </div>';
			msg = 'Request was successfully cancelled';
        } else {
            var body  = '<div class="row alert alert-warning">';
                body += '   <div class="col-sm-1">';
                body += '       <i class="fa fa-exclamation-triangle fa-3x"></i>';
                body += '   </div>';
        }				
                body += '   <div class="col-sm-11">';
                body += '       <h3>';
                body += '       	'+msg;
                body += '       </h3>';
                body += '   </div>';
                body += '</div>';
        system_message('System Message',body,'');
        $('#btn_close_new').trigger('click');
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
 
    
</script>