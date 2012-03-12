<HTML>
<script>

function load_content()
{
 alert('Into content goal');
 window.location.reload();
}

function v_context()
{
  alert('Into v_context goal');
  setTimeout("load_content()",1000);
}
</script>
<BODY onLoad="v_context()">
<INPUT TYPE="text" NAME="stime" id="sclock" SIZE="13">
<?php

 $time=time();
 $time_ref=mktime(0,0,0,date("m"),date("d"),date("Y"));
 $refseconds=$time-$time_ref;
 $hr=floor($refseconds/(60*60));
 if($hr<10)
  $hr="0".$hr;
 $refseconds=$refseconds-($hr*60*60);
 $min=floor($refseconds/60);
 if($min<10)
  $min="0".$min;
 $refseconds=$refseconds-($min*60);
 $sec=$refseconds;
 if($sec<10)
  $sec="0".$sec;
 $final_time=$hr.":".$min.":".$sec;
 //echo "<br>Current Time : ".time();

?>

<?
echo $final_time;

?>

<!--
<script>
document.getElementById('sclock').value='<?echo $final_time?>';
</script>
-->
</BODY>
</HTML>
