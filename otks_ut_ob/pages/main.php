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
						<button class="btn btn-primary btn-md fa fa-plus" id="btn_download_manual"> New Request</button>
						<button class="btn btn-primary btn-md fa fa-plus" id="btn_new_straight_request"> New Request</button>
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

<!-- Modal new overtime request form -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_new_straight_request">
  <div class="modal-dialog" style="width:800px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">New Straight Request</h4>
      </div>
      <form id="frm_new_overtime_request" method="post"> 
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
						<datalist id="txt_approver_list">
						</datalist>
						<div style="padding:2px;">
							<label style="width:150px;">Approver:</label>
							<input type="text" style="width:57%;" class="form-control" list="txt_approver_list" name="txt_approver" id="txt_approver" required>
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
<div class="modal fade" tabindex="-1" role="dialog" id="modal_edit_straight_request">
  <div class="modal-dialog" style="width:800px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Overtime Request</h4>
      </div>
      <form id="frm_edit_overtime_request" method="post"> 
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
							<input type="text" style="width:57%;" class="form-control" list="txt_approver_edit_list" name="txt_approver_edit" id="txt_approver_edit" required>
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

<script src="../../../common_functions/common_functions.js"></script>
<script>
var handler = './handler/handler.php';
var username = $('#hd_username').val();

$('document').ready(function(){
	var oTable = $('#tbl_straight_main').DataTable({
					"bProcessing": true,
					"bServerSide": true,
					"sAjaxSource": "./server_side_scripts/straight_main.php?username="+username
				 });
	
});

/* click functions */
$('#btn_new_straight_request').click(function(){
	$('#modal_new_straight_request').modal('show');
});
$('#btn_download').click(function(){
	window.open('manual_viewer.php','_blank');
});

$('#tbl_straight_main tbody').on('dblclick','tr',function(){
	var pkid = $(this).find('.btn-warning').val();
	modal_edit_straight_modal(pkid);
});

function modal_edit_straight_modal(pkid){
	var data = {
		"action"	: "fetch_main_data_update",
		"pkid"		: pkid
	}
	call_ajax(data,handler,function(result){
		// alert(result['req_approver']['0']);
		$('#txt_request_date_edit').val(result['req_date']['0']);  
		$('#txt_manpower_involved_edit').val(result['req_manpower']['0']);
		$('#txt_date_from_edit').val(result['req_datefrom']['0']);
		$('#txt_date_to_edit').val(result['req_dateto']['0']);
		$('#txt_requested_by_edit').val(result['req_by']['0']);
		$('#txt_division_edit').val('');
		$('#txt_department_edit').val('');
		$('#txt_approver_edit').val(result['req_approver']['0']);
		$('#txt_justification_edit').val(result['req_justification']['0']);
		$('#modal_edit_straight_request').modal('show');
	});
}

</script>