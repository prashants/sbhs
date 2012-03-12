<?php
session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
<html class=" jsEnabled" lang="en"><head>


<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<title> Single board heater system</title>
<meta name="description" content="">
<meta http-equiv="X-UA-Compatible" content="IE=8">
<link media="screen" rel="stylesheet" type="text/css" 
href="css/global.css">
<link rel="stylesheet" type="text/css" 
href="css/flowConsumerOnboarding.css">

<link rel="stylesheet" type="text/css" href="css/country.css">
<link media="print" rel="stylesheet" type="text/css" 
href="css/print.css">

<style type="text/css">

/*Menu*/
.underlinemenu{
font-weight: bold;
width: 100%;
}

.underlinemenu ul{
padding: 6px 0 7px 0; /*6px should equal top padding of "ul li a" below, 7px should equal bottom padding + bottom border of "ul li a" below*/
margin: 0;
text-align: center; //set value to "left", "center", or "right"*/
}

.underlinemenu ul li{
display: inline;
}

.underlinemenu ul li a{
color: #494949;
padding: 6px 3px 4px 3px; /*top padding is 6px, bottom padding is 4px*/
margin-right: 20px; /*spacing between each menu link*/
text-decoration: none;
border-bottom: 3px solid gray; /*bottom border is 3px*/
}

.underlinemenu ul li a:hover, .underlinemenu ul li a.selected{
border-bottom-color: black;
}

</style>

<script type="text/javascript">

/***********************************************
* Local Time script- © Dynamic Drive (http://www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit http://www.dynamicdrive.com/ for this script and 100s more.
***********************************************/

var weekdaystxt=["Sun", "Mon", "Tues", "Wed", "Thurs", "Fri", "Sat"]

function showLocalTime(container, servermode, offsetMinutes, displayversion){
if (!document.getElementById || !document.getElementById(container)) return
this.container=document.getElementById(container)
this.displayversion=displayversion
var servertimestring=(servermode=="server-php")? '<? print date("F d, Y H:i:s", time())?>' : (servermode=="server-ssi")? '<!--#config timefmt="%B %d, %Y %H:%M:%S"--><!--#echo var="DATE_LOCAL" -->' : '<%= Now() %>'
this.localtime=this.serverdate=new Date(servertimestring)
this.localtime.setTime(this.serverdate.getTime()+offsetMinutes*60*1000) //add user offset to server time
this.updateTime()
this.updateContainer()
}

showLocalTime.prototype.updateTime=function(){
var thisobj=this
this.localtime.setSeconds(this.localtime.getSeconds()+1)
setTimeout(function(){thisobj.updateTime()}, 1000) //update time every second
}

showLocalTime.prototype.updateContainer=function(){
var thisobj=this
if (this.displayversion=="long")
this.container.innerHTML=this.localtime.toLocaleString()
else{
var hour=this.localtime.getHours()
var minutes=this.localtime.getMinutes()
var seconds=this.localtime.getSeconds()
var ampm=(hour>=12)? "PM" : "AM"
var dayofweek=weekdaystxt[this.localtime.getDay()]
this.container.innerHTML=formatField(hour, 1)+":"+formatField(minutes)+":"+formatField(seconds)+" "+ampm+" ("+dayofweek+")"
}
setTimeout(function(){thisobj.updateContainer()}, 1000) //update container every second
}

function formatField(num, isHour){
if (typeof isHour!="undefined"){ //if this is the hour field
var hour=(num>12)? num-12 : num
return (hour==0)? 12 : hour
}
return (num<=9)? "0"+num : num//if this is minute or sec field
}

</script>

</head>

<body onLoad='new showLocalTime("timecontainer", "server-php", 0, "short")'>
<iframe style="position: absolute; visibility: visible; 
width: 2em; height: 2em; top: -29px; left: 0pt; border-width: 0pt;" 
title="Text Resize Monitor" id="_yuiResizeMonitor"></iframe><div 
style="z-index: 17; visibility: hidden;" id="balloonCalloutPanel_c" 
class="yui-panel-container balloon yui-overlay-hidden"><div 
style="visibility: inherit; top: 873px; left: 442px;" class="yui-module 
yui-overlay yui-panel posUnder" id="balloonCalloutPanel"><div 
class="body"></div></div></div>
<noscript><p class="nonjsAlert">NOTE: Many features on the website require Javascript and cookies. You can enable both via your browser's preference settings.</p></noscript>
<div class="onboarding signup" id="page">
<div id="header" class="notab">
<h1><img 
src="img/1.jpg" alt="Single board heater system" border="0"></h1>
<div class="empty" id="navPrimary"></div>
</div>
<div id="content">
<div id="headline">
<div class="underlinemenu">
<ul>
<?
if(isset($_SESSION['rollno']) && isset($_SESSION['mid']) )
{
print "
<li><a href=logout.php>Logout</a></li>
";
}
else
{
print "
<li><a href=login.php>Login</a></li>
";
}
?>
<li><a href="delete_booking.php">View / Delete slot</a></li>
<li><a href="book.php">Book Slot</a></li>
<li><a href="contactus.php">Contact us</a></li>
</ul>
</div>
<br><br>
</div>
<div id="messageBox"></div>
<div id="main"><div class="layout1">



<?php
if(isset($_SESSION['rollno']) && isset($_SESSION['mid']) )
{

$date = $_POST["date"];
$rollno = $_SESSION['rollno'];
$mid = $_SESSION['mid'];
$i = 0;
$j = 0;
$arr=split("/",$date); // splitting the array
$dd=$arr[0]; // first element of the array is date
$mm=$arr[1]; // second element is month
$yy=$arr[2]; // third element is year
//if($date=date("d/m/y"))
$bk_date=mktime(23,59,59,$mm,$dd,$yy);
if (($bk_date-time()) < 0)
{
	die("<center><br><br><br><br><h1>You cannot book a slot in the past because Time Travel has not been invented yet.</h1></center>");
}
include_once("config.inc.php");
 global $db, $db_host, $db_user, $db_password;


$cid = mysql_connect($db_host,$db_user,$db_password);
 if (!$cid) {

  die("ERROR: " . mysql_error() . "\n");

 }
mysql_select_db ("$db");
$stuff = mysql_query("SELECT * FROM `slot_booking` where slot_date='$date' AND rollno='$rollno'") or die("MySQL Login Error: ".mysql_error()); 

if (mysql_num_rows($stuff) > 0) { //Has Booked one or more slots

		$noofslots = mysql_num_rows($stuff);
		$stuff2 = mysql_query("SELECT `slot_id` FROM `slot_booking` where slot_date='$date' AND rollno='$rollno'") or die("MySQL Login Error: ".mysql_error());
		$no_curr_bookings = 0;
		while($row2 = mysql_fetch_array($stuff))
		{
			$stuff3 = mysql_query("SELECT `slot_id` FROM `curr_bookings` where `slot_id`='".$row2['slot_id']."'") or die("MySQL Login Error: ".mysql_error());
			if(mysql_num_rows($stuff3)>0)
				{$no_curr_bookings+=1;}

		}
		
		if ($noofslots < 2 + $no_curr_bookings )//But total no of slots less than 2 + booked by current booking.
		{
			
			echo "<form class=\"safeSubmit\" 
			method=\"post\" id=\"signup_form\" name=\"signup_form\" 
			action=\"book_slot_action.php\">
			<p>Please fill in all fields.</p>
			<p class=\"group\"><label for=\"rollno\">Select a time slot :</label><span 
			class=\"help\">you will be allocated experiment slot in this time slot</span><span 
			class=\"field\"><select name=\"time\">";
			
			while($row = mysql_fetch_array($stuff))
		  	{
			  	$start=$row['start_time'];
			  	$end=$row['end_time'];
			  	$sid=$row['slot_id'];

				
			}

			


			$cid3 = mysql_connect($db_host,$db_user,$db_password);
			 if (!$cid3) {

			  die("ERROR: " . mysql_error() . "\n");

			 }
			mysql_select_db ("$db");
			$stuff = mysql_query("SELECT * FROM `slot` ") or die("MySQL Login Error: ".mysql_error()); 

			if (mysql_num_rows($stuff) > 0)
			{ 
			while($row = mysql_fetch_array($stuff))
			  {
				
				$stime=$row['start_time'];
			  	$etime=$row['end_time'];
			  	$sid=$row['slot_id'];

					

				$cid2 = mysql_connect($db_host,$db_user,$db_password);
				 if (!$cid2)
				{

			  	die("ERROR: " . mysql_error() . "\n");

			 	}
				mysql_select_db ("$db");
				$stuff2 = mysql_query("SELECT * FROM `slot_booking` where slot_date='$date' AND start_time='$stime' AND mid='$mid'") or die("MySQL Login Error: ".mysql_error()); 
				

				if (mysql_num_rows($stuff2) > 0)
				{
					
				}
				else
				{
					$hn=0;
					$hh=0;
					if($date==date("d/m/Y"))
					{
						$hh=(int)$stime;
						$hn=date("H");
						
					
					}
					if($hh-$hn>=0)
					{
						$time = $stime." - ".$etime;
						echo "<option value=\"$time\">$time</option>";
					}
				}


	
			  }//while($row = mysql_fetch_array($stuff)) end
		} // if(mysql_nom_rows($stuff))

			
			
			echo "</select></span></p>
			<br>
			<input type=hidden value=$rollno name=rollno>
			<input type=hidden value=$date name=date>
			<p class=\"buttons\"><button type=\"submit\" id=\"next.x\" name=\"next.x\" +
			class=\"primary\">Book Slot</button></p>";


			}//No of slots less than 2
			else
			{

				 echo "<center><br><br><br><br><h1>Please try another day! You cannot book more than two slots in a day</h1><br><br><br><br><br><br><br><br>";

			}
		

                    
}//Has Booked one or more slots
else
{//Not booked even 1 slot on this date.

			echo "<form class=\"safeSubmit\" 
			method=\"post\" id=\"signup_form\" name=\"signup_form\" 
			action=\"book_slot_action.php\">
			<p>Please fill in all fields.</p>
			<p class=\"group\"><label for=\"rollno\">Select a time slot :</label><span 
			class=\"help\">you will be allocated experiment slot in this time slot</span><span 
			class=\"field\"><select name=\"time\">";
			
			while($row = mysql_fetch_array($stuff))
		  	{
			  	$start=$row['start_time'];
			  	$end=$row['end_time'];
			  	$sid=$row['slot_id'];

				
			}

			


			$cid3 = mysql_connect($db_host,$db_user,$db_password);
			 if (!$cid3) {

			  die("ERROR: " . mysql_error() . "\n");

			 }
			mysql_select_db ("$db");
			$stuff = mysql_query("SELECT * FROM `slot` ") or die("MySQL Login Error: ".mysql_error()); 

			if (mysql_num_rows($stuff) > 0)
			{ 
			while($row = mysql_fetch_array($stuff))
			  {
				
				$stime=$row['start_time'];
			  	$etime=$row['end_time'];
			  	$sid=$row['slot_id'];

					

				$cid2 = mysql_connect($db_host,$db_user,$db_password);
				 if (!$cid2)
				{

			  	die("ERROR: " . mysql_error() . "\n");

			 	}
				mysql_select_db ("$db");
				$stuff2 = mysql_query("SELECT * FROM `slot_booking` where slot_date='$date' AND start_time='$stime' AND mid='$mid'") or die("MySQL Login Error: ".mysql_error()); 
				

				if (mysql_num_rows($stuff2) > 0)
				{
					
				}
				else
				{
					$hn=0;
					$hh=0;
					if($date==date("d/m/Y")) // if booking date == Current date
					{
						
						$hh=(int)$stime;
						$hn=date("H");
					}
					if($hh-$hn>=0) //if booking hour - current hour >= 0 then print in list
					{
						$def .= $hh.",".$hn.",";
						$time = $stime." - ".$etime;
						echo "<option value=\"$time\">$time</option>";
					}
				}


	
			  }//while($row = mysql_fetch_array($stuff)) end
		} // if(mysql_nom_rows($stuff))

			
			
			echo "</select></span></p>
			<br>
			<input type=hidden value=$rollno name=rollno>
			<input type=hidden value=$date name=date>
			<p class=\"buttons\"><button type=\"submit\" id=\"next.x\" name=\"next.x\" +
			class=\"primary\">Book Slot</button></p>";


}//end of no booking on date.


}


?>



</div>


</form></div></div>
</div>
<div id="footer">
<ul>
<li class="last"><a 
href="contactus.php">Contact
 Us</a></li>
<li class="last">

</li>
</ul>
Current Server Time:<span id="timecontainer"></span>
<p id="legal">Single Board Heater System Lab - Automation Lab - <b>Chemical Dept IIT Bombay</b></div>

</body></html>
