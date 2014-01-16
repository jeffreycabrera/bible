<html>
	<head>
		<title>Bible Application</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<script type="text/javascript" src="jquery.1.10.2.js"></script>
	<script type="text/javascript" src = "bible.js"></script>
	<script src = "jquery.min.js"></script>

	<?php
		include_once('config.php');
		include_once('BookDAO.php');

		$books = BookDAO::getBooks();
		$defaultChapters = BookDAO::getChapterNumbers(1);
		$defaultVerses = BookDAO::getVerseNumbers(1, 1);
		$defaultVerseText = BookDAO::getVerseText(1, 1, 1);
	?>
	</head>
	<body>

		<div class = "span well" id = "back" style = "background-image:url(back.jpg); background-size:1200px">

			<div class = "span well" id = "nav1">

				<div class = "span">
					<h3 id = "head"><font face ="Adobe Garamond Pro Bold" size = "6px" color = "white">Bible Application</font></h3>	
				</div>
				
			</div>

			<div class = "span well" id = "back2">

				<div class = "span well" id = "nav2">

					<div class = "span well" id = "nav2a">

						<h2 id = "head2"><center><font face = "Cooper Black" color = "white">Find Book's Chapter and Verse</center></font></h2>

						<center>

							<div class = "span" id = "book">
								<font face = "Cooper Black" size = "4.5em" id = "book1" color = "white">Book:</font>

								<select name="books" id="books">

									<?php foreach($books as $id => $book): ?>
										<option value="<?= $id ?>"><?= $book ?></option>
									<?php endforeach ?>

								</select>

							</div>

							<div class = "span">
								<font face = "Cooper Black" size = "4.5em" color = "white">Chapter:</font>

								<select name="chapters" id="chapters">

									<?php for($i = 1; $i <= $defaultChapters; $i++): ?>
										<option value="<?= $i ?>"><?= $i ?></option>
									<?php endfor ?>

								</select>

							</div>

							<div class = "span">
								<font face = "Cooper Black" size = "4.5em" color = "white">Verse:</font>

								<select name="verses" id="verses">

									<?php for($i = 1; $i <= $defaultVerses; $i++): ?>
										<option value="<?= $i ?>"><?= $i ?></option>
									<?php endfor ?>

								</select>

							</div>

						</center>

					</div>


					<textarea id = "verse_text" disabled>

						<?= $defaultVerseText ?>

					</textarea>

				</div>

				<div class = "span well" id = "nav3">

					<div class= "span well" id = "searchin">

						<h4 id = "searcher"><font face = "Serif" color = "white">Search</font></h4>

						<div class = "span" id = "search">

							<form class="form-search" method = "POST" name = "searching">

			    				<div class = "span" >
			                    	<input type="text" class="span3 search-query " name = "search" id = "insearch" placeholder = "Search word in the Bible..">
			                	</div>

	            			</form>

						</div>

					</div>

						<textarea id = "output" disabled></textarea>

				</div>
				
			</div>

		</div>

	</body>

</html>