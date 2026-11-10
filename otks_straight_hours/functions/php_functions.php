<?php
function check_time_difference($date_time_in,$date_time_out){
	if(strtotime($date_time_in) > strtotime($date_time_out)){
		return 'invalid - (Time in is greater than time out)';
	}
	$diff = strtotime($date_time_out) - strtotime($date_time_in);
	
	$hour = ($diff / 60) / 60;
	$hour = explode('.',$hour);
	$hour = $hour[0];
	
	$min  = ($diff / 60) % 60;
	
	$time_array = array();
	$time_array['hour'] = $hour;
	$time_array['min']  = $min;
	return $time_array;
}