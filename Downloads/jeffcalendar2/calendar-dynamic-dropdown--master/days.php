<?php

$year = (isset($_GET['year'])) ? $_GET['year']: false;
$month = (isset($_GET['month'])) ? $_GET['month']: false;
$day = 0;
$days = array('', 31, ($year % 4 == 0 ? 29 : 28), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

 for($i = 0; $i < $days[$month]; $i++)
  {
    
    $day += 1;

  }

echo json_encode(
    array(
      'year' => $year,
      'month' => $month,
      'result' => 'success',
      'day' => $day)
    );
  
?>
