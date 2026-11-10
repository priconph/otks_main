<html>
<title>Training System</title>
<head>
<!--Affix Scripts/CSS here-->
<?php
require_once('./includes.php');

?>
</head>
<body>
<!--Start of bootstrap navbar-->
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Training</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="index.php?page=home.php"><span class="glyphicon glyphicon-home"/> Home<span class="sr-only">(current)</span></a></li>
        <li><a href="index.php?page=records.php"><span class="glyphicon glyphicon-th-list"/> Records</a></li>
        <li><a href="#"><span class="glyphicon glyphicon-user"/> About</a></li>
      </ul>
	</div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
