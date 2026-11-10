<?php
require_once('./libraries/includes.php');

$file_full_path = realpath(dirname(__FILE__)) . '/' . basename(__FILE__, '.php') . '.php'; 
$file_full_path = substr( str_replace('/var/www','',$file_full_path) , 1);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Notification Mailer</title>
      
    <script src="../../../common_functions/common_functions.js"></script>	
    <script>
        var tardiness_mailer_handler = './handler/mailer_handler.php';
        var main_mailer_handler = '../../../mailer_dashboard/handler/handler.php';
        var username = 'otks_tardiness'
        
        /* CHANGE THE INTERVAL THAT YOU WISH TO REFRESH THE PAGE (measured in milliseconds) */
        sendMail(); 
        window.onload = function(){
            setInterval( function(){ 
                sendMail(); 
//            }, 10000); }
            }, 60000); }
        
        function sendMail(){
            var data = {
                "action" 		: "load_tardiness_notif", // CALL THE FUNCTION THAT WILL SEND NOTIFICATION
				"mailer_link" 	: "<?php echo $file_full_path; ?>",
                "username" 		: username
            } 
            call_ajax(data, tardiness_mailer_handler, function(result){
                /* DO NOT CHANGE */
                /* Add a transaction on db_mailer_dashboard.tbl_daily_email_status to monitor the email sent */
                // if(result['status'] != 'N/A') {
                    // save_mailer_transaction(result['status'] , result['remarks'] , result['date_today']);
                // } else{
                    // return_reminder_info( result['date_today'] );
					// console.log('N/A');
                // }
                return_reminder_info( result['date_today'] );
            });
        }
        function save_mailer_transaction(status, remarks, date_today) {
            var data = {
                "action" 		: "add_daily_transactions",
                "mailer_link" 	: "<?php echo $file_full_path; ?>",
                "status" 		: status,
                "remarks" 		: remarks,
                "username" 		: username
            } 
            call_ajax(data, main_mailer_handler, function(result){ 		
				console.log('script'+result['script']);
                draw_reminder_design( date_today, result['fk_mailer'], result['system_name'], result['icon'] );
            });
        }
        function draw_reminder_design(date_today, fk_mailer, system_name, icon) {
            var data = {
                "action" 		: "draw_reminder_design",
                "date_today" 	: date_today,
                "fk_mailer" 	: fk_mailer,
                "icon" 	        : icon,
                "system_name" 	: system_name
            } 
            call_ajax(data, tardiness_mailer_handler, function(result){		
                $('#div_container').html( result['html'] );
                console.log(result['html']);
            });
        }
        function return_reminder_info(date_today) {
            var data = {
                "action" 		: "return_reminder_info",
                "mailer_link" 	: "<?php echo $file_full_path; ?>"
            } 
            call_ajax(data, tardiness_mailer_handler, function(result){		
                draw_reminder_design( date_today, result['fk_mailer'], result['system_name'], result['icon'] );
            });
        }
     </script>

 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	
  </head>
  
<body>
<div id="div_container"></div>
</body>
</html>