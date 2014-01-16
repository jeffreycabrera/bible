
<?php
  include_once("config.php");
  include_once("BibleDAO.php");

  $books  = BibleDAO::getBooks();
  $defaultChapters = BibleDAO::getChapterNumbers(1);
  $defaultVerses = BibleDAO::getVerseNumbers(1,1);
  $defaultVerseText = BibleDAO::getVerseText(1,1,1);
?>
<html>
<head>
  <title>Kjv Bible</title>

  <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap responsive -->
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet">
    <!-- Font awesome - iconic font with IE7 support --> 
    <link href="css/font-awesome.css" rel="stylesheet">
    <link href="css/font-awesome-ie7.css" rel="stylesheet">
    <link href="css/boot-business.css" rel="stylesheet">
      <script src = "js/jquery.1.10.2.js"></script>
      <script src="js/bootstrap-transition.js"></script>
      <script src="js/bootstrap-modal.js"></script>
      <script type="text/javascript" src = "js/Bible.js"></script>
      <script src="js/search.js"></script>
</head>
<body class = "Img" style =" background:url('img/(12).jpg') no-repeat;">


  <!-- Start: HEADER -->
<header  style = "background:url('img/(18).jpg') no-repeat;">
  <div class ="container" >
          <div class="navbar">
            <a class="brand font-brand" href="Bible.php"> LVCC BIBLE</a>
            <div class = "pull-right"><!-- sample modal content -->
            <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 id="myModalLabel"><i class = "icon-search"></i>  Text Search</h3>
              </div>
              <div class="modal-body">
                  <form class="form-search">
                    <div class="input-append">
                      <input type="text" class="span5 search-query" style = "height: 30px" id="search">
                      <button type="reset" class="btn btn-success" style = "height: 30px" id = "searchButton">&times;</button>
                    </div>
                  <h3>Result</h3>
                      <div id="result">
                      </div>
                  </form>
              </div>
              <div class="modal-footer">
                <button class="btn" data-dismiss="modal">Close</button>
              </div>
            </div>
            <div class="bs-docs-example" style="padding-bottom: 24px;margin-top:20px">
              <a data-toggle="modal" href="#myModal" class="btn btn-primary btn-large"><i class = "icon-search"> Text Search</i></a>
            </div>
          </div> 
          </div>

  </div>
    </div>
</header>
    <!-- End: HEADER -->


<div class = "container aline" >

        <div class = "row">
          <center>
        <div class = "span4 Left">
          <h4 class ="Font">Books</h4>
          <select name = "books" id = "books">
            <?php foreach($books as $id => $book): ?>
              <option value = "<?= $id ?>"><?= $book ?></option>
            <?php endforeach ?>

          </select>
        </div>
        <div class = "span4 Left">
          <h4 class ="Font">Chapters</h4>
          <select name = "chapters" id = "chapters">
            <?php for($i = 1; $i <= $defaultChapters; $i++): ?>
              <option value = "<?= $i ?>"><?= $i ?></option>
            <?php endfor ?>
          </select>
        </div>
        <div class = "span4">
          <h4 class ="Font">Verses</h4>
          <select name = "verses" id = "verses">
            <?php for($i = 1; $i <= $defaultVerses; $i++): ?>
              <option value = "<?= $i ?>"><?= $i ?></option>
            <?php endfor ?>
          </select>
        </div>
      </div>

  <div class = "container margLeft">
    <div class = "row font-book" id = "bookCHpVrs" >
      <?php foreach($defaultVerseText as $value): ?>
      <p >&nbsp; &nbsp;<?php echo $value['book_name']."  ".$value['chapter_number'].":".$value['verse_number'];?><strong></strong> 
      </p><br><br>
    </div>
    <div class = "font-verse" id ="verse_text"><p><?= $value['verse_text']?></p>
    <?php endforeach ?>
    </div>
    
  </div>


</div>

  
</body>
</html>


