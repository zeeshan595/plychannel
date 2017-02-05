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
		<?php
			require_once("PHP/connect.php"); 
			$cat = strip_tags(trim($_GET['c']));

			$totalVideos = mysql_query("SELECT COUNT(`ID`) FROM `videos` WHERE  `Uploaded` = '1' AND `Privacy` = 'a' LIMIT 1");
			$totalVideos = mysql_fetch_array($totalVideos);
			$totalVideos = $totalVideos[0];
		?>
		<input type="hidden" value="<?php echo $cat; ?>" id="category" />
		<input type="hidden" value="<?php echo $totalVideos; ?>" id="totalVideos" />
		<div class="content">
			<div class="section">
			    <h3><?php echo $cat; ?></h3>
<?php
				$query = mysql_query("SELECT * FROM `videos` WHERE  `Uploaded` = '1' AND `Privacy` = 'a' ORDER BY `Time` ASC LIMIT 50");
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
				    	<div class="videoDate"><?php echo timeToString($row['Time']); ?> ago</div>
				    </div>
				</a>
<?php
				}
?>
			</div>
			<div style="margin-left: auto;margin-right: auto;width: 62px;display: block;" class="greyButton" id="loader">Load More</div>
		</div>


		<?php require_once("PHP/footer.php"); ?>
		<!-- JS -->
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script type="text/javascript" src="Javascript/toolbar.js"></script>
		<script type="text/javascript">
			var amount = 50;
			$("#loader").click(function(){
				$.ajax({
					url: "PHP/getMoreCategories.php",
					type: 'post',
					data: { start: amount, category: $("#category").val() },
					success: function(data){
						console.log(data);
						amount += 50;
						$(".section").append(data);
						if ($("#totalVideos").val() <= amount)
							$("#loader").css("display", "none");
					}
				});
			});
		</script>
	</body>
</html>