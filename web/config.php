<?php	
  $con = mysql_connect("localhost", "radar", "thelevonad");
	if(!$con){
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db("radar") or die(mysql_error());  
?> 