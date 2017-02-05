<?php
require_once("Include/header.php");
if (!isset($_COOKIE['Username']))
	header("Location: http://plychannel.com/login?feature=http://plychannel.com/settings");

?>
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="description" content="A video sharing website, where you can share videos with your friends, family and others." />
<meta name="keywords" content="video, sharing, family, plychannel, ply channel, ago, views, month, months, days, westnstyle" />
<meta name="author" content="Zeeshan Abid" />
<link rel="shortcut icon" href="Images/favicon.ico" />

<title>Plychannel - Personal Settings</title>

<!-- og Tags -->

<meta property="og:title" content="Plychannel.com"/>
<meta property="og:type" content="html"/>
<meta property="og:image" content="http://plychannel.com/logo.png"/>
<meta property="og:image:type" content="image/png">
<meta property="og:image:width" content="300">
<meta property="og:image:height" content="33">

<meta property="og:url" content="http://plychannel.com/"/>
<meta property="og:description" content="video, sharing, family, plychannel, ply channel"/>

<style>
.InputForm {
	font-size: 13px;
	text-align: left;
	overflow-y: hidden;
	height:auto;
}
.formInput {
	padding: 5px;
}
.formInput span {
	margin-left: 0;
	display: block;
}
.formInput textarea {
	resize: none;
	width: 100%;
	height: 75px;
}
</style>

<?php require_once("Include/navigation.php"); ?>

<ul class="nav nav-tabs">
  <li><a href="http://plychannel.com/settings">Personal</a></li>
  <li><a href="http://plychannel.com/settingsChannel">Channel</a></li>
  <li class="active"><a href="http://plychannel.com/settingsDefaults">Defaults</a></li>
</ul>

<?php
require_once("Include/connect.php");
require_once("Include/encrypt.php");

$user = stripcslashes(strip_tags(trim($_COOKIE['Username'])));
$user = decrypt(urldecode($user));

$defaults = mysql_query("SELECT * FROM `defaults` WHERE `author` = '$user' LIMIT 1");

if (mysql_num_rows($defaults) == 0)
{
	mysql_query("INSERT INTO `defaults` (`privacy`, `description`, `tags`, `category`, `allowed`, `author`) VALUES ('','','', '', '', '', '$user')");

	$category = "";
	$privacy = "";
	$allowed = "";
	$tags = "";
	$description = "";
}
else
{
	$defaults = mysql_fetch_array($defaults);
	$category = $defaults['category'];
	$privacy = $defaults['privacy'];
	$allowed = $defaults['allowed'];
	$tags = $defaults['tags'];
	$description = $defaults['allowed'];
}

if (isset($_POST['SUBMITTED']))
{
	$category = stripslashes(strip_tags(trim($_POST['category'])));
	$privacy = stripslashes(strip_tags(trim($_POST['privacy'])));
	$allowed = stripslashes(strip_tags(trim($_POST['allowed'])));
	$tags = stripslashes(strip_tags(trim($_POST['tags'])));
	$description = stripslashes(strip_tags(trim($_POST['description'])));

	$category = mysql_real_escape_string($category);
	$privacy = mysql_real_escape_string($privacy);
	$allowed = mysql_real_escape_string($allowed);
	$tags = mysql_real_escape_string($tags);
	$description = mysql_real_escape_string($description);

	mysql_query("UPDATE `defaults` 
		SET
		`privacy` = '$category',
		`description` = '$privacy',
		`tags` = '$allowed',
		`category` = '$tags',
		`description` = '$description'
		WHERE `author` = '$user'
		LIMIT 1
		");
}
?>

<form class="InputForm" action="" method="POST">
	<div class="formInput">
		<span>Category:</span>
		<select name="category">
<?php
		$cats = mysql_query("SELECT * FROM `categories` ORDER BY `id` ASC");
		while($row = mysql_fetch_array($cats))
		{
?>
			<option value="<?php echo $row['cat']; ?>" <?php if ($category == $row['cat']) echo "selected"; ?>><?php echo $row['cat']; ?></option>
<?php
		}
?>
		</select>
	</div>
	<div class="formInput" >
		<span>Privacy:</span>
		<select name="privacy" id="privacy">
			<option value="a" <?php if ($privacy == "a") echo "selected"; ?>>Public</option>
			<option value="u" <?php if ($privacy == "u") echo "selected"; ?>>Unlisted</option>
			<option value="p" <?php if ($privacy == "p") echo "selected"; ?>>Private</option>
		</select>
	</div>
	<div class="formInput" style="display:none;" id="allowed">
		<span>Users Allowed:</span>
		<input type="text" name="allowed" value="<?php echo $allowed; ?>" />
	</div>
	<div class="formInput" >
		<span>Tags:</span>
		<input type="text" name="tags" value="<?php echo $tags; ?>" />
	</div>
	<div class="formInput" >
		<span>Description:</span>
		<textarea name="description"><?php echo $description; ?></textarea>
	</div>
	<br />
	<input type="hidden" value="true" name="SUBMITTED" />
	<button type="submit" class="btn btn-sm btn-default">Save</button>
</form>

<script>
$("#privacy").change(function(){
	if ($(this).val() == "p")
	{
		$("#allowed").slideDown(700);
	}
	else
	{
		$("#allowed").slideUp(700);
	}
});
</script>
<?php require_once("Include/footer.php"); ?>