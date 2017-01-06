<?php
    include('config.php');

    $query = "select dev1,dev2,dev3,dev4,dev5,dev6,dev7,dev8,projectname from projectmaster order by projectname ASC";
    
	$retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Data Not Found Please contact SEPG');
		}

    echo "<table width='50%' border='1' cellspacing='0' cellpadding='0'>";
	?>
    <tr><th>Project Name</th><th>Dev1</th><th>Dev2</th><th>Dev3</th><th>Dev4</th><th>Dev5</th><th>Dev6</th><th>Dev7</th><th>Dev2</th></tr>
	<?php
    while($row = mysql_fetch_assoc($retval)) 
    { 
      $projectname=$row['projectname'];
      $dev1=$row['dev1'];
	  $dev2=$row['dev2'];
	  $dev3=$row['dev3'];
	  $dev4=$row['dev4'];
	  $dev5=$row['dev5'];
	  $dev6=$row['dev6'];
	  $dev7=$row['dev7'];
	  $dev8=$row['dev8'];
        
      echo "<tr>";
	  echo "<td>".$projectname."</td>";
      echo "<td>".$dev1."</td>";
      echo "<td>".$dev2."</td>";
	  echo "<td>".$dev3."</td>";
	  echo "<td>".$dev4."</td>";
	  echo "<td>".$dev5."</td>";
	  echo "<td>".$dev6."</td>";
	  echo "<td>".$dev7."</td>";
	  echo "<td>".$dev8."</td>";
      echo "</tr>";
    }
	echo "</table>";
?>