<?php
	if (!isset($_COOKIE['Username']))
		header("Location: http://plychannel.com/signin?feature=http://plychannel.com/history");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Traditional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-traditional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="Styles/toolbar.css" type="text/css" rel="stylesheet" />
		<link href="Styles/page.css" type="text/css" rel="stylesheet" />
		<title>History - Plychannel</title>
	</head>

	<body>
		
		<?php require_once("PHP/toolbar.php"); ?>
		<?php require_once("PHP/connect.php"); ?>

		<div class="content">
			<div class="section">
			    <h3>History</h3>
			    <a href="?clear" class="greyButton">Clear History</a>
			    <div class="seperator"></div>
<?php
				if (isset($_GET['clear']))
					mysql_query("DELETE FROM `userhistory` WHERE `username` = '$user'");

				$query = mysql_query("SELECT `videoID` FROM `userhistory` WHERE `username` = '$user' ORDER BY `time` DESC LIMIT 50");
				while($row = mysql_fetch_array($query))
				{
					$getVideo = mysql_query("SELECT * FROM `videos` WHERE `Uploaded` = '1' AND `ID` = '".$row[0]."' LIMIT 1");
					$getVideo = mysql_fetch_array($getVideo);
?>
				<a href="watch?v=<?php echo urlencode(encrypt($getVideo['ID'])); ?>">
				    <div class="videoThumb">
						<img src="http://plychannel.com/Images/video?i=<?php echo urlencode(encrypt($getVideo['ID'])); ?>" alt="Thumbnail" />
						<div style="height:0; width: 0;">
							<div class="videoTime"><?php echo $row['Length']; ?></div>
						</div>
						<div class="videoTitle" style="word-wrap:break-word;"><?php if (strlen($getVideo['Title']) < 38) echo $getVideo['Title']; else echo substr($getVideo['Title'], 0, 35) . "..."; ?></div>
						<span>By <?php echo $getVideo['Author']; ?></span><span style="text-align: right;"><?php echo number_format($getVideo['Views']); ?> views</span>
				    	<div class="videoDate"><?php echo timeToString($getVideo['Time']); ?></div>
				    </div>
				</a>
<?php
				}
?>
			</div>
		</div>

		<?php require_once("PHP/footer.php"); ?>
		<!-- JS -->
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script type="text/javascript" src="Javascript/toolbar.js"></script>
	</body>
</html>