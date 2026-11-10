<input type="hidden" id="hd_username" value="<?php echo $username; ?>"> 
<!--Main Container-->
<div id="row main_container" style="margin-top:20px;width:100%">
	<div class="row panel panel-primary top-container">
		<div class="panel-heading" style="margin-bottom:10px;"><b>INDIVIDUAL TIME CARD</b></div>		
		<div class="col-sm-12">	
			<form class="form-inline" action="#" id="frm_search_attendance">
			  <div class="form-group">
				<label class="" for="txtStartDate">Start Date</label>
				<input type="date" class="form-control" id="txtStartDate" name="txtStartDate" title="Start Date" required>
			  </div>
			  <div class="form-group">
				<label class="" for="txtEndDate">End Date</label>
				<input type="date" class="form-control" id="txtEndDate" name = "txtEndDate" title="End Date" required>
			  </div>
			  <label class="" for="txtEndDate">Employee Number</label>
			  <input type="text" class="form-control" placeholder="EN" id="txtEmpNo" title="Employee Number" required>
			  <button type="submit" class="btn btn-primary" id="set_date_1"><span class="fa fa-calendar"></span> Search</button><br><br>
			</form>
		</div>	
	
</div>
		<div class="panel panel-success">
	  		<div class="panel-heading">Employee Attendance</div>
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
                            <!-- Double click the row to view / approve / disapprove the request.<br><br>
                            <b>Legend: </b>
                                <ol><b>OB</b> - (Official Business)</ol>
                                <ol><b>UT</b> - (Undertime)</ol></p></h5>
                        <h5><p>Row in <font color="red">Red</font> are uncontrolled documents.</p></h5>
                        <h5><p>Row in <font color="green">Green</font> are unactive documents.</p></h5> -->
                      </div>
                    </div>	
                   </div>	
                </div>	
				<div id="container_timecard">
					
				</div>
	 	 	</div>
		</div>
	</div>
</div>

<script src="../../../common_functions/common_functions.js"></script>
<script>
var oTable = '';    
var handler   = './handler/handler.php';
var table_id   = 'tblMain';
var start_date = '<?php echo date('Y-m-d'); ?>';
var end_date   = '<?php echo date('Y-m-d'); ?>';
var empno 	   = '';

$('document').ready(function(){
	oTable = $('#'+table_id).DataTable( {
		"bProcessing": true,
		"bServerSide": true,
		"aaSorting"	 : [ [1,"asc"] ],
		"pageLength" : 10,
		"sAjaxSource": "./server_side_scripts/raw_data.php?date_start="+start_date+"&date_end="+end_date+"&empno="+empno,
		"columnDefs": [
			{ className: "hide_column", "targets": [ 1 ] }
		  ]
	} );
});

$('#txtStartDate').change(function () {
	var data = {
		"action" 		: "add_15_days",
		"date_from"		: $('#txtStartDate').val()
	} 
	call_ajax(data, handler, function(result){		
		$('input#txtEndDate').attr({
			"min"   : $('#txtStartDate').val(),
			"max"   : result['date_to'],
			"value" : $('#txtStartDate').val()
		});
	});
});

$('#frm_search_attendance').on('submit',(function(e) {
	e.preventDefault();
	start_date 	= $('#txtStartDate').val();
	end_date 	= $('#txtEndDate').val();
	empno 		= $('#txtEmpNo').val();
	oTable.ajax.url( "./server_side_scripts/raw_data.php?date_start="+start_date+"&date_end="+end_date+"&empno="+empno ).load();
	oTable.draw(false);
	$('#modal_advance_search').modal('hide');
})); 
</script>