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
 var decimalExpression = /^[0-9. ]+$/;
 //var alphaExp = /^[a-zA-Z /s]*$/;
 //var alphanumericExp = /^[0-9a-zA-Z._, /s]*$/;
 var a = trim(document.getElementById('item').value);
 var b = trim(document.getElementById('meau').value);
 var d = trim(document.getElementById('quantity').value);
 //alert(a);
 //alert(b);
 //alert(d);
 //alert(e);
 //alert(f);
 //alert(g);
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
//newwindow.close();
str=document.forms["tstest"]["item"].value;
//alert (str);

if (str=="")
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
xmlhttp.open("GET","admindump.php?q="+str,true);
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
 $meau=$_POST['meau'];
 $quantity=(double)$_POST['quantity'];
 //$message=$item."+".$action."+".$quantity."+".$cash."+".$remarks;

 $cquery="select * from register where item='$item'";
 $cretval = mysql_query( $cquery, $con ) or die (mysql_error());
 $count = mysql_num_rows($cretval);
 
 if($count>0) {$message="This item already exists. To change the qunatity contact Internal Quality";}
 else{
 $iquery="insert into register(item,measuringunit,currentquantity) values('$item','$meau','$quantity')";
 $iretval = mysql_query( $iquery, $con ) or die (mysql_error());	   
 $message=$item." added to inventory updated with quantity :".$quantity;
 }
 }
?>
<h6><div id="ResHint"><b></b></div></h6>
<script language="JavaScript" src="datetimepicker.js">
</script>
<form name="tstest" method="post" action="additem.php" onsubmit="return verify()">
<TABLE>
<TR>
<TD>Item Name</TD>
<TD><input type="text" name="item" id="item"  size="40" maxlength="40" value="<?php echo $item;?>"></TD>
</TR>

<TR>
<TD>Measuring Unit</TD>
<TD><select name="meau" id="meau"   size="1">
<option value="Select" selected>Select</option>
<option value="Packets">Packets</option>
<option value="Cans">Cans</option>
<option value="Pieces">Pieces</option>
<option value="Bottles">Bottles</option>
<option value="KG">KG</option>
<option value="Liters">Liters</option>
<option value="Rolls">Rolls</option>
<option value="Tubes">Tubes</option>
<option value="Pouch">Pouch</option>
<option value="Sachet">Sachet</option>
</select></TD>
</TR>

<TR>
<TD>Quantity</TD>
<TD><input type="text" name="quantity" id="quantity" size="3"></TD>
</TR>

</TABLE>
<?php
echo "<input type ='hidden' name='loggeduser' value='$username'>";
?>
<input type="button" class="button" value="Log Out" onclick="location.href='logout.php';">
<input type="submit" class="button" value="Add Item Details">
<input type="button" class="button" value="Show All Item Status" onclick="showAll()">
</form>
<br />
<div id="txtHint"><i>Store records will appear here....</i></div>
</br>
<div id="msgHint"><i><?php echo $message; ?></i></div>
</body>
</html> 