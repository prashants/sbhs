<?php
session_start();
?>
<html>

<head>
<meta http-equiv="refresh" content="2">
</head>

<body>
<table>
<tr>
<td align="center">
<?php
// check if user is logged in and machine id is set
if (isset($_SESSION['rollno']) && isset($_SESSION['mid'])) {

	$base_path = "/var/www/sb/webcam";
	$machine_id = (int)$_SESSION['mid'];
	$group_id = filegroup("/dev/video" . $machine_id);

	// check if machine id is within valid range and the video file exists and the file group is 'video' = 44
	if ($machine_id < 1 || $machine_id > 15 || (!file_exists("/dev/video" . $machine_id)) || ($group_id != 44)) {
		echo "<img src=\"noimage.jpeg\" width=320 height=240 />";
	} else {
		// dump the image using streamer
		$image_command = "streamer -f jpeg -c /dev/video" . $machine_id . " -o " . $base_path . "/image" . $machine_id . ".jpeg";
		exec($image_command);
		echo "<img src=\"./image" . $machine_id . ".jpeg\" />";
	}
?>

</td>
</tr>
<tr>
<td align="center">

<?php
	echo date('d-M-Y h:i:s A', time());
	echo " - MID : " . $machine_id;
} else {
	echo "Please login before accessing this page";
}
?>

</td>
</tr>
</body>
</html>

