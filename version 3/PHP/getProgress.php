<?php

if (!isset($_COOKIE['Username']))
	die();

	$id = stripslashes(strip_tags(trim($_POST['id'])));
	if (isset($_POST['name']))
		$name = stripslashes(strip_tags(trim($_POST['name'])));

if (!file_exists("/var/www/Logs/webm".$id.".txt"))
	die("done");
	//WEBM CONVERSION

	$content = file_get_contents("/var/www/Logs/webm".$id.".txt");

	preg_match("/Duration: (.*?), start:/", $content, $matches);
	$rawDuration = $matches[1];

	//rawDuration is in 00:00:00.00 format. This converts it to seconds.
	$ar = array_reverse(explode(":", $rawDuration));
	$duration = floatval($ar[0]);
	if (!empty($ar[1])) $duration += intval($ar[1]) * 60;
	if (!empty($ar[2])) $duration += intval($ar[2]) * 60 * 60;

	//get the time in the file that is already encoded
	preg_match_all("/time=(.*?) bitrate/", $content, $matches);

	$rawTime = array_pop($matches);

	//this is needed if there is more than one match
	if (is_array($rawTime)){$rawTime = array_pop($rawTime);}

	//rawTime is in 00:00:00.00 format. This converts it to seconds.
	$ar = array_reverse(explode(":", $rawTime));
	$time = floatval($ar[0]);
	if (!empty($ar[1])) $time += intval($ar[1]) * 60;
	if (!empty($ar[2])) $time += intval($ar[2]) * 60 * 60;

	//calculate the progress
	$pro2 = round(($time/$duration) * 100);


	//MP4 CONVERSION

	$content2 = file_get_contents("/var/www/Logs/mp4".$id.".txt");

	preg_match("/Duration: (.*?), start:/", $content2, $matches);
	$rawDuration = $matches[1];

	//rawDuration is in 00:00:00.00 format. This converts it to seconds.
	$ar = array_reverse(explode(":", $rawDuration));
	$duration = floatval($ar[0]);
	if (!empty($ar[1])) $duration += intval($ar[1]) * 60;
	if (!empty($ar[2])) $duration += intval($ar[2]) * 60 * 60;

	//get the time in the file that is already encoded
	preg_match_all("/time=(.*?) bitrate/", $content2, $matches);

	$rawTime = array_pop($matches);

	//this is needed if there is more than one match
	if (is_array($rawTime)){$rawTime = array_pop($rawTime);}

	//rawTime is in 00:00:00.00 format. This converts it to seconds.
	$ar = array_reverse(explode(":", $rawTime));
	$time = floatval($ar[0]);
	if (!empty($ar[1])) $time += intval($ar[1]) * 60;
	if (!empty($ar[2])) $time += intval($ar[2]) * 60 * 60;

	//calculate the progress
	$pro1 = round(($time/$duration) * 100);


	$progress = ($pro1 + $pro2) / 2;

	if ($progress >= 100)
	{
		require_once("connect.php");

		if (isset($name))
		{
			$ext = end(explode(".", $name));
			shell_exec("rm /var/www/Temp/num" . $id . "." . $ext);
		}

		shell_exec("rm /var/www/Logs/mp4".$id.".txt");
		shell_exec("rm /var/www/Logs/webm".$id.".txt");		
	}

	echo $progress;

?>