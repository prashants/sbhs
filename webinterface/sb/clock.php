<html>
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

 $hours=array("00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23");

 $minutes[0]="00";
 $minutes[1]="01";
 $minutes[2]="02";
 $minutes[3]="03";
 $minutes[4]="04";
 $minutes[5]="05";
 $minutes[6]="06";
 $minutes[7]="07";
 $minutes[8]="08";
 $minutes[9]="09";
 $minutes[10]="10";
 $minutes[11]="11";
 $minutes[12]="12";
 $minutes[13]="13";
 $minutes[14]="14";
 $minutes[15]="15";
 $minutes[16]="16";
 $minutes[17]="17";
 $minutes[18]="18";
 $minutes[19]="19";
 $minutes[20]="20";
 $minutes[21]="21";
 $minutes[22]="22";
 $minutes[23]="23";
 $minutes[24]="24";
 $minutes[25]="25";
 $minutes[26]="26";
 $minutes[27]="27";
 $minutes[28]="28";
 $minutes[29]="29";
 $minutes[30]="30";
 $minutes[31]="31";
 $minutes[32]="32";
 $minutes[33]="33";
 $minutes[34]="34";
 $minutes[35]="35";
 $minutes[36]="36";
 $minutes[37]="37";
 $minutes[38]="38";
 $minutes[39]="39";
 $minutes[40]="40";
 $minutes[41]="41";
 $minutes[42]="42";
 $minutes[43]="43";
 $minutes[44]="44";
 $minutes[45]="45";
 $minutes[46]="46";
 $minutes[47]="47";
 $minutes[48]="48";
 $minutes[49]="49";
 $minutes[50]="50";
 $minutes[51]="51";
 $minutes[52]="52";
 $minutes[53]="53";
 $minutes[54]="54";
 $minutes[55]="55";
 $minutes[56]="56";
 $minutes[57]="57";
 $minutes[58]="58";
 $minutes[59]="59";

 $seconds[0]="00";
 $seconds[1]="01";
 $seconds[2]="02";
 $seconds[3]="03";
 $seconds[4]="04";
 $seconds[5]="05";
 $seconds[6]="06";
 $seconds[7]="07";
 $seconds[8]="08";
 $seconds[9]="09";
 $seconds[10]="10";
 $seconds[11]="11";
 $seconds[12]="12";
 $seconds[13]="13";
 $seconds[14]="14";
 $seconds[15]="15";
 $seconds[16]="16";
 $seconds[17]="17";
 $seconds[18]="18";
 $seconds[19]="19";
 $seconds[20]="20";
 $seconds[21]="21";
 $seconds[22]="22";
 $seconds[23]="23";
 $seconds[24]="24";
 $seconds[25]="25";
 $seconds[26]="26";
 $seconds[27]="27";
 $seconds[28]="28";
 $seconds[29]="29";
 $seconds[30]="30";
 $seconds[31]="31";
 $seconds[32]="32";
 $seconds[33]="33";
 $seconds[34]="34";
 $seconds[35]="35";
 $seconds[36]="36";
 $seconds[37]="37";
 $seconds[38]="38";
 $seconds[39]="39";
 $seconds[40]="40";
 $seconds[41]="41";
 $seconds[42]="42";
 $seconds[43]="43";
 $seconds[44]="44";
 $seconds[45]="45";
 $seconds[46]="46";
 $seconds[47]="47";
 $seconds[48]="48";
 $seconds[49]="49";
 $seconds[50]="50";
 $seconds[51]="51";
 $seconds[52]="52";
 $seconds[53]="53";
 $seconds[54]="54";
 $seconds[55]="55";
 $seconds[56]="56";
 $seconds[57]="57";
 $seconds[58]="58";
 $seconds[59]="59";

 $time= hours().":".mins().":".secs();

 $hrs=hours();
 $min=mins();
 $sec=secs();

 $interval=1;
 
 while(true)
 {
   sleep($interval);
   
   $sec++;

   if($sec>59)
    {
      $min++;
      $sec=$sec%60;
    }

    if($min>59)
    {
      $hrs++;
      $min=$min%60;
    }
    
         
    

 }

   while(list($k2,$v2)=each($hours))
   {
     echo($v2."\n");
   }

      
   

/* $MonList = array
   
      (
   
              // Match month
   
              '01' => 'Jan',
   
              '02' => 'Feb',
   
              '03' => 'Mar',
   
              '04' => 'Apr',
   
              '05' => 'May',
   
              '06' => 'Jun',
  
              '07' => 'Jul',
  
              '08' => 'Aug',
  
              '09' => 'Sep',
  
              '10' => 'Oct',
  
              '11' => 'Nov',
  
              '12' => 'Dec',
  
              
      );
  
      // Loop through the array 
  
      foreach($MonList as $CurrMon=>$Match)
  
      {
  
             // Find a match

              if (eregi($Match, $tokenized2))
              {
                      // We found the correct match
                      break;
              }
      }
	  //echo "$CurrMon";
	  $finaldt=$tokenized3 . "/" . $CurrMon . "/" .$tokenized1;
	  return $finaldt;
	}
*/
//function gettm() 
//{
  $time=hours().":".mins().":".secs();
  sleep(5);
//}
echo "1=>".$time;
sleep(5);
$time=hours().":".mins().":".secs();
echo "<br>2=>".$time;
sleep(5);
$time=hours().":".mins().":".secs();
echo "<br>3=>".$time;
?>

<!--
   
<SCRIPT>
 var tick;
 function stop() {
   clearTimeout(tick);
   }

 function simpleClock(cnt,hr,min,sec) {
 //  var ut=new Date();

  alert("Into clock Fn"+cnt+":"+hr+":"+min+":"+sec);
   var h,m,s;
   var time="        ";
   if(cnt==1)
  {
     h=<?=hours();?>;
     m=<?=mins(); ?>;
     s=<?=secs(); ?>;
  }
else
 { 
   h=hr;
   m=min;
   s=sec;
   
   s++;
   if(s>59)
   {
     m++;
     s=s%60;
   }
   
   if(m>59)
   {
     h++;
     m=m%60;
   }

 
  }
     if(s<=9) s="0"+s;
     if(m<=9) m="0"+m;
     if(h<=9) h="0"+h;
     time+=h+":"+m+":"+s;
     document.getElementById("sclock").value=time;
     tick=setTimeout('simpleClock(cnt+1,h,m,s)',1000);    
}
</SCRIPT>

<body onLoad="simpleClock(1,0,0,0);" onUnload="stop();">
<INPUT TYPE="text" NAME="stime" id="sclock" SIZE="13">
-->

<body>
<INPUT TYPE="text" NAME="stime" id="sclock" SIZE="13" value="<?=$time?>">
</body></html>

<!-- Suggested Approach 
Call PHP Fn in this file & implement time script in another php file 
-->
