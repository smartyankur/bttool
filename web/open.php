<html>
<head>
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
function validateForm()
{
var x=trim(document.forms["tstest"]["finding"].value);
var y=document.forms["tstest"]["process"].value;
var z=document.forms["tstest"]["DDate"].value;
var a=document.forms["tstest"]["TDate"].value;
var b=document.forms["tstest"]["project"].value;

if (b=="Select")
  {
  alert("Project must be selected");
  document.forms["tstest"]["project"].focus();
  return false;
  }

if (y=="Select")
  {
  alert("Process Area must be filled");
  document.forms["tstest"]["process"].focus();
  return false;
  }

if (x=="")
  {
  alert("Feedback must be filled");
  document.forms["tstest"]["finding"].focus();
  return false;
  }


if (z=="")
  {
  alert("Discussion Date must be filled");
  document.forms["tstest"]["DDate"].focus();
  return false;
  }
if (a=="")
  {
  alert("Target Date must be filled");
  document.forms["tstest"]["TDate"].focus();
  return false;
  }

}
</script>
</head>
<?php	
	$con = mysql_connect("localhost","root","password");
    $user=mysql_real_escape_string($_REQUEST['user']);
    //echo $user;

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
     echo "<h3>"."Hi ".$row['username']." ! You Can Log Action Items"."<h3>";
	 $username=$row['username'];
	 //$pwd=$row['pwd'];
    } 	
?>
<body>
<h1>Enter Action Item</h1>
<script language="JavaScript" src="datetimepicker.js">
</script>
<form name="tstest" action="submit.php" onsubmit="return validateForm()" method="post">

<TABLE>
<TR>
	<TD>Project Name</TD>
	<td>
    <?php
	$con = mysql_connect("localhost","root","password");

    if (!$con)
      {
        die('Could not connect: ' . mysql_error());
      }

	mysql_select_db("audit") or die(mysql_error());
    $query = "select projectname from projectmaster";
    
	$retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Data Not Found');
		}

    echo "<select name=\"project\">"; 
    echo "<option size =30 selected>Select</option>";
    
	if(mysql_num_rows($retval)) 
    { 
    while($row = mysql_fetch_assoc($retval)) 
    {
	 if(strlen($row[projectname])<>0)
		{		 
         echo "<option>$row[projectname]</option>"; 
        }
	} 
 
    } 
    else {
    echo "<option>No Names Present</option>";  
    } 
    ?>
    </td>
</TR>
<TR>
	<TD>Process Area</TD>
	<TD><select name="process" size="1">
<option value="Select" selected>Select</option>
<option value="CAR">CAR</option>
<option value="CM">CM</option>
<option value="DAR">DAR</option>
<option value="IPM">IPM</option>
<option value="MA">MA</option>
<option value="OID">OID</option>
<option value="OPD">OPD</option>
<option value="OPF">OPF</option>
<option value="OPP">OPP</option>
<option value="OT">OT</option>
<option value="PI">PI</option>
<option value="PMC">PMC</option>
<option value="PP">PP</option>
<option value="PPQA">PPQA</option>
<option value="QPM">QPM</option>
<option value="RD">RD</option>
<option value="REQM">REQM</option>
<option value="RSKM">RSKM</option>
<option value="SAM">SAM</option>
<option value="TS">TS</option>
<option value="VAL">VAL</option>
<option value="VER">VER</option>
</select></TD>
</TR>

<TR>
<TD>Type of NC</TD>
<TD><select name="nctype" size="1">
<option value="NC">NC</option>
<option value="Followon">Followon</option>
<option value="Improvement">Improvement</option>
</select></TD>
</TR>

<TR>
<TD>NC Owner</TD>
<TD><select name="ncowner" size="1">
<option value="PM">PM</option>
<option value="DM">DM</option>
<option value="BD">BD</option>
</select></TD>
</TR>

<TR>
<TD>Audit Finding</TD>
<TD><textarea name="finding" rows="6" cols="30"></textarea></TD>
</TR>
<TR>
<TD>Discussion Date</TD>
<TD><input type="Text" id="DDate" value="" maxlength="20" size="9" name="DDate" readonly="readonly">
<a href="javascript:NewCal('DDate','ddmmmyyyy')"><img src="cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></TD>
</TR>
<TR>
<TD>Target Date</TD>
<TD><input type="Text" id="TDate" value="" maxlength="20" size="9" name="TDate" readonly="readonly">
<a href="javascript:NewCal('TDate','ddmmmyyyy')"><img src="cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></TD>
</TR>
</TABLE>
<table border="1">
<input type="submit" />
<?php
echo "<input type ='hidden' name='adminuser' value='$user'>";
?>
<input type="button" value="Main Menu" onclick="document.location = 'admin.php?ruser=<?php echo $user;?>';">
</form>
</body>
</html> 