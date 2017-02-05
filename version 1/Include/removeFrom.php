<?php

if (!isset($_COOKIE['Username']))
	die();

require_once('/var/www/Include/connect.php');
require_once('/var/www/Include/encrypt.php');

$user = decrypt(urldecode($_COOKIE['Username']));
$playlistID = strip_tags(stripcslashes(trim($_POST['playlist'])));
$videoID = strip_tags(stripcslashes(trim($_POST['videoID'])));

$playlistName = mysql_query("SELECT * FROM `playlists` WHERE `id` = '$playlistID' AND `owner` = '$user' LIMIT 1");
if (mysql_num_rows($playlistName) > 0)
{
	mysql_query("DELETE FROM `playlist_videos` WHERE `playlistID` = '$playlistID' AND `videoID` = '$videoID' LIMIT 1");

	$playlistName = mysql_fetch_array($playlistName);
	$playlistName = $playlistName['name'];

	echo "<div class='alert alert-success'>Removed from " . $playlistName . "</div>";
}
else
{
	echo "<div class='alert alert-danger'>You don't rights to that playlist</div>";
}
?>