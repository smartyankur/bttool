<?php
$q=$_GET["q"];
$pro_id=$_GET["pro_id"];
$r=$_GET["r"];
$user=$_GET["t"];
$currentdate= date("Y-m-d");

$ddate = strtotime($q);
$ddateformat = date( 'Y-m-d', $ddate );
$s = mysql_real_escape_string($_GET["s"]);


include("config.php");

$query = "select actionid from actionitem where project_id='$pro_id' and discussiondate='$ddateformat'";
$retval = mysql_query( $query, $con);
$count = mysql_num_rows($retval);

if($count==0)
{
  die('No Action Items Found On The Specified Date');
}
else
{
 
 $cquery="select auditeecomment from actionitem where project_id='$pro_id' and discussiondate='$ddateformat'";
 $cresult = mysql_query($cquery) or die( "An error has ocured: " .mysql_error (). ":" .mysql_errno ());
 while($crow = mysql_fetch_array($cresult))
  {
    if (strlen($crow['auditeecomment'])<>0)
     {
       die('Atleast One Response Already Exists in this Set. So Update Couldnot Be Done');
     }
  }
$query = "update actionitem set auditeecomment='$s',auditee='$user', auditeecomdate='$currentdate' WHERE project_id='$pro_id' and discussiondate='$ddateformat'";
$result = mysql_query($query) or die( "An error has ocured: " .mysql_error (). ":" .mysql_errno ());
echo "All the rows updated with the response for project :".$r;
}
mysql_close($con);

?> 