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

		<div class="content">
			<a href="popular">
				<h3>Featured Videos</h3>
			</a>
<?php
			$popularVideos = mysql_query("SELECT * FROM `videos` WHERE `Uploaded` = '1' AND `Privacy` = 'a' ORDER BY rand() LIMIT 7");
			while ($row = mysql_fetch_array($popularVideos))
			{
				if (!isset($doneFeatured))
				{
?>
				<a href="watch?v=<?php echo urlencode(encrypt($row['ID'])); ?>">
					<div style="display:inline-block; padding: 5px; width: 500px; height: 500px; vertical-align: top;">
						<img style="width: 500px; height: 410px;" src="http://plychannel.com/Images/video?i=<?php echo urlencode(encrypt($row['ID'])); ?>" alt="Thumbnail" />
						<div style="height:0; width: 0;">
							<div style="position: relative;top: -415px;font-size: 14px;color: #fff;background: rgba(0, 0, 0, 0.7);padding: 1px 2px;display: inline-block;"><?php echo $row['Length']; ?></div>
						</div>
						<div style="font-size: 15px;font-weight: bold;color: #000; word-wrap:break-word;"><?php if (strlen($row['Title']) < 38) echo $row['Title']; else echo substr($row['Title'], 0, 35) . "..."; ?></div>
						<span style="color: #555;font-size: 13px;margin-right: 10px;">By <?php echo $row['Author']; ?></span>
						<span style="color: #000;font-size: 13px;margin-right: 10px;"><?php echo number_format($row['Views']); ?> views</span>
				    	<span style="color: #555;font-size: 13px;margin-right: 10px;"><?php echo timeToString($row['Time']); ?></span>
					</div>
				</a>
					<div style="display:inline-block; padding: 5px; width: 425px;">
<?php
					$doneFeatured = true;
				}
				else
				{
?>
				<a href="watch?v=<?php echo urlencode(encrypt($row['ID'])); ?>">
					<div>
						<img style="display:inline-block; width: 100px; height: 75px;" src="http://plychannel.com/Images/video?i=<?php echo urlencode(encrypt($row['ID'])); ?>" alt="Thumbnail" />
						<div style="height:0; width: 0; display:inline-block;">
							<div style="position: relative;left: -104px;top: -64px;font-size: 10px;color: #fff;background: rgba(0, 0, 0, 0.7);padding: 1px 2px;display: inline-block;"><?php echo $row['Length']; ?></div>
						</div>
						<div style="display: inline-block; width:300px; vertical-align: top;">
							<div style="font-size: 15px;font-weight: bold;color: #000; word-wrap:break-word;"><?php if (strlen($row['Title']) < 38) echo $row['Title']; else echo substr($row['Title'], 0, 35) . "..."; ?></div>
							<span style="color: #555;font-size: 13px;margin-right: 10px;">By <?php echo $row['Author']; ?></span>
							<span style="color: #000;font-size: 13px;margin-right: 10px;"><?php echo number_format($row['Views']); ?> views</span>
					    	<div style="color: #555;font-size: 13px;margin-right: 10px;"><?php echo timeToString($row['Time']); ?></div>
						</div>
					</div>
				</a>
<?php
				}
			}
?>
			</div>
			<div class="seperator"></div>
			<div class="section">
			    <a href="uploads">
			    	<h3>New Uploads</h3>
			    </a>
<?php
				$query = mysql_query("SELECT * FROM `videos` WHERE  `Uploaded` = '1' AND `Privacy` = 'a' ORDER BY `Time` DESC LIMIT 10");
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
			    <a href="category?c=Entertainment">
			    	<h3>Entertainment</h3>
			    </a>
<?php
				$query = mysql_query("SELECT * FROM `videos` WHERE  `Uploaded` = '1' AND `Privacy` = 'a' AND `Category` = 'Entertainment' ORDER BY rand() LIMIT 10");
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
			    <a href="category?c=Music">
			    	<h3>Music</h3>
			    </a>
<?php
				$query = mysql_query("SELECT * FROM `videos` WHERE  `Uploaded` = '1' AND `Privacy` = 'a' AND `Category` = 'Music' ORDER BY rand() LIMIT 5");
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
				<a href="category?c=Sports">
			    	<h3>Sports</h3>
			    </a>
<?php
				$query = mysql_query("SELECT * FROM `videos` WHERE  `Uploaded` = '1' AND `Privacy` = 'a' AND `Category` = 'Sports' ORDER BY rand() LIMIT 5");
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
				<a href="category?c=Sports">
				    <h3>Gaming</h3>
				</a>
<?php
				$query = mysql_query("SELECT * FROM `videos` WHERE  `Uploaded` = '1' AND `Privacy` = 'a' AND `Category` = 'Gaming' ORDER BY rand() LIMIT 5");
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
				<a href="category?c=Education">
				    <h3>Education</h3>
				</a>
<?php
				$query = mysql_query("SELECT * FROM `videos` WHERE  `Uploaded` = '1' AND `Privacy` = 'a' AND `Category` = 'Education' ORDER BY rand() LIMIT 5");
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
				<a href="category?c=Movies">
				    <h3>Movies</h3>
				</a>
<?php
				$query = mysql_query("SELECT * FROM `videos` WHERE  `Uploaded` = '1' AND `Privacy` = 'a' AND `Category` = 'Movies' ORDER BY rand() LIMIT 5");
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
				<a href="category?c=TV Shows & Drama">
				    <h3>TV Shows</h3>
				</a>
<?php
				$query = mysql_query("SELECT * FROM `videos` WHERE  `Uploaded` = '1' AND `Privacy` = 'a' AND `Category` = 'TV Shows & Drama' ORDER BY rand() LIMIT 5");
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
				<a href="">
				    <h3>Other</h3>
				</a>
<?php
				$query = mysql_query("SELECT * FROM `videos` WHERE  `Uploaded` = '1' AND `Privacy` = 'a' AND `Category` = 'Comedy' OR `Category` = 'Science & Technology' OR `Category` = 'Politics' OR `Category` = 'Health & Beauty' OR `Category` = 'Recipes & Baking' OR `Category` = 'Religious' OR `Category` = 'Travel & Events' ORDER BY rand() LIMIT 20");
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
		</div>

		<?php require_once("PHP/footer.php"); ?>
		<!-- JS -->
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script type="text/javascript" src="Javascript/toolbar.js"></script>
	</body>
</html>