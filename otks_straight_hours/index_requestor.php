<?php
session_start();
/* 0 = requestor, 1 = approver */
$_SESSION['user_type'] = '0';

/* libraries */
require_once('./libraries/includes.php');
/* page header */
require_once('./pages/header.php');
/* check if get page is undefined or empty */
if( (!isset($_GET['page'])) || ($_GET['page'] == '') ){
	/* set page to main.php */
	$page = 'main.php';
}else{
	/* set page using get page value */
	$page = $_GET['page'];
}
/* selected page */
require_once('./pages/'.$page);
/* page footer */
require_once('./pages/footer.php');
// $_SESSION['user_type'] = 'requestor';