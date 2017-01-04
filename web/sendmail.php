<?php	
    error_reporting(0);
	session_start();
	
	if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	header ("Location:index.php");
    }
	
	$con = mysql_connect("localhost","root","password");
    $user=$_SESSION['login'];

    if (!$con)
    {
        die('Could not connect: ' . mysql_error());
    }

	mysql_select_db("audit") or die(mysql_error());

    $query = "select username from login where uniqueid='$user'";
    
	$retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
	{
			die('Data Not Found Please contact SEPG');
	}

    
    while($row = mysql_fetch_assoc($retval)) 
    { 
     echo "<h4>"."Hi ".$row['username']." ! Welcome To Travel Invoice Mail Module"."<h4>";
	 $username=$row['username'];
    } 	
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/> 
<script type="text/javascript">
window.onunload = unloadPage;

function verify()
{
 var decimalExpression = /^[0-9. ]+$/;
 
 var j = trim(document.getElementById('BilledTo').value);
 if(j==""){alert("Please provide BilledTo information"); return false;}
 
 var k = trim(document.getElementById('MDate').value);
 if(k==""){alert("Please provide From Date"); return false;}

 var l = trim(document.getElementById('TDate').value);
 if(l==""){alert("Please provide To Date"); return false;}
}

function unloadPage()
{
 //alert("unload event detected!");
 newwindow.close();
 //chwindow.close();
}

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

</script>
</head>
<body background="bg.gif">
<?php
//get the billed to information
$billedto=$_REQUEST["b"];
?>
<h6><div id="ResHint"><b></b></div></h6>
<script language="JavaScript" src="datetimepicker.js">
</script>
<form name="tstest" method="post" action="invbill.php" onsubmit="return verify()">
<TABLE>
<TR><h5>Select From and To Date to send the invoice details to the Owner</h5></TR>
<TR>
<td>Billed To</td><TD><input type="text" name="BilledTo" id="BilledTo" value="<?php echo $billedto;?>" size="20" maxlength="50"></TD>
</TR>

<TR>
<TD>From InvoiceDate</TD>
<TD><input type="Text" readonly="readonly" id="MDate" value="" maxlength="20" size="9" name="MDate">
<a href="javascript:NewCal('MDate','ddmmmyyyy')"><img src="cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></TD>
</TR>

<TR>
<TD>To InvoiceDate</TD>
<TD><input type="Text" readonly="readonly" id="TDate" value="" maxlength="20" size="9" name="TDate">
<a href="javascript:NewCal('TDate','ddmmmyyyy')"><img src="cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></TD>
</TR>

</TABLE>
<?php
echo "<input type ='hidden' name='loggeduser' value='$username'>";
?>
<input type="submit" value="Proceed...">
</form>
</body>
</html> 