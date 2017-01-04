<html>
<body>
<h1>Admin Tool</h1>
<?PHP
    error_reporting(1);
	include("config.php");

    if(trim($_REQUEST['user'])<>"")
	{
	  $user=mysql_real_escape_string(trim($_REQUEST['user']));
	}

    

    $query = "select username from adminlogin where uniqueid='$user';";
	$retval = mysql_query( $query);
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
<script src="js/jquery.js"></script>
<script type="text/javascript">
/* @saurav Modify to do process using project id */
function showarchivedone(pro_id) {
	var user_id = '<?php echo $user ?>';
	mywindow=window.open("archivedone.php?pro_id="+pro_id+"&q="+user_id,'Archive','width=500,height=500,scrollbars=no');
	if (window.focus) {mywindow.focus()}
	
}

function showunarchivedone(pro_id) {
	var user_id = '<?php echo $user ?>';
	mywindow=window.open ("unarchivedone.php?pro_id="+pro_id+"&q="+user_id,'UnArchive','width=500,height=500,scrollbars=no');
	if (window.focus) {mywindow.focus()}
	
}
</script>
<table width='50%' border='1' cellspacing='0' cellpadding='5'>
  <tr><th>Project</th><th>Project Startdate</th><th>Project Enddate</th><th>Action</th></tr>
	<?php
    $query = "select projectname, pindatabaseid, projectstartdate, projectenddate, is_archive from projectmaster order by projectname";
	$retval = mysql_query( $query);
    $count = mysql_num_rows($retval);
	while($row = mysql_fetch_assoc($retval)){ 
      if($row['projectname'] == '') continue;
	  echo "<tr>";
      echo "<td>".$row['projectname']."</td>";
      echo "<td>".$row['projectstartdate']."</td>";
      echo "<td>".$row['projectenddate']."</td>";
	  if($row['is_archive'] == 1) {
		echo "<td><a href='javascript:void(0);' onclick='showunarchivedone(".$row['pindatabaseid'].");'>Unarchive</a></td>"; 
	  } else {
		echo "<td><a href='javascript:void(0);' onclick='showarchivedone(".$row['pindatabaseid'].");'>Archive</a></td>";
	  }
	  
	  echo "</tr>";
    }
?>
</table>
<br>
<input type="button" class="button" value="Back" onclick="location.href='admin.php?ruser=<?php echo $user; ?>';">
</body>
</html> 