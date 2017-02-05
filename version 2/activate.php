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
<?php
			if (isset($_GET['u']) && isset($_GET['k']))
			{
				require_once("PHP/connect.php");
				$user = strip_tags(trim($_GET['u']));
				$key = strip_tags(trim($_GET['k']));

				$user = mysql_real_escape_string($user);
				$key = mysql_real_escape_string($key);

				$check = mysql_query("UPDATE `users` SET `Active` = '1' WHERE `Username` = '$user' AND `Code` = '$key' LIMIT 1");
				if ($check)
					echo "<h2>Your account is now activated.</h2>";
				else
					echo "<h2>Unknown Error, Couldn't activate your account. Please contact us.</h2>";
			}
			else
			{
				echo "<h2>Invalid Link. Please check that you type the link properly.</h2>";
			}
?>
			
		</div>

		<?php require_once("PHP/footer.php"); ?>
		<!-- JS -->
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script type="text/javascript" src="Javascript/toolbar.js"></script>
	</body>
</html>