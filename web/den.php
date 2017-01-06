<?php
include('config.php');

function den($q)
{

$sql="select count(actionid) from actionitem where projectname= '$q';";
$result = mysql_query($sql);
$count= mysql_num_rows($result);

if($count==0)
{
  return false;
  exit();
}

$esql="select estimatedeffort from projectmaster where projectname= '$q';";
$eresult = mysql_query($esql);
$ecount = mysql_num_rows($eresult);

if($ecount==0)
{
  return false;
  exit();
}

$erow = mysql_fetch_array($eresult);
$effort = $erow['estimatedeffort'];
$den = $effort/$count;
return $den;
}

?> 