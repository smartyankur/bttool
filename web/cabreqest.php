<?php	
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
     echo "<h3>"."Hi ".$row['username']." ! Welcome To Cab Booking Module"."<h3>";
	 $username=$row['username'];
    } 	
?>
<html>
<head>
<script type="text/javascript">
window.onunload = unloadPage;

function submitresponse()
{
 alert(123);
 //mywindow=window.open ("utedit.php?id="+mtr,"Ratting","scrollbars=1,width=250,height=85,0,status=0,");
 //if (window.focus) {mywindow.focus()}
}

function verify()
{
 //alert(123);
 var numericExpression = /^[0-9]+$/;
 var decimalExpression = /^[0-9. ]+$/;
 //var alphaExp = /^[a-zA-Z /s]*$/;
 //var alphanumericExp = /^[0-9a-zA-Z._, /s]*$/;
 var a = trim(document.getElementById('item').value);
 var b = trim(document.getElementById('meau').value);
 var d = trim(document.getElementById('quantity').value);
 
 if(a==""){alert("Please provide item name"); return false;}
 if(b=="Select"){alert("Please select measuring unit"); return false;}
 if(d==""){alert("Please provide quantity"); return false;}

 if(!d.match(decimalExpression))
  {
  alert("Quantity Should be Numeric or Decimal");
  return false;
  }
}

function getitem()
{
 document.getElementById("msgHint").innerHTML="";
 str=document.forms["tstest"]["item"].value;
 //alert(str);
 //getmail();

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

function submitresponse(str)
{
  //alert (str);
  var ptr = trim(document.getElementById(str).value);
  //alert (ptr);

if (ptr=="select")
{
 alert ("The status must be selected");
 //document.getElementById(str).focus();
 return false;
}

if (str=="")
  {
  document.getElementById("ResHint").innerHTML="";
  return;
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
    document.getElementById("ResHint").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","updatestat.php?q="+str+ "&r=" + ptr,true);
xmlhttp.send();

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
xmlhttp.open("GET","cardump.php",true);
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

</script>
</head>
<body background="bg.gif">
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
 //$message = "somebody posted the form";
 $purpose=mysql_real_escape_string($_POST['purpose']);
 $from=mysql_real_escape_string($_POST['from']);
 $to=mysql_real_escape_string($_POST['to']);
 $cabtype=$_POST['cabtype'];
 //$cabtype=(double)$_POST['quantity'];
 //$message=$item."+".$action."+".$quantity."+".$cash."+".$remarks;
 $cquery="insert into cabbooking(purpose,frompl,topl,cabtype,requester) values('$purpose','$from','$to','$cabtype','$username')";
 //echo $cquery;
 $cretval = mysql_query( $cquery, $con ) or die (mysql_error());
 $message="Cab request added to car booking master...";
 }
?>
<h6><div id="ResHint"><b></b></div></h6>
<script language="JavaScript" src="datetimepicker.js">
</script>
<form name="tstest" method="post" action="cabreqest.php" onsubmit="return verify()">

<TABLE>

<TR>
<TD>Purpose or Requirement Details</TD>
<TD><textarea name="purpose" rows="6" cols="30"></textarea></TD>
</TR>

<TR>
<TD>Starting From</TD>
<TD><input type="text" name="from" id="from" size="39"></TD>
</TR>


<TR>
<TD>Dropping To</TD>
<TD><input type="text" name="to" id="to" size="39"></TD>
</TR>

<TR>
<TD>Cab Type</TD>
<TD><select name="cabtype" id="cabtype"   size="1">
<option selected>Select</option>
<option value="AC">AC</option>
<option value="NONAC">NONAC</option>
</select></TD>
</TR>

</TABLE>
<?php
echo "<input type ='hidden' name='loggeduser' value='$username'>";
?>
<input type="button" value="Log Out" onclick="location.href='logout.php';">
<input type="submit" value="Add Item Details">
<input type="button" value="Show All Requests" onclick="showAll()">
</form>
<br />
<div id="txtHint"><i>Cab requests will appear here....</i></div>
</br>
<div id="msgHint"><i><?php echo $message; ?></i></div>
</body>
</html> 