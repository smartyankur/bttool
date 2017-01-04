<head>
<script>
function submitresponse(str,ttr)
{
var statid='stat'+str;
var mid=ttr;
var ptr = document.getElementById(statid).value;

if(ptr=="select"){alert("Please select status");return false;}

if(ptr=="accepted")
{
  mywindow=window.open ("accept.php?id="+ str + "&stat="+ ptr + "&mid="+ mid,"Ratting","scrollbars=1,width=550,height=250,0,status=0,");
  if (window.focus) {mywindow.focus()}
}

if(ptr=="rejected")
{
  mywindow=window.open ("reject.php?id="+ str + "&stat="+ ptr + "&mid="+ mid,"Ratting","scrollbars=1,width=550,height=450,0,status=0,");
  if (window.focus) {mywindow.focus()}
}

if(ptr=="closed")
 {
   mywindow=window.open ("closetask.php?id="+ str + "&stat="+ ptr + "&mid="+ mid,"Ratting","scrollbars=1,width=550,height=450,0,status=0,");
   if (window.focus) {mywindow.focus()}
 }
}

function qcplan(str,ntr)
{
    mywindow=window.open ("qcplan.php?id="+ str + "&mid="+ ntr,"Ratting","scrollbars=1,width=220,height=200,0,status=0,");
	if (window.focus) {mywindow.focus()}
}

function band()
{
    //alert (str);
	mywindow=window.open ("graph.php","Ratting","scrollbars=1,width=550,height=450,0,status=0,");
	if (window.focus) {mywindow.focus()}
}

function commitment()
{
    //alert (str);
	mywindow=window.open ("commitment.php","Ratting","scrollbars=1,width=550,height=450,0,status=0,");
	if (window.focus) {mywindow.focus()}
}

function fplans()
{
	mywindow=window.open ("filterplans.php","Ratting","scrollbars=1,width=550,height=450,0,status=0,");
	if (window.focus) {mywindow.focus()}
}


function editplan(str,otr)
{
    mywindow=window.open ("editplans.php?id="+ str + "&mid="+ otr,"Ratting","scrollbars=1,width=600,height=250,0,status=0,");
	if (window.focus) {mywindow.focus()}
}


function distribute(str,rtr)
{
    mywindow=window.open ("makeplan.php?id="+ str + "&mid="+ rtr,"Ratting","scrollbars=1,width=550,height=500,0,status=0,");
	if (window.focus) {mywindow.focus()}	
}


function viewdist(str,otr)
{
	mywindow=window.open ("viewdist.php?id="+ str + "&mid="+ otr,"Ratting","scrollbars=1,width=620,height=500,0,status=0,");
	if (window.focus) {mywindow.focus()}	
}


</script>
<style type="text/css">
body
{
background:url('qcr.jpg') no-repeat;
}
.button
{
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
.table_text {
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
<body background="bg.gif">
<?php
    header("Refresh: 30;");
    session_start();
	
  if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
    header ("Location:index.php");
  }
  $user=$_SESSION['login'];    
	
  include("config.php");

  $query = "select username,dept from login where uniqueid='$user'";
    
	$retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
	{
			die('Data Not Found Please contact SEPG');
	}

    
    while($row = mysql_fetch_assoc($retval)) 
    { 
     echo "<br>";
     echo "<br>";
	 echo "<h3>"."Hi ".$row['username']." ! Welcome To Request View Interface"."</h3>";
	 $username=$row['username'];
	 $dept=$row['dept'];
	}
    
	if($dept!="LMS")
	{
     die("This Link is Only For LMS Dept.");
    }
	
    $query = "select * from qcreq order by indx desc";
	$retval = mysql_query($query, $con);
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Data Not Found Please contact SEPG');
		}

    echo "<br>";
	echo "<table>";
	?>
	<tr>
    <td><input type="button" class="button" value="Check Bandwidth" onclick="band()"></td>
    <td><input type="button" class="button" value="Filter All Requests by Del Date" onclick="commitment()"></td>
    <td><input type="button" class="button" value="Filter Plans" onclick="fplans()"></td>
    <td><input type="button" class="button" value="Log Out" onclick="location.href='logout.php';"></td>  
  </tr>
	<?php
	echo "</table>";
	echo "<table width='50%' border='1' cellspacing='0' cellpadding='0' bordercolor=\"orangered\">";
	?>
    <tr class="table_text"><th>Serial</th><th>ID</th><th>Project</th><th>Task</th><th>Type</th><th>Status</th><th>Planned Effort (Dev)</th><th>Delivery Date</th><th>Request For Round</th><th>Impact On FS</th><th>Received On</th><th>FS Path</th><th>Build Path</th><th>Who Sent</th><th>Select Status</th><th>Change Status</th><th>Check Plan</th><th>Edit Plan</th><th>Distribute</th><th>View Dist</th></tr>
	<?php
    while($row = mysql_fetch_assoc($retval)) 
    { 
	  echo "<tr>";
	  $mid=$row['id'];
      $effq="select project,task,effort,status,type from projecttask where id='$mid'";
      $retq = mysql_query( $effq, $con );
      $rowq = mysql_fetch_assoc($retq);
      echo "<td class=\"table_text\">".$row['indx']."</td>";
	  echo "<td class=\"table_text\">".$mid."</td>";
	  echo "<td class=\"table_text\">".$rowq['project']."</td>";
      echo "<td class=\"table_text\">"."<div style="."width:150;height:70;overflow:auto>".$rowq['task']."</div>"."</td>";
	  echo "<td class=\"table_text\">".$rowq['type']."</td>";
	  echo "<td class=\"table_text\">".$row['status']."</td>";
	  echo "<td class=\"table_text\">".$rowq['effort']."</td>";
	  echo "<td class=\"table_text\">".$row['DDate']."</td>";
      echo "<td class=\"table_text\">".$row['forround']."</td>";
      echo "<td class=\"table_text\">".$row['fsimpact']."</td>";
      echo "<td class=\"table_text\">".$row['ADate']."</td>";
	  echo "<td class=\"table_text\">".$row['path']."</td>";
      echo "<td class=\"table_text\">".$row['build']."</td>";
	  echo "<td class=\"table_text\">".$row['whosent']."</td>";
      ?>
	  <TD class="table_text"><select id="<?php echo "stat".$row['indx'];?>" size="1">
      <option value="select" selected>Select</option>
      <option value="accepted">Accepted</option>
      <option value="rejected">Rejected</option>
      <option value="closed">Closed</option>
	  </select></TD>
      <TD class="table_text"><input type="button" class="button" value="Update" onclick="submitresponse(<?php echo $row['indx'];?>,<?php echo $row['id'];?>)"></TD>
	  <TD class="table_text"><input type="button" class="button" value="View" onclick="qcplan(<?php echo $row['indx'];?>,<?php echo $row['id'];?>)"></TD>
	  <TD class="table_text"><input type="button" class="button" value="Edit" onclick="editplan(<?php echo $row['indx'];?>,<?php echo $row['id'];?>)"></TD>
	  <TD class="table_text"><input type="button" class="button" value="Distribute" onclick="distribute(<?php echo $row['indx'];?>,<?php echo $row['id'];?>)"></TD>
	  <TD class="table_text"><input type="button" class="button" value="View Dist" onclick="viewdist(<?php echo $row['indx'];?>,<?php echo $row['id'];?>)"></TD>
	  <?php
      echo "</tr>";
    }
	echo "</table>";
?>
<br>
<input type="button" value="Log Out" class="button" onclick="location.href='logout.php';">
</body>