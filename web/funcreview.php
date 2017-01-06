<body background="bg.gif">
<?php
    include('config.php');

    $query = "select DISTINCT project from blobt order by project ASC";
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
    <tr><th>Project</th><th>Count</th><th>Reviewee</th><th>Reviewer</th><th>Instructional Design</th><th>Media</th><th>Functionality</th></tr>
<?php
    
	while($row = mysql_fetch_assoc($retval)) 
    { 
      $project=$row['project'];
	        
	  $reviewee="select count(*),reviewee,reviewer from blobt where project='$project' group by reviewee";
      $retree = mysql_query( $reviewee, $con );
      
	  while($rowree = mysql_fetch_assoc($retree))
	  {
	  $reviewee = $rowree['reviewee'];
	  $count = $rowree['count(*)'];
	  $reviewer = $rowree['reviewer'];
      
      $edcat="select count(*) from blobt where project='$project' AND reviewee='$reviewee' AND cat='Instructional Design'";
	  $reted = mysql_query( $edcat, $con );
      $rowed = mysql_fetch_assoc($reted); 
	  $toted = $rowed['count(*)'];	   

      $medcat="select count(*) from blobt where project='$project' AND reviewee='$reviewee' AND cat='Media'";
      $retmed = mysql_query( $medcat, $con );
      $rowmed = mysql_fetch_assoc($retmed); 
	  $totmed = $rowmed['count(*)'];

      $funcat="select count(*) from blobt where project='$project' AND reviewee='$reviewee' AND cat='Functionality'";
      $retfun = mysql_query( $funcat, $con );
      $rowfun = mysql_fetch_assoc($retfun); 
	  $totfun = $rowfun['count(*)'];
	  
	  echo "<tr>";
      echo "<td>".$project."</td>";
      echo "<td>".$count."</td>";
      echo "<td>".$reviewee."</td>";
      echo "<td>".$reviewer."</td>";
      echo "<td>".$toted."</td>";
	  echo "<td>".$totmed."</td>";
      echo "<td>".$totfun."</td>";
	  echo "</tr>";
      }
	}
	echo "</table>";
?>
</body>