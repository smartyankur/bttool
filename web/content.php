<?PHP
session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	$_SESSION['login'] = "";
	header ("Location:index.php");
} else{     
	$user=$_SESSION['login'];	 
	include("config.php");

	$query = "select username,role,dept from login where uniqueid='$user';";
	$retval = mysql_query( $query, $con );
	$count = mysql_num_rows($retval);
		
	if($count==0){
		die('Please Contact SEPG; May be You Are Not Registered');
	}
	   
	while($row = mysql_fetch_assoc($retval)){ 
		$role= $row['role'];
	    $dept= $row['dept'];
		$uname= $row['username'];
	}
	$links = array();
	if($role=="PM" || $role=="FM" || $role=="ID FM" || $role=="Media FM" || $role=="Tech FM" || $role=="DM" || $role=="RM" || $role=="PH" || $role=="IQ")
	{
		$links['ncreport.php'] = "For PMs - Find and Respond to NCs";
		$links['closedlist.php'] = "For PMs - Find Closed NCs";
		$links['ncreportglobalresponse.php'] = "For PMs - Give Global Response for NCs";
		$links['ncdreport.php'] = "For PMs - Find NC Density Project-Wise";
		$links['mastercom.php'] = "For PMs - Master Compliance Report";
		$links['sb_review.php'] = "SB Review";
		if($dept=="LMS")
		{
			$links['projection.php'] = "Create, Send QC Projections";
			$links['createtask.php'] = "Create, Send and Manage LMS QC Request";
			$links['managedev.php'] = "Respond to QC issues";
			$links['manageticket.php'] = "Manage Tickets";
		}
		if($dept=="Content")
		{
			$links['funrev.php'] = "Log Predelivery Functional Review Findings";
			$links['qccalc12.php'] = "Link to View Function-Wise QC Defect Status";
		}	
	}
	if($role=="PM" || $role=="FM" || $role=="ID FM" || $role=="Media FM" || $role=="Tech FM" || $role=="DM" || $role=="RM" || $role=="PH" || $role=="IQ" || $role=="QC FM" || $role=="QC") {	
		if($dept=="Content"){
			$links['openbug2.php'] = "For QC Team - Log a New Bug and Manage Status";
			$links['countholdissues.php'] = "Link for Count of Hold Issues";
			$links['chd.php'] = "Link for Course Handover Document";
			
			$links['devcomment.php'] = "For Dev Team - Log Response to Bugs From QC";
			$links['sb_review.php'] = "SB Review";
		}
		$links['project_report.php'] = "Project Report";
	}
	if($role=="QC" || $role=="QC FM" || $role=="IQ"){
		if($dept=="Content"){
			$links['qccomment.php'] = "For QC Team -Log Response to Developers' Comment.";
			$links['qccalc12.php'] = "Link to view function wise QC defect status";
		}
		$links['alloc.php'] = "Receive & Manage QC Request";
		$links['taskclosure.php'] = "Link to Close LMS QC Task";
		$links['lmsbt.php'] = "Link to Log issues or defects.";
		$links['collateral.php'] = "Log ancilliary or collateral issues.";
		$links['managebug.php'] = "Respond to Dev Comments.";
		$links['productlevelbugs.php'] = "Product Level Bugs";
		$links['sb_review.php'] = "SB Review";
		$links['project_report.php'] = "Project Report";
	}
	if($role == 'DEV' || $role == "IQ" || $role == "Tech" || $role == "Media" || $role == "ID" || $role == "ID, Media" || $role == "ID, Tech" || $role == "Tech, Media" || $role == "Tech, ID" || $role == "Media, ID" || $role == "Media, Tech"){
		if($dept=="Content"){
			$links['devcomment.php'] = "For Dev Team - Log Response to Bugs from QC";
			$links['funrev.php'] = "Check Functional Review Findings";
			$links['sb_review.php'] = "SB Review";
			
		}
		if( ($dept=="LMS") && ($uname != 'Parvendra Singh') ){
			$links["projection.php"] = "Create, Send QC Projections";
			$links["createtask.php"] = "Create, Send and Manage LMS QC Request";
			
		}
		$links['project_report.php'] = "Project Report";
		$links["managedev.php"] = "Respond to QC issues";
	}
	if($role=="RM" || $role=="IQ" ){
		$links["utilization.php"] = "Track utilization";
	}
	if($role=="ADMIN" || $role=="IQ"){
		$links["storein.php"] = "Track Store Items";
		$links["additem.php"] = "Add Store Items";
		$links["cabrequest.php"] = "Cab Request Entries";
		$links["cabreport.php"] = "Cab Report Interface";
		$links["cabexpensemail.php"] = "Mail Cab Expenses";
		$links["carstring.php"] = "Cab Search Report";
		$links["food.php"] = "Food Request Interface";
		$links["foodreport.php"] = "Food Report Interface";
		$links["manualeffort.php"] = "Track manual labours";
		$links["travelinvoice.php"] = "Travel Invoice";
	}

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>BT Tool</title>
    <link rel="stylesheet" href="css/style.css" />
	<script type="text/javascript" src="js/jquery.js"></script>
</head>

<body>
    <div class="wrapper">
        <div class="user_box">
            <div class="logo">
                <img src="images/logo.png" alt="" />
            </div>
            <div class="login_area">
                <div class="user_head">Hi <span><?php echo $uname?>!</span></div>
                <div class="welcome_txt">
                    <p><span>W</span>elcome <span>T</span>o <span>RADAR!</span></p>
                </div>
                <form action="">                    
                    <select class="classic">
                        <option value="">Select Option</option>
						<?php foreach($links as $key => $val){ ?>
							<option value="<?php echo $key; ?>"><?php echo $val; ?></option>
						<?php } ?>
                    </select>
                    <br>
                    <button class="subtn" onclick="location.href='logout.php';">Logout</button>
                </form>
            </div>
           
        </div>
    </div>
	<script>
		$(document).ready(function(){
			$(".classic").change(function(){
				var link = $(this).val();
				if(link != '') {
					window.location.href = link;
				}
			});
		});
	</script>
</body>

</html>