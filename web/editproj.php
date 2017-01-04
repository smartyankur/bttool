<html>
<head>
<script src="js/jquery.js"></script>
<script>
function validateForm() {

var x=document.getElementById('projectname').value;
var pro_id = document.forms["tstest"]["project"].options[document.forms['tstest']['project'].selectedIndex].getAttribute('ref');
$("#pro_id_hidden").val(pro_id);
var y=document.getElementById('project').value;

if (y=="Select")
 {
  alert("Project should be selected");
  return false;
 }

if (x=="")
 {
  alert("Projectname must be filled");
  document.getElementById('projectname').focus();
  return false;
 }

}
</script>
</head>
<body>
<?php
    error_reporting(0);
	$user=mysql_real_escape_string($_REQUEST['user']);
	include("config.php");

	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
     $project=$_REQUEST['project'];
	 $projectname=mysql_real_escape_string(trim($_REQUEST['projectname']));
     $equery="update projectmaster set projectname='".$projectname."' where projectname = '".$project."'";    
     $eresult=mysql_query($equery, $con) or die (mysql_error());
     $msg="<b>"."The projectname has been updated"."</b>"."</br>";
	 
     $cquery="select * from mommaster where projectname ='".$project."'";
	 $cresult=mysql_query($cquery, $con) or die (mysql_error());
     $ccount=mysql_num_rows($cresult);
	 //$cmsg="<b>"."The number of rows of project in mommaster :".$ccount."</b>";
	 
	 if($ccount>0)
		{
         $uquery="update mommaster set projectname='".$projectname."' where projectname ='".$project."'";
		 $uresult=mysql_query($uquery, $con) or die (mysql_error());
		 $cmsg="</br>"."<b>"."MOM records have been updated"."</b>"."</br>";
		}

	 $mquery="select * from actionitem where projectname ='".$project."'";
	 $mresult=mysql_query($mquery, $con) or die (mysql_error());
     $mcount=mysql_num_rows($mresult);
	 //$mmsg="<b>"."The number of rows of project in actionitem :".$mcount."</b>";
     
	 if($mcount>0)
		{
         $aquery="update actionitem set projectname='".$projectname."' where projectname ='".$project."'";
		 $aresult=mysql_query($aquery, $con) or die (mysql_error());
		 $mmsg="<b>"."Actionitem records have been updated"."</b>";
		}

     $qquery="select * from qcuploadinfo where project='".$project."'";
	 $qresult=mysql_query($qquery, $con) or die (mysql_error());
     $qcount=mysql_num_rows($qresult);
	 //$mmsg="<b>"."The number of rows of project in actionitem :".$mcount."</b>";
     
	 if($qcount>0)
		{
         $rquery="update qcuploadinfo set project='".$projectname."' where project='".$project."'";
		 $rresult=mysql_query($rquery, $con) or die (mysql_error());
		 $qmsg="<b>"."QC item records have been updated"."</b>";
		}
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
     echo "<h3>"."Hi ".$row['username']." ! You Can Update Project Name"."<h3>";
	 $username=$row['username'];
	 //$pwd=$row['pwd'];
    } 	
?>
<h3>Update Projectname</h3>
<script language="JavaScript" src="datetimepicker.js">
</script>
<form name="tstest" action="editproj.php" onsubmit="return validateForm()" method="post">
<br>
<TABLE>
<TR>
	<TD>Project Name</TD>
	<TD>
    <?php
	$query = "select DISTINCT projectname, pindatabaseid from projectmaster where projectmanager= '$username' or accountmanager= '$username' or buhead='$username' or practicehead='$username' or sepghead='$username' or sepglead='$username' order by projectname";
	$retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Data Not Found');
		}

    echo "<select name=\"project\" id=\"project\">"; 
    echo "<option size =30 selected value=\"Select\">Select</option>";
    
	if(mysql_num_rows($retval)) 
    { 
    while($row = mysql_fetch_assoc($retval)) 
    { 
    echo "<option ref='".$row['pindatabaseid']."'>$row[projectname]</option>"; 
    } 
 
    } 
    else {
    echo "<option>No Names Present</option>";  
    } 
    ?>
    </TD>
	<input type="hidden" name="pro_id" id="pro_id_hidden" value="" />
</TR>

<TR>
<TD>Project Name</TD>
<TD><input type=text maxlength=100 size=50 name="projectname" id="projectname"></TD>
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
echo "</br>";
echo $qmsg;
?>
</body>
</html> 