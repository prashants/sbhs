<html>

<head>
<meta http-equiv="refresh" content="2">
</head>

<body>
<table>
<tr>
<td align="center">
<?php
$base_path = "/var/www";
$base_folder = "/sb/webcam/image";
$machine_id = (int)$_GET['machine'];
if ($machine_id < 0 || $machine_id > 15) {
	echo "<img src=\"webcam.jpeg\" />";
} else {
	$image_command = "streamer -f jpeg -c /dev/video" . $machine_id . " -o " . $base_path . $base_folder . $machine_id . ".jpeg";
	exec($image_command);
	echo "<img src=\"" . $base_folder . $machine_id . ".jpeg\" />";
}
?>
</td>
</tr>
<tr>
<td align="center">
<?php echo date('d-M-Y h:i:s A', time()); ?>
</td>
</tr>
</body>
</html>

