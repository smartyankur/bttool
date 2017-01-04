<?php
$q=$_GET["q"];
$r=$_GET["r"];
$s=$_GET["s"];

//echo "reqid:".$q."    "."status: ".$r."    "."remark: ".$s;

$con = mysql_connect("localhost","root","password");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("audit", $con);
$s = mysql_real_escape_string($s);

$query = "UPDATE lmsblob SET status = '$r',qccomment='$s' WHERE id = '$q'";
//echo $query;
$result = mysql_query($query) or die( "An error has ocured: " .mysql_error (). ":" .mysql_errno ());
echo "Row updated with new bug status for id :"."<b>".$q."</b>";

mysql_close($con);

?> 