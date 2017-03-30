<?php	
  $con = mysql_connect("localhost", "root", "password");
  if(!$con){
    die('Could not connect: ' . mysql_error());
  }
  mysql_select_db("bttool17jan17") or die(mysql_error());  
?> 