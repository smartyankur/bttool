<html>
<head>
<script>
function validateForm() {

var x=document.getElementById('project').value;
var y=document.getElementById('spoc').value;

if (y=="Select")
 {
  alert("SPOC should be selected");
  return false;
 }

if (x=="Select")
 {
  alert("Project name must be selected");
  document.getElementById('spoc').focus();
  return false;
 }

}
</script>
</head>
<body>
<?php
    error_reporting(0);
	$con = mysql_connect("localhost","root","password");
    $user=mysql_real_escape_string($_REQUEST['user']);
    
    if (!$con)
      {
        die('Could not connect: ' . mysql_error());
      }
    mysql_select_db("audit") or die(mysql_error());

	
	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
     $spoc=$_REQUEST['spoc'];
     $projectname=mysql_real_escape_string(trim($_REQUEST['project']));
     $equery="update projectmaster set clientspoc='".$spoc."' where projectname ='".$projectname."'";    
     $eresult=mysql_query($equery, $con) or die (mysql_error());
     $msg="<b>"."The spoc has been updated"."</b>"."</br>";
	} 
	
	$query = "select username from adminlogin where uniqueid='$user'";
	$retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
	{
	 die('Data Not Found Please contact SEPG');
	}

    while($row = mysql_fetch_assoc($retval)) 
    { 
     echo "<h3>"."Hi ".$row['username']." ! You Can ADD Client SPOC Name"."<h3>";
	 $username=$row['username'];
	 //$pwd=$row['pwd'];
    } 	
?>
<h3>Update Projectname</h3>
<script language="Javascript" src="js/jquery.js"></script>
<script language="JavaScript" src="datetimepicker.js">
</script>
<script>
function getData(){
	$.get("getData.php?mode=clientSPOC&project="+$('#project').val(), function(data){
			$('#spoc').val(data.clientspoc);
		}, "json");
}
</script>
<form name="tstest" action="addclient.php" onsubmit="return validateForm()" method="post">
<br>
<TABLE>
<TR>
	<TD>Project Name</TD>
	<TD>
    <?php
	$query = "select DISTINCT projectname from projectmaster";
	$retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Data Not Found');
		}

    echo "<select name=\"project\" id=\"project\" onChange=\"getData();\">"; 
    echo "<option size =30 selected value=\"Select\">Select</option>";
    
	if(mysql_num_rows($retval)) 
    { 
    while($row = mysql_fetch_assoc($retval)) 
    { 
    echo "<option>$row[projectname]</option>"; 
    } 
 
    } 
    else {
    echo "<option>No Names Present</option>";  
    } 
    ?>
    </TD>
</TR>

<TR>
<TD>Client SPOC Name</TD>
<TD><?php
	$query = "select DISTINCT username from login order by username";
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Users Not Found; Contact SEPG');
		}

    echo "<select name=\"spoc\" id=\"spoc\">"; 
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

<br>
<br>
<input type="button" value="Main Menu" onclick="document.location = 'admin.php?ruser=<?php echo $user;?>';">
<input type ='hidden' name='user' value='<?php echo $user;?>'>
<input type="submit"/>
</form>
</br>
<?php
echo $msg;
echo $cmsg;
echo $mmsg;
?>
</body>
</html> 