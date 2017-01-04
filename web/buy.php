<?php
session_start();
	
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

    $query = "select username from login where uniqueid='$user'";
    
	$retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0)
		{
			die('Session data not found please contact SEPG');
		}

$q=$_GET["q"]; //symbol
$r=$_GET["r"]; //shares
$issuedate=date("Y-m-d");
//$issuedate=date( 'Y-m-d H:i:s', strtotime($issuedate));
//echo $issuedate;

//echo "symbol:".$q."    "."shares :".$r;

$con = mysql_connect("localhost","root","password");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("audit", $con);

$query="INSERT INTO csrfvul(symbol,shares,date) values('".$q."','".$r."','".$issuedate."')";

if (mysql_query($query))
       {
		echo "Record created for :".$q;
	   }
    else
       {
        echo "Record not created";
	   }

  mysql_close($con);
?> 