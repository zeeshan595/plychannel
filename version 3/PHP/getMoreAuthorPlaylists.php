<?php
	if (!isset($_POST['start']) || !isset($_POST['author']))
		die("No Args");
	
	require_once('connect.php');
	$start = strip_tags(trim($_POST['start']));
	$author = strip_tags(trim($_POST['author']));

	$pls = mysql_query("SELECT `id`, `name`, `description` FROM `playlists` WHERE `owner` = '$author' AND `privacy` = 'a' LIMIT $start, 50");
	if (mysql_fetch_array($pls) > 0)
	{
		while($row = mysql_fetch_array($pls))
		{
			$plid = $row['id'];
			$plName = $row['name'];
			$pldescription = $row['description'];
			$plVideos = mysql_query("SELECT `videoID`, COUNT(`id`) AS `count` FROM `playlist_videos` WHERE `playlistID` = '$plid' ORDER BY rand() LIMIT 1");
			$plVideos = mysql_fetch_array($plVideos);
			$image = urlencode(encrypt($plVideos[0]));
			$total = $plVideos[1];
?>
		<a href="http://plychannel.com/playlist?p=<?php echo urlencode(encrypt($plid)); ?>">
		    <div class="videoThumb" style="width: 100%;">
				<img src="http://plychannel.com/Images/video?i=<?php echo $image; ?>" alt="Thumbnail" />
				<div class="videoTitle" style="word-wrap:break-word;"><?php if (strlen($plName) < 50) echo $plName; else echo substr($plName, 0, 47) . "..."; ?></div>
				<span><?php echo $total; ?> videos</span>
		    </div>
		</a>
<?php
		}
	}
?>