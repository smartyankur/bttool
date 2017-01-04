<?php
$q=$_GET["q"];
$pro_id=$_GET["pro_id"];

include("config.php");


$sql="SELECT projectmanager,fmone,fmtwo,fmthree,fmfour FROM projectmaster WHERE pindatabaseid = '".$pro_id."'";

$result = mysql_query($sql);
$count = mysql_num_rows($result);

if($count==0)
{
  die('Data Not Found');
}

while($row = mysql_fetch_array($result))
{
 $pm=$row['projectmanager']; 
 $fmone=$row['fmone'];
 $fmtwo=$row['fmtwo'];
 $fmthree=$row['fmthree'];
 $fmfour=$row['fmfour']; 
}
echo "PM :".$pm."| ID FM :".$fmone."|  Media FM :".$fmtwo."|  Scripting FM :".$fmthree."|  QC FM :".$fmfour;
mysql_close($con);
?> 