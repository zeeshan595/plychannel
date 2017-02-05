<?php
require_once("Include/header.php"); 
require_once("Include/connect.php");
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if (preg_match("/http\:\/\/[a-zA-Z\.\/]+\/channel\/([a-zA-Z0-9]+)/", $actual_link, $matches))
{
	$user = $matches[1];
	$query = mysql_query("SELECT * FROM `users` WHERE `Username` = '".mysql_real_escape_string($user)."' LIMIT 1");
	if (mysql_num_rows($query) != 0)
	{
		$channel = mysql_fetch_array($query);
	}
	else
	{
		header("Location: http://plychannel.com/404");
		die();
	}
}
else
{
	header("Location: http://plychannel.com/404?");
	die();
}
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
$user = $matches[1];
?>

<style>
.featuredBig{
	padding: 50px 0 0 0;
}
.featuredBig div {
	font-weight: bold;
	padding: 5px;
	font-size: 15px;
	color: #FE563B;
}

.featuredBig span {
	display: block;
	font-weight: bold;
	padding: 1px 0 1px 10px;
	color: #919191;
	font-size: 12px;
}

.Banner{
	background-image: url(<?php echo $channel['Background']; ?>);
	background-repeat: repeat;
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

.plychannelVideoID{

}
</style>

<script>
$(document).ready(function(){
	$("#EnableSearch").click(function(){
		$("#EnableSearch").slideUp(300);
		$("#ChannelSearchForm").slideDown(700);
	});
});

	$(window).resize(function() {
		resizeChannelVideo();
	});
	$(document).ready(function (){
		resizeChannelVideo();
	});

	function resizeChannelVideo()
	{
		if ($(window ).width() > 1184)
		{
			$("#plychannelVideoID").css('width', 850 + 'px');
			$("#plychannelVideoID").css('height', 630 + 'px');

			$("#FeaturedSDes").css("display" , "none");
			$("#FeaturedMDes").css("display" , "none");
			$("#FeaturedLDes").css("display" , "block");
		}
		else if ($(window).width() > 976)
		{
			$("#plychannelVideoID").css('width', 649 + 'px');
			$("#plychannelVideoID").css('height', 480 + 'px');

			$("#FeaturedSDes").css("display" , "none");
			$("#FeaturedMDes").css("display" , "block");
			$("#FeaturedLDes").css("display" , "none");
		}
		else if ($(window).width() > 765)
		{
			$("#plychannelVideoID").css('width', 415 + 'px');
			$("#plychannelVideoID").css('height', 307 + 'px');

			$("#FeaturedSDes").css("display" , "block");
			$("#FeaturedMDes").css("display" , "none");
			$("#FeaturedLDes").css("display" , "none");
		}
		else
		{
			$("#plychannelVideoID").css('width', 435 + 'px');
			$("#plychannelVideoID").css('height', 322 + 'px');

			$("#FeaturedSDes").css("display" , "block");
			$("#FeaturedMDes").css("display" , "none");
			$("#FeaturedLDes").css("display" , "none");
		}
	}
</script>

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
  <li class="active"><a href="http://plychannel.com/channel/<?php echo $user; ?>"><img src="http://plychannel.com/Images/home.png" width="20px" /></a></li>
  <li><a href="http://plychannel.com/channelVideos?u=<?php echo $user; ?>"><img src="http://plychannel.com/Images/videos.png" width="20px" /></a></li>
  <li><a href="http://plychannel.com/channelPlaylists?u=<?php echo $user; ?>"><img src="http://plychannel.com/Images/playlists.png" width="20px" /></a></li>
  <li><a href="http://plychannel.com/channelInfo?u=<?php echo $user; ?>"><img src="http://plychannel.com/Images/info_small.png" width="20px" /></a></li>
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

<?php
require_once("Include/encrypt.php");
require_once("Include/extraFunctions.php");

if ($channel['Channelvideo'] == '-1')
	$featuredVideo = mysql_query("SELECT * FROM `videos` WHERE `Uploaded` = '1' AND `Privacy` = 'a' AND `Author` = '$user' ORDER BY `Time` DESC LIMIT 1");
else
	$featuredVideo = mysql_query("SELECT * FROM `videos` WHERE `ID` = '".$channel['Channelvideo']."' LIMIT 1");

if (mysql_num_rows($featuredVideo) == 0)
{
?>
<div class="alert alert-danger">
<strong>Oh snap!</strong> This channel hasn't uploaded any video.
</div>
<?php
	require_once("Include/footer.php");
	die();
}

$featuredVideo = mysql_fetch_array($featuredVideo);
$id = urlencode(encrypt($featuredVideo['ID']));
?>
<table width="100%">
	<tr>
		<td style="border: 1px #e0e0e0 solid;">
			<iframe id="plychannelVideoID" scrolling="no" src="http://plychannel.com/video.php?v=<?php echo urlencode(encrypt($featuredVideo['ID'])); ?>&t=0" allowFullScreen="true" webkitallowfullscreen="true" mozallowfullscreen="true" frameborder="0px"></iframe>
		</td><td valign="top" style="border: 1px #e0e0e0 solid;">
			<a href="http://plychannel.com/watch?v=<?php echo urlencode(encrypt($featuredVideo['ID'])); ?>" style="text-decoration: none;">
				<div class="featuredBig">
					<div><?php echo $featuredVideo['Title']; ?></div>
					<span><?php echo timeToString($featuredVideo['Time']); ?> ago</span>
					<br />
					<span>
<?php

$description = $featuredVideo['Discription'];
preg_match_all("\<br \/\>", $description, $matches);
$desSize = (sizeof($matches) * 50) + strlen(strip_tags($description));
if ($desSize > 300)
	$smallDis = substr($description, 0, 300) . "...";
else
	$smallDis = $description;

if ($desSize > 600)
	$mediumDis = substr($description, 0, 600) . "...";
else
	$mediumDis = $description;

if ($desSize > 800)
	$largeDis = substr($description, 0, 800) . "...";
else
	$largeDis = $description;

echo "<span id='FeaturedSDes'>" . $smallDis . "</span>";
echo "<span id='FeaturedMDes'>" . $mediumDis . "</span>";
echo "<span id='FeaturedLDes'>" . $largeDis . "</span>";
?>
					</span>
				</div>
			</a>
		</td>
	</tr>
</table>
<div style="border: 1px #e0e0e0 solid;">
<?php require_once("Sections/channelPopular.php"); ?>
</div><div style="border: 1px #e0e0e0 solid;">
<?php require_once("Sections/channelLatest.php"); ?>
</div><div style="border: 1px #e0e0e0 solid;">
<?php require_once("Sections/channelPlaylist.php"); ?>
</div>

<?php require_once("Include/footer.php"); ?>