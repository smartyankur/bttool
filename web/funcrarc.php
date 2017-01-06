<body background="bg.gif">
<?php
    include('config.php');

    $query = "select DISTINCT project from blobcopy order by project ASC";
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
    <tr><th>Project</th><th>Count</th><th>Reviewee</th><th>Reviewer</th><th>Editorial</th><th>Media</th><th>Functional</th><th>Audio</th><th>Simulation</th><th>Others</th></tr>
<?php
    
	while($row = mysql_fetch_assoc($retval)) 
    { 
      $project=$row['project'];
	        
	  $reviewee="select count(*),reviewee,reviewer from blobcopy where project='$project' group by reviewee";
      $retree = mysql_query( $reviewee, $con );
      
	  while($rowree = mysql_fetch_assoc($retree))
	  {
	  $reviewee = $rowree['reviewee'];
	  $count = $rowree['count(*)'];
	  $reviewer = $rowree['reviewer'];
      
      $edcat="select count(*) from blobcopy where project='$project' AND reviewee='$reviewee' AND cat='editorial'";
	  $reted = mysql_query( $edcat, $con );
      $rowed = mysql_fetch_assoc($reted); 
	  $toted = $rowed['count(*)'];	   

      $medcat="select count(*) from blobcopy where project='$project' AND reviewee='$reviewee' AND cat='media'";
      $retmed = mysql_query( $medcat, $con );
      $rowmed = mysql_fetch_assoc($retmed); 
	  $totmed = $rowmed['count(*)'];

      $funcat="select count(*) from blobcopy where project='$project' AND reviewee='$reviewee' AND cat='functional'";
      $retfun = mysql_query( $funcat, $con );
      $rowfun = mysql_fetch_assoc($retfun); 
	  $totfun = $rowfun['count(*)'];
	  
      $funaud="select count(*) from blobcopy where project='$project' AND reviewee='$reviewee' AND cat='audio'";
      $retaud = mysql_query( $funaud, $con );
      $rowaud = mysql_fetch_assoc($retaud); 
	  $totaud = $rowaud['count(*)']; 

      $funsim="select count(*) from blobcopy where project='$project' AND reviewee='$reviewee' AND cat='simulation'";
      $retsim = mysql_query( $funsim, $con );
      $rowsim = mysql_fetch_assoc($retsim); 
	  $totsim = $rowsim['count(*)'];

	  $funot="select count(*) from blobcopy where project='$project' AND reviewee='$reviewee' AND cat='other'";
      $retot = mysql_query( $funot, $con );
      $rowot = mysql_fetch_assoc($retot); 
	  $totot = $rowot['count(*)'];

	  echo "<tr>";
      echo "<td>".$project."</td>";
      echo "<td>".$count."</td>";
      echo "<td>".$reviewee."</td>";
      echo "<td>".$reviewer."</td>";
      echo "<td>".$toted."</td>";
	  echo "<td>".$totmed."</td>";
      echo "<td>".$totfun."</td>";
      echo "<td>".$totaud."</td>";
      echo "<td>".$totsim."</td>";
	  echo "<td>".$totot."</td>";
	  echo "</tr>";
      }
	}
	echo "</table>";
?>
</body>