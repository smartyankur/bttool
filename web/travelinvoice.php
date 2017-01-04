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
     echo "<h3>"."Hi ".$row['username']." ! Welcome To Travel Invoice Module"."<h3>";
	 $username=$row['username'];
    } 	
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/> 
<script type="text/javascript">
window.onunload = unloadPage;

function filloption(str)
{
var dept=str;
//alert(dept);

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
    document.getElementById("OpHint").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","projdump.php?q="+dept,true);
xmlhttp.send();
}

function getpm(str)
{
var prj=str;
//alert(prj);

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
    document.getElementById("BilledTo").innerHTML=xmlhttp.responseText;
    }
  }
prj=encodeURIComponent(prj);
xmlhttp.open("GET","pminv.php?q="+prj,true);
xmlhttp.send();

}

function submitresponse(str)
{
 //alert(str);
 mywindow=window.open ("cabedit.php?id="+str,"Ratting","scrollbars=1,width=300,height=135,0,status=0,");
 if (window.focus) {mywindow.focus()}
}

function verify()
{
 var decimalExpression = /^[0-9. ]+$/;
 
 var j = trim(document.getElementById('dept').value);
 if(j=="Select"){alert("Please provide dept name"); return false;}
 
 if(document.getElementById('pm') == null) {alert("Billed To information missing"); return false;}
 
 var k = trim(document.getElementById('user').value);
 if(k==""){alert("Please provide traveller name"); return false;}

 var l = trim(document.getElementById('invno').value);
 if(l==""){alert("Please provide invoice number"); return false;}

 var m = trim(document.getElementById('itner').value);
 if(m==""){alert("Please provide place details"); return false;}
 
 var n = trim(document.getElementById('TDate').value);
 if(n==""){alert("Please provide travel start date"); return false;}
 
 var o = trim(document.getElementById('MDate').value);
 if(o==""){alert("Please provide invoice date"); return false;}
  
 var p = trim(document.getElementById('cost').value);
 if(p==""){alert("Please provide cost"); return false;}

 if(!p.match(decimalExpression))
 {
  alert("Cost should be Numeric or Decimal");
  return false;
 }
 //if(document.getElementById("OpHint").innerHTML==""){alert("Project not selected"); return false;}
 //if(document.getElementById('pm').value==""){alert("PM not selected"); return false;}
 ///var pr=document.getElementByName("OpHint")[0].childNodes; alert(pr);
 //var pm=document.getElementByName('BilledTo').innerHTML; alert(pm);
}

function getitem()
{
 document.getElementById("msgHint").innerHTML="";
 str=document.forms["tstest"]["item"].value;
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
    document.getElementById("fmHint").innerHTML=xmlhttp.responseText;
    }
}
str=encodeURIComponent(str);
xmlhttp.open("GET","getiteminfo.php?q="+str,true);
xmlhttp.send();
}

function unloadPage()
{
 //alert("unload event detected!");
 newwindow.close();
 //chwindow.close();
}

function showAll()
{
//alert(123);

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
xmlhttp.open("GET","tradump.php",true);
xmlhttp.send();
}

function changeai(str)
{
//alert(str);
newwindow=window.open("chai.php?param="+str,"Ratting","scrollbars=1,width=550,height=170,0,status=0,");
if (window.focus) {newwindow.focus()}
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

function showmailwin()
{
 
 if(document.getElementById('pm') == null) {alert("Billed To information missing"); return false;}
 
 var billedto = document.getElementById("pm").value;
 if(billedto=="") {alert("Please select the billedto information"); return false;}

 billedto=encodeURIComponent(billedto);
 
 mywindow=window.open ("sendmail.php?b="+billedto,"Ratting","scrollbars=1,width=550,height=170,0,status=0,");
 if (window.focus) {mywindow.focus()}
}

</script>
</head>
<body background="bg.gif">
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
 $dept=mysql_real_escape_string($_POST['dept']);
 $pm=mysql_real_escape_string($_POST['pm']);
 $user=mysql_real_escape_string($_POST['user']);
 $invno=mysql_real_escape_string($_POST['invno']);
 $itner=mysql_real_escape_string($_POST['itner']);
 $tdate=mysql_real_escape_string($_POST['TDate']);
 $mdate=mysql_real_escape_string($_POST['MDate']);
 $cost=mysql_real_escape_string($_POST['cost']);
 $tdate=strtotime($tdate);
 $tdate = date( 'Y-m-d', $tdate);
 $mdate=strtotime($mdate);
 $mdate = date( 'Y-m-d', $mdate);
 $cquery="insert into travelbooking(dept,pm,user,invno,itinerary,traveldate,invoicedate,cost) values('$dept','$pm','$user','$invno','$itner','$tdate','$mdate','$cost')";
 //echo $cquery;
 $cretval=mysql_query( $cquery, $con ) or die (mysql_error());
 $message="Invoice added to travel master :".$dept."~".$pm."~".$user."~".$invno."~".$tdate."~".$cost;
}
?>
<h6><div id="ResHint"><b></b></div></h6>
<script language="JavaScript" src="datetimepicker.js">
</script>
<form name="tstest" method="post" action="travelinvoice.php" onsubmit="return verify()">
<TABLE>

<TR>
<TD>Dept</TD>
<TD><select name="dept" id="dept" size="1" onchange="getpm(this.value)">
<option selected>Select</option>
<option value="LMS">LMS</option>
<option value="Content">Content</option>
<option value="HR">HR</option>
<option value="ADMIN">ADMIN</option>
<option value="IT">IT</option>
<option value="VIVO">VIVO</option>
<option value="SEPG">SEPG</option>
</select></TD>
</TR>

<TR>
<td>Billed To</td><td><div name="BilledTo" id="BilledTo"></div></td>
</TR>

<TR>
<td>Traveller</td><TD><input type="text" name="user" id="user" size="20" maxlength="50"></TD>
</TR>

<TR>
<TD>Invoice Number</TD>
<TD><input type="text" name="invno" id="invno" size="20" maxlength="50"></TD>
</TR>

<TR>
<td>To-From-To</td><TD><input type="text" name="itner" id="itner" size="20" maxlength="100"></TD>
</TR>

<TR>
<TD>Travel start date</TD>
<TD><input type="Text" readonly="readonly" id="TDate" value="" maxlength="20" size="9" name="TDate">
<a href="javascript:NewCal('TDate','ddmmmyyyy')"><img src="cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></TD>
</TR>

<TR>
<TD>Invoice Date</TD>
<TD><input type="Text" readonly="readonly" id="MDate" value="" maxlength="20" size="9" name="MDate">
<a href="javascript:NewCal('MDate','ddmmmyyyy')"><img src="cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></TD>
</TR>

<TR>
<TD>Total Amount</TD>
<TD><input type="text" name="cost" id="cost" size="9"></TD>
</TR>

</TABLE>
<?php
echo "<input type ='hidden' name='loggeduser' value='$username'>";
?>
<input type="button" value="Log Out" onclick="location.href='logout.php';">
<input type="submit" value="Add Item Details">
<input type="button" value="Show All Requests" onclick="showAll()">
<input type="button" value="Send Mail" onclick="showmailwin()">
</form>
<br />
<div id="txtHint"><i>Travel invoies will appear here....</i></div>
</br>
<div id="msgHint"><i><?php echo $message; ?></i></div>
</body>
</html> 