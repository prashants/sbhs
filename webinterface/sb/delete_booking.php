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

<link rel="stylesheet" media="screen" href="cal/styles/vlaCal-v2.1.css" type="text/css" />
<link rel="stylesheet" media="screen" href="cal/styles/vlaCal-v2.1-adobe_cs3.css" type="text/css" />
<link rel="stylesheet" media="screen" href="cal/styles/vlaCal-v2.1-apple_widget.css" type="text/css" />
	
<script type="text/javascript" src="cal/jslib/mootools-1.2-core-compressed.js"></script>
<script type="text/javascript" src="cal/jslib/vlaCal-v2.1-compressed.js"></script>



<script type="text/javascript">
		window.addEvent('domready', function() { 
			new vlaDatePicker('exampleI');			
		});	
	</script>


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
</head>

<?php 
include_once("config.inc.php");
 global $db, $db_host, $db_user, $db_password,$mailsite; //Declaring global for ip address
$date = date("d/m/Y"); 
$rollno = $_SESSION['rollno'];

 $cid = mysql_connect($db_host,$db_user,$db_password);
 if (!$cid) {

  die("ERROR: " . mysql_error() . "\n");

 }
mysql_select_db ("$db");



function hours()
{
$stuff = mysql_query("SELECT HOUR(CURTIME()) as hrs") or die("MySQL Login Error: ".mysql_error()); 

if (mysql_num_rows($stuff) > 0) { 
   $row = mysql_fetch_array($stuff);
   $hrs=$row['hrs'];
}
 return $hrs;
}

function mins()
{
$stuff = mysql_query("SELECT MINUTE(CURTIME()) as min") or die("MySQL Login Error: ".mysql_error()); 

if (mysql_num_rows($stuff) > 0) 
   { 
     $row = mysql_fetch_array($stuff);
     $min=$row['min'];
   }
 return $min;
}

function secs()
{
  $stuff = mysql_query("SELECT SECOND(CURTIME()) as sec") or die("MySQL     Login Error: ".mysql_error()); 

  if (mysql_num_rows($stuff) > 0) 
  { 
    $row = mysql_fetch_array($stuff);
    $sec=$row['sec'];
  }
return $sec;
}

$time= hours().":".mins().":".secs();

 $hrs=hours();
 $min=mins();
 $sec=secs();

 
?>

<script type="text/javascript">

/***********************************************
* Local Time script- © Dynamic Drive (http://www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit http://www.dynamicdrive.com/ for this script and 100s more.
***********************************************/

var weekdaystxt=["Sun", "Mon", "Tues", "Wed", "Thurs", "Fri", "Sat"]

var preference=0,hour=0,minutes=0,seconds=0;

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
// var hour=this.localtime.getHours()
// var minutes=this.localtime.getMinutes()
// var seconds=this.localtime.getSeconds()

if(preference==0)
      {
        hour='<?echo $hrs?>';
        minutes='<?echo $min?>';
        seconds='<?echo $sec?>';
      }

    preference=1;

   seconds++;
   if(seconds>59)
    {
      minutes++;
      seconds=seconds%60;
    }

    if(minutes>59)
    {
      hour++;
      minutes=minutes%60;
    }

// var ampm=(hour>=12)? "PM" : "AM"

var dayofweek=weekdaystxt[this.localtime.getDay()]
// this.container.innerHTML=formatField(hour, 1)+":"+formatField(minutes)+":"+formatField(seconds)+" "+ampm+" ("+dayofweek+")"
this.container.innerHTML=formatField(hour)+":"+formatField(minutes)+":"+formatField(seconds)+" ("+dayofweek+")"

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
<li><a href="index.php">Home</a></li>
<li><a href="book.php">Book Slot</a></li>
<li><a href="delete_booking.php">View / Delete Slot</a></li>
<li><a href="dirbrowser.php">Download Log Files</a></li>
<li><a href="showvideo.php">Show Video</a></li>
<li><a href="change_pass_logon.php">Change Password</a></li>
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
</ul>
</div>
<br><br>

<center><h1>View/Delete slot</h1></center>
<br><br>



<?
if(isset($_SESSION['rollno']) && isset($_SESSION['mid']) )
{
include_once("config.inc.php");
 global $db, $db_host, $db_user, $db_password;
$date = date("d/m/Y"); 
$rollno = $_SESSION['rollno'];

 $cid = mysql_connect($db_host,$db_user,$db_password);
 if (!$cid) {

  die("ERROR: " . mysql_error() . "\n");

 }
mysql_select_db ("$db");
$stuff = mysql_query("SELECT * FROM `slot_booking` WHERE slot_date>='".$date."' AND  rollno='".$rollno."'") or die("MySQL Login Error: ".mysql_error()); 
if (mysql_num_rows($stuff) > 0) { 
$row=mysql_num_rows($stuff);

echo"<center><table border=\"0\"><tr>
<th>Slot date</th>
<th>Start time</th>
<th>End time</th>";
//<th>Access key</th>
//<th>IP</th>
//<th>Port no</th>
echo "<th>Action</th>
</tr>";

while($row = mysql_fetch_array($stuff))
  {
  $stime=$row['start_time'];
  $etime=$row['end_time'];	
  $rno=$row['rno'];
  $slotdate=$row['slot_date'];
   $mid=$row['mid'];

//if($mid<=7)
//{
$ip = $mailsite;
//}
//else
//{
//$ip = "10.102.152.29";
//}


$portno = 9900 + $mid;	

echo "<tr>
<td>$slotdate</td>
<td>$stime</td>
<td>$etime</td>";
//<td>$rno</td>
//<td>$ip</td>
//<td>$portno</td>
echo "<td><a href=delete_myslot_action.php?rno=$rno&sdate=$slotdate&stime=$stime>Delete slot</a></td>
</tr>";


}

echo "</table></center>";
}
else
{


  }


}
else
{
echo "<br><br><br><br><center><b>Please login to access this feature</b></center><br><br><br><br>";
}
?>




</div>


</form></div>

</div>



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
