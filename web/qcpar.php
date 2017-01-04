<?php
    $con = mysql_connect("localhost","root","password");
    
    if (!$con)
      {
        die('Could not connect: ' . mysql_error());
      }

	mysql_select_db("audit") or die(mysql_error());

    $query = "select COUNT(*),bcat from qcuploadinfo group by bcat";
	echo $query;
    
	$retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Data Not Found Please contact SEPG');
		}

    echo "<table width='50%' border='1' cellspacing='0' cellpadding='0'>";
	?>
    <tr><th>COUNT</th><th>Cat</th></tr>
	<?php
    while($row = mysql_fetch_assoc($retval)) 
    { 
      $count=$row['COUNT(*)'];
	  $proj=$row['bcat'];
	  echo "<tr>";
	  echo "<td>".$count."</td>";
      echo "<td>".$proj."</td>";
      echo "</tr>";
    }
	echo "</table>";
?>