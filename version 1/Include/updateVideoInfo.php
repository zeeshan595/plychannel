<?php
	if (!isset($_COOKIE['Username']))
		die();

	require_once("/var/www/Include/connect.php");
	require_once("/var/www/Include/encrypt.php");

	$user = stripslashes(strip_tags(trim(decrypt(urldecode($_COOKIE['Username'])))));
	$inputData = stripslashes(strip_tags(trim($_POST['inputData'])));
	$inputType = stripslashes(strip_tags(trim($_POST['inputType'])));
	$id = stripslashes(strip_tags(trim($_POST['id'])));

	if ($inputType == "title")
		$query = "UPDATE `videos` SET `Title` = '$inputData' WHERE `ID` = '$id' AND `Author` = '$user' LIMIT 1";
	else if ($inputType == "privacy")
		$query = "UPDATE `videos` SET `Privacy` = '$inputData' WHERE `ID` = '$id' AND `Author` = '$user' LIMIT 1";
	else if ($inputType == "allowed")
		$query = "UPDATE `videos` SET `ViewsAllow` = '$inputData' WHERE `ID` = '$id' AND `Author` = '$user' LIMIT 1";
	else if ($inputType == "tags")
		$query = "UPDATE `videos` SET `Tags` = '$inputData' WHERE `ID` = '$id' AND `Author` = '$user' LIMIT 1";
	else if ($inputType == "category")
		$query = "UPDATE `videos` SET `Category` = '$inputData' WHERE `ID` = '$id' AND `Author` = '$user' LIMIT 1";
	else if ($inputType == "description")
	{
		$inputData = preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank">$1</a>', $inputData);
		$inputData = nl2br($inputData);
		$query = "UPDATE `videos` SET `Description` = '$inputData' WHERE `ID` = '$id' AND `Author` = '$user' LIMIT 1";
	}
	mysql_query($query);

	echo "Saved " . $inputType . ".";
?>