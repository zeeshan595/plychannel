<?php
	require_once("Include/header.php");
	require_once("Include/connect.php");
	require_once("Include/encrypt.php");

	$encid = stripcslashes(strip_tags(trim($_GET['v'])));
	$id = decrypt(urldecode($encid));

	$query = mysql_query("SELECT * FROM `videos` WHERE `ID` = '$id' LIMIT 1");
	$video = mysql_fetch_array($query);

	$title = $video['Title'];
	$description = $video['Description'];
	$tags = $video['Tags'];
	$author = $video['Author'];
	$time = $video['Time'];
	$views = $video['Views'];
	$likes = $video['Likes'];
	$dislikes = $video['Dislikes'];

	$totalVideos = mysql_query("SELECT COUNT(`Title`) AS total FROM `videos` WHERE `Uploaded` = '1' AND `Author` = '$author' LIMIT 1");
	$totalVideos = mysql_fetch_array($totalVideos);
	$totalVideos = $totalVideos['total'];

	$totalSubscribers = mysql_query("SELECT COUNT(`ID`) AS total FROM `subscriptions` WHERE `Subscribed` = '$author' LIMIT 1");
	$totalSubscribers = mysql_fetch_array($totalSubscribers);
	$totalSubscribers = $totalSubscribers['total'];
?>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="description" content="<?php echo strip_tags(trim($description)); ?>" />
<meta name="keywords" content="<?php echo $tags; ?>" />
<meta name="author" content="<?php echo $author; ?>" />
<link rel="shortcut icon" href="Images/favicon.ico" />
<meta name="robots" content="noindex">

<!-- og Tags -->

<meta property="og:title" content="<?php echo $title; ?>"/>
<meta property="og:site_name" content="Ply Channel">
<meta property="og:type" content="video"/>
<meta property="og:image" content="http://plychannel.com/Images/video?i=<?php echo urlencode($encid); ?>&w=600&h=400"/>
<meta property="og:video" content="http://plychannel.com/watch?v=<?php echo urlencode($encid); ?>">
<meta property="og:url" content="http://plychannel.com/watch?v=<?php echo urlencode($encid); ?>"/>
<meta property="og:description" content="<?php echo strip_tags(trim($description)); ?>"/>
<meta property="og:keywords" content="<?php echo $tags; ?>"/>

<title><?php echo $title; ?> - Ply Channel</title>

<script type="text/javascript">
// Popup window code
function newPopup(w, h, url) {
	popupWindow = window.open(url,'popUpWindow','height='+h+',width='+w+',left=10,top=10,resizable=false,scrollbars=false,toolbar=false,menubar=no,location=no,directories=no,status=false');
}
</script>

<?php require_once("Include/navigation.php");?>
<input type='hidden' id='id' value='<?php echo $id; ?>' />
<input type='hidden' id='user' value='<?php echo $user; ?>' />
<link href="http://plychannel.com/css/watch.css" rel="stylesheet" />

<style>
.playlistBar{
	position: relative;
	background-color: rgb(48, 48, 48);
	color: #ffffff;
	width: calc(100% - 16px);
	padding: 10px;
	margin-left: 8px;
	margin-right: 10px;
	top: 44px;
}
.button{
	padding: 3px;
	margin: 3px;
}

#playlistLister {
	position: absolute;
	top: 10px;
	left: 95%;
	opacity: 0.4;
	filter:alpha(opacity=40); /* For IE8 and earlier */
}
#playlistLister:hover{
	opacity: 1;
	filter:alpha(opacity=100); /* For IE8 and earlier */
}
#playlistList{
	display: none;
	position: absolute;
	z-index: 50;
	background-color: rgb(48, 48, 48);
	padding: 15px;
	width: 400px;
	height: 300px;
	color: #fff;
	overflow-y: scroll;
	right: 50%;
	margin-right: -348px;
}
.playlistListVideo {
	height: 50px;
	padding: 7px;
	cursor: pointer;
	cursor: hand;
}
.playlistListVideo:hover {
	background-color: rgb(27, 27, 27);
}

.playlistListVideo img{
	width:50px;
	height:35px;
}

#playlistSelected {
	margin: 5px;
	color: #000;
	font-size: 13px;
	font-weight: bold;
	padding: 5px;
	cursor: pointer;
	cursor: hand;
}
#playlistSelected:hover {
	background: #555555;
	color: #fff;
}

#playlistChoser {
	background: #efefef;
	overflow-y: scroll;
	border: 1px #ccc solid;
	margin: 5px;
	height: 300px;
}
</style>

<table style="position: relative;top: -30px;">
<tr>
<td>
<?php
$p = "";
if (isset($_GET['p']))
{
	$playlistID = stripslashes(strip_tags(trim($_GET['p'])));
	$playlistID = decrypt(urldecode($playlistID));
	$playlistCheck = mysql_query("SELECT * FROM `playlists` WHERE `id` = '$playlistID' LIMIT 1");
	if (mysql_num_rows($playlistCheck) != 0)
	{
		$p = "&p=" . urlencode(encrypt($playlistID));
		$videoNumber = mysql_query("SELECT * FROM `playlist_videos` WHERE `playlistID` = '$playlistID' AND `videoID` = '$id' LIMIT 1");
		$videoNumber = mysql_fetch_array($videoNumber);
		$videoNumber = $videoNumber['videoNumber'];
		$getVideos = mysql_query("SELECT * FROM `playlist_videos` WHERE `playlistID` = '$playlistID' ORDER BY `videoNumber` ASC");
		$totalVideosInPlaylist = mysql_num_rows($getVideos);
		$playlistAuthor = mysql_fetch_array($playlistCheck);
		$playlistAuthor = $playlistAuthor["owner"];
		echo "<div id='playlistList'>";
		while($row = mysql_fetch_array($getVideos))
		{
			if ($row['videoNumber'] == ($videoNumber - 1))
			{
				$back = "http://plychannel.com/watch?v=" . urlencode(encrypt($row['videoID'])) . "&p=" . urlencode(encrypt($playlistID));
			}
			else if ($row['videoNumber'] == ($videoNumber + 1))
			{
				$front = "http://plychannel.com/watch?v=" . urlencode(encrypt($row['videoID'])) . "&p=" . urlencode(encrypt($playlistID));
				$frontName = mysql_query("SELECT `Title` FROM `videos` WHERE `ID` = '".$row['videoID']."' LIMIT 1");
				$frontName = mysql_fetch_array($frontName);
				$frontName = $frontName['Title'];
				if (strlen($frontName) > 40)
					$frontName = substr($frontName, 0, 37) . "...";
			}
			$playlistCreator = mysql_query("SELECT `Title` FROM `videos` WHERE `ID` = '".$row['videoID']."' LIMIT 1");
			$playlistCreator = mysql_fetch_array($playlistCreator);
			$playlistCreatorTitle = $playlistCreator['Title'];
?>
			<a href="http://plychannel.com/watch?v=<?php echo urlencode(encrypt($row['videoID'])); ?>&p=<?php echo urlencode(encrypt($playlistID)); ?>">
				<div class="playlistListVideo">
					<img class="pull-left" src="http://plychannel.com/Images/video?i=<?php echo urlencode(encrypt($row['videoID'])); ?>">
					<span>
<?php
	if (strlen($playlistCreatorTitle) > 40)
		$playlistCreatorTitle = substr($playlistCreatorTitle, 0, 37) . "...";
	echo $playlistCreatorTitle;
?></span>
				</div>
			</a>
<?php
		}
?>
</div>
			<div class="playlistBar">
<?php 
			if (isset($back))
			{
?>
			<a class="button" href="<?php echo $back; ?>"><span class="glyphicon glyphicon-backward"></span></a>
<?php
			}
			echo "<span style='font-weight:bold;'>" . $totalVideosInPlaylist . "</span>";

			if (isset($front))
			{
?>
			<a class="button" href="<?php echo $front; ?>"><span class="glyphicon glyphicon-forward"></span>
<?php
			if (strlen($frontName) < 100)
				echo $frontName; 
			else
				echo substr($frontName, 0, 100) . "...";
?>
			</a>
<?php
			}
?>
			<span style='font-size: 12px;font-weight: bold;color: #999999;margin-left: 40px;'>
				by: <a href='http://plychannel.com/channel/".$playlistAuthor."'><?php echo $playlistAuthor; ?></a>
			</span>
			<span id="playlistLister" class="glyphicon glyphicon-align-justify"></span>
		</div>
<?php
	}
}
?>
			<iframe id="plychannelVideoID" scrolling="no" src="video.php?v=<?php echo $encid; ?>&t=0<?php echo $p; ?>" allowFullScreen="true" webkitallowfullscreen="true" mozallowfullscreen="true" frameborder="0px"></iframe>
		</td>
	</tr><tr>
		<td>
			<div class="videoDetails" style="height: 140px;">
				<div><?php echo $title; ?></div>

				<?php
				$green = 150;
				$red = 50;
				if($check['Dislikes'] != 0 || $check['Likes'] != 0)
				{
					$total = $dislikes + $likes;
					$green = ($likes * 200) / $total;
					$red = ($dislikes * 200) / $total;
				}
				?>

				<table width="100%">
					<tr>
						<td>
							<div id="Author">
								<a style="text-decoration:none;" href="http://plychannel.com/channel/<?php echo $author; ?>">
									<img src="http://plychannel.com/Images/author?u=<?php echo $author; ?>" width="50px" height="50px" />
									<span id="AuthorName"><?php echo $author; ?> - <span><?php echo $totalVideos; ?> videos</span></span>
								</a>
								<div style="position: absolute;top: 60px;left: 65px;">
<?php
								if (isset($_COOKIE['Username']))
								{
									$checkSubscription = mysql_query("SELECT * FROM `subscriptions` WHERE `Username` = '$user' AND `Subscribed` = '$author' LIMIT 1");
									if ($user != $author)
									{
										if (mysql_num_rows($checkSubscription) == 0)
										{
?>
											<a href="http://plychannel.com/subscribe?u=<?php echo $author; ?>&feature=http://plychannel.com/watch?v=<?php echo urlencode($encid . $p); ?>"><button type="button" id="SubButton" author="<?php echo $author; ?>" class="btn btn-sm btn-primary">Subscribe</button></a>
<?php
										}
										else
										{
?>
											<a href="http://plychannel.com/subscribe?u=<?php echo $author; ?>&feature=http://plychannel.com/watch?v=<?php echo urlencode($encid . $p); ?>"><button type="button" id="UnsubButton" class="btn btn-sm btn-default">Unsubscribe</button></a>
<?php
										}
									}
								}
								else
								{
?>
									<a href="http://plychannel.com/login?feature=http://plychannel.com/watch?v=<?php echo urlencode($encid . $p); ?>"><button type="button" id="SubButton" author="<?php echo $author; ?>" class="btn btn-sm btn-primary">Subscribe</button></a>
<?php
								}
?>
								<span style="padding-right: 5px;left: 10px;background-color: #FAFAFA;position: relative;height: 50px;border-top: 1.2px #CCCCCC solid;border-bottom: 1.2px #CCCCCC solid;border-right: 1.2px #CCCCCC solid;">
									<img style="position: relative;left: -5px;height: 23.5px;" src="http://plychannel.com/Images/leftArrow.png" />
									<?php echo $totalSubscribers; ?>
								</span>
							</div>
							</div>
						</td><td align="right">
							<div id="Views"><?php echo number_format($views); ?></div>
							<span id="likeBar" style="background-color: #04E435;width: <?php echo $green; ?>px;display: block;position: relative;left: -<?php echo $red; ?>px;top: 2px;background-size: 100%;height: 2px;"></span>
							<span id="dislikeBar" style="background-color: red;width: <?php echo $red; ?>px;display: block;background-size: 100%, 5px;height: 2px;"></span><br />
							<span id="TotalLikes">
								<img src="http://plychannel.com/Images/likes.png" />
								<?php echo $likes; ?>
								<img src="http://plychannel.com/Images/dislikes.png" />
								<?php echo $dislikes; ?>
							</span>
						</td>
					</tr>
				</table>
				<table width="100%">
					<tr>
						<td>
<?php
							if (isset($_COOKIE['Username']))
							{
								$getLike = mysql_query("SELECT * FROM `likes` WHERE `Username` = '$user' AND `VideoID` = '$id' LIMIT 1");
								if (mysql_num_rows($getLike) != 0)
								{
									$getLike = mysql_fetch_array($getLike);
									if ($getLike['Liked'] == '1')
									{
?>
										<img class="LikeButton" id="LikeImage" src="http://plychannel.com/Images/Liked.png" />
										<img class="LikeButton" id="DislikeImage" src="http://plychannel.com/Images/Dislike.png" />
<?php
									}
									else
									{
?>
										<img class="LikeButton" id="LikeImage" src="http://plychannel.com/Images/Like.png" />
										<img class="LikeButton" id="DislikeImage" src="http://plychannel.com/Images/Disliked.png" />
<?php
									}
								}
								else
								{
									?>
										<img class="LikeButton" id="LikeImage" src="http://plychannel.com/Images/Like.png" />
										<img class="LikeButton" id="DislikeImage" src="http://plychannel.com/Images/Dislike.png" />
									<?php
								}
							}
							else
							{
?>
							<a href="http://plychannel.com/login" style="">
								<img class="LikeButton" src="http://plychannel.com/Images/Like.png" />
								<img class="LikeButton" src="http://plychannel.com/Images/Dislike.png" />
							</a>
<?php
							}
?>
						</td>
						<td align="right">
							<div class='tabs' id='tabs' align='right'>
								<a href=javascript:activateTab('page1','TabButton_1') class='tabButtonSelected' id='TabButton_1'><img src='http://plychannel.com/Images/info_small.png' width='20px' height='20px' title='About' /></a>
						        <a href=javascript:activateTab('page2','TabButton_2') class='tabButton'  id='TabButton_2'><img src='http://plychannel.com/Images/AddTo.png' width='20px' height='20px' title='Add To Playlist' /></a>
								<a href=javascript:activateTab('page3','TabButton_3') class='tabButton'  id='TabButton_3'><img src='http://plychannel.com/Images/share.png' width='20px' height='20px' title='Share' /></a>
								<a href=javascript:activateTab('page4','TabButton_4') class='tabButton'  id='TabButton_4'><img src='http://plychannel.com/Images/report.png' width='20px' height='20px' title='Report' /></a>
							</div>
						</td>
					</tr>
				</table>
			</div><div class="detailsNext">
			<div id='tabCtrl'>
			<div id='page1' style=''>
				<div class="description">
				<span>Published on <?php echo date("j F Y", $time); ?></span>
				<br />
				
<?php

preg_match_all("/\<br \/\>/", $description, $matches);
$desSize = (sizeof($matches) * 50) + strlen(strip_tags($description));
if ($desSize > 300)
{
	$smallDis = substr($description, 0, 300) . "...";
	echo "<span id='smallDiscription'>" . $smallDis . "</span>";
	echo "<span id='fullDiscription' style='display:none;'>" . $description . "</span>";
	echo "<div id='MoreShower' class='MoreShower'></div>";
}
else
{
	echo "<span>" . $description . "</span>";
}

?>
				</div>
			</div>
			<div id='page2' style='display: none;'>
			<div id="AddToMessage" style="display:none;"></div>
<?php

			if ($_COOKIE['Username'])
			{
				$playlists = mysql_query("SELECT * FROM `playlists` WHERE `owner` = '$user' ORDER BY `id` DESC");
				echo "<div id='playlistChoser'>";
				while($row = mysql_fetch_array($playlists))
	            {
	            	$totalPlaylistVideos = mysql_query("SELECT COUNT(`id`) AS 'title' FROM `playlist_videos` WHERE `playlistID` = '".$row['id']."' LIMIT 1");
	            	$totalPlaylistVideos = mysql_fetch_array($totalPlaylistVideos);
	            	$totalPlaylistVideos = $totalPlaylistVideos[0];
?>
					<div id='playlistSelected' name="<?php echo $row['name']; ?>" number="<?php echo $row['id']; ?>">
						<table width="100%">
							<tr>
								<td width="30px">
<?php
								$checkPlVideo = mysql_query("SELECT * FROM `playlist_videos` WHERE `playlistID` = '".$row['id']."' AND `videoID` = '$id' LIMIT 1");
								if (mysql_num_rows($checkPlVideo) > 0)
								{
?>
									<img style="display:block;width:15px;" id="tick_<?php echo $row['id']; ?>" src="http://plychannel.com/Images/tick.png" alt="tick" />
<?php
								}
								else
								{
?>
									<img style="display:none;width:15px;" id="tick_<?php echo $row['id']; ?>" src="http://plychannel.com/Images/tick.png" alt="tick" />
<?php
								}
?>
								</td><td>
									<?php echo $row['name'] . " (<span id='totalPlVideos_".$row['id']."'>" . $totalPlaylistVideos . "</span>)"; ?>
								</td>
								<td width="100px">
<?php 
									if ($row['privacy'] == "a")
									{
										echo "Public";
									}
									else
									{
										echo "Unlisted";
									}
?>
								</td>
							</tr>
						</table>
					</div>
<?
	            }
	            echo "</div>";
?>
				<div style="margin:5px;">
					<input style="width: 536px;height: 30px;" id='playlistTyped' type="text" placeholder="Create A New Playlist." />
					<select style="height: 30px;" id="playlistPrivacySelected">
						<option value="a">Public</option>
						<option value="u">Unlisted</option>
					</select>
					<button id='playlistCreate' style="position: relative;top: -2px;" type="button" class="btn btn-sm btn-default">Create</button>
				</div>
			<?php
			}
			else
			{
?>

				<div class="alert alert-info">
				  <a href="http://plychannel.com/login?feature=http://plychannel.com/watch?v=<?php echo $encid; ?>" class="alert-link">You must be signed in to access this.</a>
				</div>

<?php
			}
?>

			</div>
			<div id='page3' style='display: none;'>
				<div style="font-size: 14px;font-weight: bold;color: #3C3C3C;">Share this video</div>
				<table>
					<tr>
						<td><!-- facebook -->
							<a href="javascript:newPopup(600, 300, 'https://www.facebook.com/dialog/feed?%20app_id=145634995501895%20&display=popup&caption=<?php echo $title; ?>&link=http://plychanenl.com/watch?v=<?php echo urlencode($encid); ?>&picture=http://plychannel.com/Images/video?i=<?php echo urlencode($encid); ?>&redirect_uri=https://developers.facebook.com/tools/explorer');">
								<img style="margin: 5px;" src="http://plychannel.com/Images/Sharing/facebook.jpg" alt="Share to facebook." title="Share to facebook.">
							</a>
						</td>
						<td><!-- twitter -->
							<a href="javascript:newPopup(550, 450, 'https://twitter.com/intent/tweet?url=http://plychannel.com/watch?v=<?php echo urlencode($encid); ?>&text=<?php echo urlencode($title); ?>:&via=plychannel&related=Plychannel');">
								<img style="margin: 5px;" src="http://plychannel.com/Images/Sharing/twitter.jpg" alt="Share to twitter." title="Share to twitter." />
							</a>
						</td>
						<td><!-- google+ -->
							<a href="javascript:newPopup(500, 450, 'https://plus.google.com/share?url=http://plychannel.com/watch?v=<?php echo urlencode($encid); ?>');">
								<img style="margin: 5px;" src="http://plychannel.com/Images/Sharing/google.jpg" alt="Share to google+." title="Share to google+." />
							</a>
							<div class="g-plusone" data-size="tall" style="position:relative; top:2px;"></div>
						</td>
						<td><!-- stubmle upon -->
							<a href="javascript:newPopup(800, 550, 'http://www.stumbleupon.com/submit?url=http://plychannel.com/watch?v=<?php echo urlencode(urlencode($encid . $p)); ?>')">
								<img style="margin: 5px;" src="http://plychannel.com/Images/Sharing/stumbleupon.jpg" alt="Share to stumble upon." title="Share to stumble upon." />
							</a>
						</td>
						<!--
						<td><!-- digg
							<a href="javascript:newPopup(700, 430, 'http://www.stumbleupon.com/submit?url=http://plychannel.com/watch?v=<?php echo urlencode(urlencode($encid . $p)); ?>')">
								<img style="margin: 5px;" src="http://plychannel.com/Images/Sharing/digg.jpg" alt="Share to digg." title="Share to digg." />
							</a>
						</td>
						<td><!-- diigo
							<a href="javascript:newPopup(700, 430, 'http://www.stumbleupon.com/submit?url=http://plychannel.com/watch?v=<?php echo urlencode(urlencode($encid . $p)); ?>')">
								<img style="margin: 5px;" src="http://plychannel.com/Images/Sharing/diigo.jpg" alt="Share to diigo." title="Share to diigo." />
							</a>
						</td>
						-->
						<td><!-- blogger -->
							<a href="javascript:newPopup(500, 450, 'http:\/\/www.blogger.com\/blog-this.g?n=<?php echo urlencode($title); ?>\u0026source=plychannel\u0026b=%253Ca%2520href%253D%2522http%253A%252F%252Fplychannel.com%252Fwatch%253Fv%253D<?php echo urlencode(urlencode(urlencode($encid))); ?>%2522%253Ehttp%253A%252F%252Fplychannel.com%252Fwatch%253Fv%253D<?php echo urlencode(urlencode(urlencode($encid))); ?>%253C%252Fa%253E');">
								<img style="margin: 5px;" src="http://plychannel.com/Images/Sharing/blogger.jpg" alt="Share to blogger." title="Share to blogger." />
							</a>
							<div class="g-plusone" data-size="tall" style="position:relative; top:2px;"></div>
						</td>
						<td><!-- reddit -->
							<a href="javascript:newPopup(850, 700, 'http:\/\/reddit.com\/submit?url=http%3A\/\/plychannel.com\/watch%253Fv%3D<?php echo urlencode(urlencode($encid)); ?>\u0026title=<?php echo urlencode($title); ?>')">
								<img style="margin: 5px;" src="http://plychannel.com/Images/Sharing/reddit.jpg" alt="Share to reddit." title="Share to reddit." />
							</a>
						</td>
						<td><!-- tumbler -->
							<a href="javascript:newPopup(700, 430, 'http://www.tumblr.com/share?v=3&u=http%25253A//plychannel.com/watch%253Fv%253D<?php echo urlencode(urlencode(urlencode(urlencode($encid)))); ?>')">
								<img style="margin: 5px;" src="http://plychannel.com/Images/Sharing/tumbler.jpg" alt="Share to tumbler." title="Share to tumbler." />
							</a>
						</td>
						<td><!-- bkонтакте -->
							<a href="javascript:newPopup(700, 430, 'http://vk.com/share.php?url=http%3A%2F%2Fplychannel.com%2Fwatch%3Fv%3D<?php echo urlencode(urlencode($encid)); ?>')">
								<img style="margin: 5px;" src="http://plychannel.com/Images/Sharing/ВКонтакте.jpg" alt="Share to bkонтакте." title="Share to bkонтакте." />
							</a>
						</td>
						<td><!-- oдноклассники -->
							<a href="javascript:newPopup(700, 430, 'http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.noresize=on&st._surl=http%3A%2F%2Fplychannel.com%2Fwatch%3Fv%3D<?php echo urlencode(urlencode(urlencode($encid))); ?>')">
								<img style="margin: 5px;" src="http://plychannel.com/Images/Sharing/Одноклассники.jpg" alt="Share to oдноклассники." title="Share to oдноклассники." />
							</a>
						</td>
						<td><!-- pinster -->
							<a href="javascript:newPopup(700, 430, 'http://www.pinterest.com/pin/create/button/?url=http%3A%2F%2Fplychannel.com%2Fwatch%3Fv%3D<?php echo urlencode(urlencode(urlencode($encid))); ?>&description=<?php echo urlencode($title); ?>&is_video=true&media=http%3A%2F%2Fplychannel.com%2FImages%2Fvideo%3Fi%3D<?php echo urlencode($encid); ?>')">
								<img style="margin: 5px;" src="http://plychannel.com/Images/Sharing/pinterest.jpg" alt="Share to pinterest." title="Share to pinterest." />
							</a>
						</td>
						<td><!-- linkdin -->
							<a href="javascript:newPopup(700, 430, 'http://www.linkedin.com/shareArticle?url=http%3A%2F%2Fplychannel.com%2Fwatch%3Fv%3D<?php echo urlencode(urlencode(urlencode($encid))); ?>&title=<?php echo urlencode($title); ?>&source=plychannel')">
								<img style="margin: 5px;" src="http://plychannel.com/Images/Sharing/linkedin.jpg" alt="Share to linkedin." title="Share to linkedin." />
							</a>
						</td>
					</tr>
				</table>
				<input style="width: calc(100% - 10px);height: 40px;font-size: 24px;margin: 5px;" type="text" value="http://plychannel.com/watch?v=<?php echo urlencode($encid); ?>" />
				<br />
				<img width="100%" height="12px" src="http://plychannel.com/Images/seperator.png" alt="seperator" />
				<div style="font-size: 14px;font-weight: bold;color: #3C3C3C;">Embed</div>
				<textarea style="margin: 5px;width: calc(100% - 10px);height: 100px;resize: none;">&lt;iframe style="width:400;height:285;" id="plychannelVideoID" scrolling="no" src="http://plychannel.com/video?v=<?php echo urlencode($encid); ?>&t=0&a=false" allowFullScreen="true" webkitallowfullscreen="true" mozallowfullscreen="true" frameborder="0px"&gt;&lt;/iframe&gt;</textarea>
<?php
				if (isset($_COOKIE['Username']))
				{
?>				
				<img width="100%" height="12px" src="http://plychannel.com/Images/seperator.png" alt="seperator" />
				<div style="font-size: 14px;font-weight: bold;color: #3C3C3C;">Email</div>
				<div id="SentVideoEmail" style="margin: 5px;display:none;"></div>
				<span style="font-size: 12px;margin: 5px;"><strong>To</strong> (use ; to seperate emails e.g. example@gmail.com;example2@gmail.com)</span>
				<br />
				<input style="margin: 5px;width: 300px;" type="text" id="emailingThisVideoTo" />
				<br />
				<button style="margin: 5px;" class="btn btn-xs btn-primary" id="SendVideoToEmail">Send Via Email</button>
<?php
				}
?>
			</div>
			<div id='page4' style='display: none;'>
<?php
			if (isset($_COOKIE['Username']))
			{
?>
				<div id="reportMessage" style="display:none;"></div>
				<h5>Please describe why you are reporting this video.</h5>
					<textarea style='resize:none;height:100px;width:100%;' id='videoReportMessage'></textarea>
					<br />
					<button id='videoReportButton' class="btn btn-xs btn-warning">Report</button>
<?php
			}
			else
			{
?>
				<div class="alert alert-info">
				  <a href="http://plychannel.com/login?feature=http://plychannel.com/watch?v=<?php echo $encid; ?>" class="alert-link">You must be signed in to access this.</a>
				</div>
<?php
			}
?>
			</div>
		</div>
				<img src="http://plychannel.com/Images/seperator.png" width="100%" height="12px"><br />
				<table width="100%">
				<tr><td valign="top">
				<select id='commentSelection'>";
					<option value='top' selected>Top Comments</option>
		            <option value='latest'>Latest Comments</option>
				</select>
				<br /><br />
				<div class="commentArea">
				</div>
			</td><td valign="top" width="250px">
				<div class="relatedVideos">
<?php
				$relatedVideos = "SELECT * FROM `videos` WHERE (";
				$searches = $tags . " " . $title . " " . $description;
				preg_match_all("/[a-zA-Z0-9]+/", $searches, $matches);
				for ($x = 0; $x < count($matches); $x++)
				{
					$word = $matches[$x][0];
					$relatedVideos .= "`Title` LIKE '%".$word."%' OR `Tags` LIKE '%".$word."%' OR `Discription` LIKE '%".$word."%' OR";
				}
				if(count($matches) > 0)
				{
					$relatedVideos = substr($relatedVideos, 0, -3);
					$relatedVideos .= ") AND ";
				}
				$relatedVideos .= "(`Uploaded` = '1' AND `Privacy` = 'a' AND `ID` != '$id')ORDER BY `Views` DESC LIMIT 12";
				$relatedVideos = mysql_query($relatedVideos);
				while($row = mysql_fetch_array($relatedVideos))
				{
?>
					<div class="media">
					  <a style="text-decoration:none;" href="http://plychannel.com/watch?v=<?php echo encrypt($row['ID']); ?>">
					    <div style="position:relative; width:0; height:0;top:0;left:0;"><span id="videoTime"><?php echo $row['Length']; ?></span></div>
					    <img width="100px" height="70px" class="media-object pull-left" src="http://plychannel.com/Images/video?i=<?php echo encrypt($row['ID']); ?>">
						  <div class="media-body" class="pull-left" style="position: relative;padding: 0 0 0 5px;top: -5px;">
						    <h4 style="color: #FE563B;font-size: 15px;font-weight: bold;">
<?php
							$relatedTitle = $row['Title'];
							if (strlen($relatedTitle) > 17)
								$relatedTitle = substr($relatedTitle, 0, 14) . "...";
							echo $row['Title'];
?>
						    </h4>
						    <span style="color: #999999;font-weight: bold;font-size: 11px;">
						  	by: <?php echo $row['Author']; ?><br />
						  	<?php echo $row['Views']; ?> views
						  	</span>
						  </div>
					  </a>
					</div>
<?php
				}
?>
				</div>
				</td></tr></table>
			</div>
		</td>
	</tr>
</table>
<script src="http://plychannel.com/js/watch.js"></script>
<script src="http://plychannel.com/js/tab.js"></script>

<?php require_once("Include/footer.php"); ?>