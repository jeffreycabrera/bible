<?php
include_once('config.php');
include_once('BibleDAO.php');

$book_id = (isset($_POST['book_id'])) ? $_POST['book_id']: false;
$chapter_id = (isset($_POST['chapter_id'])) ? $_POST['chapter_id'] : false;

$verses = BibleDAO::getVerseNumbers($book_id,$chapter_id); 

if($verses == false) {
	echo json_encode(
			array(
				'status' => 'failed',
				'message' => 'Unable to get verses'
			)
		);
}else {
	echo json_encode(
			array(
				'status' => 'success',
				'verses' => $verses
			)
		);
}
?>