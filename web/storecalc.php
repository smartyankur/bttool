<?php
    $con = mysql_connect("localhost","root","password");
    
    if (!$con)
      {
        die('Could not connect: ' . mysql_error());
      }

	mysql_select_db("audit") or die(mysql_error());

    $query = "select SUM(quantity),item from admintran where date between '2012-09-01' AND '2012-09-30' and action='Issue' group by item";
    //echo $query;
	$retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Data Not Found Please contact SEPG');
		}

    echo "<table width='50%' border='1' cellspacing='0' cellpadding='0'>";
	?>
    <tr><th>Consumption</th><th>Item</th></tr>
	<?php
    while($row = mysql_fetch_assoc($retval)) 
    { 
      $consumption=$row['SUM(quantity)'];
	  $item=$row['item'];
      echo "<tr>";
	  echo "<td>".$consumption."</td>";
      echo "<td>".$item."</td>";
      echo "</tr>";
    }
	echo "</table>";
?>