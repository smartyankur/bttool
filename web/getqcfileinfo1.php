<?php
error_reporting( E_ALL & ~E_DEPRECATED & ~E_NOTICE );
// turn on output buffering 
ob_start();
 
define('DB_DRIVER', 'mysql');
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASSWORD", "password");
define("DB_DATABASE", "audit");
 
 
// basic options for PDO 
$dboptions = array(
    PDO::ATTR_PERSISTENT => FALSE,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
);
 
//connect with the server
try {
    $DB = new PDO(DB_DRIVER . ':host=' . DB_HOST . ';dbname=' . DB_DATABASE, DB_USER, DB_PASSWORD, $dboptions);
} catch (Exception $ex) {
    echo($ex->getMessage());
    die;
}


// Very important to set the page number first.
if (!(isset($_GET['pagenum']))) { 
  $pagenum = 1; 
} else {
  $pagenum = intval($_GET['pagenum']); 		
}
 
//Number of results displayed per page 	by default its 10.
$page_limit =  ($_GET["show"] <> "" && is_numeric($_GET["show"]) ) ? intval($_GET["show"]) : 10;
 

 http://www.thesoftwareguy.in/ajax-pagination-with-php-and-mysql/#ixzz40Vaw8AZr



