<?PHP
session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	$_SESSION['login'] = "";
	header ("Location:index.php");
}else{     
$user=$_SESSION['login'];	 
include("config.php");

$query = "select username,role,dept from login where uniqueid='$user';";
$retval = mysql_query( $query, $con );
$count = mysql_num_rows($retval);
	
if($count==0){
 die('Please Contact SEPG; May be You Are Not Registered');
}
   
while($row = mysql_fetch_assoc($retval)){ 
 echo "<br>";
 echo "<br>";
 echo "<h3>"."Hi ".$row['username']." ! Welcome To Audit Tracking Tool"."<h3>";
 $role= $row['role'];
 $dept= $row['dept'];
 $uname= $row['username'];
}
}
?>
<html>
<head>
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
<h1>Audit Tracking Tool</h1>
<form name="tstest" method=post>
<TABLE border=1>
<?php
if($role=="PM" || $role=="FM" || $role=="ID FM" || $role=="Media FM" || $role=="Tech FM" || $role=="DM" || $role=="RM" || $role=="PH" || $role=="IQ")
{
?>
<TR>
	<TD bgcolor="F7941C">Links for tracking NCs from audit conducted by SEPG.</TD>	
</TR>
<TR>
	<TD><a href="ncreport.php">For PMs- Find and Respond to NCs</a></TD>	
</TR>
<TR>
	<TD><a href="closedlist.php">For PMs-Find Closed NCs</a></TD>	
</TR>
<TR>
	<TD><a href="ncreportglobalresponse.php">For PMs-Give Global Response For NCs</a></TD>
</TR>
<TR>
	<TD><a href="ncdreport.php">For PMs-Find NC Density Projectwise.</a></TD>
</TR>
<TR>
	<TD><a href="mastercom.php">For PMs-Master Compliance Report</a></TD>
</TR>
<TR>
	<TD><a href="sb_review.php">SB Review</a></TD>
</TR>
<?php
if($dept=="LMS")
{
?>
<TR>
	<TD bgcolor="F7941C">Link To Send LMS QC Request</TD>	
</TR>
<TR>
	<TD><a href="projection.php">Create, Send QC Projections</a></TD>
</TR>
<TR>
	<TD><a href="createtask.php">Create, Send and Manage LMS QC Request</a></TD>
</TR>
<TR>
	<TD><a href="managedev.php">Respond to QC issues</a></TD>
</TR>
<TR>
	<TD><a href="manageticket.php">Manage Tickets</a></TD>
</TR>
<?php
}

if($dept=="Content")
{
?>
<TR>
	<TD bgcolor="F7941C">Link for logging Functional Review findings.</TD>	
</TR>
<TR>
	<TD><a href="funrev.php">Log predelivery functional review findings</a></TD>
</TR>
<TR>
	<TD bgcolor="F7941C">Link for QC data anytime detailed status.</TD>	
</TR>
<TR>
	<TD><a href="qccalc12.php">Link to view function wise QC defect status</a></TD>
</TR>
<?php
 }
}
?>
<?php
if($role=="PM" || $role=="FM" || $role=="ID FM" || $role=="Media FM" || $role=="Tech FM" || $role=="DM" || $role=="RM" || $role=="PH" || $role=="IQ" || $role=="QC FM" || $role=="QC")
{
?>
<?php
 if($dept=="Content")
 {
?>
<TR>
	<TD bgcolor="F7941C">Links for logging, tracking and closing defects.</TD>	
</TR>
<TR>
	<TD><a href="openbug2.php">For QC Team -Log A New Bug and Manage Status.</a></TD>
</TR>
<TR>
	<TD><a href="countholdissues.php">Link for COUNT or HOLD issues.</a></TD>
</TR>
<TR>
	<TD><a href="chd.php">Link for Course Handover Document.</a></TD>
</TR>
<TR>
	<TD><a href="project_report.php">Project Report</a></TD>
</TR>
<TR>
	<TD bgcolor="F7941C">Link for responding, tracking and fixing defects.</TD>	
</TR>
<TR>
	<TD><a href="devcomment.php">For Dev Team -Log Response to Bugs from QC.</a></TD>
</TR>
<TR>
	<TD><a href="sb_review.php">SB Review</a></TD>
</TR>
<?php
 }
if($role=="QC" || $role=="QC FM" || $role=="IQ")
{
 if($dept=="Content")
 {
?>
<TR>
	<TD bgcolor="F7941C">Link QC for Responding To Dev's comment.</TD>	
</TR>
<TR>
	<TD><a href="qccomment.php">For QC Team -Log Response to Developers' Comment.</a></TD>
</TR>
<TR>
	<TD bgcolor="F7941C">Link for QC data anytime detailed status.</TD>	
</TR>
<TR>
	<TD><a href="qccalc12.php">Link to view function wise QC defect status</a></TD>
</TR>
<?php
 }
?>
<TR>
	<TD bgcolor="F7941C">Links To Receive and Manage QC Requests</TD>	
</TR>
<TR>
	<TD><a href="alloc.php">Receive & Manage QC Request</a></TD>
</TR>
<TR>
	<TD><a href="taskclosure.php">Link to Close LMS QC Task</a></TD>
</TR>
<TR>
	<TD bgcolor="F7941C">Manage Bugs</TD>	
</TR>
<TR>
	<TD><a href="lmsbt.php">Link to Log issues or defects.</a></TD>
</TR>
<TR>
	<TD><a href="collateral.php">Log ancilliary or collateral issues.</a></TD>
</TR>
<TR>
	<TD><a href="managebug.php">Respond to Dev Comments.</a></TD>
</TR>
<TR>
	<TD><a href="productlevelbugs.php">Product Level Bugs</a></TD>
</TR>
<TR>
	<TD><a href="sb_review.php">SB Review</a></TD>
</TR>
<?php
}
?>
<?php
}
?>
<?php
if(strpos($role, "Tech") !== false || strpos($role, "Media") !== false || strpos($role, "ID") !== false || $role == 'DEV' || $role == "IQ")
{
 if($dept=="Content")
 {
?>
<TR>
	<TD bgcolor="F7941C">Link for responding, tracking and fixing defects.</TD>	
</TR>
<TR>
	<TD><a href="devcomment.php">For Dev Team -Log Response to Bugs from QC.</a></TD>
</TR>
<TR>
	<TD><a href="qcopenbugs.php">For Dev Team -Check open or hold Bugs.</a></TD>
</TR>
<TR>
	<TD bgcolor="F7941C">Link for Functional Review findings.</TD>	
</TR>
<TR>
	<TD><a href="funrev.php">Check functional review findings</a></TD>
</TR>
<TR>
	<TD><a href="sb_review.php">SB Review</a></TD>
</TR>
<?php
 }
?>
<?php
if( ($dept=="LMS") && ($uname != 'Parvendra Singh') ){
?>
<TR>
	<TD bgcolor="F7941C">Link To Send LMS QC Request</TD>	
</TR>
<TR>
	<TD><a href="projection.php">Create, Send QC Projections</a></TD>
</TR>
<TR>
	<TD><a href="createtask.php">Create, Send and Manage LMS QC Request</a></TD>
</TR>
<TR>
	<TD><a href="managedev.php">Respond to QC issues</a></TD>
</TR>
<TR>
	<TD><a href="manageticket.php">Manage Tickets</a></TD>
</TR>
<?php
}elseif( ($dept=="LMS") && ($uname == 'Parvendra Singh') ){
?>
<TR>
	<TD bgcolor="F7941C">Link To Send LMS QC Request</TD>	
</TR>
<TR>
	<TD><a href="managedev.php">Respond to QC issues</a></TD>
</TR>
<?php
}
}
?>

<?php
if($role=="RM" || $role=="IQ" )
{
?>
<TR>
	<TD bgcolor="F7941C">Links for tracking Utilization.</TD>	
</TR>
<TR>
	<TD><a href="utilization.php">Track utilization</a></TD>
</TR>
<?php
}
?>

<?php
if($role=="ADMIN" || $role=="IQ")
{
?>
<TR>
	<TD bgcolor="F7941C">Links for Admin.</TD>	
</TR>
<TR>
	<TD><a href="storein.php">Track Store Items</a></TD>
</TR>
<TR>
	<TD><a href="additem.php">Add Store Items</a></TD>
</TR>
<TR>
	<TD><a href="cabrequest.php">Cab Request Entries</a></TD>
</TR>
<TR>
	<TD><a href="cabreport.php">Cab Report Interface</a></TD>
</TR>
<TR>
	<TD><a href="cabexpensemail.php">Mail Cab Expenses</a></TD>
</TR>
<TR>
	<TD><a href="carstring.php">Cab Search Report</a></TD>
</TR>
<TR>
	<TD><a href="food.php">Food Request Interface</a></TD>
</TR>
<TR>
	<TD><a href="foodreport.php">Food Report Interface</a></TD>
</TR>
<TR>
	<TD><a href="manualeffort.php">Track manual labours</a></TD>
</TR>
<TR>
	<TD><a href="travelinvoice.php">Travel Invoice</a></TD>
</TR>
<?php
}
?>

</table>
<br>
<input type="button" class="button" value="Log Out" onclick="location.href='logout.php';">
</form>
</body>
</html> 