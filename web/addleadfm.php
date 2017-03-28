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
 var b=trim(document.forms["tstest"]["lead"].value);
 var c=trim(document.forms["tstest"]["fmone"].value);
 var d=trim(document.forms["tstest"]["fmtwo"].value); 
 var e=trim(document.forms["tstest"]["fmthree"].value);
 var f=trim(document.forms["tstest"]["fmfour"].value);
 var g=trim(document.forms["tstest"]["ceo"].value);
 var h=trim(document.forms["tstest"]["md"].value);

if (a=="Select")
  {
  alert("Project must be selected.");
  return false;
  }

if (b=="Select")
  {
  alert("Lead must be selected.");
  return false;
  }

if (c=="Select")
  {
  alert("FM One must be selected");
  return false;
  }

if (d=="Select")
  {
  alert("FM Two must be selected");
  return false;
  }

if (e=="Select")
  {
  alert("FM Three must be selected");
  return false;
  }

if (f=="Select")
  {
  alert("FM Four must be selected");
  return false;
  }

 if (g=="Select")
  {
  alert("CEO must be selected");
  return false;
  }

if (h=="Select")
  {
  alert("MD Four must be selected");
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
     echo "<h3>"."Hi ".$row['username']." ! You Can Add Lead and FM"."<h3>";
	 $username=$row['username'];
	 //$pwd=$row['pwd'];
    } 	
?>
<body>
<h3>Add Lead, FM, CEO and MD for the projects.</h3>
<script language="Javascript" src="js/jquery.js"></script>
<script language="JavaScript" src="datetimepicker.js">
</script>
<script>
function getData(){
	var pro_id = document.forms["tstest"]["project"].options[document.forms['tstest']['project'].selectedIndex].getAttribute('ref');
	$.get("getData.php?mode=lead,fm,ceo,md&project="+$('#project').val()+"&pro_id="+pro_id, function(data){
			$('#lead').val(data.lead);
			$('#fmone').val(data.fmone);
			$('#fmtwo').val(data.fmtwo);
			$('#fmthree').val(data.fmthree);
			$('#fmfour').val(data.fmfour);
			$('#ceo').val(data.ceo);
			$('#md').val(data.md);
		}, "json");
}
</script>
<form name="tstest" action="lfsubmit.php" onsubmit="return validateForm()" method="post">
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
         echo "<option ref='".$row['pindatabaseid']."'>$row[projectname]</option>"; 
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
<TD>Project Lead</TD>
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

    echo "<select name=\"lead\" id=\"lead\">"; 
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
<TD>ID FM</TD>
<TD>
    <?php
	/*$query = "select DISTINCT username from login order by username";
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Users Not Found; Contact SEPG');
		}*/

    echo "<select name=\"fmone\" id=\"fmone\">"; 
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
<TD>Media FM</TD>
<TD>
    <?php
	/*$query = "select DISTINCT username from login order by username";
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Users Not Found; Contact SEPG');
		}*/

    echo "<select name=\"fmtwo\" id=\"fmtwo\">"; 
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
<TD>Tech FM</TD>
<TD>
    <?php
	/*$query = "select DISTINCT username from login order by username";
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Users Not Found; Contact SEPG');
		}*/

    echo "<select name=\"fmthree\" id=\"fmthree\">"; 
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
<TD>QC FM</TD>
<TD>
    <?php
	/*$query = "select DISTINCT username from login order by username";
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Users Not Found; Contact SEPG');
		}*/

    echo "<select name=\"fmfour\" id=\"fmfour\">"; 
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
<TD>CEO</TD>
<TD>
    <?php
	/*$query = "select DISTINCT username from login order by username";
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Users Not Found; Contact SEPG');
		}*/

    echo "<select name=\"ceo\" id=\"ceo\">"; 
    echo "<option size =30 selected>Select</option>";
    
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
<TD>MD</TD>
<TD>
    <?php
	/*$query = "select DISTINCT username from login order by username";
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Users Not Found; Contact SEPG');
		}*/

    echo "<select name=\"md\" id=\"md\">"; 
    echo "<option size =30 selected>Select</option>";
    
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