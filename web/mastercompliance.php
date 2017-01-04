<?php	
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
     echo "<h3>"."Hi ".$row['username']." ! Welcome To NC Master Compliance Report"."<h3>";
	 $username=$row['username'];
    } 	
?>
<html>
<head>
</head>
<body background="bg.gif">
<h2>Master Compliance Report</h2>
<?php

function td($q)
{
 $sql="select count(actionid) from actionitem where projectname= '$q'";
 //echo $sql;
 $result = mysql_query($sql);
 $count= mysql_num_rows($result); 
 if($count==0)
 {
  $var="May be this project has never been audited.";
  return $var;
  exit();
 }
 $row = mysql_fetch_array($result); 
 $tild=$row['count(actionid)'];
 return $tild;
}

function last($q)
{
$query="select max(discussiondate) from actionitem where projectname= '$q'";
$result = mysql_query($query);

while($row = mysql_fetch_array($result))
  {
   if(strlen($row['max(discussiondate)'])<>0)
   {
    $str=$row['max(discussiondate)'];
   }
   else
   {
    $str="Contact SEPG";
	return $str;
   } 
  }
  return $str;
}
function pa($q)
{
$str="";
$query="select distinct processarea from actionitem where status='open' and projectname= '$q'";
$result = mysql_query($query);
$count= mysql_num_rows($result); 
 if($count==0)
 {
  $var="No Open Action Item Found ... GOOD";
  return $var;
  exit();
 }
while($row = mysql_fetch_array($result))
  {
   if(strlen($row['processarea'])<>0)
   {
    $str=$str."|".$row['processarea'];
   }
  }
return $str;
}

function actions($q)
{
$str="";
$query="select finding from actionitem where status='open' and projectname= '$q'";
$result = mysql_query($query);
while($row = mysql_fetch_array($result))
  {
   if(strlen($row['finding'])<>0)
   {
    $str=$str."|".$row['finding'];
   }
  }
return $str;
}

function open($q)
{
 $sql="select * from actionitem where status='open' and projectname= '$q';";
 $result = mysql_query($sql);
 $count= mysql_num_rows($result); 
 if($count==0)
 {
  $var="No Open AI Found ... GOOD";
  return $var;
  exit();
 }
  
 return $count;
}
function whomgr($q)
{
 $sql="select projectmanager from projectmaster where projectname= '$q';";
 $result = mysql_query($sql);
 $count= mysql_num_rows($result); 
 if($count==0)
 {
  $var="No Manager Found ... Strange";
  return $var;
  exit();
 }
  
 $row = mysql_fetch_array($result);
 $pmgr = $row['projectmanager'];
 return $pmgr;
}

function den($q)
{

$sql="select count(actionid) from actionitem where projectname= '$q';";
$result = mysql_query($sql);
$count= mysql_num_rows($result);

if($count==0)
{
  $var="No Action Items Found";
  return $var;
  exit();
}

$esql="select estimatedeffort from projectmaster where projectname= '$q';";
$eresult = mysql_query($esql);
$ecount = mysql_num_rows($eresult);

if($ecount==0)
{
  $var="No Estimated Effort Found";
  return $var;
  exit();
}

$erow = mysql_fetch_array($eresult);
$effort = $erow['estimatedeffort'];
$den = $count/$effort;
return $den;
}


function aging($q)
{
$currentdate= date("Y-m-d");
$sql="select * from actionitem where status='open' and targetdate<'$currentdate' and projectname= '$q';";

$result = mysql_query($sql);
$count = mysql_num_rows($result);
$var = 0;

if($count==0)
{
  $var="No Open Action Items";
  return $var;
  exit();
}

else
{
 while($row = mysql_fetch_array($result))
  {
   $diff = strtotime($currentdate) - strtotime($row['targetdate']);
   $diffdays = $diff/60/60/24;
   $var = $var + $diffdays; 
   //echo "NC Aging :".$diffdays."</br>";
  }
  $var = $var/$count;
  return $var;
}

}

echo "-------------------------------------------------------------------------------";
$query = "SELECT distinct projectname FROM actionitem";
$result = mysql_query($query);
while($row = mysql_fetch_array($result))
   {
    $proj=$row['projectname'];
	$density=den($proj);
    $age=aging($proj);
	$mgr=whomgr($proj);
	$open=open($proj);
	$findings=actions($proj);
	$pas=pa($proj);
	$ldate=last($proj);
	$tilldate=td($proj);
	echo "</br>";
	echo "Project Manager :".$mgr."</br>";
	echo "Project Name :".$proj."</br>";
	echo "Total Open NCs :".$open."</br>";
    echo "Project Level Avg NC Aging->Days :".$age."</br>";
    echo "Project Level NC Density (Open and Closed)->NCs per unit effort :".$density."</br>";
	echo "The process areas for focus :".$pas."</br>";
	echo "The project was last audited :".$ldate."</br>";
	echo "Total no of NCs found till date (from all audits) :".$tilldate."</br>";
	if (strlen($findings)<>0)
	{
    echo "<b>"."Following are the open items"."</b>"."</br>"; 
	?>
     <textarea name="findings" rows="4" cols="30" readonly="readonly"><?php echo $findings ?></textarea>   
	<?php
    }
	echo "<br>";
	echo "-------------------------------------------------------------------------------";
   }

mysql_close($con);

?>
<br>
<input type="button" value="Log Out" onclick="location.href='logout.php';">
</body>
</html>