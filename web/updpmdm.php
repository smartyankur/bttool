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
 var b=trim(document.forms["tstest"]["pm"].value);
 var c=trim(document.forms["tstest"]["am"].value);
 var d=trim(document.forms["tstest"]["buh"].value); 
 var e=trim(document.forms["tstest"]["ph"].value);
 var f=trim(document.forms["tstest"]["sh"].value);
 var g=trim(document.forms["tstest"]["sl"].value);

if (a=="Select")
  {
  alert("Project must be selected.");
  return false;
  }

if (b=="Select")
  {
  alert("PM must be selected.");
  return false;
  }

if (c=="Select")
  {
  alert("AM must be selected");
  return false;
  }

if (d=="Select")
  {
  alert("BUH must be selected");
  return false;
  }

if (e=="Select")
  {
  alert("PH must be selected");
  return false;
  }

if (f=="Select")
  {
  alert("SH must be selected");
  return false;
  }

 if (g=="Select")
  {
  alert("SL must be selected");
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
     echo "<h3>"."Hi ".$row['username']." ! Update PM,AM,BU Head"."<h3>";
	 $username=$row['username'];
	 //$pwd=$row['pwd'];
    } 	
?>
<body>
<h4>You Can Change PM,AM,BU Head, Practice Head, SEPG Head, SEPG Lead</h4>
<script language="Javascript" src="js/jquery.js"></script>
<script language="JavaScript" src="datetimepicker.js">
</script>
<script>
function getData(){
	var pro_id = document.forms["tstest"]["project"].options[document.forms['tstest']['project'].selectedIndex].getAttribute('ref');
	$.get("getData.php?mode=pm,am,buh,ph,sh,sl&project="+$('#project').val()+"&pro_id="+pro_id, function(data){
			$('#pm').val(data.projectmanager);
			$('#am').val(data.accountmanager);
			$('#buh').val(data.buhead);
			$('#ph').val(data.practicehead);
			$('#sh').val(data.sepghead);
			$('#sl').val(data.sepglead);
		}, "json");
}
</script>
<form name="tstest" action="pdsubmit.php" onsubmit="return validateForm()" method="post">
<TABLE>
<TR>
	<TD>Project Name</TD>
	<td>
    <?php
	
    $query = "select DISTINCT projectname, pindatabaseid from projectmaster";
    
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
<TD>Project Manager</TD>
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

    echo "<select name=\"pm\" id=\"pm\">"; 
    echo "<option size =30 selected>Select</option>";
    
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
<TD>Account Manager</TD>
<TD>
    <?php
	/*$query = "select DISTINCT username from login order by username";
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Users Not Found; Contact SEPG');
		}*/

    echo "<select name=\"am\" id=\"am\">"; 
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
<TD>BU Head</TD>
<TD>
    <?php
	/*$query = "select DISTINCT username from login order by username";
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Users Not Found; Contact SEPG');
		}*/

    echo "<select name=\"buh\" id=\"buh\">"; 
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
<TD>Practice Head</TD>
<TD>
    <?php
	/*$query = "select DISTINCT username from login order by username";
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Users Not Found; Contact SEPG');
		}*/

    echo "<select name=\"ph\" id=\"ph\">"; 
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
<TD>SEPG Head</TD>
<TD>
    <?php
	/*$query = "select DISTINCT username from login order by username";
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Users Not Found; Contact SEPG');
		}*/

    echo "<select name=\"sh\" id=\"sh\">"; 
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
<TD>SEPG Lead</TD>
<TD>
    <?php
	/*$query = "select DISTINCT username from login order by username";
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Users Not Found; Contact SEPG');
		}*/

    echo "<select name=\"sl\" id=\"sl\">"; 
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