<?php

$id = stripslashes(strip_tags(trim($_POST['id'])));

require_once("connect.php");

//Get Duration From Video
$duration = shell_exec("avconv -i /var/www/Uploads/num".$id.".webm 2>&1");
preg_match_all("/Duration: ([0-9\:\.]+)/", $duration, $matches);
$duration = $matches[1][0];

if (preg_match("/^00:([0-9]+:[0-9]+).[0-9]+$/", $duration))
$duration = substr($duration, 3, strlen($duration) - 6);
else
$duration = substr($duration, 0, strlen($duration) - 3);

$durationCheck = mysql_query("SELECT * `videos` WHERE  `ID` = '".$id."' LIMIT 1");
$durationCheck = mysql_fetch_array($durationCheck);
if ($durationCheck['Length'] != $duration)
{
	mysql_query("UPDATE  `videos` SET `Uploaded` = '1', `Length` =  '".$duration."' WHERE  `ID` = '".$id."' LIMIT 1");

	//Convert Duration To Seconds Only
	preg_match_all("/(([0-9]+):)?([0-9]+):([0-9]+)/", $duration, $matches);
	$time = ($matches[2][0] * 3600) + ($matches[3][0] * 60) + $matches[4][0];
	$time = rand(0, $time);
	$min = 0;
	$hours = 0;
	while ($time > 60)
	{
		$min++;
		$time -= 60;
	}

	while ($min > 60)
	{
		$hours++;
		$min -= 60;
	}

	$duration = $hours . ":" . $min . ":" . $time;
	unlink("/var/www/Uploads/".$id.".jpg");
	shell_exec("avconv -ss $duration -i /var/www/Uploads/num$id.webm -s 800x600 -frames:v 1 /var/www/Uploads/".$id.".jpg");
}

?>