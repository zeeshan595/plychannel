<?php
if (isset($_POST['submitted']))
{
	if (isset($_POST['user']) && isset($_POST['email']) && isset($_POST['pass']) && isset($_POST['pass2']) && isset($_POST['name']))
	{
		require_once("PHP/connect.php");
		$name = strip_tags(trim($_POST['name']));
		$user = strip_tags(trim($_POST['user']));
		$email = strip_tags(trim($_POST['email']));
		$pass = strip_tags(trim($_POST['pass']));
		$pass2 = strip_tags(trim($_POST['pass2']));
		if ($pass2 != $pass)
			$errors = "The 2 passwords do not match.";
		else
		{
			$encPass = urlencode(encrypt($pass));

			//regular expressions
			if(!preg_match("/^[a-zA-Z0-9\-\_\@\+\.]{3,45}$/", $user))
			{
				if (strlen($user) > 45 || strlen($user) < 3)
				{
					$errors = "Username must be between 3 to 45 characters long";
				}
				else
				{
					$errors = "Username is not in the correct format.";
				}
			}
			else if(!preg_match("/^[a-zA-Z\ @]{3,45}$/", $name))
			{
				if (strlen($name) > 45 || strlen($name) < 3)
				{
					$errors = "Name must be between 3 to 45 characters long";
				}
				else
				{
					$errors = "Name is not in the correct format.";
				}
			}
			else if(!preg_match("/^[a-zA-Z0-9\-\_\@\#\$\%\^\&\*\(\)\+]{3,45}$/", $pass))
			{
				if(strlen($pass) > 3 && $pass < 45)
				{
					$errors = "You can only type letters, numbers,_,@ and . for your password.";
				}
				else
				{
					$errors = "Your Password must be between 3 to 45 characters long.";
				}
			}
			else if(!preg_match("/^([a-zA-Z0-9\-\_\+\.])+@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/", $email))
			{
				if(strlen($Password) > 3 && $Password < 200)
				{
					$errors = "Your email is not in the correct format.";
				}
				else
				{
					$errors = "Your email must be between 3 to 200 characters long.";
				}
			}
			else
			{
				$checkUser = mysql_query("SELECT `ID` FROM `users` WHERE `Username` = '$user' LIMIT 1");
				if (mysql_num_rows($checkUser))
					$errors = "That username already exists please chose another one.";
				else
				{
					$pic = file_get_contents("Images/default.png");
					$pic = addslashes($pic);
					$code = rand(999, 9999);
					$create = mysql_query("INSERT INTO `users` (
						`Blocked`,
						`Username`,
						`Password`,
						`Name`,
						`Email`,
						`ChannelName`,
						`About`,
						`Background`,
						`Image`,
						`Channelvideo`,
						`Code`,
						`Active`,
						`Time`,
						`website`,
						`twitter`,
						`facebook`,
						`googleplus`
						) VALUES (
						'0',
						'$user',
						'$encPass',
						'$name',
						'$email',
						'$user\'s Channel',
						'No Description Available.',
						'http://plychannel.com/Images/default_banner.png',
						'$pic',
						'-1',
						'$code',
						'0', 
						'".time()."',
						'',	
						'', 
						'', 
						'');");

					if ($create)
					{
						mysql_query("INSERT INTO `defaults` (`privacy`, `description`, `category`, `author`) VALUES ('a','No Description Avalible.', 'Entertainment' , '$user');");
						require_once("PHPMailer/Mail.php");
						SendMail($email, "Activate Your Account", "Please click the link below to activate your account: \n\n<br /><br /><a href='http://plychannel.com/activate?u=$user&k=$code'>http://plychannel.com/activate?u=$user&k=$code</a>");
						$errors = "Your account has been created please check your email to activate your account.";
					}
					else
					{
						$errors = "ERROR 54: An error occured please contact us so we can fix this.<br />" . mysql_error();
					}
				}
			}
		}
	}
	else
	{
		$errors = "Please enter all the details below.";
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Traditional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-traditional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="Styles/page.css" type="text/css" rel="stylesheet" />
		<title>Sign up - Plychannel</title>
	</head>
	<body>
		<div style="position: fixed;background: #fff;top: 0;left: 0;width: 100%;padding: 5px;">
			<a href="http://plychannel.com/"><img src="Images/logo.png" alt="logo" style="height: 35px;" /></a>
			<a href="signin" class="greyButton" style="text-decoration: none; margin-left: calc(100% - 420px);width: 150px;margin-right: 15px;vertical-align: top;margin-top: 5px;">Already have an account?</a>
		</div>
		<div class="loginBox">
			<h3>Sign Up</h3>
			<form action="" method="POST">
				<?php echo "<h5>" . $errors . "</h5>"; ?>
				<input type="text" name="name" placeholder="Name" value="<?php echo $name; ?>" />
				<input type="text" name="user" placeholder="Username" value="<?php echo $user; ?>" />
				<input type="text" name="email" placeholder="Email" value="<?php echo $email; ?>" />
				<input type="password" name="pass" placeholder="Password" value="<?php echo $pass; ?>" />
				<input type="password" name="pass2" placeholder="Re-Password" value="<?php echo $pass2; ?>" />
				<input type="submit" value="Sign up" name="submitted" class="greyButton" style="display: block;margin-left: auto;margin-right: -12px;" />
			</form>
		</div>
	</body>
</html>