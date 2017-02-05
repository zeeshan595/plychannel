<?php

if (!isset($_COOKIE['Username']))
	die();

require_once('Include/connect.php');
require_once('Include/encrypt.php');

$user = decrypt(urldecode($_COOKIE['Username']));
$like = stripcslashes(strip_tags(trim($_POST['like'])));
$id = stripcslashes(strip_tags(trim($_POST['id'])));

$totalLikes = 0;
$totalDislikes = 0;

$Getter = mysql_query("SELECT * FROM `comments` WHERE `id` = '".$id."' LIMIT 0 , 1");
$Getter = mysql_fetch_array($Getter);
$totalLikes = $Getter['likes'];
$totalDislikes = $Getter['dislikes'];



$check = mysql_query("SELECT * FROM `commentlikes` WHERE `commentID` = '".$id."' AND `username` = '".$user."' LIMIT 0 , 1");
if (mysql_num_rows($check) == 0)
{
	mysql_query("INSERT INTO `commentlikes` (`ID` , `commentID` , `username` , `liked`) VALUES
		('' , '".$id."' , '".$user."' , '".$like."')");
	if ($like)
	{
		$totalLikes = $totalLikes + 1;
	}
	else
	{
		$totalDislikes = $totalDislikes + 1;
	}
}
else
{
	$check = mysql_fetch_array($check);
	$prevLiked = $check['liked'];
	if($prevLiked != $like)
	{
		if ($like)
		{
			$totalLikes = $totalLikes + 1;
			$totalDislikes = $totalDislikes - 1;
		}
		else
		{
			$totalLikes = $totalLikes - 1;
			$totalDislikes = $totalDislikes + 1;
		}

		mysql_query("UPDATE `commentlikes` SET `liked` = '".$like."' WHERE `username` = '".$user."' AND `commentID` = '".$id."'");
	}
}

mysql_query("UPDATE `comments` SET `likes` = '".$totalLikes."', `dislikes` = '".$totalDislikes."' WHERE `id` = '".$id."'");

?>