<?php
include("config.php");

$selectCommon = "SELECT pt.project, pt.id as wpid, qcr.indx as reqid, qcr.status, qcr.forround, qcr.whosent, qcr.DDate FROM projecttask pt INNER JOIN qcreq qcr ON pt.id = qcr.id WHERE qcr.status = 'closed' ORDER BY pt.project ASC";
$queryCommon = mysql_query($selectCommon);
$numrowsCommon  = mysql_num_rows($queryCommon);

if($numrowsCommon==0){
  die('Data Not Found');
}
?>
<table width="99%" border="0" cellspacing="0" cellpadding="0" bordercolor="orangered">
  <tr class="table_text">
    <td valign="top" align="right">
      <a href="weeklyreportexport.php">Export result</a>
    </td>                      
  </tr>
</table>  
<table width="80%" border="1" cellspacing="0" cellpadding="0" bordercolor="orangered">
  <tr class="table_text">
    <th colspan="20" valign="top">&nbsp;</th>                  
  </tr>
  <tr class="table_text">
    <th valign="top">Req ID</th>
    <th valign="top">Project</th>
    <th valign="top">Task</th>
    <th valign="top">Round</th>  
    <th valign="top">Who Sent</th>
    <th valign="top">When Sent To QC</th>
    <th valign="top">Status</th>
    <th valign="top">Delivery Date</th>
    <th valign="top">When Last Status Achieved</th>
    <th valign="top">QC</th>
    <th valign="top">Planned Effort</th>
    <th valign="top">Actual Effort</th>
    <th valign="top">Variance</th>
    <th valign="top">Total bugs</th>
    <th valign="top">Open bugs</th>
    <th valign="top">closed bugs</th>
    <th valign="top">Reopened bugs</th>
    <th valign="top">Fixed</th>
    <th valign="top">Hold</th>
    <th valign="top">OK as is</th>                  
  </tr>
<?php
while($fetchCommon = mysql_fetch_array($queryCommon)){
	$indxCommon = $fetchCommon['reqid'];
	$selectQCPlan = "SELECT * FROM qcplan WHERE indx = $indxCommon ORDER BY indx";
	$queryQCPlan  = mysql_query($selectQCPlan);
	$numrowsQCPlan  = mysql_num_rows($queryQCPlan);
  if($numrowsQCPlan != 0){
    while($fetchQCPlan = mysql_fetch_array($queryQCPlan)){

  $queryBugsDetails = mysql_query("SELECT count(id) as totalBugs, 
                                        (select count(status) from `lmsblob` where status = 'open' and `reqid` = ".$fetchQCPlan['indx'].") as openBugs,
                                        (select count(status) from `lmsblob` where status = 'closed' and `reqid` = ".$fetchQCPlan['indx'].") as closedBugs,                                           
                                        (select count(status) from `lmsblob` where status = 'reopened' and `reqid` = ".$fetchQCPlan['indx'].") as reopenedBugs,   
                                        (select count(status) from `lmsblob` where status = 'fixed' and `reqid` = ".$fetchQCPlan['indx'].") as fixedBugs,  
                                        (select count(status) from `lmsblob` where status = 'hold' and `reqid` = ".$fetchQCPlan['indx'].") as holdBugs,
                                        (select count(status) from `lmsblob` where status = 'ok as is' and `reqid` = ".$fetchQCPlan['indx'].") as okasisBugs                                                                                
                                 FROM `lmsblob` where `reqid` = ".$fetchQCPlan['indx']);
  $fetchBugsDetails = mysql_fetch_array($queryBugsDetails);
              
    	echo "<tr class=\"table_text\">";
      	echo "<td class=\"table_text\" align=\"center\" valign=\"top\">".$fetchCommon['reqid']."</td>";
      	echo "<td class=\"table_text\" valign=\"top\"><div style=\"width:150;height:53;overflow:auto\">".$fetchCommon['project']."</div></td>";
      	echo "<td class=\"table_text\" valign=\"top\"><div style=\"width:150;height:53;overflow:auto\">".$fetchQCPlan['task']."</div></td>";
      	echo "<td class=\"table_text\" align=\"center\" valign=\"top\">".$fetchCommon['forround']."</td>";
      	echo "<td class=\"table_text\" align=\"center\" valign=\"top\">".$fetchCommon['whosent']."</td>";
      	echo "<td class=\"table_text\" valign=\"top\">".$fetchQCPlan['SDate']."</td>";
      	echo "<td class=\"table_text\" valign=\"top\">".$fetchQCPlan['status']."</td>";
      	echo "<td class=\"table_text\" valign=\"top\">".$fetchCommon['DDate']."</td>";
      	echo "<td class=\"table_text\" valign=\"top\">".$fetchQCPlan['whenchanged']."</td>";
      	echo "<td class=\"table_text\" valign=\"top\" align=\"center\">".$fetchQCPlan['qc']."</td>";
      	echo "<td class=\"table_text\" valign=\"top\">".$fetchQCPlan['effort']."</td>";
      	echo "<td class=\"table_text\" valign=\"top\">".$fetchQCPlan['actualeffort']."</td>";
      	echo "<td class=\"table_text\" valign=\"top\">".round((($fetchQCPlan['actualeffort']-$fetchQCPlan['effort'])/$fetchQCPlan['effort']), 2)."</td>";
      	echo "<td class=\"table_text\" valign=\"top\">".$fetchBugsDetails['totalBugs']."</td>";
      	echo "<td class=\"table_text\" valign=\"top\">".$fetchBugsDetails['openBugs']."</td>";
      	echo "<td class=\"table_text\" valign=\"top\">".$fetchBugsDetails['closedBugs']."</td>";
      	echo "<td class=\"table_text\" valign=\"top\">".$fetchBugsDetails['reopenedBugs']."</td>";
      	echo "<td class=\"table_text\" valign=\"top\">".$fetchBugsDetails['fixedBugs']."</td>";
      	echo "<td class=\"table_text\" valign=\"top\">".$fetchBugsDetails['holdBugs']."</td>";
      	echo "<td class=\"table_text\" valign=\"top\">".$fetchBugsDetails['okasisBugs']."</td>";                                                        
    	echo "</tr>";      
    }
  }//else{
//     	echo "<tr class=\"table_text\">";
//       	echo "<td class=\"table_text\" align=\"center\">No result</td>";                                                        
//     	echo "</tr>";  
//   }	
}
mysql_close($con);
?> 
</table>