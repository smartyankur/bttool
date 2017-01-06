<?php	
	session_start();
	
	if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	header ("Location:index.php");
    }
	
    $user=$_SESSION['login'];

    include('config.php');

    $query = "select username from login where uniqueid='$user'";
    
	$retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Data Not Found Please contact SEPG');
		}

    
    while($row = mysql_fetch_assoc($retval)) 
    { 
     echo "<h3>"."Hi ".$row['username']." ! Manage Manual Labour Expenses."."</h3>";
	 $username=$row['username'];
    } 	
	?>
<html>
<head>
<script type="text/javascript">
function showhistory(str)
{
 //alert(str);
 newwindow=window.open("piphistory.php?param1="+str,"Ratting","scrollbars=1,width=550,height=170,0,status=0,");
 if (window.focus) {newwindow.focus()}
}
function showAll()
{

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","getallman.php",true);
xmlhttp.send();
}

function submitproposal()
{
  //alert (pqr);
  var decimalExpression = /^[0-9. ]+$/;
  var str = trim(document.getElementById('prop').value);
  var cost = trim(document.getElementById('cost').value);
  var etype = trim(document.getElementById('etype').value);
  var date = trim(document.getElementById('MDate').value);
  var mop = trim(document.getElementById('mop').value);
  //alert (pqr);

if (str=="")
  {
  alert ("Please Provide Labour Details");
  document.getElementById('prop').focus();
  return false;
  }

if (cost=="")
  {
  alert ("Please Provide Cost");
  document.getElementById('cost').focus();
  return false;
  }


if (mop=="Select")
  {
  alert ("Please Provide Mode Of Payment");
  document.getElementById('mop').focus();
  return false;
  }


if (date=="")
  {
  alert ("Please Provide Date");
  document.getElementById('MDate').focus();
  return false;
  }

if (etype=="Select")
  {
  alert ("Please Provide Expense Type");
  document.getElementById('etype').focus();
  return false;
  }

  
if(!cost.match(decimalExpression))
  {
  alert("Effort should be Numeric or Decimal");
  return false;
  }

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }

else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }

xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
str= encodeURIComponent(str);
cost= encodeURIComponent(cost);
xmlhttp.open("GET","manual.php?q="+str+ "&r=" +cost+ "&s=" +etype+ "&t=" +date+ "&u=" +mop,true);
xmlhttp.send();
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

function submitresponse(str)
{
 //alert(str);
 mywindow=window.open ("manualedit.php?id="+str,"Ratting","scrollbars=1,width=550,height=170,0,status=0,");
 if (window.focus) {mywindow.focus()}
 
}
</script>
</head>
<body background="bg.gif">
<script language="JavaScript" src="datetimepicker.js">
</script>
<form name="tstest" action="manual.php">
<TABLE>
<TR>
<TD>Manual Labour Details</TD>
<TD><textarea id="prop" name="prop" rows="6" cols="30"></textarea></TD>
</TR>
<TR>
<TD>Cost</TD>
<TD><input type="text" name="cost" id="cost" size="9"></TD>
</TR>
<TR>
<TD>Mode Of Payment</TD>
<TD><select name="mop" id="mop" size="1">
<option selected>Select</option>
<option value="Cash">Cash</option>
<option value="Cheque">Cheque</option>
</select></TD>
</TR>
<TR>
<TD>Date</TD>
<TD><input type="Text" readonly="readonly" id="MDate" value="" maxlength="20" size="9" name="MDate">
<a href="javascript:NewCal('MDate','ddmmmyyyy')"><img src="cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></TD>
</TR>
<TR>
<TD>Expense Type</TD>
<TD><select name="etype" id="etype"   size="1">
<option selected>Select</option>
<option value="Electrical">Electrical</option>
<option value="Plumbing">Plumbing</option>
<option value="Telephone">Telephone</option>
<option value="Carpentry">Carpentry</option>
<option value="Florist">Florist</option>
<option value="Snacks">Snacks</option>
<option value="Others">Others</option>
<option value="Decoration">Decoration</option>
</select></TD>
</TR>

</TABLE>
<br>
<?php
echo "<input type ='hidden' id='user' value='$username'>";
?>
<input type="button" value="Log Out" onclick="location.href='logout.php';">
<input type="button" value="Submit the Response" onclick="submitproposal();">
<input type="button" value="Show Manual Labour Details" onclick="showAll()">
</form>
<br />
<div id="txtHint"><b></b></div>

</body>
</html> 