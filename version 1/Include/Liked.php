<?php

if (!isset($_COOKIE['Username']))
	die();

require_once('/var/www/Include/connect.php');
require_once('/var/www/Include/encrypt.php');

$like = stripcslashes(strip_tags(trim($_POST['like'])));
$id = stripcslashes(strip_tags(trim($_POST['id'])));

echo $id . "||" . $like;

$totalLikes = 0;
$totalDislikes = 0;

$Getter = mysql_query("SELECT * FROM `videos` WHERE `ID` = '".$id."' LIMIT 0 , 1");
$Getter = mysql_fetch_array($Getter);
$totalLikes = $Getter['Likes'];
$totalDislikes = $Getter['Dislikes'];



$check = mysql_query("SELECT * FROM `likes` WHERE `VideoID` = '".$id."' AND `Username` = '".decrypt(urldecode($_COOKIE['Username']))."' LIMIT 1");
if (mysql_num_rows($check) == 0)
{
	mysql_query("INSERT INTO `likes` (`ID` , `VideoID` , `Username` , `Liked` , `Time`) VALUES
		('' , '".$id."' , '".decrypt(urldecode($_COOKIE['Username']))."' , '".$like."' , '".time()."')");
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
	$prevLiked = $check['Liked'];
	if ($like == '2')
	{
		mysql_query("DELETE FROM `likes` WHERE `Username` = '".decrypt(urldecode($_COOKIE['Username']))."' AND `VideoID` = '".$id."' LIMIT 1");
		if ($prevLiked == '1')
		{
			mysql_query("UPDATE `videos` SET `Likes` = (`Likes` - 1) WHERE `ID` = '".$id."'");
		}
		else
		{
			mysql_query("UPDATE `videos` SET `Dislikes` = (`Dislikes` - 1) WHERE `ID` = '".$id."'");
		}
		die();
	}
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

		mysql_query("UPDATE `likes` SET `Liked` = '".$like."' WHERE `Username` = '".decrypt(urldecode($_COOKIE['Username']))."' AND `VideoID` = '".$id."'");
	}
}

mysql_query("UPDATE `videos` SET `Likes` = '".$totalLikes."', `Dislikes` = '".$totalDislikes."' WHERE `ID` = '".$id."'");
?>
