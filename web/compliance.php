
<?php
error_reporting(0);	
include("config.php");

function td($q)
{
 $sql="select count(actionid) from actionitem where project_id = '$pro_id'";
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
$query="select max(discussiondate) from actionitem where project_id = '$pro_id'";
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
$query="select distinct processarea from actionitem where status='open' and project_id = '$pro_id'";
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
$query="select finding from actionitem where status='open' and project_id = '$pro_id'";
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
 $sql="select * from actionitem where status='open' and project_id = '$pro_id';";
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
 $sql="select projectmanager from projectmaster where pindatabaseid = '$pro_id';";
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

$sql="select count(actionid) from actionitem where project_id = '$pro_id';";
$result = mysql_query($sql);
$row= mysql_fetch_array($result);
$count=$row['count(actionid)'];

if($count==0)
{
  $den="No Action Items Found";
  return $den;
  exit();
}

$esql="select estimatedeffort from projectmaster where pindatabaseid = '$pro_id';";
$eresult = mysql_query($esql);

if($erow = mysql_fetch_array($eresult))
{
 $effort = $erow['estimatedeffort']; 
}
else
{
 $den="No estimated effort found in project master";
 return $den;
 exit();
}

$den = $count/$effort;
//$den="count :".$count."effort :".$effort;
return $den;
}


function aging($q)
{
$currentdate= date("Y-m-d");
$sql="select * from actionitem where status='open' and targetdate<'$currentdate' and project_id= '$pro_id';";

$result = mysql_query($sql);
$count = mysql_num_rows($result);
$var = 0;

if($count==0)
{
  $var="No Open Action Items Where Target Date is Less Than Current Date";
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
$q=$_GET["q"];
$pro_id=$_GET["pro_id"];
$proj=$q;
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
echo "Total no of action items found till date (from all audits) :".$tilldate."</br>";

if (strlen($findings)<>0)
{
  echo "<b>"."Following are the open items"."</b>"."</br>"; 
?>
  <textarea name="findings" rows="4" cols="30" readonly="readonly"><?php echo $findings ?></textarea>   
<?php
}
echo "<br>";
echo "-------------------------------------------------------------------------------";
mysql_close($con);
?>
