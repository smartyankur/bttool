<?php

$project = $_POST['project'];
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
//echo $project;

$currentdate= date("Y-m-d");

//echo "date=".date("Y-m-d");

include('config.php');

$query = "select finding,targetdate,status from actionitem where status='open' and targetdate<'$currentdate' and projectname= '$project';";
//echo $query;

$retval = mysql_query( $query, $con );
$count = mysql_num_rows($retval);
//echo "Count of elements:".$count;

if($count==0)
{
  die('Data Not Found');
}


while($row = mysql_fetch_array($retval))
  {
   echo "<b>"."Action Items"."|"."Target Date Of Closure"."|"."Status"."</b>";
   echo "</br>";
   echo "</br>";
   echo "<TABLE border=1>";
   echo "<TR>";
   echo "<TD>".$row['finding']."</TD>";
   echo "<TD>".$row['targetdate']."</TD>";
   echo "<TD>".$row['status']."</TD>";
   echo "</TR>";
   echo "</TABLE>";
  }
mysql_close($con);

?>