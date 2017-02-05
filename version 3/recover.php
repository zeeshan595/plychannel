<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Traditional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-traditional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="Styles/page.css" type="text/css" rel="stylesheet" />
		<title>Sign in - Plychannel</title>
	</head>
	<body>
		<div style="position: fixed;background: #fff;top: 0;left: 0;width: 100%;padding: 5px;">
			<a href="http://plychannel.com/"><img src="Images/logo.png" alt="logo" style="height: 35px;" /></a>
		</div>
		<div class="loginBox">
			<h3>Recover Account</h3>
<?php
				if (isset($_POST['submitted']))
				{
					$email = strip_tags(trim($_POST['email']));
					require_once("PHPMailer/Mail.php");
					require_once("PHP/connect.php");
					$data = mysql_query("SELECT * FROM `users` WHERE `Email` = '$email' LIMIT 1");
					$data = mysql_fetch_array($data);
					$user = $data['Username'];
					$pass = $data['Password'];
					SendMail($email, "Recover Account", "A request to recover your account was activated. Please change your password to something you will remember. \n<br /> If you did not authorise this please ignore this message.\n\n<br /><br />Username: $user \n<br />Password: $pass");
					echo "An email has been sent to you that contains recovery details for your account.";
				}
?>
			<form action="" method="POST">
				<input type="text" name="email" placeholder="Email" />
				<input type="submit" value="Recover" class="Button" name="submitted" style="display:block; width: 312px; margin-left: 0;" />
			</form>
		</div>
	</body>
</html>