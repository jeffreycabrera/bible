<?php
$year = (isset($_GET['year'])) ? $_GET['year']: false;
$month = (isset($_GET['month'])) ? $_GET['month']: false;
$day = 0;
if (($year % 4) != 0) {
	if($month == 'feb'){
		$day = 28;
	}elseif(in_array($month, array('jan','mar','may','jul','aug','oct','dec'))){
		$day = 31;
	}elseif(in_array($month, array('apr','jun','sept','nov'))){
		$day = 30;
	}else{
	$day = 30;
	}
}elseif (($year % 4) == 0) {
	if($month == 'feb'){
		$day = 29;
	}elseif(in_array($month, array('jan','mar','may','jul','aug','oct','dec'))){
		$day = 31;
	}elseif(in_array($month, array('apr','jun','sept','nov'))){
		$day = 30;
	}else{
	$day = 30;
	}
} else {
		$day = false;
}

if ($day !== false) {
	echo json_encode(
		array(
			'year' => $year,
			'month' => $month,
			'result' => 'success',
			'day'	=> $day)
		);
} else {
	echo json_encode(
		array(
			'year' => $year,
			'month' => $month,
			'result' => 'failed'));
}
