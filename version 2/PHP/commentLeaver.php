<?php
	if (isset($_COOKIE['Username']))
	{
		require_once("connect.php");
		$parent = strip_tags(trim($_POST['parent']));
?>
		<form action="" method="POST">
			<input type="hidden" value="<?php echo $parent; ?>" name="parent" />
			<div style="margin-top: 15px;">
				<div style="display: inline-block;width:50px;height:50px;background: url('http://plychannel.com/Images/author?u=<?php echo decrypt(urldecode($_COOKIE['Username'])); ?>'); background-size: 100%;"></div>
				<textarea name="comment" placeholder="Share your thoughts" style="display: inline-block;width: 600px;height: 50px;resize: none;padding: 4px;" maxlength="500"></textarea>
			</div>
			<input type="submit" id="commentLeaverButton" class="Button" style="margin-left: 617px;" value="Reply" />
		</form>
<?php
	}
?>