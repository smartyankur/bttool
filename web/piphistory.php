<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>PIP History</title>
</head>
<body background="bg.gif">
<form name="ttest">
<?php
$con = mysql_connect("localhost","root","password");
//$user=$_SESSION['login'];

if (!$con)
{
  die('Could not connect: ' . mysql_error());
}

mysql_select_db("audit") or die(mysql_error());
$id=$_REQUEST['param1'];
//echo "<b>"."PIP :"."</b>".$id;
$query="select * from piphistory where pipid='".$id."'";
$retval = mysql_query( $query, $con );
echo "---------------------------------------------------------------------------------------------------";
while($row = mysql_fetch_assoc($retval))
{
 echo "</br>";
 echo "Date :".$row['date']."</br>";
 echo "Status :".$row['status']."</br>";
 echo "--------------------------------------------------------------------------------------------------";
}
?>
</br>
</form>
</body>
</html>
