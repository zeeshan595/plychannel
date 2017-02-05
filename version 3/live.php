<?php
if(!isset($_COOKIE['Username']))
	header('Location: http://plychannel.com/signin?feature=http://plychannel.com/live');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Traditional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-traditional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="Styles/toolbar.css" type="text/css" rel="stylesheet" />
		<link href="Styles/page.css" type="text/css" rel="stylesheet" />
		<title>Live Broadcast - Plychannel</title>
	</head>

	<body>
		
		<?php require_once("PHP/toolbar.php"); ?>
		<?php require_once("PHP/connect.php"); ?>

		<div class="content">
			<p style="text-align: center;font-size: 15px;font-weight: bold;">
				This service is currently under development. Please check back later.
			</p>
		</div>

	<?php require_once("PHP/footer.php"); ?>
	<!-- JS -->
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script type="text/javascript" src="Javascript/toolbar.js"></script>
</body>
</html>