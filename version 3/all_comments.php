<?php require_once("PHP/connect.php"); ?>

<?php
if (isset($_GET['v']))
{
	$id = decrypt(urldecode($_GET['v']));
	$encid = urlencode(encrypt($id));

	$check = mysql_query("SELECT * FROM `videos` WHERE `ID` = '$id' LIMIT 1");
	$exists = (mysql_num_rows($check) != 0);
	if ($exists)
	{
		$query = mysql_fetch_array($check);
		$comm = mysql_query("SELECT * FROM `comments` WHERE `videoID` = '$id' AND `parent` = '0' ORDER BY `time` DESC LIMIT 300");
	}
	else
	{
		header("Location: http://plychannel.com/404");
	}
}
else
{
	header("Location: http://plychannel.com/404");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Traditional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-traditional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="Styles/toolbar.css" type="text/css" rel="stylesheet" />
		<link href="Styles/page.css" type="text/css" rel="stylesheet" />
		<link href="Styles/watch.css" type="text/css" rel="stylesheet" />
		<title>All comments on <?php echo $query['Title']; ?> - Plychannel</title>
	
		<style type="text/css">
			.moreComms{
				position: absolute;
				display: none;
				background: url('../Images/moreComments.png');
				background-size: 100%;
				width: 13px;
				height: 13px;
				right: 10px;
			}
			.moreComms:hover{
				cursor: pointer;
				cursor: hand;
			}
			.replyButton{
				font-size: 13px;
				font-weight: bold;
				color: #999;
				text-decoration: none;
			}
			.replyButton:hover{
				text-decoration: underline;
				cursor: pointer;
				cursor: hand;
			}

			.dropDown{
				background-color: #fff;
				font-size: 15px;
				padding: 10px 15px;
			}
			.dropDown:hover{
				background-color: #F5F5F5;
				cursor: pointer;
				cursor: hand;
			}
		</style>
	</head>

	<body>
		
		<?php require_once("PHP/toolbar.php"); ?>

		<div class="content">
<?php
			while($row = mysql_fetch_array($comm))
			{
?>
				<div id="comment" number="<?php echo $row['id']; ?>" style="margin-bottom: 15px;">
					<div style="display: inline-block;width:50px;height:50px;background: url('http://plychannel.com/Images/author?u=<?php echo $row['author']; ?>'); background-size: 100%;"></div>
					<div style="display: inline-block;">
						<span style="font-size: 14px;font-weight: bold;color: #000000;"><?php echo $row['author']; ?></span>
						<span style="margin-left: 15px;font-size: 12px;color: #999;font-weight: bold;"><?php echo timeToString($row['time']); ?> ago</span>
						<div id="droper" number="<?php echo $row['id']; ?>" class="moreComms"></div>
						<div id="dropDown_<?php echo $row['id']; ?>" style="display:none;position: absolute;right: 10px;margin-top: 15px;z-index: 10;background-color: #fff;border: solid 1px #ccc;padding: 5px 0px;">
							<div class="dropDown">Report spam or abuse</div>
<?php
							if (isset($_COOKIE['Username']))
							{
								if ($user == $row['author'])
								{
?>
									<div class="dropDown">Delete this comment</div>
<?php
								}
							}		
?>
						</div>
						<div><?php echo $row['message']; ?></div>
						<div style="margin-top:10px;">
							<span class="replyButton">Reply</span>
						</div>
					</div>
				</div>
<?php
			}
?>
		</div>

		<?php require_once("PHP/footer.php"); ?>
		<!-- JS -->
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script type="text/javascript" src="Javascript/toolbar.js"></script>
	<script type="text/javascript">
		$("html", window.parent.document).click(function(){
			$("[id=droper]").each(function(){
				var number = $(this).attr("number");
				if ($(this).css("display") == "none")
					$("#dropDown_" + number).css("display" , "none");
			});
		});

		$("html").click(function(){
			$("[id=droper]").each(function(){
				var number = $(this).attr("number");
				if ($(this).css("display") == "none")
					$("#dropDown_" + number).css("display" , "none");
			});
		});

		$("[id=droper]").each(function(){
			$(this).click(function(){
				var number = $(this).attr("number");
				if ($("#dropDown_" + number).css("display") == "block")
					$("#dropDown_" + number).css("display" , "none");
				else
					$("#dropDown_" + number).css("display", "block");
			});
		});

		$("[id=comment]").each(function(){
			$(this).mouseenter(function(){
				var number = $(this).attr("number");
				$("[id=droper]").each(function(){
					if ($(this).attr("number") == number)
					{
						$(this).css("display" , "inline-block");
					}
				});
			});
			$(this).mouseleave(function(){
				var number = $(this).attr("number");
				$("[id=droper]").each(function(){
					if ($(this).attr("number") == number)
					{
						$(this).css("display" , "none");
					}
				});
			});
		});
	</script>
	</body>
</html>