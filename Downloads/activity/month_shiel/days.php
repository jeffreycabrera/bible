<?php

$month = (isset($_GET['month'])) ? $_GET['month']: false;
$year=(isset($_GET['year'])) ? $_GET['year']: false;

$days=0;
if(($year % 4) == 0){
	if(in_array($month,array('jan','mar','may','jul','aug','oct','dec'))){
		$days=31;
	}elseif(in_array($month,array('apr','jun','sep','nov'))){
		$days=30;
	}elseif($month == 'feb'){
		$days=29;
	}
}else{
	if(in_array($month,array('jan','mar','may','jul','aug','oct','dec'))){
		$days=31;
	}elseif(in_array($month,array('apr','jun','sep','nov'))){
		$days=30;
	}elseif($month == 'feb'){
		$days=28;
	}
}
if($days !== false){
	echo json_encode(
		array(
			'month' => $month,
			'days' => $days,
			'result' => 'success'
			)
		);
}else{
	echo json_encode(
		array(
			'month' => $month,
			'result' =>'failed'
			)
		);
}


?>