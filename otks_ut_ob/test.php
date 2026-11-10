<?php
require_once('class/otks.php'); //OOP Path
    $array_fields = array('ip_address');
    $table 	   	= 'tbl_valid_ip';
    $joins 	   	= '';
    $sql_where 	= 'WHERE ip_address="'.$_SERVER['REMOTE_ADDR'].'" AND category ="kiosk"';
    $sql_order 	= '';
    $sql_limit 	= '';
    $result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
    $ctr = 0;
    if($result->num_rows == 0) {
        header('Location: http://systemone');
    }
	echo $result->num_rows;
?>