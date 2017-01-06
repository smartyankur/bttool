<head>
<style>
body
{
background:url('qcr.jpg') no-repeat;
}
.button
{
background-color: #F7941C;
border-bottom:#F7941C;
border-left: #F7941C;
border-right:#F7941C;
border-top: #F7941C;
color: black;
font-family: Tahoma
box-shadow:2px 2px 0 0 #014D06,;
border-radius: 10px;
border: 1px outset #b37d00 ;
}
.table_text {
	font-family: Calibri;
	font-size: 12px;
	font-style: normal;
	line-height: normal;
	font-weight: normal;
	font-variant: normal;
	color: #000000;
	text-indent: 10px;
	vertical-align: middle;
}

</style>
</head>
<body>
<?php
$id = $_REQUEST['id'];
$mid = $_REQUEST['mid'];

include('config.php');

$cquery="select * from accept where masterid='$mid' and indx='$id'";
$cresult=mysql_query($cquery) or die (mysql_error());
$count = mysql_num_rows($cresult);

If($count==0){
echo "<br>";
echo "<br>";
echo "<br>";
echo "No Plan Yet....";
}

else
{
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<table width='50%' border='1' cellspacing='0' cellpadding='0' bordercolor=\"orangered\">";
?>
<tr class="table_text"><th>Start Date</th><th>End Date</th><th>Accepted For Round</th></tr>
<?php
while($row = mysql_fetch_array($cresult))
 {
	echo "<td class=\"table_text\">".$row['SDate']."</td>";
	echo "<td class=\"table_text\">".$row['DDate']."</td>";
	echo "<td class=\"table_text\">".$row['round']."</td>";
 }
}
mysql_close($con);
?>
</table>
</br>
<input type="submit" value="Drop a Message" class="button">
</body>