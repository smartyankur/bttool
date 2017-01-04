<?php
$con = mysql_connect("localhost","root","password");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
mysql_select_db("audit") or die(mysql_error());

$index=$_POST['index'];
//echo "index ".$index; echo "</br>";
$date=date('Y-m-d',strtotime($_POST['DDate']));
//echo "Date :".$date;
$user = $_POST['user'];
//echo "user ".$user;echo "</br>";

for ($i=1; $i<=$index; $i++)
{
  $name=$_POST[$i];
  //echo $name;echo "</br>";
  $projectone=$_POST["projone".$i];
  $hourone=$_POST["hourone".$i];
  //echo $projectone;echo "</br>";
  //echo $hourone;echo "</br>"; 
  $cquery="INSERT INTO utilization(project,tm,fm,date,hours) values('$projectone','$name','$user','$date','$hourone')";
  $cresult=mysql_query($cquery) or die (mysql_error());
  
  //echo "-------------------------";echo "</br>";
  $projecttwo=$_POST["projtwo".$i];
  $hourtwo=$_POST["hourtwo".$i];
  //echo $projecttwo;echo "</br>";
  //echo $hourtwo;echo "</br>";
  $cquery="INSERT INTO utilization(project,tm,fm,date,hours) values('$projecttwo','$name','$user','$date','$hourtwo')";
  $cresult=mysql_query($cquery) or die (mysql_error());
  
  //echo "-------------------------";echo "</br>";
  $projectthree=$_POST["projthree".$i];
  $hourthree=$_POST["hourthree".$i];
  //echo $projectthree;echo "</br>";
  //echo $hourthree;echo "</br>";
  $cquery="INSERT INTO utilization(project,tm,fm,date,hours) values('$projectthree','$name','$user','$date','$hourthree')";
  $cresult=mysql_query($cquery) or die (mysql_error());
 }
echo "<br>";
echo "<br>";
echo "<br>";
echo "Record Created. To enter again please press the browser back button.";
/*
$project = $_POST['project'];
$user = $_POST['user'];
//echo "Project".$project."</br>";
//echo "User".$user."</br>";
$tmone = $_POST['tmone'];
//echo "tmone".$tmone."</br>"; 
$tmtwo = $_POST['tmtwo'];
//echo "tmtwo".$tmtwo."</br>";
$tmthree = $_POST['tmthree'];
//echo "tmthree".$tmthree."</br>";
$tmfour = $_POST['tmfour'];
//echo "tmfour".$tmfour."</br>";
$tmfive = $_POST['tmfive'];
//echo "tmfive".$tmfive."</br>";
$tmsix = $_POST['tmsix'];
//echo "tmSix".$tmsix."</br>";
$tmseven = $_POST['tmseven'];
//echo "tmSeven".$tmseven."</br>";
$tmeight = $_POST['tmeight'];
//echo "tmeight".$tmeight."</br>";

$DDateOne = date('Y-m-d',strtotime($_POST['DDateOne']));
$TDateOne = date('Y-m-d',strtotime($_POST['TDateOne']));

$DDateTwo = date('Y-m-d',strtotime($_POST['DDateTwo']));
$TDateTwo = date('Y-m-d',strtotime($_POST['TDateTwo']));
//echo "DDateTwo".$DDateTwo."</br>";
//echo "TDateTwo".$TDateTwo."</br>";

$DDateThree = date('Y-m-d',strtotime($_POST['DDateThree']));
$TDateThree = date('Y-m-d',strtotime($_POST['TDateThree']));
//echo "DDateThree".$DDateThree."</br>";
//echo "TDateThree".$TDateThree."</br>";

$DDateFour = date('Y-m-d',strtotime($_POST['DDateFour']));
$TDateFour = date('Y-m-d',strtotime($_POST['TDateFour']));
//echo "DDateFour".$DDateFour."</br>";
//echo "TDateFour".$TDateFour."</br>";

$DDateFive = date('Y-m-d',strtotime($_POST['DDateFive']));
$TDateFive = date('Y-m-d',strtotime($_POST['TDateFive']));
//echo "DDateFive".$DDateFive."</br>";
//echo "TDateFive".$TDateFive."</br>";

$DDateSix = date('Y-m-d',strtotime($_POST['DDateSix']));
$TDateSix = date('Y-m-d',strtotime($_POST['TDateSix']));
//echo "DDateSix".$DDateSix."</br>";
//echo "TDateSix".$TDateSix."</br>";

$DDateSeven = date('Y-m-d',strtotime($_POST['DDateSeven']));
$TDateSeven = date('Y-m-d',strtotime($_POST['TDateSeven']));
//echo "DDateSeven".$DDateSeven."</br>";
//echo "TDateSeven".$TDateSeven."</br>";

$DDateEight = date('Y-m-d',strtotime($_POST['DDateEight']));
$TDateEight = date('Y-m-d',strtotime($_POST['TDateEight']));
//echo "DDateEight".$DDateEight."</br>";
//echo "TDateEight".$TDateEight."</br>";

$con = mysql_connect("localhost","root","password");
echo "</br>";

if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
mysql_select_db("audit") or die(mysql_error());

if($tmone<>'NA')
{
	$cquery="INSERT INTO utilization(project,tm,fm,startdate,enddate) values('$project','$tmone','$user','$DDateTwo','$TDateTwo')";
	$cresult=mysql_query($cquery) or die (mysql_error());
}

if($tmtwo<>'NA')
{
	$cquery="INSERT INTO utilization(project,tm,fm,startdate,enddate) values('$project','$tmtwo','$user','$DDateTwo','$TDateTwo')";
	$cresult=mysql_query($cquery) or die (mysql_error());
}

if($tmthree<>'NA')
{
	$cquery="INSERT INTO utilization(project,tm,fm,startdate,enddate) values('$project','$tmthree','$user','$DDateThree','$TDateThree')";
	$cresult=mysql_query($cquery) or die (mysql_error());
}

if($tmfour<>'NA')
{
	$cquery="INSERT INTO utilization(project,tm,fm,startdate,enddate) values('$project','$tmfour','$user','$DDateFour','$TDateFour')";
	$cresult=mysql_query($cquery) or die (mysql_error());
}

if($tmfive<>'NA')
{
	$cquery="INSERT INTO utilization(project,tm,fm,startdate,enddate) values('$project','$tmfive','$user','$DDateFive','$TDateFive')";
	$cresult=mysql_query($cquery) or die (mysql_error());
}

if($tmsix<>'NA')
{
	$cquery="INSERT INTO utilization(project,tm,fm,startdate,enddate) values('$project','$tmsix','$user','$DDateSix','$TDateSix')";
	$cresult=mysql_query($cquery) or die (mysql_error());
}

if($tmseven<>'NA')
{
	$cquery="INSERT INTO utilization(project,tm,fm,startdate,enddate) values('$project','$tmseven','$user','$DDateSeven','$TDateSeven')";
	$cresult=mysql_query($cquery) or die (mysql_error());
}

if($tmeight<>'NA')
{
	$cquery="INSERT INTO utilization(project,tm,fm,startdate,enddate) values('$project','$tmeight','$user','$DDateEight','$TDateEight')";
	$cresult=mysql_query($cquery) or die (mysql_error());
}
echo "Row Created. If You Want to Enter Information For Another Project Please Press Back Button Of Browser.";
mysql_close($con);
*/
header ("Location: endsub.php");
?>
