<?php

if (!isset($_POST['id']))
	die();
else if (!isset($_COOKIE['Username']))
	die();
else if (!isset($_POST['type']))
	die();
else if (!isset($_POST['data']))
	die();

$id = strip_tags(trim($_POST['id']));
$type = strip_tags(trim($_POST['type']));
$data = addslashes(strip_tags(trim($_POST['data'])));

require_once("connect.php");

$user = decrypt(urldecode($_COOKIE['Username']));

if ($type == "title")
	$check = mysql_query("UPDATE `videos` SET `Title` = '$data' WHERE `ID` = '$id' AND `Author` = '$user' LIMIT 1");
else if ($type == "description")
	$check = mysql_query("UPDATE `videos` SET `Description` = '$data' WHERE `ID` = '$id' AND `Author` = '$user' LIMIT 1");
else if ($type == "privacy")
	$check = mysql_query("UPDATE `videos` SET `Privacy` = '$data' WHERE `ID` = '$id' AND `Author` = '$user' LIMIT 1");
else if ($type == "tags")
	$check = mysql_query("UPDATE `videos` SET `Tags` = '$data' WHERE `ID` = '$id' AND `Author` = '$user' LIMIT 1");
else if ($type == "category")
	$check = mysql_query("UPDATE `videos` SET `Category` = '$data' WHERE `ID` = '$id' AND `Author` = '$user' LIMIT 1");
else if ($type == "viewsAllowed")
	$check = mysql_query("UPDATE `videos` SET `ViewsAllow` = '$data' WHERE `ID` = '$id' AND `Author` = '$user' LIMIT 1");
else if ($type == "comments")
{
	if ($data == "true")
		$check = mysql_query("UPDATE `videos` SET `Comments` = '1' WHERE `ID` = '$id' AND `Author` = '$user' LIMIT 1");
	else
		$check = mysql_query("UPDATE `videos` SET `Comments` = '0' WHERE `ID` = '$id' AND `Author` = '$user' LIMIT 1");
}

if (isset($check) && !$check)
	die (mysql_error());

echo $id . ": " . $type . "=" . $data . "   - by " . $user;

?>