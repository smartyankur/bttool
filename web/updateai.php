<?php
$q=$_GET["q"];

$con = mysql_connect("localhost","root","password");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("audit", $con);
//echo "Hi    :".$q;

$sql="SELECT * FROM actionitem WHERE projectname = '".$q."'";
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
  echo "Action ID :".$row['actionid']."</br>";
  echo "Finding :".$row['finding']."</br>";
  echo "Discussion Date :".$row['discussiondate']."</br>";
  echo "Auditee Comment :".$row['auditeecomment']."</br>";
  echo "Target Date :".$row['targetdate']."</br>";
  echo "SEPG Comment :".$row['sepgcomment']."</br>";
  echo "Status :".$row['status']."</br>";
  echo "<textarea id=".$row['actionid']." rows="."4"." maxlength="."160"." cols="."30"."></textarea>";
  ?>
  <TD>Status</TD>
  <TD><select id="<?php echo "stat".$row['actionid'];?>" size="1">
  <option value="open">Open</option>
  <option value="closed">Closed</option>
  <option value="wip">WIP</option>
  </select></TD>
  
  <TD><input type="button" value="Submit Response" onclick="submitresponse(<?php echo $row['actionid'] ?>)"></TD>

  <?php
  echo "<br>";
  echo "--------------------------------------------------------------------------------------------------------------------";
  }
mysql_close($con);
?> 