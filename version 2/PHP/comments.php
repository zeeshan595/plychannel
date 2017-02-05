<html>

	<head>
		<style type="text/css">
			body{
				font-family: sans-serif;
			}
			a{
				text-decoration: none;
			}
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
			#replyButton{
				font-size: 13px;
				font-weight: bold;
				color: #999;
				text-decoration: none;
			}
			#replyButton:hover{
				text-decoration: underline;
				cursor: pointer;
				cursor: hand;
			}

			.dropDown{
				background-color: #fff;
				font-size: 15px;
				padding: 10px 15px;
				color: #000;
				text-decoration: none;
			}
			.dropDown:hover{
				background-color: #F5F5F5;
				cursor: pointer;
				cursor: hand;
			}
			.Button{
				background-color: #FE563B;
				border: 0;
				padding: 10px;
				color: #fff;
				font-size: 13px;
				font-weight: bold;
				border-radius: 3px;
			}

			.Button:hover{
				background-color: #E64F37;
				cursor: pointer;
				cursor: hand;
			}
			#replyCloser{
				position: absolute;
				margin-left: 642px;
				margin-top: -107px;
			}
			#replyCloser:hover{
				cursor: pointer;
				cursor: hand;
			}
			.commentLike{
				display: inline-block;
				background: url("../Images/like_small.png");
				background-size: 100%;
				width: 11px;
				height: 11px;
				opacity: 0.4;
    			filter: alpha(opacity=40); /* For IE8 and earlier */
			}
			.commentLike:hover{
				opacity: 1;
    			filter: alpha(opacity=100); /* For IE8 and earlier */
    			cursor: pointer;
				cursor: hand;
			}
			.commentLiked{
				display: inline-block;
				background: url("../Images/like_small.png");
				background-size: 100%;
				width: 11px;
				height: 11px;
				opacity: 1;
    			filter: alpha(opacity=100); /* For IE8 and earlier */
			}
			.commentDisike{
				display: inline-block;
				background: url("../Images/dislike_small.png");
				background-size: 100%;
				width: 11px;
				height: 11px;
				opacity: 0.4;
    			filter: alpha(opacity=40); /* For IE8 and earlier */
			}
			.commentDisike:hover{
				opacity: 1;
    			filter: alpha(opacity=100); /* For IE8 and earlier */
    			cursor: pointer;
				cursor: hand;
			}
			.commentDisiked{
				display: inline-block;
				background: url("../Images/dislike_small.png");
				background-size: 100%;
				width: 11px;
				height: 11px;
				opacity: 1;
    			filter: alpha(opacity=100); /* For IE8 and earlier */
    			cursor: pointer;
				cursor: hand;
			}
		</style>
	</head>

	<body>
		<div id="Loading" style="width: 100px;margin-left: auto;margin-right: auto;">
			<img style="width:25px;height:25px;" src="../Images/loading.gif" alt="Loading Gif" />
			<span style="position: relative;top: -7px;">Loading...</span>
		</div>
		<div id="content" style="display:none;">
<?php

	if (isset($_GET['v']))
	{
		require_once("connect.php");
		$id = decrypt(urldecode($_GET['v']));
		$o = $_GET['o'];
		$encid = urlencode(encrypt($id));

		if (isset($_POST['parent']))
		{
			$parent = strip_tags(trim($_POST['parent']));
			$comment = strip_tags(trim($_POST['comment']));

			$insertIntoDB = mysql_query("INSERT INTO `comments` (
				`id`,
				`videoID`,
				`message`,
				`time`,
				`author`,
				`likes`,
				`dislikes`,
				`parent`,
				`reports`
				) VALUES(
				'',
				'$id',
				'$comment',
				'".time()."',
				'$user',
				'0',
				'0',
				'$parent',
				'0'
				)");
		}

		$check = mysql_query("SELECT * FROM `videos` WHERE `ID` = '$id' AND `Comments`='1' LIMIT 1");
		$exists = (mysql_num_rows($check) != 0);
		if ($exists)
		{
			if (isset($_GET['del']))
			{
				$del = stripcslashes(strip_tags(trim($_GET['del'])));
				mysql_query("DELETE FROM `comments` WHERE `videoID` = '$id' AND `id` = '$del' LIMIT 1");
				echo mysql_error();
			}

			$query = mysql_fetch_array($check);

			if ($o == "latest")
				$comm = mysql_query("SELECT * FROM `comments` WHERE `videoID` = '$id' AND `parent` = '0' ORDER BY `time` DESC LIMIT 30");
			else
				$comm = mysql_query("SELECT * FROM `comments` WHERE `videoID` = '$id' AND `parent` = '0' ORDER BY `likes` DESC LIMIT 30");

			while($row = mysql_fetch_array($comm))
			{
				$reportCheck = mysql_query("SELECT * FROM `userReports` WHERE `username` = '$user' AND `commentid` = '".$row['id']."' LIMIT 1");
					if (mysql_num_rows($reportCheck) > 0)
						continue;
?>
				<div>
				<div id="comment" number="<?php echo $row['id']; ?>" style="margin-bottom: 15px;">
					<a href="http://plychannel.com/channel/<?php echo $row['author']; ?>">
						<div style="display: inline-block;vertical-align: top;width:50px;height:50px;background: url('http://plychannel.com/Images/author?u=<?php echo $row['author']; ?>'); background-size: 100%;"></div>
					</a>
					<div style="display: inline-block;">
						<a href="http://plychannel.com/channel/<?php echo $row['author']; ?>">
							<span style="font-size: 14px;font-weight: bold;color: #000000;"><?php echo $row['author']; ?></span>
						</a>
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
									<a href="?v=<?php echo $encid; ?>&del=<?php echo $row['id']; ?>">
										<div class="dropDown">Delete this comment</div>
									</a>
<?php
								}
							}		
?>
						</div>
						<div style="max-width: 600px;"><?php echo $row['message']; ?></div>
						<input type="hidden" value="<?php echo $row['parent']; ?>" id="parent" />
						<div style="margin-top:5px;">
							<span id="replyButton" number="<?php echo $row['id']; ?>">Reply</span> - 
<?php
							$likeChecker = mysql_query("SELECT `liked` FROM `commentlikes` WHERE `commentID` = '".$row['id']."' AND `Username` = '$user' LIMIT 1");
							if (mysql_num_rows($likeChecker) > 0)
							{
								$likeChecker = mysql_fetch_array($likeChecker);
								$likeChecker = $likeChecker[0];
							}
							else
								$likeChecker = -1;
?>
							<span id="commentLike" class="commentLike<?php if ($likeChecker == '1') echo 'd'; ?>" number="<?php echo $row['id']; ?>"></span>
<?php
							if ($row['likes'] > 0)
							{
								?><span style="font-size: 11px;font-weight: bold;color: #FE563B;"><?php echo $row['likes']; ?></span><?php
							}
?>
							<span id="commentDisike" class="commentDisike<?php if ($likeChecker == '0') echo 'd'; ?>" number="<?php echo $row['id']; ?>"></span>
<?php
							if ($row['dislikes'] > 0)
							{
								?><span style="font-size: 11px;font-weight: bold;color: #000;"><?php echo $row['dislikes']; ?></span><?php
							}
?>
						</div>
					</div>
				</div>
<?php
				$childCom = mysql_query("SELECT * FROM `comments` WHERE `videoID` = '$id' AND `parent` = '".$row['id']."' ORDER BY `time` DESC LIMIT 5");
				while($childRow = mysql_fetch_array($childCom))
				{
					$reportCheck = mysql_query("SELECT * FROM `userReports` WHERE `username` = '$user' AND `commentid` = '".$childRow['id']."' LIMIT 1");
					if (mysql_num_rows($reportCheck) > 0)
						continue;
?>
					<div id="comment" number="<?php echo $childRow['id']; ?>" style="margin-bottom: 15px; margin-left: 30px;">
					<a href="http://plychannel.com/channel/<?php echo $childRow['author']; ?>">
						<div style="display: inline-block; vertical-align:top; width:50px;height:50px;background: url('http://plychannel.com/Images/author?u=<?php echo $childRow['author']; ?>'); background-size: 100%;"></div>
					</a>
					<div style="display: inline-block;">
						<a href="http://plychannel.com/channel/<?php echo $childRow['author']; ?>">
							<span style="font-size: 14px;font-weight: bold;color: #000000;"><?php echo $childRow['author']; ?></span>
						</a>
						<span style="margin-left: 15px;font-size: 12px;color: #999;font-weight: bold;"><?php echo timeToString($childRow['time']); ?> ago</span>
						<div id="droper" number="<?php echo $childRow['id']; ?>" class="moreComms"></div>
						<div id="dropDown_<?php echo $childRow['id']; ?>" style="display:none;position: absolute;right: 10px;margin-top: 15px;z-index: 10;background-color: #fff;border: solid 1px #ccc;padding: 5px 0px;">
							<div class="dropDown">Report spam or abuse</div>
<?php
							if (isset($_COOKIE['Username']))
							{
								if ($user == $childRow['author'])
								{
?>
									<a href="?v=<?php echo $encid; ?>&del=<?php echo $childRow['id']; ?>">
										<div class="dropDown">Delete this comment</div>
									</a>
<?php
								}
							}		
?>
						</div>
						<div style="max-width: 600px;"><?php echo $childRow['message']; ?></div>
						<input type="hidden" value="<?php echo $childRow['parent']; ?>" id="parent" />
						<div style="margin-top:5px;">
<?php 
							$likeChecker = mysql_query("SELECT `liked` FROM `commentlikes` WHERE `commentID` = '".$childRow['id']."' AND `Username` = '$user' LIMIT 1");
							if (mysql_num_rows($likeChecker) > 0)
							{
								$likeChecker = mysql_fetch_array($likeChecker);
								$likeChecker = $likeChecker[0];
							}
							else
								$likeChecker = -1;
?>
							<span id="commentLike" class="commentLike<?php if ($likeChecker == '1') echo 'd'; ?>" number="<?php echo $childRow['id']; ?>"></span>
<?php
							if ($childRow['likes'] > 0)
							{
								?><span style="font-size: 11px;font-weight: bold;color: #FE563B;"><?php echo $childRow['likes']; ?></span><?php
							}
?>
							<span id="commentDisike" class="commentDisike<?php if ($likeChecker == '0') echo 'd'; ?>" number="<?php echo $childRow['id']; ?>"></span>
<?php
							if ($childRow['dislikes'] > 0)
							{
								?><span style="font-size: 11px;font-weight: bold;color: #000;"><?php echo $childRow['dislikes']; ?></span><?php
							}
?>
						</div>
					</div>
				</div>
<?php
				}
?>
				</div>
<?php
			}
		}
	}
	else
	{
		die();
	}
?>
	</div>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
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
		$(window).bind('load', function(){
			$("#Loading").css("display", "none");
			$("#content").slideDown(700);
		});

		$("[id=commentLike]").each(function(){
			$(this).click(function(){
				var likeButton = $(this);
				var number = $(this).attr("number");
				$.ajax({
					url: "commentLiked.php",
					type: 'post',
					data: { like: '1', id: number },
					success: function(data){
						likeButton.parent().children("#commentDisike").attr("class", "commentDisike");
						if (likeButton.attr("class") != "commentLiked")
							likeButton.attr("class", "commentLiked");
						else
							likeButton.attr("class", "commentLike");
					}
				});
			});
		});

		$("[id=commentDisike]").each(function(){
			$(this).click(function(){
				var likeButton = $(this);
				var number = $(this).attr("number");
				$.ajax({
					url: "commentLiked.php",
					type: 'post',
					data: { like: '0', id: number },
					success: function(data){
						if (likeButton.attr("class") != "commentDisiked")
							likeButton.attr("class", "commentDisiked");
						else
							likeButton.attr("class", "commentDisike");

						likeButton.parent().children("#commentLike").attr("class", "commentLike");
					}
				});
			});
		});

		$("[id=replyButton]").each(function(){
			$(this).click(function(){
				$("#replyCloser").unbind("click");
				$("#replyComment").remove();

				var num = $(this).attr("number");
				$("[id=comment]").each(function(){
					if ($(this).attr("number") == num)
					{
						var comm = $(this);
						var parent = $("#parent").val();
						if (parent == '0')
							parent = num;

						$.ajax({
							url: "commentLeaver.php",
							type: 'post',
							data: { parent:parent },
							success: function(data){
								comm.parent().append("<div id='replyComment'>" + data + "<div id='replyCloser'><img src='../Images/x.png' alt='close button' /></div></div>");
								$("#replyCloser").click(function(){
									$("#replyComment").remove();
								});
							}
						});
					}
				});
			});
		});
	</script>

	</body>
</html>