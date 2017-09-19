<html>
<head>
<script type="text/javascript">
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

function validateForm()
{
 
 var a=trim(document.forms["tstest"]["project"].value);
 var b=trim(document.getElementById('devone').value);
 var c=trim(document.getElementById('devtwo').value);
 var d=trim(document.getElementById('devthree').value); 
 var e=trim(document.getElementById('devfour').value);
 var f=trim(document.getElementById('devfive').value);
 var g=trim(document.getElementById('devsix').value);
 var h=trim(document.getElementById('devseven').value);
 var i=trim(document.getElementById('deveight').value);
 var j=trim(document.getElementById('devnine').value);
 var k=trim(document.getElementById('devten').value);
 var l=trim(document.getElementById('develeven').value);
 var m=trim(document.getElementById('devtwelve').value);
 var n=trim(document.getElementById('devthirteen').value);
 var o=trim(document.getElementById('devfourteen').value);
 var p=trim(document.getElementById('devfifteen').value);
 var q=trim(document.getElementById('devsixteen').value);
 var r=trim(document.getElementById('devseventeen').value);
 var s=trim(document.getElementById('deveighteen').value);
 var t=trim(document.getElementById('devninteen').value);
 var u=trim(document.getElementById('devtwenty').value);
 var v=trim(document.getElementById('devtwentyone').value);
 var w=trim(document.getElementById('devtwentytwo').value);
 var x=trim(document.getElementById('devtwentythree').value);
 var y=trim(document.getElementById('devtwentyfour').value);
 var z=trim(document.getElementById('devtwentyfive').value);

if (a=="Select")
  {
  alert("Project must be selected.");
  return false;
  }

if (b=="Select")
  {
  alert("Dev one must be selected.");
  return false;
  }

if (c=="Select")
  {
  alert("Dev two must be selected");
  return false;
  }

if (d=="Select")
  {
  alert("Dev three must be selected");
  return false;
  }

if (e=="Select")
  {
  alert("Dev four must be selected");
  return false;
  }

if (f=="Select")
  {
  alert("Dev five must be selected");
  return false;
  }

 if (g=="Select")
  {
  alert("Dev Six be selected");
  return false;
  }

if (h=="Select")
  {
  alert("Dev seven must be selected");
  return false;
  }

if (i=="Select")
  {
  alert("Dev eight must be selected");
  return false;
  }
}
</script>
</head>
<?php	
	$user=mysql_real_escape_string($_REQUEST['user']);
	include("config.php");

	$query = "select username from adminlogin where uniqueid='$user'";
	$retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Data Not Found Please contact SEPG');
		}

    
    while($row = mysql_fetch_assoc($retval)) 
    { 
     echo "<h3>"."Hi ".$row['username']." ! You Can Add Developers Here."."<h3>";
	 $username=$row['username'];
	 //$pwd=$row['pwd'];
    } 	
?>
<body>

<script language="Javascript" src="js/jquery.js"></script>
<script language="JavaScript" src="datetimepicker.js">
</script>
<script>
function getData(){
	var pro_id = document.forms["tstest"]["project"].options[document.forms['tstest']['project'].selectedIndex].getAttribute('ref');
	$.get("getData.php?mode=developers&project="+$('#project').val()+"&pro_id="+pro_id, function(data){
			$('#devone').val(data.dev1);
			$('#devtwo').val(data.dev2);
			$('#devthree').val(data.dev3);
			$('#devfour').val(data.dev4);
			$('#devfive').val(data.dev5);
			$('#devsix').val(data.dev6);
			$('#devseven').val(data.dev7);
			$('#deveight').val(data.dev8);
			$('#devnine').val(data.dev9);
			$('#devten').val(data.dev10);
			$('#develeven').val(data.dev11);
			$('#devtwelve').val(data.dev12);
			$('#devthirteen').val(data.dev13);
			$('#devfourteen').val(data.dev14);
			$('#devfifteen').val(data.dev15);
			$('#devsisteen').val(data.dev16);
			$('#devseventeen').val(data.dev17);
			$('#deveighteen').val(data.dev18);
			$('#devninteen').val(data.dev19);
			$('#devtwenty').val(data.dev20);
			$('#devtwentyone').val(data.dev21);
			$('#devtwentytwo').val(data.dev22);
			$('#devtwentythree').val(data.dev23);
			$('#devtwentyfour').val(data.dev24);
			$('#devtwentyfive').val(data.dev25);
		}, "json");
}
</script>
<form name="tstest" action="devsubmit.php" onsubmit="return validateForm()" method="post">
<TABLE>
<TR>
	<TD>Project Name</TD>
	<td>
    <?php
	
    $query = "select DISTINCT projectname, pindatabaseid from projectmaster order by projectname";
    
	$retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Data Not Found');
		}

    echo "<select name=\"project\" id=\"project\" onChange=\"getData();\">"; 
    echo "<option size =30 selected>Select</option>";
    echo "<option size =30>NA</option>";
	if(mysql_num_rows($retval)) 
    { 
    while($row = mysql_fetch_assoc($retval)) 
    {
	 if(strlen($row[projectname])<>0)
		{		 
         echo "<option ref='".$row['pindatabaseid']."' value='".$row['pindatabaseid']."'>$row[projectname]</option>"; 
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
<TD>Dev One</TD>
<TD>
    <?php
	$query = "select DISTINCT username from login order by username";
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	$tmp = array();
	if($count==0)
		{
			die('Users Not Found; Contact SEPG');
		}

    echo "<select name=\"devone\" id=\"devone\">"; 
    echo "<option size =30 selected>Select</option>";
    echo "<option size =30>NA</option>";
	if(mysql_num_rows($retval)) 
    { 
    while($row = mysql_fetch_assoc($retval)) 
    { 
		if($row['username'] == '') continue; 
		$tmp[] = $row['username'];
		echo "<option>$row[username]</option>"; 
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
<TD>Dev Two</TD>
<TD>
    <?php
	/*$query = "select DISTINCT username from login order by username";
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Users Not Found; Contact SEPG');
		}*/

    echo "<select name=\"devtwo\" id=\"devtwo\">"; 
    echo "<option size =30 selected>Select</option>";
    echo "<option size =30>NA</option>";
	if(count($tmp) > 0) 
    { 
		foreach($tmp as $val) 
		{ 
			if($val == '') continue;
			echo "<option>$val</option>"; 
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
<TD>Dev Three</TD>
<TD>
    <?php
	/*$query = "select DISTINCT username from login order by username";
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Users Not Found; Contact SEPG');
		}*/

    echo "<select name=\"devthree\" id=\"devthree\">"; 
    echo "<option size =30 selected>Select</option>";
    echo "<option size =30>NA</option>";
	if(count($tmp) > 0) 
    { 
		foreach($tmp as $val) 
		{ 
			if($val == '') continue;
			echo "<option>$val</option>"; 
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
<TD>Dev Four</TD>
<TD>
    <?php
	/*$query = "select DISTINCT username from login order by username";
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Users Not Found; Contact SEPG');
		}*/

    echo "<select name=\"devfour\" id=\"devfour\">"; 
    echo "<option size =30 selected>Select</option>";
    echo "<option size =30>NA</option>";
	if(count($tmp) > 0) 
    { 
		foreach($tmp as $val) 
		{ 
			if($val == '') continue;
			echo "<option>$val</option>"; 
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
<TD>Dev Five</TD>
<TD>
    <?php
	/*$query = "select DISTINCT username from login order by username";
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Users Not Found; Contact SEPG');
		}*/

    echo "<select name=\"devfive\" id=\"devfive\">"; 
    echo "<option size =30 selected>Select</option>";
    echo "<option size =30>NA</option>";
	if(count($tmp) > 0) 
    { 
		foreach($tmp as $val) 
		{ 
			if($val == '') continue;
			echo "<option>$val</option>"; 
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
<TD>Dev Six</TD>
<TD>
    <?php
	/*$query = "select DISTINCT username from login order by username";
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Users Not Found; Contact SEPG');
		}*/

    echo "<select name=\"devsix\" id=\"devsix\">"; 
    echo "<option size =30 selected>Select</option>";
    echo "<option size =30>NA</option>";
	if(count($tmp) > 0) 
    { 
		foreach($tmp as $val) 
		{ 
			if($val == '') continue;
			echo "<option>$val</option>"; 
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
<TD>Dev Seven</TD>
<TD>
    <?php
	/*$query = "select DISTINCT username from login order by username";
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Users Not Found; Contact SEPG');
		}*/

    echo "<select name=\"devseven\" id=\"devseven\">"; 
    echo "<option size =30 selected>Select</option>";
    echo "<option size =30>NA</option>";
	if(count($tmp) > 0) 
    { 
		foreach($tmp as $val) 
		{ 
			if($val == '') continue;
			echo "<option>$val</option>"; 
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
<TD>Dev Eight</TD>
<TD>
    <?php
	/*$query = "select DISTINCT username from login order by username";
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Users Not Found; Contact SEPG');
		}*/

    echo "<select name=\"deveight\" id=\"deveight\">"; 
    echo "<option size =30 selected>Select</option>";
    echo "<option size =30>NA</option>";
	if(count($tmp) > 0) 
    { 
		foreach($tmp as $val) 
		{ 
			if($val == '') continue;
			echo "<option>$val</option>"; 
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
<TD>Dev Nine</TD>
<TD>
    <?php
	/*$query = "select DISTINCT username from login order by username";
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Users Not Found; Contact SEPG');
		}*/

    echo "<select name=\"devnine\" id=\"devnine\">"; 
    echo "<option size =30 selected>Select</option>";
    echo "<option size =30>NA</option>";
	if(count($tmp) > 0) 
    { 
		foreach($tmp as $val) 
		{ 
			if($val == '') continue;
			echo "<option>$val</option>"; 
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
<TD>Dev Ten</TD>
<TD>
    <?php
	/*$query = "select DISTINCT username from login order by username";
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Users Not Found; Contact SEPG');
		}*/

    echo "<select name=\"devten\" id=\"devten\">"; 
    echo "<option size =30 selected>Select</option>";
    echo "<option size =30>NA</option>";
	if(count($tmp) > 0) 
    { 
		foreach($tmp as $val) 
		{ 
			if($val == '') continue;
			echo "<option>$val</option>"; 
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
<TD>Dev Eleven</TD>
<TD>
    <?php
	/*$query = "select DISTINCT username from login order by username";
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Users Not Found; Contact SEPG');
		}*/

    echo "<select name=\"develeven\" id=\"develeven\">"; 
    echo "<option size =30 selected>Select</option>";
    echo "<option size =30>NA</option>";
	if(count($tmp) > 0) 
    { 
		foreach($tmp as $val) 
		{ 
			if($val == '') continue;
			echo "<option>$val</option>"; 
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
<TD>Dev Twelve</TD>
<TD>
    <?php
    echo "<select name=\"devtwelve\" id=\"devtwelve\">"; 
    echo "<option size =30 selected>Select</option>";
    echo "<option size =30>NA</option>";
	if(count($tmp) > 0) 
    { 
		foreach($tmp as $val) 
		{ 
			if($val == '') continue;
			echo "<option>$val</option>"; 
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
<TD>Dev Thirteen</TD>
<TD>
<?php
    echo "<select name=\"devthirteen\" id=\"devthirteen\">"; 
    echo "<option size =30 selected>Select</option>";
    echo "<option size =30>NA</option>";
	if(count($tmp) > 0) 
	{ 
		foreach($tmp as $val) 
		{ 
			if($val == '') continue;
			echo "<option>$val</option>"; 
		} 
	} else {
		echo "<option>No Names Present</option>";  
	} 
?>
</TD>
</TR>
<TR>
<TD>Dev Fourteen</TD>
<TD>
<?php
    echo "<select name=\"devfourteen\" id=\"devfourteen\">"; 
    echo "<option size =30 selected>Select</option>";
    echo "<option size =30>NA</option>";
	if(count($tmp) > 0) 
	{ 
		foreach($tmp as $val) 
		{ 
			if($val == '') continue;
			echo "<option>$val</option>"; 
		} 
	} else {
		echo "<option>No Names Present</option>";  
	} 
?>
</TD>
</TR>
<TR>
<TD>Dev Fifteen</TD>
<TD>
<?php
    echo "<select name=\"devfiveteen\" id=\"devfiveteen\">"; 
    echo "<option size =30 selected>Select</option>";
    echo "<option size =30>NA</option>";
	if(count($tmp) > 0) 
	{ 
		foreach($tmp as $val) 
		{ 
			if($val == '') continue;
			echo "<option>$val</option>"; 
		} 
	} else {
		echo "<option>No Names Present</option>";  
	} 
?>
</TD>
</TR>
<TR>
<TD>Dev Sixteen</TD>
<TD>
<?php
    echo "<select name=\"devsixteen\" id=\"devsixteen\">"; 
    echo "<option size =30 selected>Select</option>";
    echo "<option size =30>NA</option>";
	if(count($tmp) > 0) 
	{ 
		foreach($tmp as $val) 
		{ 
			if($val == '') continue;
			echo "<option>$val</option>"; 
		} 
	} else {
		echo "<option>No Names Present</option>";  
	} 
?>
</TD>
</TR>
<TR>
<TD>Dev Seventeen</TD>
<TD>
<?php
    echo "<select name=\"devseventeen\" id=\"devseventeen\">"; 
    echo "<option size =30 selected>Select</option>";
    echo "<option size =30>NA</option>";
	if(count($tmp) > 0) 
	{ 
		foreach($tmp as $val) 
		{ 
			if($val == '') continue;
			echo "<option>$val</option>"; 
		} 
	} else {
		echo "<option>No Names Present</option>";  
	} 
?>
</TD>
</TR>
<TR>
<TD>Dev Eightteen</TD>
<TD>
<?php
    echo "<select name=\"deveighteen\" id=\"deveighteen\">"; 
    echo "<option size =30 selected>Select</option>";
    echo "<option size =30>NA</option>";
	if(count($tmp) > 0) 
	{ 
		foreach($tmp as $val) 
		{ 
			if($val == '') continue;
			echo "<option>$val</option>"; 
		} 
	} else {
		echo "<option>No Names Present</option>";  
	} 
?>
</TD>
</TR>
<TR>
<TD>Dev Ninteen</TD>
<TD>
<?php
    echo "<select name=\"devninteen\" id=\"devninteen\">"; 
    echo "<option size =30 selected>Select</option>";
    echo "<option size =30>NA</option>";
	if(count($tmp) > 0) 
	{ 
		foreach($tmp as $val) 
		{ 
			if($val == '') continue;
			echo "<option>$val</option>"; 
		} 
	} else {
		echo "<option>No Names Present</option>";  
	} 
?>
</TD>
</TR>
<TR>
<TD>Dev Twenty</TD>
<TD>
<?php
    echo "<select name=\"devtwenty\" id=\"devtwenty\">"; 
    echo "<option size =30 selected>Select</option>";
    echo "<option size =30>NA</option>";
	if(count($tmp) > 0) 
	{ 
		foreach($tmp as $val) 
		{ 
			if($val == '') continue;
			echo "<option>$val</option>"; 
		} 
	} else {
		echo "<option>No Names Present</option>";  
	} 
?>
</TD>
</TR>
<TR>
<TD>Dev TwentyOne</TD>
<TD>
<?php
    echo "<select name=\"devtwentyone\" id=\"devtwentyone\">"; 
    echo "<option size =30 selected>Select</option>";
    echo "<option size =30>NA</option>";
	if(count($tmp) > 0) 
	{ 
		foreach($tmp as $val) 
		{ 
			if($val == '') continue;
			echo "<option>$val</option>"; 
		} 
	} else {
		echo "<option>No Names Present</option>";  
	} 
?>
</TD>
</TR>
<TR>
<TD>Dev Twentytwo</TD>
<TD>
<?php
    echo "<select name=\"devtwentytwo\" id=\"devtwentytwo\">"; 
    echo "<option size=30 selected>Select</option>";
    echo "<option size =30>NA</option>";
	if(count($tmp) > 0) 
	{ 
		foreach($tmp as $val) 
		{ 
			if($val == '') continue;
			echo "<option>$val</option>"; 
		} 
	} else {
		echo "<option>No Names Present</option>";  
	} 
?>
</TD>
</TR>
<TR>
<TD>Dev Twentythree</TD>
<TD>
<?php
    echo "<select name=\"devtwentythree\" id=\"devtwentythree\">"; 
    echo "<option size =30 selected>Select</option>";
    echo "<option size =30>NA</option>";
	if(count($tmp) > 0) 
	{ 
		foreach($tmp as $val) 
		{ 
			if($val == '') continue;
			echo "<option>$val</option>"; 
		} 
	} else {
		echo "<option>No Names Present</option>";  
	} 
?>
</TD>
</TR>
<TR>
<TD>Dev Twentyfour</TD>
<TD>
<?php
    echo "<select name=\"devtwentyfour\" id=\"devtwentyfour\">"; 
    echo "<option size =30 selected>Select</option>";
    echo "<option size =30>NA</option>";
	if(count($tmp) > 0) 
	{ 
		foreach($tmp as $val) 
		{ 
			if($val == '') continue;
			echo "<option>$val</option>"; 
		} 
	} else {
		echo "<option>No Names Present</option>";  
	} 
?>
</TD>
</TR>
<TR>
<TD>Dev Twentyfive</TD>
<TD>
<?php
    echo "<select name=\"devtwentyfive\" id=\"devtwentyfive\">"; 
    echo "<option size =30 selected>Select</option>";
    echo "<option size =30>NA</option>";
	if(count($tmp) > 0) 
	{ 
		foreach($tmp as $val) 
		{ 
			if($val == '') continue;
			echo "<option>$val</option>"; 
		} 
	} else {
		echo "<option>No Names Present</option>";  
	} 
?>
</TD>
</TR>
</TABLE>
<input type="submit"/>
<?php
echo "<input type ='hidden' name='adminuser' value='$user'>";
?>
<input type="button" value="Main Menu" onclick="document.location = 'admin.php?ruser=<?php echo $user;?>';">
</form>
</body>
</html> 