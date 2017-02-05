<?php

if (!isset($_COOKIE['Username']))
	die();

	$id = stripslashes(strip_tags(trim($_POST['id'])));
	if (isset($_POST['name']))
		$name = stripslashes(strip_tags(trim($_POST['name'])));

	//WEBM CONVERSION

	$content = file_get_contents("../Logs/webm".$id.".txt");

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

	$content2 = file_get_contents("../Logs/mp4".$id.".txt");

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
		require_once("/var/www/Include/connect.php");
		require_once("/var/www/Include/encrypt.php");
		require_once("/var/www/Include/Mail.php");
		if (isset($name))
		{
			$ext = end(explode(".", $name));
			shell_exec("sudo rm /var/www/Temp/num" . $id . "." . $ext);
		}


		//Get Duration From Video
		$duration = shell_exec("avconv -i /var/www/Uploads/num".$id.".webm 2>&1");
		preg_match_all("/Duration: ([0-9\:\.]+)/", $duration, $matches);
		$duration = $matches[1][0];

		if (preg_match("/^00:([0-9]+:[0-9]+).[0-9]+$/", $duration))
			$duration = substr($duration, 3, strlen($duration) - 6);
		else
			$duration = substr($duration, 0, strlen($duration) - 3);

		mysql_query("UPDATE  `videos` SET `Uploaded` = '1', `Length` =  '".$duration."' WHERE  `ID` = '".$id."' LIMIT 1");

		//Convert Duration To Seconds Only
		preg_match_all("/([0-9]+):([0-9]+):([0-9]+).([0-9]+)/", $duration, $matches);
		$time = ($matches[1][0] * 3600) + ($matches[2][0] * 60) + $matches[3][0];

		$time = rand(0, $duration);

		shell_exec("avconv -i /var/www/Uploads/num".$id.".webm -r 1 -s 800x600 -vframes 1 -ss ".$time." /var/www/Uploads/".$id.".jpg");

		shell_exec("sudo rm /var/www/Logs/mp4".$id.".txt");
		shell_exec("sudo rm /var/www/Logs/webm".$id.".txt");
		
		$user = decrypt(urlencode($_COOKIE['Username']));
		$check = mysql_query("SELECT * FROM `subscriptions` WHERE `Subscribed` = '$user' AND `Email` = '1'");
		while($row = mysql_fetch_array($check))
		{
			$to = mysql_query("SELECT * FROM `users` WHERE `Username` = '".$row['Username']."' LIMIT 1");
			$to = mysql_fetch_array($to);
			$to = $to['Email'];
			SendMail($to , 'Plychannel - New Video' , "Hi, $user\n<br /> uploaded a new video.\n<br /> <a href='http://plychannel.com/watch?v=".urlencode(encrypt($id))."'><img src='http://plychannel.com/Images/video?i=".urlencode(encrypt($id))."' />\n<br />Click here</a> to watch it.");
		}
	}

	echo $progress;
?>