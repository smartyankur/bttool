<?php	
  $con = mysql_connect("localhost", "root", "password");
  if(!$con){
    die('Could not connect: ' . mysql_error());
  }
  mysql_select_db("audit") or die(mysql_error());  
?> 