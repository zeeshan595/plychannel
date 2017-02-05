<?php
if (!isset($_COOKIE['Username']))
	die();

require_once("connect.php");

$user = decrypt(urldecode($_COOKIE['Username']));
$pid = addslashes(strip_tags(trim($_POST['playlist'])));
$vid = addslashes(strip_tags(trim($_POST['videoID'])));

if (isset($_POST['plName']))
{
	$plName = addslashes(strip_tags(trim($_POST['plName'])));
	$privacy = $pid;
	mysql_query("INSERT INTO `playlists` (`id`, `name`, `description`, `owner`, `privacy`) VALUES('', '$plName', 'No Description Avalible.', '$user', '$privacy')");
	$pid = mysql_insert_id();
}

$exists = mysql_query("SELECT * FROM `playlist_videos` WHERE `playlistID` = '$pid' AND `videoID` = '$vid' LIMIT 1");
if (mysql_num_rows($exists) > 0)
{
	mysql_query("DELETE FROM `playlist_videos` WHERE `playlistID` = '$pid' AND `videoID` = '$vid' LIMIT 1");
}
else
{
	$videoNumber = mysql_query("SELECT COUNT(`id`) FROM `playlist_videos` WHERE `playlistID` = '$pid'");
	$videoNumber = mysql_fetch_array($videoNumber);
	$videoNumber = $videoNumber[0];
	$videoNumber++;
	mysql_query("INSERT INTO `playlist_videos` (`id`, `videoNumber`, `playlistID`, `videoID`) VALUES('', '$videoNumber', '$pid', '$vid')");
}

if (!isset($_POST['plName']))
{
	$plName = mysql_query("SELECT `name` FROM `playlists` WHERE `id` = '$pid' LIMIT 1");
	$plName = mysql_fetch_array($plName);
	$plName = $plName[0];
}
else
{
?>
<div class="playlist" id="playlistItem" plID="<?php echo $pid; ?>" inPlaylist="1">
<img id="playlistTickMark_<?php echo $pid; ?>" src="Images/tick.png" alt="tick" style="display: inline-block;" />
<span style="width: 530px;display: inline-block;font-size: 14px;font-weight: bold;"><?php echo $plName; ?>
<span style="margin-left: 15px;font-weight: normal;">(1)</span>
</span>
<span style="font-size: 14px;text-align: right;display: inline-block;width: 85px;"><?php if ($privacy == 'a') echo "Public"; else echo "Private"; ?></span>
</div>
<?php
}
?>