<!--

## Note : Removing the copyright notice is violation of the GNU Licenses ##
// +----------------------------------------------------------------------+                
// +----------------------------------------------------------------------+
// | Developed by Sushanth Poojary                                        |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GNU - GPL license, |
// | that is bundled with this package in the folder LICENSE, and is      |
// | available through the world-wide-web at                              |  
// |	    http://www.gnu.org/licenses/gpl-2.0.html                      |  
// | This program is free software; you can redistribute it and/or modify | 
// | it under the terms of the GNU General Public License as published by |
// | the Free Software Foundation; either version 2 of the License, or	  |
// | (at your option) any later version.			          | 
// |                                                                      |
// | This program is distributed in the hope that it will be useful,      |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of       |  
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the         | 
// | GNU General Public License for more details.                         |
// |                                                                      | 
// | You should have received a copy of the GNU General Public License    |
// | along with this program; if not, write to the Free Software          |
// | Foundation, Inc., 59 Temple Place, Suite 330, Boston,                |  
// | MA 02111-1307 USA.                 				  |	
// +----------------------------------------------------------------------+
// | Author: Sushanth Poojary <sushanth.poojary@gmail.com>     		  |
// | Copyright © 2010             					  |
// +----------------------------------------------------------------------+
// +----------------------------------------------------------------------+ 

-->
<?php

include_once("config.inc.php");




function addreg($rollno,$password ,$first_name,$last_name,$email)
{

include_once("config.inc.php");
 
//Mid creator code cut - Tanuj.

 # Inherit database connection information from variables defined in config.inc.php
 global $db, $db_host, $db_user, $db_password,$mailsite,$directory,$mailserver;

 # Connect to the database and report any errors on connect.
 $cid = mysql_connect($db_host,$db_user,$db_password);

 if (!$cid) {
  die("ERROR: " . mysql_error() . "\n");
 } 
 
$name = $first_name." ".$last_name;


$today = date("d.m.Y"); 



 # Setup SQL statement and add the account into the system.
 $SQL = "INSERT INTO account (
`rollno` ,
`password` ,
`emailid` ,
`name`,
`mid`,
`regdate`,
`approved`
)
VALUES ('$rollno','$password' ,'$email' ,'$name' ,'0','$today','Not approved');";

 $result = mysql_db_query($db,$SQL,$cid);
//Sending Email For Authentication using actmail.py
								

$command ='python actmail.py '.$email.' '.$rollno;
exec($command);

					


 # Check for errors.
 if (!$result) {

  die("ERROR: " . mysql_error() . "\n");

 } 
else

 {


	echo "<center><br><br><br><br><h1>Registration Complete! Please Check your Email Inbox (or Spambox) to activate your account. </h1><br><br><br><br><br><br><br><br>";
	//echo "http://$mailsite/test/activate_account.php?rollno=$rollno&emailid=$email";


}

 

 mysql_close($cid);

}

?>

