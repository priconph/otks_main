<!-- <input type="hidden" id="hd_username" value="<?php echo $username; ?>">  -->
<input type="hidden" id="hd_username" value="ilturla"> 

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
							<button class="btn btn-primary btn-md fa fa-user-plus" id="btn_new_request" > New Request</button>
							<button class="btn btn-success btn-md fa fa-users" id="btn_batch_request" > Batch Request</button>
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
								<th>Employee Name/s</th>
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

<!-- Modal new request form (single) -->
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
	    <center><div id="div_msg_new" style="display:none;color:white;font-weight:bold;text-align:center;width:100%" class="row alert alert-danger"></div></center>
        <div id="row" style="padding:0px;">
			<div class="row panel panel-default" id="2nd_row_textbox">
				<div class="col-sm-6" style="margin-top:20px;" >
					<div class="form-inline" style="padding-right:0px;">
                        <div style="padding:2px;">
							<label style="width:100px;">Employee No.</label>
                            <datalist id="txt_employee_number_list">
                            </datalist>
							<input type="text" class="form-control" style="width:71%;" name="txt_employee_number" id="txt_employee_number" list="txt_employee_number_list" autocomplete="off" disabled required>
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
				<!-- 
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
				-->
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

<!-- Modal batch request form -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_batch_request">
  <div class="modal-dialog" style="width:800px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">New Pass Slip Request (Batch)</h4>
      </div>
      <form id="frm_batch_leave_request" method="post"> 
          <input type="hidden" id="txt_action_batch">
       <div class="modal-body">
		<center><div id="div_msg_batch" style="display:none;color:white;font-weight:bold;text-align:center;width:100%" class="row alert alert-danger"></div></center>
        <div id="row" style="">
			<div class="col-m-12">
        		<div id="container_tbl_employee_list"></div>
	       	</div>
		</div><br>
        <div id="row" style="padding:0px;">
			<div class="row" id="2nd_row_textbox">
				<div class="col-sm-6" style="margin-top:2px;">
                    <div class="form-inline" style="padding-right:0px;">
                        <div style="padding:2px;">
							<label style="width:100px;">Purpose of Leaving: </label>
							<input type="radio" name="rbtn_group_batch" value="0" id="rbtn_ut_batch" required> Undertime <br><label style="width:100px;"></label>
							<input type="radio" name="rbtn_group_batch" value="1" id="rbtn_ob_batch" required> Official Business
						</div>
                    </div>
                </div>
                <div class="col-sm-6" style="margin-top:2px;">
                    <div class="form-inline" style="padding-right:0px;">
                        <div style="padding:2px;"><br>
							<label style="width:100px;">Place of OB:</label>
							<input type="text" class="form-control" style="width:71%;" name="txt_place_ob_batch" id="txt_place_ob_batch" disabled>
						</div>
                    </div>
                </div>        
                <div class="col-sm-12" style="margin-top:2px;">
					<div class="form-inline" style="padding-right:0px;">
						<label style="width:100px;">Reason:</label>
						<textarea id="txt_reason_batch" class="form-control" style="width: 86%;" required></textarea>
					</div>
				</div>     
				<div class="col-sm-6" style="margin-top:2px;">
                    <div class="form-inline" style="padding-right:0px;">
                        <div style="padding:2px;">
							<label style="width:100px;">Time-out:</label>
							<input type="time" class="form-control" style="width:71%;" name="txt_time_out_batch" id="txt_time_out_batch" required>
						</div>
                    </div>
                </div>
				<div class="col-sm-6" style="margin-top:2px;">
                    <div class="form-inline" style="padding-right:0px;">
                        <div style="padding:2px;">
							<label style="width:100px;">Time return:</label>
							<input type="time" class="form-control" style="width:71%;" name="txt_time_return_batch" id="txt_time_return_batch">
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
                            <select data-placeholder="Select Approver" class="chosen-select"  name="txt_approver_batch" id="txt_approver_batch">
                                <option value=''></option>
                            </select>
						</div>
                    </div>
                </div>
				<div class="col-sm-6" style="margin-top:2px;">
                    <div class="form-inline" style="padding-right:0px;">
                        <div style="padding:2px;">
							<label style="width:100px;">Date of Leave:</label>
							<input type="date" class="form-control" style="width:71%;" name="txt_date_leave_batch" id="txt_date_leave_batch" min="<?php echo date("Y-m-d"); ?>" required>
						</div>
                    </div>
                </div> 
			</div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success fa fa-save" title="Click to save the record as draft" id="btn_save_batch"> Save</button>
        <button type="button" class="btn btn-warning fa fa-envelope" title="Click to save and send the record for approval" id="btn_save_n_send_batch"> Save & Send</button>
        <button type="button" class="btn btn-default fa fa-close" data-dismiss="modal" id="btn_close_new_batch"> Close</button>
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal edit batch request form -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_edit_batch_request">
  <div class="modal-dialog" style="width:800px;">
    <input type="hidden" id="txt_edit_batch_action">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Pass Slip Request</h4>
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
							<input type="radio" name="rbtn_edit_group_batch" value="0" id="rbtn_edit_ut_batch" required> Undertime <br><label style="width:100px;"></label>
							<input type="radio" name="rbtn_edit_group_batch" value="1" id="rbtn_edit_ob_batch" required> Official Business
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
						<textarea id="txt_edit_reason_batch" class="form-control" style="width: 86%;" required></textarea>
					</div>
				</div>     
				<div class="col-sm-6" style="margin-top:2px;">
                    <div class="form-inline" style="padding-right:0px;">
                        <div style="padding:2px;">
							<label style="width:100px;">Time-out:</label>
							<input type="time" class="form-control" style="width:71%;" name="txt_edit_time_out_batch" id="txt_edit_time_out_batch" required>
						</div>
                    </div>
                </div>
				<div class="col-sm-6" style="margin-top:2px;">
                    <div class="form-inline" style="padding-right:0px;">
                        <div style="padding:2px;">
							<label style="width:100px;">Time return:</label>
							<input type="time" class="form-control" style="width:71%;" name="txt_edit_time_return_batch" id="txt_edit_time_return_batch">
						</div>
                    </div>
                </div>  
				<div class="col-sm-6" style="margin-top:2px;">
                    <div class="form-inline" style="padding-right:0px;">
                        <div style="padding:2px;">
							<label style="width:100px;">Approver:</label>
                            <select data-placeholder="Select Approver" class="chosen-select"  name="txt_edit_approver_batch" id="txt_edit_approver_batch">
                                <option value=''></option>
                            </select>
						</div>
                    </div>
                </div>
				<div class="col-sm-6" style="margin-top:2px;">
                    <div class="form-inline" style="padding-right:0px;">
                        <div style="padding:2px;">
							<label style="width:100px;">Date of Leave:</label>
							<input type="date" class="form-control" style="width:71%;" name="txt_edit_date_leave_batch" id="txt_edit_date_leave_batch" min="<?php echo date("Y-m-d"); ?>" required>
						</div>
                    </div>
                </div> 
			</div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success fa fa-save" title="Click to save the record as draft" id="btn_update_batch"> Update</button>
        <button type="button" class="btn btn-warning fa fa-envelope" title="Click to save and send the record for approval" id="btn_update_send_batch"> Save & Send</button>
        <button type="button" class="btn btn-info fa fa-envelope" title="Click to update and send the record for approval" id="btn_update_revised_batch"> Save & Send Revised </button>
        <button type="button" class="btn btn-default fa fa-close" data-dismiss="modal" id="btn_close_update_batch"> Close</button>
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
				What: Batch pass slip request <br>
				How: Click the Batch Request button then select the employees included in the request. <br>
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

/* Data table declaration */
var dt_emp_overtime = "";
var dt_emp_list = "";
var tbl_employee_list 	   	= 'tbl_employee_list';
/* Arrays */
var array_batch_employee = [];
var array_batch_employee_name = [];
   
   
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
	
    $('#btn_close_new_batch').click(function () {
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
$('[name="rbtn_group_batch"]').on('click',function () {
   if($('[name="rbtn_group_batch"]:checked').val() == 0) {
       $('#txt_place_ob_batch').prop('required',false);
       $('#txt_place_ob_batch').prop('disabled',true);
       $('#txt_place_ob_batch').val('');
       $('#txt_time_return_batch').prop('disabled',true);
       $('#txt_time_return_batch').val('');
   } else {
       $('#txt_place_ob_batch').prop('required',true);
       $('#txt_place_ob_batch').prop('disabled',false);
       $('#txt_time_return_batch').prop('disabled',false);
       $('#txt_time_return_batch').val('');
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
$('[name="rbtn_edit_group_batch"]').on('click',function () {
   if($('[name="rbtn_edit_group_batch"]:checked').val() == 0) {
       $('#txt_edit_place_ob_batch').prop('required',false);
       $('#txt_edit_place_ob_batch').prop('disabled',true);
       $('#txt_edit_place_ob_batch').val('');
       $('#txt_edit_time_return_batch').prop('disabled',true);
       $('#txt_edit_time_return_batch').val('');
   } else {
       $('#txt_edit_place_ob_batch').prop('required',true);
       $('#txt_edit_place_ob_batch').prop('disabled',false);
       $('#txt_edit_time_return_batch').prop('disabled',false);
       $('#txt_edit_time_return_batch').val('');
   }
});
/* CLICK FUNCTIONS */
$('#btn_new_request').click(function(){
	$('#txt_action').val('');	
	load_approver_list('txt_approver',function () {
        $('.chosen-select#txt_approver').chosen({width:"71%", height: "100%"});
		load_employee_information('txt_employee_number','txt_requested_by','txt_position','txt_department','txt_request_date');
		$('#txt_approver').val('').trigger('chosen:updated');	
		$('#modal_new_leave_request').modal('show');
	});
});
$('#btn_batch_request').click(function(){
	$('#txt_action_batch').val('');	
	array_batch_employee = [];
	array_batch_employee_name = [];
	load_approver_list('txt_approver_batch',function () {
        $('.chosen-select#txt_approver_batch').chosen({width:"71%", height: "100%"});
		load_employee_via_managed_batch();
		$('#txt_approver_batch').val('').trigger('chosen:updated');	
		$('#modal_batch_request').modal('show');
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
	pkid 			= $(this).find('#txt_pkid').val();
	var req_type 	= $(this).find('#txt_req_type').val();
	if(req_type == 0) { //0 is individual request
		$('#txt_edit_action').val('');
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
	} else if(req_type == 1) { //1 is batch request
		array_batch_employee = [];
		array_batch_employee_name = [];
		if($(this).find('td:eq()').text() == 'For Edit') {
			$('#btn_update_batch').show(); 
			$('#btn_update_send_batch').show(); 
			$('#btn_update_revised_batch').hide(); 
		} else if($(this).find('td:eq()').text() == 'For Approval') {
			$('#btn_update_batch').hide();
			$('#btn_update_send_batch').hide();
			$('#btn_update_revised_batch').show();
		} else {
			$('#btn_update_batch').hide();
			$('#btn_update_send_batch').hide();
			$('#btn_update_revised_batch').hide();
		}
		load_approver_list('txt_edit_approver_batch',function () {   
			load_request_info_batch(pkid,req_type,function () {
				$('.chosen-select#txt_edit_approver_batch').chosen({width:"71%", height: "100%"});
				$('#modal_edit_batch_request').modal('show');		
			});
		});
	}
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
    e.preventDefault(); 
	$('#div_msg_new').html('');	
    if($('#txt_action').val() == '') {
        $('#txt_action').val('save');
    } else {
        $('#txt_action').val('save_n_send');
    }  
    if($('#txt_action').val() != '') {
        if($('#txt_approver').val() == '') {
			$('#div_msg_new').show();
            $('#div_msg_new').append('*** Please select your approver. ***<br>');
			$('#txt_action').val('');
        } else {
			$('#div_msg_new').hide();
            if($('#txt_action').val() == 'save') {
				$('#modal_new_leave_request').modal('hide');
                save_new_request();
            } else if($('#txt_action').val() == 'save_n_send'){
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
					$('#modal_new_leave_request').modal('hide');
                    save_new_request();
                });  
				$('#btn_modal_close').click(function() {
					$('#txt_action').val('');
				});
            }            
        }        
    }
});
$('#frm_batch_leave_request').submit(function (e) {
	e.preventDefault();   
	$('#div_msg_batch').html('');
	if(array_batch_employee.length == 0) {
		$('#div_msg_batch').append('*** Please select employee/s from the list. ***<br>');
		$('#div_msg_batch').show();
	} else {
		$('#div_msg_batch').hide();
		if($('#txt_action_batch').val() == '') {
			$('#txt_action_batch').val('save');
		} else {
			$('#txt_action_batch').val('save_n_send');
		}  
		if($('#txt_action_batch').val() != '') {			
			if($('#txt_approver_batch').val() == '') {
				$('#div_msg_batch').append('*** Please select your approver. ***['+$('#txt_approver_batch').val()+']<br>');
				$('#div_msg_batch').show();
			} else {
				if($('#txt_action_batch').val() == 'save') {
					save_batch_request();
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
						save_batch_request();
					});  
					$('#btn_modal_close').click(function() {
						$('#txt_action_batch').val('');
					});
				}            
			}        
		}
	}
});
$('#btn_save_n_send').click(function () {
    $('#txt_action').val('save_n_send');
    $('#btn_save').trigger('click');
});
$('#frm_edit_leave_request').submit(function (e) {
    e.preventDefault();    
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
        if($('#txt_edit_action').val() == 'save') {			
			$('#modal_edit_leave_request').modal('hide');
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
				$('#modal_edit_leave_request').modal('hide');
                save_edit_request();
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
$('#btn_save_n_send_batch').click(function () {
    $('#txt_action_batch').val('save_n_send');
    $('#btn_save_batch').trigger('click');
});  
$('#frm_edit_batch_request').submit(function (e) {
    e.preventDefault();   
	$('#div_msg_edit_batch').html(''); 
    if($('#txt_edit_batch_action').val() == '') {
        $('#txt_edit_batch_action').val('save');
    } else if($('#txt_edit_batch_action').val() == 'save_n_send') {
        $('#txt_edit_batch_action').val('save_n_send');
    } else if($('#txt_edit_batch_action').val() == 'save_n_send_revised') {
        $('#txt_edit_batch_action').val('save_n_send_revised');
    } else {
        $('#txt_edit_batch_action').val('error');
    }  
	if(array_batch_employee.length == 0) {
		$('#div_msg_edit_batch').show();
		$('#div_msg_edit_batch').append('*** Please select employee/s from the list. ***<br>');
	} else { 
		if($('#txt_edit_batch_action').val() != '') {			
			if($('#txt_edit_approver_batch').val() == '') {
				$('#div_msg_edit_batch').append('*** Please select your approver. ***['+$('#txt_edit_approver_batch').val()+']<br>');
				$('#div_msg_edit_batch').show();
			} else {				
				$('#div_msg_edit_batch').hide();
				if($('#txt_edit_batch_action').val() == 'save') {
				   save_edit_request_batch();
				} else {
					var val_batch  = '<div class="row alert alert-warning">';
						val_batch += '   <div class="col-sm-1">';
						val_batch += '       <i class="fa fa-exclamation-triangle fa-3x"></i>';
						val_batch += '   </div>';
						val_batch += '   <div class="col-sm-11">';
						val_batch += '       <h3>';
						val_batch += '       	Are you sure you want to send your request?';
						val_batch += '       </h3>';
						val_batch += '   </div>';
						val_batch += '</div>';
					var verify_btn = '<button id="btn_verify_yes" class="btn btn-success fa fa-check">YES</button>';
					system_message('System Validation',val_batch,verify_btn);     
					$('#btn_verify_yes').click(function() {
						$('#modal_edit_batch_request').modal('hide');
						save_edit_request_batch();
					});     
					$('#btn_modal_close').click(function() {
						$('#txt_edit_batch_action').val('');
					});
				}
			}
		}
	}
});
$('#btn_update_send_batch').click(function () {
    $('#txt_edit_batch_action').val('save_n_send');
    $('#btn_update_batch').trigger('click');
}); 
$('#btn_update_revised_batch').click(function () {
    $('#txt_edit_batch_action').val('save_n_send_revised');
    $('#btn_update_batch').trigger('click');
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
		$('#txt_edit_approver').val('');
        $('#'+txt_approver_list).append('<option value="litoped">De Pedro, Angelito Jr.</option>');

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
            $('#txt_employee_number').prop('disabled', false);
            $('#txt_requested_by').prop('disabled', false);
        } else {
            $('#txt_employee_number').prop('disabled', true);
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
    } else if($('#txt_action').val() == 'save_n_send'){
        var ob_status = 0;
    }
	var ob_place = $('#txt_place_ob').val();
	var ob_reason = $('#txt_reason').val();
	
    var data = {
		"action"	    : "add_new_request",
		"empno"		    : $('#txt_employee_number').val(),
		"empname"		: $('#txt_requested_by').val(),
		"position"      : $('#txt_position').val(),
		"ob_date"	    : $('#txt_date_leave').val(),
		"ob_purpose"  	: $('[name="rbtn_group"]:checked').val(),
		"ob_place"		: ob_place,
		"ob_reason"		: ob_reason,
		"ob_time_out"	: $('#txt_time_out').val(),
		"ob_time_return": $('#txt_time_return').val(),
		"ob_approver"	: $('#txt_approver').val(),
		"ob_status"		: ob_status,
		"username"		: username
	}
	call_ajax(data,handler,function(result){
		var body = '';
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
				body = '<div class="row alert alert-danger">';
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
				body += '       <h3>'+result['msg']+'</h3>';
				body += '   </div>';
				body += '</div>'; 
				system_message('System Message',body,'');
			}
			
		} else {
				body = '<div class="row alert alert-danger">';
				body += '   <div class="col-sm-1">';
				body += '       <i class="fa fa-info-circle fa-2x"></i>';
				body += '   </div>';
				body += '   <div class="col-sm-11">';
				body += '       <h3>'+result['msg']+'</h3>';
				body += '   </div>';
				body += '</div>'; 
			system_message('System Message',body,'');
		}
		oTable.draw(false);
		$('#txt_action').val('') ;
	});
}
    
function save_edit_request() {
	var ob_place = $('#txt_edit_place_ob').val();
	var ob_reason = $('#txt_edit_reason').val();
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
			"ob_place"		: ob_place,
			"ob_reason"		: ob_reason,
			"ob_time_out"	: $('#txt_edit_time_out').val(),
			"ob_time_return": $('#txt_edit_time_return').val(),
			"ob_approver"	: $('#txt_edit_approver').val(),
			"ob_status"		: ob_status,
			"username"		: username
		}
		call_ajax(data,handler,function(result){
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
				$('#btn_close_update').trigger('click');
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
	var email_msg = '';
	var data = {
        "action"              : "send_email_to_approver",
		"req_type"			  : "new",
		"pkid"				  : pkid
    }
    call_ajax(data,handler,function(result){
		if(result['msg_email'] == 'Message has been sent!') {
			email_msg  = '<div class="row alert alert-success">';
			email_msg += '   <div class="col-sm-1">';
			email_msg += '       <i class="fa fa-exclamation-circle fa-3x"></i>';
			email_msg += '   </div>';		
			email_msg += '   <div class="col-sm-11">';
			email_msg += '       <h3>';
			email_msg += '       	Record was successfully saved and sent to approver';
			email_msg += '       </h3>';
			email_msg += '   </div>';
			email_msg += '</div>';
		} else { 
			email_msg = '<div class="row alert alert-danger">';
			email_msg += '   <div class="col-sm-1">';
			email_msg += '       <i class="fa fa-info-circle fa-2x"></i>';
			email_msg += '   </div>';
			email_msg += '   <div class="col-sm-11">';
			email_msg += '       <h3>ERROR: '+result['msg_email']+'</h3>';
			email_msg += '   </div>';
			email_msg += '</div>'; 
		}
		system_message('System Message',email_msg,'');
		oTable.draw(false);
	});
}

function send_email_to_approver_revised(pkid) {
	var data = {
        "action"              : "send_email_to_approver",
		"req_type"			  : "revised",
		"pkid"				  : pkid
    }
    call_ajax(data,handler,function(result){		
		var email_msg = '';
		var body_msg = '';
		if(result['msg_email'] == 'Message has been sent!') {
				email_msg = 'Record was successfully updated and sent to approver';
				body_msg += '<div class="row alert alert-success">';
				body_msg += '   <div class="col-sm-1">';
				body_msg += '       <i class="fa fa-exclamation-circle fa-3x"></i>';
				body_msg += '   </div>';
		} else {	
				email_msg = 'ERROR: '+result['msg_email'];
				body_msg += '<div class="row alert alert-warning">';
				body_msg += '   <div class="col-sm-1">';
				body_msg += '       <i class="fa fa-exclamation-triangle fa-3x"></i>';
				body_msg += '   </div>';
		}				
				body_msg += '   <div class="col-sm-11">';
				body_msg += '       <h3>';
				body_msg += '       	'+email_msg;
				body_msg += '       </h3>';
				body_msg += '   </div>';
				body_msg += '</div>';
		system_message('System Message',body_msg,'');
		oTable.draw(false);
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

/* Batch request function */
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
		$('#txt_edit_approver_batch').val(result['ob_approver']).trigger('chosen:updated');	
		if(req_type == 0) {
			$('#txt_edit_employee_number_batch').val(result['empno']);
			$('#txt_edit_requested_by_batch').val(result['emp_name']);
		} else if(req_type == 1) {
			load_employee_via_batch(result['empno'],result['emp_name']);
		} 
        callback();
    });
}
  
function save_batch_request() {
    if($('#txt_action_batch').val() == 'save') {
        var ob_status = 4;
    } else {
        var ob_status = 0;
    }	
	var body_val  = '';
    var data = {
		"action"	    				: "add_batch_request",
		"array_batch_employee"			: array_batch_employee,
		"array_batch_employee_name"		: array_batch_employee_name,
		"ob_date"	    				: $('#txt_date_leave_batch').val(),
		"ob_purpose"  					: $('[name="rbtn_group_batch"]:checked').val(),
		"ob_place"						: $('#txt_place_ob_batch').val(),
		"ob_reason"						: $('#txt_reason_batch').val(),
		"ob_time_out"					: $('#txt_time_out_batch').val(),
		"ob_time_return"				: $('#txt_time_return_batch').val(),
		"ob_approver"					: $('#txt_approver_batch').val(),
		"ob_status"						: ob_status,
		"username"						: username
	}
	call_ajax(data,handler,function(result){
		// $('#btn_close_new_batch').trigger('click');
		var empno_group_valid = (result['empno_group_valid']).split('<br>');
		var empname_group_valid = (result['empname_group_valid']).split('<br>');
		var empno_group_invalid = (result['empno_group_invalid']).split('<br>');
		var empname_group_invalid = (result['empname_group_invalid']).split('<br>');
		if(result['valid_ctr'] != 0) {
			if(ob_status == 4) {
				body_val += '<div class="alert alert-success"><h5>The following employee/s was successfully added: </h5></div>';
			} if(ob_status == 0) {
				body_val += '<div class="alert alert-success"><h5>The following employee/s was successfully added and sent to assigned approver: </h5></div>';
				// send_email_to_approver(result['new_pkid']);
				var data_email = {
					"action"              : "send_email_to_approver",
					"req_type"			  : "new",
					"pkid"				  : result['new_pkid']
				}
				call_ajax(data_email,handler,function(result){
				});
			}
			
			body_val += '<table class="table">';
			body_val += ' <thead>';
			body_val += '  <tr>';
			body_val += '   <th>Empno</th>';
			body_val += '   <th>Name</th>';
			body_val += '  </tr>';
			body_val += ' </thead>';
			body_val += ' <tbody>';
		for(var i=0;i<result['valid_ctr'];i++) {
			body_val += '  <tr>';
			body_val += '   <td>'+empno_group_valid[i]+'</td>';
			body_val += '   <td>'+empname_group_valid[i]+'</td>';
			body_val += '  </tr>';
		}
			body_val += ' </tbody>';
			body_val += '</table>';
		}
		if(result['invalid_ctr'] != 0) {	
			if(result['invalid_ctr'] != 0) {
				body_val += '<br>';
			}
			body_val += '<div class="alert alert-danger"><h5>The following employee/s has existing request: </h5></div>';
			body_val += '<table class="table">';
			body_val += ' <thead>';
			body_val += '  <tr>';
			body_val += '   <th>Empno</th>';
			body_val += '   <th>Name</th>';
			body_val += '  </tr>';
			body_val += ' </thead>';
			body_val += ' <tbody>';
		for(var i=0;i<result['invalid_ctr'];i++) {
			body_val += '  <tr>';
			body_val += '   <td>'+empno_group_invalid[i]+'</td>';
			body_val += '   <td>'+empname_group_invalid[i]+'</td>';
			body_val += '  </tr>';
		}
			body_val += ' </tbody>';
			body_val += '</table>';
		}		
		system_message('System Validation',body_val,'');
		// $('#btn_modal_close').click(function() {
			// send_email_to_approver(result['new_pkid']);
		// });
		$('#txt_action_batch').val('');
	});
}

function load_employee_via_batch(empno_batch, empname_batch){
	var container = 'container_tbl_employee_list_edit';
	var data = {
		"action" 	: "load_hris_record_by_managed_batch",
		"username"	: username
	} 
	call_ajax(data, handler, function(result){	
		var tbl_employee_list_edit = 'tbl_employee_list_edit';
		var html  = '<table id="'+tbl_employee_list_edit+'">';
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
		$('#'+container).empty();
		$('#'+container).append(html);
		/* append table values */
		for(x=0;x<result['ctr'];x++){
			var html  = '<tr>';
				if(empno_batch.indexOf(result['empno'][x]) != -1) {
					html += '	<td><input type="checkbox"  checked class="chk_employee"></td>';
					array_batch_employee.push(result['empno'][x]);
					array_batch_employee_name.push(result['fullname'][x]);
				} else {
					html += '	<td><input type="checkbox" class="chk_employee"></td>';
				}
				html += '	<td>'+result['empno'][x]+'</td>';
				html += '	<td>'+result['fullname'][x]+'</td>';
				html += '</tr>';
			$('#'+tbl_employee_list_edit+' tbody').append(html);
		}
		var dt_emp_list_edit = $('#'+tbl_employee_list_edit).DataTable({
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
		});
		
		$('.chk_all_employee').on('click', function(){
			// var rows = dt_emp_list.rows({ 'search': 'applied' }).nodes();
			var rows = dt_emp_list_edit.rows({  }).nodes();
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
			dt_emp_list_edit.$('input[type="checkbox"]:checked').each(function(){
			var new_empno = $(this).closest('tr').find('td:eq(1)').text();
			var new_empname = $(this).closest('tr').find('td:eq(2)').text();
			var check_exist = check_exist_on_array(new_empno);
			if(check_exist != 1){
				array_batch_employee.push(new_empno);
				array_batch_employee_name.push(new_empname);
			}
		  });
		console.log('checked batch: '+array_batch_employee);
		});
	});
}

function save_edit_request_batch() {
	var ob_place = $('#txt_edit_place_ob_batch').val();
	var ob_reason = $('#txt_edit_reason_batch').val();
	$('#modal_edit_batch_request').modal('hide');
    if($('#txt_edit_batch_action').val() == 'save') {
        var ob_status = 4;
    } else if($('#txt_edit_batch_action').val() == 'save_n_send') {
        var ob_status = 0;
    } else if($('#txt_edit_batch_action').val() == 'save_n_send_revised') {
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
			"action"	    				: "update_request_batch",
			"pkid"		    				: pkid,
			"array_batch_employee"			: array_batch_employee,
			"array_batch_employee_name"		: array_batch_employee_name,
			"ob_date"	    				: $('#txt_edit_date_leave_batch').val(),
			"ob_purpose"  					: $('[name="rbtn_edit_group_batch"]:checked').val(),
			"ob_place"						: ob_place,
			"ob_reason"						: ob_reason,
			"ob_time_out"					: $('#txt_edit_time_out_batch').val(),
			"ob_time_return"				: $('#txt_edit_time_return_batch').val(),
			"ob_approver"					: $('#txt_edit_approver_batch').val(),
			"ob_status"						: ob_status,
			"username"						: username
		}
		call_ajax(data,handler,function(result){
			// alert(result['msg']);
			var modal_body_msg = '';
			if($('#txt_edit_batch_action').val() == 'save') {
					modal_body_msg += '<div class="row alert alert-success">';
					modal_body_msg += '   <div class="col-sm-1">';
					modal_body_msg += '       <i class="fa fa-exclamation-circle fa-3x"></i>';
					modal_body_msg += '   </div>';		
					modal_body_msg += '   <div class="col-sm-11">';
					modal_body_msg += '       <h3>';
					modal_body_msg += '       	'+result['msg'];
					modal_body_msg += '       </h3>';
					modal_body_msg += '   </div>';
					modal_body_msg += '</div>';
				system_message('System Message',modal_body_msg,'');
			} else if($('#txt_edit_batch_action').val() == 'save_n_send'){
			   send_email_to_approver(pkid);
			} else if($('#txt_edit_batch_action').val() == 'save_n_send_revised'){
			   send_email_to_approver_revised(pkid);
			} else {
					modal_body_msg += '<div class="row alert alert-danger">';
					modal_body_msg += '   <div class="col-sm-1">';
					modal_body_msg += '       <i class="fa fa-info-circle fa-2x"></i>';
					modal_body_msg += '   </div>';
					modal_body_msg += '   <div class="col-sm-11">';
					modal_body_msg += '       <h3>'+result['msg']+'</h3>';
					modal_body_msg += '   </div>';
					modal_body_msg += '</div>'; 
				system_message('System Message',modal_body_msg,'');
			}
			$('#txt_edit_batch_action').val('');
			// $('#btn_modal_close').click(function () {
				// $('#btn_close_update').trigger('click');
			// });  
			oTable.draw(false);
		});
	}
}
</script>