<?php
include_once('config.php');
include_once('BibleDAO.php');

$search = (isset($_POST['search'])) ? $_POST['search']: false;

$results = BibleDAO::search($search);
$resultsNum = BibleDAO::searchNumResults($search);

if($resultsNum == false) {
	echo "<h4><p style = 'color:red'>No Results Found</p></h4>";
}else {
	echo "<h4><p style = 'color:blue'>".$resultsNum." Results Found</p></h4></br>";
	foreach($results as $result){
		echo "<b><p style = 'color:green'>".$result['book_name']." ".$result['chapter_number'].":".$result['verse_number']."</p></b><br>";
		echo "<p>".$result['verse_text']."</p></br>";
	}
}
?>