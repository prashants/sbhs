<?php

$mystring='ankit123';
echo 'STRING: '.$mystring.'</br>';

$mystringmd5=md5($mystring);
echo 'MD5(STRING): '.$mystringmd5.'</br></br>';

$mystring='ankit1234';
echo 'STRING: '.$mystring.'</br>';

$mystringmd5=md5($mystring);
echo 'MD5(STRING): '.$mystringmd5.'</br>';

$mystring1=mysql_real_escape_string($mystring);
echo 'MSQLRES(STRING): '.$mystring1.'</br>';

$mystringmdsre=md5($mystring1);
echo 'MD5(MSQLRES(STRING)): '.$mystringmdsre.'</br>';

?>
