<?php require_once("PHP/connect.php"); ?>
<?php
	if (isset($_GET['v']))
	{
		$id = decrypt(urldecode($_GET['v']));
		$encid = urlencode(encrypt($id));

		$check = mysql_query("SELECT * FROM `videos` WHERE `ID` = '$id' LIMIT 1");
		$exists = (mysql_num_rows($check) != 0);
		if ($exists)
		{
			$query = mysql_fetch_array($check);

			$totoalVideosByAuthor = mysql_query("SELECT COUNT(`ID`) AS 'ID' FROM `videos` WHERE `Author` = '".$query['Author']."' AND `Uploaded` = '1' LIMIT 1");
			$totoalVideosByAuthor = mysql_fetch_array($totoalVideosByAuthor);
			$totoalVideosByAuthor = $totoalVideosByAuthor['ID'];

			$totalAuthorSubs = mysql_query("SELECT COUNT(`ID`) AS 'ID' FROM `subscriptions` WHERE `Subscribed` = '".$query['Author']."' LIMIT 1");
			$totalAuthorSubs = mysql_fetch_array($totalAuthorSubs);
			$totalAuthorSubs = $totalAuthorSubs['ID'];


		}
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Traditional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-traditional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="Styles/toolbar.css" type="text/css" rel="stylesheet" />
		<link href="Styles/page.css" type="text/css" rel="stylesheet" />
		<link href="Styles/watch.css" type="text/css" rel="stylesheet" />

<?php
		if ($exists)
			echo "<title>".$query['Title']." - Plychannel</title>";
		else
			echo "<title>Plychannel</title>";
?>
	</head>

	<body>
		
		<?php require_once("PHP/toolbar.php"); ?>

<?php
		if (isset($_GET['p']))
		{
?>
			<div class="playlistShower">
				<a href="playlist?p=<?php echo $_GET['p']; ?>"><div style="font-size: 15px; font-weight: bold; color: #fff;">Title</div></a>
				<div style="font-size: 12px;color: #ccc;">by <a href="channel/<?php echo "zeeshan595"; ?>" style="color: #ccc;">zeeshan595</a> - <span>17 videos</span></div>
				<div class="plSeperator"></div>
				<div style="display: inline-block;">
					<div style="display: inline-block; margin-right: 10px;"><img src="Images/back.png" alt="back" /></div><div style="display: inline-block;"><img src="Images/forward.png" alt="forward" /></div>
				</div>
				<div style="display: inline-block; margin-left: 255px;">
					<img src="Images/repeat.png" alt="Repeat">
				</div>
				<div class="videoContainer">

				</div>
			</div>
<?php
		}
?>
		<div class="videoPlayer">
			<iframe id="plychannelVideoID" scrolling="no" src="http://plychannel.com/flowplayer/video.php?v=<?php echo $encid; ?>&amp;t=0" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true" frameborder="0px" style="width: 900px; height: 620px;"></iframe>
		</div>
		<div class="content">
<?php
		if ($exists)
		{
			getPercentage($query['Likes'], $query['Dislikes'], $likes, $dislikes);
?>
			<input type="hidden" value="<?php echo $id; ?>" id="id" /> <!-- FOR JS -->
			<input type="hidden" value="<?php echo $encid; ?>" id="encid" /> <!-- FOR JS -->

			<div class="videoDetails">
				<h2 style="font-size: 20px;font-weight: normal;"><?php echo $query['Title']; ?></h2>
				<div style="display: inline-block;width:350px;">
					<a href="http://plychannel.com/channel/<?php echo $query['Author']; ?>"><div style="display: inline-block;background: url('http://plychannel.com/Images/author?u=<?php echo $query['Author']; ?>'); background-size: 100%;width:50px;height: 50px;"></div></a>
					<div style="display: inline-block;width: 200px;height: 50px;vertical-align: top;">
						<a href="http://plychannel.com/channel/<?php echo $query['Author']; ?>"><h5 style="margin-top: 5px;margin-bottom: 5px;color:#000"><?php echo $query['Author']; ?> - <span style="color:slategrey;font-size:10px;"><?php echo $totoalVideosByAuthor; ?> videos</span></h5></a>
						<a href="#" style="display:inline-block;">
<?php
						if (isset($_COOKIE['Username']))
						{
							if ($query['Author'] != $user)
							{
								$isSubbed = mysql_fetch_array("SELECT * FROM `subscriptions` WHERE `Username` = '$user' AND `Subscribed` = '".$query['Author']."' LIMIT 1");
								if (mysql_num_rows($isSubbed) > 0)
								{
?>
									<div class="subscribed"></div><div class="VideoBubble"><?php echo number_format($totalAuthorSubs); ?></div>
<?php
								}
								else
								{
?>
									<div class="subscribe"></div><div class="VideoBubble"><?php echo number_format($totalAuthorSubs); ?></div>
<?php
								}
							}
						}
						else
						{
?>
							<div class="subscribe"></div><div class="VideoBubble"><?php echo number_format($totalAuthorSubs); ?></div>
<?php
						}
?>
						</a>
					</div>
				</div>
				<div style="display: inline-block;text-align: right;width: 330px;">
					<div style="margin-right: 5px;font-size: 17px;font-weight: bold;margin-bottom: -10px;"><?php echo number_format($query['Views']); ?></div>
					<div>
						<div style="width: <?php echo $likes * 2; ?>px;height:2px;background-color: #FE563B;display: inline-block;"></div>
						<div style="width: <?php echo $dislikes * 2; ?>px;height:2px;background-color: #ccc;display: inline-block;"></div>
					</div>
					<div style="color: #7C7C7C; font-size: 12px;">
						<span style="width: 175px;display: inline-block;text-align: left;"><img alt="likes" src="Images/like_small.png"><?php echo number_format($query['Likes']); ?></span>
						<span><img src="Images/dislike_small.png" alt="dislikes"><?php echo number_format($query['Dislikes']); ?></span>
					</div>
				</div>
				<div style="margin-top: 15px;display:inline-block">
<?php
				if (isset($_COOKIE['Username']))
				{
					$isLiked = mysql_query("SELECT `Liked` FROM `likes` WHERE `Username` = '$user' AND `VideoID` = '$id' LIMIT 1");
					if (mysql_num_rows($isLiked) > 0)
					{
						$isLiked = mysql_fetch_array($isLiked);
						$isLiked = $isLiked[0];
						if ($isLiked)
						{
?>
							<div class="liked" id="likeButton"></div>
							<div class="dislike" id="dislikeButton"></div>
<?php
						}
						else
						{
?>
							<div class="like" id="likeButton"></div>
							<div class="disliked" id="dislikeButton"></div>	
<?php
						}
					}
					else
					{
?>
						<div class="like" id="likeButton"></div>
						<div class="dislike" id="dislikeButton"></div>
<?php
					}
				}
				else
				{
?>
					<a href="http://plychannel.com/login?feature=http://plychannel.com/watch?v=<?php echo $encid; ?>">
						<div class="like"></div>
						<div class="dislike"></div>
					</a>
<?php
				}
?>
				</div>
				<div id="pageTabs" style="display:inline-block;width: 590px;text-align: right;">
					<div id="pageTab" number="1" class="pageActiveTab">About</div>
					<div id="pageTab" number="2" class="pageTab">Share</div>
					<div id="pageTab" number="3" class="pageTab">Add to</div>
					<div id="pageTab" number="4" class="pageTab"><img src="Images/flag.png" alt="flag video" /></div>
				</div>
				<div class="seperator" style="left: -15px;top: -20px;"></div>

				<!-- VIDEO DESCRIPTION -->

				<div id="pages">
					<div id="page_1">
						<span style="font-size: 13px;font-weight: bold;">Published on <?PHP echo date("j M Y", $query['Time']); ?></span>
<?php
						$count = (strlen(substr($query['Description'], 0, 582)) - strlen(strip_tags(substr($query['Description'], 0, 582)))) * 14;
						$smallDes = substr($query['Description'], 0, 582 - $count);
?>
						<div class="smallDes"><?php echo $smallDes; ?></div>
						<div class="bigDes" style="display:none;">
							<?php echo $query['Description']; ?>
							<br /><br />
							<span style="font-size: 12px; font-weight: bold; color: #000;">Category</span>
							<span style="font-size: 12px; font-weight: normal; color: #919191;"><?php echo $query['Category']; ?></span>							
						</div>
						<div id="showHideDescription" class="showMore"></div>
					</div>
					<div id="page_2" style="display:none;">
						<div style="font-size: 13px; font-weight: bold; color: #000;">Share this video</div>
						<!-- facebook -->
						<a href="javascript:newPopup(600, 300, 'https://www.facebook.com/dialog/feed?%20app_id=145634995501895%20&display=popup&caption=<?php echo $title; ?>&link=http://plychanenl.com/watch?v=<?php echo urlencode($encid); ?>&picture=http://plychannel.com/Images/video?i=<?php echo urlencode($encid); ?>&redirect_uri=https://developers.facebook.com/tools/explorer');">
							<img style="margin: 5px;" src="http://plychannel.com/Images/socialNetworks/facebook.jpg" alt="Share to facebook." title="Share to facebook.">
						</a>
						<!-- twitter -->
						<a href="javascript:newPopup(550, 450, 'https://twitter.com/intent/tweet?url=http://plychannel.com/watch?v=<?php echo urlencode($encid); ?>&text=<?php echo urlencode($title); ?>:&via=plychannel&related=Plychannel');">
							<img style="margin: 5px;" src="http://plychannel.com/Images/socialNetworks/twitter.jpg" alt="Share to twitter." title="Share to twitter." />
						</a>
						<!-- google+ -->
						<a href="javascript:newPopup(500, 450, 'https://plus.google.com/share?url=http://plychannel.com/watch?v=<?php echo urlencode($encid); ?>');">
							<img style="margin: 5px;" src="http://plychannel.com/Images/socialNetworks/google.jpg" alt="Share to google+." title="Share to google+." />
						</a>
						<!-- stubmle upon -->
						<a href="javascript:newPopup(800, 550, 'http://www.stumbleupon.com/submit?url=http://plychannel.com/watch?v=<?php echo urlencode(urlencode($encid . $p)); ?>')">
							<img style="margin: 5px;" src="http://plychannel.com/Images/socialNetworks/stumbleupon.jpg" alt="Share to stumble upon." title="Share to stumble upon." />
						</a>
						<!-- blogger -->
						<a href="javascript:newPopup(500, 450, 'http:\/\/www.blogger.com\/blog-this.g?n=<?php echo urlencode($title); ?>\u0026source=plychannel\u0026b=%253Ca%2520href%253D%2522http%253A%252F%252Fplychannel.com%252Fwatch%253Fv%253D<?php echo urlencode(urlencode(urlencode($encid))); ?>%2522%253Ehttp%253A%252F%252Fplychannel.com%252Fwatch%253Fv%253D<?php echo urlencode(urlencode(urlencode($encid))); ?>%253C%252Fa%253E');">
							<img style="margin: 5px;" src="http://plychannel.com/Images/socialNetworks/blogger.jpg" alt="Share to blogger." title="Share to blogger." />
						</a>
						<!-- reddit -->
						<a href="javascript:newPopup(850, 700, 'http:\/\/reddit.com\/submit?url=http%3A\/\/plychannel.com\/watch%253Fv%3D<?php echo urlencode(urlencode($encid)); ?>\u0026title=<?php echo urlencode($title); ?>')">
							<img style="margin: 5px;" src="http://plychannel.com/Images/socialNetworks/reddit.jpg" alt="Share to reddit." title="Share to reddit." />
						</a>
						<!-- tumbler -->
						<a href="javascript:newPopup(700, 430, 'http://www.tumblr.com/share?v=3&u=http%25253A//plychannel.com/watch%253Fv%253D<?php echo urlencode(urlencode(urlencode(urlencode($encid)))); ?>')">
							<img style="margin: 5px;" src="http://plychannel.com/Images/socialNetworks/tumbler.jpg" alt="Share to tumbler." title="Share to tumbler." />
						</a>
						<!-- bkонтакте -->
						<a href="javascript:newPopup(700, 430, 'http://vk.com/share.php?url=http%3A%2F%2Fplychannel.com%2Fwatch%3Fv%3D<?php echo urlencode(urlencode($encid)); ?>')">
							<img style="margin: 5px;" src="http://plychannel.com/Images/socialNetworks/ВКонтакте.jpg" alt="Share to bkонтакте." title="Share to bkонтакте." />
						</a>
						<!-- oдноклассники -->
						<a href="javascript:newPopup(700, 430, 'http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.noresize=on&st._surl=http%3A%2F%2Fplychannel.com%2Fwatch%3Fv%3D<?php echo urlencode(urlencode(urlencode($encid))); ?>')">
							<img style="margin: 5px;" src="http://plychannel.com/Images/socialNetworks/Одноклассники.jpg" alt="Share to oдноклассники." title="Share to oдноклассники." />
						</a>
						<!-- pinster -->
						<a href="javascript:newPopup(700, 430, 'http://www.pinterest.com/pin/create/button/?url=http%3A%2F%2Fplychannel.com%2Fwatch%3Fv%3D<?php echo urlencode(urlencode(urlencode($encid))); ?>&description=<?php echo urlencode($title); ?>&is_video=true&media=http%3A%2F%2Fplychannel.com%2FImages%2Fvideo%3Fi%3D<?php echo urlencode($encid); ?>')">
							<img style="margin: 5px;" src="http://plychannel.com/Images/socialNetworks/pinterest.jpg" alt="Share to pinterest." title="Share to pinterest." />
						</a>
						<!-- linkdin -->
						<a href="javascript:newPopup(700, 430, 'http://www.linkedin.com/shareArticle?url=http%3A%2F%2Fplychannel.com%2Fwatch%3Fv%3D<?php echo urlencode(urlencode(urlencode($encid))); ?>&title=<?php echo urlencode($title); ?>&source=plychannel')">
							<img style="margin: 5px;" src="http://plychannel.com/Images/socialNetworks/linkedin.jpg" alt="Share to linkedin." title="Share to linkedin." />
						</a>
						<br />
						<input style="width: 490px;height: 30px;font-size: 24px;outline-width: 0;border: solid 1px;color: #424242;margin-left: 5px;" type="text" value="http://plychannel.com/watch?v=<?php echo $encid; ?>&t=0" readonly />
						<br /><br />
						<div style="font-size: 13px; font-weight: bold; color: #000;">Embed</div>
						<textarea style="outline-width: 0;border: solid 1px;color: #424242;margin: 2px 2px 2px 5px;width: 487px;height: 90px;resize: none;" readonly><iframe scrolling="no" src="http://plychannel.com/video.php?v=<?php echo $encid; ?>&amp;t=0" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true" frameborder="0px" style="width: 900px; height: 620px;"></iframe></textarea>
						<img style="margin-top: 15px;margin-right: auto;margin-left: auto;display: block;" src="Images/seperator.png" alt="seperator" />
					</div>
					<div id="page_3" style="display: none;">
<?php
					if (isset($_COOKIE['Username']))
					{
?>
						<div id="playlistContainer" style="height: 250px;overflow-y: scroll;width: 670px;background: #efefef;border: 1px solid #ccc;padding: 10px;box-shadow: 0 1px 0 #fff,inset 0 1px 1px rgba(0,0,0,0.2);">
<?php
							$userPlaylists = mysql_query("SELECT * FROM `playlists` WHERE `owner` = '$user' ORDER BY `id` DESC");
							while ($row = mysql_fetch_array($userPlaylists))
							{
								$name = $row['name'];
								$privacy = $row['privacy'];
								$plSize = mysql_query("SELECT COUNT(`id`) AS 'length' FROM `playlist_videos` WHERE `playlistID` = '".$row['id']."' LIMIT 1");
								$plSize = mysql_fetch_array($plSize);
								$plSize = $plSize['length'];
								$videoInPl = mysql_query("SELECT * FROM `playlist_videos` WHERE `videoID` = '$id' AND `playlistID` = '".$row['id']."' LIMIT 1");
								$videoInPl = mysql_num_rows($videoInPl) > 0;
?>
								<div class="playlist" id="playlistItem" plID="<?php echo $row['id']; ?>" inPlaylist="<?php if ($videoInPl) echo '1'; else echo '0'; ?>">
									<img id="playlistTickMark_<?php echo $row['id']; ?>" src="Images/tick.png" alt="tick" style="display: <?php if ($videoInPl) echo 'inline-block'; else echo 'none'; ?>;" />
									<span style="width: 530px;display: inline-block;font-size: 14px;font-weight: bold;"><?php echo $row['name']; ?>
										<span style="margin-left: 15px;font-weight: normal;">(<?php echo $plSize; ?>)</span>
									</span>
									<span style="font-size: 14px;text-align: right;display: inline-block;width: 85px;"><?php if ($privacy == 'a') echo "Public"; else echo "Private"; ?></span>
								</div>
<?php
							}
?>
						</div>
						<input id="playlistName" style="width: 487px;margin-top: 5px;padding: 5px 10px;" placeholder="Enter a new playlist name" type="text" />
						<select id="playlistPrivacy">
							<option selected value="a">Public</option>
							<option value="p">Private</option>
						</select>
						<button class="greyButton" id="playlistCreator">Create playlist</button>
<?php
					}
					else
					{
?>
						<div style="color: #000;font-size: 14px;font-weight: bold;background-color: #efefef;padding: 10px;margin-right: 10px;border: solid 1px #ccc;border-radius: 2px;">Please <a href="http://plychannel.com/login">login</a>/<a href="http://plychannel.com/register">register</a> to access this feature.</div>
<?php
					}
?>
					<img style="margin-top: 15px;margin-right: auto;margin-left: auto;display: block;" src="Images/seperator.png" alt="seperator" />
					</div>
					<div id="page_4" style="display: none;">
						<div style="font-size: 13px; font-weight: bold; color: #000;">What is the issue?</div>
						<form action="report?v=<?php echo $encid;?>" method="POST">
							<select name="reportType">
								<option value="none">Select One</option>
								<option value="Sexual content">Sexual content</option>
								<option value="Violent or repulsive content">Violent or repulsive content</option>
								<option value="Hateful or abusive content">Hateful or abusive content</option>
								<option value="Harmful dangerous acts">Harmful dangerous acts</option>
								<option value="Child abuse">Child abuse</option>
								<option value="Spam or misleading">Spam or misleading</option>
								<option value="Infringes my rights">Infringes my rights</option>
								<option value="Captions report (CVAA)">Captions report (CVAA)</option>
							</select>
							<br /><br />
							<div style="font-size: 12px; font-weight: bold; color: #000;">Timestamp selected:</div>
							<input style="font-size: 20px;height: 30px;width: 50px;padding: 5px;" type="text" name="timeMinutes" />:<input style="font-size: 20px;height: 30px;width: 50px;padding: 5px;" type="text" name="timeSeconds" />
							<br /><br />
							<div style="font-size: 12px; font-weight: bold; color: #000;">Please provide additional details about the issue:</div>
							<textarea name="reportMessage" style="width: 487px;height: 90px;resize: none;" maxlength="500" id="flagMessage"></textarea>
							<div style="font-size: 12px; font-weight: bold; color: #424242;" id="flagCharactersRemaining">500 Character Remaining</div>
							<p style="font-size: 12px;font-weight: bold;color: #666;">
								We are working very hard to make sure you get the best experince possible. If you have an issue with this video please report it imediatly. Any missuse of this feature can result in your account getting deleted and a permenent ban.
							</p>
							<input style="margin-left: calc(100% - 100px);" type="submit" value="Submit" class="Button" />
						</form>
						<img style="margin-top: 15px;margin-right: auto;margin-left: auto;display: block;" src="Images/seperator.png" alt="seperator" />
					</div>
				</div>
<?php
				$totalComments = mysql_query("SELECT COUNT(`id`) FROM `comments` WHERE `videoID` = '$id' LIMIT 1");
				$totalComments = mysql_fetch_array($totalComments);
				$totalComments = $totalComments[0];
?>
				<!-- COMMENTS -->
				<a href="all_comments?v=<?php echo $encid; ?>"><div style="font-size: 13px;font-weight: bold;color: #666666;">ALL COMMENTS <span style="font-weight: normal;">(<?php echo $totalComments; ?>)</span></div></a>

<?php
				$comEnabled = mysql_query("SELECT * FROM `videos` WHERE `ID` = '$id' AND `Comments` = '1' LIMIT 1");
				if (mysql_num_rows($comEnabled) == 1)
				{
					if (isset($_COOKIE['Username']))
					{
?>
						<div style="margin-top: 15px;">
							<div style="display: inline-block;width:50px;height:50px;background: url('http://plychannel.com/Images/author?u=<?php echo $user; ?>'); background-size: 100%;"></div>
							<textarea id="commentLeaver" placeholder="Share your thoughts" style="display: inline-block;width: 600px;height: 40px;resize: none;padding: 4px;" maxlength="500"></textarea>
						</div>
						<button id="commentLeaverButton" class="Button" style="margin-left: 617px;display:none;">Post</button>
<?php
					}
					else
					{
?>
					<a href="http://plychannel.com/login?feature=http://plychannel.com/watch?v=<?php echo $encid; ?>">
						<textarea placeholder="Login to comment." style="display: inline-block;width: 685px;height: 40px;resize: none;padding: 4px;" maxlength="500" readonly></textarea>
					</a>
<?php
					}
				}
				else
				{
?>
					<p style="font-size:13px;color:#999;font-weight:bold;text-align: center;">
						Comments have been disabled on this video.
					</p>
<?php
				}
?>				
				<br />
				<select id="commentsOrder" style="margin-top: 15px;margin-left: 0;margin-bottom: 15px;">
					<option value="top" selected>Top Comments</option>
					<option value="latest">Newest First</option>
				</select>
				<div style="display: none;">
					<input type="checkbox" id="liveComments" />Live Comments.
				</div>
				<br />
				<iframe id="commentsWindow" style="width:100%;border:0;"  onload="javascript:resizeIframe(this);" src="PHP/comments?o=top&amp;v=<?php echo $encid; ?>"></iframe>
			</div>
			<div class="relatedVideos" style="top: 0px; width:250px;right: 0;">
			<h3 style="font-size: 15px;margin-top: 5px;margin-bottom: 5px;">Related Videos</h3>
<?php
			preg_match_all("/[a-zA-Z0-9]+/", $query['Title'], $matches);
			$s = "";
			$o = "";
			for ($x = 0; $x < sizeof($matches[0]); $x++)
			{
				$match = $matches[0][$x];
				$s .= "`Title` LIKE '%".$match."%' OR `Tags` LIKE '%".$match."%' OR `Description` LIKE '%".$match."%' OR";
				$o .= " WHEN `Title` LIKE '".$match."%' THEN " . (($x * 3) + 0);
				$o .= " WHEN `Title` LIKE '% %".$match." %' THEN " . (($x * 3) + 1);
				$o .= " WHEN `Title` LIKE '%".$match."' THEN " . (($x * 3) + 2);
			}
			if (sizeof($matches) > 0)
			{
				$s = substr($s, 0, -3);
				$s = " AND (" . $s . ")";
			}
			$relatedVideos = mysql_query("SELECT * FROM `videos` WHERE (`Uploaded` = '1' AND `Privacy` = 'a' AND `ID` != '$id') $s ORDER BY CASE $o ELSE 3 END LIMIT 7");
			while($row = mysql_fetch_array($relatedVideos))
			{ 
?>
				<div class="videoTile" style="margin-bottom: 15px;">
					<a href="watch?v=<?php echo urlencode(encrypt($row['ID'])); ?>">
						<div style="height:0; width: 0; display: inline-block;">
							<div class="videoTime"><?php echo $row['Length']; ?></div>
						</div>
						<img src="http://plychannel.com/Images/video?i=<?php echo urlencode(encrypt($row['ID'])); ?>" style="margin-right: 5px; width: 70px; height: 52px; display: inline-block; vertical-align: top;" />
					</a>
					<div style="display: inline-block; width: 167px;">
						<a href="watch?v=<?php echo urlencode(encrypt($row['ID'])); ?>">
							<span style="font-size: 16px;color: #000;word-wrap: break-word;display: inline-block;max-height: 36px;width: 150px;overflow: hidden;"><?php if (strlen($row['Title']) > 36) echo substr($row['Title'],0, 33) . "..."; else echo $row['Title']; ?></span>
						</a>
						<br />
						<span style="font-size: 11px;color: #999;">by <span style="font-weight: bold;"><a style="color: #999;" href="http://plychannel.com/channel/<?php echo $row['Author']; ?>"><?php echo $row['Author']; ?></a></span></span>
						<br />
						<span style="font-size: 11px;color: #999;"><?php echo timeToString($row['Time']); ?> ago</span>
					</div>
				</div>
<?php
			}
?>
			</div>
<?php
		}
		else
		{
?>
			<h2>Couldn't find video.</h2>
<?php
		}
?>
		</div>

		<?php require_once("PHP/footer.php"); ?>
		<!-- JS -->
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script type="text/javascript" src="Javascript/toolbar.js"></script>
		<script type="text/javascript" src="Javascript/watch.js"></script>
	</body>
</html>