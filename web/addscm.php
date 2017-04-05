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
var b=trim(document.forms["tstest"]["scm"].value);
 
if (a=="Select")
  {
  alert("Project must be selected.");
  return false;
  }

if (b=="Select")
  {
  alert("SCM must be selected.");
  return false;
  }

}
</script>
</head>
<?php	
	
    $user=mysql_real_escape_string($_REQUEST['user']);
    include('config.php');

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
<h3>Add SCM for the projects.</h3>
<script language="Javascript" src="js/jquery.js"></script>
<script language="JavaScript" src="datetimepicker.js">
</script>
<script>
function getData(){
	$.get("getData.php?mode=scm&project="+$('#project').val(), function(data){
			$('#scm').val(data.scm);
			$('#scmtwo').val(data.scmtwo);
		}, "json");
}
</script>
<form name="tstest" action="scmsubmit.php" onsubmit="return validateForm()" method="post">
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
<TD>SCM</TD>
<TD>
    <?php
	$query = "select DISTINCT username from login order by username";
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Users Not Found; Contact SEPG');
		}

    echo "<select name=\"scm\" id=\"scm\">"; 
    echo "<option size =30 selected>Select</option>";
    echo "<option size =30>NA</option>";
    
	if(mysql_num_rows($retval)) 
    { 
    while($row = mysql_fetch_assoc($retval)) 
    { 
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
<TD>SCM TWO</TD>
<TD>
    <?php
	$query = "select DISTINCT username from login order by username";
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Users Not Found; Contact SEPG');
		}

    echo "<select name=\"scmtwo\" id=\"scmtwo\">"; 
    echo "<option size =30 selected>Select</option>";
    echo "<option size =30>NA</option>";
    
	if(mysql_num_rows($retval)) 
    { 
    while($row = mysql_fetch_assoc($retval)) 
    { 
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

</TABLE>
<input type="submit"/>
<?php
echo "<input type ='hidden' name='adminuser' value='$user'>";
?>
<input type="button" value="Main Menu" onclick="document.location = 'admin.php?ruser=<?php echo $user;?>';">
</form>
</body>
</html> 