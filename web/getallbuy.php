<?php
session_start();
	
if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
header ("Location:index.php");
}
	
$con = mysql_connect("localhost","root","password");
$user=$_SESSION['login'];

if (!$con)
{
 die('Could not connect: ' . mysql_error());
}

mysql_select_db("audit") or die(mysql_error());
$query = "select username from login where uniqueid='$user'";
    
$retval = mysql_query( $query, $con );
$count = mysql_num_rows($retval);
	
if($count==0)
{
die('Session data not found please contact SEPG');
}

$q=$_GET["q"];

$sql="SELECT * FROM csrfvul WHERE symbol = '".$q."'";
//echo $sql;

$result = mysql_query($sql);
$count = mysql_num_rows($result);

if($count==0)
{
  die('Data Not Found');
}

//echo "---------------------------------------------------------------------------------------------------------------------";
echo "<table width='100%' border='1' cellspacing='0' cellpadding='0'>";
?>
<tr><th>Symbol</th><th>Count</th><th>Date</th></tr>
<?php
while($row = mysql_fetch_array($result))
{
 echo "<tr>";
 echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['symbol']."</div>"."</td>";
 echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['shares']."</div>"."</td>";
 echo "<td>"."<div style="."width:100;height:53;overflow:auto>".$row['date']."</div>"."</td>";
}
mysql_close($con);
?> 