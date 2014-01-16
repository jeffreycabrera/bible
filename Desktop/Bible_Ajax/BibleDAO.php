<?php
	class BibleDAO {
		public static function getChapterNumbers($book_id){
			global $db;
			$query = "SELECT MAX(chapter_number) AS chapter_numbers FROM kjv_english WHERE book_id = {$book_id}";
			$result = $db->query($query);
			if($result) {
				$row = $result->fetch_assoc();
				return $row['chapter_numbers'];
			}else {
				return false;
			}
		}

		public static function getVerseNumbers($book_id, $chapter_id){
			global $db;
			$query = "SELECT MAX(verse_number) AS verse_numbers FROM kjv_english WHERE book_id = {$book_id} AND chapter_number = {$chapter_id}";
			$result = $db->query($query);

			if($result){
				$row = $result->fetch_assoc();
				return $row['verse_numbers'];
			}else {
				return false;
			}
		}

		public static function getVerseText($book_id, $chapter_id, $verse_id){
			global $db;
			$query ="SELECT * FROM kjv_english k JOIN books b ON(k.book_id = b.id) WHERE book_id = {$book_id} AND chapter_number = {$chapter_id} AND verse_number = {$verse_id}";
			$result = $db->query($query);
			if($result->num_rows > 0) {
				$books = array();
				while($row = $result->fetch_assoc()){
					$books[] = $row;
				}
				$result->free();
				return $books;
			}else {
				return false;
			}

		}

		public static function getBooks(){
			global $db;
			$query ="SELECT id, book_name FROM books ORDER BY id";
			$result = $db->query($query);
			if($result->num_rows > 0){
				$books = array();
				while($row = $result->fetch_assoc()){
					$books[$row['id']] = $row['book_name'];
				}
				$result->free();
				return $books;

			}else {
				return false;
			}
		}

		public static function search($search){
			global $db;
			$str = ' ';
			if($search == $str){
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

		public static function searchNumResults($search){
			global $db;
			$str = ' ';
			if($search == $str){
				return false;
			}else{
				$query = "SELECT * FROM kjv_english k JOIN books b ON(k.book_id = b.id) WHERE verse_text LIKE '%{$search}%' ";
				$result = $db->query($query);
				if($result) {
					$num = $result->num_rows;
					return $num;
				} else{
					return false;
				}
			}
		}

		public static function getForward($book_id, $chapter_id, $verse_id){
			global $db;
			$bid = $book_id;
			$cid = $chapter_id;
			$vid = $verse_id + 1;
			$query ="SELECT * FROM kjv_english k JOIN books b ON(k.book_id = b.id) WHERE book_id = {$bid} AND chapter_number = {$cid} AND verse_number = {$vid}";

			$result = $db->query($query);
			if($result->num_rows > 0) {
				$books = array();
				while($row = $result->fetch_assoc()){
					$books[] = $row;
				}
				$result->free();
				return $books;
			}else {
				$bid = $book_id;
				$cid = $chapter_id + 1;
				$vid = 1;
				$query ="SELECT * FROM kjv_english k JOIN books b ON(k.book_id = b.id) WHERE book_id = {$bid} AND chapter_number = {$cid} AND verse_number = {$vid}";

				$result = $db->query($query);
				if($result->num_rows > 0) {
					$books = array();
					while($row = $result->fetch_assoc()){
						$books[] = $row;
					}
					$result->free();
					return $books;
				}else{
					$bid = $book_id + 1;
					$cid = 1;
					$vid = 1;
					$query ="SELECT * FROM kjv_english k JOIN books b ON(k.book_id = b.id) WHERE book_id = {$bid} AND chapter_number = {$cid} AND verse_number = {$vid}";

					$result = $db->query($query);
					if($result->num_rows > 0) {
						$books = array();
						while($row = $result->fetch_assoc()){
							$books[] = $row;
						}
						$result->free();
						return $books;
					}else{
						$query ="SELECT * FROM kjv_english k JOIN books b ON(k.book_id = b.id) WHERE book_id = 1 AND chapter_number = 1 AND verse_number = 1";

						$result = $db->query($query);
						if($result->num_rows > 0) {
							$books = array();
							while($row = $result->fetch_assoc()){
								$books[] = $row;
							}
							$result->free();
							return $books;
						}
					}

				}				
			}

		}
		



	}

?>