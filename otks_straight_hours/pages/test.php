<?php
require_once('../class/email.php');

$send_mail = new SENDMAIL;

$from 			= 'issinfoservice@pricon.ph';
$fromName 		= 'Mark Joseph M. Lopez';
$recipient		= 'ronfern@pricon.ph';
$CCrecipient	= 'marlope@pricon.ph';
$subject		= 'Test Email';
$message      	= 'Hello Budsko! hehe';

$send_mail->email_with_no_attachment($from,$fromName,$recipient,$CCrecipient,$subject,$message);