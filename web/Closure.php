<html>
<body>
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
//alert("Hi");
var x=trim(document.forms["tstest"]["actionid"].value);
var y=trim(document.forms["tstest"]["feedback"].value);
var z=trim(document.forms["tstest"]["CDate"].value);
var b=document.forms["tstest"]["project"].value;

if (b=="Select")
  {
  alert("Project must be selected");
  document.forms["tstest"]["project"].focus();
  return false;
  }

if (x=="")
  {
  alert("Action ID must be filled");
  document.forms["tstest"]["actionid"].focus();
  return false;
  }
if (z=="")
  {
  alert("Date must be filled");
  document.forms["tstest"]["CDate"].focus();
  return false;
  }
if (y=="")
  {
  alert("Feedback must be filled");
  document.forms["tstest"]["feedback"].focus();
  return false;
  }
}
</script>
<h1>Update Action Items</h1>
<script language="JavaScript" src="datetimepicker.js">
</script>
<form name="tstest" action="closuresubmit.php" onsubmit="return validateForm()" method="post">
<TABLE>
<TR>
	<TD>Project Name</TD>
	<td>
    <?php
	include('config.php');
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
<TD>Action Item ID</TD>
<TD><input type=text maxlength=5 size=5 name="actionid"></TD>
</TR>
<TR>
<TD>Closure Date</TD>
<TD><input type="Text" id="CDate" value="" maxlength="20" size="9" name="CDate" readonly="readonly">
<a href="javascript:NewCal('CDate','ddmmmyyyy')"><img src="cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></TD>
</TR>
<TR>
	<TD>AI Status</TD>
	<TD><select name="status" size="1">
<option value=" Open ">Open</option>
<option value=" WIP ">Work In Progress</option>
<option value=" Closed ">Closed</option>
</select></TD>
</TR>
<TR>
	<TD>Comments</TD>
	<TD><textarea name="feedback" rows="6" cols="30"></textarea></TD>
</TR>
</TABLE>
<table border="1">
<input type="submit" />
<input type="button" value="Main Menu" onclick="document.location = 'admin.html';">
</form>
</body>
</html> 