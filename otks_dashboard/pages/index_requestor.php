<?php
/* Include employee information */
require_once('get_employee_username.php');
?>
<input type="hidden" id="hidden_username" value="<?php echo $username; ?>">
<input type="hidden" id="hidden_date_today" value="<?php echo date('Y-m-d'); ?>">
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Online Time Keeping System - Requestor Modules</title>
	
	<!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../../../media/font_awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
</head>

<body>	
	<div id="swrapper">
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Home</h1>
			</div>
			<!-- /.col-lg-12 -->
		</div>
		<!-- /.row -->
		<div class="row">
			<div class="col-lg-3 col-md-6" data-toggle="tooltip" data-placement="bottom" title="Click to view the pending overtime request for approval" id="div_ot_approval">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-clock-o fa-5x"></i>
							</div>
							<div class="col-xs-9 text-right">
								<div class="huge" id="for_approval_ot" data-placement="bottom" title="Total number of pending overtime request for approval"></div>
								<div data-toggle="tooltip" data-placement="bottom" title="Click to view the pending overtime request for approval">Overtime Request</div>
							</div>
						</div>
					</div>
					<a href="../../otks_overtime/requestor_index.php" data-placement="bottom" title="Click to view the pending overtime request for approval">
						<div class="panel-footer">
							<span class="pull-left">View Request Details</span>
							<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
							<div class="clearfix"></div>
						</div>
					</a>
				</div>
			</div>
			<div class="col-lg-3 col-md-6">
				<div class="panel panel-green" data-placement="bottom" title="Click to view the pending pass request for approval" id="div_ps_approval">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-car fa-5x"></i>
							</div>
							<div class="col-xs-9 text-right">
								<div class="huge" id="for_approval_ps" data-placement="bottom" title="Total number of pending pass request for approval"></div>
								<div>Pass Slip Request</div>
							</div>
						</div>
					</div>
					<a href="../../otks_ut_ob/requestor_index.php" data-placement="bottom" title="Click to view the pending pass request for approval">
						<div class="panel-footer">
							<span class="pull-left">View Request Details</span>
							<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
							<div class="clearfix"></div>
						</div>
					</a>
				</div>
			</div>
			<div class="col-lg-3 col-md-6">
				<div class="panel panel-yellow" data-placement="bottom" title="Click to view the pending straight hour request for approval" id="div_sh_approval">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-calendar-check-o fa-5x"></i>
							</div>
							<div class="col-xs-9 text-right">
								<div class="huge" id="for_approval_sh" data-placement="bottom" title="Total number of pending straight hour request for approval"></div>
								<div>Straight Hour Request</div>
							</div>
						</div>
					</div>
					<a href="../../otks_straight_hours/index_requestor.php" data-placement="bottom" title="Click to view the pending straight hour request for approval">
						<div class="panel-footer">
							<span class="pull-left">View Request Details</span>
							<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
							<div class="clearfix"></div>
						</div>
					</a>
				</div>
			</div>
			<!-- <div class="col-lg-3 col-md-6">
				<div class="panel panel-red" data-placement="bottom" title="Click 'Manage Settings' to manage batch upload content" id="div_ms">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-gears fa-5x"></i>
							</div>
							<div class="col-xs-9 text-right">
								<div class="huge"><font style="color:#d9534f;">0</font></div>
								<div>OTKS Settings</div>
							</div>
						</div>
					</div>
					<a href="../settings.php" data-placement="bottom" title="Click to manage batch upload content">
						<div class="panel-footer">
							<span class="pull-left">Manage Settings</span>
							<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
							<div class="clearfix"></div>
						</div>
					</a>
				</div>
			</div> -->
			
			<div class="col-lg-3 col-md-6" id='div_att_viewer'>
				<div class="panel panel-info" data-placement="bottom" title="Click to view employee attendance" id="div_att">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-calendar fa-5x"></i>
							</div>
							<div class="col-xs-9 text-right">
								<div class="huge"><font style="color:#d9edf7;">0</font></div>
								<div>OTKS Attendance Viewer</div>
							</div>
						</div>
					</div>
					<a href="../../otks_attendance_viewer/attendance_index.php" data-placement="bottom" title="Click to view employee attendance">
						<div class="panel-footer">
							<span class="pull-left">View Attendance</span>
							<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
							<div class="clearfix"></div>
						</div>
					</a>
				</div>
			</div>	
			<!-- <div class="col-lg-3 col-md-6">
				<div class="panel panel-danger" data-placement="bottom" title="Click to view employee attendance" id="div_late">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-id-badge fa-5x"></i>
							</div>
							<div class="col-xs-9 text-right">
								<div class="huge"><font style="color:#f2dede;">0</font></div>
								<div>OTKS Tardiness Monitoring</div>
							</div>
						</div>
					</div>
					<a href="../../otks_tardiness_monitoring/monitoring_index.php" data-placement="bottom" title="Click to view employee attendance">
						<div class="panel-footer">
							<span class="pull-left">View Attendance</span>
							<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
							<div class="clearfix"></div>
						</div>
					</a>
				</div>
			</div> -->
		</div>
	</div>
</body>
<!-- Call user defined functions common functions -->
<script src="../../../common_functions/common_functions.js" type="text/javascript"></script>
<script src="../../../media/js/jquery.js"></script>

<script type="text/javascript">
	var username 				= $('#hidden_username').val();
	var handler 				= '../handler/handler.php';
	for_approval_ot();
	for_approval_ps();
	for_approval_sh();
	attendance_viewer_access();
	
	$('#div_ot_approval').click(function() {
		window.location.href = '../../otks_overtime/requestor_index.php';
	});
	$('#div_ps_approval').click(function() {
		window.location.href = '../../otks_ut_ob/requestor_index.php';
	});
	$('#div_sh_approval').click(function() {
		window.location.href = '../../otks_straight_hours/index_requestor.php';
	});
	$('#div_ms').click(function() {
		window.location.href = '../settings.php';
	});
	$('#div_att').click(function() {
		window.location.href = '../../otks_attendance_viewer/attendance_index.php';
	});
	$('#div_late').click(function() {
		window.location.href = '../../otks_tardiness_monitoring/monitoring_index.php';
	});
	
	function for_approval_ot(){
		var data = {
			"action"	: "for_approval_ot",
			"requestor"	: username
		}
		call_ajax(data, handler, function(result){
			$('#for_approval_ot').text(result['ot_pending']);
		});
	}
	function for_approval_ps(){
		var data = {
			"action"	: "for_approval_ps",
			"requestor"	: username
		}
		call_ajax(data, handler, function(result){
			$('#for_approval_ps').text(result['ot_pending']);
		});
	}
	function for_approval_sh(){
		var data = {
			"action"	: "for_approval_sh",
			"requestor"	: username
		}
		call_ajax(data, handler, function(result){
			$('#for_approval_sh').text(result['ot_pending']);
		});
	}

	function attendance_viewer_access(){
		var data = {
			"action"	: "get_attendance_viewer_access",
			"session_username"	: username
		}
		call_ajax(data, handler, function(result){
			if(result['fkmodname'] && result['fkmodname'].length > 0){
				if($.inArray("189", result['fkmodname']) !== -1){
					$('#div_att_viewer').show();
				}
				else{
					$('#div_att_viewer').hide();
				}
			}
		});
	}
</script>	
	
	
	
	