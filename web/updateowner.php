<?php
$q=$_GET["q"];

include('config.php');
//echo "Hi    :".$q;

$sql="SELECT * FROM actionitem WHERE status='open' and projectname = '".$q."'";
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
  echo "Owner :".$row['owner']."</br>";
  echo "NC Type :".$row['nctype']."</br>";
  echo "Discussion Date :".$row['discussiondate']."</br>";
  echo "Auditee Comment :".$row['auditeecomment']."</br>";
  echo "Target Date :".$row['targetdate']."</br>";
  echo "SEPG Comment :".$row['sepgcomment']."</br>";
  echo "Status :".$row['status']."</br>";
  ?>
  <TD>New Owner</TD>
  <TD><select name="nctype" size="1" id="<?php echo $row['actionid'];?>">
  <option value="PM">PM</option>
  <option value="DM">DM</option>
  <option value="BD">BD</option>
  </select></TD>
  
  <TD><input type="button" value="Submit Response" onclick="submitresponse(<?php echo $row['actionid'] ?>)"></TD>

  <?php
  echo "<br>";
  echo "--------------------------------------------------------------------------------------------------------------------";
  }
mysql_close($con);
?> 