<?php
if (isset($_POST['user']))
{
	require_once("/var/www/Include/connect.php");
	$user = $_POST['user'];
	if (!preg_match("/^[a-zA-Z0-9\-\_\@\+\.]{3,45}$/", $user))
	{
		die("fail");
	}
	$check = mysql_query("SELECT * FROM `users` WHERE `Username` = '".mysql_real_escape_string($user)."' LIMIT 1");
	if (mysql_num_rows($check) == 0)
	{
		echo "true";
	}
	else
	{
		echo "false";
	}
}
else if (isset($_POST['email']))
{
	require_once("/var/www/Include/connect.php");
	$email = $_POST['email'];
	if (!preg_match("/^([a-zA-Z0-9\-\_\+\.])+@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/", $email))
	{
		die("fail");
	}
	$check = mysql_query("SELECT * FROM `users` WHERE `Email` = '".mysql_real_escape_string($email)."' LIMIT 1");
	if (mysql_num_rows($check) == 0)
	{
		echo "true";
	}
	else
	{
		echo "false";
	}
}
else if (isset($_POST['password']))
{
	require_once("/var/www/Include/connect.php");
	$password = $_POST['password'];
	if (!preg_match("/^[a-zA-Z0-9\-\_\@\#\$\%\^\&\*\(\)\+]{3,45}$/", $password))
	{
		die("fail");
	}
	else
	{
		echo "true";
	}
}
?>