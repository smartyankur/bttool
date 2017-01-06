<?php	
$user=mysql_real_escape_string($_REQUEST['user']);
    //echo $user;

    include('config.php');

	$query = "select username from adminlogin where uniqueid='$user'";
	$retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Data Not Found Please contact SEPG');
		}

    
    while($row = mysql_fetch_assoc($retval)) 
    { 
     echo "<h3>"."Hi ".$row['username']." ! Please Find Org Level Open, Close and Over Due Ai Count."."<h3>";
	 $username=$row['username'];
	 //$pwd=$row['pwd'];
    } 	

$total="select count(*) from actionitem";
$retotal=mysql_query($total) or die (mysql_error());
$trow = mysql_fetch_assoc($retotal);
$totc=$trow['count(*)'];

$cquery="Select count(*) from actionitem where status='open'";
$cresult=mysql_query($cquery) or die (mysql_error());
$crow = mysql_fetch_assoc($cresult);
$openitem=$crow['count(*)'];
$currentdate= date("Y-m-d");

$query="select count(*) from actionitem where status='open' and targetdate<'$currentdate'"; 
$result=mysql_query($query) or die (mysql_error());
$row=mysql_fetch_assoc($result);
$overdue=$row['count(*)'];

$close="select count(*) from actionitem where status='closed'"; 
$clresult=mysql_query($close) or die (mysql_error());
$clrow=mysql_fetch_assoc($clresult);
$closed=$clrow['count(*)'];

?>
<br>
<br>
<table border=1>
<tr>
<td>Total Org Level AIs :</td><td><?php echo $totc;?></td>
</tr>
<tr>
<td>Total Org Level Closed AIs :</td><td><?php echo $closed;?></td>
</tr>
<tr>
<td>Total Org Level Open AIs :</td><td><?php echo $openitem;?></td>
</tr>
<tr>
<td>Total Org Level Overdue AIs :</td><td><?php echo $overdue;?></td>
</tr>
</table
<br>
<br>
<input type="button" value="Main Menu" onclick="document.location = 'admin.php?ruser=<?php echo $user;?>';">
<?php
mysql_close($con);
?>