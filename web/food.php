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
     echo "<h3>"."Hi ".$row['username']." ! Welcome To Food Ordering Module"."<h3>";
	 $username=$row['username'];
    } 	
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/> 
<script type="text/javascript">
window.onunload = unloadPage;
function editrow(mtr)
{
 //alert(mtr);
 mywindow=window.open ("foodedit.php?id="+mtr,"Ratting","scrollbars=1,width=550,height=170,0,status=0,");
 //if (window.focus) {mywindow.focus()}
}

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
 var v = trim(document.getElementById('vendor_id').value);
 var h = trim(document.getElementById('cost').value);
 var j = trim(document.getElementById('dept').value);
 var k = trim(document.getElementById('MDate').value);
 var l = trim(document.getElementById('menu').value);
 var m = trim(document.getElementById('BilledTo').value);
 
 if(j=="Select"){alert("Please provide dept name"); return false;}
 if(v=="Select"){alert("Please provide vendor name"); return false;}
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
xmlhttp.open("GET","fooddump.php",true);
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
 $dept=mysql_real_escape_string($_POST['dept']);
 $vendor_id=mysql_real_escape_string($_POST['vendor_id']);
 $pm=mysql_real_escape_string($_POST['BilledTo']);
 $user=mysql_real_escape_string($_POST['user']);
 $menu=mysql_real_escape_string($_POST['menu']);
 $cost = $_POST['cost'];
 //$cost=$_POST['cost']*118.94/100;
// $cost=($_POST['cost']*90/100)*114/100;
 $date=strtotime($_POST['MDate']);
 $date = date( 'Y-m-d', $date );
 $cquery="insert into food(dept,user,cost,billedto,date,menu, vendor_id) values('$dept','$user','$cost','$pm','$date','$menu','$vendor_id')";
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
<option value="BD">BD</option>
<option value="ODIN">ODIN</option>
<option value="ACCOUNTS">ACCOUNTS</option>
</select></TD>
</TR>

<TR>
<TD>Vendor</TD>
<TD>
	<select name="vendor_id" id="vendor_id">
		<option value="Select">Select</option>
	<?php
		$result = mysql_query("SELECT * FROM food_vendors ORDER by id ASC", $con) or die(mysql_error());
		if(mysql_num_rows($result) > 0) {
			while($row = mysql_fetch_assoc($result)){
				echo "<option value=".$row['id'].">".$row['vendor']."</option>";
			}
		}
	?>
	</select>

</TD>
</TR>

<TR>
<TD>Billed To</TD>
<TD><input type="text" name="BilledTo" id="BilledTo" size="39" maxlength="50"></TD>
</TR>

<TR>
<TD>Request from</TD>
<TD><input type="text" name="user" id="user" size="39" maxlength="50"></TD>
</TR>

<TR>
<TD>Menu</TD>
<TD><select name="menu" id="menu"   size="1">
<option selected>Select</option>
<option value="Executive Thali">Executive Thali</option>
<option value="Chinese Platter">Chinese Platter</option>
<option value="SouthIndian">South Indian Platter</option>
<option value="Rajma Chawal">Rajma Chawal</option>
<option value="Assorted">Assorted</option>
<option value="Chole Bathura">Chole Bathura</option>
<option value="Pizza">Pizza</option>
<option value="Matar Kulcha">Matar Kulcha</option>
<option value="Pao Bhaji">Pao Bhaji</option>
<option value="Dahi Bhalla">Dahi Bhalla</option>
<option value="Tandoori Platter">Tandoori Platter</option>
<option value="Onion Kulcha">Onion Kulcha</option>
<option value="Grill Sandwich">Grill Sandwich</option>
<option value="Paneer Naan">Paneer Naan</option>
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
<input type="button" value="Log Out" onclick="location.href='logout.php';">
<input type="submit" value="Add Item Details">
<input type="button" value="Show All Requests" onclick="showAll()">
</form>
<br />
<div id="txtHint"><i>Food requests will appear here....</i></div>
</br>
<div id="msgHint"><i><?php echo $message; ?></i></div>
</body>
</html> 