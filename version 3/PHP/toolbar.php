<?php
if (isset($_GET['accept-cookies']))
	setcookie("accept-cookies", "true", time() + 32140800, "/");

?>
<div class="Toolbar">
	<a href="http://plychannel.com/"><div class="logo"></div></a>
	<div id="menuButton" class="menuButton"></div>
	<form action="search" method="GET" class="search">
		<input id="searchBar" class="searchBar" type="text" name="s" placeholder="Search..." />
		<input class="searchButton" type="submit" value="" />
	</form>
	<a href="upload"><div class="uploadButton"></div></a>
</div>

<div class="sideBar" style="display:none;">
	<a href="http://plychannel.com/">
		<div class="item">
			<img class="normal" src="http://plychannel.com/Images/Sidebar/home.png" alt="What To Watch" />
			<img class="hover" style="display:none;" src="http://plychannel.com/Images/Sidebar/home_active.png" alt="What To Watch" />
			What To Watch
		</div>
	</a>
<?php
if (isset($_COOKIE['Username']))
{
	require_once("PHP/connect.php");
?>
	<a href="http://plychannel.com/channel/<?php echo decrypt(urldecode($_COOKIE['Username'])); ?>">
		<div class="item">
			<img class="normal" src="http://plychannel.com/Images/Sidebar/mychannel.png" alt="My channel" />
			<img class="hover" style="display:none;" src="http://plychannel.com/Images/Sidebar/mychannel_active.png" alt="My channel" />
			My Channel
		</div>
	</a>
	<a href="http://plychannel.com/subscription">
		<div class="item">
			<img class="normal" src="http://plychannel.com/Images/Sidebar/playlist.png" alt="Playlist" />
			<img class="hover" style="display:none;" src="http://plychannel.com/Images/Sidebar/playlist_active.png" alt="Playlist" />
			My Sybscriptions
		</div>
	</a>
	<a href="http://plychannel.com/manager">
		<div class="item">
			<img class="normal" src="http://plychannel.com/Images/Sidebar/manager.png" alt="Video Manager" />
			<img class="hover" style="display:none;" src="http://plychannel.com/Images/Sidebar/manager_hover.png" alt="Watch Later" />
			Video Manager
		</div>
	</a>
	<a href="http://plychannel.com/history">
		<div class="item">
			<img class="normal" src="http://plychannel.com/Images/Sidebar/history.png" alt="History" />
			<img class="hover" style="display:none;" src="http://plychannel.com/Images/Sidebar/history_active.png" alt="History" />
			History
		</div>
	</a>
	<a href="http://plychannel.com/settings">
		<div class="item">
			<img class="normal" src="http://plychannel.com/Images/Sidebar/manageSub.png" alt="Settings" />
			<img class="hover" style="display:none;" src="http://plychannel.com/Images/Sidebar/manageSub_active.png" alt="Manage Subscriptions" />
			Settings
		</div>
	</a>
	<a href="http://plychannel.com/signout">
		<div class="item">
			<img class="normal" src="http://plychannel.com/Images/Sidebar/signout.jpg" alt="Settings" />
			<img class="hover" style="display:none;" src="http://plychannel.com/Images/Sidebar/signout_hover.jpg" alt="Manage Subscriptions" />
			Sign out
		</div>
	</a>
	<div class="seperator"></div>
	<a href="#"><div class="label">Playlists</div></a>

<?php
		$pl = mysql_query("SELECT * FROM `playlists` WHERE `owner` = '$user' LIMIT 5");
		while ($row = mysql_fetch_array($pl))
		{
?>
			<a href="http://plychannel.com/playlist?p=<?php echo urlencode(encrypt($row['id'])); ?>">
				<div class="item">
					<img class="normal" src="http://plychannel.com/Images/Sidebar/playlists.png" alt="playlists" />
					<img class="hover" style="display:none;" src="http://plychannel.com/Images/Sidebar/playlists_active.png" alt="playlists" />
					<?php if (strlen($row['name']) < 30)echo $row['name']; else substr($row['name'], 0, 28) . "..."; ?>
				</div>
			</a>
<?php
		}
?>

	<a href="http://plychannel.com/liked">
		<div class="item">
			<img class="normal" src="http://plychannel.com/Images/Sidebar/like.png" alt="Like Videos" />
			<img class="hover" style="display:none;" src="http://plychannel.com/Images/Sidebar/like_active.png" alt="Like Videos" />
			Liked Videos
		</div>
	</a>
	<div class="seperator"></div>
	<a href="#"><div class="label">Subscriptions</div></a>

<?php
		$subs = mysql_query("SELECT * FROM `subscriptions` WHERE `Username` = '$user' LIMIT 10");
		while ($row = mysql_fetch_array($subs))
		{
?>
			<a href="http://plychannel.com/channel/<?php echo $row['Subscribed']; ?>">
				<div class="item">
					<img class="normal" style="width:15px;height:15px;opacity:0.4;filter:alpha(opacity=40); /* For IE8 and earlier */" src="http://plychannel.com/Images/author?u=<?php echo $row['Subscribed']; ?>" alt="user thumb" />
					<img class="hover" style="display:none;width:15px;height:15px;" src="http://plychannel.com/Images/author?u=<?php echo $row['Subscribed']; ?>" alt="user thumb" />
					<?php if (strlen($row['Subscribed']) < 30)echo $row['Subscribed']; else substr($row['name'], 0, 28) . "..."; ?>
				</div>
			</a>
<?php
		}
?>

	<div class="seperator"></div>
	<a href="http://plychannel.com/home">
		<div class="item">
			<img class="normal" src="http://plychannel.com/Images/Sidebar/browse.png" alt="Browse Channels" />
			<img class="hover" style="display:none;" src="http://plychannel.com/Images/Sidebar/browse_active.png" alt="Browse Channels" />
			Browse Channels
		</div>
	</a>
<?php 
}
else
{
?>
	<a href="http://plychannel.com/popular">
		<div class="item">
			<img src="http://plychannel.com/Images/Sidebar/popular.png" alt="Popular" />
			Popular on Plychannel
		</div>
	</a>
	<a href="http://plychannel.com/category?c=Music">
		<div class="item">
			<img src="http://plychannel.com/Images/Sidebar/music.png" alt="Music" />
			Music
		</div>
	</a>
	<a href="http://plychannel.com/category?c=Sports">
		<div class="item">
			<img src="http://plychannel.com/Images/Sidebar/sports.png" alt="Sports" />
			Sports
		</div>
	</a>
	<a href="http://plychannel.com/category?c=Gaming">
		<div class="item">
			<img src="http://plychannel.com/Images/Sidebar/gaming.png" alt="Gaming" />
			Gaming
		</div>
	</a>
	<a href="http://plychannel.com/category?c=Education">
		<div class="item">
			<img src="http://plychannel.com/Images/Sidebar/education.png" alt="Education" />
			Education
		</div>
	</a>
	<a href="http://plychannel.com/category?c=Movies">
		<div class="item">
			<img src="http://plychannel.com/Images/Sidebar/movies.png" alt="Movies" />
			Movies
		</div>
	</a>
	<a href="http://plychannel.com/category?c=TV Shows & Drama">
		<div class="item">
			<img src="http://plychannel.com/Images/Sidebar/tvshows.png" alt="TV Show" />
			TV Shows
		</div>
	</a>
	<div class="seperator"></div>
	<a href="http://plychannel.com/signin">
		<div class="Button" style="width: 50px;margin-left: 30px;">Sign in</div>
	</a>
<?php
}
?>
</div>

<?php
if (!isset($_COOKIE['accept-cookies']) && !isset($_GET['accept-cookies']))
{
	$new_query_string = http_build_query($_GET);
	if ($new_query_string != "")
		$new_query_string .= "&";
?>
	<div style="width: 900px;
	margin-left: auto;
	margin-right: auto;
	height: 50px;
	background-color: #fff;
	margin-bottom: 5px;
	border: solid 1px #ccc;
	padding: 30px 30px;
	text-align: center;">
	We use cookies on this website. By using this website, we'll assume you consent to the cookies we set.<br />
	<a href="?<?php echo $new_query_string; ?>accept-cookies"><button type="button" class="Button" style="margin-right: 670px;">Ok</button></a>
	</div>
<?php
}
?>