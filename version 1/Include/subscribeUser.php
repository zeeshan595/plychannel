<?php
if(!isset($_COOKIE['Username']))
	die();

require_once("/var/www/Include/connect.php");
require_once("/var/www/Include/encrypt.php");

$author = stripcslashes(strip_tags(trim($_POST['author'])));
$user = stripcslashes(strip_tags(trim($_POST['user'])));
$subscribed = stripcslashes(strip_tags(trim($_POST['subscribed'])));

if ($user != decrypt($_COOKIE['Username']))
	die();

if ($subscribed == '1')
{
	$check = mysql_query("SELECT * FROM `subscriptions` WHERE `Username` = '$user' AND `Subscribed` = '$author' LIMIT 1");
	if (mysql_num_rows($check) == 0 && $user != $author)
	{
		mysql_query("INSERT INTO `subscriptions` (`Time`, `ID`, `Username`, `Subscribed`, `Email`, `Order`, `Videos`) VALUES ('".time()."', '', '$user', '$author', '0', '0', '12')");
	}
	else
		die();
}
else
{
	mysql_query("DELETE FROM `subscriptions` WHERE `Username` = '$user' AND `Subscribed` = '$author' LIMIT 1");
}

?>