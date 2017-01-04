<body background="bg.gif">
<?php
    $con = mysql_connect("localhost","root","password");
    
    if (!$con)
      {
        die('Could not connect: ' . mysql_error());
      }

	mysql_select_db("audit") or die(mysql_error());

    $query = "select COUNT(*),project from blobt group by project ASC";
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
    <tr><th>Project</th><th>Project Mgr</th><th>Total</th><th>Fixed</th><th>Open</th><th>Editorial</th><th>Media</th><th>Functional</th><th>Audio</th><th>Simulation</th><th>Other</th><th>Reviewer</th><th>Reviewee</th><th>ID</th><th>Media</th><th>Script</th><th>QC</th></tr>
	<?php
    while($row = mysql_fetch_assoc($retval)) 
    { 
      $count=$row['COUNT(*)'];
	  $project=$row['project'];
	 
	  
      $reviewer="select reviewer from blobt where project='$project'";
      $retrev = mysql_query( $reviewer, $con );
      $rowrev = mysql_fetch_assoc($retrev);
	  $reviewer = $rowrev['reviewer'];
	  
	  $reviewee="select reviewee from blobt where project='$project'";
      $retree = mysql_query( $reviewee, $con );
      $rowree = mysql_fetch_assoc($retree);
	  $reviewee = $rowree['reviewee'];

	  $edcat="select count(*) from blobt where project='$project' AND cat='editorial'";
	  $reted = mysql_query( $edcat, $con );
      $rowed = mysql_fetch_assoc($reted); 
	  $toted = $rowed['count(*)'];
	  	  	  
      $medcat="select count(*) from blobt where project='$project' AND cat='media'";
      $retmed = mysql_query( $medcat, $con );
      $rowmed = mysql_fetch_assoc($retmed); 
	  $totmed = $rowmed['count(*)'];

      $funcat="select count(*) from blobt where project='$project' AND cat='functional'";
      $retfun = mysql_query( $funcat, $con );
      $rowfun = mysql_fetch_assoc($retfun); 
	  $totfun = $rowfun['count(*)'];

      $funaud="select count(*) from blobt where project='$project' AND cat='audio'";
      $retaud = mysql_query( $funaud, $con );
      $rowaud = mysql_fetch_assoc($retaud); 
	  $totaud = $rowaud['count(*)'];

      $funsim="select count(*) from blobt where project='$project' AND cat='simulation'";
      $retsim = mysql_query( $funsim, $con );
      $rowsim = mysql_fetch_assoc($retsim); 
	  $totsim = $rowsim['count(*)'];

	  $funot="select count(*) from blobt where project='$project' AND cat='other'";
      $retot = mysql_query( $funot, $con );
      $rowot = mysql_fetch_assoc($retot); 
	  $totot = $rowot['count(*)'];

	  $fmqr="select fmone,fmtwo,fmthree,fmfour from projectmaster where projectname='$project'";
	  $retfm=mysql_query( $fmqr, $con );  
      $rowfm = mysql_fetch_assoc($retfm);
	  $fmone=$rowfm['fmone'];
      $fmtwo=$rowfm['fmtwo'];
	  $fmthree=$rowfm['fmthree'];
	  $fmfour=$rowfm['fmfour'];
	  
      $pm="select projectmanager from projectmaster where projectname='$project'";
      $retpm=mysql_query( $pm, $con );  
      $rowpm = mysql_fetch_assoc($retpm);
	  $totpm=$rowpm['projectmanager'];

      echo "<tr>";
      echo "<td>".$project."</td>";
      echo "<td>".$totpm."</td>";
      echo "<td>".$count."</td>";
	  echo "<td>".$toted."</td>";
      echo "<td>".$totmed."</td>";
	  echo "<td>".$totfun."</td>";
      echo "<td>".$totaud."</td>";
      echo "<td>".$totsim."</td>";
      echo "<td>".$totot."</td>";
      echo "<td>".$reviewer."</td>";
	  echo "<td>".$reviewee."</td>";
	  echo "<td>".$fmone."</td>";
      echo "<td>".$fmtwo."</td>";
	  echo "<td>".$fmthree."</td>";
      echo "<td>".$fmfour."</td>";
      echo "</tr>";
    }
	echo "</table>";
?>
</body>