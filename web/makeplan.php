<?php	
      error_reporting(0);
	session_start();
	
	if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	header ("Location:index.php");
    }
	
    $user=$_SESSION['login'];

    include('config.php');

    $query = "select username,email from login where uniqueid='$user'";
    
	$retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
	{
			die('Data Not Found Please contact SEPG');
	}

    
    while($row = mysql_fetch_assoc($retval)) 
    { 
     echo "<br>";
     echo "<br>";
	 echo "<h3>"."Hi ".$row['username']." ! Welcome To Task Acceptance Interface"."</h3>";
	 $username=$row['username'];
	 $email=$row['email'];
    } 	
?>
<html>
<head>
<script type="text/javascript">

window.onunload = unloadPage;

function unloadPage()
{
 newwindow.close();
}

function verify()
{
 var decimalExpression = /^[0-9.]+$/;
 var task = trim(document.getElementById('task').value);
 var qc = trim(document.getElementById('qc').value);
 var effort = trim(document.getElementById('effort').value);
 var SDate = trim(document.getElementById('SDate').value);
 var EDate = trim(document.getElementById('EDate').value);
  
 if(task == ""){alert("Please mention task name"); return false;}
 if(qc == "select"){alert("Please mention QC details"); return false;}
 if(SDate == ""){alert("Please mention start Date"); return false;}
 if(EDate == ""){alert("Please mention end Date"); return false;}
 if(effort == ""){alert("Please mention effort"); return false;}
 
 if(!effort.match(decimalExpression))
  {
	alert("Effort Should be Purely Decimal");
	return false;
  }
}

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

</script>
<style type="text/css">
body
{
background:url('qcr.jpg') no-repeat;
}
.button
{
background-color: #F7941C;
border-bottom:#F7941C;
border-left: #F7941C;
border-right:#F7941C;
border-top: #F7941C;
color: black;
font-family: Tahoma
box-shadow:2px 2px 0 0 #014D06,;
border-radius: 10px;
border: 1px outset #b37d00 ;
}
</style>
</head>
<body>
<script language="JavaScript" src="datetimepicker.js">
</script>
<form name="tstest" method="post" onsubmit="return verify()" action="distsubmit.php">

<?php
$id=$_REQUEST["id"];
$mid=$_REQUEST["mid"];

$qr="select project,task,round,status from projecttask where id='".$mid."'";
$retval = mysql_query( $qr, $con );

while($row = mysql_fetch_assoc($retval)) 
{
  $project = $row['project']; 
  $task = $row['task'];
  $str=str_replace('\n',"&#10;",$task);
  $strfin=str_replace('\r'," ",$str);
  $round=$row['round'];
  $status=$row['status'];
}
 
if($status<>"accepted")
{
  die("Status is not appropriate for planning");
}

$abz="select effort from accept where masterid='$mid' and indx='$id'";
$cdz=mysql_query($abz,$con);
$efz=mysql_fetch_assoc($cdz);
$eff=$efz['effort'];

$cons="select SUM(effort)from qcplan where masterid='$mid' and indx='$id'";
$consr=mysql_query($cons,$con);
$conse=mysql_fetch_assoc($consr);
$consumed=$conse['SUM(effort)'];

$rest=$eff-$consumed;

$deldt="select DDate from qcreq where id='$mid' and indx='$id'";
$retdt = mysql_query( $deldt, $con );
$rowdt = mysql_fetch_assoc($retdt);
$Deliverydate = $rowdt['DDate'];
echo "ID :".$mid." AND Delivery Date: ".$Deliverydate." Effort Remaining".$rest;
?>

<TABLE>
<TR>
<TD>Work Packet</TD>
<TD><textarea name="task" rows="10" cols="40" id="task"><?php echo $strfin;?></textarea></TD>
</TR>
<TR>
<TD></TD>
<TD><i>Use Only: Alphabet,Integer,Single Space and Period</i></TD>
</TR>
<TR>
<TD>Planned Start Date</TD>
<TD><input type="Text" readonly="readonly" id="SDate" value="" maxlength="20" size="17" name="SDate">
<a href="javascript:NewCal('SDate','ddmmmyyyy',true,24)"><img src="cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></TD>
</TR>
<TR>
<TD>Planned End Date</TD>
<TD><input type="Text" readonly="readonly" id="EDate" value="" maxlength="20" size="17" name="EDate">
<a href="javascript:NewCal('EDate','ddmmmyyyy',true,24)"><img src="cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></TD>
</TR>
<TR>
<TD>QC</TD>
<TD>
 <?php
	$query = "select DISTINCT username from login where role='QC' order by username";
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Users Not Found; Contact SEPG');
		}

    echo "<select name=\"qc\" id=\"qc\">"; 
    echo "<option size =30 selected value=\"select\">Select</option>";
    
	if(mysql_num_rows($retval)) 
    { 
    while($row = mysql_fetch_assoc($retval)) 
    { 
     if(strlen($row[username])<>0)
		{
		 ?>
			<option><?php echo $row[username];?></option> 
         <?php 
		}
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
<TD>Planned Test-Effort(QC)</TD>
<TD><input type="Text" id="effort" maxlength="5" size="5" name="effort" value="<?php echo $effort;?>">Hours</TD>
</TR>
</TABLE>
<?php
echo "<input type ='hidden' name='loggeduser' value='$username'>";
echo "<input type ='hidden' name='email' value='$email'>";
echo "<input type ='hidden' name='masterid' value='$mid'>";
echo "<input type ='hidden' name='id' value='$id'>";
echo "<input type ='hidden' name='round' value='$round'>";
echo "<input type ='hidden' name='deldate' value='$Deliverydate'>";
echo "<input type ='hidden' name='project' value='$project'>";
echo "<input type ='hidden' name='remaining' value='$rest'>"; //why this is used
?>
<input type="submit" class="button" value="Add Details">
</form>
<br/>
</body>
</html> 