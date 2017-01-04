<?php
$q=$_GET["q"];

$con = mysql_connect("localhost","root","password");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("audit", $con);
//echo "Hi".$q;

$sql="SELECT * FROM mommaster WHERE projectname = '".$q."'";
echo $sql;

$result = mysql_query($sql);

echo "<table border='1'>
<tr>
<th>Firstname</th>
<th>Lastname</th>
<th>Age</th>
</tr>";

while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>" . $row['agenda'] . "</td>";
  echo "<td>" . $row['participants'] . "</td>";
  echo "<td>" . $row['date'] . "</td>";
  echo "</tr>";
  }
echo "</table>";

mysql_close($con);
?> 