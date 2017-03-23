<html>
<head>
<link href="css/ajaxloader.css" rel="stylesheet" type="text/css" media="screen" />
<?php	
	error_reporting(0);
	session_start();
	
	if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
		header ("Location:index.php");
	}
	$user=$_SESSION['login'];

	include("config.php");

	$query = "select username from login where uniqueid='$user'";
	$retval = mysql_query( $query, $con );
	$count = mysql_num_rows($retval);
	
	if($count==0)
	{
		die('Data Not Found Please contact SEPG');
	}

    
	while($row = mysql_fetch_assoc($retval)) 
	{ 
		echo "<br>";
		echo "<br>";
		echo "<h4>"."Hi ".$row['username']." ! Welcome to QC bug logging Tool"."</h4>";
		$username=$row['username'];
	} 	
	if(isset($_GET['message']) && $_GET['message'] != '') {
		echo "<h5 style='color:green'>".$_GET['message']."</h5>";
	}
	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		// Configuration - Your Options
		$allowed_filetypes = array('.doc','.docx','.xls','.xlsx','.jpeg','.jpg','.JPG','.JPEG','.png','.PNG','.bmp','.BMP','.gif','.GIF'); // These will be the types of file that will pass the validation.
		$max_filesize = 1048576; // Maximum filesize in BYTES (currently 1MB).
		$upload_path = './qcfiles/'; // The place the files will be uploaded to (currently a 'files' directory).
		/* @saurav change here to add project_id */
		$pro_id = $_POST['pro_id'];
		$a=mysql_real_escape_string($_POST["project"]);
		$sql="SELECT projectmanager,fmone,fmtwo,fmthree,fmfour FROM projectmaster WHERE pindatabaseid = '".$pro_id."'";
		
		$result = mysql_query($sql);
		$count = mysql_num_rows($result);
	
		if($count==0)
		{
			die('Data Not Found');
		}
	
		while($row = mysql_fetch_array($result))
		{
			$pm=$row['projectmanager']; 
			$fmone=$row['fmone'];
			$fmtwo=$row['fmtwo'];
			$fmthree=$row['fmthree'];
			$fmfour=$row['fmfour']; 
		}
	
		$b="PM :".$pm."| ID FM :".$fmone."|  Media FM :".$fmtwo."|  Scripting FM :".$fmthree."|  QC FM :".$fmfour;
		//$b=mysql_real_escape_string($_POST["fmHint"]);//fm details
		//echo '<pre>'; print_r($_POST); die;
		$f=mysql_real_escape_string($_POST["phase"]);//topic
		$g=mysql_real_escape_string($_POST["module"]);//screen
		$h=mysql_real_escape_string($_POST["topic"]);//qc
		$i= mysql_real_escape_string($_POST["SDate"]);//SData
		$w=strtotime($i);
		$x = date( 'Y-m-d', $w );
		$j=mysql_real_escape_string($_POST["browser"]);//module
		$k= "Accepted"; //mysql_real_escape_string($_POST["coursestatus"]);//topic
		$fun=mysql_real_escape_string($_POST["function"]);//pagenumber
		$l=mysql_real_escape_string($_POST["bcat"]);//pagenumber
		$l1=mysql_real_escape_string($_POST["bscat"]);//pagenumber
		$m=mysql_real_escape_string($_POST["bdr"]);//bug description
		$n=mysql_real_escape_string($_POST["asignee"]);//bug description
		$o=mysql_real_escape_string($_POST["qc"]);
		$p=mysql_real_escape_string($_POST["screen"]);
		$q=mysql_real_escape_string($_POST["severity"]);
		$chd=explode("-",$_POST["course"]);
		//$loggeduser=mysql_real_escape_string($_POST["user"]);
		$filename = $_FILES['userfile']['name']; // Get the name of the file (including file extension).
	
		if($filename<>"")
		{
		   	$ext = substr($filename, strpos($filename,'.'), strlen($filename)-1); // Get the extension from the filename.
		   	// Check if the filetype is allowed, if not DIE and inform the user.
			if(!in_array($ext,$allowed_filetypes)){
				die('The file you attempted to upload is not allowed.Allowed are : doc,docx,xls,xlsx,jpg,jpeg,png,bmp');
			}
		   	//we can also try this : if($_FILES['userfile']['type'] != "image/gif") { echo "Sorry, we only allow uploading GIF images";   exit;}
		 
		   	// Now check the filesize, if it is too large then DIE and inform the user.
		   	if(filesize($_FILES['userfile']['tmp_name']) > $max_filesize)
		      		die('The file you attempted to upload is too large.');
		 
		   	// Check if we can upload to the specified path, if not DIE and inform the user.
		   	if(!is_writable($upload_path))
		      	die('You cannot upload to the specified directory, please CHMOD it to 777.');
		
			$date = date('m/d/Y h:i:s a', time());
			$mydate = date('Y-m-d h:i:s', time());
			
			$values = explode(" ",$date);
			$dates = explode("/", $values[0]);
			$times = explode(":", $values[1]);
			$timex=$dates[1]."_".$dates[0]."_".$dates[2]."_"."T".$times[0]."_".$times[1]."_".$times[2];
			$str=$a."_".$f."_".$timex.$ext;
			$str=mysql_real_escape_string($str);
			
			if(move_uploaded_file($_FILES['userfile']['tmp_name'],$upload_path . $str))
			{
			    $msg='Your file '.$filename.' upload was successful for project :'.$a.' and phase :'.$f.',You can view the file <a href="' . $upload_path . $str . '" title="Your File" target="_blank">here</a>'; // It worked.
			    echo "</br>";
				$query="INSERT INTO qcuploadinfo(project_id, chd_id,project,phase,module,topic,receivedate,browser,coursestatus,function, bcat,bscat,bdr,asignee,qc,screen,filepath,filename,uploaddate,severity,whenchangedstatus,whochangedstatus) values('".$pro_id."','".$chd[0]."','".$a."','".$f."','".$g."','".$h."','".$x."','".$j."','".$k."','".$fun."','".$l."','".$l1."','".$m."','".$n."','".$o."','".$p."','".$str."','".$filename."','".$mydate."','".$q."','".$mydate."','".$username."')";
			
				
				if (mysql_query($query))
				{
					//echo "Record created with id :".$row['id']." and description :".$w;
					header ("Location: openbug2.php?message=".urlencode($msg)."&proj=".urlencode($a)."&fmdetails=".urlencode($b)."&phase=".urlencode($f)."&module=".urlencode($g)."&topic=".urlencode($h)."&receivedate=".urlencode($i)."&browser=".urlencode($j)."&coursestatus=".urlencode($k)."&function=".urlencode($fun)."&bcat=".urlencode($l)."&bscat".urlencode($l1)."&bdr=".urlencode($m)."&asignee=".urlencode($n)."&qc=".urlencode($o)."&screen=".urlencode($p)."&severity=".urlencode($q)."&course=".urlencode($_POST["course"]));
				}
				else
				{
					echo "Uploadinfo table couldn't be updated.";
					exit();
				}
			}	  
		   	else {
				echo 'There was an error during the file upload.  Please try again.'; // It failed :(.
			}
			exit();
		
		} //this is end of if which is checking whether filename is blank or not.
		else //filename is blank means the user has not uploaded any file.
		{
			//$date = date('m/d/Y h:i:s a', time());
			$mydate = date('Y-m-d h:i:s', time());     
			$query="INSERT INTO qcuploadinfo(project_id,chd_id, project,phase,module,topic,receivedate,browser,coursestatus,function,bcat,bscat,bdr,asignee,qc,screen,uploaddate,severity,whenchangedstatus,whochangedstatus) values('".$pro_id."','".$chd[0]."','".$a."','".$f."','".$g."','".$h."','".$x."','".$j."','".$k."','".$fun."','".$l."','".$l1."','".$m."','".$n."','".$o."','".$p."','".$mydate."','".$q."','".$mydate."','".$username."')";
	    		
			if (mysql_query($query))
	       	{
				//echo "Record created with id :".$row['id']." and description :".$w;
				$msg="The bug has been logged without file. You can click on Show All Fileinfo to see the details";
				//header ("Location: openbug2.php?message=".urlencode($msg)."&proj=".urlencode($a)."&pm=".urlencode($b));
			  	header ("Location: openbug2.php?message=".urlencode($msg)."&proj=".urlencode($a)."&fmdetails=".urlencode($b)."&phase=".urlencode($f)."&module=".urlencode($g)."&topic=".urlencode($h)."&receivedate=".urlencode($i)."&browser=".urlencode($j)."&coursestatus=".urlencode($k)."&function=".$fun."&bcat=".urlencode($l)."&bscat=".urlencode($l1)."&bdr=".urlencode($m)."&asignee=".urlencode($n)."&qc=".urlencode($o)."&screen=".urlencode($p)."&severity=".urlencode($q)."&course=".urlencode($_POST["course"]));
		   	} else {
	        	echo "Uploadinfo table couldn't be updated.";
				exit();
		   	}
		}
	}
	mysql_close($con);
?>
<style type="text/css">
body
{
background:url('qcr.jpg') no-repeat;
}
.button
{
background-color: #F7941C;
border-bottom:#F7941C;
border-left: #F7941C;
border-right:#F7941C;
border-top: #F7941C;
color: black;
font-family: Tahoma
box-shadow:2px 2px 0 0 #014D06,;
border-radius: 10px;
border: 1px outset #b37d00 ;
}
</style>
<script src="js/jquery.js"></script>
<script src="js/jquery.selectboxes.js"></script>
<script>
$(document).ready(function(){
	$('.loaderParent').hide();
	$('.loader').hide();	
});
</script>
</head>
<body onload="populateInfo();">
<script type="text/javascript">
var active_filter ='';
var filter_value = '';
function editbug(mtr) {
 mywindow=window.open ("edit.php?id="+mtr,"Ratting","scrollbars=1,width=550,height=170,0,status=0,");
 if (window.focus) {mywindow.focus()}
}

function displayRecords(numRecords, pageNum) {
		
	str = document.forms["tstest"]["project"].value;
	pro_id = document.forms["tstest"]["project"].options[document.forms['tstest']['project'].selectedIndex].getAttribute('ref');
	chd = document.forms["tstest"]["course"].value;
	/*if($('#filter_name').length) {
		$('#filter_name').val(active_filter);
		$('#'+active_filter).show();
		$('#'+active_filter.replace('filter_','')+'1').val(filter_value);
		$('#filter_submit').show();
	}*/
	if($('#filter_name').length) {
		if($('#filter_name').val() != '') {
			var fname = $('#filter_name').val().replace('filter_','')+'1';
			var fvalue = $('#'+$('#filter_name').val().replace('filter_','')+'1').val();
			var bscatval = $("#bscat1").val();
			filter_value = fvalue;
			if(fvalue != '') {
				$.ajax({
					type: "GET",
					url: "pagination/getRecord.php",
					data: "show=" + numRecords + "&pagenum=" + pageNum+"&q="+str+"&id="+pro_id+"&filter_name="+$('#filter_name').val()+"&"+fname+"="+fvalue+"&bscat="+bscatval+"&chd_id="+chd,
					cache: false,
					beforeSend: function() {
						$('.loader').show();
						$('.loaderParent').show();
						//$('.loader').html('<img src="pagination/loader.gif" alt="" width="24" height="24" style="padding-left: 400px; margin-top:10px;" >');
					},
					success: function(html) {
						$("#txtHint").html(html);
						//$('.loader').html('');
						$('.loader').hide();
						$('.loaderParent').hide();
					}
				});
				
				
			}

		}
	} else {
		$.ajax({
			type: "GET",
			url: "pagination/getRecord.php",
			data: "show=" + numRecords + "&pagenum=" + pageNum+"&q="+str+"&id="+pro_id+"&chd_id="+chd,
			cache: false,
			beforeSend: function() {
				$('.loader').show();
				$('.loaderParent').show();
				//$('.loader').html('<img src="pagination/loader.gif" alt="" width="24" height="24" style="padding-left: 400px; margin-top:10px;" >');
			},
			success: function(html) {
				$("#txtHint").html(html);
				//$('.loader').html('');
				$('.loader').hide();
				$('.loaderParent').hide();
			}
		});
	}
	
}

function changeDisplayRowCount(numRecords) {
		$('.loader').show();
		$('.loaderParent').show();
	displayRecords(numRecords, 1);
}

function showAll()
{
	displayRecords(10, 1);
}

/* @saurav Modify to do process using project id */
function changefms() {
 var project = trim(document.getElementById('project').value);
 var pro_id = document.forms["tstest"]["project"].options[document.forms['tstest']['project'].selectedIndex].getAttribute('ref');
 if(project=="Select") {alert("Please select the project"); return false;}
 project=encodeURIComponent(project);
 mywindow=window.open ("changepmfm.php?id="+project+"&pro_id="+pro_id,"Ratting","scrollbars=1,width=550,height=170,0,status=0,");
 if (window.focus) {mywindow.focus()}
}

/* @saurav Modify to do process using project id */
function changeemail() {
 var project = trim(document.getElementById('project').value);
 var pro_id = document.forms["tstest"]["project"].options[document.forms['tstest']['project'].selectedIndex].getAttribute('ref');
 if(project=="Select") {alert("Please select the project"); return false;}
 mywindow=window.open ("changepmmail.php?id="+project+"&pro_id="+pro_id,"Ratting","scrollbars=1,width=550,height=170,0,status=0,");
 if (window.focus) {mywindow.focus()}
}

/* @saurav Modify to do process using project id */
function showmailwin() {
 var project = trim(document.getElementById('project').value);
 var pro_id = document.forms["tstest"]["project"].options[document.forms['tstest']['project'].selectedIndex].getAttribute('ref');
 var phase = trim(document.getElementById('phase').value);
 var course = trim(document.getElementById('course').value);
 if(project=="Select") {alert("Please select the project"); return false;}
 if(phase=="select") {alert("Please select the phase"); return false;}
 if(course=="") {alert("Course Required"); return false;}
 project=encodeURIComponent(project);
 phase=encodeURIComponent(phase);
 mywindow=window.open ("getid.php?pro="+project+"&pro_id="+pro_id+"&phs="+phase+"&chd="+course,"Ratting","scrollbars=1,width=600,height=600,0,status=0,");
 if (window.focus) {mywindow.focus()}
}

function rejectcourse() {
 var project = trim(document.getElementById('project').value);
 var pro_id = document.forms["tstest"]["project"].options[document.forms['tstest']['project'].selectedIndex].getAttribute('ref');
 var phase = trim(document.getElementById('phase').value);
 var course = trim(document.getElementById('course').value);
 if(project=="Select") {alert("Please select the project"); return false;}
 if(phase=="select") {alert("Please select the phase"); return false;}
 if(course=="") {alert("Course Required"); return false;}
 project=encodeURIComponent(project);
 phase=encodeURIComponent(phase);
 mywindow=window.open ("rejectcourse.php?pro="+project+"&pro_id="+pro_id+"&phs="+phase+"&chd="+course,"Ratting","scrollbars=1,width=600,height=600,0,status=0,");
 if (window.focus) {mywindow.focus()}
}

function submitresponse(str) {
	var ptr = document.getElementById(str).value;
	if (ptr=="select") {
		alert ("The status must be selected");
		//document.getElementById(str).focus();
		return false;
	}

	if (str=="") {
		document.getElementById("ResHint").innerHTML="";
		return;
	}

	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} else {
		// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}

	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById("ResHint").innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET","updatecoursestat.php?q="+str+ "&r=" + ptr,true);
	xmlhttp.send();
}


function submitbugresponse(str) {
	qtr = "bug".concat(str); 
	var ptr = document.getElementById(qtr).value;
	var lutr = document.getElementById('luser').value;
    if (ptr=="select") {
		alert ("The status must be selected");
		//document.getElementById(str).focus();
		return false;
	}

	if (str=="") {
		document.getElementById("ResHint").innerHTML="";
		return;
	}

	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} else {
		// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}

	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById("ResHint").innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET","updatebugstat.php?q="+str+ "&r=" + ptr+ "&s=" + lutr,true);
	xmlhttp.send();
}


function verify() {
	var numericExpression = /^[0-9]+$/;
	var alphaExp = /^[a-zA-Z /s]*$/;
	var alphanumericExp = /^[0-9a-zA-Z._, /s]*$/;
	var project = trim(document.getElementById('project').value);
	var pro_id = document.forms["tstest"]["project"].options[document.forms['tstest']['project'].selectedIndex].getAttribute('ref');
	//var projectmanager = trim(document.getElementById('projectmanager').value);
	//var idfm = trim(document.getElementById('idfm').value);
	//var medfm = trim(document.getElementById('medfm').value);
	//var scrfm = trim(document.getElementById('scrfm').value);
	var phase = trim(document.getElementById('phase').value);
	var module = trim(document.getElementById('module').value);
	var topic = trim(document.getElementById('topic').value);
	var screen = trim(document.getElementById('screen').value);
	var qc = trim(document.getElementById('qc').value);
	var severity = trim(document.getElementById('severity').value);
	var asignee = trim(document.getElementById('asignee').value);
	var SDate = trim(document.getElementById('SDate').value);
	var browser = trim(document.getElementById('browser').value);
	//var coursestatus = trim(document.getElementById('coursestatus').value);
	var bcat = trim(document.getElementById('bcat').value);
	var bscat = trim(document.getElementById('bscat').value);
	var func = trim(document.getElementById('function').value);
	var bug = trim(document.getElementById('bdr').value);
	if(project=="Select") {
		alert("Project must be selected");
		return false;
	}

	if(phase=="select") {
		alert("Phase must be selected");
		return false;
	}

if(module=="")
  {
  alert("Module Name should be identified");
  return false;
  }
 
if(topic=="")
  {
  alert("Topic should be identified");
  return false;
  }
  
if(screen=="")
  {
  alert("Screen details should be identified");
  return false;
  }
 
if(qc=="select")
  {
  alert("QC must be identified");
  return false;
  }
 
if(severity=="")
  {
  alert("Severity must be identified");
  return false;
  }

if(asignee=="select")
  {
  alert("Asignee must be identified");
  return false;
  }

/*if(SDate=="")
  {
  alert("Date on which received must be selected");
  return false;
  }*/
 
if(browser=="select")
  {
  alert("Browser should be identified");
  return false;
  }
 
if(func == "") {
	alert("Function should be identified");
	return false;
}
if(bcat=="")
  {
  alert("Bug category should be identified");
  return false;
  }
  if(bscat=="")
  {
  alert("Bug sub category should be identified");
  return false;
  }
  if(bug=="")
  {
  alert("Bug description should be given");
  return false;
  }


  /*if(!module.match(alphanumericExp))
  {
  alert("Module Name Should be Purely Alphanumeric");
  return false;
  }
  
  if(!screen.match(alphanumericExp))
  {
  alert("Screen Details Should be Purely Alphanumeric");
  return false;
  }

  if(!topic.match(alphanumericExp))
  {
  alert("Topic Details Should be Purely Alphanumeric");
  return false;
  }*/

 
  /*if(!bug.match(alphanumericExp))
  {
  alert("Please don't use special characters in description");
  return false;
  }*/

}


function toggleFilter(source){
	if(active_filter != '') {
		$('#'+active_filter).hide();
		$('#'+active_filter.replace('filter_','')).val('');	
	} 
	if($('#filter_name').val() != ''){
		$('#filter_submit').show();
	} else {
		$('#filter_submit').hide();
	}

	if($('#filter_name').val() != ''){
		$('#'+$('#filter_name').val()).show();
	}

	active_filter = $('#filter_name').val();

	/*
	if(active_filter == '')  {
		location.href='?project_name='+$('#project').val();
	}
	*/
	
}



function getfm()
{
 document.getElementById("txtHint").innerHTML="";
 str=document.forms["tstest"]["project"].value;
 pro_id = document.forms["tstest"]["project"].options[document.forms['tstest']['project'].selectedIndex].getAttribute('ref');
 $("#pro_id_hidden").val(pro_id);

 if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    
	document.getElementById("fmHint").innerHTML=xmlhttp.responseText;
	getFilter();
    }
  }
str=encodeURIComponent(str);
xmlhttp.open("GET","getfminfo.php?q="+str+"&pro_id="+pro_id,true);
xmlhttp.send();

}

function getFilter()
{
 document.getElementById("filtersHint").innerHTML="";
 pro=document.forms["tstest"]["project"].value;
 pro_id = document.forms["tstest"]["project"].options[document.forms['tstest']['project'].selectedIndex].getAttribute('ref');
 if(pro != "Select") {
	 if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById("filtersHint").innerHTML=xmlhttp.responseText;
		}
	  }
	str=encodeURIComponent(str);
	xmlhttp.open("GET","getfilterinfo.php?q="+pro+"&pro_id="+pro_id,true);
	xmlhttp.send();
 } 
}


function populateInfo(){
  //var arrSelected = $('#project').selectedValues();
  var project = document.forms["tstest"]["project"].value;
  var pro_id = (document.forms["tstest"]["project"].options[document.forms['tstest']['project'].selectedIndex].getAttribute('ref')) ? document.forms["tstest"]["project"].options[document.forms['tstest']['project'].selectedIndex].getAttribute('ref') : 'null';
  if(project != '' && project != undefined) {
	  $('#qc').removeOption(/./);
	  $('#asignee').removeOption(/./);
	  $("#course").removeOption(/./);
	  $('#qc').ajaxAddOption(
	    'getProjectInfo.php?q='+project+'&pro_id='+pro_id+'&mode=testers',
	    {},
		false,
		function(){
			$(this).selectOptions('<?=$_REQUEST["qc"]?>');
		}
	  );
	
	   $('#asignee').ajaxAddOption(
	    'getProjectInfo.php?q='+project+'&pro_id='+pro_id+'&mode=developers',
	    {},
		false,
		function(){
			$(this).selectOptions('<?=$_REQUEST["asignee"]?>');
		}
	  );
	  
	  $('#course').ajaxAddOption(
	    'getCourseInfo.php?q='+project+'&pro_id='+pro_id,
	    {},
		false,
		function(){
			$('#course').trigger('change');
			$(this).selectOptions('<?=$_REQUEST["course"]?>');
		}
	  );
	  getfm();
	  
  }
}
/*Saurav added For course and phase*/
$(document).ready(function(){
	var phase = '';
	
	$('#course').change(function(){
	    var course = $(this).val();
		$.get(
	    'getPhaseInfo.php',
	    {q:course},
		function(data){
			var data1 = $.parseJSON(data);
			phase = data1.version;
			$("#phase").val(data1.version);
			$("#SDate").val(data1.start_date);
		}
	  );
	});
	
	$('#bcat').change(function(){
		var cat = $(this).val();
		$.get(
	    'getsubcat.php',
	    {cat:cat},
		function(data){
			var data = $.parseJSON(data);
			var str = '<option value="">Select Sub Category</option>';
			for(var i = 0; i < data.length; i++) {
				
				str += '<option value="'+data[i].id+'">'+data[i].category+'</option>'; 
			}
			$("#bscat").html(str);
		}
	  );
	});
	$("#bscat").change(function() {
		var subcat = $(this).val();
		$.get(
			'getsubcat.php',
			{subcat:subcat},
			function(data){
				$("#severity").val(data.trim());
			}
		);
	});
	
	$("#phase").change(function(){
		if( phase != $(this).val() && $(this).val() != 'select') {
			$("#pahse_hint").html('Phase Selected Differs from the phase given in the CHD');
		} else {
			$("#pahse_hint").html('');
		}
	});

	$("#bcat1").live('change', function(){
		var cat = $(this).val();
		if(cat != "select") {
			$.get(
				'getsubcat.php',
				{cat:cat},
				function(data){
					var data = $.parseJSON(data);
					var str = '<option value="select">All</option>';
					for(var i = 0; i < data.length; i++) {
						
						str += '<option value="'+data[i].id+'">'+data[i].category+'</option>'; 
					}
					$("#bscat1").html(str);
					$("#filter_bscat").show();
				}
			);
		} else {
			$("#bscat1").html('');
			$("#filter_bscat").hide();
		}
	});
	
});

/*           End               */

function trim(s)
{
	return rtrim(ltrim(s));
}

function ltrim(s)
{
	var l=0;
	while(l < s.length && s[l] == ' ')
	{	l++; }
	return s.substring(l, s.length);
}

function rtrim(s)
{
	var r=s.length -1;
	while(r > 0 && s[r] == ' ')
	{	r-=1;	}
	return s.substring(0, r+1);
}

function export123(){
	if($('#project').val() != '') {
		var fname = $('#filter_name').val().replace('filter_','')+'1';
		var fvalue = $('#'+$('#filter_name').val().replace('filter_','')+'1').val();
        var pro_id = document.forms["tstest"]["project"].options[document.forms['tstest']['project'].selectedIndex].getAttribute('ref');
		var chd = document.forms["tstest"]["course"].value;
		var bscatval = $("#bscat1").val();
		var win = '';
		if($('#filter_name').val() != '' && $('#filter_name').val() != undefined && fvalue!='' && fvalue != undefined && fvalue != 'select') {
			//alert('exportbugs.php?mode=openbug&q='+$('#project').val()+'&mode=export&filter_name='+$('#filter_name').val()+'&'+fname+'='+fvalue);
			win = window.open('exportbugs.php?mode=openbug&q='+$('#project').val()+'&pro_id='+pro_id+'&filter_name='+$('#filter_name').val()+'&'+fname+'='+fvalue+'&bscat='+bscatval+'&chd_id='+chd);
		} else {
			//alert('exportbugs.php?mode=openbug&q='+$('#project').val()+'&mode=export');
			win = window.open('exportbugs.php?mode=openbug&q='+$('#project').val()+'&pro_id='+pro_id+'&chd_id='+chd);
			
		}
		setTimeout(function(){ win.close(); }, 2000);

		window.clearTimeout();
	}else {
		alert('Please select project');
	}
}

function exportAll(){
	if($('#project').val() != '') {
		var fname = $('#filter_name').val().replace('filter_','')+'1';
		var fvalue = $('#'+$('#filter_name').val().replace('filter_','')+'1').val();
        var pro_id = document.forms["tstest"]["project"].options[document.forms['tstest']['project'].selectedIndex].getAttribute('ref');
		//var chd = document.forms["tstest"]["course"].value;
		if($('#filter_name').val() != '' && $('#filter_name').val() != undefined && fvalue!='' && fvalue != undefined && fvalue != 'select') {
			//alert('exportbugs.php?mode=openbug&q='+$('#project').val()+'&mode=export&filter_name='+$('#filter_name').val()+'&'+fname+'='+fvalue);
			window.open('exportbugs.php?mode=openbug&q='+$('#project').val()+'&pro_id='+pro_id+'&filter_name='+$('#filter_name').val()+'&'+fname+'='+fvalue);
		} else {
			//alert('exportbugs.php?mode=openbug&q='+$('#project').val()+'&mode=export');
			window.open('exportbugs.php?mode=openbug&q='+$('#project').val()+'&pro_id='+pro_id);
		}
	}else {
		alert('Please select project');
	}
}

function submitresponse_devcomment(str)
{
	rstr="round"+str;
	var ptr = trim(document.getElementById(str).value);
	var auditee=document.forms["tstest"]["luser"].value;
	var round= trim(document.getElementById(rstr).value);
	
	if (ptr=="")
	{
		alert ("The response box is empty");
		return false;
	}
	
	if (round=="Select")
	{
		alert ("Please select the round");
		return false;
	}
	
	
	if (str=="")
	{
		document.getElementById("ResHint").innerHTML="";
		return;
	}

	if (window.XMLHttpRequest)
	{
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}else{
		// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}

	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			alert(xmlhttp.responseText);
		}
	}
	ptr= encodeURIComponent(ptr);
	xmlhttp.open("GET","qcresponse.php?q="+str+ "&r=" + ptr+ "&s=" + auditee+ "&t=" + round,true);
	xmlhttp.send();
}



</script>
<script language="JavaScript" src="datetimepicker.js">
</script>
<form name="tstest" action="./openbug2.php" onSubmit="return verify();" method="post" enctype="multipart/form-data">
<TABLE>
<TR>
	<TD>Project Name</TD>
	<td>
    <?php
	include("config.php");
    $query = "select DISTINCT projectname, pindatabaseid from projectmaster where projectmanager= '$username' or accountmanager= '$username' or buhead='$username' or practicehead='$username' or sepghead='$username' or sepglead='$username' or md='$username' or ceo = '$username' or fmfour='$username' or fmthree='$username' or fmtwo='$username' or fmone='$username' or lead='$username' or tester1='$username' or tester2='$username' or tester3='$username' or tester4='$username' or tester5='$username' or tester6='$username' or tester7='$username' or tester8='$username' order by projectname";
    
	$retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	//$m=$_REQUEST["project"];
	
	if($count==0)
		{
			die('Data Not Found');
		}

    echo "<select name=\"project\" id=\"project\" onchange=\"getfm(); populateInfo()\">"; 
    echo "<option size =30 selected>Select</option>";
    $proj=$_REQUEST["proj"];
    $pro_id=$_REQUEST["pro_id"];
	$fmdetails=$_REQUEST["fmdetails"];
	$phase=$_REQUEST["phase"];
	$module=$_REQUEST["module"];
	$topic=$_REQUEST["topic"];
    $receivedate=$_REQUEST["receivedate"];
	//$receivedate = date( 'dd-MMM-yy', strtotime($receivedate) );
	$browser=$_REQUEST["browser"];
	$coursestatus=$_REQUEST["coursestatus"];
	$bcat=$_REQUEST["bcat"];
	$bscat=$_REQUEST["bscat"];
	$bdr=$_REQUEST["bdr"];
	$asignee=$_REQUEST["asignee"];
	$qc=$_REQUEST["qc"];
	$screen=$_REQUEST["screen"];
	$severity=$_REQUEST["severity"];
	$phase=$_REQUEST["phase"];
	$function = $_REQUEST["function"];
	//$sdate = $_REQUEST["SDate"];
	
	
	if(mysql_num_rows($retval)) 
    { 
    while($row = mysql_fetch_assoc($retval)) 
    {
		if(strlen($row[projectname])<>0)
		{
		 ?>
         <option <?php if($proj==$row[projectname]) echo " selected";?> ref="<?php echo $row[pindatabaseid] ?>"><?php echo $row[projectname];?></option> 
         <?php 
		}
	} 
 
    } 
    else {
		echo "<option>No Names Present</option>";  
    } 
    ?>
    </td>
</TR>

<TR>
<td>FM Details</td><td><div name="fmHint" id="fmHint"><?php echo $fmdetails;?></div></td>
<input type="hidden" name="pro_id" id="pro_id_hidden" value="" />
</TR>

<TR>
<TD>Course</TD><TD><select name="course" size="1" id="course">
<option value="select">Select</option>

</select></TD>
</TR>

<TR>
<!--<TD>Phase</TD><TD><select name="phase" size="1" id="phase">
<option value="select" selected>Select</option>
<option value="alpha">Alpha</option>
<option value="beta">Beta</option>
<option value="gold">Gold</option>
</select>&nbsp;&nbsp;<span id="pahse_hint"></span></TD>-->
<input type="hidden" name="phase" id="phase" value="<?php echo $phase?>"/>
</TR>

<TR>
<TD>Module Name</TD>
<TD><input type=text size=42 name="module" id="module" value="<?php echo $module;?>">-Please use only alphabets and numbers</TD>
</TR>

<TR>
<TD>Topic Name</TD>
<TD><input type=text size=42 name="topic" id="topic" value="<?php echo $topic;?>">-Please use only alphabets and numbers</TD>
</TR>

<TR>
<TD>Screen Details</TD>
<TD><input type=text size=42 name="screen" id="screen" value="<?php echo $screen;?>">-Please use only alphabets and numbers</TD>
</TR>

<TR>
<TD>Raised by</TD>
<TD>
    <?php

    echo "<select name=\"qc\" id=\"qc\" >"; 
    echo "<option size =30 selected value=\"select\">Select</option>";

    /*************** List of testers is now fetched from projectmaster table. *****************/
    /*
    $query = "select DISTINCT username from login order by username";
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Users Not Found; Contact SEPG');
		}
    
	if(mysql_num_rows($retval)) 
    { 
    while($row = mysql_fetch_assoc($retval)) 
    { 
    //echo "<option>$row[username]</option>";
	if(strlen($row[username])<>0)
		{
		 ?>
         <option<?php if($qc==$row[username])echo " selected";?>><?php echo $row[username];?></option> 
         <?php 
		}

    } 
    } 
    else 
	{
     echo "<option>No Names Present</option>";  
    } 
    */


    ?>
    </TD>
</TR>




<TR>
<TD>Assignee</TD>
<TD>
    <?php
	$query = "select DISTINCT username from login order by username";
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Users Not Found; Contact SEPG');
		}

    echo "<select name=\"asignee\" id=\"asignee\">"; 
    echo "<option size =30 selected value=\"select\">Select</option>";
    
	if(mysql_num_rows($retval)) 
    { 
    while($row = mysql_fetch_assoc($retval)) 
    { 
     //echo "<option>$row[username]</option>";
	 if(strlen($row[username])<>0)
		{
		 ?>
         <option<?php if($asignee==$row[username])echo " selected";?>><?php echo $row[username];?></option> 
         <?php 
		}
    } 
    } 
    else 
	{
     echo "<option>No Names Present</option>";  
    } 
    ?>
    </TD>
</TR>

<TR>
<!--<TD>Project Received On</TD>-->
<TD><input type="hidden" id="SDate" value="<?php echo $receivedate;?>" maxlength="20" size="9" name="SDate">
<!--<a href="javascript:NewCal('SDate','ddmmmyyyy')"><img src="cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>--></TD>
</TR>

<TR>
<TD>Bowser Used</TD>
<?php
	$query = "select browser from tbl_browsers order by browser";
    $retval = mysql_query( $query, $con );
?>
<TD><select name="browser" size="1" id="browser">
<option value="select">Select</option>
<?php while($row = mysql_fetch_assoc($retval)) { ?>
	<option value="<?php echo $row['browser']?>" <?php if($browser == $row['browser']) echo "selected"; ?>><?php echo $row['browser']?></option>
<?php } ?>	
</select></TD>
</TR>

<!--<TR>
<TD>Course Status</TD>
<TD><select name="coursestatus" size="1" id="coursestatus">
<option value="select">Select</option>
<option value="accepted" <?php if($coursestatus=="accepted")echo " selected";?>>Accepted</option>
<option value="rejected" <?php if($coursestatus=="rejected")echo " selected";?>>Rejected</option>
</select></TD>
</TR>-->

<TR>
<TD>Function</TD>
<TD>
	<select name="function" size="1" id="function">
		<option value="">Select</option>
		<option <?php if($function == "Media") echo "selected" ?> value="Media">Media</option>
		<option <?php if($function == "Functionality") echo "selected" ?> value="Functionality">Functionality</option>
		<option <?php if($function == "Editorial") echo "selected" ?> value="Editorial">Editorial</option>
	</select>
</TD>
</TR>
<TD>Bug Category</TD>
<TD>
	<?php $query = "select id, category from tbl_category where parent_id = 0"; 
		  $res = mysql_query( $query, $con );
	?>
	<select name="bcat" size="1" id="bcat">
		<option value="">Select Category</option>
		<?php 
			while($row = mysql_fetch_assoc($res)) 
			{
			?>
				<option <?php if($bcat==$row['id']) echo " selected";?> value="<?php echo $row['id']?>"><?php echo $row['category'];?></option> 
			<?php			
			}
		?>
	</select>
</TD>
</TR>
<TR>
<TD>Bug Sub Category</TD>
<TD>
	<?php if(isset($bcat)) {
			  $query = "select id, category from tbl_category where parent_id = $bcat"; 
			  $res = mysql_query( $query, $con );
		}
	?>
	<select name="bscat" size="1" id="bscat">
		<option value="">Select</option>
		<?php 
			while($row = mysql_fetch_assoc($res)) 
			{
			?>
				<option <?php if($bscat==$row['id']) echo "selected";?> value="<?php echo $row['id']?>"><?php echo $row['category'];?></option> 
			<?php			
			}
		?>
	</select>
</TD>
</TR>
<TR>
<TD>Severity</TD>
<TD>
<select name="severity" id="severity">
	<option value="">Select</option>
	<option value="High" <?php if($severity == "High") echo "selected"?>>High</option>
	<option value="Low" <?php if($severity == "Low") echo "selected"?>>Low</option>
	<option value="Medium" <?php if($severity == "Medium") echo "selected"?>>Medium</option>
	<option value="Suggestion" <?php if($severity == "Suggestion") echo "selected"?>>Suggestion</option>
</select>
</TD>
</TR>

<TR>
<TD>Bug Description</TD>
<TD><textarea name="bdr" rows="4" cols="30" id="bdr"><?php echo stripslashes($bdr);?></textarea></TD>
</TR>

<TR>
<TD>Select a file:</TD><TD><input type="file" name="userfile" id="file"> Only .doc, .docx, .xls, .xlsx, .jpg, .jpeg, .png, .bmp, .gif and max size 1 MB</TD>
</TR>

<TR>
	<TD>
		Select filters to view bug
	</TD>
	<TD>
		<div id="filtersHint" name="filtersHint"></div>
	</TD>
</TR>
</TABLE>
<br>
<input type="hidden" id="luser" value="<?php echo $username;?>">
<input type="submit" class="button" value="Upload or Submit">

<!--<input type="button" class="button" value="Show All Fileinfo" onclick="showAll();return false;">-->
<input type="button" class="button" value="Send Mail" onclick="showmailwin()">
<!--<input type="button" class="button" value="Change PM and FM details" onclick="changefms()">-->
<!--<input type="button" class="button" value="Create or change email ID of PM/FM" onclick="changeemail()">-->
<input type="button" class="button" value="Reject Course" onclick="rejectcourse()">
<input type="button" class="button" value="Log Out" onclick="location.href='logout.php';">
<br>
<br>
<div id="ResHint"></div>

<div id="txtHint"><?php $m=$_REQUEST["message"]; $l=$_REQUEST["proj"];if($m<>""){echo $m;}?></div>
</form>
	<?php mysql_close($con); ?>
	<div class="loaderParent"></div>
	<div class="loader">
		<span></span>
		<span></span>
		<span></span>
	</div>

</body>
</html> 