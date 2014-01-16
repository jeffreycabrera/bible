<?php
include_once('config.php');
include_once('BibleDAO.php');

$book_id = (isset($_POST['book_id'])) ? $_POST['book_id']: false;

$chapters = BibleDAO::getChapterNumbers($book_id);
$verses = BibleDAO::getVerseNumbers($book_id, 1);
if ($chapters == false) {
	echo json_encode(
			array(
				'status' => 'failed',
				'message' => 'Unable to get chapters'
			)
		);
} else {
	echo json_encode(
			array(
				'status' => 'success',
				'chapters' => $chapters,
				'verses' => $verses
			)
		);
}