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
 global $db, $db_host, $db_user, $db_password;


function bookslot($rollno,$t1,$t2,$date)
{
include_once("config.inc.php");
 global $db, $db_host, $db_user, $db_password;
$cid = mysql_connect($db_host,$db_user,$db_password);
 if (!$cid) {

  die("ERROR: " . mysql_error() . "\n");

 }
mysql_select_db ("$db");
$stuff = mysql_query("SELECT * FROM `account` WHERE rollno='".$rollno."'") or die("MySQL Login Error: ".mysql_error()); 

if (mysql_num_rows($stuff) > 0) { 




$row=mysql_num_rows($stuff);

 

while($row = mysql_fetch_array($stuff))
  {
  $name=$row['name'];	
  $mid=$row['mid'];		
  }
}

 mysql_close($cid);






include_once("config.inc.php");
 global $db, $db_host, $db_user, $db_password,$mailsite;
$cid = mysql_connect($db_host,$db_user,$db_password);
 if (!$cid) {

  die("ERROR: " . mysql_error() . "\n");

 }
mysql_select_db ("$db");
$stuff = mysql_query("SELECT * FROM `slot_booking` WHERE  slot_date='".$date."'AND start_time='".$t1."'AND end_time='".$t2."'AND mid='".$mid."'") or die("MySQL Login Error: ".mysql_error()); 

if (mysql_num_rows($stuff) > 0) { 


echo "<center><br><h1>Someone has already booked this slot!!! try some other slot.</h1><br><br><br><br><br><br><br><br></center>";



}
else
{
		$cid = mysql_connect($db_host,$db_user,$db_password);
		 if (!$cid) {

		  die("ERROR: " . mysql_error() . "\n");

		 }
		mysql_select_db ("$db");
		$stuff = mysql_query("SELECT * FROM `slot_booking` WHERE rollno='".$rollno."'AND slot_date='".$date."'") or die("MySQL Login Error: ".mysql_error()); 

		if (mysql_num_rows($stuff) > 0) { 

		$row=mysql_num_rows($stuff);

 

		while($row = mysql_fetch_array($stuff))
		  {
		  $cst=$row['start_time'];	
		  $cet=$row['end_time'];		
		  }

		
                  $cs = abs($cst - $t1);
		  $ce = abs($cet - $t2);			
	
			}
	
		mysql_close($cid);

                  if($cs == '1' || $ce == '1')
		{
				 echo "<center><br><h1>You are not allowed to book consecutive slots</font></h1><br><br><br><br><br><br><br><br></center>";
					


		 
		 }

		else
		{
					$ip = $_SERVER['REMOTE_ADDR'];

					$gen_md = $ip.$date.$rollno.$t1.$t2;

					$rno = md5($gen_md);
					
					$port = 9900 + $mid;

					//if($mid<=7)
					//{
					$ipp = $mailsite;
					//}
					//else
					//{
					//$ipp = "10.102.152.29";
					//}


					 # Connect to the database and report any errors on connect.
					 $cid = mysql_connect($db_host,$db_user,$db_password);

					 if (!$cid) {
					  die("ERROR: " . mysql_error() . "\n");
					 } 
					 


					mysql_select_db ("$db");
					 # Setup SQL statement and add the account into the system.
					 $SQL = "INSERT INTO slot_booking (
					`rollno` ,
					`slot_date` ,
					`start_time` ,
					`end_time`,
					`time`,
					`mid`,
					`rno`,
					`is_busy`
					)
					VALUES ('$rollno','$date' ,'$t1' ,'$t2' ,'$t1','$mid','$rno','0');";


					 $result = mysql_db_query($db,$SQL,$cid);

					 # Check for errors.
					 if (!$result) {

					  die("ERROR: " . mysql_error() . "\n");

					 } 
					else

					 {



					 echo "<center><br><br><br><br><h1>$name has booked the slot $t1 - $t2 on $date </h1>";
					 #echo "<center><br><h1>Your access key for this slot is :<font color=green> $rno </font></h1>";
					  #echo "<center><br><h1>IP address : <font color=blue> $ipp </font>   Port no : <font color=red> $port </font></h1><br><br><br><br><br><br><br><br></center>";	



					}

 
				mysql_close($cid);

		}

		


}





}

?>

