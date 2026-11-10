<?php
// $ot = round_off_overtime('1','45');
// echo number_format((float)$ot, 2, '.', '');
$ot_diff['hour'] = 1;
$ot_diff['min'] = .45;
if($ot_diff['hour'] == 0 && $ot_diff['min'] == 0) {
	$ot = 0;
	$msg = 'The employee has no overtime rendered.';
} else if($filed_ot > (float)($ot_diff['hour'].'.'.$ot_diff['min'])) {
	$ot = round_off_overtime($ot_diff['hour'],$ot_diff['min']);
	$msg = 'The employee only have ' . $ot_diff['hour'] . ' hour(s) ' . $ot_diff['min'] . ' minute(s) rendered.';
} else {
	$ot = $filed_ot;
	$msg = 'Ok!';
}
echo $msg;
function round_off_overtime($hour, $mins) {
	if($mins < 30) {
		$mins = "0";
	} else {
		$mins = "5";
	}
	return $hour.".".$mins;
}


?>