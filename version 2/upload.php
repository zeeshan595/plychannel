<?php
if(!isset($_COOKIE['Username']))
	header('Location: http://plychannel.com/signin?feature=http://plychannel.com/upload');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Traditional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-traditional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="Styles/toolbar.css" type="text/css" rel="stylesheet" />
		<link href="Styles/page.css" type="text/css" rel="stylesheet" />
		<title>Upload - Plychannel</title>

		<style type="text/css">
			#uploadDroper{
				display: inline-block;
				padding: 75px 5px 75px 5px;
				text-align: center;
				background-color: #fff;
				width: 740px;
			}
			#uploadDroper:hover{
				cursor:pointer;
				cursor: hand;
			}

			#otherOptions{
				display: inline-block;
				width: 200px;
				height: 250px;
				background-color: #fff;
				position: absolute;
				margin-left: 5px;
				padding: 10px;
			}

			.small_button{
				border: 1px solid #ccc;
				background-color: #f1f1f1;
				padding: 2px 10px;
				color: #000;
				font-size: 12px;
				box-shadow: 0 1px 0 rgba(0,0,0,0.05);
				border-radius: 4px;
			}

			.small_button:hover{
				cursor: pointer;
				cursor: hand;
				background-color: #eee;
			}

			input[type=text]{
				display: block;
				font-size: 14px;
				padding: 5px 10px;
				width: 384px;
			}
			.videoUpload{
				background-color: #fff;
				box-shadow: 0 1px 2px rgba(0,0,0,.1);
				padding: 5px;
				margin-bottom: 10px;
			}
			#addMore{
				background: #fff;
				width: 122px;
				height: 19px;
				margin-left: auto;
				padding: 5px 15px;
				font-size: 13px;
				color: #868686;
				font-weight: bold;
				box-shadow: 0 1px 2px rgba(0,0,0,.1);
				border-radius: 2px;
			}
			#addMore:hover{
				cursor: pointer;
				cursor: hand;
			}
		</style>
	</head>

	<body>
		
		<?php require_once("PHP/toolbar.php"); ?>
		<?php require_once("PHP/connect.php"); ?>

		<div id="uploadingPage" class="content" style="background-color: rgba(0,0,0,0);border: 0;box-shadow: 0 0px 0px rgba(0,0,0,0);">
			<div id="fileUploaders">
				
			</div>
			<div id="uploadDroper">
				<div id="uploadDroperImage" style="margin-left: auto;margin-right: auto;background: url('Images/upload.png') 100%;width: 118px;height: 78px;"></div>
				<span style="font-size: 18px;">Select files to upload</span>
				<br />
				<span style="font-size: 13px;color: #999;font-weight: bold;">Or drag and drop video files</span>
			</div>
			<div id="otherOptions">
				<h4 style="text-transform: uppercase;color: #444;font-size: 12px;font-weight: bold;">Other Options</h4>
				<div>
					<a href="live">
						<div style="cursor: pointer;cursor: hand;display: inline-block; background: url('Images/live.png') 100%;width: 66px;height: 66px;"></div>
					</a>
					<div style="display:inline-block;vertical-align: top;">
						<div style="font-size: 13px;font-weight: bold;">Live broadcasting</div>
						<a href="live" class="small_button">Go Live</a>
					</div>
				</div>
			</div>
		</div>
		<div class="content" id="uploadingVideos" style="background: none;box-shadow: none;border: none;display:none; min-height: 50px;">
			
			<div id="addMore">+ Add More Videos</div>
		</div>
	
	<?php require_once("PHP/footer.php"); ?>
	<!-- JS -->
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script type="text/javascript" src="Javascript/toolbar.js"></script>
	<script type="text/javascript" src="Javascript/upload.js"></script>
</body>
</html>