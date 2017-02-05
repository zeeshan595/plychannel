<?php
if (!isset($_COOKIE['Username']))
	die();

require_once("/var/www/Include/connect.php");
require_once("/var/www/Include/encrypt.php");

$title = stripslashes(strip_tags(trim($_POST['title'])));

$user = decrypt(urldecode($_COOKIE['Username']));
$query = mysql_query("INSERT INTO `videos`
	(
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
	) VALUES
	(
		'',
		'$title',
		'There is no description available.',
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
		''
	)");

$id = mysql_insert_id();
?>
<div class="uploadForm"  id="uploadForm_<?php echo $id; ?>" number="<?php echo $id; ?>">
	<table width="100%">
		<tr>
			<td><div class="message" id="messageNumber_<?php echo $id; ?>" style="display:none;"></div></td>
			<td align="right"><button type="button" id="hidder" number="<?php echo $id; ?>" class="btn btn-xs btn-default">Less</button></td>
		</tr>
	</table>
	<div class="formInput">
		<span>Title:</span>
		<input type="text" id="inputArea" infoType="title" number="<?php echo $id; ?>" value="<?php echo $title; ?>" />
	</div>
	<div class="formInput">
		<span>Privacy:</span>
		<select type="text" id="inputArea" infoType="privacy" number="<?php echo $id; ?>">
			<option value="a">Public</option>
			<option value="u">Unlisted</option>
			<option value="p">Private</option>
		</select>
	</div>
	<div class="formInput" id="UsersAllowedInput_<?php echo $id; ?>" style="display:none;">
		<span>Users Allowed:</span>
		<input type="text" id="inputArea" infoType="allowed" number="<?php echo $id; ?>" />
	</div>
	<div class="formInput">
		<span>Tags:</span>
		<input type="text" id="inputArea" infoType="tags" number="<?php echo $id; ?>" />
	</div>
	<div class="formInput">
		<span>Category:</span>
		<select type="text" id="inputArea" infoType="category" number="<?php echo $id; ?>">
<?php
          	$cat = mysql_query("SELECT * FROM `categories` ORDER BY `id` ASC");
          	while($row = mysql_fetch_array($cat))
          	{
?>
          		<option value="<?php echo $row['cat']; ?>"><?php echo $row['cat']; ?></option>";
<?php
          	}
?>
		</select>
	</div>
	<div class="formInput">
		<span>Description:</span><br />
		<textarea id="inputArea" infoType="description" number="<?php echo $id; ?>">There is no description available.</textarea>
	</div>
</div>