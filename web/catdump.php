<?php
    include("config.php");
	$cat=$_GET['q'];
    
    $query = "select subcat from catmaster where cat='$cat'";
    
	$retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Data Not Found');
		}

    echo "<select name=\"subcat\" id=\"subcat\">"; 
    echo "<option size =30 selected>Select</option>";
    
	if(mysql_num_rows($retval)) 
    { 
    while($row = mysql_fetch_assoc($retval)) 
    {
	 if(strlen($row[subcat])<>0)
		{		 
         echo "<option>$row[subcat]</option>"; 
        }
	} 
 
    } 
    else {
    echo "<option>No Names Present</option>";  
    }
?> 