<?php 
	/*
	* building connection to cobfig.php
	* creating new object
	*/
	include_once('Book.php');
	include_once('BookDAO.php');
	include_once('config.php');

	$search = $_POST['search'];
	/*
	* Array for Validation and configuration
	*/
	$config = array("_search" => $search);
	/*
	* Declaring new object of Message class
	*/
	$book = new Book($config);
	$search = $book->getsearch();
	
	BookDAO::getSearch($search);
	
 ?>