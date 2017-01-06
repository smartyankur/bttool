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
<html>
<head>
	<script src="js/jquery.js"></script>
	<script>
		function verifiyForm(form){
			if(form.start_date.value == ''){
				alert('Please select Start Date');
				return false;
			}
			if(form.end_date.value == ''){
				alert('Please select End Date');
				return false;
			}
			//prompt('','exportbugs.php?mode=admin_export&q='+$('#project').val()+'&start_date='+$('#start_date').val()+'&end_date='+$('#end_date').val());
			window.open('exportbugs.php?mode=admin_export&q='+$('#project').val()+'&start_date='+$('#start_date').val()+'&end_date='+$('#end_date').val());
			return false;
		}
	</script>
</head>
<body>
<h3>Export Bugs</h3>
<script language="JavaScript" src="datetimepicker.js">
</script>
<form name="export_bugs_form" method="post" onsubmit="return verifiyForm(this);">
	<table>
	<tr>
		<td>Select Project:</td>
		<td>
			<select name="project" id="project">
				<?php
				$query = "select projectname from projectmaster";
				
				$retval = mysql_query( $query);
				$count = mysql_num_rows($retval);
				
				if($count==0)
				{
					die('Data Not Found');
				}
				
				echo "<option value='' selected>All</option>";
				
				if(mysql_num_rows($retval)) 
				{ 
					while($row = mysql_fetch_assoc($retval)) 
					{
						if(strlen($row[projectname])<>0)
						{		 
							echo "<option value=".$row["projectname"].">".$row["projectname"]."</option>"; 
						}
					} 
				
				} 
				else {
					echo "<option>No Names Present</option>";  
				}
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td>Select Start Date:</td>
		<td>
			<input type="Text" id="start_date" value="" maxlength="20" size="9" name="start_date" readonly="readonly">
			<a href="javascript:NewCal('start_date','DDMMYYYY')"><img src="cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
		</td>
	</tr>
	<tr>
		<td>Select End Date:</td>
		<td>
			<input type="Text" id="end_date" value="" maxlength="20" size="9" name="end_date" readonly="readonly">
			<a href="javascript:NewCal('end_date','DDMMYYYY')"><img src="cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
		</td>
	</tr>
	<tr>
		<td></td>
		<td>
			<input type="submit" id="Submit" value="Submit" name="Submit" >
		</td>
	</tr>
	</table>
</form>

<input type="button" value="Main Menu" onclick="document.location = 'admin.php?ruser=<?php echo $user;?>';">
</body>
</html> 