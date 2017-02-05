<?php
require_once("PHP/connect.php");
if (isset($_GET['u']))
{
	$channelUser = strip_tags(trim($_GET['u']));
	echo "<input type='hidden' value='".$channelUser."' id='author' />";
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
				<a href="http://plychannel.com/channel/<?php echo $channelUser; ?>"><div>Home</div></a>
				<a href="http://plychannel.com/channelVideos?u=<?php echo $channelUser; ?>"><div>Videos</div></a>
				<a href="http://plychannel.com/channelPlaylists?u=<?php echo $channelUser; ?>"><div style="border-bottom: #ff0000 3px solid; opacity: 1;">Playlists</div></a>
				<a href="http://plychannel.com/channelDiscussions?u=<?php echo $channelUser; ?>"><div>Discussions</div></a>
				<a href="http://plychannel.com/channelAbout?u=<?php echo $channelUser; ?>"><div>About</div></a>
			</div>
		</div>
		
		<div class="content">
			<div class="section">
<?php
				$totalPls = mysql_query("SELECT COUNT(`id`) FROM `playlists` WHERE `owner` = '$channelUser' AND `privacy` = 'a' LIMIT 1");
				$totalPls = mysql_fetch_array($totalPls);
				$totalPls = $totalPls[0];
				echo "<input type='hidden' value='$totalPls' id='totalPls' />";
				echo "<h3>All playlists by $channelUser ($totalPls)</h3>";
				$pls = mysql_query("SELECT `id`, `name`, `description` FROM `playlists` WHERE `owner` = '$channelUser' AND `privacy` = 'a' LIMIT 50");
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
?>
			</div>
			<div style="margin-left: auto;margin-right: auto;width: 62px;display: block;" class="greyButton" id="loader">Load More</div>
		</div>

		<?php require_once("PHP/footer.php"); ?>
		<!-- JS -->
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script type="text/javascript" src="../Javascript/toolbar.js"></script>
		<script type="text/javascript">
		var amount = 50;
		if ($("#totalPls").val() <= amount)
			$("#loader").css("display", "none");
		
		$("#loader").click(function(){
			$.ajax({
				url: "PHP/getMoreAuthorPlaylists.php",
				type: 'post',
				data: { start: amount, author: $("#author").val() },
				success: function(data){
					console.log(data);
					amount += 50;
					$(".section").append(data);
					if ($("#totalPls").val() <= amount)
						$("#loader").css("display", "none");
				}
			});
		});
		</script>
	</body>
</html>