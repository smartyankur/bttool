<?php	
    error_reporting(0);
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
       echo "<br>";
       echo "<br>";
       echo "<h3>"."Hi ".$row['username']." ! Welcome To Cab Booking Module"."</h3>";
	 $username=$row['username'];
    } 	

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
 $dept=mysql_real_escape_string($_POST['dept']);
 $project=mysql_real_escape_string($_POST['project']);
 $pm=mysql_real_escape_string($_POST['pm']);
 $user=mysql_real_escape_string($_POST['user']);
 $purpose=mysql_real_escape_string($_POST['purpose']);
 $from=mysql_real_escape_string($_POST['from']);
 $to=mysql_real_escape_string($_POST['to']);
 $cabtype=$_POST['cabtype'];
 $cost=$_POST['cost'];
 $date=strtotime($_POST['MDate']);
 $date = date( 'Y-m-d', $date );

 if($pm=="Select" || $pm==""){echo "Billed To Information not correct. Please go back and enter again..."; exit();}
 if($project=="Select" || $project==""){echo "Project Information not correct. Please go back and enter again..."; exit();} 
  
 $cquery="insert into cabbooking(dept,user,purpose,frompl,topl,cabtype,cost,project,billedto,date) values('$dept','$user','$purpose','$from','$to','$cabtype','$cost','$project','$pm','$date')";
 
 $message="Cab request added to car booking master :".$dept." ".$project." ".$pm." ".$user." ".$purpose." ".$from." ".$to." ".$cabtype." ".$cost." "." ".$date;

 if (mysql_query($cquery))
       {
		  //echo "Record created with id :".$row['id']." and description :".$w;
	      header ("Location: cabrequest.php?message=".$message);
	   }
    else
       {
        //echo "Uploadinfo table couldn't be updated.";
		die (mysql_error());
		exit();
	   }
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
 var a = trim(document.getElementById('user').value);
 var b = trim(document.getElementById('purpose').value);
 var c = trim(document.getElementById('from').value);
 var d = trim(document.getElementById('to').value);
 var g = trim(document.getElementById('cabtype').value);
 var h = trim(document.getElementById('cost').value);
 var j = trim(document.getElementById('dept').value);
 var k = trim(document.getElementById('MDate').value);
 
 if(j=="Select"){alert("Please provide dept name"); return false;}
 if(document.getElementById("OpHint").innerHTML==""){alert("Project not selected"); return false;}
 if(document.getElementById("BilledTo").innerHTML=="" || document.getElementById("BilledTo").innerHTML=="Select"){alert("PM not selected"); return false;}
 if(a==""){alert("Please provide username"); return false;}
 if(b==""){alert("Please provide purpose"); return false;}
 if(c==""){alert("Please provide from location"); return false;}
 if(d==""){alert("Please provide to location"); return false;}
 if(g=="Select"){alert("Please provide cabtype"); return false;}
 if(h==""){alert("Please provide cost"); return false;}
 if(k==""){alert("Please provide date"); return false;}
 
 ///var pr=document.getElementByName("OpHint")[0].childNodes; alert(pr);
 //var pm=document.getElementByName('BilledTo').innerHTML; alert(pm);


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
<h6><div id="ResHint"><b></b></div></h6>
<script language="JavaScript" src="datetimepicker.js">
</script>
<form name="tstest" method="post" action="cabrequest.php" onsubmit="return verify()">
<TABLE>
<TR>
<TD>Dept</TD>
<TD><select name="dept" id="dept" size="1" onchange="filloption(this.value)">
<option selected>Select</option>
<option value="LMS">LMS</option>
<option value="Content">Content</option>
<option value="HR">HR</option>
<option value="ADMIN">ADMIN</option>
<option value="IT">IT</option>
<option value="VIVO">VIVO</option>
<option value="SEPG">SEPG</option>
<option value="ODIN">ODIN</option>
<option value="ACCOUNT">ACCOUNT</option>
<option value="PHP">PHP</option>
<option value="BD">BD</option>
</select></TD>
</TR>

<TR>
<td>Project Details</td><td><div name="OpHint" id="OpHint"></div></td>
</TR>

<TR>
<td>Billed To</td><td><div name="BilledTo" id="BilledTo"></div></td>
</TR>

<TR>
<TD>Request from</TD>
<TD><input type="text" name="user" id="user" size="39" maxlength="50"></TD>
</TR>

<TR>
<TD>Purpose</TD>
<TD><textarea name="purpose" id="purpose" rows="3" cols="30"></textarea></TD>
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

<TR>
<TD>Date</TD>
<TD><input type="Text" readonly="readonly" id="MDate" value="" maxlength="20" size="9" name="MDate">
<a href="javascript:NewCal('MDate','ddmmmyyyy')"><img src="cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></TD>
</TR>

<TR>
<TD>Cost</TD>
<TD><input type="text" name="cost" id="cost" size="9"></TD>
</TR>

</TABLE>
<?php
echo "<input type ='hidden' name='loggeduser' value='$username'>";
?>
<input type="button" class="button" value="Log Out" onclick="location.href='logout.php';">
<input type="submit" class="button" value="Add Item Details">
<input type="button" class="button" value="Show All Requests" onclick="showAll()">
</form>
<div id="msgHint"><i><?php $message=$_REQUEST["message"]; echo $message;?></i></div>
<br />
<div id="txtHint"><i>Cab requests will appear here....</i></div>
</br>
</body>
</html> 