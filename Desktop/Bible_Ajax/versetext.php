<?php
include_once('config.php');
include_once('BibleDAO.php');

$book_id = (isset($_POST['book_id'])) ? $_POST['book_id']: false;
$chapter_id = (isset($_POST['chapter_id'])) ? $_POST['chapter_id']: false;
$verse_id = (isset($_POST['verse_id'])) ? $_POST['verse_id']: false;

$books = BibleDAO::getVerseText($book_id, $chapter_id, $verse_id);
foreach ($books as $result){ 
$book_name = $result['book_name'];
$chapter_number = $result['chapter_number'];
$verse_number = $result['verse_number'];
$verse_text = $result['verse_text'];
}

if ($verse_text == false) {
	echo json_encode(
			array(
				'status' => 'failed',
				'message' => 'Unable to get verse'
			)
		);
} else {
	echo json_encode(
			array(
				'status' => 'success',
				'book_name' => $book_name,
				'chapter_number' => $chapter_number,
				'verse_number' => $verse_number,
				'verse_text' => $verse_text
			)
		);
}