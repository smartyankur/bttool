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
       echo "<h3>"."Hi ".$row['username']." ! Welcome To Store Maintenance Module"."<h3>";
	 $username=$row['username'];
    } 	
?>
<html>
<head>
<script type="text/javascript">
window.onunload = unloadPage;


function verify()
{
 //alert(123);
 var numericExpression = /^[0-9]+$/;
 var decimalExpression = /^[0-9.]+$/;
 //var alphaExp = /^[a-zA-Z /s]*$/;
 //var alphanumericExp = /^[0-9a-zA-Z._, /s]*$/;
 var a = trim(document.getElementById('item').value);
 var b = trim(document.getElementById('actiontype').value);
 var d = trim(document.getElementById('quantity').value);
 var e = trim(document.getElementById('cash').value);
 var f = trim(document.getElementById('remarks').value);
 //alert(a);
 //alert(b);
 //alert(d);
 //alert(e);
 //alert(f);
 //alert(g);

if(a=="Select" || a=="ALL") {alert("Please select item"); return false;}
if(b=="Select") {alert("Please select action"); return false;}
if(d=="") {alert("Please provide quantity"); return false;}
//if(d>g){alert("Please provide lesser amount"); return false;}
if(b=="Receive" && e=="") {alert("Please provide cash amount"); return false;}
if(f=="") {alert("Please provide remarks"); return false;}
if(b=="Issue" && e!="") {alert("Please keep cash box blank"); return false;}

if(!d.match(decimalExpression))
  {
  alert("Quantity Should be Numeric or Decimal");
  return false;
  }

if(b=="Receive" && !e.match(decimalExpression))
  {
  alert("Cash Should be Numeric or Decimal");
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
//newwindow.close();
str=document.forms["tstest"]["item"].value;
//alert (str);

if (str=="Select")
  {
  alert("Item must be selected");
  document.forms["tstest"]["project"].focus();
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
xmlhttp.open("GET","admintran.php?q="+str,true);
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
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
 //$message = "somebody posted the form";
 $item=$_POST['item'];
 $action=$_POST['actiontype'];
 $quantity=(double)$_POST['quantity'];
 $action=$_POST['actiontype'];
 $cash=(double)$_POST['cash'];
 $date=date('Y-m-d',time());
 $remarks=$_POST['remarks'];
 //$message=$item."+".$action."+".$quantity."+".$cash."+".$remarks;

 if($action=="Issue"){
 $query="select currentquantity from register where item='$item'";
 $retval = mysql_query( $query, $con );
 while($row = mysql_fetch_assoc($retval)) 
    { 
     $inv=$row['currentquantity'];
    }
  if($inv<$quantity)
	 {
      $message="Not enough balance....";
	 }
  if($inv>$quantity)
	 {
       $iquery="insert into admintran(item,action,quantity,date,user) values('$item','$action','$quantity','$date','$username')";
       $iretval = mysql_query( $iquery, $con ) or die (mysql_error());	   
	   $rest=$inv-$quantity; 
	   $query="update register set currentquantity='$rest' where item='$item'";
       $retval = mysql_query( $query, $con ) or die (mysql_error());
	   $message="Inventory updated for :".$item." Current quantity is :".$rest;
	  }
 }

 if($action=="Receive"){
 $iquery="insert into admintran(item,action,quantity,cash,date,user) values('$item','$action','$quantity','$cash','$date','$username')";
 $iretval = mysql_query( $iquery, $con ) or die (mysql_error());
 $query="select currentquantity from register where item='$item'";
 $retval = mysql_query( $query, $con );
 while($row = mysql_fetch_assoc($retval)) 
    { 
     $inv=$row['currentquantity'];
    }
  
  $finq=$inv+$quantity;
  //$cash=$cash;
  $query="update register set currentquantity='$finq' where item='$item'";
  $retval = mysql_query( $query, $con ) or die (mysql_error());
  $message="Inventory updated for :".$item." Current quantity is :".$finq;
 }
}
?>
<h6><div id="ResHint"><b></b></div></h6>
<script language="JavaScript" src="datetimepicker.js">
</script>
<form name="tstest" method="post" action="storein.php" onsubmit="return verify()">
<TABLE>
<TR>
<TD>Item Name</TD>
<TD>
    <?php
	$query = "select item from register";
    //echo $query;
	$retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Data Not Found; Contact SEPG');
		}

    echo "<select name=\"item\" id=\"item\"  onchange=\"getitem()\">"; 
    echo "<option size =30 selected>Select</option>";
    echo "<option size =30>ALL</option>";
	if(mysql_num_rows($retval)) 
    { 
    while($row = mysql_fetch_assoc($retval)) 
    { 
    echo "<option>$row[item]</option>"; 
    } 
    } 
    else 
	{
     echo "<option>No Names Present</option>";  
    } 
    ?>
    </TD>
</TR>

<TR>
<TD>Action</TD>
<TD><select name="actiontype" id="actiontype"   size="1">
<option value="Select" selected>Select</option>
<option value="Issue">Issue</option>
<option value="Receive">Receive</option>
</select></TD>
</TR>

<TR><td>Current Qty</td><td><div name="fmHint" id="fmHint"><?php echo $fmdetails;?></div></td></TR>

<TR>
<TD>Issue or Received Quantity</TD>
<TD><input type="text" name="quantity" id="quantity" size="3"></TD>
</TR>

<TR>
<TD>Cash(While receiving only)</TD>
<TD><input type="text" name="cash" id="cash"  size="3"><i>While issuing it can be kept blank</i></TD>
</TR>

<TR>
<TD>Remarks</TD>
<TD><input type="text" name="remarks" id="remarks"  size="20" value="General requirement"></TD>
</TR>

<TR><td><i>Instruction</i></td><td><i>: Issue will subtract from and receive will add to the current quantity.</i></td></TR>

</TABLE>
<?php
echo "<input type ='hidden' name='loggeduser' value='$username'>";
?>
<input type="button" class="button" value="Log Out" onclick="location.href='logout.php';">
<input type="submit" class="button" value="Add Item Details">
<input type="button" class="button" value="Show All Transactions" onclick="showAll()">
</form>
<br />
<div id="txtHint"><i>Store records will appear here....</i></div>
</br>
<div id="msgHint"><i><?php echo $message; ?></i></div>
</body>
</html> 