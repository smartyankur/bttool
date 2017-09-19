<?php
    include("config.php");
	$cat=$_GET['q'];
	$subcat = $_GET['subcat'];
    
    $query = "select subcat from catmaster where cat='$cat'";
    
	$retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Data Not Found');
		}

    echo "<select name=\"subcat\" id=\"subcat\">"; 
    echo "<option size=30>Select</option>";
    
	if(mysql_num_rows($retval)) 
    { 
		while($row = mysql_fetch_assoc($retval)) 
		{
			if(strlen($row[subcat])<>0)
			{?>		 
			 <option <?php echo $subcat == $row['subcat'] ? 'selected' : '' ?>><?php echo $row['subcat'] ?></option> 
			<?php } 
		} 
 
    } else {
		echo "<option>No Names Present</option>";  
    }
?> 