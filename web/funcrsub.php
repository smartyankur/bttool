<body background="bg.gif">
<?php
    $con = mysql_connect("localhost","root","password");
    
    if (!$con)
      {
        die('Could not connect: ' . mysql_error());
      }

	mysql_select_db("audit") or die(mysql_error());

    $query = "select DISTINCT reviewer from blobt";
	//echo $query;
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Data Not Found Please contact SEPG');
		}

    echo "<br>";
	echo "<br>";
	echo "<br>";
	echo "<table width='50%' border='1' cellspacing='0' cellpadding='0'>";
	?>
    <tr><th>Reviewer</th><th>Count</th><th>Sub Cat</th></tr>
	<?php
    while($row = mysql_fetch_assoc($retval)) 
    { 
      $reviewer=$row['reviewer'];
	  $quer="select count(*),subcat from blobt where reviewer='$reviewer' group by subcat";
      $ret = mysql_query( $quer, $con );
	  
	  while($rowt = mysql_fetch_assoc($ret)) 
       {      
	    echo "<tr>";
        echo "<td>".$reviewer."</td>";
        echo "<td>".$rowt['count(*)']."</td>";
        echo "<td>".$rowt['subcat']."</td>";
        echo "</tr>";
       }
    }
	echo "</table>";
?>
</body>