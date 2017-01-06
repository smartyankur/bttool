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
  echo "Discussion Date :".$row['discussiondate']."</br>";
  echo "Auditee Comment :".$row['auditeecomment']."</br>";
  echo "Target Date :".$row['targetdate']."</br>";
  echo "SEPG Comment :".$row['sepgcomment']."</br>";
  echo "Status :".$row['status']."</br>";
  //echo "<textarea id=".$row['actionid']." rows="."4"." maxlength="."160"." cols="."30"."></textarea>";
  ?>
  <TD>Target Date</TD>
  <TD><input type="Text" readonly="readonly" id="<?php echo "TDate".$row['actionid'];?>" value="" maxlength="20" size="9" name="<?php echo "TDate".$row['actionid'];?>">
  <a href="javascript:NewCal('<?php echo "TDate".$row['actionid'];?>','ddmmmyyyy')"><img src="cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></TD>
 
  <TD><input type="button" value="Submit Response" onclick="submitresponse(<?php echo $row['actionid'] ?>)"></TD>
  <?php
  echo "<br>";
  echo "--------------------------------------------------------------------------------------------------------------------";
  }
mysql_close($con);
?> 