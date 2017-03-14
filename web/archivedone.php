<?php
error_reporting(0);
$user=$_REQUEST['q'];
$pro_id = $_REQUEST['pro_id'];
include("config.php");
$query = "select username from adminlogin where uniqueid='$user';";
$retval = mysql_query( $query);
$count = mysql_num_rows($retval);

if($count==0)
	{
		die('Please Contact SEPG; May be You Are Not Registered');
	}


while($row = mysql_fetch_assoc($retval)) 
{ 
 echo "<h3>"."Hi ".$row['username']." ! Welcome To Audit Tracking Tool"."<h3>"; 
}

try {
	
	/* qcuploadinfo table Archive */
	$qc_query = "select * from qcuploadinfo where project_id='".$pro_id."'";
	$result=mysql_query($qc_query) or die (mysql_error());
	$count = mysql_num_rows($result);
	if($count < 1) {
		echo "No QC bug available to archive <br>";
		
	} else {
		while($row = mysql_fetch_assoc($result)) { 
		   
		   $query = "insert into test.qcuploadinfo values('".$row['project_id']."','".$row['chd_id']."','".addslashes($row['project'])."','".addslashes($row['phase'])."','".addslashes($row['module'])."','".addslashes($row['topic'])."','".$row['recievedate']."','".addslashes($row['browser'])."','".addslashes($row['coursestatus'])."','".addslashes($row['function'])."','".addslashes($row['bcat'])."','".addslashes($row['bscat'])."','".addslashes($row['bdr'])."','".addslashes($row['asignee'])."','".addslashes($row['qc'])."','".addslashes($row['screen'])."','".addslashes($row['filename'])."','".addslashes($row['filepath'])."','".addslashes($row['id'])."','".addslashes($row['uploaddate'])."','".addslashes($row['bugstatus'])."','".addslashes($row['severity'])."','".addslashes($row['whochangedstatus'])."','".addslashes($row['whenchangedstatus'])."','".addslashes($row['rootcause'])."','".addslashes($row['correctiveaction'])."','".addslashes($row['whodidrca'])."','".addslashes($row['devcomment'])."','".addslashes($row['qccomment'])."','".addslashes($row['devresponding'])."','".addslashes($row['devrespdate'])."','".addslashes($row['qcresponding'])."','".addslashes($row['qcrespdate'])."','".addslashes($row['round'])."','".addslashes($row['reviewer'])."')"; 
		   mysql_query($query) or die (mysql_error());
		}
		$query="delete from qcuploadinfo where project_id='".$pro_id."'";
		mysql_query($query) or die (mysql_error());
		echo "Archive for Qcuploadinfo table record done sucessfully <br/>";
	}
	/* End of qcuploadinfo table Archive */
	
	/* Blob table Archive */
	$blob_query = "select * from blobt where project_id='".$pro_id."'";
	$result=mysql_query($blob_query) or die (mysql_error());
	$count = mysql_num_rows($result);
	if($count < 1) {
		echo "No Blob available to archive <br>";
	} else {
		while($row = mysql_fetch_assoc($result)) { 
		   
		   $query = "insert into test.blobt values('','".$row['reviewer']."','".addslashes($row['project_id'])."','".addslashes($row['project'])."','".addslashes($row['phase'])."','".addslashes($row['cat'])."','".addslashes($row['subcat'])."','".$row['reviewee']."','".addslashes($row['desc1'])."','".addslashes($row['grab'])."','".addslashes($row['status'])."','".addslashes($row['comment'])."','".addslashes($row['creationDate'])."','".addslashes($row['severity'])."')"; 
		   mysql_query($query) or die (mysql_error());
		}
		$query="delete from blobt where project_id='".$pro_id."'";
		mysql_query($query) or die (mysql_error());
		
		echo "Archive for Blobt table record done sucessfully <br/>";
	}
	/* End of Blob table Archive */
	
	/* Function table Archive */
	$fun_query = "select * from tbl_functional_review where project_id='".$pro_id."'";
	$result=mysql_query($fun_query) or die (mysql_error());
	$count = mysql_num_rows($result);
	if($count < 1) {
		echo "No Functional record available to archive <br>";
	} else {
		while($row = mysql_fetch_assoc($result)) { 
		
		   $query = "insert into test.tbl_functional_review values('','".$row['project_id']."','".addslashes($row['project_name'])."','".addslashes($row['project_manager'])."','".addslashes($row['course_title'])."','".addslashes($row['start_date'])."','".$row['course_level']."','".$row['reject_course']."','".$row['phase_closed']."','".$row['out_sourced']."','".addslashes($row['functional_manager_id'])."','".addslashes($row['functional_manager_media'])."','".addslashes($row['functional_manager_tech'])."','".addslashes($row['developers'])."','".addslashes($row['version'])."','".addslashes($row['pagecount'])."','".addslashes($row['iterationRound'])."','".addslashes($row['learning_hours'])."','".addslashes($row['testing_scope'])."','".addslashes($row['partial_testing'])."','".addslashes($row['conf_reviews'])."','".addslashes($row['course_path'])."','".addslashes($row['sb_path'])."','".addslashes($row['editsheet'])."','".addslashes($row['dt_path'])."','".addslashes($row['test_plan_path'])."','".addslashes($row['test_checklists'])."','".addslashes($row['reviewer'])."','".addslashes($row['status'])."','".addslashes($row['assignqc'])."','".addslashes($row['qccomment'])."','".addslashes($row['modificationdate'])."','".addslashes($row['comments'])."','".addslashes($row['support_file1'])."','".addslashes($row['support_file2'])."','".addslashes($row['support_file3'])."','".addslashes($row['support_file4'])."','".addslashes($row['testenvironment'])."','".addslashes($row['coursesize'])."','".addslashes($row['chdreleasedate'])."')"; 
		  
		   mysql_query($query) or die (mysql_error());
		 
		}
		$query="delete from tbl_functional_review where project_id='".$pro_id."'";
		mysql_query($query) or die (mysql_error());
		
		echo "Archive for tbl_functional_review table record done sucessfully <br/>";
	}
	/* End Function table Archive */
	$mark_archive_query = "update projectmaster set is_archive = '1' where pindatabaseid = $pro_id";
	mysql_query($mark_archive_query) or die (mysql_error());
} catch(Exception $e) {
	echo $e->getMessage();
}
?>

<script>
    window.onunload = refreshParent;
    function refreshParent() {
        window.opener.location.reload();
    }
</script>
