<?php
require_once("Include/header.php"); 
require_once("Include/connect.php");
$matches = stripcslashes(strip_tags(trim($_GET['u'])));
$check = mysql_query("SELECT * FROM `users` WHERE `Username` = '".mysql_real_escape_string($matches)."' LIMIT 1");
if (mysql_num_rows($check) == 0)
{
	header("Location: http://plychannel.com/404");
	die();
}
$channel = mysql_fetch_array($check);
?>

<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="description" content="<?php echo $channel['About']; ?>" />
<meta name="keywords" content="video, sharing, family, plychannel, ply channel, channel" />
<meta name="author" content="Zeeshan Abid" />
<link rel="shortcut icon" href="Images/favicon.ico" />

<title><?php echo $channel['ChannelName']; ?></title>

<!-- og Tags -->

<meta property="og:title" content="Plychannel.com"/>
<meta property="og:type" content="html"/>
<meta property="og:image" content="http://plychannel.com/Images/author?u=<?php echo $user; ?>"/>
<meta property="og:image:type" content="image/png">
<meta property="og:image:width" content="300">
<meta property="og:image:height" content="33">

<meta property="og:url" content="http://plychannel.com/"/>
<meta property="og:description" content="<?php echo $channel['About']; ?>"/>

<?php
require_once("Include/navigation.php");
$user = $matches;
?>

<style>
.Banner{
	background: url(<?php echo $channel['Background']; ?>);
	height: 200px;
	padding: 25px;
}

.Banner .BannerImage{
	width: 75px;
	height: 75px;
}

.Banner .Info{
	position: relative;
	left: -50px;
	top: 110px;
}
.Banner .Info span{
	background: rgba(254,86,59,0.3);
	color: #fff;
	font-weight: bold;
	padding: 5px 5px 20px 5px;
}
.Banner .Info a{
	color: #fff;
}
.Banner .Info img{
	width:30px;
	height:32px;
}
</style>

<div class="Banner">
	<img class="BannerImage" src="http://plychannel.com/Images/author?u=<?php echo $user; ?>" />
	<span class="Info">
		<span>
<?php
		if ($channel['website'] != "")
			echo "<a href='".stripslashes(strip_tags(trim($channel['website'])))."' title='Vist this channel\'s website.'>".$channel['ChannelName']."</a>";
		else
			echo $channel['ChannelName'];
?>
		</span>
<?php
		if ($channel['twitter'] != "")
			echo "<span id='twitterLink'><a href='".stripslashes(strip_tags(trim($channel['twitter'])))."' title='Vist this channel\'s twitter page.'><img src='http://plychannel.com/Images/twitter.png' /></a></span>";

		if ($channel['facebook'] != "")
			echo "<span id='facebookLink'><a href='".stripslashes(strip_tags(trim($channel['facebook'])))."' title='Vist this channel\'s facebook page.'><img src='http://plychannel.com/Images/facebook.png' /></a></span>";

		if ($channel['googleplus'] != "")
			echo "<span id='twitterLink'><a href='".stripslashes(strip_tags(trim($channel['googleplus'])))."' title='Vist this channel\'s googleplus page.'><img src='http://plychannel.com/Images/googleplus.png' /></a></span>";
?>
	</span>
</div>

<table width="100%"><tr>
<td>
<ul class="nav nav-tabs">
  <li><a href="http://plychannel.com/channel/<?php echo $user; ?>"><img src="http://plychannel.com/Images/home.png" width="20px" /></a></li>
  <li><a href="http://plychannel.com/channelVideos?u=<?php echo $user; ?>"><img src="http://plychannel.com/Images/videos.png" width="20px" /></a></li>
  <li><a href="http://plychannel.com/channelPlaylists?u=<?php echo $user; ?>"><img src="http://plychannel.com/Images/playlists.png" width="20px" /></a></li>
  <li class="active"><a href="http://plychannel.com/channelInfo?u=<?php echo $user; ?>"><img src="http://plychannel.com/Images/info_small.png" width="20px" /></a></li>
  <li>
  	<form id="ChannelSearchForm" action="http://plychannel.com/channelVideos" method="GET" style="display:none;padding:10px;">
  		<input type="text" name="s" placeholder="Search Channel..." />
  		<input type="hidden" name="u" value="<?php echo $user; ?>" />
  		<button type="submit" /><img src="http://plychannel.com/Images/search.png" width="12px" /></button>
	</form>
	<div style="padding:10px;">
		<img id="EnableSearch" src="http://plychannel.com/Images/search.png" width="12px" />
  	</div>
  </li>
</ul>
</td><td align="right">
<?php
	if (isset($_COOKIE['Username']))
	{
		$loggedInUser = stripcslashes(strip_tags(trim(decrypt(urldecode($_COOKIE['Username'])))));
		$checkSubscription = mysql_query("SELECT * FROM `subscriptions` WHERE `Username` = '$loggedInUser' AND `Subscribed` = '$user' LIMIT 1");
		if ($loggedInUser != $user)
		{
			if (mysql_num_rows($checkSubscription) == 0)
			{
?>
				<a style="background-color: #fff;border: 0;" href="http://plychannel.com/subscribe?u=<?php echo $user; ?>&feature=http://plychannel.com/watch?v=<?php echo urlencode($encid . $p); ?>"><button type="button" id="SubButton" author="<?php echo $user; ?>" class="btn btn-sm btn-primary">Subscribe</button></a>
<?php
			}
			else
			{
?>
				<a style="background-color: #fff;border: 0;" href="http://plychannel.com/subscribe?u=<?php echo $user; ?>&feature=http://plychannel.com/watch?v=<?php echo urlencode($encid . $p); ?>"><button type="button" id="UnsubButton" author="<?php echo $user; ?>" class="btn btn-sm btn-default">Unsubscribe</button></a>
<?php
			}
		}
	}
	else
	{
?>
		<a style="background-color: #fff;border: 0;" href="http://plychannel.com/login?feature=http://plychannel.com/watch?v=<?php echo urlencode($encid . $p); ?>" id="subscribeButton"><button type="button" class="btn btn-sm btn-primary">Subscribe</button></a>
<?php
	}
?>
</td></tr>
</table>

<p style="font-size:12px;font-weight:bold;color: #999999;padding:25px;">
	<span style="font-size:15px;">Link: <a href="http://plychannel.com/channel/<?php echo $user ?>">http://plychannel.com/channel/<?php echo $user ?></a></span><br /><br />
	<?php echo $channel['About'] ?>
</p>
<script>
$(document).ready(function(){
	$("#EnableSearch").click(function(){
		$("#EnableSearch").slideUp(300);
		$("#ChannelSearchForm").slideDown(700);
	});
});
</script>
<?php require_once("Include/footer.php"); ?>