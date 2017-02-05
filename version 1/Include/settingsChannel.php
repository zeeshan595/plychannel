<?php
require_once("Include/header.php");
if (!isset($_COOKIE['Username']))
	header("Location: http://plychannel.com/login?feature=http://plychannel.com/settings");


require_once("Include/connect.php");
require_once("Include/encrypt.php");

$user = stripslashes(strip_tags(trim($_COOKIE['Username'])));
$user = decrypt(urldecode($user));

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

#featuredVideos {
	width: 100%;
	height: 300px;
	overflow-y: scroll;
	background-color: #efefef;
	padding: 5px;
}

.featuredVideo {
	margin: 5px;
	color: #000;
	font-size: 13px;
	font-weight: bold;
	padding: 5px;
}
.featuredVideo:hover {
	color: #fff;
	background-color: #555555;
	cursor: pointer;
	cursor: hand;
}

.featuredVideoSelected{
	margin: 5px;
	color: #fff;
	font-size: 13px;
	font-weight: bold;
	padding: 5px;
	background-color: #555555;
}

.channelImg:hover{
	opacity:0.7;
	filter:alpha(opacity=70);
	border:1px #999 solid;
	cursor: pointer;
	cursor: hand;
}

.Banner{
	background-image: url(<?php echo "http://plychannel.com/Backgrounds/".$user.".jpg"; ?>);
	background-repeat: repeat;
	height: 200px;
	padding: 25px;
}

.Banner:hover{
	opacity:0.7;
	filter:alpha(opacity=70);
	border:1px #999 solid;
	cursor: pointer;
	cursor: hand;
}
</style>

<?php require_once("Include/navigation.php"); ?>

<ul class="nav nav-tabs">
  <li><a href="http://plychannel.com/settings">Personal</a></li>
  <li class="active"><a href="http://plychannel.com/settingsChannel">Channel</a></li>
  <li><a href="http://plychannel.com/settingsDefaults">Defaults</a></li>
</ul>

<?php 

$query = mysql_query("SELECT * FROM `users` WHERE `Username` = '$user' LIMIT 1");
$userData = mysql_fetch_array($query);

?>
<input type="file" name="file" id="fileUploaderProfile" style="display:none;" />
<input type="file" id="fileUploader" style="display:none;" />

<div class="formInput">
	<span>Channel Banner:</span>
	<img class="Banner" id="channelBanner">
</div>
<div class="formInput">
	<span>Profile Picture:</span>
	<img class="channelImg" id="channelProfile" style="width:100px;height:100px;" src="http://plychannel.com/Images/author?u=<?php echo $user; ?>" alt="profile picture">
</div>
<div class="formInput">
	<span>Featured Video:</span>
	<div id="featuredVideos">
		<div number="-1" id="featuredVideo" class="featuredVideo<?php if ($userData['Channelvideo'] == '-1') echo "Selected"; ?>">
			<img width="20px" height="15px" src="http://plychannel.com/Images/Browse/latest_big.png" />
			Latest Video
		</div>
		<?php
			$query = mysql_query("SELECT * FROM `videos` WHERE `Author` = '$user' ORDER BY `Time` DESC");
			while ($row = mysql_fetch_array($query))
			{
				$id = $row['ID'];
				$encid = urlencode(encrypt($id));
?>
			<div number="<?php echo $id; ?>" id="featuredVideo" class="featuredVideo<?php if ($userData['Channelvideo'] == $id) echo "Selected"; ?>">
				<img src="http://plychannel.com/Images/video?i=<?php echo $encid; ?>&w=20&h=15" />
				<?php echo $row['Title'] ?>
			</div>
<?php
			}
		?>
	</div>
</div>
<div class="formInput">
	<span>Channel Info:</span>
	<textarea id="ChannelInfo"></textarea>
</div>

<script>
$("[id=featuredVideo]").each(function(){
	$(this).click(function(){
		$("[id=featuredVideo]").each(function(){
			$(this).attr("class", "featuredVideo");
		});
		var id = $(this).attr("number");
		var featuredV = $(this);
		$.ajax({
			url: "http://plychannel.com/Include/changeFeaturedVideo.php",
			type: 'post',
			data: { id:id },
			success: function(data){
				featuredV.attr("class", "featuredVideoSelected");
			}
		});
	});
});

$("#channelBanner").click(function(){
	$("#fileUploader").trigger("click");
});

$("#channelProfile").click(function(){
	$("#fileUploaderProfile").trigger("click");
});

$("#fileUploader").change(function(){
	if ($(this).val())
	{
		uploadImage("http://plychannel.com/Include/changeBackground.php", $(this)[0].files[0]);
	}
});

$("#fileUploaderProfile").change(function(){
	if ($(this).val())
	{
		uploadImage("http://plychannel.com/Include/changeProfilePic.php", $(this)[0].files[0]);
	}
});


function uploadImage(url, file)
{
	if (file.type != "image/jpeg")
	{
		alert("Please use jpg file format");
		return;
	}
	var fd = new FormData();
	fd.append('file', file);

	$.ajax({
	    type: "POST",
	    url: url,
	    data: fd,
	    cache: false,
        processData: false,
		contentType: false,
	    success: function(data){
            $("#channelBanner").attr("src", $("#channelBanner").attr("src"));
            $("#channelProfile").attr("src", $("#channelProfile").attr("src"));
        }
    });
}
</script>

<?php require_once("Include/footer.php"); ?>