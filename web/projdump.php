<?php
    $practice=$_GET['q'];
    $con = mysql_connect("localhost","root","password");

    if (!$con)
      {
        die('Could not connect: ' . mysql_error());
      }

	mysql_select_db("audit") or die(mysql_error());
    $query = "select projectname from projectmaster where practice='$practice' ORDER BY projectname";
    
	$retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Data Not Found');
		}

    echo "<select name=\"project\" id=\"project\" onchange=\"getpm(this.value)\">"; 
    echo "<option size =30 selected>Select</option>";
    //echo "<option size =30>ALL</option>";
    echo "<option size =30>Other personal reasons</option>";
    echo "<option size =30>Other offical reasons</option>";
    echo "<option size =30>Other Nonproject activities</option>"; 
    	if(mysql_num_rows($retval)) 
    { 
    while($row = mysql_fetch_assoc($retval))
    {
	 if(strlen($row[projectname])<>0)
		{		 
         echo "<option>$row[projectname]</option>"; 
        }
	} 
 
    } 
    else {
    echo "<option>No Names Present</option>";  
    }
?> 