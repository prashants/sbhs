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




function appreg($rollno,$email)
{
# Inherit database connection information from variables defined in config.inc.php
global $db, $db_host, $db_user, $db_password,$mailsite,$directory,$mailserver;

# Connect to the database and report any errors on connect.
$cid = mysql_connect($db_host,$db_user,$db_password);

if (!$cid) {
	die("ERROR: " . mysql_error() . "\n");
} 
mysql_select_db ("$db");

$stuff = mysql_query("SELECT mid, count(mid) FROM account WHERE approved='Approved' GROUP BY mid ORDER BY count(mid), mid;") or die("MySQL Login Error: ".mysql_error());

	$row = mysql_fetch_array($stuff);
	$mid = $row['mid'];		


 # Setup SQL statement and add the account into the system.

$SQL = "UPDATE account
SET approved='Approved', mid = '".$mid."' 
WHERE rollno='$rollno' AND emailid='$email'";

 $result = mysql_db_query($db,$SQL,$cid);
 # Check for errors.
 if (!$result) {

  die("ERROR: " . mysql_error() . "\n");
} 

else
{
	echo "<center><br><br><br><br><h1>Your Account is now activated. Machine Alloted : ".$mid."</h1><br><br><br><br><br><br><br><br>";
	
	//Code By : Ankit Bahuguna	
	//Account Activation Email with the Enrolment Key of SBHS Forum Page.	

	$command ='python enrolmail.py '.$email;
	exec($command);
					
	
}

mysql_close($cid);

}

?>

