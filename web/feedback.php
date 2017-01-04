<?PHP
session_start();
error_reporting(0);
if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	$_SESSION['login'] = "";
	header ("Location:survey.php");
}

else 
{     
$user=$_SESSION['login'];	 
$con = mysql_connect("localhost","root","password");

if (!$con)
{
   die('Could not connect: ' . mysql_error());
}

mysql_select_db("audit") or die(mysql_error());

$query = "select name from surveylogin where passwd='$user';";
$retval = mysql_query( $query, $con );
$count = mysql_num_rows($retval);
	
if($count==0)
{
 die('Please Contact SEPG; May be You Are Not Registered');
}
   
while($row = mysql_fetch_assoc($retval)) 
{ 
 $logged=$row['name'];
 echo "</br>";
 echo "</br>";
 echo "<h4>"."Hi ".$row['name']." ! Welcome To Peer Group Survey"."</h4>"; 
}
}
?>
<html>
<head>
<script type="text/javascript">

function submitall()
{
//alert (123);

var dept = trim(document.getElementById('dept').value);
if(dept=="Select")
  {
  alert("Dept should be specified");
  return false;
  }

var func = trim(document.getElementById('func').value);
if(func=="Select")
  {
  alert("Function should be specified");
  return false;
  }

var peer = trim(document.getElementById('peer').value);
if(peer=="Select")
  {
  alert("Peer should be specified");
  return false;
  }

var logged = trim(document.getElementById('loggeduser').value);
//alert(logged);

var Q1 = trim(document.getElementById('Q1').value);
if(Q1=="select")
  {
  alert("Q1 should be selected");
  return false;
  }

var Q2 = trim(document.getElementById('Q2').value);
if(Q2=="select")
  {
  alert("Q2 should be selected");
  return false;
  }

var Q3 = trim(document.getElementById('Q3').value);
if(Q3=="select")
  {
  alert("Q3 should be selected");
  return false;
  }

var Q4 = trim(document.getElementById('Q4').value);
if(Q4=="select")
  {
  alert("Q4 should be selected");
  return false;
  }

var Q5 = trim(document.getElementById('Q5').value);
if(Q5=="select")
  {
  alert("Q5 should be selected");
  return false;
  }

var Q6 = trim(document.getElementById('Q6').value);
if(Q6=="select")
  {
  alert("Q6 should be selected");
  return false;
  }

var Q7 = trim(document.getElementById('Q7').value);
if(Q7=="select")
  {
  alert("Q7 should be selected");
  return false;
  }

var Q8 = trim(document.getElementById('Q8').value);
if(Q8=="select")
  {
  alert("Q8 should be selected");
  return false;
  }

var Q9 = trim(document.getElementById('Q9').value);
if(Q9=="select")
  {
  alert("Q9 should be selected");
  return false;
  }

var Q10 = trim(document.getElementById('Q10').value);
if(Q10=="select")
  {
  alert("Q10 should be selected");
  return false;
  }

var Q11 = trim(document.getElementById('Q11').value);
if(Q11=="select")
  {
  alert("Q11 should be selected");
  return false;
  }

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
    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
//alert(Q6);
xmlhttp.open("GET","updatesurveystat.php?a="+logged+"&b="+dept+"&c="+func+"&d="+peer+"&e="+Q1+"&f="+Q2+"&g="+Q3+"&h="+Q4+"&i="+Q5+"&j="+Q6+"&k="+Q7+"&l="+Q8+"&m="+Q9+"&n="+Q10+"&o="+Q11,true);
xmlhttp.send();

}


function showAll()
{
//newwindow.close();
//str=document.forms["tstest"]["project"].value;
//alert (123);

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
    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
//str=encodeURIComponent(str);
xmlhttp.open("GET","getsurveyinfo.php",true);
xmlhttp.send();
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
background:url('survey2.jpg') no-repeat;
}
</style>
</head>
<body>
<form name="tstest">
<TABLE border=1>
<TR><i>Answer the following questions either A or B option that is true most frequently</i></TR>
<TR>
<TD>Please specify your department.</TD>
<TD><select name="dept" id="dept" size="1">
<option selected>Select</option>
<option value="Business Development">Business Development</option>
<option value="Content">Content</option>
<option value="Management">Management</option>
<option value="Marketing">Marketing</option>
<option value="Shared Services">Shared Services</option>
<option value="Software Services">Software Services</option>
<option value="Vivo">Vivo</option>
</select></TD>
</TR>

<TR>
<TD>Please specify your function.</TD>
<TD><select name="func" id="func" size="1">
<option selected>Select</option>
<option value="Accounts">Accounts</option>
<option value="Administration">Administration</option>
<option value="Business Development">Business Development</option>
<option value="Content editing">Content editing</option>
<option value="Customer Support">Customer Support</option>
<option value="Graphic Design">Graphic Design</option>
<option value="Human Resource">Human Resource</option>
<option value="Instructional Design">Instructional Design</option>
<option value="Internal Quality">Internal Quality</option>
<option value="IT">IT</option>
<option value="Management">Management</option>
<option value="Marketing">Marketing</option>
<option value="Programming">Programming</option>
<option value="Project Coordinator">Project Coordinator</option>
<option value="Project Management">Project Management</option>
<option value="Quality Control">Quality Control</option>
<option value="Software Development">Software Development</option>
<option value="Testing">Testing</option>
<option value="Pre-sales Support">Pre-sales Support</option>
<option value="Sales Support">Sales Support</option>
<option value="Vendor Management">Vendor Management</option>
<option value="Sales">Sales</option>
</select></TD>
</TR>

<TR>
<TD width="80%">Please Choose The Name Of Peer</TD>
<TD width="20%">
    <?php
	$query = "select * from surveylogin order by name";
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Users Not Found; Contact SEPG');
		}

    echo "<select name=\"peer\" id=\"peer\">"; 
    echo "<option selected value=\"Select\">Select</option>";
    
	if(mysql_num_rows($retval)) 
    { 
    while($row = mysql_fetch_assoc($retval)) 
    { 
    ?>
    <option value="<?php echo $row[empid]; ?>"><?php echo $row[name];?></option>"; 
    <?php
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
<TD width="80%">1. When a new job starts, he/she is more concerned with:</TD><TD width="20%"><select name="Q1" size="1" id="Q1">
<option value="select" selected>Select</option>
<option value="1">Who is he/she working with</option>
<option value="2">Excelling at the task that form the job description</option>
</select></TD>
</TR>

<TR>
<TD width="80%">2. When he/she is asked to be part of a project team, he/she:</TD><TD width="20%"><select name="Q2" size="1" id="Q2">
<option value="select" selected>Select</option>
<option value="2">Figure out their strengths and how he/she can contribute to the team effort</option>
<option value="1">Determine which part of the project he/she can take ownership of and deliver excellence on</option>
</select></TD>
</TR>

<TR>
<TD width="80%">3. When credit is given for a project, he/she expects that he/she will:</TD><TD width="20%"><select name="Q3" size="1" id="Q3">
<option value="select" selected>Select</option>
<option value="2">Be mentioned as part of the team on the project</option>
<option value="1">Receive top billing for his/her important contribution</option>
</select></TD>	
</TR>

<TR>
<TD width="80%">4. He/she prefers performance incentives that:</TD><TD width="20%"><select name="Q4" size="1" id="Q4">
<option value="select" selected>Select</option>
<option value="2">Measure his/her contribution to the overall goals of the company or organization</option>
<option value="1">Measure his/her performance on the tasks outlined in his/her job description</option>
</select></TD>
</TR>

<TR>
<TD width="80%">5. He/she'd prefer to be described as:</TD><TD width="20%"><select name="Q5" size="1" id="Q5">
<option value="select" selected>Select</option>
<option value="2">Someone who seeks to discover the best in others</option>
<option value="1">Unique, an individual, a maverick or a super star</option>
</select></TD>
</TR>

<TR>
<TD width="80%">6. He/she feels most upset when:</TD><TD width="20%"><select name="Q6" size="1" id="Q6">
<option value="select" selected>Select</option>
<option value="2">Someone he/she works with is forced to handle a large amount of work with few resources and he/she is unable to offer assistance</option>
<option value="1">His/her contribution is not recognized and he/she am lumped in with a group of under performers where he/she must compensate for the poor work of others</option>
</select></TD>	
</TR>

<TR>
<TD width="80%">7. When in a problem solving meeting, he/she tends to:</TD><TD width="20%"><select name="Q7" size="1" id="Q7">
<option value="select" selected>Select</option>
<option value="1">Listen to the views of others and assimilate them into his/her view of the situation and its solution</option>
<option value="2">Analyse the situation, see their role in correcting the problem and voice it</option>
</select></TD>
</TR>

<TR>
<TD width="80%">8. When he/she is privy to information that could impact strategic direction of department / company,he/she:</TD><TD width="20%"><select name="Q8" size="1" id="Q8">
<option value="select" selected>Select</option>
<option value="1">Finds an opportunity to open a discussion around it in a meeting or impromptu gathering</option>
<option value="2">Takes ownership of the information, figures out how to best deliver the information and finds the right time to deliver it so he/she will be heard</option>
</select></TD>
</TR>

<TR>
<TD width="80%">9. Most of the time, he/she prides imself/herself on his/her:</TD><TD width="20%"><select name="Q9" size="1" id="Q9">
<option value="select" selected>Select</option>
<option value="2">Cooperative nature</option>
<option value="1">Competitive spirit</option>
</select></TD>	
</TR>

<TR>
<TD width="80%">10. When a change iniatiative is announced, he/she:</TD><TD width="20%"><select name="Q10" size="1" id="Q10">
<option value="select" selected>Select</option>
<option value="2">Thinks about the good that will come from the change and see how the contributions of many will make this change happen</option>
<option value="1">Thinks about his/her role in the initiative and what it will mean to their duties and time</option>
</select></TD>	
</TR>

<TR>
<TD width="80%">11. He/she seeks to create outcomes that are:</TD><TD width="20%"><select name="Q11" size="1" id="Q11">
<option value="select" selected>Select</option>
<option value="2">A win-win for every individual</option>
<option value="1">A win-win for him/her and his/her company’s bottom line</option>
</select></TD>
</TR>

</table>

<input type="button" value="Log Out" onclick="location.href='surveylogout.php';">
<input type="button" value="Submit" onclick="submitall()">
<?php
if($user=="barshac_01")
{
?>
<input type="button" value="Show All Entries" onclick="showAll()">
<?php
}
?>
<input type="hidden" value="<?php echo $logged;?>" name="loggeduser" id="loggeduser">
<div id="txtHint">
</form>
</body>
</html> 