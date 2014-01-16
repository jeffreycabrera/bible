<?php
$year = (isset($_GET['year'])) ? $_GET['year']: false;
$month = (isset($_GET['month'])) ? $_GET['month']: false;
$day = 0;
if (in_array($month, array('jan','mar','may','jul','aug','oct','dec'))) {
	$day = 31;
} elseif (in_array($month, array('apr','jun','sept','nov'))) {
	$day = 30;
} elseif (($month == 'feb') && (($year % 4) == 0)) {
	$day = 29;
} elseif (($month == 'feb') && (($year % 4) != 0)) {
	$day = 28;
} else {
	$day = false;
}

if ($day !== false) {
	echo json_encode(
		array(
			'month' => $month,
			'result' => 'success',
			'day'	=> $day)
		);
} else {
	echo json_encode(
		array(
			'month' => $month,
			'result' => 'failed'));
}
