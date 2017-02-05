<?php
	if (!isset($_COOKIE['Username']))
		header("Location: http://plychannel.com/signin?feature=http://plychannel.com/playlistManager");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Traditional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-traditional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="Styles/toolbar.css" type="text/css" rel="stylesheet" />
		<link href="Styles/page.css" type="text/css" rel="stylesheet" />
		<title>Plychannel</title>
		<style type="text/css">
			.videoThumb img{
				width: 175px;
			}
			.videoThumb{
				color: #000;
				margin-bottom: 10px;
				display: inline-block;
			}
			.videoTitle{
				font-size: 15px;
				font-weight: bold;
			}
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
		</style>
	</head>

	<body>
		
		<?php require_once("PHP/toolbar.php"); ?>
		<?php require_once("PHP/connect.php"); ?>

<?php
			if (isset($_GET['pi']))
				$p = strip_tags(trim($_GET['pi']));
			else
				$p = 0;

			if (isset($_POST['options']) && $_POST['options'] == "del")
			{
				$delPlaylists = mysql_query("SELECT * FROM `playlists` WHERE `owner` = '$user' LIMIT ".($p * 50).", 50");
				while ($row = mysql_fetch_array($delPlaylists))
				{
					if (isset($_POST['checker_' . $row['id']]))
					{
						mysql_query("DELETE FROM `playlists` WHERE `id` = '".$row['id']."' AND `owner` = '$user' LIMIT 1");
						mysql_query("DELETE FROM `playlist_videos` WHERE `playlistID` = '".$row['id']."' LIMIT 1");
					}
				}
			}
			$totalPlaylists = mysql_query("SELECT COUNT(`id`) FROM `playlists` WHERE `owner` = '$user' LIMIT 1");
			$totalPlaylists = mysql_fetch_array($totalPlaylists);
			$totalPlaylists = $totalPlaylists[0];
?>

		<div class="topBar">
			<h3>Video Manager <span style="background: #666;color: #f0f0f0;padding: 5px;font-size: 12px;font-weight: bold;border-radius: 3px;margin-left: 15px;box-shadow: 0 1px 2px rgba(0,0,0,.1);"><?php echo $totalPlaylists; ?></span></h3>
			<div class="navBar">
				<a href="manager"><div>Videos</div></a>
				<div style="border-bottom: #ff0000 3px solid;opacity: 1;filter: alpha(opacity=100);">Playlists</div>
			</div>
		</div>

		<div class="content" style="padding: 25px 10px 15px 10px;">
			<form id="submittingForm" action="" method="POST">
			<input id="allChecker" type="checkbox" style="margin-right: 15px;" />
			<select id="options" name="options">
				<option>Actions</option>
				<option value="e">Edit</option>
				<option value="del">Delete</option>
			</select>
			<div class="seperator" style="margin-bottom: 15px;"></div>
<?php
				$playlists = mysql_query("SELECT * FROM `playlists` WHERE `owner` = '$user' ORDER BY `id` DESC LIMIT ".($p * 50).", 50");
				while($row = mysql_fetch_array($playlists))
				{
?>
					<input name="checker_<?php echo $row['id']; ?>" id="checkers" encNumber="<?php echo urlencode(encrypt($row['id'])); ?>" number="<?php echo $row['id']; ?>" type="checkbox" style="margin-right: 15px; vertical-align: top; margin-top: 60px;" />
					<a href="http://plychannel.com/playlist?p=<?php echo urlencode(encrypt($row['id'])); ?>">
					    <div class="videoThumb">
					    	<div style="width: 175px; height: 131px; display: inline-block;">
<?php
								if ($row['Uploaded'] == '0')
								{
?>
									<img src="http://plychannel.com/Images/404.png" alt="Thumbnail" />
<?php
								}
								else
								{
									$plImage = mysql_query("SELECT `videoID` FROM `playlist_videos` WHERE `playlistID` = '".$row['id']."' ORDER BY rand() LIMIT 1");
									$plImage = mysql_fetch_array($plImage);
									$plImage = $plImage[0];

?>
									<img src="http://plychannel.com/Images/video?i=<?php echo urlencode(encrypt($plImage)); ?>" alt="Thumbnail" />
<?php
								}
?>
							</div>
							<div style="width: 730px; display: inline-block; vertical-align: top;">
								<div class="videoTitle" style="word-wrap:break-word;"><?php if (strlen($row['name']) < 50) echo $row['name']; else echo substr($row['name'], 0, 47) . "..."; ?></div>
						    	<div style="font-size: 12px; color: #999;" class="videoDate" style="word-wrap:break-word;"><strong>Description:</strong> <br /><?php if (strlen($row['description']) < 200) echo $row['description']; else echo substr($row['description'], 0, 197) . "..."; ?></div>
					    	</div>
					    </div>
					</a>
<?php
				}
?>				</form>
				<div style="margin-left: 35px;">
<?php
			if ($p > 0)
			{
?>
				<a href="?pi=<?php echo $p - 1; ?>"><div style="padding: 5px 10px;" class="greyButton"><< Previous</div></a>
<?php
			}
			for ($i = 0; $i <= ($totalPlaylists / 50); $i++)
			{
				if ($i == $p)
				{
?>
					<div style="background: #F0F0F0; padding: 5px 10px;" class="greyButton"><?php echo $i; ?></div>
<?php
				}
				else
				{
?>
					<a href="?pi=<?php echo $i; ?>"><div style="padding: 5px 10px;" class="greyButton"><?php echo $i; ?></div></a>
<?php
				}
			}

			if ($p >= ($totalPlaylists / 50))
			{
?>
				<a href="?pi=<?php echo $p + 1; ?>"><div style="padding: 5px 10px;" class="greyButton">Next >></div></a>
<?php				
			}
?>
			</div>
		</div>

		<?php require_once("PHP/footer.php"); ?>
		<!-- JS -->
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script type="text/javascript" src="Javascript/toolbar.js"></script>
		<script type="text/javascript">
			$("#allChecker").click(function(){
				$("[id=checkers]").each(function(){
					$(this).prop('checked', $("#allChecker").prop('checked'));
				});
			});
			$("#options").change(function(){
				var encNumber;
				var selected = 0;
				$("[id=checkers]").each(function(){
					if ($(this).prop('checked'))
					{
						selected += 1;
						encNumber = $(this).attr("encNumber");
					}
				});

				if (selected > 0)
				{
					if ($(this).val() == "e")
					{
						if (selected > 1)
						{
							alert("You can only edit 1 playlist at one time.");
						}
						else
						{
							$("#submittingForm").attr("action", "playlist?p=" + encNumber + "&edit=1");
							$("#submittingForm").submit();
						}
					}
					else
					{
						$("#submittingForm").submit();
					}
				}
				else
				{
					alert("Please select at least 1 video.");
				}
			});
		</script>
	</body>
</html>