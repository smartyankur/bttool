<?php	
    error_reporting(0);
	session_start();
	
	if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	header ("Location:index.php");
    }
	
	$con = mysql_connect("localhost","root","password");
    //$user=$_SESSION['login'];

    if (!$con)
    {
        die('Could not connect: ' . mysql_error());
    }

	mysql_select_db("audit") or die(mysql_error());

$id=$_REQUEST['id'];
//echo "id ".$id;
$equery="select * from food where id='$id'";
$eresult = mysql_query( $equery, $con );
$count = mysql_num_rows($eresult);
	
if($count==0)
	{
	die('Data Not Found Please contact SEPG');
	}

while($row = mysql_fetch_assoc($eresult)) 
    { 
     //echo "<h4>"."Hi ".$row['username']." ! Welcome To BUG Sheet Upload Tool"."</h4>";
    $dept=$row['dept'];
	//echo "Dept ".$dept;
	$billedto=$row['billedto'];
    $requestfrom=$row['user'];
	$menu=$row['menu'];
	$date=$row['date'];
	$w=strtotime($date);
    $date= date( 'd-M-Y', $w );
	$cost=$row['cost'];
    }
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
 $dept=mysql_real_escape_string($_POST['dept']);
 $pm=mysql_real_escape_string($_POST['BilledTo']);
 $user=mysql_real_escape_string($_POST['user']);
 $menu=mysql_real_escape_string($_POST['menu']);
 $id=$_POST['id'];
 $cost=$_POST['cost'];
 $date=strtotime($_POST['MDate']);
 $date = date( 'Y-m-d', $date );
 //$cquery="insert into food(dept,user,cost,billedto,date,menu) values('$dept','$user','$cost','$pm','$date','$menu')";
 //echo $cquery;
 $cquery="update food set dept='$dept',user='$user',cost='$cost',billedto='$pm',date='$date',menu='$menu' where id='$id'";
 //$cretval=mysql_query( $cquery, $con ) or die (mysql_error());
 $message="Row updated for :".$dept." ".$pm." ".$user." ".$cost." "." ".$date." ".$menu;

 if (mysql_query($cquery))
       {
		  //echo "Record created with id :".$row['id']." and description :".$w;
	      header ("Location: foodedit.php?id=".$id."&message=".urlencode($message));
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
<h6><div id="ResHint"><b></b></div></h6>
<script language="JavaScript" src="datetimepicker.js">
</script>
<form name="tstest" method="post" action="foodedit.php" onsubmit="return verify()">
<?php
$msg=$_REQUEST["message"];
?>
<TABLE>

<TR>
<TD>Dept</TD>
<TD><select name="dept" id="dept" size="1" onchange="filloption(this.value)">
<option selected>Select</option>
<option value="LMS"<?php if($dept=='LMS') echo " selected";?>>LMS</option>
<option value="Content"<?php if($dept=='Content') echo " selected";?>>Content</option>
<option value="HR"<?php if($dept=='HR') echo " selected";?>>HR</option>
<option value="ADMIN"<?php if($dept=='ADMIN') echo " selected";?>>ADMIN</option>
<option value="IT"<?php if($dept=='IT') echo " selected";?>>IT</option>
<option value="VIVO"<?php if($dept=='VIVO') echo " selected";?>>VIVO</option>
<option value="SEPG"<?php if($dept=='SEPG') echo " selected";?>>SEPG</option>
<option value="BD"<?php if($dept=='BD') echo " selected";?>>BD</option>
<option value="ODIN"<?php if($dept=='ODIN') echo " selected";?>>ODIN</option>
<option value="ACCOUNTS"<?php if($dept=='ACCOUNTS') echo " selected";?>>ACCOUNTS</option>
</select></TD>
</TR>

<TR>
<TD>Billed To</TD>
<TD><input type="text" name="BilledTo" id="BilledTo" size="39" maxlength="50" value="<?php echo $billedto;?>"></TD>
</TR>

<TR>
<TD>Request from</TD>
<TD><input type="text" name="user" id="user" size="39" maxlength="50" value="<?php echo $requestfrom;?>"></TD>
</TR>

<TR>
<TD>Menu</TD>
<TD><select name="menu" id="menu" size="1">
<option selected>Select</option>
<option value="Executive Thali"<?php if($menu=='Executive Thali') echo " selected";?>>Executive Thali</option>
<option value="Chinese Platter"<?php if($menu=='Chinese Platter') echo " selected";?>>Chinese Platter</option>
<option value="SouthIndian"<?php if($menu=='SouthIndian') echo " selected";?>>South Indian Platter</option>
<option value="Rajma Chawal"<?php if($menu=='Rajma Chawal') echo " selected";?>>Rajma Chawal</option>
<option value="Assorted"<?php if($menu=='Assorted') echo " selected";?>>Assorted</option>
</select></TD>
</TR>

<TR>
<TD>Date</TD>
<TD><input type="Text" readonly="readonly" id="MDate" value="<?php echo $date;?>" maxlength="20" size="9" name="MDate">
<a href="javascript:NewCal('MDate','ddmmmyyyy')"><img src="cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></TD>
</TR>

<TR>
<TD>Cost</TD>
<TD><input type="text" name="cost" id="cost" size="9" value="<?php echo $cost?>"></TD>
</TR>

</TABLE>
<?php
echo "<input type ='hidden' name='id' value='$id'>";
?>
<input type="submit" value="Add Item Details">
</form>
<div id="txtHint"><i></i></div>
<div id="msgHint"><i><?php echo $msg; ?></i></div>
</body>
</html> 