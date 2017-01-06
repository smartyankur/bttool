<?php
    include('config.php');

    $query = "select projectname,round(avg(DATEDIFF(sepgcomdate,targetdate))) from actionitem where discussiondate>'2012-01-01' group by projectname ";
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Data Not Found Please contact SEPG');
		}

    echo "<table width='50%' border='1' cellspacing='0' cellpadding='0'>";
	?>
    <tr><th>Project Name</th><th>Avg Diff</th><th>PM</th></tr>
	<?php
    while($row = mysql_fetch_assoc($retval)) 
    { 
      $projectname=$row['projectname'];

      $pquery="select projectmanager from projectmaster where projectname='$projectname'";
	  $pres=mysql_query( $pquery, $con );
      while($prec=mysql_fetch_assoc($pres))
		{
		 $pm=$prec['projectmanager'];  
        }  
	  $avgdiff=$row['round(avg(DATEDIFF(sepgcomdate,targetdate)))'];
	  echo "<tr>";
	  echo "<td>".$projectname."</td>";
      echo "<td>".$avgdiff."</td>";
      echo "<td>".$pm."</td>";
      echo "</tr>";
    }
	echo "</table>";
?>