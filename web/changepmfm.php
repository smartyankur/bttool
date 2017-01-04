<html>
<head>
<script type="text/javascript">
function trim(s) {
	return rtrim(ltrim(s));
}

function ltrim(s) {
	var l=0;
	while(l < s.length && s[l] == ' ')
	{	l++; }
	return s.substring(l, s.length);
}

function rtrim(s) {
	var r=s.length -1;
	while(r > 0 && s[r] == ' ')
	{	r-=1;	}
	return s.substring(0, r+1);
}

function validateForm() {
 
	var b=trim(document.forms["tstest"]["lead"].value);
	var c=trim(document.forms["tstest"]["fmone"].value);
	var d=trim(document.forms["tstest"]["fmtwo"].value); 
	var e=trim(document.forms["tstest"]["fmthree"].value);
	var f=trim(document.forms["tstest"]["fmfour"].value);
 
	if (b=="Select") {
		alert("Project Manager must be selected.");
		return false;
	}

	if (c=="Select") {
		alert("FM One must be selected");
		return false;
	}

	if (d=="Select") {
		alert("FM Two must be selected");
		return false;
	}

	if (e=="Select") {
		alert("FM Three must be selected");
		return false;
	}

	if (f=="Select") {
		alert("FM Four must be selected");
		return false;
	}
}
</script>
</head>
<?php	
error_reporting(0); 
include("config.php");
$project = $_REQUEST['id'];
$project_id = $_REQUEST['pro_id'];
/* @saurav Modify query to fetch data using pindatabaseid */
$query="select projectmanager,fmone,fmtwo,fmthree,fmfour from projectmaster where pindatabaseid='$project_id'";

$result=mysql_query($query) or die (mysql_error());

while($row = mysql_fetch_assoc($result))  { 
     $pm=$row['projectmanager'];
	 $fmone=$row['fmone'];
     $fmtwo=$row['fmtwo'];
	 $fmthree=$row['fmthree'];
     $fmfour=$row['fmfour'];
}
		
echo "<u>"."Change PM and FM information for project :"."</u>".$project;
?>
<body background="bg.gif">

<form name="tstest" action="pfsubmit.php" onsubmit="return validateForm()" method="post">

<TABLE>
<TR>
<TD>Project Manager</TD>
<TD>
    <?php
	$query = "select DISTINCT username from login order by username";
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0) {
		die('Users Not Found; Contact SEPG');
	}

    echo "<select name=\"lead\" id=\"lead\">"; 
    echo "<option size =30 selected>Select</option>";
	?>
    <option size =30 <?php if($pm=="NA"){echo "selected";}?>>NA</option>
    <?php
	$tmp = array();
	if(mysql_num_rows($retval)) { 
		while($row = mysql_fetch_assoc($retval)) { 
			$tmp[] = $row['username'];
			$opt = $row['username'];
    ?>
    <option <?php if($pm == $opt){echo "selected";}?>><?php echo $opt;?></option> 
    <?php
		}
	} else {
		echo "<option>No Names Present</option>";  
    } 
    ?>
    </TD>
</TR>

<TR>
<TD>ID FM</TD>
<TD>
    <?php
	/* @saurav Comment query to remove redundancy on same page */
	
	/*$query = "select DISTINCT username from login order by username";
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0) {
		die('Users Not Found; Contact SEPG');
	}*/

    echo "<select name=\"fmone\" id=\"fmone\">"; 
    echo "<option size =30 selected>Select</option>";
	?>
    <option size =30 <?php if($fmone=="NA"){echo "selected";}?>>NA</option>
    <?php
	if(count($tmp)) { 
		foreach($tmp as $val) { 
	?>
    <option <?php if($fmone == $val)echo "selected";?>><?php echo $val;?></option> 
    <?php 
		}
	} else {
		echo "<option>No Names Present</option>";  
	} 
    ?>
    </TD>
</TR>

<TR>
<TD>Media FM</TD>
<TD>
    <?php
	/* @saurav Comment query to remove redundancy on same page */
	
	/*$query = "select DISTINCT username from login order by username";
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0) {
		die('Users Not Found; Contact SEPG');
	}*/

    echo "<select name=\"fmtwo\" id=\"fmtwo\">"; 
    echo "<option size =30 selected>Select</option>";
	?>
    <option size =30 <?php if($fmtwo=="NA"){echo "selected";}?>>NA</option>
    <?php 
	if(count($tmp)) { 
		foreach($tmp as $val) { 
    ?>
    <option <?php if($fmtwo == $val)echo "selected";?>><?php echo $val;?></option> 
    <?php 
		}
	} else {
		echo "<option>No Names Present</option>";  
    } 
    ?>
    </TD>
</TR>

<TR>
<TD>Script FM</TD>
<TD>
    <?php
	/* @saurav Comment query to remove redundancy on same page */
	
	/*$query = "select DISTINCT username from login order by username";
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0) {
		die('Users Not Found; Contact SEPG');
	}*/

    echo "<select name=\"fmthree\" id=\"fmthree\">"; 
    echo "<option size =30 selected>Select</option>";
    ?>
    <option size =30 <?php if($fmthree=="NA"){echo "selected";}?>>NA</option>
    <?php
	if(count($tmp)) { 
		foreach($tmp as $val) {
    ?>
    <option <?php if($fmthree == $val)echo "selected";?>><?php echo $val;?></option> 
    <?php 
		}
	} else {
		echo "<option>No Names Present</option>";  
    } 
    ?>
    </TD>
</TR>

<TR>
<TD>QC FM</TD>
<TD>
    <?php
	/* @saurav Comment query to remove redundancy on same page */
	
	/*$query = "select DISTINCT username from login order by username";
    $retval = mysql_query( $query, $con );
    $count = mysql_num_rows($retval);
	
	if($count==0) {
			die('Users Not Found; Contact SEPG');
	}*/

    echo "<select name=\"fmfour\" id=\"fmfour\">"; 
    echo "<option size =30 selected>Select</option>";
    ?>
    <option size =30 <?php if($fmfour=="NA"){echo "selected";}?>>NA</option>
    <?php
	if(count($tmp)) { 
		foreach($tmp as $val) {
    ?>
    <option <?php if($fmfour==$val)echo "selected";?>><?php echo $val;?></option> 
    <?php 
		}
	} else {
		echo "<option>No Names Present</option>";  
    } 
    ?>
    </TD>
</TR>

</TABLE>
<input type="submit"/>
<input type="hidden" name="project" value="<?php echo $project;?>">
</form>
</body>
</html> 