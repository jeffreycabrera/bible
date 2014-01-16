<?php
mysql_connect('localhost', 'root', '');
mysql_select_db('bible');
$count= 0;
$key = (isset($_GET['key'])) ? $_GET['key']: false;
$key = addslashes($key);
$sql = mysql_query("SELECT DISTINCT * FROM kjv_english c
 INNER JOIN books s ON c.book_id = s.bookList_id WHERE verse_text LIKE '%$key%'");

while($row = mysql_fetch_array($sql)) {
$count++;
$bookname = $row['book_name'];
$bookchapter = $row['chapter_number'];
$bookverse = $row['verse_number'];
$words = $row['verse_text'];

if($count <= 5){
?>
	<div class="show<?php echo $book_id; ?> font7" style = "margin-left:0px">
		<div class="table span2">
			<tr>
				<td><i class = "icon-book"></i>&nbsp;<a onclick="getAll()"><b><?php echo $bookname; ?></b></a></td>
				<td><a><?php echo $bookchapter; ?></a></td>
				<td>:</td>
				<td><a><?php echo $bookverse; ?></a></td>
	    		<td><?php echo "<p class = 'col'>".$words."</p>"; ?></td>
	    	</tr>
	    </div>
	</div>
<?php }}
	if($count==""){
		echo "<p class = 'Error'>No Word/s or Phrase/s Found!</p>";
	}else{
	
	?>
<?php } ?>
