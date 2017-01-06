<?php
    error_reporting(0);
    include('config.php');
    //echo $proj;
	$proj=mysql_real_escape_string($_GET['q']);
	$query = "select head from depheads where dept='".$proj."'";
	//echo $query;
	
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Data Not Found');
		}

    if(mysql_num_rows($retval)) 
    { 
    while($row = mysql_fetch_assoc($retval)) 
    {
	 if(strlen($row[head])<>0)
		{
		 ?>
         <input type="text" name="pm" id="pm" readonly="readonly" value="<?php echo $row[head];?>" size="20">
         <?php
		}
	} 
 
    } 
    else {
    echo "No Names Present";  
    }
	
?> 