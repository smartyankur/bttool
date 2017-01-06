<html>
<head>
<?php	
	$user=mysql_real_escape_string($_REQUEST['user']);
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
     echo "<h3>"."Hi ".$row['username']." ! You Can Create Project Records"."<h3>";
	 $username=$row['username'];
	 //$pwd=$row['pwd'];
    } 	
	?>
</head>
<body>

<h1>Project Master Maintenance</h1>
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
 var pin = trim(document.getElementById('pin').value);
 var IDate = trim(document.getElementById('IDate').value);
 var projectname = trim(document.getElementById('projectname').value);
 var SDate = trim(document.getElementById('SDate').value);
 var EDate = trim(document.getElementById('EDate').value);
 var cost = trim(document.getElementById('cost').value);
 var effort = trim(document.getElementById('effort').value);
 var projectmanager = trim(document.getElementById('projectmanager').value);
 var accountmanager = trim(document.getElementById('accountmanager').value);
 var clientspoc = trim(document.getElementById('clientspoc').value);
 var practice = trim(document.getElementById('practice').value);
 var remarks =  trim(document.getElementById('remarks').value);
 var accountname = trim(document.getElementById('accountname').value);
 var buhead = trim(document.getElementById('buhead').value);
 var practicehead = trim(document.getElementById('practicehead').value);
 var sepghead = trim(document.getElementById('sepghead').value);
 var sepglead = trim(document.getElementById('sepglead').value);
 var CDT = trim(document.getElementById('CDT').value);
 var CRate = trim(document.getElementById('CRate').value);
 var CPT = trim(document.getElementById('CPT').value);

 if (pin=="")
 {
  alert ("Please Provide PIN");
  document.getElementById('pin').focus();
  return false;
 }

if (IDate=="")
 {
  alert ("Please Provide Date Of Issue");
  document.getElementById('IDate').focus();
  return false;
 }

 if (accountname=="")
 {
  alert ("Please Provide Account Name");
  document.getElementById('accountname').focus();
  return false;
 }


if (projectname=="")
 {
  alert ("Please Provide Project Name");
  document.getElementById('projectname').focus();
  return false;
 }

if (SDate=="")
 {
  alert ("Please Provide Start Date");
  document.getElementById('SDate').focus();
  return false;
 }

if (EDate=="")
 {
  alert ("Please Provide End Date");
  document.getElementById('EDate').focus();
  return false;
 }

if (cost=="")
 {
  alert ("Please Provide Cost");
  document.getElementById('cost').focus();
  return false;
 }

 if(isNaN(cost))
    {
        alert("Enter numeric data in cost");
		document.getElementById('cost').focus();
        return false;
    }

if (effort=="")
 {
  alert ("Please Provide Effort");
  document.getElementById('effort').focus();
  return false;
 }

if(isNaN(effort))
    {
        alert("Enter numeric data in effort");
		document.getElementById('effort').focus();
        return false;
    }

if (projectmanager=="Select")
 {
  alert ("Please Provide Project Manager Name");
  document.getElementById('projectmanager').focus();
  return false;
 }

if (accountmanager=="Select")
 {
  alert ("Please Provide Account Manager Name");
  document.getElementById('accountmanager').focus();
  return false;
 }

if (clientspoc=="")
 {
  alert ("Please Provide Client Spoc Name");
  document.getElementById('clientspoc').focus();
  return false;
 }

if (CDT=="")
 {
  alert ("Please Provide Commercial Detail");
  document.getElementById('CDT').focus();
  return false;
 }

if (CRate=="")
 {
  alert ("Please Provide Commercial Detail");
  document.getElementById('CRate').focus();
  return false;
 }

if(isNaN(CRate))
    {
        alert("Enter numeric data in Rate");
		document.getElementById('CRate').focus();
        return false;
    }

if (CPT=="")
 {
  alert ("Please Provide Commercial Detail");
  document.getElementById('CPT').focus();
  return false;
 }

if (practice=="Select")
 {
  alert ("Please Provide Practice Detail");
  document.getElementById('practice').focus();
  return false;
 }

if (remarks=="")
 {
  alert ("Please Provide Remarks");
  document.getElementById('remarks').focus();
  return false;
 }

if (buhead=="Select")
 {
  alert ("Please Provide BUHead Name");
  document.getElementById('buhead').focus();
  return false;
 }

if (practicehead=="Select")
 {
  alert ("Please Provide Practice Head Name");
  document.getElementById('practicehead').focus();
  return false;
 }

if (sepghead=="Select")
 {
  alert ("Please Provide SEPG Head Name");
  document.getElementById('sepghead').focus();
  return false;
 }

if (sepglead=="Select")
 {
  alert ("Please Provide SEPG Lead Name");
  document.getElementById('sepglead').focus();
  return false;
 }
}
</script>
<script language="JavaScript" src="datetimepicker.js">
</script>
<form name="tstest" action="mastersubmit.php" onsubmit="return verify()" method="post">
<TABLE>
<TR>
<TD>PIN</TD>
<TD><input type=text maxlength=15 size=15 name="pin" id="pin"></TD>
</TR>

<TR>
<TD>Issue Date</TD>
<TD><input type="Text" id="IDate" value="" maxlength="20" size="9" name="IDate" readonly="readonly">
<a href="javascript:NewCal('IDate','ddmmmyyyy')"><img src="cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></TD>
</TR>

<TR>
<TD>Account Name</TD>
<TD><input type=text maxlength=50 size=50 name="accountname" id="accountname"></TD>
</TR>


<TR>
<TD>Project Name</TD>
<TD><input type=text maxlength=100 size=100 name="projectname" id="projectname"></TD>
</TR>


<TR>
<TD>Start Date</TD>
<TD><input type="Text" id="SDate" value="" maxlength="20" size="9" name="SDate" readonly="readonly">
<a href="javascript:NewCal('SDate','ddmmmyyyy')"><img src="cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></TD>
</TR>

<TR>
<TD>End Date</TD>
<TD><input type="Text" id="EDate" value="" maxlength="20" size="9" name="EDate" readonly="readonly">
<a href="javascript:NewCal('EDate','ddmmmyyyy')"><img src="cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></TD>
</TR>

<TR>
<TD>Project Cost</TD><TD><select name="currency" size="1" id="currency">
<option value="INR">INR</option>
<option value="GBP">GBP</option>
<option value="EURO">EURO</option>
<option value="USD">USD</option>
<option value="AUD">AUD</option>
<option value="other">OTHER</option>
</select><input type=text maxlength=10 size=10 name="cost" id="cost"></TD>
</TR>

<TR>
<TD>Estimated Effort(PH)</TD>
<TD><input type=text maxlength=10 size=10 name="effort" id="effort"></TD>
</TR>

<TR>
<TD>Client Spoc</TD>
<TD><input type=text maxlength=50 size=50 name="clientspoc" id="clientspoc"></TD>
</TR>

<TR>
<TD>Commercial Details Deal Type</TD>
<TD><input type=text maxlength=50 size=50 name="CDT" id="CDT"></TD>
</TR>

<TR>
<TD>Commercial Details Rate</TD>
<TD><input type=text maxlength=5 size=5 name="CRate" id="CRate"></TD>
</TR>

<TR>
<TD>Commercial Details Payment Terms</TD>
<TD><textarea name="CPT" rows="4" cols="30" id="CPT"></textarea></TD>
</TR>

<TR>
<TD>Practice</TD>
<TD><select name="practice" size="1" id="practice">
<option value="Select" selected>Select</option>
<option value="Content">Content</option>
<option value="LMS">LMS</option>
<option value="HR">HR</option>
<option value="ADMIN">ADMIN</option>
<option value="IT">IT</option>
<option value="VIVO">VIVO</option>
<option value="SEPG">SEPG</option>
<option value="ODIN">ODIN</option>
<option value="PHP">PHP</option>
<option value="ACCOUNT">ACCOUNT</option>
<option value="BD">BD</option>
</select></TD>
</TR>

<TR>
<TD>Remarks</TD>
<TD><textarea name="remarks" rows="4" cols="30" id="remarks"></textarea></TD>
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