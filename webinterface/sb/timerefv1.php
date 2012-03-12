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

</head>

<?php

 include_once("config.inc.php");
 global $db, $db_host, $db_user,$db_password;
 global $hrs,$min,$sec,$time;

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

<SCRIPT>
 var tick;
 var gtime,hrs,mint,sec;
 var hours=new Array(); 
 var minutes=new Array();
 var seconds=new Array();

 function stop() {
   clearTimeout(tick);
   }

 function simpleClock() {
 
   var v1,v2,v3;
  
   sec++;

   if(sec>59)
    {
      mint++;
      sec=sec%60;
    }

    if(mint>59)
    {
      hrs++;
      mint=mint%60;
    }
    
 v1=hours[hrs];
 v2=minutes[mint];
 v3=seconds[sec];

 gtime=v1+":"+v2+":"v3;         

 alert("<br>"+gtime);

   document.getElementById("sclock").value=gtime;
   tick=setTimeout("simpleClock()",1000);    

   }

 function digit() {

 //  var hours=new Array(); 
   
   hours[0]="00";       
   hours[1]="01";
   hours[2]="02";
   hours[3]="03";
   hours[4]="04";
   hours[5]="05";
   hours[6]="06";
   hours[7]="07";
   hours[8]="08";
   hours[9]="09";
   hours[10]="10";
   hours[11]="11";
   hours[12]="12";
   hours[13]="13";
   hours[14]="14";
   hours[15]="15";
   hours[16]="16";
   hours[17]="17";
   hours[18]="18";
   hours[19]="19";
   hours[20]="20";
   hours[21]="21";
   hours[22]="22";
   hours[23]="23";

  // var minutes=new Array();
   minutes[0]="00";
   minutes[1]="01";
   minutes[2]="02";
   minutes[3]="03";
   minutes[4]="04";
   minutes[5]="05";
   minutes[6]="06";
   minutes[7]="07";
   minutes[8]="08";
   minutes[9]="09";
   minutes[10]="10";
   minutes[11]="11";
   minutes[12]="12";
   minutes[13]="13";
   minutes[14]="14";
   minutes[15]="15";
   minutes[16]="16";
   minutes[17]="17";
   minutes[18]="18";
   minutes[19]="19";
   minutes[20]="20";
   minutes[21]="21";
   minutes[22]="22";
   minutes[23]="23";
   minutes[24]="24";
   minutes[25]="25";
   minutes[26]="26";
   minutes[27]="27";
   minutes[28]="28";
   minutes[29]="29";
   minutes[30]="30";
   minutes[31]="31";
   minutes[32]="32";
   minutes[33]="33";
   minutes[34]="34";
   minutes[35]="35";
   minutes[36]="36";
   minutes[37]="37";
   minutes[38]="38";
   minutes[39]="39";
   minutes[40]="40";
   minutes[41]="41";
   minutes[42]="42";
   minutes[43]="43";
   minutes[44]="44";
   minutes[45]="45";
   minutes[46]="46";
   minutes[47]="47";
   minutes[48]="48";
   minutes[49]="49";
   minutes[50]="50";
   minutes[51]="51";
   minutes[52]="52";
   minutes[53]="53";
   minutes[54]="54";
   minutes[55]="55";
   minutes[56]="56";
   minutes[57]="57";
   minutes[58]="58";
   minutes[59]="59";

  // var seconds=new Array();
   seconds[0]="00";
   seconds[1]="01";
   seconds[2]="02";
   seconds[3]="03";
   seconds[4]="04";
   seconds[5]="05";
   seconds[6]="06";
   seconds[7]="07";
   seconds[8]="08";
   seconds[9]="09";
   seconds[10]="10";
   seconds[11]="11";
   seconds[12]="12";
   seconds[13]="13";
   seconds[14]="14";
   seconds[15]="15";
   seconds[16]="16";
   seconds[17]="17";
   seconds[18]="18";
   seconds[19]="19";
   seconds[20]="20";
   seconds[21]="21";
   seconds[22]="22";
   seconds[23]="23";
   seconds[24]="24";
   seconds[25]="25";
   seconds[26]="26";
   seconds[27]="27";
   seconds[28]="28";
   seconds[29]="29";
   seconds[30]="30";
   seconds[31]="31";
   seconds[32]="32";
   seconds[33]="33";
   seconds[34]="34";
   seconds[35]="35";
   seconds[36]="36";
   seconds[37]="37";
   seconds[38]="38";
   seconds[39]="39";
   seconds[40]="40";
   seconds[41]="41";
   seconds[42]="42";
   seconds[43]="43";
   seconds[44]="44";
   seconds[45]="45";
   seconds[46]="46";
   seconds[47]="47";
   seconds[48]="48";
   seconds[49]="49";
   seconds[50]="50";
   seconds[51]="51";
   seconds[52]="52";
   seconds[53]="53";
   seconds[54]="54";
   seconds[55]="55";
   seconds[56]="56";
   seconds[57]="57";
   seconds[58]="58";
   seconds[59]="59";

   gtime='<?=$time?>';

   hrs='<?=$hrs?>';
   mints='<?=$min?>';
   sec='<?=$sec?>';
   
   simpleClock();
    
 }

</SCRIPT>

<body onLoad="digit();" onUnload="stop();"><iframe style="position: absolute; visibility: visible; 
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
<h2>Login</h2>
</div>
<div id="messageBox"></div>
<div id="main"><div class="layout1"><form class="safeSubmit" 
method="post" id="signup_form" name="signup_form" 
action="logon.php">
<p class="group"><label for="email">Roll no :</label><span 
class="field"><input id="uname" class="large" name="uname" type="text"></span></p>
<p class="group"><label for="password">Password :</label><span class="field"><input 
autocomplete="off" id="pass" name="pass" value="" class="large" 
type="password"></span></p>


<br>
<p class="buttons"><button type="submit" id="next.x" name="next.x" 
class="primary">Login</button></p>

</div>


</form></div></div>
</div>
<div id="footer">
<ul>
<li class="last"><a 
href="contactus.php">Contact
 Us</a></li>
</ul>

<INPUT TYPE="text" NAME="stime" id="sclock" SIZE="13">

<p id="legal">Single Board Heater System Lab - Automation Lab - <b>Chemical Dept IIT Bombay</b></div>

</body></html>
