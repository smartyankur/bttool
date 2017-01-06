<?php
    include("config.php");

    $query = "select DISTINCT billedto,project,purpose from cabbooking where purpose LIKE '%Late%'";
	echo $query;
    
	$retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Data Not Found Please contact SEPG');
		}

    echo "<table width='50%' border='1' cellspacing='0' cellpadding='0'>";
	?>
    <tr><th>Billed To</th><th>Project</th><th>Purpose</th></tr>
	<?php
    while($row = mysql_fetch_assoc($retval)) 
    { 
      $count=$row['billedto'];
	  $proj=$row['project'];
	  $pur=$row['purpose'];
      echo "<tr>";
	  echo "<td>".$count."</td>";
      echo "<td>".$proj."</td>";
      echo "<td>".$pur."</td>";
      echo "</tr>";
    }
	echo "</table>";
?>