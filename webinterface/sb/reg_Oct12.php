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

<?php 

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

        var mytext = document.getElementById("rollno");
        mytext.focus();
        mytext.select();
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

</head>

<script type="text/javascript" src="livevalidation_standalone.compressed.js"></script>
<!-- Include for LiveValidation Java Script.-->

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
<li><a href="login.php">Login</a></li>
<li><a href="reg.php">Registration</a></li>
<li><a href="book.php">Book Slot</a></li>
<li><a href="contactus.php">Contact us</a></li>
</ul>
</div>
<br><br>
<h2>Registration Page</h2>
</div>
<div id="messageBox"></div>
<div id="main"><div class="layout1"><form class="safeSubmit" 
method="post" id="signup_form" name="signup_form" 
action="reg_action.php" onsubmit="return validate_form(this);">
<p>Please fill in all fields.</p>
<p class="group"><label for="rollno">Roll no</label><span 
class="help">You will use this to log in</span><span 
class="field"><input id="rollno" class="large" name="rollno" type="text"></span></p>
<p class="group"><label for="password">Choose a password</label><span 
class="help">eight characters minimum</span><span class="field"><input 
autocomplete="off" id="password" name="password" value="" class="large" 
type="password"></span></p>
<p class="group"><label for="retype_password">Re-enter password</label><span
 class="field"><input autocomplete="off" id="retype_password" 
name="retype_password" value="" class="large" type="password"></span></p>

<fieldset class="multi">
<legend class="accessAid"><span class="label">First name and Last name</span></legend>
<p class="group"><label for="first_name">First name</label><span 
class="field"><input id="first_name" class="large" name="first_name" 
type="text"></span></p><br><br><br>
<p class="group"><label for="middle_initial">Last name</label><span 
class="field"><input id="last_name" class="large" 
name="last_name" type="text"></span></p>
</fieldset>
<p class="group"><label for="rollno">Email ID</label><span 
class="field">
<input id="email" class="large" name="email" type="text" onblur="ValidEmail(this.value)">
<!-- <input id="email" class="large" name="email" type="text" onchange="ValidEmail(this.value)"> -->
</span><div id="txtHint"><b>Email Validation info will be listed here.</b></div></p>
<br>

<p class="buttons"><button type="submit" id="next.x" name="next.x" +
class="primary">Create Account</button></p>

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

<!-- CSS for LiveValidation Java Script.-->
<style>
.LV_validation_message{
    font-weight:bold;
    margin:0 0 0 5px;
}

.LV_valid {
    color:#00CC00;
}
	
.LV_invalid {
    color:#CC0000;
}
    
.LV_valid_field,
input.LV_valid_field:hover, 
input.LV_valid_field:active,
textarea.LV_valid_field:hover, 
textarea.LV_valid_field:active {
    border: 1px solid #00CC00;
}
    
.LV_invalid_field, 
input.LV_invalid_field:hover, 
input.LV_invalid_field:active,
textarea.LV_invalid_field:hover, 
textarea.LV_invalid_field:active {
    border: 1px solid #CC0000;
}
</style>
<!-- Validation Check-->
<script type="text/javascript">
var fname = new LiveValidation('first_name');
var lname = new LiveValidation('last_name');
var rollno = new LiveValidation('rollno');
var email = new LiveValidation('email');
var pass1 = new LiveValidation('password');
var pass2 = new LiveValidation('retype_password');


fname.add( Validate.Presence, { validMessage: "", failureMessage: "Cannot Be Empty!" } )
lname.add( Validate.Presence, { validMessage: "", failureMessage: "Cannot Be Empty!" } )
rollno.add( Validate.Presence, { validMessage: "", failureMessage: "Cannot Be Empty!" } )
email.add( Validate.Presence, { validMessage: "", failureMessage: "Cannot Be Empty!" } )
pass1.add( Validate.Presence, { validMessage: "", failureMessage: "Cannot Be Empty!" } )
pass2.add( Validate.Presence, { validMessage: "", failureMessage: "Cannot Be Empty!" } )

email.add( Validate.Email );

fname.add( Validate.Length, { validMessage: "", minimum: 1, maximum: 15 } );
lname.add( Validate.Length, { validMessage: "", minimum: 1, maximum: 15 } );
rollno.add( Validate.Length, { validMessage: "", minimum: 4, maximum: 10 } );
pass1.add( Validate.Length, { validMessage: "", minimum: 8, maximum: 15 } );
pass2.add( Validate.Length, { validMessage: "", minimum: 8, maximum: 15 } );

pass2.add( Validate.Confirmation, { match: 'password' } );

/* Below Validation by Sitesh on Sep 09 */

      
 
 function ValidEmail(str)
 {
   if (str=="")
   {
    document.getElementById("txtHint").innerHTML="";
    return;
   }

   if (window.XMLHttpRequest)
   {// code for IE7+, Firefox, Chrome, Opera, Safari
     xmlhttp=new XMLHttpRequest();
   }
   else
   {// code for IE6, IE5
       xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
   }
   xmlhttp.onreadystatechange=function()
   {
    if (xmlhttp.readyState==4 && xmlhttp.status==200)
       {
        document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
       }
   }
   xmlhttp.open("GET","getvalidemail.php?q="+str,true);
   xmlhttp.send();

    var emailstatus="<? echo $_SESSION['regemail'] ?>";

    // alert(emailstatus);
   
   if(emailstatus==0)
   {
     document.getElementById('next.x').disabled=true;
   }
   
   if(emailstatus==1)
   {
     document.getElementById('next.x').disabled=false;
   }
 }

/* End Of Validation by Sitesh */

</script>
</body></html>
