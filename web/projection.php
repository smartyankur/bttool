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
     echo "</br>";
	 echo "</br>";
     echo "</br>";
	 echo "<h3>"."Hi ".$row['username']." ! Welcome To Projection Interface."."</h3>";
	 $username=$row['username'];
    } 	
	?>
<html>
<head>
<style type="text/css">
body
{
background:url('qcr.jpg') no-repeat;
}
.button
{
background-color: #F7941C;
border-bottom:#F7941C;
border-left: #F7941C;
border-right:#F7941C;
border-top: #F7941C;
color: black;
font-family: Tahoma
box-shadow:2px 2px 0 0 #014D06,;
border-radius: 10px;
border: 1px outset #b37d00 ;
}
</style>
<script type="text/javascript">
function showhistory(str)
{
 //alert(str);
 newwindow=window.open("piphistory.php?param1="+str,"Ratting","scrollbars=1,width=550,height=170,0,status=0,");
 if (window.focus) {newwindow.focus()}
}
function showAll()
{
var project = trim(document.getElementById('project').value);

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
project= encodeURIComponent(project);
xmlhttp.open("GET","projecall.php?q="+project,true);
xmlhttp.send();
}

function submitproposal()
{
  var decimalExpression = /^[0-9. ]+$/; 
  var project = trim(document.getElementById('project').value);
  var fsimpact = trim(document.getElementById('fsimpact').value);
  var PDate = trim(document.getElementById('PDate').value);
  var pleffort = trim(document.getElementById('pleffort').value);
  var QDate = trim(document.getElementById('QDate').value);
  var brt = trim(document.getElementById('brt').value);
  var scope = trim(document.getElementById('scope').value);

if (project=="Select")
  {
  alert ("Please Provide Project name");
  //document.getElementById('proposal').focus();
  return false;
  }

if (fsimpact=="select")
  {
  alert ("Please Provide impact");
  //document.getElementById('practice').focus();
  return false;
  }

if (PDate=="")
  {
  alert ("Please Provide Planned Date");
  //document.getElementById('proposal').focus();
  return false;
  }

if (pleffort=="" || pleffort==0)
  {
  alert ("Please Provide Effort");
  //document.getElementById('proposal').focus();
  return false;
  }

if (QDate=="")
  {
  alert ("Please Provide Planned QC Date");
  //document.getElementById('proposal').focus();
  return false;
  }

if (brt=="select")
  {
  alert ("Please Provide build release time");
  //document.getElementById('proposal').focus();
  return false;
  }

if (scope=="")
  {
  alert ("Please Provide scope.");
  //document.getElementById('proposal').focus();
  return false;
  }

if(!pleffort.match(decimalExpression))
  {
  alert("Effort Should be Numeric or Decimal");
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
project= encodeURIComponent(project);
pleffort= encodeURIComponent(pleffort);
//alert(project);
//alert(pleffort);
xmlhttp.open("GET","projec.php?q="+project+ "&s=" + pleffort+ "&t=" + PDate+ "&u=" + fsimpact+ "&v=" + QDate+ "&w=" + brt+ "&x=" + scope,true);
xmlhttp.send();

}

function submitresponse(str)
{
alert (str);
 
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
    document.getElementById("ResHint").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","deleteproj.php?q="+str,true);
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

</script>
</head>
<body>
<script language="JavaScript" src="datetimepicker.js">
</script>
<form name="tstest">
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
    $query = "select projectname from projectmaster where practice='LMS'";
    
	$retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Data Not Found');
		}

    echo "<select id=\"project\">"; 
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
<TD>FS has been impacted</TD>
<TD><select name="fsimpact" size="1" id="fsimpact">
<option value="select">Select</option>
<option value="Y" <?php if($fsimpact=="Y") echo "selected";?>>Yes</option>
<option value="N" <?php if($fsimpact=="N") echo "selected";?>>No</option>
</select></TD>
</TR>

<TR>
<TD>Planned Delivery Date</TD>
<TD><input type="Text" readonly="readonly" id="PDate" value="<?php echo $PDate;?>" maxlength="20" size="17" name="PDate">
<a href="javascript:NewCal('PDate','ddmmmyyyy',true,24)"><img src="cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></TD>
</TR>

<TR>
<TD>Planned Effort</TD>
<TD><input type=text maxlength=5 size=5 name="pleffort" id="pleffort" value="<?php echo $pleffort;?>"></TD>
</TR>

<TR>
<TD>Planned QC Date</TD>
<TD><input type="Text" readonly="readonly" id="QDate" value="<?php echo $QDate;?>" maxlength="20" size="17" name="QDate">
<a href="javascript:NewCal('QDate','ddmmmyyyy',true,24)"><img src="cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></TD>
</TR>


<TR>
<TD>Build release time</TD>
<TD><select name="brt" size="1" id="brt">
<option value="select">Select</option>
<option value="AM" <?php if($brt=="AM") echo "selected";?>>AM</option>
<option value="PM" <?php if($brt=="PM") echo "selected";?>>PM</option>
</select></TD>
</TR>

<TR>
<TD>Scope Description</TD>
<TD><textarea name="scope" rows="4" cols="30" id="scope"><?php echo stripslashes($scope);?></textarea></TD>
</TR>

</TABLE>
<br>
<?php
echo "<input type ='hidden' id='user' value='$username'>";
?>
<input type="button" value="Log Out" onclick="location.href='logout.php';">
<input type="button" value="Submit" onclick="submitproposal();">
<input type="button" value="Show All" onclick="showAll()">
</form>
<br />
<div id="ResHint"><b></b></div>
<div id="txtHint"><b></b></div>

</body>
</html> 