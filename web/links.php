<html>
<body background="bg.gif">
<h1>Audit Tracking Tool</h1>
<?PHP
//error_reporting(0);
if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {

	session_start();
	$_SESSION['login'] = "";
	header ("Location:index.php");
}

else 
{
session_start();     
$user=$_SESSION['login'];	 
$con = mysql_connect("localhost","root","password");

if (!$con)
{
   die('Could not connect: ' . mysql_error());
}

mysql_select_db("audit") or die(mysql_error());

$query = "select username from login where uniqueid='$user';";
$retval = mysql_query( $query, $con );
$count = mysql_num_rows($retval);
	
if($count==0)
{
 die('Please Contact SEPG; May be You Are Not Registered');
}
   
while($row = mysql_fetch_assoc($retval)) 
{ 
 echo "<h3>"."Hi ".$row['username']." ! Welcome To Audit Tracking Tool"."<h3>"; 
}
}
?>

<form name="tstest" method=post>
<TABLE border=1>
<TR>
	<TD><a href="ncaging.php">NC Aging Projectwise</a></TD>
</TR>
<TR>
	<TD><a href="ncreport.php">Give Response For Individual Action Item</a></TD>	
</TR>
<TR>
	<TD><a href="ncreportglobalresponse.php">Give Global Response For a Set Of Action Items</a></TD>
</TR>
<TR>
	<TD><a href="ncdreport.php">NC Density Projectwise. No of NCs per PH</a></TD>
</TR>
<TR>
	<TD><a href="mastercompliance.php">Master Compliance Report</a></TD>
</TR>

<TR>
	<TD><a href="momframe.php">MOM Creation And Tracking</a></TD>
</TR>

<TR>
	<TD><a href="momreport.php">MOM Report Generation</a></TD>
</TR>

<TR>
	<TD><a href="string.php">Search MOMs with STRING</a></TD>
</TR>

<TR>
	<TD><a href="status.php">Create Project Status Report</a></TD>
</TR>

<TR>
	<TD><a href="pip.php">Process Improvement Proposal</a></TD>
</TR>

</table>
<br>
<br>
<input type="button" value="Login Page" onclick="location.href='login.html';">
</form>
</body>
</html> 