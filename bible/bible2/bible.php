<?php
include_once('config.php');
include_once('BibleDAO.php');

$books = BibleDAO::getBooks();
$defaultChapters = BibleDAO::getChapterNumbers(1);
$defaultVerses = BibleDAO::getVerseNumbers(1, 1);
$defaultVerseText = BibleDAO::getVerseText(1, 1, 1);
?>

<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/design.css">
	<div id="div_header"><p id="header">King James Bible</p>

	</div>
</head>

<body style="background-image:url('img/bible2.jpg')">


	<div id="select">
		<div id="book_div">
			<select name="books" id="books">
				<?php foreach($books as $id => $book): ?>
					<option value="<?= $id ?>"><?= $book ?></option>
				<?php endforeach ?>
			</select>

			<select name="chapters" id="chapters">
				<?php for($i = 1; $i <= $defaultChapters; $i++): ?>
					<option value="<?= $i ?>"><?= $i ?></option>
				<?php endfor ?>
			</select>

			<select name="verses" id="verses">
				<?php for($i = 1; $i <= $defaultVerses; $i++): ?>
					<option value="<?= $i ?>"><?= $i ?></option>
				<?php endfor ?>
			</select>
			<img src="img/search.png" style="margin-left: 20px" id="thumb"/>
		</div>
	</div>

	<div id="container">
		<div id="output_container">
			<div id="verse_text">
				<?= $defaultVerseText ?>
			</div>
		</div>
	</div>


	<div id="overlay"></div>	
	<div = id="overlay_div" style="background-image:url('img/bible2.jpg')">
		<div id="close_button">X</div>
		<input placeholder="Search..." type="text" id="key">
		<h4 align = "center"  id="result"><i></i></h4>
	</div>
	

<script type="text/javascript" src="js/jquery.1.10.2.js"></script>
<script type="text/javascript" src="js/ajax.js"></script>
<script type="text/javascript" src="js/myjquery.js"></script>
<script type="text/javascript" src="js/thumb.js"></script>

</body>
</html>