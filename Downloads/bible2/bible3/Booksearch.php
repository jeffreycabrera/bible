<?php 
	/*
	* building connection to cobfig.php
	* creating new object
	*/
	include "config.php";
		$_search = $_POST['search'];
		
	/*
	* Array for Validation and configuration
	*/
	$config = array("_search" => $_search);
	/*
	* Declaring new object of Message class
	*/
	$book = new Book($config);
		$_search = $book->getsearch();
	
	$found = BookDAO::getSearch($_search);
		
 ?>