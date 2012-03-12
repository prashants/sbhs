<?php
session_start();
?>

<?php

include_once("config.inc.php");
global $db, $db_host, $db_user, $db_password;

/* A script by Sitesh on sep 09 for Valid Email */

$q=$_GET["q"];

$con = mysql_connect($db_host, $db_user, $db_password);

if (!$con)
  {
    die('Could not connect: ' . mysql_error());
  }

mysql_select_db("$db", $con);

//Query should be 'select count(emailid) from account where emailid in('actual email i.e.$q');

 $sql="SELECT count(emailid) as cnt FROM account WHERE emailid in('".$q."')";

 $result = mysql_query($sql);

 $row = mysql_fetch_array($result);

 if($row['cnt']>0)
 {
       $_SESSION['regemail']=0;
     echo "Emailid is already being used !!";
    // echo "<script language=javascript>alert('Please enter a valid username.')</script>";
    // echo "<script language=javascript>alert('Emailid is already being used !!')</script>";
    // echo "<script>".'alert("Emailid is already being used !!")'."</script>";
 }
 else
 {
     $_SESSION['regemail']=1;
      echo "Emailid is available for registration ";
    // echo "<script language=javascript>alert('Emailid is available for registration')</script>";
   // echo "<script>".'alert("Emailid is available for registration")'."</script>";
 }

 mysql_close($con);

?> 

