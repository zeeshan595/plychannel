<?php

if (!isset($_COOKIE['Username']))
	die();

require_once("/var/www/Include/connect.php");
require_once("/var/www/Include/encrypt.php");

$user = stripslashes(strip_tags(trim($_COOKIE['Username'])));
$user = decrypt(urldecode($user));
$id = stripcslashes(strip_tags(trim($_POST['id'])));

mysql_query("UPDATE `users` SET `Channelvideo` = '$id' WHERE `Username` = '$user' LIMIT 1");
?>