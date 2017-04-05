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
 var b=trim(document.getElementById('tone').value);
 var c=trim(document.getElementById('ttwo').value);
 var d=trim(document.getElementById('tthree').value); 
 var e=trim(document.getElementById('tfour').value);
 var f=trim(document.getElementById('tfive').value);
 var g=trim(document.getElementById('tsix').value);
 var h=trim(document.getElementById('tseven').value);
 var i=trim(document.getElementById('teight').value);

if (a=="Select")
  {
  alert("Project must be selected.");
  return false;
  }

if (b=="Select")
  {
  alert("Tester one must be selected.");
  return false;
  }

if (c=="Select")
  {
  alert("Tester two must be selected");
  return false;
  }

if (d=="Select")
  {
  alert("Tester three must be selected");
  return false;
  }

if (e=="Select")
  {
  alert("Tester four must be selected");
  return false;
  }

if (f=="Select")
  {
  alert("Tester five must be selected");
  return false;
  }

if (g=="Select")
  {
  alert("Tester six must be selected");
  return false;
  }

if (h=="Select")
  {
  alert("Tester seven must be selected");
  return false;
  }

if (i=="Select")
  {
  alert("Tester eight must be selected");
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
     echo "<h3>"."Hi ".$row['username']." ! You Can Add Testers Here."."<h3>";
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
	$.get("getData.php?mode=testers&project="+$('#project').val()+"&pro_id="+pro_id, function(data){
			$('#tone').val(data.tester1);
			$('#ttwo').val(data.tester2);
			$('#tthree').val(data.tester3);
			$('#tfour').val(data.tester4);
			$('#tfive').val(data.tester5);
			$('#tsix').val(data.tester6);
			$('#tseven').val(data.tester7);
			$('#teight').val(data.tester8);
		}, "json");
}
</script>

<form name="tstest" action="testersubmit.php" onsubmit="return validateForm()" method="post">
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
<TD>Tester One</TD>
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

    echo "<select name=\"tone\" id=\"tone\">"; 
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
<TD>Tester Two</TD>
<TD>
    <?php
	/*$query = "select DISTINCT username from login order by username";
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Users Not Found; Contact SEPG');
		}*/

    echo "<select name=\"ttwo\" id=\"ttwo\">"; 
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
<TD>Tester Three</TD>
<TD>
    <?php
	/*$query = "select DISTINCT username from login order by username";
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Users Not Found; Contact SEPG');
		}*/

    echo "<select name=\"tthree\" id=\"tthree\">"; 
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
<TD>Tester Four</TD>
<TD>
    <?php
	/*$query = "select DISTINCT username from login order by username";
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Users Not Found; Contact SEPG');
		}*/

    echo "<select name=\"tfour\" id=\"tfour\">"; 
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
<TD>Tester Five</TD>
<TD>
    <?php
	/*$query = "select DISTINCT username from login order by username";
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Users Not Found; Contact SEPG');
		}*/

    echo "<select name=\"tfive\" id=\"tfive\">"; 
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
<TD>Tester Six</TD>
<TD>
    <?php
	/*$query = "select DISTINCT username from login order by username";
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Users Not Found; Contact SEPG');
		}*/

    echo "<select name=\"tsix\" id=\"tsix\">"; 
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
<TD>Tester Seven</TD>
<TD>
    <?php
	/*$query = "select DISTINCT username from login order by username";
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Users Not Found; Contact SEPG');
		}*/

    echo "<select name=\"tseven\" id=\"tseven\">"; 
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
<TD>Tester Eight</TD>
<TD>
    <?php
	/*$query = "select DISTINCT username from login order by username";
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Users Not Found; Contact SEPG');
		}*/

    echo "<select name=\"teight\" id=\"teight\">"; 
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
</TABLE>
<input type="submit"/>
<?php
echo "<input type ='hidden' name='adminuser' value='$user'>";
?>
<input type="button" value="Main Menu" onclick="document.location = 'admin.php?ruser=<?php echo $user;?>';">
</form>
</body>
</html> 