<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Traditional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-traditional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="Styles/toolbar.css" type="text/css" rel="stylesheet" />
		<link href="Styles/page.css" type="text/css" rel="stylesheet" />
		<title>Plychannel</title>
		<style type="text/css">
		.formInput span{
			font-size: 13px;
			font-weight: bold;
		}
		.formInput input[type=text]{
			padding: 5px 10px;
			font-size: 15px;
			width: 200px;
		}
		.formInput textarea{
			width: 930px;
			height: 300px;
			resize: none;
			padding: 5px 10px;
		}
		</style>
	</head>

	<body>
		
		<?php require_once("PHP/toolbar.php"); ?>
		<?php require_once("PHP/connect.php"); ?>

		<div class="content">
			<h2>Contact</h2>
			<form action="" method="POST">
				<div class="formInput">
					<span>Name: (required)</span><br />
					<input type="text" name="name" />
				</div>
				<div class="formInput">
					<span>Email: (required)</span><br />
					<input type="text" name="email" />
				</div>
				<div class="formInput">
					<span>Message:</span><br />
					<textarea name="message"></textarea>
				</div>
				<button type="submit" class="greyButton">Send</button>
				<input type="hidden" value="true" name="SUBMITTED" />
			</form>
		</div>

		<?php require_once("PHP/footer.php"); ?>
		<!-- JS -->
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script type="text/javascript" src="Javascript/toolbar.js"></script>
	</body>
</html>