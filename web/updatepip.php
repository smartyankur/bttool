<?php
//$q=$_GET["q"];

include('config.php');
//echo "Hi    :".$q;

$sql="SELECT * FROM PIP";
//echo $sql;

$result = mysql_query($sql);
$count = mysql_num_rows($result);

if($count==0)
{
  die('No open action item was found with this project name.');
}

echo "---------------------------------------------------------------------------------------------------------------------";

while($row = mysql_fetch_array($result))
  {
  echo "<br>";
  echo "PIP ID :".$row['pipid']."</br>";
  echo "Proposal :".$row['proposal']."</br>";
  echo "Submission Date :".$row['date']."</br>";
  echo "Submitted By :".$row['name']."</br>";
  
  $query="select status,implemented from piphistory where pipid='".$row['pipid']."'";
  $retval = mysql_query($query);
  while($erow = mysql_fetch_array($retval)){$stat=$erow['status'];$implemented=$erow['implemented'];}
  echo "Status :".$stat."</br>";
  echo "Implemented :".$implemented."</br>";
  ?>
  New SEPG Status :<TD><textarea id="<?php echo "stat".$row['pipid'];?>" roes="4" maxlength="160" cols="10"></textarea></TD>
  <TD><input type="button" value="Submit SEPG Status" onclick="submitstatus(<?php echo $row['pipid'];?>)"></TD>
  <TD>New Implementation Status</TD>
  <TD><select id="<?php echo $row['pipid'];?>" size="1">
  <option value="yes">yes</option>
  <option value="no">no</option>
  <option value="wip">wip</option>
  </select></TD>
   
  <TD><input type="button" value="New Implementation Status" onclick="submitresponse(<?php echo $row['pipid'];?>)"></TD>
  
  <TD>Accepted</TD>
  <TD><select id="<?php echo "acc".$row['pipid'];?>" size="1">
  <option value="yes">yes</option>
  <option value="no">no</option>
  <option value="wip">wip</option>
  </select></TD>
  <TD><input type="button" value="New Acceptance Status" onclick="submitacceptance(<?php echo $row['pipid'];?>)"></TD>
  
  <TD><input type="button" value="Delete Response" onclick="submitresponse(<?php echo $row['pipid'];?>)"></TD>
  <?php
  echo "<br>";
  echo "--------------------------------------------------------------------------------------------------------------------";
  }
mysql_close($con);
?> 