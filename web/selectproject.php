<html>
<head>
<?php	
	$con = mysql_connect("localhost","root","password");
    $user=mysql_real_escape_string($_REQUEST['user']);

    if (!$con)
      {
        die('Could not connect: ' . mysql_error());
      }

	mysql_select_db("audit") or die(mysql_error());

    $query = "select username from adminlogin where uniqueid='$user'";
    
	$retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Data Not Found Please contact SEPG');
		}

    
    while($row = mysql_fetch_assoc($retval)) 
    { 
     echo "<h3>"."Hi ".$row['username']." ! You Can Select Project Names"."<h3>";
	 $username=$row['username'];
	 //$pwd=$row['pwd'];
    } 	
	?>
</head>
<body>
<?php
$con = mysql_connect("localhost","root","password");

    if (!$con)
      {
        die('Could not connect: ' . mysql_error());
      }

	mysql_select_db("audit") or die(mysql_error());
?>
<h1>PIN Maintenance</h1>
<script type="text/javascript">
function verify()
{
var projectname = document.getElementById('proname').value;
 
if (projectname=="Select")
 {
  alert ("Please Provide Project Name");
  document.getElementById('proname').focus();
  return false;
 }
}
</script>

<form name="tstest" action="promasedit.php" onsubmit="return verify()" method="post">
<TABLE>
<TR>
<TD>Project Name</TD>
<TD>
<?php
	$query = "select DISTINCT projectname from projectmaster";
    
	$retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Data Not Found');
		}

    echo "<select name=\"proname\" id=\"proname\">"; 
    echo "<option size =30 selected value=\"Select\">Select</option>";
    
	if(mysql_num_rows($retval)) 
    { 
    while($row = mysql_fetch_assoc($retval)) 
    { 
    echo "<option>$row[projectname]</option>"; 
    } 
 
    } 
    else {
    echo "<option>No Names Present</option>";  
    } 
?>
</TD>
</TR>
</TABLE>
<?php
echo "<input type ='hidden' name='user' value='$user'>";
?>
<input type="submit" />
<?php
echo "<input type ='hidden' name='adminuser' value='$user'>";
?>
<input type="button" value="Main Menu" onclick="document.location = 'admin.php?ruser=<?php echo $user;?>';">
</form>
</body>
</html> 