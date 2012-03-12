<html>
<head>
<script type="text/javascript">
function showUser(str)
{
 alert("Into ajax");
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
xmlhttp.open("GET","timeref.php?q="+str,true);
xmlhttp.send();
}
</script>
</head>
<body onload="setTimeout(showUser(1),1000)">
<br/>
<div id="txtHint"><b>Person info will be listed here.</b></div>

</body>
</html> 
