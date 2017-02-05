<?php

if (!isset($_COOKIE['Username']))
	die();

require_once("connect.php");

$user = decrypt(urldecode($_COOKIE['Username']));
$like = addslashes(strip_tags(trim($_POST['like'])));
$vid = addslashes(strip_tags(trim($_POST['id'])));

$exists = mysql_query("SELECT * FROM `likes` WHERE `videoID` = '$vid' AND `Username` = '$user' LIMIT 1");
if (!$exists)
	die("Couldn't check if already liked the video");

if (mysql_num_rows($exists) > 0)
{
	$check = mysql_fetch_array($exists);
	$id = $check['ID'];
	$liked = $check['Liked'];
	if ($liked == $like)
	{
		mysql_query("DELETE FROM `likes` WHERE `ID` = '$id' LIMIT 1");
		if ($like)
			mysql_query("UPDATE `videos` SET `Likes` = `Likes`-1 WHERE `id` = '$vid' LIMIT 1");
		else
			mysql_query("UPDATE `videos` SET `Dislikes` = `Dislikes`-1 WHERE `id` = '$vid' LIMIT 1");
	}
	else
	{
		mysql_query("UPDATE `likes` SET `Liked` = '$like', `Time` = '".time()."' WHERE `ID` = '$id' LIMIT 1");
		if ($like)
			mysql_query("UPDATE `videos` SET `Likes` = `Likes`+1, `Dislikes` = `Dislikes`-1 WHERE `id` = '$vid' LIMIT 1");
		else
			mysql_query("UPDATE `videos` SET `Likes` = `Likes`-1, `Dislikes` = `Dislikes`+1 WHERE `id` = '$vid' LIMIT 1");
	}
}
else
{
	mysql_query("INSERT INTO `likes` (`ID`, `VideoID`, `Username`, `Liked`, `Time`) VALUES ('', '$vid', '$user', '$like', '".time()."')");
	if ($like)
		mysql_query("UPDATE `videos` SET `Likes` = `Likes`+1 WHERE `id` = '$vid' LIMIT 1");
	else
		mysql_query("UPDATE `videos` SET `Dislikes` = `Dislikes`+1 WHERE `id` = '$vid' LIMIT 1");
}

?>