<?php

if(!isset($_COOKIE['Username']))
	die();

require_once("/var/www/Include/encrypt.php");

$user = stripcslashes(strip_tags(trim($_COOKIE['Username'])));
$user = decrypt(urldecode($user));

$about = stripcslashes(strip_tags(trim($_POST['about'])));

require_once("/var/www/Include/connect.php");

$about = mysql_real_escape_string($about);
mysql_query("UPDATE `users` SET `About` = '$about' WHERE `Username` = '$user' LIMIT 1");

?>