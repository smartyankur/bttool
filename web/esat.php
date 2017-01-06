<?php
session_start();
error_reporting(0);
if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	$_SESSION['login'] = "";
	header ("Location:survey.php");
}

else 
{     
$user=$_SESSION['login'];	 
include('config.php');

$query = "select name,empid from surveylogin where passwd='$user';";
$retval = mysql_query( $query, $con );
$count = mysql_num_rows($retval);
	
if($count==0)
{
 die('Please Contact SEPG; May be You Are Not Registered');
}
   
while($row = mysql_fetch_assoc($retval)) 
{ 
 $logged=$row['name'];
 $empid=$row['empid'];
 echo "</br>";
 echo "</br>";
 echo "</br>";
 echo "<h3>"."Hi ".$row['name']." ! Welcome To ESAT Survey"."</h3>"; 
}

 $vquery="select * from esat where user='$logged'";
 //echo $vquery;
 $vretval=mysql_query($vquery, $con) or die (mysql_error());
 $tot_rows = mysql_num_rows($vretval); 
 //echo "number of rows :".$total_rows;
 if($tot_rows>0)
 {
  header('Location:thanks.php'); 
 } 
}

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
 $Q11=mysql_real_escape_string($_POST['Q11']);
 $Q12=mysql_real_escape_string($_POST['Q12']);
 $Q13=mysql_real_escape_string($_POST['Q13']);
 $Q14=mysql_real_escape_string($_POST['Q14']);
 $Q15=mysql_real_escape_string($_POST['Q15']);
 $Q21=mysql_real_escape_string($_POST['Q21']);
 $Q21a=mysql_real_escape_string($_POST['Q21a']);
 $Q22=mysql_real_escape_string($_POST['Q22']);
 $Q23=mysql_real_escape_string($_POST['Q23']);
 $Q24=mysql_real_escape_string($_POST['Q24']);
 $Q24a=mysql_real_escape_string($_POST['Q24a']);
 $Q25=mysql_real_escape_string($_POST['Q25']);
 $Q26=mysql_real_escape_string($_POST['Q26']);
 $Q31=mysql_real_escape_string($_POST['Q31']);
 $Q31a=mysql_real_escape_string($_POST['Q31a']);
 $Q32=mysql_real_escape_string($_POST['Q32']);
 $Q32a=mysql_real_escape_string($_POST['Q32a']);
 $Q33=mysql_real_escape_string($_POST['Q33']);
 $Q34=mysql_real_escape_string($_POST['Q34']);
 $Q35=mysql_real_escape_string($_POST['Q35']);
 $Q36=mysql_real_escape_string($_POST['Q36']);
 $Q37=mysql_real_escape_string($_POST['Q37']);
 $Q38=mysql_real_escape_string($_POST['Q38']);
 $Q41=mysql_real_escape_string($_POST['Q41']);
 $Q42=mysql_real_escape_string($_POST['Q42']);
 $Q43=mysql_real_escape_string($_POST['Q43']);
 $Q46=mysql_real_escape_string($_POST['Q46']);
 $Q47=mysql_real_escape_string($_POST['Q47']);
 $Q51=mysql_real_escape_string($_POST['Q51']);
 $Q52=mysql_real_escape_string($_POST['Q52']);
 $Q54=mysql_real_escape_string($_POST['Q54']);
 $Q56=mysql_real_escape_string($_POST['Q56']);
 $Q57=mysql_real_escape_string($_POST['Q57']);
 $Q59=mysql_real_escape_string($_POST['Q59']);
 $Q59a=mysql_real_escape_string($_POST['Q59a']);
 $Q510=mysql_real_escape_string($_POST['Q510']);
 $Q511=mysql_real_escape_string($_POST['Q511']);
 $Q511a=mysql_real_escape_string($_POST['Q511a']);
 $Q512=mysql_real_escape_string($_POST['Q512']);
 $Q61=mysql_real_escape_string($_POST['Q61']);
 $Q61a=mysql_real_escape_string($_POST['Q61a']); 
 $Q62=mysql_real_escape_string($_POST['Q62']);
 $Q62a=mysql_real_escape_string($_POST['Q62a']);
 $Q63=mysql_real_escape_string($_POST['Q63']);
 $Q64=mysql_real_escape_string($_POST['Q64']);
 $Q65=mysql_real_escape_string($_POST['Q65']);
 $Q66=mysql_real_escape_string($_POST['Q66']);
 $Q67=mysql_real_escape_string($_POST['Q67']);
 $user=mysql_real_escape_string($_POST['loggeduser']);
 $empid=mysql_real_escape_string($_POST['empid']);

 $chkuery="select * from esat where user='$user'";
 $cretval=mysql_query( $chkuery, $con ) or die (mysql_error());
 $total_rows = mysql_num_rows($cretval); 
 //echo "number of rows :".$total_rows;
 if($total_rows==0)
 {
 //echo "Hello";
 $cquery="insert into esat(empid,user,Q11,Q12,Q13,Q14,Q15,Q21,Q21a,Q22,Q23,Q24,Q24a,Q25,Q26,Q31,Q31a,Q32,Q32a,Q33,Q34,Q35,Q36,Q37,Q38,Q41,Q42,Q43,Q46,Q47,Q51,Q52,Q54,Q56,Q57,Q59,Q59a,Q510,Q511,Q511a,Q512,Q61,Q61a,Q62,Q62a,Q63,Q64,Q65,Q66,Q67)  values('$empid','$user','$Q11','$Q12','$Q13','$Q14','$Q15','$Q21','$Q21a','$Q22','$Q23','$Q24','$Q24a','$Q25','$Q26','$Q31','$Q31a','$Q32','$Q32a','$Q33','$Q34','$Q35','$Q36','$Q37','$Q38','$Q41','$Q42','$Q43','$Q46','$Q47','$Q51','$Q52','$Q54','$Q56','$Q57','$Q59','$Q59a','$Q510','$Q511','$Q511a','$Q512','$Q61','$Q61a','$Q62','$Q62a','$Q63','$Q64','$Q65','$Q66','$Q67')";
 $insertq=mysql_query($cquery, $con ) or die (mysql_error());
 //echo "Yout feedback taken. Thanks a lot for appearing the survey";
 header('Location: thank.php') ;
 }
 else
 {
  //echo "Hello";
  header('Location:thanks.php');
 }
}
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/> 
<script type="text/javascript">
function verify()
{
 var $Q11= trim(document.getElementById('Q11').value);
 if($Q11=="Select"){alert("Please answer all the questions"); document.getElementById('Q11').focus();return false;}
 var $Q12= trim(document.getElementById('Q12').value);
 if($Q12=="Select"){alert("Please answer all the questions"); document.getElementById('Q12').focus();return false;}
 var $Q13= trim(document.getElementById('Q13').value);
 if($Q13=="Select"){alert("Please answer all the questions"); document.getElementById('Q13').focus();return false;}
 var $Q14= trim(document.getElementById('Q14').value);
 if($Q14=="Select"){alert("Please answer all the questions"); document.getElementById('Q14').focus();return false;}
 var $Q15= trim(document.getElementById('Q15').value);
 if($Q15=="Select"){alert("Please answer all the questions"); document.getElementById('Q15').focus();return false;}

 var $Q21= trim(document.getElementById('Q21').value);
 if($Q21=="Select"){alert("Please answer all the questions"); document.getElementById('Q21').focus();return false;}
 var $Q21a= trim(document.getElementById('Q21a').value);
 if($Q21=="Disagree" && $Q21a=="" || $Q21=="Somewhat Disagree" && $Q21a=="" ) {alert("Please enter comment"); document.getElementById('Q21a').focus();return false;}

 var $Q22= trim(document.getElementById('Q22').value);
 if($Q22=="Select"){alert("Please answer all the questions"); document.getElementById('Q22').focus();return false;}
 var $Q23= trim(document.getElementById('Q23').value);
 if($Q23=="Select"){alert("Please answer all the questions"); document.getElementById('Q23').focus();return false;}
 var $Q24= trim(document.getElementById('Q24').value);
 if($Q24=="Select"){alert("Please answer all the questions"); document.getElementById('Q24').focus();return false;}
 var $Q24a= trim(document.getElementById('Q24a').value);
 if($Q24=="Disagree" && $Q24a=="" || $Q24=="Somewhat Disagree" && $Q24a=="" ) {alert("Please enter comment"); document.getElementById('Q24a').focus();return false;}
 
 var $Q25= trim(document.getElementById('Q25').value);
 if($Q25=="Select"){alert("Please answer all the questions"); document.getElementById('Q25').focus();return false;}
 var $Q26= trim(document.getElementById('Q26').value);
 if($Q26=="Select"){alert("Please answer all the questions"); document.getElementById('Q26').focus();return false;}
 
 var $Q31= trim(document.getElementById('Q31').value);
 if($Q31=="Select"){alert("Please answer all the questions"); document.getElementById('Q31').focus();return false;}
 var $Q31a= trim(document.getElementById('Q31a').value);
 if($Q31=="Disagree" && $Q31a=="" || $Q31=="Somewhat Disagree" && $Q31a=="" ) {alert("Please enter comment"); document.getElementById('Q31a').focus();return false;}
 
 var $Q32= trim(document.getElementById('Q32').value);
 if($Q32=="Select"){alert("Please answer all the questions"); document.getElementById('Q32').focus();return false;}
 var $Q32a= trim(document.getElementById('Q32a').value);
 if($Q32=="Disagree" && $Q32a=="" || $Q32=="Somewhat Disagree" && $Q32a=="" ) {alert("Please enter comment"); document.getElementById('Q32a').focus();return false;} 
  
 var $Q33= trim(document.getElementById('Q33').value);
 if($Q33=="Select"){alert("Please answer all the questions"); document.getElementById('Q33').focus();return false;}
 var $Q34= trim(document.getElementById('Q34').value);
 if($Q34=="Select"){alert("Please answer all the questions"); document.getElementById('Q34').focus();return false;}
 var $Q35= trim(document.getElementById('Q35').value);
 if($Q35=="Select"){alert("Please answer all the questions"); document.getElementById('Q35').focus();return false;}
 var $Q36= trim(document.getElementById('Q36').value);
 if($Q36=="Select"){alert("Please answer all the questions"); document.getElementById('Q36').focus();return false;}
 var $Q37= trim(document.getElementById('Q37').value);
 if($Q37=="Select"){alert("Please answer all the questions"); document.getElementById('Q37').focus();return false;}
 var $Q38= trim(document.getElementById('Q38').value);
 if($Q38=="Select"){alert("Please answer all the questions"); document.getElementById('Q38').focus();return false;}
 
 var $Q41= trim(document.getElementById('Q41').value);
 if($Q41=="Select"){alert("Please answer all the questions"); document.getElementById('Q41').focus();return false;}
 var $Q42= trim(document.getElementById('Q42').value);
 if($Q42=="Select"){alert("Please answer all the questions"); document.getElementById('Q42').focus();return false;}
 var $Q43= trim(document.getElementById('Q43').value);
 if($Q43=="Select"){alert("Please answer all the questions"); document.getElementById('Q43').focus();return false;}
 var $Q46= trim(document.getElementById('Q46').value);
 if($Q46=="Select"){alert("Please answer all the questions"); document.getElementById('Q46').focus();return false;}
 var $Q47= trim(document.getElementById('Q47').value);
 if($Q47=="Select"){alert("Please answer all the questions"); document.getElementById('Q47').focus();return false;}
 
 var $Q51= trim(document.getElementById('Q51').value);
 if($Q51=="Select"){alert("Please answer all the questions"); document.getElementById('Q51').focus();return false;}
 var $Q52= trim(document.getElementById('Q52').value);
 if($Q52=="Select"){alert("Please answer all the questions"); document.getElementById('Q52').focus();return false;}
 var $Q54= trim(document.getElementById('Q54').value);
 if($Q54=="Select"){alert("Please answer all the questions"); document.getElementById('Q54').focus();return false;}
 var $Q56= trim(document.getElementById('Q56').value);
 if($Q56=="Select"){alert("Please answer all the questions"); document.getElementById('Q56').focus();return false;}
 var $Q57= trim(document.getElementById('Q57').value);
 if($Q57=="Select"){alert("Please answer all the questions"); document.getElementById('Q57').focus();return false;}
 var $Q59= trim(document.getElementById('Q59').value);
 if($Q59=="Select"){alert("Please answer all the questions"); document.getElementById('Q59').focus();return false;}
 var $Q59a= trim(document.getElementById('Q59a').value);
 if($Q59=="Somewhat Agree" && $Q59a=="" || $Q59=="Strongly Agree" && $Q59a=="" ) {alert("Please enter comment"); document.getElementById('Q59a').focus();return false;}
 var $Q510= trim(document.getElementById('Q510').value);
 if($Q510=="Select"){alert("Please answer all the questions"); document.getElementById('Q510').focus();return false;}
 var $Q511= trim(document.getElementById('Q511').value);
 if($Q511=="Select"){alert("Please answer all the questions"); document.getElementById('Q511').focus();return false;}
 var $Q511a= trim(document.getElementById('Q511a').value);
 if($Q511=="Somewhat Agree" && $Q511a=="" || $Q511=="Strongly Agree" && $Q511a=="" ) {alert("Please enter comment"); document.getElementById('Q511a').focus();return false;}
 var $Q512= trim(document.getElementById('Q512').value);
 if($Q512=="Select"){alert("Please answer all the questions"); document.getElementById('Q512').focus();return false;}
 
 var $Q61= trim(document.getElementById('Q61').value);
 if($Q61=="Select"){alert("Please answer all the questions"); document.getElementById('Q61').focus();return false;}
 var $Q61a= trim(document.getElementById('Q61a').value);
 if($Q61=="Disagree" && $Q61a=="" || $Q61=="Somewhat Disagree" && $Q61a=="" ) {alert("Please enter comment"); document.getElementById('Q61a').focus();return false;}
 
 //if($Q61a=="Select"){alert("Please answer all the questions"); document.getElementById('Q61a').focus();return false;}
 var $Q62= trim(document.getElementById('Q62').value);
 if($Q62=="Select"){alert("Please answer all the questions"); document.getElementById('Q62').focus();return false;}
 var $Q62a= trim(document.getElementById('Q62a').value);
 if($Q62=="Somewhat Agree" && $Q62a=="" || $Q62=="Strongly Agree" && $Q62a=="" ) {alert("Please enter comment"); document.getElementById('Q62a').focus();return false;}
 
 //if($Q62a=="Select"){alert("Please answer all the questions"); document.getElementById('Q62a').focus();return false;}
 var $Q63= trim(document.getElementById('Q63').value);
 if($Q63=="Select"){alert("Please answer all the questions"); document.getElementById('Q63').focus();return false;}
 var $Q64= trim(document.getElementById('Q64').value);
 if($Q64=="Select"){alert("Please answer all the questions"); document.getElementById('Q64').focus();return false;}
 var $Q65= trim(document.getElementById('Q65').value);
 if($Q65=="Select"){alert("Please answer all the questions"); document.getElementById('Q65').focus();return false;}
 var $Q66= trim(document.getElementById('Q66').value);
 if($Q66=="Select"){alert("Please answer all the questions"); document.getElementById('Q66').focus();return false;}
 var $Q67= trim(document.getElementById('Q67').value);
 if($Q67==""){alert("Please provide the comment."); document.getElementById('Q67').focus();return false;}
}

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

</script>
<style type="text/css">
body
{
background:url('esat2.jpg') no-repeat;
}
</style>
</head>
<body background="bg.gif">
<form name="tstest" method="post" action="esat.php" onsubmit="return verify()">

<TABLE border=1>
<TR>
<TD>SECTION 1.GENERAL</TD>
</TR>

<TR>
<TD>Q1</TD><TD>Which of the following describes your level?</TD>
<TD><select name="Q11" id="Q11" size="1">
<option selected>Select</option>
<option value="Trainee/Intern">Trainee/Intern</option>
<option value="Executive/Senior Executive">Executive/Senior Executive</option>
<option value="Team Lead/ Project Lead/ Assistant Manager">Team Lead/ Project Lead/ Assistant Manager</option>
<option value="Managers and above">Managers and above</option>
<option value="Others">Others</option>
</select></TD>
</TR>

<TR>
<TD>Q2</TD><TD>Please specify your department.</TD>
<TD><select name="Q12" id="Q12" size="1">
<option selected>Select</option>
<option value="Content (Project management and Coordination)">Content (Project management and Coordination)</option>
<option value="Content (Quality Control)">Content (Quality Control)</option>
<option value="Content (Programming)">Content (Programming)</option>
<option value="Content (Pre-Sales Support)">Content (Pre-Sales Support)</option>
<option value="Content (Graphic Design)">Content (Graphic Design)</option>
<option value="Content (ID and editing)">Content (ID and editing)</option>
<option value="Content (Vendor Management)">Content (Vendor Management)</option>
<option value="Content (Presales)">Content (Presales)</option>
<option value="BD (Incl marketing)">BD (Incl marketing)</option>
<option value="Software Services (SBT)">Software Services (SBT)</option>
<option value="Software Services (Wizdom Web)">Software Services (Wizdom Web)</option>
<option value="Software Services (Efficiant)">Software Services (Efficiant)</option>
<option value="HR">HR</option>
<option value="Admin">Admin</option>
<option value="Internal Quality">Internal Quality</option>
<option value="IT Support">IT Support</option>
<option value="Finance and Accounts">Finance and Accounts</option>
</select></TD>
</TR>

<TR>
<TD>Q3</TD><TD>How long have you been working with G-Cube?</TD>
<TD><select name="Q13" id="Q13" size="1">
<option selected>Select</option>
<option value="0-6 Months">0-6 Months</option>
<option value="More than 6 months but less than 1 year">More than 6 months but less than 1 year</option>
<option value="1 year or more but less than 2 years">1 year or more but less than 2 years</option>
<option value="2 years or more but less than 3 years">2 years or more but less than 3 years</option>
<option value="3 years or more but less than 5 years">3 years or more but less than 5 years</option>
<option value="5 years or more but less than 7 years">5 years or more but less than 7 years</option>
<option value="7 years or more but less than 10 years">7 years or more but less than 10 years</option>
<option value="More than 10 years">More than 10 years</option>
</select></TD>
</TR>

<TR>
<TD>Q4</TD><TD>Please specify your gender.</TD>
<TD><select name="Q14" id="Q14" size="1">
<option selected>Select</option>
<option value="Male">Male</option>
<option value="Female">Female</option>
</select></TD>
</TR>

<TR>
<TD>Q5</TD><TD>Please mention the name of your supervisor</TD>
<TD><?php
	$query = "select DISTINCT manager from manager order by manager";
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Users Not Found; Contact SEPG');
		}

    echo "<select name=\"Q15\" id=\"Q15\">"; 
    echo "<option size =30 selected>Select</option>";
    if(mysql_num_rows($retval)) 
    { 
    while($row = mysql_fetch_assoc($retval)) 
    { 
    echo "<option>$row[manager]</option>"; 
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
<TD>SECTION 2 - JOB CLARITY AND GROWTH</TD>
</TR>

<TR>
<TD>Q1</TD><TD>Your KRAs are clearly given to you for 2014-15.</TD>
<TD><select name="Q21" id="Q21" size="1">
<option selected>Select</option>
<option value="Disagree">Disagree</option>
<option value="Somewhat Disagree">Somewhat Disagree</option>
<option value="Neutral">Neutral</option>
<option value="Somewhat Agree">Somewhat Agree</option>
<option value="Strongly Agree">Strongly Agree</option>
</select></TD>
</TR>

<TR>
<TD>Q1a.</TD><TD>Comment.</TD><TD><textarea name="Q21a" id="Q21a" rows="3" cols="30"></textarea></TD>
</TR>

<TR>
<TD>Q2</TD><TD>You know what is expected of you in your job</TD>
<TD><select name="Q22" id="Q22" size="1">
<option selected>Select</option>
<option value="Disagree">Disagree</option>
<option value="Somewhat Disagree">Somewhat Disagree</option>
<option value="Neutral">Neutral</option>
<option value="Somewhat Agree">Somewhat Agree</option>
<option value="Strongly Agree">Strongly Agree</option>
</select></TD>
</TR>

<TR>
<TD>Q3</TD><TD>You have the support to pursue opportunities for growth.</TD>
<TD><select name="Q23" id="Q23" size="1">
<option selected>Select</option>
<option value="Disagree">Disagree</option>
<option value="Somewhat Disagree">Somewhat Disagree</option>
<option value="Neutral">Neutral</option>
<option value="Somewhat Agree">Somewhat Agree</option>
<option value="Strongly Agree">Strongly Agree</option>
</select></TD>
</TR>

<TR>
<TD>Q4</TD><TD>Trainings through L&D in last 6 months were interactive and useful</TD>
<TD><select name="Q24" id="Q24" size="1">
<option selected>Select</option>
<option value="Disagree">Disagree</option>
<option value="Somewhat Disagree">Somewhat Disagree</option>
<option value="Neutral">Neutral</option>
<option value="Somewhat Agree">Somewhat Agree</option>
<option value="Strongly Agree">Strongly Agree</option>
</select></TD>
</TR>

<TR>
<TD>Q4a</TD><TD>Comment.</TD><TD><textarea name="Q24a" id="Q24a" rows="3" cols="30"></textarea></TD>
</TR>

<TR>
<TD>Q5</TD><TD>You are growing as a professional in G-Cube</TD>
<TD><select name="Q25" id="Q25" size="1">
<option selected>Select</option>
<option value="Disagree">Disagree</option>
<option value="Somewhat Disagree">Somewhat Disagree</option>
<option value="Neutral">Neutral</option>
<option value="Somewhat Agree">Somewhat Agree</option>
<option value="Strongly Agree">Strongly Agree</option>
</select></TD>
</TR>

<TR>
<TD>Q6</TD><TD>In last 6 months, someone has talked about your growth and progress in G-Cube.</TD>
<TD><select name="Q26" id="Q26" size="1">
<option selected>Select</option>
<option value="Disagree">Disagree</option>
<option value="Somewhat Disagree">Somewhat Disagree</option>
<option value="Neutral">Neutral</option>
<option value="Somewhat Agree">Somewhat Agree</option>
<option value="Strongly Agree">Strongly Agree</option>
</select></TD>
</TR>

<TR>
<TD>SECTION 3 -MANAGERIAL STYLE AND RECOGNITION</TD>
</TR>

<TR>
<TD>Q1</TD><TD>You are treated fairly by your manager.</TD>
<TD><select name="Q31" id="Q31" size="1">
<option selected>Select</option>
<option value="Disagree">Disagree</option>
<option value="Somewhat Disagree">Somewhat Disagree</option>
<option value="Neutral">Neutral</option>
<option value="Somewhat Agree">Somewhat Agree</option>
<option value="Strongly Agree">Strongly Agree</option>
</select></TD>
</TR>


<TR>
<TD>Q1a</TD><TD>Comment.</TD><TD><textarea name="Q31a" id="Q31a" rows="3" cols="30"></textarea></TD>
</TR>


<TR>
<TD>Q2</TD><TD>Your manager is an effective leader (i.e.consistent, positive and motivating).</TD>
<TD><select name="Q32" id="Q32" size="1">
<option selected>Select</option>
<option value="Disagree">Disagree</option>
<option value="Somewhat Disagree">Somewhat Disagree</option>
<option value="Neutral">Neutral</option>
<option value="Somewhat Agree">Somewhat Agree</option>
<option value="Strongly Agree">Strongly Agree</option>
</select></TD>
</TR>

<TR>
<TD>Q2a</TD><TD>Comment.</TD><TD><textarea name="Q32a" id="Q32a" rows="3" cols="30"></textarea></TD>
</TR>

<TR>
<TD>Q3</TD><TD>You get timely feedback about how you are doing your job.</TD>
<TD><select name="Q33" id="Q33" size="1">
<option selected>Select</option>
<option value="Disagree">Disagree</option>
<option value="Somewhat Disagree">Somewhat Disagree</option>
<option value="Neutral">Neutral</option>
<option value="Somewhat Agree">Somewhat Agree</option>
<option value="Strongly Agree">Strongly Agree</option>
</select></TD>
</TR>

<TR>
<TD>Q4</TD><TD>You have the knowledge and resources to do your job well</TD>
<TD><select name="Q34" id="Q34" size="1">
<option selected>Select</option>
<option value="Disagree">Disagree</option>
<option value="Somewhat Disagree">Somewhat Disagree</option>
<option value="Neutral">Neutral</option>
<option value="Somewhat Agree">Somewhat Agree</option>
<option value="Strongly Agree">Strongly Agree</option>
</select></TD><TD>Resources here refer to inanimate items like desktop/laptop, software, budget, etc</TD>
</TR>

<TR>
<TD>Q5</TD><TD>You are adequately recognized for your job</TD>
<TD><select name="Q35" id="Q35" size="1">
<option selected>Select</option>
<option value="Disagree">Disagree</option>
<option value="Somewhat Disagree">Somewhat Disagree</option>
<option value="Neutral">Neutral</option>
<option value="Somewhat Agree">Somewhat Agree</option>
<option value="Strongly Agree">Strongly Agree</option>
</select></TD>
</TR>

<TR>
<TD>Q6</TD><TD> Do you feel comfortable going to your manager with any concerns/issues.</TD>
<TD><select name="Q36" id="Q36" size="1">
<option selected>Select</option>
<option value="Disagree">Disagree</option>
<option value="Somewhat Disagree">Somewhat Disagree</option>
<option value="Neutral">Neutral</option>
<option value="Somewhat Agree">Somewhat Agree</option>
<option value="Strongly Agree">Strongly Agree</option>
</select></TD>
</TR>

<TR>
<TD>Q7</TD><TD> In the last one month, you have recieved recognition or praise for doing good work, from your immediate manager.</TD>
<TD><select name="Q37" id="Q37" size="1">
<option selected>Select</option>
<option value="Disagree">Disagree</option>
<option value="Somewhat Disagree">Somewhat Disagree</option>
<option value="Neutral">Neutral</option>
<option value="Somewhat Agree">Somewhat Agree</option>
<option value="Strongly Agree">Strongly Agree</option>
</select></TD>
</TR>

<TR>
<TD>Q8</TD><TD>I can disagree with my supervisor without fear of getting in trouble.</TD>
<TD><select name="Q38" id="Q38" size="1">
<option selected>Select</option>
<option value="Disagree">Disagree</option>
<option value="Somewhat Disagree">Somewhat Disagree</option>
<option value="Neutral">Neutral</option>
<option value="Somewhat Agree">Somewhat Agree</option>
<option value="Strongly Agree">Strongly Agree</option>
</select></TD>
</TR>

<TR>
<TD>SECTION 4 -TEAMWORK</TD>
</TR>

<TR>
<TD>Q1</TD><TD>I have close friends at work.</TD>
<TD><select name="Q41" id="Q41" size="1">
<option selected>Select</option>
<option value="Disagree">Disagree</option>
<option value="Somewhat Disagree">Somewhat Disagree</option>
<option value="Neutral">Neutral</option>
<option value="Somewhat Agree">Somewhat Agree</option>
<option value="Strongly Agree">Strongly Agree</option>
</select></TD>
</TR>

<TR>
<TD>Q2</TD><TD>I regularly laugh with my colleagues</TD>
<TD><select name="Q42" id="Q42" size="1">
<option selected>Select</option>
<option value="Disagree">Disagree</option>
<option value="Somewhat Disagree">Somewhat Disagree</option>
<option value="Neutral">Neutral</option>
<option value="Somewhat Agree">Somewhat Agree</option>
<option value="Strongly Agree">Strongly Agree</option>
</select></TD>
</TR>

<TR>
<TD>Q3</TD><TD>People in my dept. treat me with respect and civility.</TD>
<TD><select name="Q43" id="Q43" size="1">
<option selected>Select</option>
<option value="Disagree">Disagree</option>
<option value="Somewhat Disagree">Somewhat Disagree</option>
<option value="Neutral">Neutral</option>
<option value="Somewhat Agree">Somewhat Agree</option>
<option value="Strongly Agree">Strongly Agree</option>
</select></TD>
</TR>





<TR>
<TD>Q4</TD><TD> My department gives equal importance to all my peers and colleagues.</TD>
<TD><select name="Q46" id="Q46" size="1">
<option selected>Select</option>
<option value="Disagree">Disagree</option>
<option value="Somewhat Disagree">Somewhat Disagree</option>
<option value="Neutral">Neutral</option>
<option value="Somewhat Agree">Somewhat Agree</option>
<option value="Strongly Agree">Strongly Agree</option>
</select></TD>
</TR>

<TR>
<TD>Q5</TD><TD>I feel part of a team working towards a shared goal.</TD>
<TD><select name="Q47" id="Q47" size="1">
<option selected>Select</option>
<option value="Disagree">Disagree</option>
<option value="Somewhat Disagree">Somewhat Disagree</option>
<option value="Neutral">Neutral</option>
<option value="Somewhat Agree">Somewhat Agree</option>
<option value="Strongly Agree">Strongly Agree</option>
</select></TD>
</TR>

<TR><TD>
SECTION 5 -TRUST, AUTONOMY AND INNOVATION</TD>
</TR>

<TR>
<TD>Q1</TD><TD>At work, my opinion seems to count.</TD>
<TD><select name="Q51" id="Q51" size="1">
<option selected>Select</option>
<option value="Disagree">Disagree</option>
<option value="Somewhat Disagree">Somewhat Disagree</option>
<option value="Neutral">Neutral</option>
<option value="Somewhat Agree">Somewhat Agree</option>
<option value="Strongly Agree">Strongly Agree</option>
</select></TD>
</TR>

<TR>
<TD>Q2</TD><TD>I have confidence in the leadership of G-Cube.</TD>
<TD><select name="Q52" id="Q52" size="1">
<option selected>Select</option>
<option value="Disagree">Disagree</option>
<option value="Somewhat Disagree">Somewhat Disagree</option>
<option value="Neutral">Neutral</option>
<option value="Somewhat Agree">Somewhat Agree</option>
<option value="Strongly Agree">Strongly Agree</option>
</select></TD>
</TR>



<TR>
<TD>Q3</TD><TD>My immediate manager looks out for the best interest of all team members.</TD>
<TD><select name="Q54" id="Q54" size="1">
<option selected>Select</option>
<option value="Disagree">Disagree</option>
<option value="Somewhat Disagree">Somewhat Disagree</option>
<option value="Neutral">Neutral</option>
<option value="Somewhat Agree">Somewhat Agree</option>
<option value="Strongly Agree">Strongly Agree</option>
</select></TD>
</TR>




<TR>
<TD>Q4</TD><TD>I am encouraged to think creatively and raise new ideas.</TD>
<TD><select name="Q56" id="Q56" size="1">
<option selected>Select</option>
<option value="Disagree">Disagree</option>
<option value="Somewhat Disagree">Somewhat Disagree</option>
<option value="Neutral">Neutral</option>
<option value="Somewhat Agree">Somewhat Agree</option>
<option value="Strongly Agree">Strongly Agree</option>
</select></TD>
</TR>

<TR>
<TD>Q5</TD><TD> I have the resources I need to implement new projects and ideas</TD>
<TD><select name="Q57" id="Q57" size="1">
<option selected>Select</option>
<option value="Disagree">Disagree</option>
<option value="Somewhat Disagree">Somewhat Disagree</option>
<option value="Neutral">Neutral</option>
<option value="Somewhat Agree">Somewhat Agree</option>
<option value="Strongly Agree">Strongly Agree</option>
</select></TD><TD>Resources here mean essential items like budget, time for research, software required etc</TD>
</TR>





<TR>
<TD>Q6</TD><TD>Do you believe in the need to continuously improve at work? Support with an example, if you choose somewhat agree or strongly agree.</TD>
<TD><select name="Q59" id="Q59" size="1">
<option selected>Select</option>
<option value="Disagree">Disagree</option>
<option value="Somewhat Disagree">Somewhat Disagree</option>
<option value="Neutral">Neutral</option>
<option value="Somewhat Agree">Somewhat Agree</option>
<option value="Strongly Agree">Strongly Agree</option>
</select></TD>
</TR>

<TR>
<TD>Q6a</TD><TD>Comment.</TD><TD><textarea name="Q59a" id="Q59a" rows="3" cols="30"></textarea></TD>
</TR>

<TR>
<TD>Q7</TD><TD> Information and knowledge is shared openly in the company.</TD>
<TD><select name="Q510" id="Q510" size="1">
<option selected>Select</option>
<option value="Disagree">Disagree</option>
<option value="Somewhat Disagree">Somewhat Disagree</option>
<option value="Neutral">Neutral</option>
<option value="Somewhat Agree">Somewhat Agree</option>
<option value="Strongly Agree">Strongly Agree</option>
</select></TD>
</TR>

<TR>
<TD>Q8</TD><TD>You are constantly searching for ideas that can drive growth and spin them across to others. Give examples if you choose Strongly Agree or Somewhat Agree.</TD>
<TD><select name="Q511" id="Q511" size="1">
<option selected>Select</option>
<option value="Disagree">Disagree</option>
<option value="Somewhat Disagree">Somewhat Disagree</option>
<option value="Neutral">Neutral</option>
<option value="Somewhat Agree">Somewhat Agree</option>
<option value="Strongly Agree">Strongly Agree</option>
</select></TD>
</TR>

<TR>
<TD>Q8a</TD><TD>Comment.</TD><TD><textarea name="Q511a" id="Q511a" rows="3" cols="30"></textarea></TD>
</TR>


<TR>
<TD>Q9</TD><TD>Associates are held accountable for the quality of work they produce.</TD>
<TD><select name="Q512" id="Q512" size="1">
<option selected>Select</option>
<option value="Disagree">Disagree</option>
<option value="Somewhat Disagree">Somewhat Disagree</option>
<option value="Neutral">Neutral</option>
<option value="Somewhat Agree">Somewhat Agree</option>
<option value="Strongly Agree">Strongly Agree</option>
</select></TD>
</TR>


<TR><TD>
SECTION 6-OUTCOME</TD>
</TR>

<TR>
<TD>Q1</TD><TD>You are proud of G-Cube</TD>
<TD><select name="Q61" id="Q61" size="1">
<option selected>Select</option>
<option value="Disagree">Disagree</option>
<option value="Somewhat Disagree">Somewhat Disagree</option>
<option value="Neutral">Neutral</option>
<option value="Somewhat Agree">Somewhat Agree</option>
<option value="Strongly Agree">Strongly Agree</option>
</select></TD>
</TR>

<TR>
<TD>Q1a</TD><TD>Comment.</TD><TD><textarea name="Q61a" id="Q61a" rows="3" cols="30"></textarea></TD>
</TR>

<TR>
<TD>Q2</TD><TD>You have seriously thought of resigning in the last 3 months.Give examples if you choose Strongly Agree or Somewhat Agree.</TD>
<TD><select name="Q62" id="Q62" size="1">
<option selected>Select</option>
<option value="Disagree">Disagree</option>
<option value="Somewhat Disagree">Somewhat Disagree</option>
<option value="Neutral">Neutral</option>
<option value="Somewhat Agree">Somewhat Agree</option>
<option value="Strongly Agree">Strongly Agree</option>
</select></TD>
</TR>

<TR>
<TD>Q2a</TD><TD>Comment.</TD><TD><textarea name="Q62a" id="Q62a" rows="3" cols="30"></textarea></TD>
</TR>


<TR>
<TD>Q3</TD><TD>Different departments within G-Cube cooperate with each other.</TD>
<TD><select name="Q63" id="Q63" size="1">
<option selected>Select</option>
<option value="Disagree">Disagree</option>
<option value="Somewhat Disagree">Somewhat Disagree</option>
<option value="Neutral">Neutral</option>
<option value="Somewhat Agree">Somewhat Agree</option>
<option value="Strongly Agree">Strongly Agree</option>
</select></TD>
</TR>


<TR>
<TD>Q4</TD><TD>Your peers and co workers are committed to doing good work.</TD>
<TD><select name="Q64" id="Q64" size="1">
<option selected>Select</option>
<option value="Disagree">Disagree</option>
<option value="Somewhat Disagree">Somewhat Disagree</option>
<option value="Neutral">Neutral</option>
<option value="Somewhat Agree">Somewhat Agree</option>
<option value="Strongly Agree">Strongly Agree</option>
</select></TD>
</TR>

<TR>
<TD>Q5</TD><TD>G-Cube is a fun place to work</TD>
<TD><select name="Q65" id="Q65" size="1">
<option selected>Select</option>
<option value="Disagree">Disagree</option>
<option value="Somewhat Disagree">Somewhat Disagree</option>
<option value="Neutral">Neutral</option>
<option value="Somewhat Agree">Somewhat Agree</option>
<option value="Strongly Agree">Strongly Agree</option>
</select></TD>
</TR>

<TR>
<TD>Q6</TD><TD>Customer needs are the highest priority in G-Cube</TD>
<TD><select name="Q66" id="Q66" size="1">
<option selected>Select</option>
<option value="Disagree">Disagree</option>
<option value="Somewhat Disagree">Somewhat Disagree</option>
<option value="Neutral">Neutral</option>
<option value="Somewhat Agree">Somewhat Agree</option>
<option value="Strongly Agree">Strongly Agree</option>
</select></TD>
</TR>

<TR>
<TD>Q7</TD><TD>Mention 3 important concerns/issues which require immediate attention in G-Cube</TD>
<TD><textarea name="Q67" id="Q67" rows="3" cols="30"></textarea></TD>
</TR>

</TABLE>
<br>
<input type="hidden" value="<?php echo $logged;?>" name="loggeduser" id="loggeduser">
<input type="hidden" value="<?php echo $empid;?>" name="empid" id="empid">
<input type="submit" value="Submit">
<input type="button" value="Log Out" onclick="location.href='esatlogout.php';">
</form>
</body>
</html> 