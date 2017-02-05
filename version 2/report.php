<?php

if (!isset($_GET['v']))
	die();

$reportType = strip_tags(trim(addslashes($_POST['reportType'])));
$timeMinutes = strip_tags(trim(addslashes($_POST['timeMinutes'])));
$timeSeconds = strip_tags(trim(addslashes($_POST['timeSeconds'])));
$reportMessage = strip_tags(trim(addslashes($_POST['reportMessage'])));
$videoTime = $timeSeconds + ($timeMinutes * 60);

require_once("PHP/connect.php");
$vid = decrypt(urldecode($_GET['v']));

mysql_query("INSERT INTO `VideoReports` (`id`, `type`, `time`, `videoID`, `message`) VALUES('', '$reportType', '$videoTime', '$vid', '$reportMessage')");
mysql_query("UPDATE `videos` SET `reports` = `reports`+1 WHERE `ID` = '$vid' LIMIT 1")

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Traditional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-traditional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="Styles/toolbar.css" type="text/css" rel="stylesheet" />
		<link href="Styles/page.css" type="text/css" rel="stylesheet" />
		<title>Plychannel</title>
	</head>

	<body>
		
		<?php require_once("PHP/toolbar.php"); ?>

		<div class="content">
		  <div class="section">
		    <h3>Report A Video</h3>
		    <p>
		    	Thank you for reporting this video. We will try our best to remove any improper content.

		    	Thanks
		    </p>
		  </div>
		</div>

		<?php require_once("PHP/footer.php"); ?>
		<!-- JS -->
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script type="text/javascript" src="Javascript/toolbar.js"></script>
	</body>
</html>