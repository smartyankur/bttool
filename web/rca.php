<?php
$q=$_GET["q"];

$con = mysql_connect("localhost","root","password");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("audit", $con);
//echo "Hi    :".$q;

$sql="SELECT * FROM qcuploadinfo WHERE project = '".$q."'";
//echo $sql;

$result = mysql_query($sql);
$count = mysql_num_rows($result);

if($count==0)
{
  die('No open action item was found with this project name.');
}

echo "-----------------------------------------------------------------------------------------------------------------------------";

while($row = mysql_fetch_array($result))
  {
  echo "<br>";
  echo "Bug ID :".$row['id']."</br>";
  echo "Bug Desc :".$row['bdr']."</br>";
  echo "Receive Date :".$row['receivedate']."</br>";
  echo "Enter the corrective action in the below text box:-"."</br>";
  echo "<textarea id=".$row['id']." rows="."4"." maxlength="."160"." cols="."30"."></textarea>";
  ?>
  <TD>Root Cause</TD>
  <TD><?php
	$q = "select cause from cause";
    $r = mysql_query( $q, $con );
    $count = mysql_num_rows($r);
	
	if($count==0)
		{
			die('Data Not Found');
		}
    ?>
    <select name="cause" id="<?php echo "cause".$row['id'];?>"> 
    <?php
	echo "<option size =30 selected value=\"Select\">Select</option>";
    
	if(mysql_num_rows($r)) 
    { 
    while($rowc = mysql_fetch_assoc($r)) 
    { 
    echo "<option>$rowc[cause]</option>"; 
    } 
 
    } 
    else {
    echo "<option>No Names Present</option>";  
    } 
    ?>
	</select>
	</TD>
    <TD><input type="button" value="Submit Response" onclick="submitresponse(<?php echo $row['id'] ?>)"></TD>
    <?php
    echo "<br>";
    echo "-----------------------------------------------------------------------------------------------------------------------------";
    }
mysql_close($con);
?> 