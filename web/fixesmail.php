<body >
<?php
error_reporting(0);
session_start();
if(!(isset($_SESSION['login']) && $_SESSION['login'] != '')){
  header ("Location:index.php");
}
$user = $_SESSION['login'];

include("config.php");

$query = "select username, role from login where uniqueid='$user'";
$retval = mysql_query( $query, $con );
$count = mysql_num_rows($retval);

if($count==0){
  die('Data Not Found Please contact SEPG');
}
while($row = mysql_fetch_assoc($retval)){ 
  
  $username = $row['username'];
  $userrole = $row['role'];  
}
$pro=$_REQUEST['pro'];
//$phs=$_REQUEST['phs'];
$pro_id = $_REQUEST['pro_id'];
$course = explode("-", $_REQUEST['chd']);

$pro=mysql_real_escape_string($pro);
/* @saurav changed query to fetch data using project_id */
$query="select projectmanager,fmone,fmtwo,fmthree,fmfour,dev1,dev2,dev3,dev4,dev5,dev6,dev7,dev8,dev9,dev10,dev11,dev12,tfr.id,tfr.course_title from projectmaster join tbl_functional_review tfr on tfr.project_id = projectmaster.pindatabaseid where pindatabaseid='$pro_id' and tfr.id='$course[0]'";
$result=mysql_query($query) or die (mysql_error());

while($row = mysql_fetch_assoc($result)) { 
    $pm=$row['projectmanager'];
	$fmone=$row['fmone'];
    $fmtwo=$row['fmtwo'];
	$fmthree=$row['fmthree'];
    $dev1=$row['dev1'];
    $dev2=$row['dev2'];
    $dev3=$row['dev3'];
    $dev4=$row['dev4'];
    $dev5=$row['dev5'];
    $dev6=$row['dev6'];
    $dev7=$row['dev7'];
    $deb8=$row['dev8'];
    $dev9=$row['dev9'];
    $dev10=$row['dev10'];
    $dev11=$row['dev11'];
    $dev12=$row['dev12'];
    $chd_id=$row['id'];
    $course_title=$row['course_title'];
}

/* @saurav modify script to merge 5 query in one */
$mquery = "select email, username from login where username IN('$pm', '$fmone', '$fmtwo', '$fmthree', '$fmfour', '$dev1', '$dev2', '$dev3', '$dev4', '$dev5', '$dev6', '$dev7', '$dev8', '$dev9', '$dev10', '$dev11', '$dev12')";
$mresult=mysql_query($mquery) or die (mysql_error());
$tmp = array();
while($mrow = mysql_fetch_assoc($mresult)) { 
    $tmp[$mrow['username']] = $mrow['email'];
} 	


/* @saurav To Merge 4 query in one and fetch data using project_id */
$bug_status_query = "select bugstatus, count(*) from qcuploadinfo where project_id='$pro_id' and chd_id = '$course[0]' group by `bugstatus`";
$bug_result = mysql_query($bug_status_query) or die (mysql_error());
	
while($bug_row = mysql_fetch_assoc($bug_result))  { 
	if($bug_row['bugstatus'] == "open")
		$open = $bug_row['count(*)'];
	else if($bug_row['bugstatus'] == "hold")
		$hold = $bug_row['count(*)'];
	else if ($bug_row['bugstatus'] == "closed")
		$closed = $bug_row['count(*)'];
	else if ($bug_row['bugstatus'] == "ok as is")
		$okasis = $bug_row['count(*)'];
	else if ($bug_row['bugstatus'] == "fixed")
		$fixed = $bug_row['count(*)'];
	else if ($bug_row['bugstatus'] == "reopened")
		$reopened = $bug_row['count(*)'];
}

$total = $open + $hold + $closed + $okasis + $fixed + $reopened;
/* @saurav end */


mysql_close($con);
?>
<script type="text/javascript" src="http://js.nicedit.com/nicEdit-latest.js"></script> <script type="text/javascript">
//<![CDATA[
        bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
  //]]>
</script>
<script>
function verify()
{
var mail = trim(document.getElementById('pmmail').value);
var msg = trim(document.getElementById('msg').value);
//var alphaExp = /^[a-zA-Z /s]*$/;
var alphaExp = /^[0-9a-zA-Z._, .:/s]*$/;
if(mail=="")
  {
  alert("Mail ID must be provided");
  return false;
  }

if(msg=="")
  {
  alert("Message must be provided");
  return false;
  }

// if(!msg.match(alphaExp))
  // {
  // alert("Please dont use special characters.");
  // return false;
  // }
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
<form name="tstest" action="./mailSend.php" onsubmit="return verify()" method="post" enctype="multipart/form-data">
<table>
<TR><h3><?php echo "CHD NUMBER- ".$chd_id." - ".$pro." - ".$course_title." - Fixes Completed"; ?></h3></TR>
<TR>If PM/FM or their eMail informations are blank/incorrect, use "Change PM/FM Details" and "Create or Change email ID of PM/FM"</TR>
<TR>
<TD><?php if(trim($pm)<>"" || trim($pm)<>'NA') echo "TO :"?></TD>
<TD><input type="email" size=66 name="pmmail" id="pmmail" value="<?php echo $tmp[$pm];?>"></TD><TD>PM</TD>
</TR>
<TR>
<TD><?php if(trim($fmone)<>"" || trim($fmone)<>'NA') echo "Cc :"?></TD>
<TD><input type="email" size=66 name="fmonemail" id="fmonemail" value="<?php echo $tmp[$fmone];?>"></TD><TD>ID FM</TD>
</TR>

<TR>
<TD><?php if(trim($fmtwo)<>"" || trim($fmtwo)<>'NA') echo "Cc :"?></TD>
<TD><input type="email" size=66 name="fmtwomail" id="fmtwomail" value="<?php echo $tmp[$fmtwo];?>"></TD><TD>MED FM</TD>
</TR>

<TR>
<TD><?php if(trim($fmthree)<>"" || trim($fmthree)<>'NA') echo "Cc :"?></TD>
<TD><input type="email" size=66 name="fmthreemail" id="fmthreemail" value="<?php echo $tmp[$fmthree];?>"></TD><TD>SCR FM</TD>
</TR>

<TR>
<TD><?php if(trim($fmfour)<>"" || trim($fmfour)<>'NA') echo "Cc :"?></TD>
<TD><input type="text" size=66 name="qc" id="qc" value="<?php echo $tmp[$fmfour];?>"></TD><TD>QC FM</TD>
</TR>

<TR>
<TD><?php if(trim($dev1)<>"" || trim($dev1)<>'NA') echo "Cc :";?></TD>
<?php
	$dev_tmp = array();
	$dev_email_str = '';
	if($dev1 != '' || $dev1 != 'NA')
		$dev_tmp[] = $dev1;
	if($dev2 != '' || $dev2 != 'NA')
		$dev_tmp[] = $dev2;
	if($dev3 != '' || $dev3 != 'NA')
		$dev_tmp[] = $dev3;
	if($dev4 != '' || $dev4 != 'NA')
		$dev_tmp[] = $dev4;
	if($dev5 != '' || $dev5 != 'NA')
		$dev_tmp[] = $dev5;
	if($dev6 != '' || $dev6 != 'NA')
		$dev_tmp[] = $dev6;
	if($dev7 != '' || $dev7 != 'NA')
		$dev_tmp[] = $dev7;
	if($dev8 != '' || $dev8 != 'NA')
		$dev_tmp[] = $dev8;
	if($dev9 != '' || $dev9 != 'NA')
		$dev_tmp[] = $dev9;
	if($dev10 != '' || $dev10 != 'NA')
		$dev_tmp[] = $dev10;
	if($dev11 != '' || $dev11 != 'NA')
		$dev_tmp[] = $dev11;
	if($dev12 != '' || $dev12 != 'NA')
		$dev_tmp[] = $dev12;
	if(count($dev_tmp) > 0) {
		foreach($dev_tmp as $key => $val) {
			if($tmp[$val] == '') continue;
			if($key == count($dev_tmp) - 1)
				$dev_email_str .= $tmp[$val];
			else 
				$dev_email_str .= $tmp[$val].',';
		}
	}
?>
<TD><input type="text" size=66 name="dev" id="dev" value="<?php echo $dev_email_str; ?>"></TD><TD>Developers Team</TD>
</TR>
<TR>
<TD>Subject:</TD>
<TD><input type="text" name="subject" size=66 value="<?php echo "CHD NUMBER- ".$chd_id." - ".$pro." - ".$course_title." - Fixes Completed"; ?>"></TD>
</TR>
</br>
<TR>
<TD>Message :</TD>
<!-- @saurav changed here for exception handeling --> 
<TD><textarea name="msg" rows="4" cols="50" name="msg" id="msg">
Hi,<br><br>

We have completed the fixes for the edits.<br><br>

Please find the updated build on SVN at the same path.<br><br>

Bug Summary:<br><br>

Fixed: (<?php echo (empty($fixed) ? 0 : $fixed) ?>)<br>
Open: (<?php echo (empty($open) ? 0 : $open) ?>)<br>
Hold: (<?php echo (empty($hold) ? 0 : $hold) ?>)<br>
Closed: (<?php echo (empty($closed) ? 0 : $closed) ?>)<br>
Reopened: (<?php echo (empty($reopened) ? 0 : $reopened) ?>)<br>
Ok As Is: (<?php echo (empty($okasis) ? 0 : $okasis) ?>)<br><br>

Total Bugs: (<?php echo (empty($total) ? 0 : $total) ?>)<br><br>

Regards,<br>
<?php echo $username; ?> 

</textarea></TD>
</TR>
</table>
<input type="submit" value="Send Mail">
<input type="hidden" name="project" value="<?php echo $pro;?>">

</form>
</body>