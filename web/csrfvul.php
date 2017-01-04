<html>
<head>
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
			die('Session data not found please contact SEPG');
		}

    
    while($row = mysql_fetch_assoc($retval)) 
    { 
     echo "<h4>"."Hi ".$row['username']." ! Welcome To BUG Reporting Tool"."</h4>";
	 $username=$row['username'];
    } 	
?>
</head>
<body background="bg.gif">
<script type="text/javascript">

function saverec()
{
 //alert(123);

 var numericExpression = /^[0-9]+$/;
 var symbol = trim(document.getElementById('symbol').value);
 var shares = trim(document.getElementById('shares').value);
 
 //alert(symbol);
 //alert(shares);
 
 if(symbol=="select")
  {
  alert("Symbol must be selected");
  return false;
  }

 if(shares=="")
  {
  alert("Number of shareshould be provided");
  return false;
  }

 if(!shares.match(numericExpression))
  {
  alert("Shares Should be Numeric");
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
    document.getElementById("ResHint").innerHTML=xmlhttp.responseText;
    }
  }
 xmlhttp.open("GET","buy.php?q="+symbol+"&r="+shares,true);
 xmlhttp.send();
 
}

function showAll()
{
//newwindow.close();
str=document.forms["tstest"]["symbol"].value;
//alert (str);

if (str=="select")
  {
  alert("Symbol must be selected");
  return false;
  }

if (str=="")
  {
  document.getElementById("txtHint").innerHTML="";
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
    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","getallbuy.php?q="+str,true);
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

<form name="tstest" action="buy.php" onsubmit="return verify()" method="post">
<div id="ResHint">Results of buying will appear here.</div>
</br>
</br>
<TABLE>
<TR>
<TD>Symbol</TD><TD><select name="symbol" size="1" id="symbol">
<option value="select" selected>Select</option>
<option value="RIL">RIL</option>
<option value="BILT">BILT</option>
<option value="IOC">IOC</option>
</select></TD>
</TR>

<TR>
<TD>Number of shares</TD>
<TD><input type=text maxlength=20 size=20 name="shares" id="shares"></TD>
</TR>
</TABLE>

<input type="button" value="Buy" onclick="return saverec()">
<input type="button" value="Log Out" onclick="location.href='logout.php';">
<input type="button" value="Show All Transactions" onclick="showAll()">

</br>
</br>
<div id="txtHint">Previous transaction records will appear here.</div>
</form>
</body>
</html> 