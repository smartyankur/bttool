<?php
$q=$_GET["q"];

$con = mysql_connect("localhost","root","password");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("audit", $con);
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
  echo "NC Type :".$row['nctype']."</br>";
  echo "Discussion Date :".$row['discussiondate']."</br>";
  echo "Auditee Comment :".$row['auditeecomment']."</br>";
  echo "Target Date :".$row['targetdate']."</br>";
  echo "SEPG Comment :".$row['sepgcomment']."</br>";
  echo "Status :".$row['status']."</br>";
  echo "<u>"."Write inside the text area the modified finding"."</u>"."</br>";
  echo "<textarea id=".$row['actionid']." rows="."4"." maxlength="."160"." cols="."30"."></textarea>";
  ?>
  <TD>NC Type</TD>
  <TD><select name="nctype" size="1" id="<?php echo "stat".$row['actionid'];?>">
  <option value="NC">NC</option>
  <option value="Followon">Followon</option>
  <option value="Improvement">Improvement</option>
  </select></TD>
  
  <TD><input type="button" value="Submit Response" onclick="submitresponse(<?php echo $row['actionid'] ?>)"></TD>

  <?php
  echo "<br>";
  echo "--------------------------------------------------------------------------------------------------------------------";
  }
mysql_close($con);
?> 