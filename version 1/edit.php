<?php
require_once("Include/header.php");

if (!isset($_COOKIE['Username']) && !isset($_POST['SubmitPlaylistData']))
{
	header("Location: http://plychannel.com/login?feature=http://plychannel.com/manager");
}

?>

<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="description" content="A video sharing website, where you can share videos with your friends, family and others." />
<meta name="keywords" content="video, sharing, family, plychannel, ply channel, ago, views, month, months, days, westnstyle" />
<meta name="author" content="Zeeshan Abid" />
<link rel="shortcut icon" href="Images/favicon.ico" />

<title>Plychannel - Edit</title>

<!-- og Tags -->

<meta property="og:title" content="Plychannel.com"/>
<meta property="og:type" content="html"/>
<meta property="og:image" content="http://plychannel.com/logo.png"/>
<meta property="og:image:type" content="image/png">
<meta property="og:image:width" content="300">
<meta property="og:image:height" content="33">

<meta property="og:url" content="http://plychannel.com/"/>
<meta property="og:description" content="Edit your videos"/>

<style>
.uploadForm {
	font-size: 13px;
	text-align: left;
	overflow-y: hidden;
	height: auto;/* Less=45 */
	border: 1px #999999 solid;
	padding: 10px;
	margin-bottom: 15px;
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

<?php require_once("Include/navigation.php");?>

<?php

require_once("Include/connect.php");
require_once("Include/encrypt.php");

$query = mysql_query("SELECT * FROM `videos` WHERE `Author` = '$user' AND `Uploaded` = '1'");
while($row = mysql_fetch_array($query))
{
	if (isset($_POST['video_' . $row['ID']]))
	{
		$id = $row['ID'];
		$title = $row['Title'];
		$allwoed = $row['ViewsAllow'];
		$tags = $row['Tags'];
		$Privacy = $row['Privacy'];
		$Category = $row['Category'];
		$description = $row['Discription'];
		$description = preg_replace('/\<br\s*(\/)?\>/', "", $description);
		$videoLength = $row['Length'];
?>
		<div class="uploadForm"  id="uploadForm_<?php echo $id; ?>" number="<?php echo $id; ?>">
			<table width="100%">
				<tr>
					<td><div class="message" id="messageNumber_<?php echo $id; ?>" style="font-size: 15px;font-weight: bold;"><?php echo $title; ?></div></td>
					<td align="right"><button type="button" id="hidder" number="<?php echo $id; ?>" class="btn btn-xs btn-default">Less</button></td>
				</tr>
			</table>
			<table width="100%">
			<tr><td>
			<div class="formInput">
				<span>Title:</span>
				<input type="text" id="inputArea" infoType="title" number="<?php echo $id; ?>" value="<?php echo $title; ?>" />
			</div>
			<div class="formInput">
				<span>Privacy:</span>
				<select type="text" id="inputArea" infoType="privacy" number="<?php echo $id; ?>">
					<option value="a" <?php if ($Privacy == 'a') echo "selected"; ?>>Public</option>
					<option value="u" <?php if ($Privacy == 'u') echo "selected"; ?>>Unlisted</option>
					<option value="p" <?php if ($Privacy == 'p') echo "selected"; ?>>Private</option>
				</select>
			</div>
			<div class="formInput" id="UsersAllowedInput_<?php echo $id; ?>" style="<?php if ($Privacy != 'p') echo "display:none;"; ?>">
				<span>Users Allowed:</span>
				<input type="text" id="inputArea" infoType="allowed" number="<?php echo $id; ?>" value="<?php echo $allwoed; ?>" />
			</div>
			<div class="formInput">
				<span>Tags:</span>
				<input type="text" id="inputArea" infoType="tags" number="<?php echo $id; ?>" value="<?php echo $tags; ?>" />
			</div>
			<div class="formInput">
				<span>Category:</span>
				<select type="text" id="inputArea" infoType="category" number="<?php echo $id; ?>">
<?php
		          	$cat = mysql_query("SELECT * FROM `categories` ORDER BY `id` ASC");
		          	while($row = mysql_fetch_array($cat))
		          	{
?>
		          		<option value="<?php echo $row['cat']; ?>" <?php if ($Category == $row['cat']) echo "selected"; ?>><?php echo $row['cat']; ?></option>";
<?php
		          	}
?>
				</select>
			</div>
			</td><td align="right" width="210px">
				<div style="position:relative; width:0; height:0;top:0px;left:-200px;"><span class="videoTime_<?php echo $id; ?>" id="videoTime"><?php echo $videoLength; ?></span></div>
				<img id="imageToRefresh_<?php echo $id; ?>" style="width:200px;" src="http://plychannel.com/Images/video?i=<?php echo urlencode(encrypt($id)); ?>" alt="Video Image"><br />
				<button number="<?php echo $id; ?>" id="imageRefresher" class="btn btn-xs btn-default" style="width: 200px;">Refresh Image</button>
				<div id="imageRefreshLoader"></div>
			</td></tr>
			</table>
			<div class="formInput">
				<span>Description:</span><br />
				<textarea id="inputArea" infoType="description" number="<?php echo $id; ?>"><?php echo $description; ?></textarea>
			</div>
		</div>
<?php
	}
}

?>
<script src="js/edit.js"></script>
<?php require_once("Include/footer.php"); ?>