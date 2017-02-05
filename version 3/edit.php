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
			input[type=text]{
				display: block;
				font-size: 14px;
				padding: 5px 10px;
				width: 384px;
			}
			.videoUpload{
				padding: 5px;
				margin-bottom: 10px;
			}
		</style>
	</head>

	<body>
		
		<?php require_once("PHP/toolbar.php"); ?>
		<?php require_once("PHP/connect.php"); ?>

		<div class="content">
			<h3>Edit</h3>
<?php
		$editingVideos = mysql_query("SELECT * FROM `videos` WHERE `Author` = '$user' ORDER BY `Time` DESC LIMIT ".($p * 50).", 50");
		while($row = mysql_fetch_array($editingVideos))
		{
			if (isset($_POST['checker_' . $row['ID']]))
			{
				$newid = $row['ID'];
				$title = $row['Title'];
				$description = $row['Description'];
				$tags = $row['Tags'];
				$privacy = $row['Privacy'];
				$comments = $row['Comments'];
				$Category = $row['Category'];
?>
				<div class="videoUpload" id="videoUpload" number="<?php echo $newid; ?>">
					<div style="display: inline-block;">
						<div id="background" number="<?php echo $newid; ?>" style="width: 295px;height: 150px;background: #eee; background: url('Uploads/<?php echo $newid; ?>.jpg'); background-size: 100% 100%;"><div id="refreshImage" number="<?php echo $newid; ?>" class="greyButton">Refresh</div></div>
					</div>
					<div style="display: inline-block;vertical-align: top;">
						<input number="<?php echo $newid; ?>" type="text" placeholder="Title" id="title" value="<?php echo $title; ?>" />
						<textarea number="<?php echo $newid; ?>" id="description" style="height: 70px;width: 384px;resize: none; padding: 5px 10px;" placeholder="Description" maxlength="500"><?php echo $description; ?></textarea>
						<input number="<?php echo $newid; ?>" type="text" placeholder="Tags" id="tags" value="<?php echo $tags; ?>" />
					</div>
					<div style="display: inline-block;vertical-align: top;">
						<input number="<?php echo $newid; ?>" type="checkbox" id="allowComments" <?php if ($comments == '1') echo "checked"; ?>/>Allow Comments.
						<br />
						<select number="<?php echo $newid; ?>" id="category">
<?php
							$getcat = mysql_query("SELECT `cat` FROM `categories`");
							while($catRow = mysql_fetch_array($getcat))
							{
								$cat = $catRow[0];
								echo "<option value='$cat' ";

								if ($Category == $cat)
									echo "selected";

								echo ">$cat</option>";
							}
?>
						</select>
						<br />
						<select number="<?php echo $newid; ?>" id="privacy">
							<option value="a" <?php if ($privacy == 'a') echo "selected"; ?>>Public</option>
							<option value="u" <?php if ($privacy == 'u') echo "selected"; ?>>Unlisted</option>
							<option value="p" <?php if ($privacy == 'p') echo "selected"; ?>>Private</option>
						</select>
						<br />
						<p style="font-size: 12px; width: 230px;font-weight: bold;color: #999;"><a target="_blank" href="http://plychannel.com/watch?v=<?php echo encrypt($newid); ?>">http://plychannel.com/watch?v=<?php echo encrypt($newid); ?></a></p>
					</div>
				</div>
				<div class="seperator" style="margin-bottom: 15px;"></div>
<?php
			}
		}
?>
		</div>

		<?php require_once("PHP/footer.php"); ?>
		<!-- JS -->
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script type="text/javascript" src="Javascript/toolbar.js"></script>
		<script type="text/javascript">
			$("[id=refreshImage]").each(function(){
				$(this).click(function(){
					var id = $(this).attr("number");
					$.ajax({
					    url: "PHP/updateVideoImage.php",
					    type: 'post',
					    data: { id:id },
					    success: function(data){
					    	console.log(data);
					    	$("[id=background]").each(function(){
					    		if ($(this).attr("number") == id)
					    		{
					    			$(this).css("background", "url('Uploads/"+id+".jpg') 100% 100%");
					    		}
					    	});
					    }
					});
				});
			});

		  $("[id=title]").each(function(){
		    $(this).change(function(){
		      var id = $(this).attr("number");
		      var data = $(this).val();
		      var type = "title";
		      saveVideoInfo(id, type, data);
		    });
		  });

		  $("[id=description]").each(function(){
		    $(this).change(function(){
		      var id = $(this).attr("number");
		      var data = $(this).val();
		      var type = "description";
		      saveVideoInfo(id, type, data);
		    });
		  });

		  $("[id=tags]").each(function(){
		    $(this).change(function(){
		      var id = $(this).attr("number");
		      var data = $(this).val();
		      var type = "tags";
		      saveVideoInfo(id, type, data);
		    });
		  });

		  $("[id=category]").each(function(){
		    $(this).change(function(){
		      var id = $(this).attr("number");
		      var data = $(this).val();
		      var type = "category";
		      saveVideoInfo(id, type, data);
		    });
		  });

		  $("[id=privacy]").each(function(){
		    $(this).change(function(){
		      var id = $(this).attr("number");
		      var data = $(this).val();
		      var type = "privacy";
		      saveVideoInfo(id, type, data);
		    });
		  });

		  $("[id=allowComments]").each(function(){
		    $(this).change(function(){
		      var id = $(this).attr("number");
		      var data = $(this).is(':checked');
		      var type = "comments";
		      saveVideoInfo(id, type, data);
		    });
		  });

			function saveVideoInfo(id, type, data)
			{
			  $.ajax({
			    url: "PHP/updateVideoDetails.php",
			    type: 'post',
			    data: { id:id, type: type, data: data },
			    success: function(data){
			    }
			  });
			}
		</script>
	</body>
</html>