<?php
/* Include employee information */
require_once('./pages/get_employee_username.php');
$fkid = $_GET['pkid'];
?>
<input type="hidden" id="hidden_username" value="<?php echo $username; ?>">
<input type="hidden" id="hidden_date_today" value="<?php echo date('Y-m-d'); ?>">

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
			"action" 	: "get_employee_overtime",
			"fkid"		: fkid,
			"username"	: username
		}
		call_ajax(data, handler, function(result){
			var ctr = result['ctr'];
            var msg = '';
            var disabled = '';
			for(x=0;x<ctr;x++){
                if(result['system_comment'][x] == 'No record found!' || result['system_comment'][x] == 'No time in!' || result['system_comment'][x] == 'No time out!') {
                    msg = '<font color="red">'+result['system_comment'][x]+'</font>';
                } else if(result['system_comment'][x] == 'Successfully added!') {
                    msg = result['system_comment'][x];
                } else {
                    msg = '<font color="blue">'+result['system_comment'][x]+'</font>';
                }
                if(req_status != 0){
                    disabled = ' disabled ';
                } else {
                    disabled = '';
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
            if(req_status != 0) {
                if(req_status == 1) {
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
            }
		});
    }
    
	function show_main_container(){
		$('#container_btn_main').show();
	}
		
	/* ON LOAD FUNCTIONS */
	load_employee_overtime();
    load_overtime_main_info_by_pkid(fkid);
	show_main_container();
	
	$('#btn_close').click(function(){
		window.location.href = "approver_index.php";
	});	
		
</script>