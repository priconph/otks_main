<?php
/* Include employee information */
require_once('./pages/get_employee_username.php');
?>
<input type="hidden" id="hidden_username" value="<?php echo $username; ?>">
<input type="hidden" id="hidden_date_today" value="<?php echo date('Y-m-d'); ?>">

<!--Main Container-->
<div id="row main_container" style="margin-top:20px;">
	<div class="col-sm-12">
		<div class="panel panel-primary">
	  		<div class="panel-heading">Summary of Overtime Requests</div>
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
                            <i class="fa fa-info-circle" style="color:blue;"></i> Double click to view filed overtime.<br>
                      </div>
                    </div>	
                   </div>	
                </div>	
				<div id="row">
					<div class="col-sm-4">
						<button class="btn btn-default btn-md fa fa-home" id="btn_home"> Home</button>
						<button class="btn btn-info btn-md fa fa-search" id="btn_advance_search_main"> Advance Search</button>
					</div>
					<div class="col-sm-8">
						<p style="text-align:right;padding-bottom:20px;">
							<button class="btn btn-primary btn-md fa fa-gear" id="btn_manage_batch"> Manage Batch</button>
							<button class="btn btn-primary btn-md fa fa-plus" id="btn_new_overtime_request"> New Request</button>
							<button class="btn btn-success btn-md fa fa-file-excel-o" id="btn_report_main"> Report</button>
						</p>
					</div>
					<div class="col-sm-12" id="container_table_overtime_summary">
						<table id="tbl_overtime_summary" class="table table-hover table-striped table-bordered" style="">
							<thead>
								<tr>
									<th>Status</th>
									<th>Date Requested</th>
									<th>Overtime Type</th>
									<th>Date of Overtime</th>
									<th>Manpower</th>
									<th>Justification</th>
									<th>Edit</th>
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
</div>

<!-- Modal new overtime request form -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_new_overtime_request">
  <div class="modal-dialog" style="width:800px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">New Overtime Request</h4>
      </div>
      <form id="frm_new_overtime_request" method="post"> 
       <div class="modal-body">
		<div id="validation_message" style="color:red;align:center;font-weight:bold;"></div>
        <div id="row" style="padding:0px;">			
				<div class="row panel panel-default" id="1st_row_options" style="font-size:16px; padding-bottom: 20px; padding-top: 20px;">
					<div class="col-sm-4" >
						<input type="radio" name="option_type_of_ot" value="1" required> Regular</input><br>
						<input type="radio" name="option_type_of_ot" value="2" required> Legal Holiday</input>
					</div>
					<div class="col-sm-4" style="padding:0px;">
						<input type="radio" name="option_type_of_ot" value="3" required> Sunday</input><br>
						<input type="radio" name="option_type_of_ot" value="4" required> Special Non Working Holiday</input>
					</div>
					<div class="col-sm-4">
						<input type="radio" name="option_type_of_ot" value="5" required> Sunday/Legal Holiday</input><br>
						<input type="radio" name="option_type_of_ot" value="6" required> Sunday/Special Holiday</input>
					</div>	
				</div>
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
							<!-- <datalist id="txt_approver_list">
							</datalist> -->
							<div style="padding:2px;">
								<label style="width:150px;" id="lblapprover">Approver:</label>
								<!-- <input type="text" style="width:57%;" class="form-control" list="txt_approver_list" name="txt_approver" id="txt_approver" autocomplete="off" required> -->
								<select data-placeholder="Select Approver" class="chosen-select"  name="txt_approver" id="txt_approver" style="margin:3px;">
									<option value=''></option>
								</select>
							</div>
						</div>
					</div>
					<div class="col-sm-12" style="margin-top:2px;">
						<div class="form-inline" style="padding-right:0px;">
							<label style="width:152px;">Justification:</label>
							<textarea id="txt_justification" class="form-control" style="width: 79%;" required></textarea>
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
<div class="modal fade" tabindex="-1" role="dialog" id="modal_edit_overtime_request">
  <div class="modal-dialog" style="width:800px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Overtime Request</h4>
      </div>
      <form id="frm_edit_overtime_request" method="post"> 
       <div class="modal-body">
        <div id="row" style="padding:0px;">
			
				<div class="row panel panel-default" id="1st_row_options" style="font-size:16px; padding-bottom: 20px; padding-top: 20px;">
					<div class="col-sm-4" >
						<input type="radio" name="option_type_of_ot" value="1" required> Regular</input><br>
						<input type="radio" name="option_type_of_ot" value="2" required> Legal Sunday</input>
					</div>
					<div class="col-sm-4" style="padding:0px;">
						<input type="radio" name="option_type_of_ot" value="3" required> Sunday</input><br>
						<input type="radio" name="option_type_of_ot" value="4" required> Special Non Working Holiday</input>
					</div>
					<div class="col-sm-4">
						<input type="radio" name="option_type_of_ot" value="5" required> Sunday/Legal Holiday</input><br>
						<input type="radio" name="option_type_of_ot" value="6" required> Sunday/Special Holiday</input>
					</div>	
				</div>
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
							<!-- <datalist id="txt_approver_edit_list">
							</datalist> -->
							<div style="padding:2px;">
								<label style="width:150px;">Approver:</label>
								<!-- <input type="text" style="width:57%;" class="form-control" list="txt_approver_edit_list" name="txt_approver_edit" id="txt_approver_edit" autocomplete="off" required> -->
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
        <button type="submit" class="btn btn-primary fa fa-save"> Update</button>
        <button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal show overtime request form -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_view_overtime_request">
  <div class="modal-dialog" style="width:800px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">View Overtime Request</h4>
      </div>
      <form id="frm_view_overtime_request" method="post"> 
       <div class="modal-body">
        <div id="row" style="padding:0px;">			
				<div class="row panel panel-default" id="1st_row_options" style="font-size:16px; padding-bottom: 20px; padding-top: 20px;">
					<div class="col-sm-4" >
						<input type="radio" name="option_type_of_ot" value="1" required> Regular</input><br>
						<input type="radio" name="option_type_of_ot" value="2" required> Legal Sunday</input>
					</div>
					<div class="col-sm-4" style="padding:0px;">
						<input type="radio" name="option_type_of_ot" value="3" required> Sunday</input><br>
						<input type="radio" name="option_type_of_ot" value="4" required> Special Non Working Holiday</input>
					</div>
					<div class="col-sm-4">
						<input type="radio" name="option_type_of_ot" value="5" required> Sunday/Legal Holiday</input><br>
						<input type="radio" name="option_type_of_ot" value="6" required> Sunday/Special Holiday</input>
					</div>	
				</div>
				<div class="row panel panel-default" id="2nd_row_textbox">
					<div class="col-sm-6" style="margin-top:20px;">
						<div class="form-inline" style="padding-right:0px;">
							<div style="padding:2px;">
								<label style="width:150px;">Request Date:</label>
								<input type="date" class="form-control" name="txt_request_date_view" id="txt_request_date_view" disabled required>
							</div>
							<div style="padding:2px;">
								<label style="width:150px;">Manpower Involved:</label>
								<input type="number" style="width:51.5%;" class="form-control" name="txt_manpower_involved_view" id="txt_manpower_involved_view" min=1 required>
							</div>
							<div style="padding:2px;">
								<label style="width:150px;">Date From:</label>
								<input type="date" style="width:51.5%;" class="form-control" name="txt_date_from_view" id="txt_date_from_view" max="<?php echo date('Y-m-d'); ?>" required>
							</div>
							<div style="padding:2px;">
								<label style="width:150px;">Date To:</label>
								<input type="date" style="width:51.5%;" class="form-control" name="txt_date_to_view" id="txt_date_to_view" required >
							</div>
						</div>
					</div>
					<div class="col-sm-6" style="margin-top:20px;">
						<div class="form-inline" style="padding-right:0px;">
							<div style="padding:2px;">
								<label style="width:150px;">Request By:</label>
								<input type="text" style="width:57%;" class="form-control" name="txt_requested_by_view" id="txt_requested_by_view" required readonly>
							</div>
							<div style="padding:2px;">
									<label style="width:150px;">Division:</label>
								<input type="text" style="width:57%;" class="form-control" name="txt_division_view" id="txt_division_view" required readonly>
							</div>
							<div style="padding:2px;">
								<label style="width:150px;">Department:</label>
								<input type="text" style="width:57%;" class="form-control" name="txt_department_view" id="txt_department_view" required readonly>
							</div>
							<!-- <datalist id="txt_approver_view_list">
							</datalist> -->
							<div style="padding:2px;">
								<label style="width:150px;">Approver:</label>
								<!-- <input type="text" style="width:57%;" class="form-control" list="txt_approver_view_list" name="txt_approver_view" id="txt_approver_view" autocomplete="off" required> -->
								<select data-placeholder="Select Approver" class="chosen-select"  name="txt_approver_view" id="txt_approver_view" style="margin:3px;">
									<option value=''></option>
								</select>
							</div>
						</div>
					</div>
					<div class="col-sm-12" style="margin-top:2px;">
						<div class="form-inline" style="padding-right:0px;">
							<label style="width:152px;">Justification:</label>
							<textarea id="txt_justification_view" name="txt_justification_view" class="form-control" style="width: 79%;" required></textarea>
						</div>
					</div>
				</div>
        </div>
      </div>
      <div class="modal-footer">
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

<!-- Modal advance search -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_advance_search">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><span class="fa fa-search"> Advance Search</span></h4>
      </div>
      <div class="modal-body">
		<div class="row">
			<div class="col-md-12 form-inline">
				<label class="control-label" style="width:25%;">Date Request: </label>
				<input type="text" style="width:73%;margin:2px;" class="form-control" id="txt_date_request_asearch">
			</div>
			<div class="col-md-12 form-inline">
				<label class="control-label" style="width:25%;">Overtime Type: </label>
				<select style="width:73%;margin:2px;" class="form-control" id="cmb_ot_type_asearch">
					<option value="All">All</option>
					<option value="Regular">Regular</option>
					<option value="Legal Holiday">Legal Holiday</option>
					<option value="Sunday">Sunday</option>
					<option value="Special Non Working Holiday">Special Non Working Holiday</option>
					<option value="Sunday Legal Holiday">Sunday/Legal Holiday</option>
					<option value="Sunday Special">Sunday/Special Holiday</option>
				</select>
			</div>
			<div class="col-md-12 form-inline">
				<label class="control-label" style="width:25%;">Overtime Range: </label>
				<input type="text" style="width:73%;margin:2px;" class="form-control" id="txt_ot_range_asearch">
			</div>
			<div class="col-md-12 form-inline">
				<label class="control-label" style="width:25%;">Status: </label>
				<select style="width:73%;margin:2px;" class="form-control" id="cmb_status_asearch">
					<option value="-">All</option>
					<option value="0">Draft</option>
					<option value="1">For Approval</option>
					<option value="2">Approved</option>
					<option value="3">Disapproved</option>
					<option value="4">Cancelled</option>
				</select>
			</div>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary fa fa-search" data-dismiss="modal" id="btn_advance_search"> Search</button>
        <button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal report search -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_report">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><span class="fa fa-file-excel-o"> Generate Report</span></h4>
      </div>
      <div class="modal-body">
		<div class="row">
			<div class="col-md-12 form-inline">
				<label class="control-label" style="width:25%;">Date Request: </label>
				<input type="text" style="width:73%;margin:2px;" class="form-control" id="txt_date_request_report">
			</div>
			<div class="col-md-12 form-inline">
				<label class="control-label" style="width:25%;">Overtime Type: </label>
				<select style="width:73%;margin:2px;" class="form-control" id="cmb_ot_type_report">
					<option value="-">All</option>
					<option value="1">Regular</option>
					<option value="2">Legal Holiday</option>
					<option value="3">Sunday</option>
					<option value="4">Special Non Working Holiday</option>
					<option value="5">Sunday/Legal Holiday</option>
					<option value="6">Sunday/Special Holiday</option>
				</select>
			</div>
			<div class="col-md-12 form-inline">
				<label class="control-label" style="width:25%;">Overtime Range: </label>
				<input type="text" style="width:73%;margin:2px;" class="form-control" id="txt_ot_range_report">
			</div>
			<div class="col-md-12 form-inline">
				<label class="control-label" style="width:25%;">Status: </label>
				<select style="width:73%;margin:2px;" class="form-control" id="cmb_status_report">
					<option value="-">All</option>
					<option value="0">Draft</option>
					<option value="1">For Approval</option>
					<option value="2">Approved</option>
					<option value="3">Disapproved</option>
					<option value="4">Cancelled</option>
				</select>
			</div>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success fa fa-file-excel-o" data-dismiss="modal" id="btn_report"> Report</button>
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

<!-- Call user defined functions common functions -->
<script src="../../../common_functions/common_functions.js" type="text/javascript"></script>

<script type="text/javascript">
	var username 		= $('#hidden_username').val();
	var date_today 		= $('#hidden_date_today').val();
	var table_summary 	= 'tbl_overtime_summary';
	var data_table      = "";
	var handler = './handler/handler.php';
	var pkid = 0;
    
    data_table = $('#'+table_summary).DataTable({
        "aaSorting": [],
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "./server_side_scripts/requestor_datatable.php?username="+username
    });
	
    function reload_datatable() {
        data_table.draw(false);
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
			$('#'+txt_request_date).val(date_today);
		});
	}
	
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
	    
    function load_overtime_main_info_by_pkid(txt_request_date,txt_date_to,txt_date_from,txt_manpower_involved,txt_approver,txt_justification,txt_approver_list,fkid, callback) {
        var data = {
			"action" 	: "load_overtime_main_info_by_pkid",
            "pkid"      : fkid,
			"username"	: username
		} 
		call_ajax(data, handler, function(result){
            $("input[name=option_type_of_ot][value=" + result['req_type'] + "]").prop('checked', true);
			$('#'+txt_request_date).val(result['req_date']);
			$('#'+txt_date_to).val(result['req_dateto']);
			$('#'+txt_date_from).val(result['req_datefrom']);
			$('#'+txt_manpower_involved).val(result['req_manpower']);
			$('#'+txt_justification).val(result['req_justification']);    
            // var approver_name = get_datalist_value_and_text(txt_approver_list,result['req_approver']);
			// $('#'+txt_approver).val(approver_name['value']); 
			$('#'+txt_approver).val(result['req_approver']); 
            callback();
		});
    }
    
	function save_main_record(serialized_data){
        // var approver = get_datalist_value_and_text('txt_approver_list',$('#txt_approver').val());
		var justification = $('#txt_justification').val();
		var justification_replace = justification.replace("'", " ");
		var data = {
			"action"              : "save_main_record",
            'created_by'          : username,
            'req_type'            : $("input[name='option_type_of_ot']:checked").val(),
            'req_date'            : $('#txt_request_date').val(), 
            'req_by'              : username, 
            'req_manpower'        : $('#txt_manpower_involved').val(), 
            'req_datefrom'        : $('#txt_date_from').val(), 
            'req_dateto'          : $('#txt_date_to').val(), 
            'req_approver'        : $('#txt_approver').val(), 
            'req_justification'   : justification_replace, 
            'req_status'          : 0, 
            'username'            : username
		}
		
//		call_ajax_serialize(data, serialized_data, handler, function(result){
		call_ajax(data, handler, function(result){
            if(result['pkid'] == undefined || result['pkid'] == null) {
            } else {
                window.location.href = "requestor_index.php?page=employee_overtime.php&pkid="+result['pkid'];
            }
		});
	}
    
	function update_main_record(serialized_data){
		var justification = $('#txt_justification_edit').val();
		var justification_replace = justification.replace("'", " ");
		
		var data = {
			"action"              : "update_main_record",
            'justification'       : justification_replace,
            'req_type'            : $("input[name='option_type_of_ot']:checked").val()
		}
		call_ajax_serialize(data, serialized_data, handler, function(result){
            var body  = '<div class="row alert alert-success">';
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
            reload_datatable();
		});
	}
	
    function cancel_request(serialized_data) {
        var data = {
			"action"              : "cancel_request"
		}
		call_ajax_serialize(data, serialized_data, handler, function(result){
            reload_datatable();            
            var body  = '<div class="row alert alert-success">';
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
		});
    }
    
	function modal_make_request_confirmation(serialized_data,action){
		var title = '<span class="fa fa-settings"></span> System Message';
		var body = '<p>Are you sure you want to make this request?</p>';
		var buttons = '<button class="btn btn-success fa fa-check" type="button" id="btn_yes_request"> YES</button>';
		system_message(title,body,buttons);
		$('#btn_yes_request').click(function(){
            if(action == 'new') {
				save_main_record(serialized_data);  
            } else if(action == 'edit') {
                update_main_record(serialized_data);
            }
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
        
    function get_day_name(date_selected, serialized_data) {
        var data = {
			"action"              : "get_day_name",
            "date_selected"       : date_selected
		}
		call_ajax(data, handler, function(result){
            if(result['day_name'] != 'Sunday') {
                var body  = '<div class="row alert alert-danger">';
                    body += '   <div class="col-sm-1">';
                    body += '       <i class="fa fa-exclamation-triangle fa-3x"></i>';
                    body += '   </div>';
                    body += '   <div class="col-sm-11">';
                    body += '       <h3>Invalid "Date From" selected! Please select Sunday only.</h3>';
                    body += '   </div>';
                    body += '</div>';
                system_message('System Validation',body,'');
            } else {
                modal_make_request_confirmation(serialized_data,'new');
            }
		});
    }
    
	$('#modal_system_message .modal-header span').show();
        
    /* Update Record - details*/
    $('#'+table_summary+' tbody').on('click', 'tr', function () {
		$('#'+table_summary+' tbody tr').attr('style','');
		$(this).attr('style','background:teal;color:white;');
	});
    
    $('#'+table_summary+' tbody').on('dblclick', 'tr', function () {
        var row_pkid = $(this).find('#btn_hidden').val();
        var status = $(this).find('td:eq()').text();
//        if(status == 'For Edit') {
//            window.location.href = "requestor_index.php?page=employee_overtime.php&pkid="+row_pkid+'&username='+username;
//        } else if(status == 'For Approval') {
//            window.open("./pages/print_preview.php?pkid="+row_pkid+'&username='+username, '_blank');
//        }
        if(row_pkid != undefined) {
			window.location.href = "requestor_index.php?page=employee_overtime.php&pkid="+row_pkid+'&username='+username;
	   }        
    })
    
    /* Update Main Record */
    $('#'+table_summary+' tbody').on('click','tr button#btn_edit', function() {
        pkid = $(this).val();
        load_approver_list('txt_approver_edit',function () {
            load_employee_information('txt_requested_by_edit','txt_division_edit','txt_department_edit','txt_request_date_edit');
			load_overtime_main_info_by_pkid('txt_request_date_edit','txt_date_to_edit','txt_date_from_edit','txt_manpower_involved_edit','txt_approver_edit','txt_justification_edit','txt_approver_edit_list',pkid, function() {
				$('.chosen-select#txt_approver_edit').chosen({width:"57%"});
                $('#modal_edit_overtime_request').modal('show');
            });			
		});
    });
    
    /* View Main Record */
    $('#'+table_summary+' tbody').on('click','tr button#btn_view', function() {
        pkid = $(this).val();
        load_approver_list('txt_approver_view',function () {
            load_employee_information('txt_requested_by_view','txt_division_view','txt_department_view','txt_request_date_view');
			load_overtime_main_info_by_pkid('txt_request_date_view','txt_date_to_view','txt_date_from_view','txt_manpower_involved_view','txt_approver_view','txt_justification_view','txt_approver_view_list',pkid, function() {
				$('.chosen-select#txt_approver_view').chosen({width:"57%"});
                $('#modal_view_overtime_request').modal('show');
            });			
		});
    });
    
    /* Cancel Request */
    $('#'+table_summary+' tbody').on('click','tr #btn_cancel', function() {
        pkid = $(this).val();
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
//             alert(serialized_data);
            cancel_request(serialized_data);
        });
     });
    
	/* CLICK FUNCTIONS */
	$('#btn_new_overtime_request').click(function(){
		// load_approver_list('txt_approver_list',function () {
		load_approver_list('txt_approver',function () {
			$('.chosen-select#txt_approver').chosen({width:"57%"});
			load_employee_information('txt_requested_by','txt_division','txt_department','txt_request_date');
			$('#modal_new_overtime_request').modal('show');
		});
	});
	
	/* Validation for date of overtime */
	$('#txt_date_from').change(function () {
		$('input#txt_date_to').attr({
			"min" : $('#txt_date_from').val()
		});
		//$('#txt_date_to').prop('readonly', false);
	});
		
	/* SUBMIT FUNCTIONS */
	$('#frm_new_overtime_request').submit(function(e){
		e.preventDefault();
		var serialized_data = $(this).serialize();
        if($("input[name='option_type_of_ot']:checked").val() == 3 || $("input[name='option_type_of_ot']:checked").val() == 5 || $("input[name='option_type_of_ot']:checked").val() == 6) {
            get_day_name($('#txt_date_from').val(),serialized_data);
        } else {
			if($('#txt_approver').val() == '') {
				$('#validation_message').text('*** Please select your approver ***');
				$('#lblapprover').css('color','red');
			} else {
				modal_make_request_confirmation(serialized_data,'new');
			}             
        }		
	});
    
	$('#frm_edit_overtime_request').submit(function(e){
		e.preventDefault();
        var approver = $('#txt_approver_edit').val();
		var serialized_data  = $(this).serialize();
		    serialized_data += '&username='+username+'&pkid='+pkid+'&approver_name='+approver;
		modal_make_request_confirmation(serialized_data,'edit');
	});
	
	/* MANAGE BATCH START*/
	/*  Load datatable server side script  */
	oTable_batch_list = $('#tbl_batch').DataTable({
		"aaSorting"	 : [],			
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "./server_side_scripts/manage_batch_list_datatable.php?username="+username
	});
	
	$('#btn_home').click(function() {
		window.location.href = '../../otks_main/otks_dashboard/index_requestor.php';
	});
	
	$('#btn_advance_search_main').click(function() {
		date_time_picker('txt_date_request_asearch');
		date_time_picker('txt_ot_range_asearch');
		$('#modal_advance_search').modal('show');
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
	
	$('input[type="text"]').keydown(function(e){
	   var ingnore_key_codes = [222];
	   if ($.inArray(e.keyCode, ingnore_key_codes) >= 0){
		  alert('Single quote is not allowed');	  
	   }
	});		
	$('#txt_justification').keydown(function(e){
	   var ingnore_key_codes = [222];
	   var str = $(this).val();
	   if ($.inArray(e.keyCode, ingnore_key_codes) >= 0){
		  alert('Single quote is not allowed');	  
	   }
	});	
	$('#txt_justification_edit').keydown(function(e){
	   var ingnore_key_codes = [222];
	   var str = $(this).val();
	   if ($.inArray(e.keyCode, ingnore_key_codes) >= 0){
		  alert('Single quote is not allowed');	  
	   }
	});	
	
	$('#btn_advance_search').click(function() {
		var date_request = $('#txt_date_request_asearch').val();
		var ot_type		 = $('#cmb_ot_type_asearch').val();
		var ot_range	 = $('#txt_ot_range_asearch').val();
		var ot_status	 = $('#cmb_status_asearch').val();
		// alert('['+date_request+'] ['+ot_type+'] ['+ot_range+'] ['+ot_status+'] ');
		data_table.ajax.url( "./server_side_scripts/requestor_datatable_a_search.php?username="+username+"&date_request="+date_request+"&ot_type="+ot_type+"&ot_range="+ot_range+"&ot_status="+ot_status ).load();
		data_table.draw(false);
	});
	
	$('#btn_report_main').click(function() {
		date_time_picker('txt_date_request_report');
		date_time_picker('txt_ot_range_report');
		$('#modal_report').modal('show');
	});
	$('#btn_report').click(function() {
		var date_request = $('#txt_date_request_report').val();
		var ot_type		 = $('#cmb_ot_type_report').val();
		var ot_range	 = $('#txt_ot_range_report').val();
		var ot_status	 = $('#cmb_status_report').val();
		// alert('['+date_request+']['+ot_type+']['+ot_range+']['+ot_status+']');
		window.location.href = "pages/export_to_excel.php?date_request="+date_request+"&ot_type="+ot_type+"&ot_range="+ot_range+"&ot_status="+ot_status+"&username="+username;
	});
	/* populate data list */
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

	//Date range picker
	function date_time_picker(id) {
		$('#'+id).daterangepicker(
				{
					ranges: {
						'Today': [moment(), moment()],
						'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
						'Last 7 Days': [moment().subtract('days', 6), moment()],
						'Last 30 Days': [moment().subtract('days', 29), moment()],
						'This Month': [moment().startOf('month'), moment().endOf('month')],
						'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
					},
					startDate: moment().subtract('days', 29),
					endDate: moment()
				},
			function(start, end) {
				$('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
				if(id == "date_created_search_group") {
					load_all_control_number_per_date_created('control_number_search_list_group','control_number_search',$('#date_created_search_group').val());
				}
			}
		);
		return false;
	}
	
</script>