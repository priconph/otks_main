<?php
/* Include employee information */
require_once('./pages/get_employee_username.php');
$fkid = $_GET['pkid'];
?>
<input type="hidden" id="hidden_username" value="<?php echo $username; ?>">
<input type="hidden" id="hidden_date_today" value="<?php echo date('Y-m-d'); ?>">
<div>
    <div class="row" style="margin-top:20px;"> <!--  panel panel-default -->
        <div class="col-sm-6 col-sm-offset-7" style="width:45%;padding:0px;">
            <button type="button" class="btn btn-success fa fa-save" id="btn_save_ot" title="Click to save the record as draft"> Save Draft</button>
            <button type="button" class="btn btn-warning fa fa-envelope" id="btn_save_n_send_ot" title="Click to save and send the record for approval"> Save & Send</button>
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
                            <i class="fa fa-info-circle" style="color:blue;"></i> Double click the row to view / edit the record.<br><br>
                            <i class="fa fa-info-circle" style="color:blue;"></i> OT Conversion: 0-29 mins = 0 | 30-59 mins = 0.5 | 60 mins = 1 <br><br>
                            <i class="fa fa-info-circle" style="color:blue;"></i> System will correct the valid OT based on time in and out. <br><br>
                            <i class="fa fa-info-circle" style="color:blue;"></i> "Save Draft" button: Save your overtime as draft. OT can still be updated. <br><br>
                            <i class="fa fa-info-circle" style="color:blue;"></i> "Save & Send" button: Overtime is subject for approval to assigned approver. System will not allow the following: "No record found!", "Multiple Record", "No Time In", "No Time Out" to proceed. Invalid overtime can be filed manually (printing the filed OT).<br><br>
                            <i class="fa fa-info-circle" style="color:blue;"></i> "Print" button: (Draft Request) User can print the filed overtime.  <br><br>
                            <i class="fa fa-info-circle" style="color:blue;"></i> Excess of 8 hours are only classified as "OVERTIME" based on company shifting schedules. Preceeding OT's is one of the limitation of the system. Requestor will have to print the request from the system to process the overtime.  <br><br>
                            <i class="fa fa-info-circle" style="color:blue;"></i> Row in blue means that there are adjustment happen on the record.  <br><br>
                            
                            </h5>
                        <!-- <h5><p>Row in <font color="red">Red</font> are uncontrolled documents.</p></h5>
                        <h5><p>Row in <font color="green">Green</font> are unactive documents.</p></h5> -->
                      </div>
                    </div>	
                   </div>	
                </div>	
                <div class="row" style="padding-right:2.5%;"> <!--  panel panel-default -->
					<div class="col-sm-3 col-sm-offset-6" id="container_btn_main" style="width:70%;padding:0px;">
						<button type="button" class="btn btn-primary fa fa-user-plus" id="btn_add_employee"> Add Employee</button>
                        <!--<button type="button" class="btn btn-primary fa fa-users" id="btn_add_batch_employee">Add Employee by Batch</button>-->
                        <button type="button" class="btn btn-primary fa fa-users" id="btn_add_batch_employee_own_list">Add Employee by Batch</button>
                        <!--<button class="fa btn btn-primary">
						  <div class="dropdown ">
							  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="color:white;"><span class="fa fa-users"> </span> Add Employee by Batch <span class="caret"></span></a>
							  <ul class="dropdown-menu">
								<li><a href="#" id="btn_add_batch_employee" class=""> Per Section</a></li>
								<li role="separator" class="divider" style="padding:0px;margin:0px;"></li>
								<li><a href="#" id="btn_add_batch_employee_own_list" class=""> Per Batch (User defined batch)</a></li>
							  </ul>
						  </div>
						</button>-->
						<!-- <button type="button" class="btn btn-primary fa fa-upload" id="btn_upload_employees">Upload Employees</button> -->
						<button type="button" class="btn btn-primary fa fa-street-view" id="btn_other_employee"> Other Employee</button>
					</div>
				</div>
				<div class="row" style="padding:5px;">
					<div class="col-sm-12">
						<h3><span class="fa fa-users"></span> Employee Overtime</h3>
						<div id="container_tbl_employee_overtime"></div>
					</div>
				</div>
				
				<div id="container_upload_employee" method="post">
					<form id="frm_upload_employees">
						<div class="row" style="padding:5px;">
							<h3 style="margin-left:15px;"><span class="fa fa-user-plus"></span> Batch Upload Employees</h3>
							<div class="col-sm-6 panel ">
								<div class="form-inline" style="padding:2px;">
									<label style="width:150px;">Date:</label>
									<input class="form-control" type="date" name="txt_upload_date" id="txt_upload_date" required>
								</div>
								<div class="form-inline" style="padding:2px;">
									<label style="width:150px;">Division:</label>
									<input class="form-control" type="text" name="txt_upload_division" required>
								</div>
								<div class="form-inline" style="padding:2px;">
									<label style="width:150px;">Department:</label>
									<input class="form-control" type="text" name="txt_upload_department" required>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-inline" style="padding:2px;">
									<label style="width:150px;">Section:</label>
									<input class="form-control" type="text" name="txt_upload_section" required>
								</div>
								<div class="form-inline" style="padding:2px;">
									<label style="width:150px;">Filed Overtime</label>
									<input class="form-control" type="number" name="txt_upload_filled_overtime" value=0 required>
								</div>
								<div class="form-inline" style="padding:2px;">
									<label style="width:150px;">Remarks:</label>
									<input class="form-control" type="text" name="txt_upload_remarks">
								</div>
							</div>
						</div>
						<div class="col-sm-4 col-sm-offset-8" id="container_btn_upload_employees">
							<button class="btn btn-md btn-success fa fa-save" type="submit" id="btn_save_upload_employee"> Save</button>
							<button class="btn btn-md btn-default fa fa-close" type="button" id="btn_close_upload_employee"> Close</button>
							
						</div>
					</form>
				</div><!--Add upload end--> 
	 	 	</div>
		</div>
	</div>
</div>
</div>
<!-- Modal system message -->
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
                        <div class="col-sm-6 col-sm-offset-6" style="">
                            <div class="form-inline" style="padding:0px;">
                                <label style="width:150px;">Date:</label>
                                <input class="form-control" type="date" name="txt_add_employee_date" id="txt_add_employee_date" required>
                            </div>
                        </div>
                        <div class="col-sm-6 " class="form-inline">
                            <div style="padding:0px;">
                                <datalist id="txt_add_employee_number_list">
                                </datalist>
                                <label style="width:150px;">Employee Number:</label>
                                <input class="form-control" type="text" name="txt_add_employee_number" id="txt_add_employee_number"  maxlength="4" list="txt_add_employee_number_list" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-sm-6" style="margin-top:0px;" class="form-inline">
                            <div style="padding:0px;">
                                <label style="width:150px;">Filed Overtime</label>
                                <input class="form-control" type="number" name="txt_add_employee_filled_overtime" id="txt_add_employee_filled_overtime" min="0.5" step="0.5" required>
                            </div>
                        </div>
                        <div class="col-sm-12 ">
                            <div class="form-inline" style="padding:0px;">
                                <datalist id="txt_add_employee_name_list">
                                </datalist>
                                <label style="width:150px;">Employee Name:</label>
                                <input class="form-control" style="width:100%" type="text" name="txt_add_employee_name" id="txt_add_employee_name" list="txt_add_employee_name_list" autocomplete="off" required>
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
        <button class="btn btn-md btn-default fa fa-close" type="button" id="btn_close_add_employee"> Close</button>
		      </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal system message -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_add_other_employee">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><span class="fa fa-user-plus"></span> Add Other Employee</h4>
      </div>
      <div class="modal-body">
            <div id="">
                <form id="frm_other_employee" method="post">
                    <div class="row" style="padding:0px;">
                        <div class="col-sm-6 col-sm-offset-6" style="">
                            <div class="form-inline" style="padding:0px;">
                                <label style="width:150px;">Date:</label>
                                <input class="form-control" type="date" name="txt_add_employee_date" id="txt_other_date" required>
                            </div>
                        </div>
                        <div class="col-sm-6 " class="form-inline">
                            <div style="padding:0px;">
                                <datalist id="txt_other_employee_number_list">
                                </datalist>
                                <label style="width:150px;">Employee Number:</label>
                                <input class="form-control" type="text" name="txt_add_employee_number" id="txt_other_employee_number"  maxlength="4" list="txt_other_employee_number_list" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-sm-6" style="margin-top:0px;" class="form-inline">
                            <div style="padding:0px;">
                                <label style="width:150px;">Filed Overtime</label>
                                <input class="form-control" type="number" name="txt_add_employee_filled_overtime"  min="0.5" step="0.5" required>
                            </div>
                        </div>
                        <div class="col-sm-12 ">
                            <div class="form-inline" style="padding:0px;">
                                <datalist id="txt_other_employee_name_list">
                                </datalist>
                                <label style="width:150px;">Employee Name:</label>
                                <input class="form-control" style="width:100%" type="text" name="txt_add_employee_name" id="txt_other_employee_name" list="txt_other_employee_name_list" autocomplete="off" required>
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
        <button class="btn btn-md btn-success fa fa-save" type="submit" id="btn_save_other_employee"> Save</button>
        <button class="btn btn-md btn-default fa fa-close" type="button" id="btn_close_other_employee"> Close</button>
		      </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

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
						<label style="width:150px;">Date: </label><input type="date" class="form-control" id="txt_batch_date" required>
						<label style="width:150px;">Filed Overtime: </label><input type="number" class="form-control" id="txt_batch_filled_overtime" min="0.5" step="0.5" required>
					</div>
					<div class="col-sm-6">
						<label style="width:150px;">Remarks: </label><input type="text" class="form-control" id="txt_batch_remarks">
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

<!-- Modal update filed OT -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_for_update">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"> System Message</h4>
      </div>
      <div class="modal-body">
        <div class="row alert alert-info">
	       	<div class="col-sm-1">
				<i class="fa fa-info-circle fa-3x"></i>
			</div>
			<div class="col-sm-11">
				<h3>You have items for update. Kindly update the record with " <font color='red'><span class='fa fa-refresh'> </span> FOR UPDATE! </font> " on System comment because of record adjustment.
				<!-- <br><br> ***Note: Overtime added before are not included in the system message. System patch implementation is May 17, 2016 8:00am. --></h3>
			</div>
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

<script src="../../../common_functions/common_functions.js" type="text/javascript"></script>

<div id="container_loading" style="display:none;background: rgba(241, 245, 241, .5);position:absolute;width:100%;height:100%;top:0px;padding-top:20%;" align="center"><img src="libraries/loading.gif" style="width:14%;height:57%;"></div>
<span class="sr-only">Loading...</span></div>

<script>
	/* System Variables */
	var handler = './handler/handler.php';
	
	/* Variable Table ID's */
	var table_employee_overtime = 'tbl_employee_overtime';
	var tbl_employee_list 	   	= 'tbl_employee_list';
	
    /* Data table declaration */
    var dt_emp_overtime = "";
    var dt_emp_list = "";
	/* Variable */
	var username 	= $('#hidden_username').val();
	var date_today 	= $('#hidden_date_today').val();
    var fkid        = "<?php echo $fkid; ?>";
	var fullname	= '';
	var section 	= '';
	var department 	= '';
	var division 	= '';
	var min_date    = '';
	var max_date    = '';
	var ot_type     = '';
	var req_status  = '';
	var tbl_row    = '';
	var validate_save    = 0;

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
        array_exist_validate = {};
        array_validate_ob_filed = {};
	var validate_exist = 0;
	var duplicate_rec = '';	
	var record_ctr = 0;
	var duplicate_filed = '';
	var for_update_checker = 0;
	
    var array_duplicate_rows = {};
		array_duplicate_rows.empno = [];
		array_duplicate_rows.name = [];
		array_duplicate_rows.date_dtin = [];
		array_duplicate_rows.date_dtout = [];
	var array_duplicate_record_db = {};
		array_duplicate_record_db.empno = [];
		array_duplicate_record_db.name = [];
		array_duplicate_record_db.date_dtin = [];
		array_duplicate_record_db.date_dtout = [];
	
    $(document).on({
        ajaxStart: function() { $('#container_loading').show(); },
        ajaxStop: function() { $('#container_loading').hide(); }
    });
    
    function load_employee_overtime(callback){
		var container_id = 'container_tbl_employee_overtime';
		/* empty the container */
		$('#'+container_id).empty();
		/* append new table */
		var html  = '<table id="'+table_employee_overtime+'" class="table table-hover table-striped table-bordered" style="">';
			html += '	<thead>';
			html += '		<tr>';
			html += '			<th>EN</th>';
			html += '			<th>Employee Name</th>';
			html += '			<th>Date / Time In</th>';
			html += '			<th>Date / Time Out</th>';
			html += '			<th>OT Date</th>';
			html += '			<th>Filed OT</th>';
			html += '			<th>Valid OT</th>';
			html += '			<th>Remarks</th>';
			html += '			<th>System Comment</th>';
			html += '			<th>Action</th>';
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
              "orderable": false
            }],
            "paginate" : false
        });
        
		/* append table cell values */
		var data = {
			"action" 	: "get_employee_overtime",
			"fkid"		: fkid,
			"username"	: username
		}
		call_ajax(data, handler, function(result){
			var ctr = result['ctr'];
            var msg = '';
            var disabled = '';
			var bg = '';
			var for_update_msg = '';
			for(x=0;x<ctr;x++){
				// if(result['empno'][x] == '1197'){
				// alert(' date in orig '+result['date_time_in_orig'][x]+' date in '+result['date_time_in'][x]+' date out '+result['date_time_out'][x]+' checker '+result['checker'][x]);
				// }
				if(result['checker'][x] == '1') {
					for_update_msg = '';
				} else if(result['checker'][x] == '0') {
					for_update_msg = ' <font color="red"><span class="fa fa-refresh"> FOR UPDATE!</span> </font><br>';
					for_update_checker = 1;
				} else {
					for_update_msg = ' <font color="red"><span class="fa fa-warning"> ERROR!</span> </font><br>';
				}
                if(result['system_comment'][x] == 'No record found!' || result['system_comment'][x] == 'No time in!' || result['system_comment'][x] == 'No time out!') {
                    msg = '<font color="red">'+for_update_msg+result['system_comment'][x]+'</font>';
                } else if(result['system_comment'][x] == 'Ok!') {
                    msg = for_update_msg+result['system_comment'][x];
                } else {
                    if(result['valid_ot'][x] == 0) {
                        msg = '<font color="red">'+for_update_msg+result['system_comment'][x]+'</font>';
                    } else {
                        msg = '<font color="blue">'+for_update_msg+result['system_comment'][x]+'</font>';
                    }                    
                }
					
                if(req_status == 0 || req_status == 1){
                    disabled = '';
                } else {
                    disabled = ' disabled ';
                }
				var date_time_in= result['date_time_in'][x];
				if(date_time_in == '') {
					date_time_in = 'N/A';
				} 
				var date_time_out= result['date_time_out'][x];
				if(date_time_out == '') {
					date_time_out = 'N/A';
				} 
				row_node = dt_emp_overtime.row.add([
                    result['empno'][x],
                    result['emp_name'][x],
                    date_time_in,
                    date_time_out,
                    result['ot_date'][x],
                    result['filed_ot'][x],
                    result['valid_ot'][x],
                    result['remarks'][x],
                    msg,
                    '<button class="btn btn-sm btn-danger fa fa-trash-o" value="'+result['pkid'][x]+'" type="button"'+disabled+'></button>'
                ]).draw(false);
				// $('body').append('EN:'+result['empno'][x]+' checker: '+result['checker'][x]+' raw in ['+result['date_time_in_new'][x]+'] ot ['+result['date_time_in_orig'][x]+'] raw out ['+result['date_time_out_new'][x]+'] ot ['+result['date_time_out_orig'][x]+']<br><hr>');			
			}
			callback();
		});
	}
	
	function save_information(action, serialized_data){
		var data = {
			"action"	: action
		}
		call_ajax_serialize(data, serialized_data, handler, function(result){
			duplicate_filed = ''; 
            show_main_container();
			var body_val = '';
			if(result['msg'] == 'No record found!' || result['msg'] == 'No time in!' || result['msg'] == 'No time out!' || result['msg'] == 'Invalid overtime!') {
				var msg = '<font color="red">'+result['msg']+'</font>';
			} else if(result['msg'] == 'Ok!') {
				var msg = result['msg'];
			} else {
                if(result['valid_ot'] == 0) {
                    var msg = '<font color="red">'+result['msg']+'</font>';   
                } else {
                    var msg = '<font color="blue">'+result['msg']+'</font>';
                }				
			}
            // if(result['validate_ot'] == 'YES') {
               // duplicate_filed += '<tr>';
               // duplicate_filed += '<td>'+result['emp_no']+'</td>';
               // duplicate_filed += '<td>'+result['emp_name']+'</td>';
               // duplicate_filed += '<td>'+result['date_time_in']+'</td>';
               // duplicate_filed += '<td>'+result['date_time_out']+'</td>';
               // duplicate_filed += '</tr>';
           // } else {
                // validate_duplicate(
                    // result['emp_no'],
                    // result['emp_name'],
                    // result['date_time_in'],
                    // result['date_time_out'],
                    // result['date_ot'],
                    // result['filed_ot'],
                    // result['valid_ot'],
                    // result['remarks'],
                    // msg,
                    // result['fkid']
                // );
           // }	
            if(result['validate_ot'] == 'NO') {
                validate_duplicate(
                    result['emp_no'],
                    result['emp_name'],
                    result['date_time_in'],
                    result['date_time_out'],
                    result['date_ot'],
                    result['filed_ot'],
                    result['valid_ot'],
                    result['remarks'],
                    msg,
                    result['fkid']
                );
           } else {
               duplicate_filed += '<tr>';
               duplicate_filed += '<td>'+result['emp_no']+'</td>';
               duplicate_filed += '<td>'+result['emp_name']+'</td>';
               duplicate_filed += '<td>'+result['date_time_in']+'</td>';
               duplicate_filed += '<td>'+result['date_time_out']+'</td>';
               duplicate_filed += '</tr>';
           }	
			if(duplicate_filed != '') {
				body_val += '<div class="alert alert-danger"><h5>Failed to add the following record due to duplicate OT filed. Overtime was already filed separately by '+result['validate_ot']+'.</h5></div>';
				body_val += '<table class="table">';
				body_val += ' <thead>';
				body_val += '  <tr>';
				body_val += '   <th>Empno</th>';
				body_val += '   <th>Name</th>';
				body_val += '   <th>DateIn / TimeIn</th>';
				body_val += '   <th>DateOut / TimeOut</th>';
				body_val += '  </tr>';
				body_val += ' </thead>';
				body_val += ' <tbody>';
				body_val += duplicate_filed;
				body_val += ' </tbody>';
				body_val += '</table>';
				system_message('System Validation',body_val,'');
			} else {
				if(array_duplicate_rows['empno'].length != 0) {
					system_message('System Validation',body_val,'');
				} else {
					$('#modal_batch_add_employee').modal('hide');
				}
			}
            
			$('#txt_add_employee_number').val('');
            $('#txt_add_employee_name').val('');
			$('#txt_other_employee_number').val('');
            $('#txt_other_employee_name').val('');
			
			/* append duplicate rows */
			if(array_duplicate_rows['empno'].length == 0){
				return false;
			}
				
			body_val = '<div class="alert alert-danger"><h5>Failed to add the following record due to duplicate OT filed. Overtime was already exist.</h5></div>';
			   body_val += '<table class="table" id="tbl_row_exist">';
			   body_val += ' <thead>';
			   body_val += '  <tr>';
			   body_val += '   <th>Empno</th>';
			   body_val += '   <th>Name</th>';
			   body_val += '   <th>DateIn / TimeIn</th>';
			   body_val += '   <th>DateOut / TimeOut</th>';
			   body_val += '  </tr>';
			   body_val += ' </thead>';
			   body_val += ' <tbody>';
			   // body_val += duplicate_rec;
			   body_val += ' </tbody>';
			   body_val += '</table>';
			   $('#modal_system_message .modal-body').append(body_val);
				$('#modal_system_message .modal-body #tbl_row_exist tbody').empty();
			   for(x=0;x<array_duplicate_rows['empno'].length;x++){
				  var body_dup  = '<tr>';
					  body_dup += '	<td>'+ array_duplicate_rows['empno'][x] +'</td>';
					  body_dup += '	<td>'+ array_duplicate_rows['name'][x] +'</td>';
					  body_dup += '	<td>'+ array_duplicate_rows['date_dtin'][x] +'</td>';
					  body_dup += '	<td>'+ array_duplicate_rows['date_dtout'][x] +'</td>';
				 $('#modal_system_message .modal-body #tbl_row_exist tbody').append(body_dup);
			   }
			   reset_duplicate_rows();
		});
	}
	
	function update_information(action, serialized_data){
		var data = {
			"action"	: action
		}
		call_ajax_serialize(data, serialized_data, handler, function(result){
            show_main_container();
			var remarks = $('#txt_update_employee_remarks').val();
			var remarks_replace = remarks.replace("'", " ");
			if(result['msg'] == 'No record found!' || result['msg'] == 'No time in!' || result['msg'] == 'No time out!' || result['msg'] == 'Invalid overtime!') {
					msg = '<font color="red">'+result['msg']+'</font>';
            } else if(result['msg'] == 'Ok!') {
                msg = result['msg'];
            } else {
                msg = '<font color="blue">'+result['msg']+'</font>';
            }
			dt_emp_overtime.cell(tbl_row.find('td:eq(2)')).data(result['date_time_in']);
			dt_emp_overtime.cell(tbl_row.find('td:eq(3)')).data(result['date_time_out']);
			dt_emp_overtime.cell(tbl_row.find('td:eq(4)')).data(result['date_ot']);
			dt_emp_overtime.cell(tbl_row.find('td:eq(5)')).data(result['filed_ot']);
			dt_emp_overtime.cell(tbl_row.find('td:eq(6)')).data(result['valid_ot']);
			dt_emp_overtime.cell(tbl_row.find('td:eq(7)')).data(remarks_replace);
			dt_emp_overtime.cell(tbl_row.find('td:eq(8)')).data(msg);
			$('#modal_update_employee_overtime').modal('hide');
		});
	}
	
	function remove_filed_ot(pkid) {
		var body  = '<div class="row alert alert-danger">';
			body += '   <div class="col-sm-1">';
			body += '       <i class="fa fa-exclamation-triangle fa-3x"></i>';
			body += '   </div>';
			body += '   <div class="col-sm-11">';
			body += '       <h3>';
			body += '       	Are you sure you want to remove the record of: <br>';
			body += '       	Employee Number: '+(tbl_row.find('td:eq(0)').text())+'<br>';
			body += '       	Employee Name: '+(tbl_row.find('td:eq(1)').text())+'<br>';
			body += '       	Date OT: '+(tbl_row.find('td:eq(4)').text())+'<br>';
			body += '       	Filed OT: '+(tbl_row.find('td:eq(5)').text())+'<br>';
			body += '       </h3>';
			body += '   </div>';
			body += '</div>';
		var button = '<button  class="btn btn-success fa fa-save" type="button" id="btn_yes_remove_record"> YES </button>';
		system_message('System Validation',body,button);
		
		$('#btn_yes_remove_record').click(function () {
			dt_emp_overtime.row(tbl_row).remove().draw( false );
			$('#modal_system_message').modal('hide');
            array_delete.push(pkid);
            console.log('array delete '+array_delete);
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
		  dt_emp_list.$('input[type="checkbox"]:checked').each(function(){
            var new_empno = $(this).closest('tr').find('td:eq(1)').text();
            var new_empname = $(this).closest('tr').find('td:eq(2)').text();
            var check_exist = check_exist_on_array(new_empno);
            if(check_exist != 1){
                array_batch_employee.push(new_empno);
                array_batch_employee_name.push(new_empname);
            }
          });
        console.log('checked batch: '+array_batch_employee);
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
	
	function reset_duplicate_rows() {
		array_duplicate_rows = {};
		array_duplicate_rows.empno = [];
		array_duplicate_rows.name = [];
		array_duplicate_rows.date_dtin = [];
		array_duplicate_rows.date_dtout = [];
		array_duplicate_record_db = {};
		array_duplicate_record_db.empno = [];
		array_duplicate_record_db.name = [];
		array_duplicate_record_db.date_dtin = [];
		array_duplicate_record_db.date_dtout = [];
        duplicate_filed = '';
	}
    
    function reset_ticked_rows() {
        array_batch_employee = [];
		array_batch_employee_name = [];
    }
	
	function add_batch_employee(){
        /* Query that will check the batch filed OT. Passed the data from the array then let the handler to check the filed OT. */
        var msg = "";
		var body_val = "";
		var batch_remarks = $('#txt_batch_remarks').val();
		var batch_remarks_replace = batch_remarks.replace("'", " ");
		$('#modal_system_message .modal-body').empty();
		duplicate_filed = '';
			var data = {
				"action" 							: "check_ot_filed_array",
				"username"							: username,
				"txt_add_employee_number"			: array_batch_employee,
				"txt_add_employee_name"				: array_batch_employee_name,
				"txt_add_employee_date"				: $('#txt_batch_date').val(),
				"txt_add_employee_filled_overtime"	: $('#txt_batch_filled_overtime').val(),
				"txt_add_employee_remarks"			: batch_remarks_replace,
				"fkid"								: fkid,
				"ot_type"							: ot_type,
				"username"							: username
			}
            call_ajax(data, handler, function(result){
               for(x=0;x<result['emp_no'].length;x++) {
                    if(result['msg'][x] == 'No record found!' || result['msg'][x] == 'No time in!' || result['msg'][x] == 'No time out!' || result['msg'][x] == 'Invalid overtime!') {
                        msg = '<font color="red">'+result['msg'][x]+'</font>';
                    } else if(result['msg'][x] == 'Ok!') {
                        msg = result['msg'][x];
                    } else {
                        if(result['valid_ot'][x] == 0) {
                            var msg = '<font color="red">'+result['msg'][x]+'</font>';   
                        } else {
                            var msg = '<font color="blue">'+result['msg'][x]+'</font>';
                        }	
//                        msg = '<font color="blue">'+result['msg'][x]+'</font>';
                    }
                   if(result['validate_ot'][x] == 'NO') {
                       validate_duplicate(
                            result['emp_no'][x],
                            result['emp_name'][x],
                            result['date_time_in'][x],
                            result['date_time_out'][x],
                            result['date_ot'][x],
                            result['filed_ot'][x],
                            result['valid_ot'][x],
                            result['remarks'][x],
                            msg,
                            result['fkid'][x]
                        );
                   }else{
                       duplicate_filed += '<tr>';
                       duplicate_filed += '<td>'+result['emp_no'][x]+'</td>';
                       duplicate_filed += '<td>'+result['emp_name'][x]+'</td>';
                       duplicate_filed += '<td>'+result['date_time_in'][x]+'</td>';
                       duplicate_filed += '<td>'+result['date_time_out'][x]+'</td>';
                       duplicate_filed += '</tr>';
                   }
                    // alert(body);
                    if(x==(array_batch_employee.length-1)) {
                        if(duplicate_filed != '') {
                            body_val += '<div class="alert alert-danger"><h5>Failed to add the following record due to duplicate OT filed. Overtime was already filed separately by '+result['validate_ot'][x]+'.</h5></div>';
                            body_val += '<table class="table">';
                            body_val += ' <thead>';
                            body_val += '  <tr>';
                            body_val += '   <th>Empno</th>';
                            body_val += '   <th>Name</th>';
                            body_val += '   <th>DateIn / TimeIn</th>';
                            body_val += '   <th>DateOut / TimeOut</th>';
                            body_val += '  </tr>';
                            body_val += ' </thead>';
                            body_val += ' <tbody>';
                            body_val += duplicate_filed;
                            body_val += ' </tbody>';
                            body_val += '</table>';
                            system_message('System Validation',body_val,'');
                        } else {
                            if(array_duplicate_rows['empno'].length != 0) {
                                system_message('System Validation',body_val,'');
                            } else {
                                $('#modal_batch_add_employee').modal('hide');
                            }
                        }
                        $('#container_loading').hide();
                    }
                }
                
                reset_ticked_rows();
                
                if(array_duplicate_rows['empno'].length == 0){
                    return false;
                }

				   body_val = '<div class="alert alert-danger"><h5>Failed to add the following record due to duplicate OT filed. Overtime was already exist.</h5></div>';
                   body_val += '<table class="table" id="tbl_row_exist">';
                   body_val += ' <thead>';
                   body_val += '  <tr>';
                   body_val += '   <th>Empno</th>';
                   body_val += '   <th>Name</th>';
                   body_val += '   <th>DateIn / TimeIn</th>';
                   body_val += '   <th>DateOut / TimeOut</th>';
                   body_val += '  </tr>';
                   body_val += ' </thead>';
                   body_val += ' <tbody>';
                   body_val += ' </tbody>';
                   body_val += '</table>';
                   $('#modal_system_message .modal-body').append(body_val);
                    $('#modal_system_message .modal-body #tbl_row_exist tbody').empty();
                   for(x=0;x<array_duplicate_rows['empno'].length;x++){
                      var body_dup  = '<tr>';
                          body_dup += '	<td>'+ array_duplicate_rows['empno'][x] +'</td>';
                          body_dup += '	<td>'+ array_duplicate_rows['name'][x] +'</td>';
                          body_dup += '	<td>'+ array_duplicate_rows['date_dtin'][x] +'</td>';
                          body_dup += '	<td>'+ array_duplicate_rows['date_dtout'][x] +'</td>';
                     $('#modal_system_message .modal-body #tbl_row_exist tbody').append(body_dup);
                   }
                 reset_duplicate_rows();
            });
        console.log('array batch employee: '+array_batch_employee);
//        console.log(array_batch_employee_name);
	}
			
	function validate_duplicate(emp_no_new,emp_name_new,date_time_in_new,date_time_out_new,date_ot_new,filed_ot_new,valid_ot_new,remarks_new,msg_new,fkid_new) {
		var remarks_replace = remarks_new.replace("'", " ");
		var emp_no = '';
		var date_ot = '';
		var fkid = '';
		var body = '';
		//check if overtime was already exists on the table		
		$('#'+table_employee_overtime+' tbody tr').each(function () {
		   var tr = $(this);
		   emp_no = tr.find("td:eq(0)").text();
		   date_ot = tr.find("td:eq(4)").text();
		   fkid = tr.find("td:eq(9)").text();
		   if((emp_no == emp_no_new) && (date_ot == date_ot_new)) { 
			   validate_exist = 1; 
		   }
		});	
		
		if(validate_exist == 1) {		   
		   array_duplicate_rows.empno.push(emp_no_new);
		   array_duplicate_rows.name.push(emp_name_new);
		   array_duplicate_rows.date_dtin.push(date_time_in_new);
		   array_duplicate_rows.date_dtout.push(date_time_out_new);
		   validate_exist = 0;
		} else {
			dt_emp_overtime.row.add([
			   emp_no_new,
			   emp_name_new,
			   date_time_in_new,
			   date_time_out_new,
			   date_ot_new,
			   filed_ot_new,
			   valid_ot_new,
			   remarks_replace,
			   msg_new,
			   '<button class="btn btn-sm btn-danger fa fa-trash-o" type="button" value="0"></button>'
			]).draw(false);
		}
	}
	
	function load_overtime_main_info_by_pkid(fkid) {
        var data = {
			"action" 	: "load_overtime_main_info_by_pkid",
            "pkid"      : fkid,
			"username"	: username
		} 
		call_ajax(data, handler, function(result){
			max_date = result['req_dateto'];
			min_date = result['req_datefrom'];
			ot_type = result['req_type'];
			req_status = result['req_status'];
            if(req_status == 0 || req_status == 1) {                
                $('#btn_save_n_send_ot').prop('disabled',false);
                $('#btn_add_employee').prop('disabled',false);
                $('#btn_add_batch_employee').prop('disabled',false);
                $('#btn_add_batch_employee_own_list').prop('disabled',false);
                $('#btn_other_employee').prop('disabled',false);                
            } else {
                $('#btn_save_ot').prop('disabled',true);
                $('#btn_save_n_send_ot').prop('disabled',true);
                $('#btn_add_employee').prop('disabled',true);
                $('#btn_add_batch_employee').prop('disabled',true);
                $('#btn_add_batch_employee_own_list').prop('disabled',true);
                $('#btn_other_employee').prop('disabled',true);
            }
            if(req_status == 0) {
				$('#btn_save_ot').prop('disabled',false);
                $('#container_summary').append('<div class="ui blue horizontal label">FOR EDIT</div>');
            } else if(req_status == 1) {
				$('#btn_save_ot').prop('disabled',true);
                $('#container_summary').append('<div class="ui yellow horizontal label">FOR APPROVAL</div>');
            } else if(req_status == 2) {
                $('#container_summary').append('<div class="ui green horizontal label">APPROVED</div>');
            } else if(req_status == 3) {
                $('#container_summary').append('<div class="ui red horizontal label">DISAPPROVED</div>');
            } else if(req_status == 4) {
                $('#container_summary').append('<div class="ui red horizontal label">CANCELLED</div>');
            } else {
                $('#container_summary').append('<div class="ui default horizontal label">ERROR!</div>');
            }
		});
    }
    
    function load_employee_list_via_section(emp_no_list,emp_name_list) {
        $('#'+emp_no_list).empty();
        $('#'+emp_name_list).empty();
        var data = {
			"action" 	: "load_hris_record_by_section",
			"section"	: section
		} 
		call_ajax(data, handler, function(result){
            var ctr = result['ctr'];
            for(var i=0;i<ctr;i++) {
                $('#'+emp_no_list).append('<option>'+result['EmpNo'][i]+'</option>');
                $('#'+emp_name_list).append('<option>'+result['lastname'][i]+', '+result['firstname'][i]+'</option>');
            }
        });
    }
    	
	function load_hris_record_all(emp_no_list,emp_name_list) {
		$('#'+emp_no_list).empty();
        $('#'+emp_name_list).empty();
        var data = {
			"action" 	: "load_hris_record_all"
		} 
		call_ajax(data, handler, function(result){
            var ctr = result['ctr'];
            for(var i=0;i<ctr;i++) {
                $('#'+emp_no_list).append('<option>'+result['EmpNo'][i]+'</option>');
                $('#'+emp_name_list).append('<option>'+result['lastname'][i]+', '+result['firstname'][i]+'</option>');
            }
        });
	}
	
    function load_employee_name_by_number(emp_no,txt_emp_name) {
        var data = {
			"action" 	: "load_employee_name_by_number",
			"emp_no"	: emp_no
		} 
		call_ajax(data, handler, function(result){
            if(result['msg'] == 'Not found') {
                var body  = '<div class="row alert alert-danger">';
                    body += '   <div class="col-sm-1">';
                    body += '       <i class="fa fa-exclamation-triangle fa-3x"></i>';
                    body += '   </div>';
                    body += '   <div class="col-sm-11">';
                    body += '       <h3>Employee name not found!</h3>';
                    body += '   </div>';
                    body += '</div>';
                system_message('System Validation',body,'');
                $('#'+txt_emp_name).val(''); 
            } else {
                $('#'+txt_emp_name).val(result['emp_name']);   
            }
        });
    }
    
    function load_employee_number_by_name(emp_name,txt_emp_no) {
        var data = {
			"action" 	: "load_employee_number_by_name",
			"emp_name"	: emp_name
		} 
		call_ajax(data, handler, function(result){
            if(result['msg'] == 'Not found') {
                var body  = '<div class="row alert alert-danger">';
                    body += '   <div class="col-sm-1">';
                    body += '       <i class="fa fa-exclamation-triangle fa-3x"></i>';
                    body += '   </div>';
                    body += '   <div class="col-sm-11">';
                    body += '       <h3>Employee number not found!</h3>';
                    body += '   </div>';
                    body += '</div>';
                system_message('System Validation',body,'');
                $('#'+txt_emp_no).val('');
            } else {
                $('#'+txt_emp_no).val(result['emp_no']);   
            }
        });
    }
    
	function save_employee_ot(fkid,action) {
        var table_list  = '';
       var array_record_save = {};
            array_record_save.empno = [];
            array_record_save.emp_name = [];
            array_record_save.date_time_in = [];
            array_record_save.date_time_out = [];
            array_record_save.date_ot = [];
            array_record_save.ot_date = [];
            array_record_save.filed_ot = [];
            array_record_save.valid_ot = [];
            array_record_save.remarks = [];
            array_record_save.system_comment = [];
            array_record_save.pkid = [];
        
        $('#tbl_employee_overtime tbody tr').each(function(){
            array_record_save.empno.push($(this).find('td:eq(0)').text());
            array_record_save.emp_name.push($(this).find('td:eq(1)').text());
            array_record_save.date_time_in.push($(this).find('td:eq(2)').text());
            array_record_save.date_time_out.push($(this).find('td:eq(3)').text());
            array_record_save.ot_date.push($(this).find('td:eq(4)').text());
            array_record_save.filed_ot.push($(this).find('td:eq(5)').text());
            array_record_save.valid_ot.push($(this).find('td:eq(6)').text());
            array_record_save.remarks.push($(this).find('td:eq(7)').text());
            array_record_save.system_comment.push($(this).find('td:eq(8)').text());
            array_record_save.pkid.push($(this).find('td:eq(9) .btn-danger').val());
            console.log(array_record_save);
        });
        
        var data = {
            "action"             : "save_ot_data",
            "array_record_save"  : array_record_save,
            "fkid"               : fkid,
            "username"           : username
        }
        
        call_ajax(data, handler, function(result){
            /* delete data */
            var data = {
                "action"        : "delete_ot_details",
                "array_delete"  : array_delete,
                "username"      : username
            }
            
            call_ajax(data, handler, function(result){
                var rowCount = $('#'+table_employee_overtime+' tbody tr').length;
                $('#tbl_employee_overtime tbody tr').each(function(){
                    if(parseFloat($(this).find('td:eq(6)').text()) >= 0.5) {
                        approve_overtime_details($(this).find('td:eq(0)').text(),$(this).find('td:eq(4)').text(),fkid,$(this).find('td:eq(5)').text(),$(this).find('td:eq(6)').text(),username);
                        validate_save++;
                    } else {
                        table_list += '<tr>';
                        table_list += '<td>'+$(this).find('td:eq(1)').text()+'</td>';
                        table_list += '<td>'+$(this).find('td:eq(2)').text()+'</td>';
                        table_list += '<td>'+$(this).find('td:eq(3)').text()+'</td>';
                        table_list += '<td>'+$(this).find('td:eq(8)').text()+'</td>';
                        table_list += '</tr>';
                    }
                });
                
                if($('#'+table_employee_overtime+' tbody tr').text() != "No data available in table") {
                    var body = '';
                    if(action == 'save_only' || action == 'save_exit') {
                            body += '<div class="row alert alert-success">';
                            body += '   <div class="col-sm-1">';
                            body += '       <i class="fa fa-info-circle fa-2x"></i>';
                            body += '   </div>';
                            body += '   <div class="col-sm-11">';
                            body += '       <h3>';
                            body += '       	Overtime was successfully saved!';
                            body += '       </h3>';
                            body += '   </div>';
                            body += '</div>';
                            system_message('System Validation',body,'');
							$('#btn_close_modal_message').click(function() {
								if(action == 'save_only') {
									window.location.href = "requestor_index.php?page=employee_overtime.php&pkid="+fkid;
								} else {
									window.location.href = "requestor_index.php";
								}
							});
                    } else {
                        // alert('row'+rowCount+' validate_save'+validate_save);
                        if((rowCount) != validate_save) {
                            body += '<div class="alert alert-danger"><h5>Unable to send overtime request due to invalid overtime filed. Please remove or update the invalid overtime. Thank you!</h5></div>';
                            body += '<table class="table">';
                            body += ' <thead>';
                            body += '  <tr>';
                            body += '   <th>Empno</th>';
                            body += '   <th>Name</th>';
                            body += '   <th>DateIn / TimeIn</th>';
                            body += '   <th>DateOut / TimeOut</th>';
                            body += '  </tr>';
                            body += ' </thead>';
                            body += ' <tbody>';
                            body += table_list;
                            body += ' </tbody>';
                            body += '<table>';

                            system_message('System Validation',body,'');
                            $('#btn_close_modal_message').click(function() {
                                window.location.href = "requestor_index.php?page=employee_overtime.php&pkid="+fkid;
                            });
                        } else {
                            var data = {
                                "action" 	: "send_email_to_approver",
                                "fkid"		: fkid,
                                "username"	: username
                            } 
                            call_ajax(data, handler, function(result){	
                                if(result['msg'] == 'Message has been sent!') {
                                    body += '<div class="row alert alert-success">';
                                    body += '   <div class="col-sm-2">';
                                    body += '       <i class="fa fa-info-circle fa-2x"></i> <i class="fa fa-envelope-o fa-2x"></i>';
                                    body += '   </div>';
                                    body += '   <div class="col-sm-10">';
                                    body += '       <h3>';
                                    body += '       	Overtime was successfully saved and sent to assigned approver!';
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
                                system_message('System Validation',body,'');
                                $('#btn_close_modal_message').click(function() {
                                    window.location.href = "requestor_index.php?page=employee_overtime.php&pkid="+fkid;
                                });
                            });
                        }
                    } 
                } else {
                    var body  = '<div class="row alert alert-warning">';
                        body += '   <div class="col-sm-1">';
                        body += '       <i class="fa fa-warning fa-2x"></i>';
                        body += '   </div>';
                        body += '   <div class="col-sm-11">';
                        body += '       <h3>';
                        body += '       	No record found!';
                        body += '       </h3>';
                        body += '   </div>';
                        body += '</div>';
                    system_message('System Validation',body,'');
                }
                validate_save = 0;
                
            });
        });
	}
	
    function approve_overtime_details(empno,ot_date,fkid,filed_ot,valid_ot,username) {
        var data = {
            "action" 		: "approve_overtime_details",
            "empno"			: empno,
            "ot_date"		: ot_date,
            "fkid"			: fkid,
            "filed_ot"		: filed_ot,
            "valid_ot"		: valid_ot,
            "status"		: '1',
            "username"		: username
        } 
        call_ajax(data, handler, function(result){		
//            $('body').append(result['msg']);
        });
    }
        
	function system_message(title,body,buttons){
		/* Empty System Message Modal - Title, Body, Footer */
		$('#modal_system_message .modal-title').empty();
		$('#modal_system_message .modal-body').empty();
		$('#modal_system_message .modal-footer').empty();
		/* Append the close button */
		$('#modal_system_message .modal-footer').append('<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal" id="btn_close_modal_message">Close</button>');
		/* Append parameter data */
		$('#modal_system_message .modal-title').append(title);
		$('#modal_system_message .modal-body').append(body);
		$('#modal_system_message .modal-footer').prepend(buttons);
		/* Show modal */
		$('#modal_system_message').modal('show');
	}
	
	function system_message_validation(body){
		/* Empty System Message Modal - Title, Body, Footer */
		$('#modal_system_message2 .modal-title').empty();
		$('#modal_system_message2 .modal-body').empty();
		$('#modal_system_message2 .modal-footer').empty();
		/* Append the close button */
		$('#modal_system_message2 .modal-footer').append('<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');
		/* Append parameter data */
		$('#modal_system_message2 .modal-title').append(title);
		$('#modal_system_message2 .modal-body').append(body);
		$('#modal_system_message2 .modal-footer').prepend(buttons);
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
		$('#container_upload_employee').hide();
		// $('#container_other_employee').hide();
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
	load_employee_information();
	load_employee_overtime(function() {//alert(for_update_checker);
		if(for_update_checker == 1) {			
			$('#modal_for_update').modal('show');
			for_update_checker = 0;
		}
	});
    load_overtime_main_info_by_pkid(fkid);
	show_main_container();
	
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
	
	$('#btn_add_batch_employee_own_list').click(function(){
        $('input#txt_batch_date').attr({
			"min"   : min_date,
            "max"   : max_date,
            "value" : min_date
		});
		$('#modal_batch_add_employee').modal('show');
		load_employee_via_managed_batch();
	});	
	
	$('#btn_add_employee').click(function(){
        /* Set the minimum date and maximum based on the overtime main info */
        $('input#txt_add_employee_date').attr({
			"min"   : min_date,
            "max"   : max_date,
            "value" : min_date
		});
        load_employee_list_via_section('txt_add_employee_number_list','txt_add_employee_name_list');
		$('#modal_add_each_employee').modal('show');
	});
    
	$('#btn_upload_employees').click(function(){
         /* Set the minimum date and maximum based on the overtime main info */
        $('input#txt_upload_date').attr({
			"min"   : min_date,
            "max"   : max_date,
            "value" : min_date
		});
		show_container('container_upload_employee');
	});
	
	$('#btn_other_employee').click(function(){
        /* Set the minimum date and maximum based on the overtime main info */
        $('input#txt_other_date').attr({
			"min"   : min_date,
            "max"   : max_date,
            "value" : min_date
		});
		load_hris_record_all('txt_other_employee_number_list','txt_other_employee_name_list');
		// show_container('container_other_employee');
		$('#modal_add_other_employee').modal();
	});
	
	$('#btn_save_ot').click(function(){
        save_employee_ot(fkid,'save_only');
	});
    
	$('#btn_save_n_send_ot').click(function(){
        var body  = '<div class="row alert alert-warning">';
			body += '   <div class="col-sm-1">';
			body += '       <i class="fa fa-exclamation-triangle fa-3x"></i>';
			body += '   </div>';
			body += '   <div class="col-sm-11">';
			body += '       <h3>';
			body += '       	Are you sure you want to send your overtime request?<br>';
			body += '       	Please be reminded that you are not allowed to update data once request was sent.';
			body += '       </h3>';
			body += '   </div>';
			body += '</div>';
		var button = '<button  class="btn btn-success fa fa-save" type="button" id="btn_yes_send"> YES </button>';
		system_message('System Validation',body,button);
		$('#btn_close_modal_message').html(' NO');
		
		$('#btn_yes_send').click(function () {
			save_employee_ot(fkid,'save_n_send');
		});
	});
	
    $('#btn_print_ot').click(function(){
		save_employee_ot(fkid,'save_only');
        window.open("./pages/print_preview.php?pkid="+fkid+'&username='+username, '_blank');
    });
    
	$('#btn_close_add_employee').click(function(){
        $('#modal_add_each_employee').modal('hide');
	});
	
	$('#btn_close_upload_employee').click(function(){
		show_main_container();
	});
	
	$('#btn_close_other_employee').click(function(){
		// show_main_container();
		$('#modal_add_other_employee').modal('hide');
	});
	
	$('#btn_close').click(function(){
		if(req_status == 0 || req_status == 1) {
            var body = '';
                body += '<div class="row alert alert-success">';
                body += '   <div class="col-sm-1">';
                body += '       <i class="fa fa-info-circle fa-2x"></i>';
                body += '   </div>';
                body += '   <div class="col-sm-11">';
                body += '       <h3>';
                body += '       	Do you want to save your changes?';
                body += '       </h3>';
                body += '   </div>';
                body += '</div>';
            var button = '<button  class="btn btn-success fa fa-save" type="button" id="btn_yes_save"> YES </button>';
            system_message('System Validation',body,button);
			$('#btn_close_modal_message').html(' NO');
            $('#btn_yes_save').click(function() {
                save_employee_ot(fkid,'save_exit');
            });
            $('#btn_close_modal_message').click(function() {
                window.location.href = "requestor_index.php";
            });
        } else {
            window.location.href = "requestor_index.php";
        }        
	});
	
	$('#frm-batch-employee-add').submit(function(e){
		e.preventDefault();
        hide_modal(function(){
           add_batch_employee();          
        });
		
	});
	
    function hide_modal(callback){
        $('#modal_batch_add_employee').modal('hide');
        callback();
    }
    
	/* SUBMIT FUNCTIONS */
	$('#frm_add_employee').submit(function(e){
		e.preventDefault();
		var serialized_data = $(this).serialize();
            serialized_data += '&fkid='+fkid+'&ot_type='+ot_type+'&username='+username;
            save_information('check_ot_filed', serialized_data);
	});
	
	$('#frm_other_employee').submit(function(e){
		e.preventDefault();
		var serialized_data = $(this).serialize();
			serialized_data += '&fkid='+fkid+'&ot_type='+ot_type+'&username='+username;
			save_information('check_ot_filed', serialized_data);
        // validate_duplicate_modal();
	});
    	
	$('#frm-employee-update').submit(function(e){
		e.preventDefault();
		var serialized_data = $(this).serialize();
            serialized_data += '&fkid='+fkid+'&ot_type='+ot_type+'&username='+username;
            update_information('check_ot_filed', serialized_data);
	});
    /* Events */
    $('#txt_add_employee_number').change(function() {
        load_employee_name_by_number($('#txt_add_employee_number').val(),'txt_add_employee_name');
    });
    
    $('#txt_add_employee_name').change(function() {
        load_employee_number_by_name($('#txt_add_employee_name').val(),'txt_add_employee_number')
    });

    $('#txt_other_employee_number').change(function() {
        load_employee_name_by_number($('#txt_other_employee_number').val(),'txt_other_employee_name','txt_other_employee_name');
    });
    
    $('#txt_other_employee_name').change(function() {
        load_employee_number_by_name($('#txt_other_employee_name').val(),'txt_other_employee_number')
    });

	/* Table Events */
	var tr_color = '';
	$('#'+table_employee_overtime+' tbody').on('click', 'tr', function () {	//dapat maretain parin ung blue
		$('#'+table_employee_overtime+' tbody tr').attr('style','');
		$(this).attr('style','background:teal;color:white;');
	});
	
	$('#'+table_employee_overtime+' tbody').on('dblclick', 'tr', function () {
		// tbl_row = dt_emp_overtime.row( this ).data();
		tbl_row = $(this);
        var month = '';
        var date = '';
		var emp_no = $(this).find('td:eq(0)').text();
		var emp_name = $(this).find('td:eq(1)').text();
		var date_ot = new Date($(this).find('td:eq(4)').text());
		if((date_ot.getMonth()+1) < 10) {
			month = "0"+(date_ot.getMonth()+1);
		} else {
			month = (date_ot.getMonth()+1);
		}	
        if(date_ot.getDate() < 10) {
            date = '0'+date_ot.getDate();
        } else {
            date = date_ot.getDate();
        }
        if(req_status == 0 || req_status == 1){
            $('#btn_save_update_employee').show();
        } else {
            $('#btn_save_update_employee').hide();
        }
        var ot_date = (date_ot.getFullYear())+"-"+month+"-"+date;
		var filled_ot = parseFloat($(this).find('td:eq(5)').text());
		var remarks = $(this).find('td:eq(7)').text();
		var remarks_replace = remarks.replace("'", " ");
		$('#txt_update_employee_date').val(ot_date);
		$('#txt_update_employee_number').val(emp_no);
		$('#txt_update_employee_name').val(emp_name);
		$('#txt_update_employee_filled_overtime').val(filled_ot);
		$('#txt_update_employee_remarks').val(remarks_replace);
		$('#modal_update_employee_overtime').modal('show');
	});
	
    var array_delete = [];
    /* Delete record */
	$('#'+table_employee_overtime+' tbody').on('click','tr button',function() {
		tbl_row = $(this).closest('tr');
		//fkid = $(this).val();
		var pkid = $(this).val();
        remove_filed_ot(pkid);
	});
	
	$('input[type="text"]').keydown(function(e){
	   var ingnore_key_codes = [222];
	   if ($.inArray(e.keyCode, ingnore_key_codes) >= 0){
		  alert('Single quote is not allowed');	  
	   }
	});		
</script>