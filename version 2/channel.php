<?php
require_once("PHP/connect.php");
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if (preg_match("/http\:\/\/[a-zA-Z\.\/]+\/channel\/([a-zA-Z0-9]+)/", $actual_link, $matches))
{
	$channelUser = strip_tags(trim($matches[1]));
	$query = mysql_query("SELECT * FROM `users` WHERE `Username` = '".mysql_real_escape_string($channelUser)."' LIMIT 1");
	if (mysql_num_rows($query) != 0)
	{
		$channel = mysql_fetch_array($query);
		$subscribs = mysql_query("SELECT COUNT(`ID`) FROM `subscriptions` WHERE `Subscribed` = '$channelUser'");
		$subscribs = mysql_fetch_array($subscribs);
		$subscribs = $subscribs[0];
		$views = mysql_query("SELECT `Views` FROM `videos` WHERE `Author` = '$channelUser'");
		$counter = 0;
		while ($row = mysql_fetch_array($views))
		{
			$counter += $row[0];
		}
		$views = $counter;
	}
	else
	{
		header("Location: http://plychannel.com/404");
		die();
	}
}
else
{
	header("Location: http://plychannel.com/404");
	die();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Traditional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-traditional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="../Styles/toolbar.css" type="text/css" rel="stylesheet" />
		<link href="../Styles/page.css" type="text/css" rel="stylesheet" />
		<title><?php echo $channelUser; ?>'s Channel - Plychannel</title>
		<style type="text/css">
			.topBar{
				box-shadow: 2px 2px 10px rgba(0,0,0,.1);
				background: #fff;
				padding: 10px 20px;
				font-size: 13px;
				font-weight: bold;
				color: #000;
				width: 930px;
				margin-left: auto;
				margin-right: auto;
				border: #e2e2e2 1px solid;
			}
			.topBar div{
				display: inline-block;
				margin-right: 30px;
				opacity: 0.7;
    			filter: alpha(opacity=70); /* For IE8 and earlier */
			}
			.topBar div:hover{
				opacity: 1;
    			filter: alpha(opacity=100); /* For IE8 and earlier */
    			cursor: pointer;
    			cursor: hand;
			}
			.background{
				box-shadow: 2px 2px 10px rgba(0,0,0,.1);
				width: 950px;
				height: 176px;
				margin-left: auto;
				margin-right: auto;
				padding: 5px 10px;
			}
			.authorImage{
				width: 100px;
				height: 100px;
				margin-top: -5px;
			}
			.bottomBar{
				box-shadow: 2px 2px 10px rgba(0,0,0,.1);
				background: #fff;
				padding: 5px 10px;
				width: 950px;
				margin-left: auto;
				margin-right: auto;
				margin-bottom: 15px;
			}
			.navBar{

			}
			.navBar div{
				color: #000;
				display: inline-block;
				position: relative;
				bottom: -5px;
				margin-right: 20px;
				font-size: 13px;
				font-weight: bold;
				opacity: 0.7;
				filter: alpha(opacity=70); /* For IE8 and earlier */
			}
			.navBar div:hover{
				border-bottom: #ff0000 3px solid;
				opacity: 1;
				filter: alpha(opacity=100); /* For IE8 and earlier */
				cursor: pointer;
				cursor: hand;
			}
			.socialNetwork{
				text-align: right;
				vertical-align: bottom;
				position: relative;
				bottom: -60px;
			}
			.socialNetwork div{
				display: inline-block;
				padding: 3px;
				background: rgba(0,0,0,0.3);
				color: #fff;
				font-size: 12px;
				font-weight: bold;
			}
			.socialNetwork div img{
				width: 15px;
			}
		</style>
	</head>

	<body>
		
		<?php require_once("PHP/toolbar.php"); ?>
		<?php require_once("PHP/connect.php"); ?>

		<div class="topBar">
			<div><?php echo number_format($subscribs); ?> Subscribers</div>
			<div><?php echo number_format($views); ?> Views</div>
		</div>
		<div class="background" style="background: url(<?php echo $channel['Background']; ?>); background-size: 100%;">
			<div class="authorImage" style="background: url('../Images/author?u=<?php echo $channelUser; ?>'); background-position: center; background-size: auto 100%;"></div>
			<div class="socialNetwork">
<?php
				if ($channel['twitter'] != "")
				{
?>
					<a href="<?php echo $channel['twitter']; ?>"><div><img src="http://plychannel.com/Images/socialNetworks/twitter.jpg" alt="twitter" /></div></a>
<?php
				}
				if ($channel['facebook'] != "")
				{
?>
					<a href="<?php echo $channel['facebook']; ?>"><div><img src="http://plychannel.com/Images/socialNetworks/facebook.jpg" alt="facebook" /></div></a>
<?php
				}
				if ($channel['googleplus'] != "")
				{
?>
					<a href="<?php echo $channel['googleplus']; ?>"><div><img src="http://plychannel.com/Images/socialNetworks/google.jpg" alt="google plus" /></div></a>
<?php
				}
				if ($channel['website'] != "")
				{
?>
					<a href="<?php echo $channel['website']; ?>"><div><?php echo $channel['website']; ?></div></div></a>
<?php
				}
?>
			</div>
		</div>
		<div class="bottomBar">
			<h3><?php echo $channel['ChannelName']; ?></h3>
			<div class="navBar">
				<a href="http://plychannel.com/channel/<?php echo $channelUser; ?>"><div style="border-bottom: #ff0000 3px solid; opacity: 1;">Home</div></a>
				<a href="http://plychannel.com/channelVideos?u=<?php echo $channelUser; ?>"><div>Videos</div></a>
				<a href="http://plychannel.com/channelPlaylists?u=<?php echo $channelUser; ?>"><div>Playlists</div></a>
				<a href="http://plychannel.com/channelDiscussions?u=<?php echo $channelUser; ?>"><div>Discussions</div></a>
				<a href="http://plychannel.com/channelAbout?u=<?php echo $channelUser; ?>"><div>About</div></a>
			</div>
		</div>
		
		<div class="content">
<?php
			$featuredVideo = $channel['Channelvideo'];
			$isNewest = 0;
			if ($featuredVideo == "-1")
			{
				$isNewest = 1;
				$featuredVideo = mysql_query("SELECT `ID` FROM `videos` WHERE `Author` = '$channelUser' AND `Uploaded` = '1' AND `Privacy` = 'a' ORDER BY `Time` DESC LIMIT 1");
				if (mysql_num_rows($featuredVideo) > 0)
				{
					$featuredVideo = mysql_fetch_array($featuredVideo);
					$featuredVideo = $featuredVideo[0];
					$details = mysql_query("SELECT `Title`, `Description`, `Views`, `Time` FROM `videos` WHERE `Author` = '$channelUser' AND `Uploaded` = '1' AND `Privacy` = 'a' ORDER BY `Time` DESC LIMIT 1");
					$details = mysql_fetch_array($details);

					$title = $details['Title'];
					$description = $details['Description'];
					$views = $details['Views'];
					$time = $details['Time'];

					if (strlen($description) > 200)
						$description = substr($description, 0, 197) . "...";
				}
				else
					$NoVideo = true;
			}
			$featuredVideo = urlencode(encrypt($featuredVideo));
			if (!isset($NoVideo))
			{
?>
				<iframe style="width: 600px; height: 413px; display: inline-block;" scrolling="no" src="http://plychannel.com/flowplayer/video.php?v=<?php echo $featuredVideo; ?>&amp;t=0" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true" frameborder="0px"></iframe>
				<div style="display: inline-block;width: 330px;margin-top: 35px; vertical-align: top;">
					<a href="http://plychannel.com/watch?v=<?php echo $featuredVideo; ?>">
						<div style="font-size: 15px;font-weight: bold; color: #000;"><?php echo $title; ?></div>
					</a>
					<div style="display: inline-block;font-size: 13px;font-weight: bold;color: #666;"><?php echo $views; ?> views</div>
					<div style="display: inline-block;font-size: 13px;font-weight: bold;color: #666; margin-left: 50px"><?php echo timeToString($time); ?> ago</div>
					<div style="font-size: 15px;"><?php echo $description; ?></div>
				</div>
				<div class="seperator"></div>
				<div class="section">
				    <h3>New Uploads</h3>
<?php
					$query = mysql_query("SELECT `Title`, `Description`, `ID`, `Views`, `Time`, `Length` FROM `videos` WHERE `Author` = '$channelUser' AND `Uploaded` = '1' AND `Privacy` = 'a' ORDER BY `Time` DESC LIMIT $isNewest,5");
					echo mysql_error();
					while($row = mysql_fetch_array($query))
					{
?>
					<a href="http://plychannel.com/watch?v=<?php echo urlencode(encrypt($row['ID'])); ?>">
					    <div class="videoThumb">
							<img src="http://plychannel.com/Images/video?i=<?php echo urlencode(encrypt($row['ID'])); ?>" alt="Thumbnail" />
							<div style="height:0; width: 0;">
								<div class="videoTime"><?php echo $row['Length']; ?></div>
							</div>
							<div class="videoTitle" style="word-wrap:break-word;"><?php if (strlen($row['Title']) < 38) echo $row['Title']; else echo substr($row['Title'], 0, 35) . "..."; ?></div>
							<span>By <?php echo $channelUser; ?></span><span style="text-align: right;"><?php echo number_format($row['Views']); ?> views</span>
					    	<div class="videoDate"><?php echo timeToString($row['Time']); ?></div>
					    </div>
					</a>
<?php
					}
?>
				</div>
				<div class="seperator"></div>
				<div class="section">
				    <h3>Popular videos by '<?php echo $channelUser; ?>'</h3>
<?php
					$query = mysql_query("SELECT `Title`, `Description`, `ID`, `Views`, `Time`, `Length` FROM `videos` WHERE `Author` = '$channelUser' AND `Uploaded` = '1' AND `Privacy` = 'a' ORDER BY `Views` DESC LIMIT 5");
					echo mysql_error();
					while($row = mysql_fetch_array($query))
					{
?>
					<a href="http://plychannel.com/watch?v=<?php echo urlencode(encrypt($row['ID'])); ?>">
					    <div class="videoThumb">
							<img src="http://plychannel.com/Images/video?i=<?php echo urlencode(encrypt($row['ID'])); ?>" alt="Thumbnail" />
							<div style="height:0; width: 0;">
								<div class="videoTime"><?php echo $row['Length']; ?></div>
							</div>
							<div class="videoTitle" style="word-wrap:break-word;"><?php if (strlen($row['Title']) < 38) echo $row['Title']; else echo substr($row['Title'], 0, 35) . "..."; ?></div>
							<span>By <?php echo $channelUser; ?></span><span style="text-align: right;"><?php echo number_format($row['Views']); ?> views</span>
					    	<div class="videoDate"><?php echo timeToString($row['Time']); ?></div>
					    </div>
					</a>
<?php
					}
?>
				</div>
<?php
				$pls = mysql_query("SELECT `id`, `name`, `description` FROM `playlists` WHERE `owner` = '$channelUser' AND `privacy` = 'a' LIMIT 5");
				if (mysql_num_rows($pls) > 0)
				{
?>
				<div class="seperator"></div>
				<div class="section">
					<h3>Playlists</h3>
<?php
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
					    	<div style="width: 175px; height: 131px; display: inline-block;">
								<img src="http://plychannel.com/Images/video?i=<?php echo $image; ?>" alt="Thumbnail" />
							</div>
							<div style="display: inline-block; vertical-align: top;">
								<div class="videoTitle" style="word-wrap:break-word;"><?php if (strlen($plName) < 50) echo $plName; else echo substr($plName, 0, 47) . "..."; ?></div>
								<span><?php echo $total; ?> videos</span>
						    	<div class="videoDate" style="word-wrap:break-word;"><?php if (strlen($pldescription) < 200) echo $pldescription; else echo substr($pldescription, 0, 197) . "..."; ?></div>
					    	</div>
					    </div>
					</a>
<?php
					}
?>
				</div>
<?php
				}
			}
?>
		</div>

		<?php require_once("PHP/footer.php"); ?>
		<!-- JS -->
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script type="text/javascript" src="../Javascript/toolbar.js"></script>
	</body>
</html>