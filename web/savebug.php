<?php
$q=$_GET["q"]; //project
$r=$_GET["r"]; //phase
$s=$_GET["s"]; //reviewer
$t=$_GET["t"]; //module
$u=$_GET["u"]; //topic
$v=$_GET["v"]; //page
$w=$_GET["w"]; //desc
$issuedate=date("Y-m-d");

//echo "project:".$q."    "."phase :".$r."reviewer :".$s."module :".$t."topic :".$u."page :".$v."desc :".$w;

$con = mysql_connect("localhost","root","password");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("audit", $con);


if(mysql_num_rows(mysql_query("SELECT * FROM bugreport where projectname='".$q."' and phase='".$r."' and module='".$t."' and topic='".$u."' and pagenumber='".$v."' and descr='".$w."'")))
    {
     echo "Record couldnot be created as this already exists.";
	 exit();
    }   

$query="INSERT INTO bugreport(projectname,phase,reviewer,reviewdate,module,topic,pagenumber,descr) values('".$q."','".$r."','".$s."','".$issuedate."','".$t."','".$u."','".$v."','".$w."')";

if (mysql_query($query))
       {
		$result = mysql_query("SELECT id FROM bugreport where projectname='".$q."' and phase='".$r."' and module='".$t."' and topic='".$u."' and pagenumber='".$v."' and descr='".$w."'");
        $row = mysql_fetch_array($result);
        echo "Record created with id :".$row['id']." and description :".$w;
	   }
    else
       {
        echo "Record not created. Please contact admin.";
	   }

  mysql_close($con);
?> 