<?php
if (!isset($_COOKIE['Username']))
	die();

require_once("connect.php");
$stripedTitle = stripcslashes(trim($_POST['title']));
$title = addslashes($stripedTitle);

$createVid = mysql_query("INSERT INTO `videos` (
	`ID`,
	`Title`,
	`Description`,
	`Views`,
	`Author`,
	`Time`,
	`Privacy`,
	`Tags`,
	`Category`,
	`Likes`,
	`Dislikes`,
	`Comments`,
	`Uploaded`,
	`ViewsAllow`,
	`URL`,
	`reports`,
	`Length`
	) VALUES(
	'',
	'$title',
	'No Description Available.',
	'0',
	'$user',
	'".time()."',
	'a',
	'',
	'Entertainment',
	'0',
	'0',
	'1',
	'0',
	'',
	'http://plychannel.com/Uploads/',
	'0',
	'')");
if (!$createVid)
	die(mysql_error());

$newid = mysql_insert_id();

$settings = mysql_query("SELECT * FROM `defaults` WHERE `author` = '$user' LIMIT 1");
$settings = mysql_fetch_array($settings);

$privacy = $settings['privacy'];
$description = $settings['description'];
$tags = $settings['tags'];
$category = $settings['category'];
$allowed = $settings['allowed'];

?>
<div class="videoUpload" id="videoUpload" number="<?php echo $newid; ?>">
	<p id="ptitle" number="<?php echo $newid; ?>" style="margin-bottom: 0;margin-top: 5px;font-size: 18px;"><?php echo $stripedTitle; ?></p>
	<div style="display: inline-block;width: 883px;">
		<div id="progressBar" number="<?php echo $newid; ?>" style="width: 50%;height: 5px;background-color: #FE563B;"></div>
	</div>
	<a id="cancelButton" number="<?php echo $newid; ?>"><div class="greyButton">Cancel</div></a>
	<br />

	<div style="display: inline-block;">
		<div id="background" number="<?php echo $newid; ?>" style="width: 295px;height: 150px;background: #eee;"></div>
	</div>
	<div style="display: inline-block;vertical-align: top;">
		<input number="<?php echo $newid; ?>" type="text" placeholder="Title" id="title" value="<?php echo $stripedTitle; ?>" />
		<textarea number="<?php echo $newid; ?>" id="description" style="height: 70px;width: 384px;resize: none; padding: 5px 10px;" placeholder="Description" maxlength="500"><?php echo $description; ?></textarea>
		<input number="<?php echo $newid; ?>" type="text" placeholder="Tags" id="tags" value="<?php echo $tags; ?>" />
	</div>
	<div style="display: inline-block;vertical-align: top;">
		<input number="<?php echo $newid; ?>" type="checkbox" id="allowComments" checked/>Allow Comments.
		<br />
		<select number="<?php echo $newid; ?>" id="category">
<?php
			$getcat = mysql_query("SELECT `cat` FROM `categories`");
			while($row = mysql_fetch_array($getcat))
			{
				$cat = $row[0];
				echo "<option value='$cat'";
				if ($category == $cat)
					echo " selected";
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