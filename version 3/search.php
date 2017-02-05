<?php

	if (!isset($_GET['s']))
		header("Location: index");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Traditional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-traditional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="Styles/toolbar.css" type="text/css" rel="stylesheet" />
		<link href="Styles/page.css" type="text/css" rel="stylesheet" />
		<title>Search - Plychannel</title>
	</head>

	<body>
		<?php require_once("PHP/toolbar.php"); ?>
		<?php
			require_once("PHP/connect.php"); 
			$search = stripcslashes(trim($_GET['s']));
		?>

		<div class="content">
			<h3>Search results for '<?php echo $search; ?>'</h3>
			<div class="section">
<?php
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
				$query = mysql_query("SELECT * FROM `videos` WHERE (`Uploaded` = '1' AND `Privacy` = 'a' AND `ID` != '$id') $s ORDER BY CASE $o ELSE 3 END LIMIT 7");
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