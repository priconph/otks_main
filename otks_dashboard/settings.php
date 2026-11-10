<?php
require_once("./pages/header.php");

/* If page does not exist load home page */
if(!isset($_GET['page'])){
	$page = "manage_batch.php";
}else{
	$page = $_GET['page'];
}

require_once('./pages/'.$page);

require_once("./pages/footer.php");
?>