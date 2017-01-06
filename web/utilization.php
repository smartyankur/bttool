<html>
<head>
<script type="text/javascript">

function submitresponse(mtr)
{
 //alert(mtr);
 mywindow=window.open ("utedit.php?id="+mtr,"Ratting","scrollbars=1,width=250,height=85,0,status=0,");
 if (window.focus) {mywindow.focus()}
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

function del(str)
{
//str=document.forms["tstest"]["project"].value;
//auditee=document.forms["tstest"]["auditee"].value;
alert (str);
str= encodeURIComponent(str);
if (str=="Select")
{
 alert("Please select the project");
 return; 
}

if (str=="")
  {
  document.getElementById("uxtHint").innerHTML="";
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
    document.getElementById("uxtHint").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","deluts.php?q="+str,true);
xmlhttp.send();

}

function showAll()
{
str=document.forms["tstest"]["DDate"].value;
//auditee=document.forms["tstest"]["auditee"].value;
//alert (str);
//str= encodeURIComponent(str);
if (str=="")
{
 alert("Please select the date");
 return; 
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
xmlhttp.open("GET","getuts.php?q="+str,true);
xmlhttp.send();
}

function showAllUt()
{
str=document.forms["tstest"]["DDate"].value;
usr=document.forms["tstest"]["user"].value;
//auditee=document.forms["tstest"]["auditee"].value;
//alert (str);
//str= encodeURIComponent(str);
if (str=="")
{
 alert("Please select the date");
 return; 
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
xmlhttp.open("GET","getutl.php?q="+str+ "&r=" + usr,true);
xmlhttp.send();
}

function validateForm()
{
 //alert(123);
 var numericExpression = /^[0-9]+$/;
 var a=trim(document.forms["tstest"]["DDate"].value);
 //alert(a);
 if(a=="")
   {
      alert("Please provide the date of utilization");
      return false;
   }
 var a=trim(document.forms["tstest"]["index"].value);   
 //alert(a);
 
 for (i=1; i<=a; i++)
  {
   //alert(i);
   var projone="projone"+i;
   var projtwo="projtwo"+i;
   var projthree="projthree"+i;

   var done="hourone"+i;
   var dtwo="hourtwo"+i;
   var dthree="hourthree"+i;

   //alert(proj);
   var b=trim(document.forms["tstest"][projone].value);
   var c=trim(document.forms["tstest"][projtwo].value);
   var d=trim(document.forms["tstest"][projthree].value);

   var e=trim(document.forms["tstest"][done].value);
   var f=trim(document.forms["tstest"][dtwo].value);
   var g=trim(document.forms["tstest"][dthree].value);
   
   if(b=="Select" || c=="Select" || d=="Select") {alert("Please select project"); return false;}
   
   if(e=="" || e==0) {alert("Provide hours of utilization"); return false;};
   if(!e.match(numericExpression))
			{
			alert("Hours Should be Numeric");
			return false;
			} 
	  
   if(f=="" || f==0) {alert("Provide hours of utilization"); return false;};
   if(!f.match(numericExpression))
			{
			alert("Hours Should be Numeric");
			return false;
			}
	  		   
    if(g=="" || g==0) {alert("Provide hours of utilization"); return false;};
	if(!g.match(numericExpression))
			{
			alert("Hours Should be Numeric");
			return false;
			}
	   
  }
 
 /*
 var b=trim(document.getElementById('tmone').value);
 //alert(b);
 var c=trim(document.getElementById('tmtwo').value);
 //alert(c);
 var d=trim(document.getElementById('tmthree').value); 
 //alert(d);
 var e=trim(document.getElementById('tmfour').value);
 //alert(e);
 var f=trim(document.getElementById('tmfive').value);
 //alert(f);
 var g=trim(document.getElementById('tmsix').value);
 //alert(g);
 var h=trim(document.getElementById('tmseven').value);
 //alert(h);
 var i=trim(document.getElementById('tmeight').value);
 //alert(i);
 var j=trim(document.getElementById('DDateOne').value);
 //alert(j);
 var k=trim(document.getElementById('TDateOne').value);
 //alert(k);
 var l=trim(document.getElementById('DDateTwo').value);
 //alert(l);
 var m=trim(document.getElementById('TDateTwo').value); 
 //alert(m);
 var n=trim(document.getElementById('DDateThree').value);
 //alert(n); 
 var o=trim(document.getElementById('TDateThree').value);
 //alert(o);
 var p=trim(document.getElementById('DDateFour').value);
 //alert(p);
 var q=trim(document.getElementById('TDateFour').value);
 //alert(q);
 var r=trim(document.getElementById('DDateFive').value);
 //alert(r);
 var s=trim(document.getElementById('TDateFive').value); 
 //alert(s);
 var t=trim(document.getElementById('DDateSix').value);
 //alert(t);
 var u=trim(document.getElementById('TDateSix').value);
 //alert(u);
 var v=trim(document.getElementById('DDateSeven').value);
 //alert(v);
 var w=trim(document.getElementById('TDateSeven').value);
 //alert(w);
 var x=trim(document.getElementById('DDateEight').value);
 //alert(x);
 var y=trim(document.getElementById('TDateEight').value);
 //alert(y);

 if(a=="Select")
  {
  alert("Project must be selected.");
  return false;
  }
 
 if(b=="Select")
  {
  alert("TM One must be selected.");
  return false;
  }

 if(b!='NA' && b!="Select")
  {
  if(j=="" || k=="")
	  {
	   alert("Please enter dates for TM One.");
       return false;
      } 
  }

if(c=="Select")
  {
  alert("TM Two must be selected.");
  return false;
  }
 
 if(c!='NA' && c!="Select")
  {
  if(l=="" || m=="")
	  {
	   alert("Please enter dates for TM Two.");
       return false;
      } 
  }

if (d=="Select")
  {
  alert("TM three must be selected");
  return false;
  }
if(d!='NA' && d!="Select")
  {
   if(n=="" || o=="")
	  {
	   alert("Please enter dates for TM Three.");
       return false;
      }   
  }

if (e=="Select")
  {
  alert("TM four must be selected");
  return false;
  }
if(e!='NA' && e!="Select")
  {
   if(p=="" || q=="")
	  {
	   alert("Please enter dates for TM Four.");
       return false;
      } 
  }

if (f=="Select")
  {
  alert("TM five must be selected");
  return false;
  }
if(f!='NA' && f!="Select")
  {
   if(r=="" || s=="")
      {  
	   alert("Please enter dates for TM Five.");
       return false;
	  }
  }

if (g=="Select")
  {
  alert("TM Six be selected");
  return false;
  }
 if(g!='NA' && g!="Select")
  {
   if(t=="" || u=="")
	  {
	   alert("Please enter dates for TM Six.");
       return false;
      }
  }

if (h=="Select")
  {
  alert("TM seven must be selected");
  return false;
  }
 if(h!='NA' && h!="Select")
  {
   if(v=="" || w=="")
	  {
	   alert("Please enter dates for TM Seven.");
       return false;
      } 
  }

if (i=="Select")
  {
  alert("TM eight must be selected");
  return false;
  }
else if(i!='NA' && i!="Select")
  {
   if(x=="" || y=="")
	  {
	   alert("Please enter dates for TM Eight.");
       return false;
	  }
  }
  */
}

</script>
</head>
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

	if($count>0)
	{
		while($row = mysql_fetch_assoc($retval)) 
		{ 
			echo "<h3>"."Hi ".$row['username']." ! Welcome To Utilization Module"."<h3>";
			$username=$row['username'];
		}
	}
	?>
<body background="bg.gif">

<script language="JavaScript" src="datetimepicker.js">
</script>
<form name="tstest" action="utlsubmit.php" onsubmit="return validateForm()" method="post">
<table>
<TR>
<TD>Utilization Date</TD>
<TD><input type="Text" id="DDate" value="" maxlength="20" size="9" name="DDate" readonly="readonly">
<a href="javascript:NewCal('DDate','ddmmmyyyy')"><img src="cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></TD>
</TR>
</table>
<TABLE>
<TR>
	<td>
    <?php
	$query = "select tm from fmtm where fm='$username'";
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Data Not Found');
		}
    $index=0;
    if(mysql_num_rows($retval)) 
    { 
    while($row = mysql_fetch_assoc($retval)) 
    {
	 if(strlen($row[tm])<>0)
		{
		 $index=$index+1;
         echo "<input type ='text' readonly='readonly' name='$index' value='$row[tm]'>";
		 ?>
		 <select name="projone<?php echo $index;?>" size="1">
         <?php
         echo "<option size =30 selected>Select</option>";
         echo "<option size =30>FREE</option>";
		 echo "<option size =30>LEAVE</option>";
         $query1 = "select projectname from projectmaster";
         $retval1 = mysql_query( $query1, $con );
		 if(mysql_num_rows($retval1)) 
			{ 
			while($row1 = mysql_fetch_assoc($retval1)) 
				{
			  if(strlen($row1[projectname])<>0)
				 {		 
					echo "<option>$row1[projectname]</option>"; 
				 }
				} 
 			}
		 ?>
		 &nbsp;&nbsp;<input type="text" name="hourone<?php echo $index;?>" size="2">
		 </select>
		 <select name="projtwo<?php echo $index;?>" size="1">
         <?php
         echo "<option size =30 selected>Select</option>";
		 echo "<option size =30>FREE</option>";
		 echo "<option size =30>LEAVE</option>";
         $query1 = "select projectname from projectmaster";
         $retval1 = mysql_query( $query1, $con );
		 if(mysql_num_rows($retval1)) 
			{ 
			while($row1 = mysql_fetch_assoc($retval1)) 
				{
			  if(strlen($row1[projectname])<>0)
				 {		 
					echo "<option>$row1[projectname]</option>"; 
				 }
				} 
 			}
		 ?>
		 &nbsp;&nbsp;<input type="text" name="hourtwo<?php echo $index;?>" size="2">
		 </select>
		 <select name="projthree<?php echo $index;?>" size="1">
		 <?php
         echo "<option size =30 selected>Select</option>";
		 echo "<option size =30>FREE</option>";
		 echo "<option size =30>LEAVE</option>";
         $query1 = "select projectname from projectmaster";
         $retval1 = mysql_query( $query1, $con );
		 if(mysql_num_rows($retval1)) 
			{ 
			while($row1 = mysql_fetch_assoc($retval1)) 
				{
			  if(strlen($row1[projectname])<>0)
				 {		 
					echo "<option>$row1[projectname]</option>"; 
				 }
				} 
 			}
          ?> 
         &nbsp;&nbsp;<input type="text" name="hourthree<?php echo $index;?>" size="2">
		 </select>
		 <?php
		 echo "</br>";
         echo "</br>";
		}
	} 
     
//echo "Count of rows :".$index;
    } 
    else {
    echo "<option>No Names Present</option>";  
    } 
    ?>
    
</td>
</TR>
</TABLE>
<input type="submit"/>
<?php
echo "<input type ='hidden' name='user' value='$username'>";
echo "<input type ='hidden' name='index' value='$index'>";
?>
<input type="button" value="Log Out" onclick="location.href='logout.php';">
<input type="button" value="Show All Records" onclick="showAll()">
<input type="button" value="Get Utilization" onclick="showAllUt()">
</form>
<div id="uxtHint"></div>
<div id="txtHint">All records will appear here.</div>
</body>
</html> 