<html>
<body>
<h1>Audit Tracking Tool</h1>
<?PHP
$user=getenv("username");
$con = mysql_connect("localhost","root","password");

    if (!$con)
      {
        die('Could not connect: ' . mysql_error());
      }

	mysql_select_db("audit") or die(mysql_error());
    $query = "select name from login where username='$user';";
    
	$retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Please Contact SEPG; May be You Are Not Registered');
		}

    
    while($row = mysql_fetch_assoc($retval)) 
    { 
     echo "<h3>"."Hi ".$row['name']." ! Welcome To Audit Tracking Tool"."<h3>"; 
    } 
 
?>

<form name="tstest">
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
	<TD><a href="pip.php">Process Improvement Proposal</a></TD>
</TR>
</form>
</body>
</html> 