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
			.dropDown{
				background-color: #fff;
				font-size: 15px;
				padding: 10px 15px;
				color: #000;
				text-decoration: none;
			}
			.dropDown:hover{
				background-color: #F5F5F5;
				cursor: pointer;
				cursor: hand;
			}
			.moreComms{
				position: absolute;
				display: none;
				background: url('Images/moreComments.png');
				background-size: 100%;
				width: 13px;
				height: 13px;
				right: 10px;
			}
			.moreComms:hover{
				cursor: pointer;
				cursor: hand;
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
				<a href="http://plychannel.com/channelPlaylists?u=<?php echo $channelUser; ?>"><div>Playlists</div></a>
				<a href="http://plychannel.com/channelDiscussions?u=<?php echo $channelUser; ?>"><div style="border-bottom: #ff0000 3px solid; opacity: 1;">Discussions</div></a>
				<a href="http://plychannel.com/channelAbout?u=<?php echo $channelUser; ?>"><div>About</div></a>
			</div>
		</div>
		
		<div class="content">
<?php
		if (isset($_COOKIE['Username']))
		{
?>
			<form action="" method="POST">
				<div style="margin: 5px;">
					<div style="display: inline-block; vertical-align:top; width:50px;height:50px;background: url('http://plychannel.com/Images/author?u=<?php echo $user; ?>'); background-size: 100%;"></div>
					<div style="display: inline-block;">
						<textarea style="width: 885px;height: 50px;resize: none;" name="comment"></textarea>
					</div>
					<input style="margin-left: 900px;" class="greyButton" type="submit" value="Post" name="submitted" />
				</div>
			</form>
<?php
		}
		if (isset($_POST['submitted']) && isset($_COOKIE['Username']))
		{
			$comment = strip_tags(trim($_POST['comment']));
			mysql_query("INSERT INTO `channelcomments` (`id`, `channel`, `comment`, `author`, `time`)
				VALUES ('', '$channelUser', '$comment', '$user', '".time()."')");
		}
		if (isset($_GET['del']) && isset($_COOKIE['Username']))
		{
			$del = strip_tags(trim($_GET['del']));
			mysql_query("DELETE FROM `channelcomments` WHERE `id` = '$del' AND `author` = '$user' LIMIT 1");
		}
		$query = mysql_query("SELECT `id`, `comment`, `author`, `time` FROM `channelcomments` WHERE `channel` = '$channelUser' ORDER BY `time` DESC LIMIT 50");
		while ($row = mysql_fetch_array($query))
		{
?>
		<div id="comment" number="<?php echo $row['id']; ?>" style="margin: 5px;">
			<a href="http://plychannel.com/channel/<?php echo $row['author']; ?>">
				<div style="display: inline-block; vertical-align:top; width:50px;height:50px;background: url('http://plychannel.com/Images/author?u=<?php echo $row['author']; ?>'); background-size: 100%;"></div>
			</a>
			<div style="display: inline-block;">
				<a href="http://plychannel.com/channel/<?php echo $row['author']; ?>">
					<span style="font-size: 14px;font-weight: bold;color: #000000;"><?php echo $row['author']; ?></span>
				</a>
				<span style="margin-left: 15px;font-size: 12px;color: #999;font-weight: bold;"><?php echo timeToString($row['time']); ?> ago</span>
				<div id="droper" number="<?php echo $row['id']; ?>" class="moreComms"></div>
				<div id="dropDown_<?php echo $row['id']; ?>" style="display:none;position: absolute;right: 10px;margin-top: 15px;z-index: 10;background-color: #fff;border: solid 1px #ccc;padding: 5px 0px;">
<?php
					if (isset($_COOKIE['Username']))
					{
						if ($user == $row['author'])
						{
?>
							<a href="?u=<?php echo $_GET['u']; ?>&amp;del=<?php echo $row['id']; ?>">
								<div class="dropDown">Delete this comment</div>
							</a>
<?php
						}
					}		
?>
				</div>
				<div style="max-width: 600px;"><?php echo $row['comment']; ?></div>
			</div>
		</div>
<?php
		}
?>
		</div>

		<?php require_once("PHP/footer.php"); ?>
		<!-- JS -->
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script type="text/javascript" src="../Javascript/toolbar.js"></script>
		<script type="text/javascript">
		$("html", window.parent.document).click(function(){
			$("[id=droper]").each(function(){
				var number = $(this).attr("number");
				if ($(this).css("display") == "none")
					$("#dropDown_" + number).css("display" , "none");
			});
		});

		$("html").click(function(){
			$("[id=droper]").each(function(){
				var number = $(this).attr("number");
				if ($(this).css("display") == "none")
					$("#dropDown_" + number).css("display" , "none");
			});
		});

		$("[id=droper]").each(function(){
			$(this).click(function(){
				var number = $(this).attr("number");
				if ($("#dropDown_" + number).css("display") == "block")
					$("#dropDown_" + number).css("display" , "none");
				else
					$("#dropDown_" + number).css("display", "block");
			});
		});
		$("[id=comment]").each(function(){
			$(this).mouseenter(function(){
				var number = $(this).attr("number");
				$("[id=droper]").each(function(){
					if ($(this).attr("number") == number)
					{
						$(this).css("display" , "inline-block");
					}
				});
			});
			$(this).mouseleave(function(){
				var number = $(this).attr("number");
				$("[id=droper]").each(function(){
					if ($(this).attr("number") == number)
					{
						$(this).css("display" , "none");
					}
				});
			});
		});
		</script>
	</body>
</html>