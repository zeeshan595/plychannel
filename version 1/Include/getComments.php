<?php
	require_once("/var/www/Include/connect.php");
	require_once("/var/www/Include/encrypt.php");
	$id = stripcslashes(strip_tags(trim($_POST['id'])));
	$CommentOrder = $_POST['order'];
	$totalComments = mysql_query("SELECT COUNT(`id`) AS 'title' FROM `comments` WHERE `videoID` = '$id' LIMIT 1");
	$totalComments = mysql_fetch_array($totalComments);
	$totalComments = $totalComments['title'];
?>
	<a href="http://plychannel.com/comments?v=<?php echo encrypt($id); ?>"><div>ALL COMMENTS (<?php echo number_format($totalComments); ?>)</div></a>
<?php
	if (isset($_COOKIE['Username']))
	{
		$user = decrypt(urldecode($_COOKIE["Username"]));

?>
	<div class="media">
	<p id='commentPostTemp' style='display:none;color:#999999; font-size:15px; font-weight:bold;'></p>
	  <img width="50px" height="50px" class="media-object pull-left" src="http://plychannel.com/Images/author?u=<?php echo $user; ?>">
	  <div class="media-body">
	  	<textarea id='commentMessage' maxlength="500" style='resize:none;height:75px;width:95%;'></textarea>
	  	<br />
	  	<table width="95%">
	  		<tr><td>
	  			<span id="commentCharactersRemaining">500 Characters Remaining</span>
	  		</td><td align="right">
	  			<button id='postCommentMessage' reply='-1' type="button" class="btn btn-s btn-primary">Post</button>
	  		</td></tr>
	  	</table>
	  </div>
	</div>
<?php
	}

	if ($CommentOrder != 'l')
		$comments = mysql_query("SELECT * FROM `comments` WHERE `videoID` = '$id' AND `parent` = '' ORDER BY `likes` DESC LIMIT 20");
	else
		$comments = mysql_query("SELECT * FROM `comments` WHERE `videoID` = '$id' AND `parent` = '' ORDER BY `time` DESC LIMIT 20");

	while ($row = mysql_fetch_array($comments))
	{
?>
	<div class="media">
	  <a class="pull-left" href="http://plychannel.com/channel/<?php echo $row['author']; ?>">
	    <img width="50px" height="50px" class="media-object" src="http://plychannel.com/Images/author?u=<?php echo $row['author']; ?>">
	  </a>
	  <div class="media-body">
	    <h4 class="media-heading"><?php echo $row['author']; ?> <span style="font-size:11px;color: #999999;font-weight:bold;">on <?php echo date("j F Y", $row['time']); ?></span></h4>
	  	<?php echo $row['message'] ?><br />
	  	<a id="ReplyComment" author="<?php echo $row['author']; ?>" number="<?php echo $row['id']; ?>" parent="">Reply</a>
	  	<img src="http://plychannel.com/Images/likes.png" id="commentLikes" like="1" number="<?php echo $row['id']; ?>" /><?php echo $row['likes']; ?> 
	  	<img src="http://plychannel.com/Images/dislikes.png" id="commentLikes" like="0"  number="<?php echo $row['id']; ?>" /><?php echo $row['dislikes']; ?>
<?php
		$commentReplies = mysql_query("SELECT * FROM `comments` WHERE `videoID` = '$id' AND `parent` = '".$row['id']."' ORDER BY `time` DESC LIMIT 5");
		while($replieRow = mysql_fetch_array($commentReplies))
		{
?>						
		<div class="media">
		  <a class="pull-left" href="http://plychannel.com/channel/<?php echo $replieRow['author']; ?>">
		    <img width="50px" height="50px" class="media-object" src="http://plychannel.com/Images/author?u=<?php echo $replieRow['author']; ?>">
		  </a>
		  <div class="media-body">
		    <h4 class="media-heading"><?php echo $replieRow['author']; ?> <span style="font-size:11px;color: #999999;font-weight:bold;">on <?php echo date("j F Y", $replieRow['time']); ?></span></h4>
		  	<?php echo $replieRow['message'] ?><br />
		  	<a id="ReplyComment" author="<?php echo $replieRow['author']; ?>" parent="<?php echo $row['id']; ?>" number="<?php echo $replieRow['id']; ?>">Reply</a>
		  	<img src="http://plychannel.com/Images/likes.png" id="commentLikes" class="commentLikes" like="1" number="<?php echo $replieRow['id']; ?>" /><?php echo $replieRow['likes']; ?> 
		  	<img src="http://plychannel.com/Images/dislikes.png" id="commentLikes" class="commentLikes" like="0"  number="<?php echo $replieRow['id']; ?>" /><?php echo $replieRow['dislikes']; ?>
		  </div>
		</div>
<?php
		}
?>
	  </div>
	</div>
<?php
	}
?>

<script>
$("#commentMessage").keyup(function(){
	var count = $("#commentMessage").val().length;
	$("#commentCharactersRemaining").html((500 - count) + " Characters Remaining");
});
</script>