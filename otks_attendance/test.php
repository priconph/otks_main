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
	echo '['.$result->num_rows.']';
    if($result->num_rows == 0) {
        // header('Location: http://systemone');
    }
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
?>