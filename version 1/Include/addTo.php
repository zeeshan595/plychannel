<?php
if (!isset($_COOKIE['Username']))
	die();

require_once('/var/www/Include/connect.php');
require_once('/var/www/Include/encrypt.php');

$user = decrypt(urldecode($_COOKIE['Username']));

$playlistID = strip_tags(stripcslashes(trim($_POST['playlist'])));
$videoID = strip_tags(stripcslashes(trim($_POST['videoID'])));

if (isset($_POST['newPlaylist']))
{
	$privacy = stripcslashes(strip_tags(trim($_POST['newPlaylist'])));
	$playlistName = $playlistID;
    mysql_query("INSERT INTO `playlists` (`id` , `name` , `discription` , `owner`, `privacy`) VALUES
		('' , '".$playlistName."' , 'No description available.' , '".$user."', '$privacy')");
    $playlistID = mysql_insert_id();
    $videoCount = 0;
}
else
{
	$playlistName = mysql_query("SELECT * FROM `playlists` WHERE `id` = '$playlistID'");
	$playlistName = mysql_fetch_array($playlistName);
	$playlistName = $playlistName['name'];
}

$videoCount = mysql_query("SELECT * FROM `playlist_videos` WHERE `playlistID` = '".$playlistID."'");
$videoCount = mysql_num_rows($videoCount);

$videoCount = $videoCount + 1;

mysql_query("INSERT INTO `playlist_videos` (`id` , `videoNumber` , `playlistID` , `videoID`) VALUES
			('' , '".$videoCount."' , '".$playlistID."' , '".$videoID."')");

if (isset($_POST['newPlaylist']))
{
?>
	<div class="playlist" id="playlistItem" plID="<?php echo $playlistID; ?>" inPlaylist="<?php if ($videoInPl) echo '1'; else echo '0'; ?>">
		<img src="Images/tick.png" alt="tick" style="display: <?php if ($videoInPl) echo 'inline-block'; else echo 'none'; ?>;" />
		<span style="width: 530px;display: inline-block;font-size: 14px;font-weight: bold;"><?php echo $playlistName; ?>
			<span style="margin-left: 15px;font-weight: normal;">(1)</span>
		</span>
		<span style="font-size: 14px;text-align: right;display: inline-block;width: 85px;"><?php if ($privacy == 'a') echo "Public"; else echo "Private"; ?></span>
	</div>
<?php
}
?>