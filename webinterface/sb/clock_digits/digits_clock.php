<?php
// En: Begin PHP Code / Fr: Debut code PHP
/******************************************************************************\
* Digital Access Counter                       Version 1.0                     *
* Copyright 2000 Frederic TYNDIUK (FTLS)       All Rights Reserved.            *
* E-Mail: tyndiuk@ftls.org                     Script License: GPL             *
* Created  02/28/2000                          Last Modified 02/28/2000        *
* Scripts Archive at:                          http://www.ftls.org/php/        *
*******************************************************************************/
// Necessary Variables:

$IMG_DIR_URL = "./digits/";
	// En: URL Directory of digits (0.gif ... 9.gif).
	// Fr: URL du repertoire des images (0.gif ... 9.gif).

// End  Necessary Variables section
/******************************************************************************/

function txt2digits ($txt) {
	global $IMG_DIR_URL;

	$digits = preg_split("//", $txt);

	while (list($key, $val) = each($digits)) {
		if ($val != "")  {
				if ($val == "-") $val = "dash";
				if ($val == ":") $val = "colon";
			$html_result .= "<IMG SRC=\"$IMG_DIR_URL$val.gif\">";
		}
	}
	return $html_result;
}

$date = txt2digits(date("d-m-Y"));
$time = txt2digits(date("H:i:s"));

// En: End PHP Code
// Fr: Fin code PHP
?>

<HTML><HEAD><TITLE>Clock</TITLE></HEAD>
<BODY BGCOLOR="white">
<BR><BR><P ALIGN="Center"><FONT FACE="Arial, helvetica" SIZE="+2" COLOR="#336699"><STRONG><EM>Sample / Examples</EM></STRONG></FONT></P><BR>

<CENTER>
<?php echo $date ?>
<P>
<?php echo $time ?>
</CENTER>

<div id="maincontent">

<?php
      if (true) 
      {
        include 'gclock.php';
      }
?>

</div>
<CENTER><BR><BR>
	<FONT FACE="Arial" SIZE=-2>
	<EM>&copy Copyright 2000 <A HREF="http://www.ftls.org/ftls.shtml">FTLS</A> (Tyndiuk Fr&eacute;d&eacute;ric). All rights reserved.
	<BR>FTLS's PHP Scripts Archive : <A HREF="http://www.ftls.org/php/">http://www.ftls.org/php/</A></EM></FONT>
</CENTER></BODY></HTML>
