<?php
require_once("Include/header.php");
if (!isset($_COOKIE['Username']))
	header("Location: http://plychannel.com/login?feature=http://plychannel.com/settings");

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
</style>

<?php require_once("Include/navigation.php"); ?>

<ul class="nav nav-tabs">
  <li class="active"><a href="http://plychannel.com/settings">Personal</a></li>
  <li><a href="http://plychannel.com/settingsChannel">Channel</a></li>
  <li><a href="http://plychannel.com/settingsDefaults">Defaults</a></li>
</ul>

<?php 

require_once("Include/connect.php");
require_once("Include/encrypt.php");

$user = stripslashes(strip_tags(trim($_COOKIE['Username'])));
$user = decrypt(urldecode($user));

if (isset($_POST['currentPassword']))
{
	$name = stripcslashes(strip_tags(trim($_POST['name'])));
	$email = stripcslashes(strip_tags(trim($_POST['email'])));
	$pass = stripcslashes(strip_tags(trim($_POST['password'])));
	$pass2 = stripslashes(strip_tags(trim($_POST['password2'])));

	$currentPass = stripslashes(strip_tags(trim($_POST['currentPassword'])));
	$currentPass = encrypt(urlencode($currentPass));

	$query = mysql_query("SELECT * FROM `users` WHERE `Username` = '$user' LIMIT 1");
	$query = mysql_fetch_array($query);

	if ($currentPass != $query['Password'])
	{
?>
		<div class="alert alert-danger">
		  <strong>Something's Wrong!</strong> Your current password doesn't match. To change any settings you need to type your current password.
		</div>
<?php
	}
	else if (!preg_match("/^[a-zA-Z\ @]{3,45}$/", $name))
	{
?>
		<div class="alert alert-danger">
		  <strong>Something's Wrong!</strong> Your name is not in the correct format.
		</div>
<?php
	}
	else if (!preg_match("/^([a-zA-Z0-9\-\_\+\.])+@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})/", $email))
	{
?>
		<div class="alert alert-danger">
		  <strong>Something's Wrong!</strong> Your email is not in the correct format.
		</div>
<?php	
	}
	else if (!preg_match("/^[a-zA-Z0-9\-\_\@\#\$\%\^\&\*\(\)\+]{3,45}$/", $pass))
	{
?>
		<div class="alert alert-danger">
		  <strong>Something's Wrong!</strong> Your password is not in the correct format.
		</div>
<?php	
	}
	else if ($pass != $pass2)
	{
?>
		<div class="alert alert-danger">
		  <strong>Something's Wrong!</strong> Your new passwords do not match.
		</div>
<?php
	}
	else
	{
		$pass = urlencode(encrypt($pass));
		mysql_query("UPDATE `users` SET `Name` = '$name', `Email` = '$email', `Password` = '$pass' WHERE `Username` = '$user' AND `Password` = '$currentPass' LIMIT 1");
		$pass = decrypt(urldecode($pass));
?>
		<div class="alert alert-success">
		 <strong>Done!</strong> All the settings are now saved.
		</div>
<?php
	}
}
else
{
	$query = mysql_query("SELECT * FROM `users` WHERE `Username` = '$user' LIMIT 1");
	$query = mysql_fetch_array($query);
	$name = $query['Name'];
	$email = $query['Email'];
	$pass = decrypt(urldecode($query['Password']));
}

?>

<form class="InputForm" action="" method="POST">
	<div class="formInput">
		<span>Name:</span>
		<input type="text" name="name" value="<?php echo $name; ?>" />
	</div>
	<div class="formInput">
		<span>Email:</span>
		<input type="text" name="email" value="<?php echo $email; ?>" />
	</div>
	<div class="formInput" >
		<span>New Password:</span>
		<input type="password" name="password" value="<?php echo $pass; ?>" />
	</div>
	<div class="formInput" >
		<span>Re-type New Password:</span>
		<input type="password" name="password2" value="<?php echo $pass; ?>" />
	</div>
	<div class="formInput" >
		<span>Current Password:</span>
		<input type="password" name="currentPassword" />
	</div><br />
	<button type="submit" class="btn btn-sm btn-default">Save</button>
</form>

<?php require_once("Include/footer.php"); ?>