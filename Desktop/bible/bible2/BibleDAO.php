<?php
class BibleDAO {
	public static function getChapterNumbers($book_id) {
		global $db;
		$sql = "SELECT MAX(chapter_number) AS chapter_numbers
				FROM kjv_english
				WHERE book_id = {$book_id};";
		$result = $db->query($sql);
		if ($result) {
			$row = $result->fetch_assoc();
			return $row['chapter_numbers'];
		} else {
			return false;
		}
	}

	public static function getVerseNumbers($book_id, $chapter_id) {
		global $db;
		$sql = "SELECT MAX(verse_number) AS verse_numbers
				FROM kjv_english
				WHERE book_id = {$book_id}
					AND chapter_number = {$chapter_id};";
		$result = $db->query($sql);
		if ($result) {
			$row = $result->fetch_assoc();
			return $row['verse_numbers'];
		} else {
			return false;
		}
	}

	public static function getVerseText($book_id, $chapter_id, $verse_id) {
		global $db;
		$sql = "SELECT verse_text
				FROM kjv_english
				WHERE book_id = {$book_id}
					AND chapter_number = {$chapter_id}
					AND verse_number = {$verse_id};";
		$result = $db->query($sql);
		if ($result) {
			$row = $result->fetch_assoc();
			return $row['verse_text'];
		} else {
			return false;
		}
	}
	public static function search($search){
			global $db;
			if($search == ''){
				return false;
			}else{
				$query = "SELECT * FROM kjv_english k JOIN books b ON(k.book_id = b.id) WHERE verse_text LIKE '%{$search}%' ";
				$result = $db->query($query);
				if($result->num_rows > 0) {
					$books = array();
					while($row = $result->fetch_assoc()) {
						$books[] = $row;
					}
					$result->free();
					return $books;
				} else{
					return false;
				}
			}
		}

	public static function getBooks() {
		global $db;
		$sql = "SELECT bookList_id, book_name FROM books ORDER BY bookList_id";
		$result = $db->query($sql);
		if ($result->num_rows > 0) {
			$books = array();
			for ($i = 0; $i < $result->num_rows; $i++) {
				$row = $result->fetch_assoc();
				$books[$row['bookList_id']] = $row['book_name'];
			}
			$result->free();
			return $books;
		} else {
			return false;
		}
	}
}
