<?php

$id = stripcslashes(strip_tags(trim($_POST['id'])));

//Get Duration From Video
$duration = shell_exec("avconv -i /var/www/Uploads/num".$id.".webm 2>&1");
preg_match_all("/Duration: ([0-9\:\.]+)/", $duration, $matches);
$duration = $matches[1][0];

//Convert Duration To Seconds Only
preg_match_all("/([0-9]+):([0-9]+):([0-9]+).([0-9]+)/", $duration, $matches);
$timeInSeconds = ($matches[1][0] * 3600) + ($matches[2][0] * 60) + $matches[3][0];

$time = rand(1, $timeInSeconds);


shell_exec("avconv -i /var/www/Uploads/num".$id.".webm -r 1 -s 800x600 -vframes 1 -ss ".$time." /var/www/Uploads/".$id.".jpg");

//Update MySQL video length.
require_once("/var/www/Include/connect.php");
if (preg_match("/^00:([0-9]+:[0-9]+).[0-9]+$/", $duration))
	$duration = substr($duration, 3, strlen($duration) - 6);
else
	$duration = substr($duration, 0, strlen($duration) - 3);

mysql_query("UPDATE  `videos` SET `Uploaded` = '1', `Length` =  '".$duration."' WHERE  `ID` = '".$id."' LIMIT 1");

echo $duration;
?>