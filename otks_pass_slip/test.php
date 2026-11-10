<?php
	$en_cancel = explode(',','L006');
	$en = 'L006';
	$status_search_cancel = array_search($en, $en_cancel);
	if($status_search_cancel != 0 ) {
		$status .= '3,';echo 'here cancel1'.$en.'<br>';
	} else {
		if(count($en_cancel) == 1) {
			if($en == $en_cancel[0]) {
				$status .= '3,';echo 'here cancel'.$en.'<br>';
			}
		}
	}
?>