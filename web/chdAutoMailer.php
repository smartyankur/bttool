<body>

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
$chd_id=$_REQUEST['chd_id'];
$status=isset($_REQUEST['status']) ? $_REQUEST['status'] : '';

/* @saurav changed query to fetch data using project_id */
$query="select id, project_name, project_manager, course_title, functional_manager_id, functional_manager_media, functional_manager_tech, developers_id,developers_media,developers_tech, reviewer, assignqc from tbl_functional_review where id = $chd_id";
$result=mysql_query($query) or die (mysql_error());
while($row = mysql_fetch_assoc($result)) { 
    $pm      = $row['project_manager'];
	$fmone   = $row['functional_manager_id'];
    $fmtwo   = $row['functional_manager_media'];
	$fmthree = $row['functional_manager_tech'];
    $devsid     = explode(',', $row['developers_id']);
    $devsmed     = explode(',', $row['developers_media']);
    $devstech     = explode(',', $row['developers_tech']);
	$rev     = $row['reviewer'];
    $qc      = $row['assignqc'];
	$pro     = $row['project_name'];
	$chd_id  = $row['id'];
	$title   = $row['course_title'];
}
if(count($devsid) > 0) {
	$tmp_array = array();
	foreach($devsid as $val) {
		$tmp_array[] = "'$val'";
	}
}
if(count($devsmed) > 0) {
	$tmp_array = array();
	foreach($devsmed as $val) {
		$tmp_array[] = "'$val'";
	}
}
if(count($devstech) > 0) {
	$tmp_array = array();
	foreach($devstech as $val) {
		$tmp_array[] = "'$val'";
	}
}
$dev_str = implode(',', $tmp_array);
$mquery = "select email, username from login where username IN('$pm','$fmone','$fmtwo','$fmthree','$qc',$dev_str,'$rev')";
$mresult=mysql_query($mquery) or die (mysql_error());
$tmp = array();
while($mrow = mysql_fetch_assoc($mresult)) { 
   $tmp[$mrow['username']] = $mrow['email'];
} 	
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
var alphaExp = /^[0-9a-zA-Z._,: .:/s]*$/;
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
<TR><h3><?php echo "CHD NUMBER- ".$chd_id." - ".$pro." - ".$title." - CHD ".(empty($status) ? 'Accepted' : ucfirst($status)); ?></h3></TR>
<TR>If PM/FM or their eMail informations are blank/incorrect, use "Change PM/FM Details" and "Create or Change email ID of PM/FM"</TR>
<TR>
<TD><?php if(trim($pm)<>"" || trim($pm)<>'NA') echo "TO :"?></TD>
<TD><input type=email size=66 name="pmmail" id="pmmail" value="<?php echo $tmp[$pm];?>"></TD><TD>PM</TD>
</TR>
<TR>
<TD><?php if(trim($fmone)<>"" || trim($fmone)<>'NA') echo "Cc :"?></TD>
<TD><input type=email size=66 name="fmonemail" id="fmonemail" value="<?php echo $tmp[$fmone];?>"></TD><TD>ID FM</TD>
</TR>

<TR>
<TD><?php if(trim($fmtwo)<>"" || trim($fmtwo)<>'NA') echo "Cc :"?></TD>
<TD><input type=email size=35 name="fmtwomail" id="fmtwomail" value="<?php echo $tmp[$fmtwo];?>"></TD><TD>MED FM</TD>
</TR>

<TR>
<TD><?php if(trim($fmthree)<>"" || trim($fmthree)<>'NA') echo "Cc :"?></TD>
<TD><input type=email size=35 name="fmthreemail" id="fmthreemail" value="<?php echo $tmp[$fmthree];?>"></TD><TD>SCR FM</TD>
</TR>
<?php
if(count($tmp_array) > 0) {
	$dev_email = array();
	foreach($tmp_array as $val) {
		$dev_email[] = $tmp[$val];
	}
	$dev_email_str = implode(',',$dev_email);
}
?>
<TR>
<TD><?php if(trim($dev_str)<>"" || trim($dev_str)<>'NA') echo "Cc :"?></TD>
<TD><input type=text size=66 name="dev" id="dev" value="<?php echo $dev_email_str ?>"></TD><TD>Developers</TD>
</TR>

<TR>
<TD><?php if(trim($qc)<>"" || trim($qc)<>'NA') echo "Cc :"?></TD>
<TD><input type=text size=66 name="qc" id="qc" value="<?php echo $tmp[$qc] ?>"></TD><TD>QC</TD>
</TR>
<!--<TR>
<TD><?php if(trim($rev)<>"" || trim($rev)<>'NA') echo "Cc :"?></TD>
<TD><input type=text size=66 name="rev" id="rev" value="<?php echo $tmp[$rev] ?>"></TD><TD>Reviewer</TD>
</TR>-->
<TR>
<TD>Subject :</TD>
<TD><input type="text" size=66 name="subject" value="<?php echo "CHD NUMBER- ".$chd_id." - ".$pro." - ".$title." - CHD ".(empty($status) ? 'Accepted' : ucfirst($status)); ?>"></TD>
</TR>
</br>
<TR>
<TD>Message :</TD>
<!-- @saurav changed here for exception handeling --> 
<TD>
<textarea name="msg" id="msg" cols="50" rows="4">
Hi,<br><br> The CHD has been <?php echo (empty($status) ? 'Accepted' : ucfirst($status)); ?> for the course <?php echo $title; ?>.<br><br>
Bugs will be logged under the following project name: <?php echo $pro; ?> <br><br>
Regards, <br>
<?php echo $username; ?>
</textarea>
</TD>
</TR>
</table>
<input type="submit" value="Send Mail">
<input type="hidden" name="project" value="<?php echo $pro; ?>">
<input type="hidden" name="chd_id"  value="<?php echo $chd_id; ?>">
<input type="hidden" name="status" value="<?php echo $status ?>">
</form>
</body>