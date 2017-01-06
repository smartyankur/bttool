<body background="bg.gif">
<?php
$id = $_POST['ID'];
$hour = $_POST['hour'];
//echo "project :".$project;
//echo "<br>";
$SD = date('Y-m-d',strtotime($_POST['DDate']));

include('config.php');

//$query = "INSERT INTO blogs_table(blogger_name, comment, date) VALUES ('".$logged_in_user . "', '".$inputfromform  . "', " ." now() )";

$query="update utilization set date='$SD', hours='$hour' where id='$id'";
//echo $query;
mysql_query($query) or die (mysql_error());
echo "Row Updated";
mysql_close($con);
?>
</body>