<head>
<script>
function goBack()
  {
  window.history.back()
  }
</script>
<style>
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
body
{
background:url('qcr.jpg') no-repeat;
}
</style>
</head>
<body>
<?php
    error_reporting(0);
    session_start();
	include("class.phpmailer.php");
	if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	header ("Location:index.php");
    }
	
	$con = mysql_connect("localhost","root","password");
    $user=$_SESSION['login'];

    if (!$con)
    {
        die('Could not connect: ' . mysql_error());
    }

	mysql_select_db("audit") or die(mysql_error());
    
    $SDate=$_POST["SDate"];
	$EDate=$_POST["EDate"];
	$masterid=$_POST["masterid"];
    $id=$_POST["id"];
	$serial=$_POST["serial"];
	$deldate=$_POST["deldate"];
	$recdate=$_POST["recdate"];
	$qc=$_POST["qc"];
	
	$currentdate = date('Y-m-d h:i:s', time());

	$SDate=strtotime($SDate);
    $SDate = date( 'Y-m-d H:i:s', $SDate );
	
	$EDate=strtotime($EDate);
    $EDate = date( 'Y-m-d H:i:s', $EDate );

    If($SDate>$EDate) {echo "<br>"; echo "<br>"; echo "<br>"; echo "Start Date cannot be after End Date"; exit();}
    If($EDate>$deldate || $SDate>$deldate) {echo "<br>"; echo "<br>"; echo "<br>"; echo "Start Date or End Date cannot be after Delivery Date"; exit();}
    If($EDate<$recdate || $SDate<$recdate) {echo "<br>"; echo "<br>"; echo "<br>"; echo "Start Date or End Date cannot be before Received Date"; exit();}

    $uquery = "update qcplan set SDate='$SDate',EDate='$EDate',timestamp='$currentdate',qc='$qc' where masterid='$masterid' AND indx='$serial' AND id='$id'";
	if (mysql_query($uquery))
          {
            echo "</br>";
			echo "</br>";
            echo "</br>";
			die("Row updated...");
          } 
    else
		  {	
            echo "</br>";
			echo "</br>";
            echo "</br>";
            die (mysql_error());
			exit();
          }	
?>
</body>