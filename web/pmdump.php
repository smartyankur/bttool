<?php
    error_reporting(0);
    $proj=$_GET['q'];
    include('config.php');
    //echo $proj;
	
	$query = "select projectmanager from projectmaster where projectname='$proj'";
	//echo $query;
	
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
             
              $query = "select DISTINCT username from login order by username";
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Users Not Found; Contact SEPG');
		}

    echo "<select name=\"pm\" id=\"pm\">"; 
    echo "<option size =30 selected>Select</option>";
    //echo "<option size =30>NA</option>";
	if(mysql_num_rows($retval)) 
    { 
    while($row = mysql_fetch_assoc($retval)) 
    { 
    echo "<option>$row[username]</option>"; 
    } 
    } 
    else 
	{
     echo "<option>No Names Present</option>";  
    }
              
			die();
		}

    if(mysql_num_rows($retval)) 
    { 
    while($row = mysql_fetch_assoc($retval)) 
    {
	 if(strlen($row[projectmanager])<>0)
		{
		 ?>
         <input type="text" name="pm" id="pm" value="<?php echo htmlentities($row[projectmanager],ENT_QUOTES,"UTF-8",false);?>" size="39">
         <?php
		}
	} 
 
    } 
    else {
    echo "No Names Present";  
    }
	
?> 