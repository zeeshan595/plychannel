<?php
$errors = "";
if (!isset($_COOKIE['Username']))
{
	if (isset($_POST['submitted']))
	{
		if (isset($_POST['user']) && isset($_POST['pass']))
		{
			require_once("PHP/connect.php");
			$user = strip_tags(trim($_POST['user']));
			$pass = strip_tags(trim($_POST['pass']));
			$pass = urlencode(encrypt($pass));
			if (strpos($user, "@") === false)
				$query = mysql_query("SELECT * FROM `users` WHERE `Username` = '$user' AND `Password` = '$pass' LIMIT 1");
			else
				$query = mysql_query("SELECT * FROM `users` WHERE `Email` = '$user' AND `Password` = '$pass' LIMIT 1");
			
			if (mysql_num_rows($query) == 0)
				$errors = "The username/email or password that you entered is incorrect.";
			else
			{
				$query = mysql_fetch_array($query);
				$blockCheck = $query['Blocked'];
				$activated = $query['Active'];
				$user = $query["Username"];
				if ($blockCheck == '1')
					$errors = "Your account has been blocked please contact us for help.";
				else if ($activated == '0')			
					$errors = "Your account needs to be activated, please check your email.<br /> Another email with the link to activate your account has just been sent to you.";
				else
				{
					if (isset($_POST['signedIn']))
						setcookie("Username", urlencode(encrypt($user)), time() + 32140800, "/");
					else
						setcookie("Username", urlencode(encrypt($user)), time() + 3600, "/");
					if (isset($_GET['feature']))
					{
						$feature = strip_tags(trim($_GET['feature']));
						header("Location: " . $feature);
					}
					else
					{
						header("Location: http://plychannel.com/");
					}
				}
			}
		}
		else
		{
			$errors = "Please enter username/email and password for your account.";
		}
	}
}
else
	header("Location: http://plychannel.com/");

?>
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
			<h3>Sign In</h3>
			<form action="" method="POST">
				<input type="text" name="user" placeholder="Username/Email" />
				<input type="password" name="pass" placeholder="Password" />
				<?php echo "<h5>" . $errors . "</h5>"; ?>
				<input type="submit" value="Sign in" class="Button" name="submitted" style="display:block; width: 312px; margin-left: 0;" />
				<table style="width: 320px;margin-left: -6px;">
					<tr>
						<td><input type="checkbox" name="signedIn" checked/> Stay signed in</td>
						<td style="text-align: right;"><a href="recover" style="text-decoration: none;color: #000;font-size: 13px;font-weight: bold;">Need Help?</a></td>
					</tr>
				</table>
			</form>
		</div>
		<div style="width: 151px;margin-left: auto;margin-right: auto;margin-top: 15px;">
			<a href="signup" style="font-size: 13px; font-weight: bold; color: #000; text-decoration: none;">Create a new account</a>
		</div>
	</body>
</html>