<?php
/* Include employee information */
require_once('get_employee_username.php');
?>
<input type="hidden" id="hidden_username" value="<?php echo $username; ?>">
<input type="hidden" id="hidden_date_today" value="<?php echo date('Y-m-d'); ?>">

<!--Main Container-->
<div id="row main_container" style="margin-top:20px;">
	<div class="col-sm-12">
		<div class="panel panel-primary">
	  		<div class="panel-heading">Employee List</div>
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
                            <i class="fa fa-info-circle" style="color:blue;"></i> These will be the list on batch uploading.<br>
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
							<button class="btn btn-primary btn-md fa fa-plus" id="btn_manage_batch"> Manage Batch</button>
						</p>
					</div>
					<div class="col-sm-12" id="container_batch_list">
						<table id="tbl_batch" class="table table-hover table-striped table-bordered" style="">
							<thead>
								<tr>
									<th><center>EmpNo</center></th>
									<th>Employee Name</th>
									<th><center>Remove </center></th>
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

<div class="modal fade" tabindex="-1" role="dialog" id="modal_manage_batch">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><span class="fa fa-user"> Manage Batch</span></h4>
      </div>
	<form id="frm_add_batch">
      <div class="modal-body">
		<div id="container_add_batch">
			<div class="row">
				<div class="col-sm-12">
					<datalist id="list_empno"></datalist>
					<label class="control-label">Employee Number</label>
					<input type="text" class="form-control" id="txt_add_batch_empno" style="text-transform:uppercase" list="list_empno" required>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<datalist id="list_empname"></datalist>
					<label class="control-label">Employee Name</label>
					<input type="text" class="form-control" id="txt_add_batch_empname" list="list_empname" required>
				</div>
			</div>
		</div>
      </div>
      <div class="modal-footer">
		<button type="submit" class="btn btn-success fa fa-save"> Add to batch</button>
        <button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
      </div>
	  </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- Call user defined functions common functions -->
<script src="../../../common_functions/common_functions.js" type="text/javascript"></script>

<script type="text/javascript">
	var username 				= $('#hidden_username').val();
	var tbl_batch      			= "tbl_batch";
	var oTable_batch_list       = "";
	var handler 				= './handler/handler.php';
	
	/* MANAGE BATCH START*/
	/*  Load datatable server side script  */
	oTable_batch_list = $('#'+tbl_batch).DataTable({
		"aaSorting"	 : [],			
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "./server_side_scripts/manage_batch_list_datatable.php?username="+username
	});
	
	$('#btn_home').click(function() {
		window.location.href = '../../otks_main/otks_dashboard/index_requestor.php';
	});
	
	$('#'+tbl_batch+' tbody').on('click', 'tr', function () {
		$('#'+tbl_batch+' tbody tr').attr('style','');
		$(this).attr('style','background:teal;color:white;');
	});
	
	$('#btn_manage_batch').click(function(){
		populate_datalist();
		$('#modal_manage_batch').modal('show');
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
	
	$('#frm_add_batch').submit(function (e) {
		e.preventDefault();
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
	
	$('#'+tbl_batch+' tbody').on('click','tr #btn_remove_batch', function(){
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
			alert('Employee was successfully removed on the list');
			oTable_batch_list.ajax.reload();
		});
	});
	
	
	/* pupulate data list */
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