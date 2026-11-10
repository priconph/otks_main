<script>
	var chrome = /chrom(e|ium)/.test(navigator.userAgent.toLowerCase()); 
	
	if(!chrome){
		date_picker_for_firefox_ie();
	}

	function date_picker_for_firefox_ie(){
		/* Date Picker */
		$('input').each(function(){
			if( $(this).attr('type') == 'date' ){
				$(this).datepicker();
			}
			if( $(this).attr('type') == 'time' ){
				$(this).timepicker();
			}
		});
	}
</script>