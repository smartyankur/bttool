<body background="bg.gif">
<?php
$desc=$_GET["prop"]; //description
$cost=$_GET["cost"]; //cost
$mop=$_GET["mop"]; //expense type
$MDate=$_GET["MDate"]; //date
$etype=$_GET["etype"]; //mop
$id=$_GET["id"];

$date=strtotime($MDate);
$date = date( 'Y-m-d', $date );

include('config.php');
//$q = mysql_real_escape_string($q);
//$r = mysql_real_escape_string($r);

$query = "update manual set descr='$desc',cost='$cost',date='$date',type='$etype',mop='$mop' where id='$id'";
//echo $query;
$result = mysql_query($query) or die( "An error has ocured: " .mysql_error (). ":" .mysql_errno ());
mysql_close($con);
echo "Row update for  ".$id;
?>
</body> 