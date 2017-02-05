<?php
if (!isset($_COOKIE['Username']))
	die("You must be logged in to report a video.");

require_once('/var/www/Include/connect.php');
require_once('/var/www/Include/encrypt.php');

$user = decrypt($_COOKIE['Username']);
$id = strip_tags(stripcslashes(trim($_POST['id'])));
$message = strip_tags(stripcslashes(trim($_POST['message'])));

$check = mysql_query("SELECT * FROM `VideoRportings` WHERE `Username` = '$user' AND `videoID` = '$id' LIMIT 1");
if (mysql_num_rows($check) == 0)
{
	mysql_query("INSERT INTO `VideoRportings` (`id`, `Username`, `videoID`, `message`) VALUES ('id', '$user', '$id', '$message')");
	mysql_query("UPDATE `videos` SET `reports` = `reports` + 1 WHERE `ID` = '$id' LIMIT 1");
	echo "<div class='alert alert-success'>This video has been reported. Thanks!</div>";
}
else
{
	echo "<div class='alert alert-danger'>You already have reported this video.</div>";
}
?>