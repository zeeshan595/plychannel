<?php
require_once("PHP/connect.php"); 
$p = strip_tags(trim($_GET['p']));
$p = decrypt(urldecode($p));
$pQuery = mysql_query("SELECT * FROM `playlists` WHERE `id` = '$p' LIMIT 1");
if (mysql_num_rows($pQuery) == 0)
	header("Location: http://plychannel.com/404");
$pQuery = mysql_fetch_array($pQuery);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Traditional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-traditional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="Styles/toolbar.css" type="text/css" rel="stylesheet" />
		<link href="Styles/page.css" type="text/css" rel="stylesheet" />
		<title><?php echo $pQuery['name']; ?> Playlist - Plychannel</title>
	</head>

	<body>
		
		<?php require_once("PHP/toolbar.php"); ?>
		<?php
			$pName = $pQuery['name'];
			$pDescription = $pQuery['description'];
			$pOwner = $pQuery['owner'];
		?>

		<div class="content">
			<div class="section">
			    <h3><?php echo $pName; ?></h3>
			    <div style="font-size: 12px;color: #7E7E7E;font-weight: bold;margin-bottom: -5px;">by <?php echo $pOwner; ?></div>
			    <p style="font-size: 13px;"><?php echo $pDescription; ?></p>
<?php
				$query = mysql_query("SELECT `videoID` FROM `playlist_videos` WHERE `playlistID` = '$p' ORDER BY `videoNumber` ASC LIMIT 1");
			    $query = mysql_fetch_array($query);
?>
			    <a href="watch?v=<?php echo urlencode(encrypt($query[0])); ?>&p=<?php echo urlencode(encrypt($p)); ?>" class="greyButton" style="padding: 5px 10px;">Play</a>
<?php
		    	if (isset($_COOKIE['Username']) && $pOwner == $user)
		    	{
?>
					<a href="?p=<?php echo $_GET['p']; ?>&amp;edit=1" class="greyButton" style="padding: 5px 10px;">Edit</a>
<?php
		    	}
?>
			    <div class="seperator"></div>
<?php
				$query = mysql_query("SELECT `videoID` FROM `playlist_videos` WHERE `playlistID` = '$p' ORDER BY `videoNumber` ASC");
				while($row = mysql_fetch_array($query))
				{
					$getVideo = mysql_query("SELECT * FROM `videos` WHERE `Uploaded` = '1' AND `ID` = '".$row[0]."' LIMIT 1");
					$getVideo = mysql_fetch_array($getVideo);
?>
				<a href="watch?v=<?php echo urlencode(encrypt($getVideo['ID'])); ?>">
				    <div class="videoThumb">
						<img src="http://plychannel.com/Images/video?i=<?php echo urlencode(encrypt($getVideo['ID'])); ?>" alt="Thumbnail" />
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