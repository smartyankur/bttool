<body background="bg.gif">
<?php
$id = $_POST['ID'];
$hour = $_POST['hour'];
//echo "project :".$project;
//echo "<br>";
$SD = date('Y-m-d',strtotime($_POST['DDate']));

$con = mysql_connect("localhost","root","password");
echo "</br>";
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
mysql_select_db("audit") or die(mysql_error());

//$query = "INSERT INTO blogs_table(blogger_name, comment, date) VALUES ('".$logged_in_user . "', '".$inputfromform  . "', " ." now() )";

$query="update utilization set date='$SD', hours='$hour' where id='$id'";
//echo $query;
mysql_query($query) or die (mysql_error());
echo "Row Updated";
mysql_close($con);
?>
</body>