<?php
    require_once('oop.php'); //OOP Path
    $array_fields = array('ip_address');
    $table 	   	= 'tbl_valid_ip';
    $joins 	   	= '';
    $sql_where 	= 'WHERE ip_address="'.$_SERVER['REMOTE_ADDR'].'" AND category="otks"';
    $sql_order 	= '';
    $sql_limit 	= '';
    $result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
    $ctr = 0;
    if($result->num_rows == 0) {
        header('Location: http://systemone');
    }
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>Online Time Keeping System 2.0</title>
		<link href = 'css/otksmainscreenstyle.css' rel = 'stylesheet' style = 'text/css'>
        <!-- <script src="../media/js/jquery.js"></script> -->
		<script type = 'text/javascript' src = 'js/logsearch.js'></script>
		<script src="js/jquery.min.js"></script>
		<script src="js/jquery.textfill.js"></script>
		<script type = 'text/javascript'>
            $(document).ready(function() {
                /* Declared Variables */
                var onProcess = 0;
				var togbuslate = 'OFF';
				var earlyknockoff = 'OFF';
				var loggedchecker = 'OFF';
				var opac = '0';
				var opac2 = '0';
				var moder = 'NORMAL';
				var secDiff = 0;
				var bootloader;
				var timeChecker;
				var hrs;
				var mins;
				var sec;
				var dtday;
				var secday;
				var secdaySplitter;
                var emp_no = '';
                var last_name = '';
                var first_name = '';
                var middle_name = '';
                var first_middle_name = '';
                var section = '';
                var position = '';
                var message = '';
                var time_logged = '';
                var attendance_mode = '';
                var handler = 'handler.php';
                /* On load function */
                loadTime();
                function loadTime() { 
					$('#timeticker').load('timeticker.php');
					$('#dateticker').load('dateticker.php');
					if (earlyknockoff == 'OFF') {
						$('#earlyknockoffwrapper').css('opacity', '0.0');
					} else { 
						/* if (opac == '0') {
							$('#earlyknockoffwrapper').css('opacity', '0.0');
							opac = '1';
						} else { 
							$('#earlyknockoffwrapper').css('opacity', '1.0');
							$('#earlyknockoffwrapper').text('EARLY KNOCKOFF');
							opac = '0';
						} */
					}
					if (loggedchecker == 'OFF') {
						$('#duplicateloggedwrapper').css('opacity', '0.0');
					} else {
						if (opac2 == '0') {
							$('#duplicateloggedwrapper').css('opacity', '0.0');
							opac2 = '1';
						} else { 
							$('#duplicateloggedwrapper').css('opacity', '1.0');
							$('#duplicateloggedwrapper').text('DUPLICATE LOG IN/OUT');
							opac2 = '0';
						}
					}
					
					bootloader = document.getElementById('timeticker').innerHTML;
					timeChecker = bootloader.split(':');
					hrs = parseInt(timeChecker[0]);
					mins = parseInt(timeChecker[1]);
					secday = timeChecker[2];
					secdaySplitter = secday.split(' ');
					sec = parseInt(secdaySplitter[0]);
					dtday = secdaySplitter[1];
					
					if (dtday == 'PM') {
						if (hrs >= 1 && hrs != 12) {
							hrs = hrs + 12;
						}
					}
					
					if (togbuslate == 'OFF') {
						moder = 'NORMAL';
					} else {
						moder = 'BUS LATE';
						$('#txtmode').html('BUS LATE MODE');
						$('#modewrapper').css('background-color', 'yellow');
					}
					document.getElementById('txtEmpNo').focus();
					setTimeout(loadTime, 500);
				}
                
                function get_employee_info_by_emp_no(emp_no) {
                    var data = {
                        "action" 	: "get_employee_info_by_emp_no",
                        "emp_no"	: emp_no
                    }
                    
                    call_ajax(data, handler, function(result){
                        $("#tablerecent > tbody tr").remove();
                        if(result['last_name'] == 'NOT FOUND') {
                            last_name         = '';
                            first_middle_name = '';
                            section           = '';
                            position          = '';
                            message           = '';
                            $('#txtSection').html('');
                            $('#txtPosition').html('');
                            $('#txtFMName').html('');
                            $('#txtMessage').html('');
                            $('#inwrapper').html('');
                            $('#txtLastName').html('NOT FOUND');
                            $('#otksimg').attr('src', 'pmi_pictures/not_found.jpg');
                            $('#floatEmp').val('');
                            loggedchecker = 'OFF';
                        } else {
                            last_name         = result['last_name'];
                            first_name        = result['first_name'];
                            middle_name       = result['middle_name'];
                            first_middle_name = result['first_name']+' '+result['middle_name'].substring(0,1) + ".";
                            section           = result['section'];
                            position          = result['position'];
                            message           = result['message'];
                            $('#floatEmp').val(emp_no.toUpperCase());
                            $('#txtSection').html(section);
                            $('#txtPosition').html(position);
                            $('#txtLastName').html(last_name + ",");
                            $('#txtFMName').html(first_middle_name);
//                            $('#otksimg').attr('src', 'pmi_pictures/' + emp_no.toUpperCase() + '.jpg');
                            $('#otksimg').attr('src', 'pmi_pictures/' + emp_no.toUpperCase() + '.jpg');
                            $('#txtMessage').html(result['message']);
//                            resizeFont();
//                            adjustHeights('#txtFMName');
//                            adjustHeights('#txtLastName');
							var check_if_has_pending_pass_request = result['message'];
							if(check_if_has_pending_pass_request.match("FOR APPROVAL PASS REQUEST") || check_if_has_pending_pass_request.match("EARLY TIME OUT FOR UNDERTIME REQUEST")) {
								/* do not save the record with for approval request */
								loadPage(emp_no);								
							} else if(check_if_has_pending_pass_request.match("DRAFT PASS REQUEST")) {
								loadPage(emp_no);								
							} else {
								get_employee_recent_log_interval(emp_no);
							}                            
                        }
                    });
                }
                
                function get_employee_recent_log_interval(emp_no) {
                    var data = {
                        "action" 	: "get_employee_recent_log_interval",
                        "emp_no"	: emp_no
                    }
                    call_ajax(data, handler, function(result){
                        var hr_interval  = result['hr_interval'];
                        var min_interval = result['min_interval'];
                        var sec_interval = result['sec_interval'];
                        // alert(hr_interval+':'+min_interval+':'+sec_interval);
                        time_logged      = result['time_now'];
						/* Log checker ON means within 15 minutes interval */
						if(result['log_checker'] == "ON") {
							earlyknockoff = 'OFF';
							loggedchecker = 'ON';
							$('#txtmode').html('');
							$('#txtMessage').html('ALREADY LOGGED IN/OUT!!!');
							loadPage(emp_no);
						} else {
							append_employee_attendance(function() {
								setTimeout(loadPage(emp_no), 1000);	
								onProcess = 1;
							});
						}
                    });
                }
                
                function append_employee_attendance(callback) {
                    var data = {
                        "action" 		: "append_employee_attendance",
                        "emp_no"		: emp_no,
                        "mode"	    	: moder,
                        "last_name"		: last_name,
                        "first_name"	: first_name,
                        "middle_name"	: middle_name,
                        "section"		: section,
                        "position"		: position,
                        "time_logged"	: time_logged
                    }
//                    alert(data['emp_no']+'\n'+data['mode']+'\n'+data['last_name']+'\n'+data['first_name']+'\n'+data['middle_name']+'\n'+data['section']+'\n'+data['position']+'\n'+data['time_logged']+'\n');
                    call_ajax(data, handler, function(result){
                        attendance_mode = result['mode'];
                        var time_log = result['time_log'];
                        if(attendance_mode == 'IN' || attendance_mode == "OB-IN") {
                            $('#inwrapper').css('background', '#FF8A8A');
                            $('#inwrapper').css('background', '-moz-linear-gradient(top,#FF8A8A 0%,#BD2B2B 100%)');
                            $('#inwrapper').css('background', '-webkit-gradient(linear,left top,left bottom,color-stop(0%,#FF8A8A),color-stop(100%,#BD2B2B))');
                            $('#inwrapper').css('background', '-webkit-linear-gradient(top,#FF8A8A 0%,#BD2B2B 100%)');
                            $('#inwrapper').css('background', '-o-linear-gradient(top,#FF8A8A 0%,#BD2B2B 100%)');
                            $('#inwrapper').css('background', '-ms-linear-gradient(top,#FF8A8A 0%,#BD2B2B 100%)');
                            $('#inwrapper').css('background', 'linear-gradient(top,#FF8A8A 0%,#BD2B2B 100%)');
                            $('#inwrapper').css('filter', "progid:DXImageTransform.Microsoft.gradient(startColorstr='#FF8A8A',endColorstr='#BD2B2B',GradientType=0)");
                            $('#inwrapper').html("IN " + time_log);
                            earlyknockoff = 'OFF';
                            loggedchecker = 'OFF';
                            $('#txtmode').html('NORMAL MODE');
                            $('#modewrapper').css('background-color', 'white');
                        } else if(attendance_mode == 'BUS LATE') {
                            $('#inwrapper').css('background', '#FF8A8A');
                            $('#inwrapper').css('background', '-moz-linear-gradient(top,#FF8A8A 0%,#BD2B2B 100%)');
                            $('#inwrapper').css('background', '-webkit-gradient(linear,left top,left bottom,color-stop(0%,#FF8A8A),color-stop(100%,#BD2B2B))');
                            $('#inwrapper').css('background', '-webkit-linear-gradient(top,#FF8A8A 0%,#BD2B2B 100%)');
                            $('#inwrapper').css('background', '-o-linear-gradient(top,#FF8A8A 0%,#BD2B2B 100%)');
                            $('#inwrapper').css('background', '-ms-linear-gradient(top,#FF8A8A 0%,#BD2B2B 100%)');
                            $('#inwrapper').css('background', 'linear-gradient(top,#FF8A8A 0%,#BD2B2B 100%)');
                            $('#inwrapper').css('filter', "progid:DXImageTransform.Microsoft.gradient(startColorstr='#FF8A8A',endColorstr='#BD2B2B',GradientType=0)");
                            $('#inwrapper').html("IN " + time_log);
                            earlyknockoff = 'OFF';
                            loggedchecker = 'OFF';
                            $('#txtmode').html('BUS LATE MODE');
                            $('#modewrapper').css('background-color', 'yellow');
                        } else if(attendance_mode == 'OUT' || attendance_mode == 'OB-OUT' || attendance_mode == 'UNDERTIME') {
                            earlyknockoff = 'OFF';
                            loggedchecker = 'OFF';
                            if (hrs == 7 && mins < 33) {
                                earlyknockoff = 'ON';
                            } else if (hrs == 15 && mins < 33) {
                                earlyknockoff = 'ON';
                            } else if (hrs == 16 && mins < 33) {
                                earlyknockoff = 'ON';
                            } else {
                                earlyknockoff = 'OFF';
                            }

                            $('#inwrapper').css('background', '#FCFCD4');
                            $('#inwrapper').css('background', '-moz-linear-gradient(top,#FCFCD4 0%,#C7C708 100%)');
                            $('#inwrapper').css('background', '-webkit-gradient(linear,left top,left bottom,color-stop(0%,#FF8A8A),color-stop(100%,#C7C708))');
                            $('#inwrapper').css('background', '-webkit-linear-gradient(top,#FCFCD4 0%,#C7C708 100%)');
                            $('#inwrapper').css('background', '-o-linear-gradient(top,#FCFCD4 0%,#C7C708 100%)');
                            $('#inwrapper').css('background', '-ms-linear-gradient(top,#FCFCD4 0%,#C7C708 100%)');
                            $('#inwrapper').css('background', 'linear-gradient(top,#FCFCD4 0%,#C7C708 100%)');
                            $('#inwrapper').css('filter', "progid:DXImageTransform.Microsoft.gradient(startColorstr='#FCFCD4',endColorstr='#C7C708',GradientType=0)");
                            $('#inwrapper').html("OUT " + time_log);
                            $('#txtmode').html('NORMAL MODE');
                            $('#modewrapper').css('background-color', 'white');
                        } else if(attendance_mode == 'OUT-EARLY') {
                            earlyknockoff = 'ON';
                            loggedchecker = 'OFF';

                            $('#inwrapper').css('background', '#FCFCD4');
                            $('#inwrapper').css('background', '-moz-linear-gradient(top,#FCFCD4 0%,#C7C708 100%)');
                            $('#inwrapper').css('background', '-webkit-gradient(linear,left top,left bottom,color-stop(0%,#FF8A8A),color-stop(100%,#C7C708))');
                            $('#inwrapper').css('background', '-webkit-linear-gradient(top,#FCFCD4 0%,#C7C708 100%)');
                            $('#inwrapper').css('background', '-o-linear-gradient(top,#FCFCD4 0%,#C7C708 100%)');
                            $('#inwrapper').css('background', '-ms-linear-gradient(top,#FCFCD4 0%,#C7C708 100%)');
                            $('#inwrapper').css('background', 'linear-gradient(top,#FCFCD4 0%,#C7C708 100%)');
                            $('#inwrapper').css('filter', "progid:DXImageTransform.Microsoft.gradient(startColorstr='#FCFCD4',endColorstr='#C7C708',GradientType=0)");
                            $('#inwrapper').html("OUT " + time_log);
                            $('#txtmode').html('NORMAL MODE');
                            $('#modewrapper').css('background-color', 'white');
                        } else if(attendance_mode == 'LATE') {
                            earlyknockoff = 'OFF';
                            loggedchecker = 'OFF';
                            $('#inwrapper').css('background', '#FF8A8A');
                            $('#inwrapper').css('background', '-moz-linear-gradient(top,#FF8A8A 0%,#BD2B2B 100%)');
                            $('#inwrapper').css('background', '-webkit-gradient(linear,left top,left bottom,color-stop(0%,#FF8A8A),color-stop(100%,#BD2B2B))');
                            $('#inwrapper').css('background', '-webkit-linear-gradient(top,#FF8A8A 0%,#BD2B2B 100%)');
                            $('#inwrapper').css('background', '-o-linear-gradient(top,#FF8A8A 0%,#BD2B2B 100%)');
                            $('#inwrapper').css('background', '-ms-linear-gradient(top,#FF8A8A 0%,#BD2B2B 100%)');
                            $('#inwrapper').css('background', 'linear-gradient(top,#FF8A8A 0%,#BD2B2B 100%)');
                            $('#inwrapper').css('filter', "progid:DXImageTransform.Microsoft.gradient(startColorstr='#FF8A8A',endColorstr='#BD2B2B',GradientType=0)");
                            $('#inwrapper').html("IN " + time_log);

                            $('#txtmode').html('LATE MODE');
                            $('#modewrapper').css('background-color', 'red');
                        } else if(attendance_mode == 'BUS LATE') {
                            earlyknockoff = 'OFF';
                            loggedchecker = 'OFF';
                        } else if(attendance_mode == '') {
						
						} else {
                            earlyknockoff = 'OFF';
                            loggedchecker = 'ON';
                        }
                        callback();
                    });
                }
                
                function resizeFont() {
					 var size = 20;

					 if (!isNaN(size)) {
						 $('.jtextfill').textfill({
							 maxFontPixels: size
						 });
					 }
				}
                
                function loadPage(emp_no) {
                    var data = {
                        "action" 	: "load_log_record",
                        "emp_no"	: emp_no
                    }
                    call_ajax(data, handler, function(result){
//                        alert(result['ctr']);
                        var tbl_body = '';
                        for(var i=0;i<result['ctr'];i++) {
                            if(i == 0) {
                                tbl_body = "<tr><td>" + result['date_in'][i] + "</td><td>" + result['time_in'][i] + "</td><td>" + result['mode_in'][i] + "</td><td>" + result['date_out'][i] + "</td><td>" + result['time_out'][i] + "</td><td>" + result['mode_out'][i] + "</td></tr>";
                            } else {
                                if(result['time_in'][i] == '' || result['time_out'][i] == '') {
									if(result['time_in'][i] == 'BDL' && result['time_out'][i] == '') {
										tbl_body = "<tr><td>" + result['date_in'][i] + "</td><td>" + result['time_in'][i] + "</td><td>" + result['mode_in'][i] + "</td><td>" + result['date_out'][i] + "</td><td>" + result['time_out'][i] + "</td><td>" + result['mode_out'][i] + "</td></tr>";
									} else if(result['time_in'][i] == 'BL' && result['time_out'][i] == '') {
										tbl_body = "<tr><td>" + result['date_in'][i] + "</td><td>" + result['time_in'][i] + "</td><td>" + result['mode_in'][i] + "</td><td>" + result['date_out'][i] + "</td><td>" + result['time_out'][i] + "</td><td>" + result['mode_out'][i] + "</td></tr>";
									} else if(result['time_in'][i] == 'BRL' && result['time_out'][i] == '') {
										tbl_body = "<tr><td>" + result['date_in'][i] + "</td><td>" + result['time_in'][i] + "</td><td>" + result['mode_in'][i] + "</td><td>" + result['date_out'][i] + "</td><td>" + result['time_out'][i] + "</td><td>" + result['mode_out'][i] + "</td></tr>";
									} else if(result['time_in'][i] == 'do' && result['time_out'][i] == '') {
										tbl_body = "<tr><td>" + result['date_in'][i] + "</td><td>" + result['time_in'][i] + "</td><td>" + result['mode_in'][i] + "</td><td>" + result['date_out'][i] + "</td><td>" + result['time_out'][i] + "</td><td>" + result['mode_out'][i] + "</td></tr>";
									} else if(result['time_in'][i] == 'FL' && result['time_out'][i] == '') {
										tbl_body = "<tr><td>" + result['date_in'][i] + "</td><td>" + result['time_in'][i] + "</td><td>" + result['mode_in'][i] + "</td><td>" + result['date_out'][i] + "</td><td>" + result['time_out'][i] + "</td><td>" + result['mode_out'][i] + "</td></tr>";
									} else if(result['time_in'][i] == 'holiday' && result['time_out'][i] == '') {
										tbl_body = "<tr><td>" + result['date_in'][i] + "</td><td>" + result['time_in'][i] + "</td><td>" + result['mode_in'][i] + "</td><td>" + result['date_out'][i] + "</td><td>" + result['time_out'][i] + "</td><td>" + result['mode_out'][i] + "</td></tr>";
									} else if(result['time_in'][i] == 'ML' && result['time_out'][i] == '') {
										tbl_body = "<tr><td>" + result['date_in'][i] + "</td><td>" + result['time_in'][i] + "</td><td>" + result['mode_in'][i] + "</td><td>" + result['date_out'][i] + "</td><td>" + result['time_out'][i] + "</td><td>" + result['mode_out'][i] + "</td></tr>";
									} else if(result['time_in'][i] == 'SL' && result['time_out'][i] == '') {
										tbl_body = "<tr><td>" + result['date_in'][i] + "</td><td>" + result['time_in'][i] + "</td><td>" + result['mode_in'][i] + "</td><td>" + result['date_out'][i] + "</td><td>" + result['time_out'][i] + "</td><td>" + result['mode_out'][i] + "</td></tr>";
									} else if(result['time_in'][i] == 'VL' && result['time_out'][i] == '') {
										tbl_body = "<tr><td>" + result['date_in'][i] + "</td><td>" + result['time_in'][i] + "</td><td>" + result['mode_in'][i] + "</td><td>" + result['date_out'][i] + "</td><td>" + result['time_out'][i] + "</td><td>" + result['mode_out'][i] + "</td></tr>";
									} else if(result['time_in'][i] == 'yec' && result['time_out'][i] == '') {
										tbl_body = "<tr><td>" + result['date_in'][i] + "</td><td>" + result['time_in'][i] + "</td><td>" + result['mode_in'][i] + "</td><td>" + result['date_out'][i] + "</td><td>" + result['time_out'][i] + "</td><td>" + result['mode_out'][i] + "</td></tr>";
									} else {
										tbl_body = "<tr><td bgcolor=red>" + result['date_in'][i] + "</td><td bgcolor=red>" + result['time_in'][i] + "</td><td bgcolor=red>" + result['mode_in'][i] + "</td><td bgcolor=red>" + result['date_out'][i] + "</td><td bgcolor=red>" + result['time_out'][i] + "</td><td bgcolor=red>" + result['mode_out'][i] + "</td></tr>";
									}
                                } else {
                                    tbl_body = "<tr><td>" + result['date_in'][i] + "</td><td>" + result['time_in'][i] + "</td><td>" + result['mode_in'][i] + "</td><td>" + result['date_out'][i] + "</td><td>" + result['time_out'][i] + "</td><td>" + result['mode_out'][i] + "</td></tr>";
                                }
                            }
                            $("#tablerecent > tbody").append(tbl_body);
                        }
                        onProcess = 0;
					    $('#txtEmpNo').val('');
                    });
				}
                
                function call_ajax(data, handler, fn) {
                    data = $.param(data);
                    $.ajax({
                        type: "post",
                        dataType: "json",
                        data: data,
                        url: handler,
                        success: function (result) {
                            fn(result);
                        },
                        error: function (result) {
                            alert('error ajax');
                        }
                    });
                }
                
                $('#txtEmpNo').keyup(function (e) {
                    if (e.keyCode == 13 && onProcess == 0) {
                        emp_no = ($('#txtEmpNo').val()).toUpperCase();
                        if (emp_no == 'BLMD') {
							togbuslate = 'ON';
							loggedchecker = 'OFF';
						} else if (emp_no == 'NMMD') {
							togbuslate = 'OFF';
                            loggedchecker = 'OFF';
							$('#txtmode').html('NORMAL MODE');
                            $('#modewrapper').css('background-color', 'white');
						} else {                            
                            $('#txtmode').html('NORMAL MODE');
                            $('#modewrapper').css('background-color', 'white');
                            get_employee_info_by_emp_no(emp_no);
                        }
                        $('#txtEmpNo').val('');
                        $('#txtMessage').html('');
//                        alert('1 '+moder);
//                        setTimeout(loadPage, 1000);	
                    }
                });
                
                function adjustHeights(elem) {
                  var fontstep = 10;
                  if ($(elem).height()>$(elem).parent().height() || $(elem).width()>$(elem).parent().width()) {
                    $(elem).css('font-size',(($(elem).css('font-size').substr(0,2)-fontstep)) + 'px').css('line-height',(($(elem).css('font-size').substr(0,2))) + 'px');
                    adjustHeights(elem);
                  }
                }
            });
        </script>
    </head>
    <body>
		<div id = 'logowrapper'><div id = 'logohandler'><img src = 'images/pricon_logo.png' height = '65' width = '340'></div></div>
		<div id = 'webwrapper'>
			<div id = 'bluewrapper'><img src = 'images/pic_bg.png' height = '400' width = '383'>
				<div id = 'inwrapper' align = 'center'></div>
				<div id = 'picwrapper' align = 'center'><img id = 'otksimg'></div>
				<div id = 'infowrapper' class="">
					<table>
						<tr>
							<td id = 'txtLastName' style='font-size: 2.4em;'></td>
						</tr>
						<tr>
							<td id = 'txtFMName' style='font-size: 1.9em;'></td>
						</tr>
					</table>
				</div>
				<div id = 'earlyknockoffwrapper'></div>
				<div id = 'duplicateloggedwrapper'></div>
				<div id = 'modewrapper' align = 'center'>
					<table>
						<tr>
							<td id = 'txtmode'></td>
						</tr>
					</table>
				</div>
			</div>
			<div id = 'datewrapper' align = 'center'>
				<table id = 'dttable'>
					<tr>
						<td align = 'center' id = 'dateticker' style = 'font-size: 45;'></td>
					</tr>
					<tr align = 'center'>
						<td align = 'center' id = 'timeticker' style = 'font-size: 45;'>00:00:00</td>
					</tr>
				</table>
			</div>
			<div id = 'sidewrapper1'>
				<div id = 'sidetopwrapper'>
					<table>
						<tr>
							<td>EMPLOYEE NUMBER:</td>
						</tr>
					</table>
				</div>
				<div id = 'floatwrapper'>
					<input type = 'text' id = 'floatEmp' readOnly = 'true'>
				</div>
				<table>
					<tr>
						<td><input type = 'text' id = 'txtEmpNo' autofocus maxlength = '4'></td>
					</tr>
				</table>
			</div>
			<div id = 'sidewrapper2'>
				<div id = 'sidetopwrapper'>
					<table>
						<tr>
							<td>SECTION:</td>
						</tr>
					</table>
				</div>
				<div id = 'sidetopwrapper2'>
					<table>
						<tr>
							<td>
								<div class="jtextfill" style="width:500px; height:40px;">
									<span class="txtSection" id = 'txtSection'></span>
								</div>
							</td>
						</tr>
					</table>
				</div>
			</div>
			<div id = 'sidewrapper3'>
				<div id = 'sidetopwrapper'>
					<table>
						<tr>
							<td>POSITION:</td>
						</tr>
					</table>
				</div>
				<table>
					<tr>
						<td id = 'txtPosition'></td>
					</tr>
				</table>
			</div>
			<div id = 'sidewrapper4'>
				<div id = 'sidetopwrapper'>
					<table>
						<tr>
							<td>MESSAGE:</td>
						</tr>
					</table>
				</div>
				<table>
					<tr>
						<td>
							<div class="jtextfill" style="width:500px; height:80px;">
								<span class="txtMessage" id = 'txtMessage'></span>
							</div>
						</td>
					</tr>
				</table>
			</div>
			<div id = "transactiontablewrapper">
				<table cellspacing = '0' cellpadding = '0'>
					<tr>
						<th colspan = '6'>Transaction History</th>
					</tr>
					<tr align = 'center'>
						<th>Date In</th>
						<th>Time In</th>
						<th>Remarks</th>
						<th>Date Out</th>
						<th>Time Out</th>
						<th>Remarks</th>
					</tr>
				</table>
				<div id = 'tableinformation'>
					<table cellspacing = '0' cellpadding = '0' id = 'tablerecent'>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</body>
</html>