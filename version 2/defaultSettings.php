<?php

if (!isset($_COOKIE['Username']))
	header("Location: http://plychannel.com/login?feature=http://plychannel.com/settings");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Traditional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-traditional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="Styles/toolbar.css" type="text/css" rel="stylesheet" />
		<link href="Styles/page.css" type="text/css" rel="stylesheet" />
		<title>Settings - Plychannel</title>
		<style type="text/css">
			.topBar{
				box-shadow: 2px 2px 10px rgba(0,0,0,.1);
				background: #fff;
				padding: 5px 10px;
				width: 950px;
				margin-left: auto;
				margin-right: auto;
				margin-bottom: 15px;
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
			.content input{
				font-size: 18px;
				width: 500px;
				margin-bottom: 10px;
			}
		</style>
	</head>

	<body>
		
		<?php require_once("PHP/toolbar.php"); ?>

		<div class="topBar">
			<h3>Settings</h3>
			<div class="navBar">
				<a href="settings"><div>General</div></a>
				<a href="personalSettings"><div>Personal</div></a>
				<div style="border-bottom: #ff0000 3px solid;opacity: 1;filter: alpha(opacity=100);">Defaults</div>
			</div>
		</div>

<?php


		require_once("PHP/connect.php");
		$settings = mysql_query("SELECT * FROM `users` WHERE `Username` = '$user' LIMIT 1");
		$settings = mysql_fetch_array($settings);

		$channelName = $settings['ChannelName'];
		$about = $settings['About'];
		$website = $settings['website'];
		$twitter = $settings['twitter'];
		$facebook = $settings['facebook'];
		$google = $settings['googleplus'];
?>

		<div class="content">
			
			<input style="width:100px" class="greyButton" type="submit" value="Save" />
		</div>

		<?php require_once("PHP/footer.php"); ?>
		<!-- JS -->
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script type="text/javascript" src="Javascript/toolbar.js"></script>
	</body>
</html>