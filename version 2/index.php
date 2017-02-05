<?php
	if (!isset($_COOKIE['Username']))
		header("Location: home");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Traditional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-traditional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="Styles/toolbar.css" type="text/css" rel="stylesheet" />
		<link href="Styles/page.css" type="text/css" rel="stylesheet" />
		<title>Plychannel</title>
	</head>

	<body>
		
		<?php require_once("PHP/toolbar.php"); ?>
		<?php require_once("PHP/connect.php"); ?>

		<div class="content" style="min-height: 50px;margin-bottom: 15px;">
			<h4>Currently we are working on playlists, settings and subscription. Please be patient</h4>
		</div>

		<div class="content">
		  <div class="section">
		    <h3>Recomended</h3>
<?php
			$query = mysql_query("SELECT * FROM `videos` WHERE `videos`.`ID` NOT IN (SELECT * FROM (SELECT `userhistory`.`videoID` FROM `userhistory` WHERE `userhistory`.`username` = '$user' ORDER BY `userhistory`.`time` desc limit 50) as t) AND `Uploaded` = '1' ORDER BY `Views` DESC,rand() LIMIT 10");
			echo mysql_error();
			while($row = mysql_fetch_array($query))
			{
?>
			<a href="watch?v=<?php echo urlencode(encrypt($row['ID'])); ?>">
			    <div class="videoThumb">
					<img src="http://plychannel.com/Images/video?i=<?php echo urlencode(encrypt($row['ID'])); ?>" alt="Thumbnail" />
					<div style="height:0; width: 0;">
						<div class="videoTime"><?php echo $row['Length']; ?></div>
					</div>
					<div class="videoTitle" style="word-wrap:break-word;"><?php if (strlen($row['Title']) < 38) echo $row['Title']; else echo substr($row['Title'], 0, 35) . "..."; ?></div>
					<span>By <?php echo $row['Author']; ?></span><span style="text-align: right;"><?php echo number_format($row['Views']); ?> views</span>
			    	<div class="videoDate"><?php echo timeToString($row['Time']); ?></div>
			    </div>
			</a>
<?php
			}
?>
			</div>
			<div class="seperator"></div>
			<div class="section">
		    <h3>Watch it again</h3>
<?php
			$query = mysql_query("SELECT * FROM `videos` WHERE `videos`.`ID` IN (SELECT * FROM (SELECT `userhistory`.`videoID` FROM `userhistory` WHERE `userhistory`.`username` = '$user' ORDER BY rand() LIMIT 50) as t) AND `Uploaded` = '1' ORDER BY rand() LIMIT 5");
			echo mysql_error();
			while($row = mysql_fetch_array($query))
			{
?>
			<a href="watch?v=<?php echo urlencode(encrypt($row['ID'])); ?>">
			    <div class="videoThumb">
					<img src="http://plychannel.com/Images/video?i=<?php echo urlencode(encrypt($row['ID'])); ?>" alt="Thumbnail" />
					<div style="height:0; width: 0;">
						<div class="videoTime"><?php echo $row['Length']; ?></div>
					</div>
					<div class="videoTitle" style="word-wrap:break-word;"><?php if (strlen($row['Title']) < 38) echo $row['Title']; else echo substr($row['Title'], 0, 35) . "..."; ?></div>
					<span>By <?php echo $row['Author']; ?></span><span style="text-align: right;"><?php echo number_format($row['Views']); ?> views</span>
			    	<div class="videoDate"><?php echo timeToString($row['Time']); ?></div>
			    </div>
			</a>
<?php
			}
?>
			</div>
<?php
			$query = mysql_query("SELECT * FROM `subscriptions` WHERE `Username` = '$user' ORDER BY `Order` DESC LIMIT 10");
			echo mysql_error();
			while($rows = mysql_fetch_array($query))
			{
?>
				<div class="seperator"></div>
				<div class="section">
				<a href="http://plychannel.com/channel/<?php echo $rows['Subscribed']; ?>">
		   			<h3><img width="20px" src="http://plychannel.com/Images/author?u=<?php echo $rows['Subscribed']; ?>" alt="Thumb" /><?php echo $rows['Subscribed']; ?></h3>
		   		</a>
<?php
				$query = mysql_query("SELECT * FROM `videos` WHERE `videos`.`ID` NOT IN (SELECT * FROM (SELECT `userhistory`.`videoID` FROM `userhistory` ORDER BY `userhistory`.`time` desc limit 50) as t) AND `Uploaded` = '1' AND `videos`.`Author` = '".$rows['Subscribed']."' ORDER BY `ID` DESC,rand() LIMIT 10");
				echo mysql_error();
				while($row = mysql_fetch_array($query))
				{
?>
					<a href="watch?v=<?php echo urlencode(encrypt($row['ID'])); ?>">
					    <div class="videoThumb">
							<img src="http://plychannel.com/Images/video?i=<?php echo urlencode(encrypt($row['ID'])); ?>" alt="Thumbnail" />
						<div style="height:0; width: 0;">
							<div class="videoTime"><?php echo $row['Length']; ?></div>
						</div>
						<div class="videoTitle" style="word-wrap:break-word;"><?php if (strlen($row['Title']) < 38) echo $row['Title']; else echo substr($row['Title'], 0, 35) . "..."; ?></div>
							<span>By <?php echo $row['Author']; ?></span><span style="text-align: right;"><?php echo number_format($row['Views']); ?> views</span>
					    	<div class="videoDate"><?php echo timeToString($row['Time']); ?></div>
					    </div>
					</a>
<?php
				}
?>
				</div>
<?php
			}
?>
		  </div>

		<?php require_once("PHP/footer.php"); ?>
		<!-- JS -->
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script type="text/javascript" src="Javascript/toolbar.js"></script>
	</body>
</html>