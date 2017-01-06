<body background="bg.gif">
<?php
error_reporting(0);
$billedto=$_REQUEST["b"];
$r=$_GET["r"];
$s=$_GET["s"];

$fdate=strtotime($r); 
$fdate=date( 'Y-m-d', $fdate );

$tdate=strtotime($s);
$tdate=date( 'Y-m-d', $tdate );

if($fdate>$tdate) {echo "Choose proper dates"; exit();}

include('config.php');
$pro=mysql_real_escape_string($pro);

$query="select sum(cost) from cabbooking where date BETWEEN '$fdate' and '$tdate' AND billedto='$billedto'";
$result=mysql_query($query) or die (mysql_error());
while($row = mysql_fetch_assoc($result)) 
    { 
     $costtotal=$row['sum(cost)'];
    } 	

$equery="select email from login where username='$billedto'";
$eresult=mysql_query($equery) or die (mysql_error());

while($erow = mysql_fetch_assoc($eresult)) 
    { 
     $email=$erow['email'];
    } 	

$dquery="select user,purpose,project,date,cost from cabbooking where date BETWEEN '$fdate' and '$tdate' AND billedto='$billedto'";
$dresult=mysql_query($dquery) or die (mysql_error());

$str  = '<html><body>';
$str .= '<h4>Dear Sir/Ma\'am</h4>';
$str .= '<h5>Cab Details for Total Amount of '.$costtotal.'</h5>';
$str .= '<h6>From '.$fdate.' to '.$tdate.'</h6>';
$str .= '<table border=1>';
$str .= '<tr><th>User</th><th>Purpose</th><th>Project</th><th>Date</th><th>Cost</th></tr>';
while($drow = mysql_fetch_assoc($dresult)) 
    { 
     $str  .= '<tr>';
	 $user=$drow['user'];
	 $purpose=$drow['purpose'];
     $project=$drow['project'];
	 $date=$drow['date'];
	 $cost=$drow['cost'];
	 $str  .= "<td>".$user."</td>";
     $str  .= "<td>".$purpose."</td>";
     $str  .= "<td>".$project."</td>";
     $str  .= "<td>".$date."</td>";
     $str  .= "<td>".$cost."</td>";
     $str  .= '</tr>';
    }
$str .= '</table>';
$str .= '</br>';
$str .= '</br>';
$str .= 'Thanks and Regards';
$str .= '</body></html>';
?>
<script>
function verify()
{
 var mail = trim(document.getElementById('pmmail').value);
 var msg = trim(document.getElementById('msg').value); 
 
 if (mail=="")
 {
   alert("Please provide mail id");
   return false;
 }

 if (msg=="")
 {
   alert("Please provide message");
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
<form name="tstest" action="cabmail.php" onsubmit="return verify()" method="post" enctype="multipart/form-data">
<table>
<TR>If eMail informations are blank or incorrect,please contact <b>Internal Quality</b> team.</TR>
<TR></TR>
<TR>
<TD>Billed To Email ID <input type=text maxlength=35 size=35 name="pmmail" id="pmmail" value="<?php echo $email;?>"></TD>
</TR>
<TR>
<TD><?php echo "Total Expenditure from ".$fdate." to " .$tdate." is Rs ".$costtotal;?></TD>
</TR>
</table>
<table>
<?php echo $str; ?>
</table>
</br>
</br>
<input type="submit" value="Send Mail">
<input type="hidden" value="<?php echo $str;?>" name="details">
</form>
</body>