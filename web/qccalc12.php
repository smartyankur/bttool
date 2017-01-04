<head>
<style type="text/css">
body{
  background:url('qcr.jpg') no-repeat;
}

.button{
  background-color: #F7941C;
  border-bottom:#F7941C;
  border-left: #F7941C;
  border-right:#F7941C;
  border-top: #F7941C;
  color: black;
  font-family: Tahoma
  box-shadow:2px 2px 0 0 #014D06,;
  border-radius: 10px;
  border: 1px outset #b37d00 ;
}

.table_text{
	font-family: Calibri;
	font-size: 12px;
	font-style: normal;
	line-height: normal;
	font-weight: normal;
	font-variant: normal;
	color: #000000;
	text-indent: 10px;
	vertical-align: middle;
}
</style>
</head>
<body>
<form>
<?php
  session_start();
  set_time_limit(0);
  if(!(isset($_SESSION['login']) && $_SESSION['login'] != '')){
    $_SESSION['login'] = "";
    header ("Location:index.php");
  }else{     
    $user = $_SESSION['login'];
    	 
    include("config.php");
    
    $query = "select username, role from login where uniqueid='$user';";
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
    	
    if($count==0){
      die('Please Contact SEPG; May be You Are Not Registered');
    }
       
    while($row = mysql_fetch_assoc($retval)){
      echo "<br>";
      echo "<br>";
      echo "<h3>"."Hi ".$row['username']." ! Welcome To Audit Tracking Tool"."<h3>";
      $role= $row['role'];
    }
  }

  $query  = "SELECT qc.*, COUNT(*), prom.fmone,prom.fmtwo,prom.fmthree,prom.fmfour,prom.projectmanager FROM qcuploadinfo AS qc INNER JOIN projectmaster AS prom ON qc.project_id = prom.pindatabaseid WHERE qc.bcat<> 'suggesstion' AND (qc.bugstatus='closed' or qc.bugstatus='open' or qc.bugstatus='reopened' or qc.bugstatus='fixed') group by qc.project ASC";
  $retval = mysql_query( $query, $con );
  $count  = mysql_num_rows($retval);
  
  if($count==0){
    die('Data Not Found Please contact SEPG');
  }
  
  echo "<h4><i>Function wise categorization has been done for closed issues only. Sumw of Ok As Is, Hold & Valid issues equals to Total. Here Valid issues include closed,open,reopened and fixed issues</i></h4>";
?>  
<table width="99%" border="0" cellspacing="0" cellpadding="0" bordercolor="orangered">
  <tr class="table_text">
    <td valign="top" align="left">
      <a href="qccalc12export.php">Export result</a><br /><br />
    </td>                      
  </tr>
</table>
<table width='50%' border='1' cellspacing='0' cellpadding='0'>
  <tr><th>Project</th><th>Project Mgr</th><th>Review Date</th><th>Audio</th><th>Editorial</th><th>Functionality</th><th>Media</th><th>Simulation</th><th>Suggesstions</th><th>Ok AS Is</th><th>Hold</th><th>Valid Issues</th><th>Total</th><th>ID</th><th>Media</th><th>Script</th><th>QC FM</th><th>QC</th><th>Asignee</th></tr>
	<?php
    while($row = mysql_fetch_assoc($retval)){ 
      $count=$row['COUNT(*)'];
      $proj=$row['project'];
      $proj_id=$row['project_id'];
      $fmone=$row['fmone'];
      $fmtwo=$row['fmtwo'];
      $fmthree=$row['fmthree'];
      $fmfour=$row['fmfour']; 
      $totpm=$row['projectmanager'];
	  $okcount = 0;
	  $okhold = 0;
	  $oksug = 0;
	  $totmed = 0;
	  $totau = 0;
	  $totfn = 0;
	  $toted = 0;
	  $totsim = 0; 
	  $totsug = 0; 
     
      
      $count_by_status ="select bugstatus, count(*) from qcuploadinfo where project_id='$proj_id' group by `bugstatus`";
      $ret = mysql_query( $count_by_status, $con );
      
      while($bug_row = mysql_fetch_assoc($ret))  { 
		if($bug_row['bugstatus'] == "ok as is")
			$okcount = $bug_row['count(*)'];
		else if($bug_row['bugstatus'] == "hold")
			$okhold = $bug_row['count(*)'];
		else if ($bug_row['bugstatus'] == "suggesstion")
			$oksug = $bug_row['count(*)'];
	  }
	  $tot = $okcount + $okhold + $oksug;
	  
	  
	  $count_by_cat="select bcat, count(*) from qcuploadinfo where project_id='$proj_id' AND bugstatus='closed' group by 'bcat'";
      $retcat=mysql_query( $count_by_cat, $con );  
      
      while($bug_row_cat = mysql_fetch_assoc($retcat))  { 
		if($bug_row_cat['bcat'] == "media")
			$totmed = $bug_row_cat['count(*)'];
		else if($bug_row_cat['bcat'] == "editorial")
			$toted = $bug_row_cat['count(*)'];
		else if ($bug_row_cat['bcat'] == "functionality")
			$totfn = $bug_row_cat['count(*)'];
		else if ($bug_row_cat['bcat'] == "audio")
			$totau = $bug_row_cat['count(*)'];
		else if ($bug_row_cat['bcat'] == "simulation")
			$totsim = $bug_row_cat['count(*)'];
		else if ($bug_row_cat['bcat'] == "suggesstion")
			$totsug = $bug_row_cat['count(*)'];
	  }
	  
	  /*$fmqr="select fmone,fmtwo,fmthree,fmfour,projectmanager from projectmaster where pindatabaseid='$proj'";
      $retfm=mysql_query( $fmqr, $con );  
      $rowfm = mysql_fetch_assoc($retfm);
      $fmone=$rowfm['fmone'];
      $fmtwo=$rowfm['fmtwo'];
      $fmthree=$rowfm['fmthree'];
      $fmfour=$rowfm['fmfour']; 
      $totpm=$rowfm['projectmanager'];
	  
	  $rdat="select uploaddate from qcuploadinfo where project='$proj'";
      $redat = mysql_query( $rdat, $con );
      $rodat = mysql_fetch_assoc($redat);
      $revdt =  $rodat['uploaddate'];
      $revdt=strtotime($revdt);
      $revdt = date( 'Y-m-d', $revdt );
	  
	  $countok="select count(*) from qcuploadinfo where project_id='$proj' AND bugstatus='ok as is'";
      $retok = mysql_query( $countok, $con );
      $rowok = mysql_fetch_assoc($retok); 
      $okcount = $rowok['count(*)'];
      
      $counthold="select count(*) from qcuploadinfo where project='$proj' AND bugstatus='hold'";
      $rethold = mysql_query( $counthold, $con );
      $rowhold = mysql_fetch_assoc($rethold); 
      $okhold = $rowhold['count(*)'];
      
      $countsug="select count(*) from qcuploadinfo where project='$proj' AND bugstatus='suggesstion'";
      $retsug = mysql_query( $countsug, $con );
      $rowsug = mysql_fetch_assoc($retsug); 
      $oksug = $rowsug['count(*)'];
      
      $counttot="select count(*) from qcuploadinfo where project='$proj'";
      $rettot=mysql_query( $counttot, $con );  
      $rowtot = mysql_fetch_assoc($rettot);
      $tot=$rowtot['count(*)'];
	  
      
      $countmed="select count(*) from qcuploadinfo where project='$proj' AND bcat='media' AND bugstatus='closed'";
      $retmed=mysql_query( $countmed, $con );  
      $rowmed = mysql_fetch_assoc($retmed);
      $totmed=$rowmed['count(*)'];
      
      $counted="select count(*) from qcuploadinfo where project='$proj' AND bcat='editorial' AND bugstatus='closed'";
      $reted=mysql_query( $counted, $con );  
      $rowed = mysql_fetch_assoc($reted);
      $toted=$rowed['count(*)'];
      
      $countfn="select count(*) from qcuploadinfo where project='$proj' AND bcat='functionality' AND bugstatus='closed'";
      $retfn=mysql_query( $countfn, $con );  
      $rowfn = mysql_fetch_assoc($retfn);
      $totfn=$rowfn['count(*)'];
      
      $countau="select count(*) from qcuploadinfo where project='$proj' AND bcat='audio' AND bugstatus='closed'";
      $retau=mysql_query( $countau, $con );  
      $rowau = mysql_fetch_assoc($retau);
      $totau=$rowau['count(*)'];
      
      $countsim="select count(*) from qcuploadinfo where project='$proj' AND bcat='simulation' AND bugstatus='closed'";
      $retsim=mysql_query( $countsim, $con );  
      $rowsim = mysql_fetch_assoc($retsim);
      $totsim=$rowsim['count(*)'];
      
      $countsug="select count(*) from qcuploadinfo where project='$proj' AND bcat='suggesstion' AND bugstatus='closed'";
      $retsug=mysql_query( $countsug, $con );  
      $rowsug = mysql_fetch_assoc($retsug);
      $totsug=$rowsug['count(*)'];
      
      
      
	  $qc="select qc,asignee from qcuploadinfo where project='$proj'";
      $retqc=mysql_query( $qc, $con );  
      $rowqc = mysql_fetch_assoc($retqc);
      $totqc=$rowqc['qc'];
      $assignee=$rowqc['asignee'];
      
      $pm="select projectmanager from projectmaster where projectname='$proj'";
      $retpm=mysql_query( $pm, $con );  
      $rowpm = mysql_fetch_assoc($retpm);
      $totpm=$rowpm['projectmanager'];
	  */
      
	  echo "<tr>";
      echo "<td>".$proj."</td>";
      echo "<td>".$totpm."</td>";
      echo "<td>".date('Y-m-d', strtotime($row['uploaddate']))."</td>";
      echo "<td>".$totau."</td>";
      echo "<td>".$toted."</td>";
      echo "<td>".$totfn."</td>";
      echo "<td>".$totmed."</td>";
      echo "<td>".$totsim."</td>"; 
      echo "<td>".$totsug."</td>";
      echo "<td>".$okcount."</td>";
      echo "<td>".$okhold."</td>";
      echo "<td>".$count."</td>";
      echo "<td>".$tot."</td>";
      echo "<td>".$fmone."</td>";
      echo "<td>".$fmtwo."</td>";
      echo "<td>".$fmthree."</td>";
      echo "<td>".$fmfour."</td>";
      echo "<td>".$row['qc']."</td>";
      echo "<td>".$row['asignee']."</td>"; 
	  echo "</tr>";
    }
?>
</table>
<br>
<input type="button" class="button" value="Log Out" onclick="location.href='logout.php';">
</form>
</body>
