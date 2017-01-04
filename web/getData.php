<?php
include_once("config.php");
include_once("lib/utility.class.php");

$mode = isset($_REQUEST['mode']) && $_REQUEST['mode'] != "" ? $_REQUEST['mode'] : "";
$project = isset($_REQUEST['project']) && $_REQUEST['project'] != "" ? $_REQUEST['project'] : "";
$project_id = isset($_REQUEST['pro_id']) && $_REQUEST['pro_id'] != "" ? $_REQUEST['pro_id'] : "";

$obj_utility = new Utility();
if(!empty($project)) {
	switch($mode){
		case "lead,fm,ceo,md":
			$result = mysql_query("SELECT lead, fmone, fmtwo, fmthree, fmfour, ceo, md FROM projectmaster where pindatabaseid='".$project_id."'");
			if(mysql_num_rows($result) == 1) {
				echo $obj_utility->php_to_js(mysql_fetch_assoc($result));
			}
		break;

		case "developers":
			$result = mysql_query("SELECT dev1, dev2, dev3, dev4, dev5, dev6, dev7, dev8, dev9, dev10, dev11, dev12 FROM projectmaster where pindatabaseid='".$project_id."'");
			if(mysql_num_rows($result) == 1) {
				echo $obj_utility->php_to_js(mysql_fetch_assoc($result));
			}
		break;
	
		case "testers":
			$result = mysql_query("SELECT tester1, tester2, tester3, tester4, tester5, tester6, tester7, tester8 FROM projectmaster where pindatabaseid='".$project_id."'");
			if(mysql_num_rows($result) == 1) {
				echo $obj_utility->php_to_js(mysql_fetch_assoc($result));
			}
		break;

		case "pm,am,buh,ph,sh,sl":
			$result = mysql_query("SELECT projectmanager, accountmanager, buhead, practicehead, sepghead, sepglead FROM projectmaster where pindatabaseid='".$project_id."'");
			if(mysql_num_rows($result) == 1) {
				echo $obj_utility->php_to_js(mysql_fetch_assoc($result));
			}
		break;

		case "scm":
			$result = mysql_query("SELECT scm, scmtwo FROM projectmaster where projectname='".$project."'");
			if(mysql_num_rows($result) == 1) {
				echo $obj_utility->php_to_js(mysql_fetch_assoc($result));
			}
		break;

		case "clientSPOC":
			$result = mysql_query("SELECT clientspoc FROM projectmaster where projectname='".$project."'");
			if(mysql_num_rows($result) == 1) {
				echo $obj_utility->php_to_js(mysql_fetch_assoc($result));
			}
		break;

		default:
		break;
	}
}
?>