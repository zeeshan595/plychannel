<?php
	if (!isset($_POST['start']) || !isset($_POST['author']))
		die("No Args");
	
	require_once('connect.php');
	$start = strip_tags(trim($_POST['start']));
	$author = strip_tags(trim($_POST['author']));

	$query = mysql_query("SELECT `Title`, `Description`, `ID`, `Views`, `Time` FROM `videos` WHERE `Author` = '$author' AND `Uploaded` = '1' AND `Privacy` = 'a' ORDER BY `Time` DESC LIMIT $start, 50");
	echo mysql_error();
	while($row = mysql_fetch_array($query))
	{
?>
	<a href="http://plychannel.com/watch?v=<?php echo urlencode(encrypt($row['ID'])); ?>">
	    <div class="videoThumb">
			<img src="http://plychannel.com/Images/video?i=<?php echo urlencode(encrypt($row['ID'])); ?>" alt="Thumbnail" />
				<div class="videoTitle" style="word-wrap:break-word;"><?php if (strlen($row['Title']) < 38) echo $row['Title']; else echo substr($row['Title'], 0, 35) . "..."; ?></div>
			<span>By <?php echo $author; ?></span><span style="text-align: right;"><?php echo number_format($row['Views']); ?> views</span>
	    	<div class="videoDate"><?php echo timeToString($row['Time']); ?></div>
	    </div>
	</a>
<?php
	}
?>