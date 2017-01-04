<body background="bg.gif">
<?php
error_reporting(0);
$billedto=$_POST["pm"];
$r=$_POST["MDate"];
$s=$_POST["TDate"];
$billedto=$_POST["BilledTo"];

$fdate=strtotime($r); 
$fdate=date( 'Y-m-d', $fdate );

$tdate=strtotime($s); 
$tdate=date( 'Y-m-d', $tdate );

if($fdate>$tdate) {echo "Choose proper dates"; exit();}

$con = mysql_connect("localhost","root","password");
if (!$con)
  {
   die('Could not connect: ' . mysql_error());
  }

mysql_select_db("audit") or die(mysql_error());
$pro=mysql_real_escape_string($pro);

$equery="select email from login where username='$billedto'";
$eresult=mysql_query($equery) or die (mysql_error());

while($erow = mysql_fetch_assoc($eresult)) 
    { 
     $email=$erow['email'];
    } 	

$dquery="select dept,pm,user,invno,traveldate,invoicedate,itinerary,cost from travelbooking where invoicedate BETWEEN '$fdate' and '$tdate' AND pm='$billedto'";
//echo $dquery;
$dresult=mysql_query($dquery) or die (mysql_error());

$count=mysql_num_rows($dresult);
//echo "Count of rows :".$count;

if($count==0){echo "There are no invoices on this date"; exit();}

$str  = '<html><body>';
$str .= '<h4>Dear Sir/Ma\'am</h4>';
$str .= '<h5>'.$fdate.' To '.$tdate.'</h5>';
$str .= '<table border=1>';
$str .= '<tr><th>Dept</th><th>User</th><th>Invoice No</th><th>TravelDate</th><th>InvoiceDate</th><th>Route</th><th>Cost</th></tr>';
while($drow = mysql_fetch_assoc($dresult)) 
    { 
       $str  .= '<tr>';
	 $dept=$drow['dept'];
	 $pm=$drow['pm'];
       $user=$drow['user'];
	 $invno=$drow['invno'];
	 $traveldate=$drow['traveldate'];
       $invoicedate=$drow['invoicedate'];
       $route=$drow['itinerary'];
       $cost=$drow['cost']; 
	 $str  .= "<td>".$dept."</td>";
     	 $str  .= "<td>".$user."</td>";
       $str  .= "<td>".$invno."</td>";
       $str  .= "<td>".$traveldate."</td>";
       $str  .= "<td>".$invoicedate."</td>";
       $str  .= "<td>".$route."</td>"; 
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
<form name="tstest" action="invmail.php" onsubmit="return verify()" method="post" enctype="multipart/form-data">
<table>
<TR>If eMail informations are blank or incorrect,please contact <b>Internal Quality</b> team.</TR>
<TR></TR>
<TR>
<TD>Billed To Email ID <input type=text maxlength=35 size=35 name="pmmail" id="pmmail" value="<?php echo $email;?>"></TD>
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