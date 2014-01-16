<?php
include_once('config.php');
include_once('BibleDAO.php');

$books = BibleDAO::getBooks();
$defaultChapters = BibleDAO::getChapterNumbers(1);
$defaultVerses = BibleDAO::getVerseNumbers(1, 1);
$defaultVerseText = BibleDAO::getVerseText(1, 1, 1);
?>

Books:
<select name="books" id="books">
	<?php foreach($books as $id => $book): ?>
		<option value="<?= $id ?>"><?= $book ?></option>
	<?php endforeach ?>
</select>

Chapters:
<select name="chapters" id="chapters">
	<?php for($i = 1; $i <= $defaultChapters; $i++): ?>
		<option value="<?= $i ?>"><?= $i ?></option>
	<?php endfor ?>
</select>

Verses:
<select name="verses" id="verses">
	<?php for($i = 1; $i <= $defaultVerses; $i++): ?>
		<option value="<?= $i ?>"><?= $i ?></option>
	<?php endfor ?>
</select>

<div id="verse_text">
	<?= $defaultVerseText ?>
</div>

<script type="text/javascript" src="jquery.1.10.2.js"></script>

<script type="text/javascript">
$(document).ready(function() {
	function getVerseText(bid, cid, vid) {
		$.ajax({
			url: 'versetext.php',
			data: {book_id: bid, chapter_id: cid, verse_id: vid},
			dataType: 'JSON',
			method: 'GET',
			success: function(response) {
				$('#verse_text').html(response.verse_text);
			}
		});
	}

	$('#books').on('change', function() {
		var bid = $(this).val();
		$.ajax({
			url: 'chapters.php',
			data: {book_id: bid},
			dataType: 'JSON',
			method: 'GET',
			success: function(response) {
				var str = '';
				for(i = 1; i <= response.chapters; i++) {
					str += '<option value=' + i + '>' + i + '</option>';
				}
				$('#chapters').html(str);
				getVerseText(bid, 1, 1);
			},
			error: function(err) {
				alert('NONO');
			}
		});
	});

	$('#chapters').on('change', function() {
		var bid = $('#books').val();
		var cid = $(this).val();
		$.ajax({
			url: 'verses.php',
			data: {book_id: bid, chapter_id: cid},
			dataType: 'JSON',
			method: 'GET',
			success: function(response) {
				var str = '';
				for(i = 1; i <= response.verses; i++) {
					str += '<option value=' + i + '>' + i + '</option>';
				}
				$('#verses').html(str);
				getVerseText(bid, cid, 1);
			},
			error: function(err) {
				alert('NONO');
			}
		});
	});

	$('#verses').on('change', function() {
		var bid = $('#books').val();
		var cid = $('#chapters').val();
		var vid = $(this).val();
		getVerseText(bid, cid, vid);
	});
});
</script>