<?php

$id = stripslashes(strip_tags(trim($_POST['id'])));
if (isset($_POST['name']))
{
	$name = stripslashes(strip_tags(trim($_POST['name'])));
	$ext = end(explode(".", $name));
}
else
	die("");

//Get Duration From Video
$duration = shell_exec("avconv -i /var/www/Temp/num".$id.".".$ext." 2>&1");
preg_match_all("/Duration: ([0-9\:\.]+)/", $duration, $matches);
$duration = $matches[1][0];

preg_match("/^([0-9]+):([0-9]+):([0-9]+).([0-9]+)$/", $duration, $matched);

$hours = $matched[1];
$min = $matched[2];
$seconds = $matched[3];

if ($hours == "00")
	$duration = $min . ":" . $seconds;
else
	$duration = $hours . ":" . $min . ":" . $seconds;

shell_exec("avconv -ss ".$duration." -i /var/www/Temp/num".$id.".".$ext." -s 800x600 -frames:v 1 /var/www/Uploads/".$id.".jpg");

require_once("/var/www/PHP/connect.php");

mysql_query("UPDATE `videos` SET `Uploaded` = '1', `Length` =  '".$duration."' WHERE  `ID` = '".$id."' LIMIT 1");

?>