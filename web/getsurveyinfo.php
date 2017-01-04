<?php
$con = mysql_connect("localhost","root","password");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("audit", $con);
//echo "Hi";

$sql="SELECT * FROM surveyreport";
//echo $sql;

$result = mysql_query($sql);
$count = mysql_num_rows($result);

if($count==0)
{
  die('Data Not Found');
}

//echo "---------------------------------------------------------------------------------------------------------------------";
echo "<table width='50%' border='1' cellspacing='0' cellpadding='0'>";
?>
<tr><th>Reviewee</th><th>Dept Of Respondent</th><th>Function Of Respondent</th><th>Name Of Respondent</th><th>Q1</th><th>Q2</th><th>Q3</th><th>Q4</th><th>Q5</th><th>Q6</th><th>Q7</th><th>Q8</th><th>Q9</th><th>Q10</th><th>Q11</th></tr>
<?php
while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".htmlentities($row['reviewee'])."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".htmlentities($row['dept'])."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".htmlentities($row['function'])."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".htmlentities($row['respondent'])."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".htmlentities($row['Q1'])."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".htmlentities($row['Q2'])."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".htmlentities($row['Q3'])."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".htmlentities($row['Q4'])."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".htmlentities($row['Q5'])."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".htmlentities($row['Q6'])."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".htmlentities($row['Q7'])."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".htmlentities($row['Q8'])."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".htmlentities($row['Q9'])."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".htmlentities($row['Q10'])."</div>"."</td>";
  echo "<td>"."<div style="."width:100;height:53;overflow:auto>".htmlentities($row['Q11'])."</div>"."</td>";
  }
mysql_close($con);
?> 