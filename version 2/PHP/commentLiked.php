<?php

if (!isset($_COOKIE['Username']))
	die();

require_once("connect.php");

$user = decrypt(urldecode($_COOKIE['Username']));
$like = addslashes(strip_tags(trim($_POST['like'])));
$cid = addslashes(strip_tags(trim($_POST['id'])));

$exists = mysql_query("SELECT * FROM `commentlikes` WHERE `commentID` = '$cid' AND `username` = '$user' LIMIT 1");
if (!$exists)
	die("Couldn't check if already liked the comment");

if (mysql_num_rows($exists) > 0)
{
	$check = mysql_fetch_array($exists);
	$id = $check['ID'];
	$liked = $check['liked'];
	if ($liked == $like)
	{
		mysql_query("DELETE FROM `commentlikes` WHERE `ID` = '$id' LIMIT 1");
		if ($like)
			mysql_query("UPDATE `comments` SET `likes` = `likes`-1 WHERE `id` = '$cid' LIMIT 1");
		else
			mysql_query("UPDATE `comments` SET `dislikes` = `dislikes`-1 WHERE `id` = '$cid' LIMIT 1");
	}
	else
	{
		mysql_query("UPDATE `commentlikes` SET `liked` = '$like' WHERE `ID` = '$id' LIMIT 1");
		if ($like)
			mysql_query("UPDATE `comments` SET `likes` = `likes`+1, `dislikes` = `dislikes`-1 WHERE `id` = '$cid' LIMIT 1");
		else
			mysql_query("UPDATE `comments` SET `likes` = `likes`-1, `dislikes` = `dislikes`+1 WHERE `id` = '$cid' LIMIT 1");
	}
}
else
{
	mysql_query("INSERT INTO `commentlikes` (`ID`, `commentID`, `username`, `liked`) VALUES ('', '$cid', '$user', '$like')");
	if ($like)
		mysql_query("UPDATE `comments` SET `likes` = `likes`+1 WHERE `id` = '$cid' LIMIT 1");
	else
		mysql_query("UPDATE `comments` SET `dislikes` = `dislikes`+1 WHERE `id` = '$cid' LIMIT 1");
}

?>