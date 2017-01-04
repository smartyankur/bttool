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
       echo "<br>";
       echo "<br>";
       echo "<h3>"."Hi ".$row['username']." ! Welcome To CAB Report Module"."<h3>";
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
    document.getElementById("BilledTo").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","budump.php?q="+dept,true);
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
xmlhttp.open("GET","pmdump.php?q="+prj,true);
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
 var alphaExp = /^[a-zA-Z /s]*$/;
 var a = trim(document.getElementById('user').value);
 var h = trim(document.getElementById('cost').value);
 var j = trim(document.getElementById('dept').value);
 var k = trim(document.getElementById('MDate').value);
 var l = trim(document.getElementById('menu').value);
 var m = trim(document.getElementById('BilledTo').value);
 
 if(j=="Select"){alert("Please provide dept name"); return false;}
 if(m==""){alert("Please provide Billed To Name"); return false;}
 if(a==""){alert("Please provide username"); return false;}
 if(l=="Select"){alert("Please provide menu"); return false;}
 if(k==""){alert("Please provide date"); return false;}
 if(h==""){alert("Please provide cost"); return false;}
 
 
 if(!m.match(alphaExp))
  {
  alert("BilledTo Name should be alphabetic");
  return false;
  }
 
 if(!a.match(alphaExp))
  {
  alert("User Name should be alphabetic");
  return false;
  }
 
 if(!h.match(decimalExpression))
  {
  alert("Cost should be Numeric or Decimal");
  return false;
  } 
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

var j = trim(document.getElementById('dept').value);
var k = trim(document.getElementById('FDate').value);
var t = trim(document.getElementById('TDate').value);

//alert(j);
//alert(k);
//alert(t);

if(j=="Select"){alert("Please provide dept name"); return false;}
if(k==""){alert("Please provide From Date"); return false;}
if(t==""){alert("Please provide To Date"); return false;}

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
//xmlhttp.open("GET","updatestat.php?q="+str+ "&r=" + ptr,true);
xmlhttp.open("GET","cabdumprpt.php?q="+j+ "&r=" + k+ "&s=" + t,true);
xmlhttp.send();

}

function showTot()
{
//alert(123);

var j = trim(document.getElementById('dept').value);
var k = trim(document.getElementById('FDate').value);
var t = trim(document.getElementById('TDate').value);

//alert(j);
//alert(k);
//alert(t);

if(j=="Select"){alert("Please provide dept name"); return false;}
if(k==""){alert("Please provide From Date"); return false;}
if(t==""){alert("Please provide To Date"); return false;}

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
//xmlhttp.open("GET","updatestat.php?q="+str+ "&r=" + ptr,true);
xmlhttp.open("GET","cardumptot.php?q="+j+ "&r=" + k+ "&s=" + t,true);
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
 var billedto = trim(document.getElementById('billedto').value);
 var k = trim(document.getElementById('FDate').value);
 var t = trim(document.getElementById('TDate').value);
 //var phase = trim(document.getElementById('phase').value);
 //alert(billedto);
 //alert(k);
 //alert(t);

 if(billedto=="Select") {alert("Please select the billedto"); return false;}
 //if(phase=="select") {alert("Please select the phase"); return false;}
 if(k=="" || t=="") {alert("Please select the dates"); return false;} 

 billedto=encodeURIComponent(billedto);
 //phase=encodeURIComponent(phase);
 
 mywindow=window.open ("getcabbill.php?b="+billedto + "&r="+ k + "&s="+ t,"Ratting","scrollbars=1,width=550,height=170,0,status=0,");
 if (window.focus) {mywindow.focus()}

}

</script>
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
</head>
<body>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
 $dept=mysql_real_escape_string($_POST['dept']);
 $pm=mysql_real_escape_string($_POST['BilledTo']);
 $user=mysql_real_escape_string($_POST['user']);
 $menu=mysql_real_escape_string($_POST['menu']);
 $cost=$_POST['cost']*95/100;
 $date=strtotime($_POST['MDate']);
 $date = date( 'Y-m-d', $date );
 $cquery="insert into food(dept,user,cost,billedto,date,menu) values('$dept','$user','$cost','$pm','$date','$menu')";
 //echo $cquery;
 $cretval=mysql_query( $cquery, $con ) or die (mysql_error());
 $message="Food request added :".$dept." ".$project." ".$pm." ".$user." ".$cost." "." ".$date." ".$menu;
}
?>
<h6><div id="ResHint"><b></b></div></h6>
<script language="JavaScript" src="datetimepicker.js">
</script>
<form name="tstest" method="post" action="food.php" onsubmit="return verify()">
<TABLE>

<TR>
	<TD>Billed To</TD>
	<td>
    <?php
	$con = mysql_connect("localhost","root","password");

    if (!$con)
      {
        die('Could not connect: ' . mysql_error());
      }

	mysql_select_db("audit") or die(mysql_error());
    $query = "select distinct billedto from cabbooking";
    
	$retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Data Not Found');
		}

    echo "<select name=\"billedto\" id=\"billedto\">"; 
    echo "<option size =30 selected>Select</option>";
    
	if(mysql_num_rows($retval)) 
    { 
    while($row = mysql_fetch_assoc($retval)) 
    {
	 if(strlen($row[billedto])<>0)
		{		 
         echo "<option>$row[billedto]</option>"; 
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
<TD>From Date</TD>
<TD><input type="Text" readonly="readonly" id="FDate" value="" maxlength="20" size="9" name="FDate">
<a href="javascript:NewCal('FDate','ddmmmyyyy')"><img src="cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></TD>
</TR>

<TR>
<TD>To Date</TD>
<TD><input type="Text" readonly="readonly" id="TDate" value="" maxlength="20" size="9" name="TDate">
<a href="javascript:NewCal('TDate','ddmmmyyyy')"><img src="cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></TD>
</TR>

</TABLE>
<?php
echo "<input type ='hidden' name='loggeduser' value='$username'>";
?>
<input type="button" class="button" value="Log Out" onclick="location.href='logout.php';">
<input type="button" class="button" value="Send Mail" onclick="showmailwin()">
</form>
</body>
</html>