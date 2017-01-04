<html>
<body>
<h1>Admin Tool</h1>
<form name="tstest">
<?PHP
    error_reporting(0);
	include('config.php');

    if(trim($_REQUEST['user'])<>"")
	{
	  $user=sha1(mysql_real_escape_string(trim($_REQUEST['user'])));
	}

    if(trim($_REQUEST['ruser'])<>"")
	{
	  $user=trim($_REQUEST['ruser']);
	}

    $query = "select username from adminlogin where uniqueid='$user';";
    //echo $query;
	$retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Please Contact SEPG; May be You Are Not Registered');
		}

    
    while($row = mysql_fetch_assoc($retval)) 
    { 
     echo "<h3>"."Hi ".$row['username']." ! Welcome To Audit Tracking Tool"."<h3>"; 
    } 
 
?>

<TABLE border=1>
<TR>
	<TD><a href="loginmaster.php?user=<?php echo $user;?>">Fill the Login Table For Users</a></TD>	
</TR>
<TR>
	<TD><a href="projectmaster.php?user=<?php echo $user;?>">Fill Project Master Data with Details.</a></TD>
</TR>
<TR>
	<TD><a href="open.php?user=<?php echo $user;?>">Log Action Item With Finding, NC Types and Date</a></TD>
</TR>
<TR>
	<TD><a href="prelog.php?user=<?php echo $user;?>">Log Preaduit Action Items</a></TD>
</TR>
<TR>
	<TD><a href="sepgupdate.php?user=<?php echo $user;?>">Update Action Item Status with SEPG Comment</a></TD>
</TR>
<TR>
	<TD><a href="changediscussiondate.php?user=<?php echo $user;?>">Change the Discussion Date of action items.</a></TD>
</TR>
<TR>
	<TD><a href="changetarget.php?user=<?php echo $user;?>">Change the Target Date of action items.</a></TD>
</TR>
<TR>
	<TD><a href="changefinding.php?user=<?php echo $user;?>">Change the Finding Description and NC Type</a></TD>
</TR>
<TR>
	<TD><a href="editproj.php?user=<?php echo $user;?>">Change the Project Name in Project Master</a></TD>
</TR>
<TR>
	<TD><a href="addleadfm.php?user=<?php echo $user;?>">Add FM and Lead in Project Master</a></TD>
</TR>
<TR>
	<TD><a href="adddevs.php?user=<?php echo $user;?>">Add Developpers in Project Master</a></TD>
</TR>
<TR>
	<TD><a href="addtesters.php?user=<?php echo $user;?>">Add Testers in Project Master</a></TD>
</TR>
<TR>
	<TD><a href="openoverdue.php?user=<?php echo $user;?>">Open, Closed and Overdue AIs at Org Level</a></TD>
</TR>
<TR>
	<TD><a href="updpmdm.php?user=<?php echo $user;?>">Update PM, DM, BU Head, PH, SH, SL</a></TD>
</TR>
<TR>
	<TD><a href="pipdate.php?user=<?php echo $user;?>">Update PIP Status</a></TD>
</TR>
<TR>
	<TD><a href="selectproject.php?user=<?php echo $user;?>">Update PIN</a></TD>
</TR>
<TR>
	<TD><a href="bugremove.php">Delete Bug</a></TD>
</TR>
<TR>
	<TD><a href="changeowner.php?user=<?php echo $user;?>">Update Owner</a></TD>
</TR>
<TR>
	<TD><a href="addscm.php?user=<?php echo $user;?>">Add SCM To Project</a></TD>
</TR>
<TR>
	<TD><a href="addclient.php?user=<?php echo $user;?>">Add Client SPOC To Project</a></TD>
</TR>
<TR>
	<TD><a href="exportbugs_admin.php?user=<?php echo $user;?>">Export Bugs</a></TD>
</TR>
<TR>
	<TD><a href="archive.php?user=<?php echo $user;?>">Projects Archive/Un-archive</a></TD>
</TR>
</table>
<br>
<br>
<input type="button" value="Login Page" onclick="location.href='masterlogin.html';">
</form>
</body>
</html> 