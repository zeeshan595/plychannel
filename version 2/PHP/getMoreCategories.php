<?php
	if (!isset($_POST['start']) || !isset($_POST['category']))
		die("No Args");
	
	require_once('connect.php');
	$start = strip_tags(trim($_POST['start']));
	$category = strip_tags(trim($_POST['category']));

	$query = mysql_query("SELECT `Title`, `Description`, `ID`, `Views`, `Time` FROM `videos` WHERE `Category` = '".mysql_real_escape_string($category)."' AND `Uploaded` = '1' AND `Privacy` = 'a' ORDER BY `Time` ASC LIMIT $start, 50");
	echo mysql_error();
	while($row = mysql_fetch_array($query))
	{
?>
	<a href="http://plychannel.com/watch?v=<?php echo urlencode(encrypt($row['ID'])); ?>">
	    <div class="videoThumb">
			<img src="http://plychannel.com/Images/video?i=<?php echo urlencode(encrypt($row['ID'])); ?>" alt="Thumbnail" />
				<div class="videoTitle" style="word-wrap:break-word;"><?php if (strlen($row['Title']) < 38) echo $row['Title']; else echo substr($row['Title'], 0, 35) . "..."; ?></div>
			<span>By <?php echo $author; ?></span><span style="text-align: right;"><?php echo number_format($row['Views']); ?> views</span>
	    	<div class="videoDate"><?php echo timeToString($row['Time']); ?> ago</div>
	    </div>
	</a>
<?php
	}
?>