<?php
	if (!isset($_COOKIE['Username']))
		header("Location: http://plychannel.com/signin?feature=http://plychannel.com/manager");
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
			.navBar input[type=text]{
				display: block;
				font-size: 12px;
				padding: 5px 10px;
				width: 200px;
				outline: 0;
				border: solid 1px #ccc;
				margin: 0;
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
			$delVideos = mysql_query("SELECT * FROM `videos` WHERE `Author` = '$user' ORDER BY `Time` DESC LIMIT ".($p * 50).", 50");
			while ($row = mysql_fetch_array($delVideos))
			{
				if (isset($_POST['checker_' . $row['ID']]))
				{
					unlink("/var/www/" + $row['ID'] . ".jpg");
					unlink("/var/www/num" + $row['ID'] . ".mp4");
					unlink("/var/www/num" + $row['ID'] . ".webm");
					mysql_query("DELETE FROM `videos` WHERE `ID` = '".$row['ID']."' AND `Author` = '$user' LIMIT 1");
				}
			}
		}
		if (isset($_GET['s']))
			$search = strip_tags(trim($_GET['s']));

		preg_match_all("/[a-zA-Z0-9]+/", $search, $matches);
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
		if (isset($_GET['s']))
			$totalVideos = mysql_query("SELECT COUNT(`ID`) FROM `videos` WHERE (`Author` = '$user') $s LIMIT 1");
		else
			$totalVideos = mysql_query("SELECT COUNT(`ID`) FROM `videos` WHERE (`Author` = '$user') LIMIT 1");

		$totalVideos = mysql_fetch_array($totalVideos);
		$totalVideos = $totalVideos[0];
?>
		<div class="topBar">
			<h3>Video Manager <span style="background: #666;color: #f0f0f0;padding: 5px;font-size: 12px;font-weight: bold;border-radius: 3px;margin-left: 15px;box-shadow: 0 1px 2px rgba(0,0,0,.1);"><?php echo $totalVideos; ?></span></h3>
			<div class="navBar">
				<div style="border-bottom: #ff0000 3px solid;opacity: 1;filter: alpha(opacity=100);">Videos</div>
				<a href="playlistManager"><div>Playlists</div></a>
				<form action="" method="GET" style="width: 300px;display: inline-block;">
					<input type="text" name="s" placeholder="Search..." />
				</form>
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
				if (isset($_GET['s']))
					$videos = mysql_query("SELECT * FROM `videos` WHERE (`Author` = '$user') $s ORDER BY CASE $o ELSE 3 END LIMIT ".($p * 50).", 50");
				else
					$videos = mysql_query("SELECT * FROM `videos` WHERE `Author` = '$user' ORDER BY `Time` DESC LIMIT ".($p * 50).", 50");

				while($row = mysql_fetch_array($videos))
				{
?>
					<input name="checker_<?php echo $row['ID']; ?>" id="checkers" number="<?php echo $row['ID']; ?>" type="checkbox" style="margin-right: 15px; vertical-align: top; margin-top: 60px;" />
					<a href="http://plychannel.com/watch?v=<?php echo urlencode(encrypt($row['ID'])); ?>">
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
?>
									<img src="http://plychannel.com/Images/video?i=<?php echo urlencode(encrypt($row['ID'])); ?>" alt="Thumbnail" />
<?php
								}
?>
							</div>
							<div style="width: 730px; display: inline-block; vertical-align: top;">
								<div class="videoTitle" style="word-wrap:break-word;color: #000;"><?php if (strlen($row['Title']) < 50) echo $row['Title']; else echo substr($row['Title'], 0, 47) . "..."; ?></div>
								<span style="font-size: 13px; font-weight: bold; color: #999;"><?php echo timeToString($row['Time']); ?> ago</span>
						    	<div style="font-size: 12px; color: #999;" class="videoDate" style="word-wrap:break-word;color: #000;"><strong>Description:</strong> <br /><?php if (strlen($row['Description']) < 200) echo $row['Description']; else echo substr($row['Description'], 0, 197) . "..."; ?></div>
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
			for ($i = 0; $i <= ($totalVideos / 50); $i++)
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

			if ($p >= ($totalVideos / 50))
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
				var selected = false;
				$("[id=checkers]").each(function(){
					if ($(this).prop('checked'))
					{
						selected = true;
					}
				});

				if (selected)
				{
					if ($(this).val() == "e")
						$("#submittingForm").attr("action", "edit");

					$("#submittingForm").submit();
				}
				else
				{
					alert("Please select at least 1 video.");
				}
			});
		</script>
	</body>
</html>