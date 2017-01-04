<?php
$project = $_POST['project'];
//echo "project :".$project;
//echo "<br>";
$process = $_POST['process'];
//echo "process :".$process;
//echo "<br>";
$nctype = $_POST['nctype'];
//echo "nctype :".$nctype;
//echo "<br>";
$ncowner = $_POST['ncowner'];
//echo "ncowner :".$ncowner;
//echo "<br>";
//$finding = mysql_real_escape_string($_REQUEST["finding"]);
$ddate = $_POST['DDate'];
$dtime = strtotime($ddate);
$dtimemyformat = date( 'Y-m-d', $dtime );
$tdate = $_POST['TDate'];
$ttime=strtotime($tdate);
$ttimemyformat = date( 'Y-m-d', $ttime );

//echo "<br>";
//echo "ncowner :".$ncowner;
$con = mysql_connect("localhost","root","password");
$finding = mysql_real_escape_string($_REQUEST["finding"]);
//echo "finding :".$finding;
echo "</br>";

if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
mysql_select_db("audit") or die(mysql_error());

//$query = "INSERT INTO blogs_table(blogger_name, comment, date) VALUES ('".$logged_in_user . "', '".$inputfromform  . "', " ." now() )";

$cquery="select * from preactionitem where finding='$finding' and projectname='$project' and nctype='$nctype'";
$cresult=mysql_query($cquery) or die (mysql_error());
$adminuser=trim($_REQUEST['adminuser']);

if($row = mysql_fetch_array($cresult))
{
 echo "This Entry Already Exists";
 
?>
 <br>
 <br>
 <input type="button" value="Enter Another Record" onclick="document.location = 'open.php?user=<?php echo $adminuser;?>';">
 
<?php
exit();
}

$query="INSERT INTO preactionitem(projectname,processarea,nctype,finding,discussiondate,targetdate,owner) values('".$project."','".$process."','".$nctype."','".$finding."','".$dtimemyformat."','".$ttimemyformat."','".$ncowner."')";

//echo $query;

mysql_query($query) or die (mysql_error());
echo "Row Inserted";
?>
<br>
<input type="button" value="Enter Another Record" onclick="document.location = 'open.php?user=<?php echo $adminuser;?>';">
<?php
mysql_close($con);
?>