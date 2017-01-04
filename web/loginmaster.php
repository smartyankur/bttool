<html>
<head>
<?php	
	$user=mysql_real_escape_string($_REQUEST['user']);
    //echo $user;
	include("config.php");

	$query = "select username from adminlogin where uniqueid='$user'";
	$retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Data Not Found Please contact SEPG');
		}

    
    while($row = mysql_fetch_assoc($retval)) 
    { 
     echo "<h3>"."Hi ".$row['username']." ! You Can Create Logins For Users"."<h3>";
	 $username=$row['username'];
	 //$pwd=$row['pwd'];
    } 	
	?>
</head>
<body>
<h1>Login Master Maintenance</h1>
<script type="text/javascript">
function trim(s)
{
	return rtrim(ltrim(s));
}

function ltrim(s)
{
	var l=0;
	while(l < s.length && s[l] == ' ')
	{	l++; }
	return s.substring(l, s.length);
}

function rtrim(s)
{
	var r=s.length -1;
	while(r > 0 && s[r] == ' ')
	{	r-=1;	}
	return s.substring(0, r+1);
}

function verify()
{
 //alert("Hi"); 
 
 var usr = trim(document.getElementById('sysuser').value);
 var nme = trim(document.getElementById('personname').value);
 var email = trim(document.getElementById('email').value);
 var role =  trim(document.getElementById('role').value);
 if (usr=="")
 {
  alert ("Please Provide System User Name");
  document.getElementById('sysuser').focus();
  return false;
 }

if (nme=="")
 {
  alert ("Please Provide Name Of Person");
  document.getElementById('personname').focus();
  return false;
 }

if (email=="")
 {
  alert ("Please Provide email Of Person");
  document.getElementById('email').focus();
  return false;
 }

if (role=="select")
 {
  alert ("Please Provide role Of Person");
  document.getElementById('role').focus();
  return false;
 }

}
</script>
<script language="JavaScript" src="datetimepicker.js">
</script>
<form name="tstest" action="loginsubmit.php" onsubmit="return verify()" method="post">
<TABLE>

<TR>
<TD>Unique ID</TD>
<TD><input type=text maxlength=35 size=35 name="sysuser" id="sysuser"></TD>
</TR>

<TR>
<TD>Name Of The Person</TD>
<TD><input type=text maxlength=35 size=35 name="personname" id="personname"></TD>
</TR>

<TR>
<TD>Email ID</TD>
<TD><input type=text maxlength=35 size=35 name="email" id="email"></TD>
</TR>

<TR>
<TD>Role</TD>
<TD><select name="role" size="1" id="role">
<option value="select" selected>Select</option>
<option value="ADMIN">ADMIN</option>
<option value="BD">BD</option>
<option value="DM">DM</option>
<option value="PM">PM</option>
<option value="FM">FM</option>
<option value="IQ">IQ</option>
<option value="HR">HR</option>
<option value="FIN">FIN</option>
<option value="QC">QC</option>
<option value="PH">PH</option>
<option value="DEV">DEV</option>
<option value="CLIENT">CLIENT</option>
<option value="VENDOR">VENDOR</option>
</select></TD>
</TR>

<TR>
<TD>Dept</TD>
<TD><select name="dept" size="1" id="dept">
<option value="select" selected>Select</option>
<option value="LMS">LMS</option>
<option value="Content">Content</option>
<option value="CLIENT">CLIENT</option>
<option value="VENDOR">VENDOR</option>
</select></TD>
</TR>


</TABLE>
<input type="submit" />
<?php
echo "<input type ='hidden' name='adminuser' value='$user'>";
?>
<input type="button" value="Main Menu" onclick="document.location = 'admin.php?ruser=<?php echo $user;?>';">
</form>
</body>
</html> 