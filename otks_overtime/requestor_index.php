<?php
require_once("./pages/page_header.php");

/* If page does not exist load home page */
if(!isset($_GET['page'])){
	$page = "requestor_page.php";
}else{
	$page = $_GET['page'];
}

require_once('./pages/'.$page);

require_once("./pages/page_footer.php");
?>
