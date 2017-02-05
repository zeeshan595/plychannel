<?php
if(!isset($_COOKIE['Username']))
	header('Location: http://plychannel.com/login');

require_once("Include/header.php"); ?>

<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="description" content="A video sharing website, where you can share videos with your friends, family and others." />
<meta name="keywords" content="video, sharing, family, plychannel, ply channel" />
<meta name="author" content="Zeeshan Abid" />
<link rel="shortcut icon" href="Images/favicon.ico" />

<title>Plychannel - Upload</title>

<!-- og Tags -->

<meta property="og:title" content="Plychannel.com"/>
<meta property="og:type" content="html"/>
<meta property="og:image" content="http://plychannel.com/logo.png"/>
<meta property="og:image:type" content="image/png">
<meta property="og:image:width" content="300">
<meta property="og:image:height" content="33">

<meta property="og:url" content="http://plychannel.com/"/>
<meta property="og:description" content="video, sharing, family, plychannel, ply channel"/>

<?php require_once("Include/navigation.php");?>

<style>
.statusbar.odd {
	padding: 15px;
	border: 1px #e0e0e0 solid;
	width: 500px;
	margin-top: 25px;
}
.filename {
	color: #000;
	font-size: 15px;
	font-weight: bold;
}
.filesize {
	font-size: 12px;
	font-weight: bold;
	color: #999999;
}
.abort {
	position: relative;
	top: -40px;
	left: 215px;
}

.uploadForm {
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

.message {
	font-size: 12px;
	font-weight: bold;
	color: #999999;
}
</style>

<center>
<h4 style="font-size:15px;font-weight:bold;font-color: #999999;">
For now max file size is 1.8GB
</h4>
<div id='AllUploads'>
<div id="dragandrophandler" style="width: 500px;height: 100px;border: 1px #999999 solid;padding: 35px;">
Drag and drop videos here
</div>
</div>
</center>
<input type="hidden" id="uploadings" value='<?php echo $startingValue; ?>' />

<script src="http://plychannel.com/js/upload.js"></script>

<?php require_once("Include/footer.php"); ?>