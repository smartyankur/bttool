<?php
ob_start();
session_start();
include_once("lib/pagination.class.php");
$con = mysql_connect("localhost","root","password");
if (!$con){
	die('Could not connect: '. mysql_error());
}
mysql_select_db("audit") or die(mysql_error());

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'edit';

switch($action){
	case "edit":{
		if(isset($_REQUEST['bug_id'])) {
			if(ctype_digit($_REQUEST['bug_id'])){

				$sql = "SELECT id, project, phase, module, topic, screen, browser, bcat, reviewer, bdr, severity, uploaddate, bugstatus FROM qcuploadinfo WHERE id=".$_REQUEST['bug_id'];
				$result = mysql_query($sql) or die('mysql error:'.mysql_error());
				if(mysql_num_rows($result) > 0 ) {

					$row = mysql_fetch_assoc($result);
					echo join('||',array_values( $row ));
				}
			}
		}
	}
	break;
	case "update":{
		if(isset($_REQUEST['bug_id'])) {
			if(ctype_digit($_REQUEST['bug_id'])){
				$bug_status = mysql_real_escape_string($_REQUEST['bug_status']);
				$comments= mysql_real_escape_string($_REQUEST["comments"]);
				$reviewer = isset($_SESSION['reviewer']) ? $_SESSION['reviewer'] : "";
				$bdr = "<b>".$reviewer." [".date("d-M-Y H:i:s")."]:</b> ".$comments."<br /><br />";

				$sql = "UPDATE  qcuploadinfo SET bugstatus='".$bug_status."', bdr=CONCAT('".$bdr."',bdr) WHERE id=".$_REQUEST['bug_id'];
				$result = mysql_query($sql) or die('mysql error:'.mysql_error());
				if(mysql_affected_rows($con) > 0 ) {
					echo "true";
				}
			}
		}
	}
	break;
}

?>