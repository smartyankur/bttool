<head>
<script>
function edit(str,ttr,utr)
{
	mywindow=window.open ("editdist.php?id="+ str + "&mid="+ ttr + "&srn="+ utr,"Ratting","scrollbars=1,width=620,height=500,0,status=0,");
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
    error_reporting(0);
	session_start();
	
	if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	header ("Location:index.php");
    }
	
	$con = mysql_connect("localhost","root","password");
    $user=$_SESSION['login'];

    if (!$con)
    {
        die('Could not connect: ' . mysql_error());
    }

	mysql_select_db("audit") or die(mysql_error());

    $query = "select username from login where uniqueid='$user'";
    
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
	 echo "<h3>"."Hi ".$row['username']." ! Welcome To Distribution View"."</h3>";
	 $username=$row['username'];
    }
	
	$id = $_REQUEST['id'];
    $mid = $_REQUEST['mid'];

	$query = "select * from qcplan where masterid='$mid' and indx='$id'";
	$retval = mysql_query($query, $con);
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Data Not Found');
		}

    echo "<br>";
	echo "<table width='50%' border='1' cellspacing='0' cellpadding='0' bordercolor=\"orangered\">";
	?>
    <tr class="table_text"><th>ID</th><th>Serial</th><th>Project</th><th>Task</th><th>QC</th><th>Start Date</th><th>End Date</th><th>Effort</th><th>Status</th><th>Edit</th></tr>
	<?php
    while($row = mysql_fetch_assoc($retval)) 
    { 
	  echo "<tr>";
	  echo "<td class=\"table_text\">".$row['masterid']."</td>";
      echo "<td class=\"table_text\">".$row['indx']."</td>";
	  echo "<td class=\"table_text\">".$row['project']."</td>";
      echo "<td class=\"table_text\">"."<div style="."width:150;height:70;overflow:auto>".$row['task']."</div>"."</td>";
	  echo "<td class=\"table_text\">".$row['qc']."</td>";
	  echo "<td class=\"table_text\">".$row['SDate']."</td>";
	  echo "<td class=\"table_text\">".$row['EDate']."</td>";
      echo "<td class=\"table_text\">".$row['effort']."</td>";
      echo "<td class=\"table_text\">".$row['status']."</td>";
     ?>
      <TD class="table_text"><input type="button" class="button" value="Edit" onclick="edit(<?php echo $row['id'];?>,<?php echo $row['masterid'];?>,<?php echo $row['indx'];?>)"></TD>
     <?php
      echo "</tr>";
    }
	echo "</table>";
?>
</body>