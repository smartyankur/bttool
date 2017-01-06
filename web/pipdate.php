<html>
<head>
<script type="text/javascript">

function submitstatus(str)
{
//alert(str);
var status="stat"+str;
//alert (status);
var qtr=trim(document.getElementById(status).value);
//alert (qtr);

if(qtr=="")
  {
   alert("Response Should Provided"); 
   document.getElementById(status).focus();
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
qtr= encodeURIComponent(qtr);
xmlhttp.open("GET","updatesepgstat.php?q="+str+ "&r="+qtr,true);
xmlhttp.send();

}

function submitresponse(str)
{
//alert(str);
var ptr = trim(document.getElementById(str).value);
//alert(ptr);
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
xmlhttp.open("GET","updatepipstat.php?q="+str+ "&r=" + ptr,true);
xmlhttp.send();

}

function submitacceptance(str)
{
//alert(str);

var ptr = trim(document.getElementById("acc"+str).value);
//alert(ptr);

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
xmlhttp.open("GET","updatepipaccept.php?q="+str+ "&r=" + ptr,true);
xmlhttp.send();

}

function myPopup() {
//window.open( "http://www.google.com/" )
window.open("window-child.html","Ratting","width=550,height=170,0,status=0,");
//alert ("Hi");
}

function showAll()
{
//alert("Hi");
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
xmlhttp.open("GET","updatepip.php",true);
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
<?php	
    $user=mysql_real_escape_string($_REQUEST['user']);
    include('config.php');

	$query = "select username from adminlogin where uniqueid='$user'";
	$retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Data Not Found Please contact SEPG');
		}

    
    while($row = mysql_fetch_assoc($retval)) 
    { 
     echo "<h3>"."Hi ".$row['username']." ! You Can Update PIP Status"."<h3>";
	 $username=$row['username'];
	 //$pwd=$row['pwd'];
    } 	
?>
<h3>Update or Close PIPs Individually</h3>
<script language="JavaScript" src="datetimepicker.js">
</script>
<form name="tstest">
<div id="ResHint"><b></b></div>
<br>
<br>
<input type="button" value="Main Menu" onclick="document.location = 'admin.php?ruser=<?php echo $user;?>';">
<input type="button" value="Show All PIPs" onclick="showAll()">
</form>
<br />
<div id="txtHint"><b>ActionItems will appear here.</b></div>
<?php
mysql_close($con);
?>
</body>
</html> 