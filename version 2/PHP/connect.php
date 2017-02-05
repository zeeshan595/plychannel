<?php
require_once("helpers.php");
if (getPageUrl() == "plychannel.com/included/connect.php" || getPageUrl() == "plychannel.com/included/connect")
{
	header("Location: http://plychannel.com/404");
}

$con = mysql_connect("localhost","root" , "hS7J1Muc58") or die ("Cannot connect!");
if (!$con)
	die('Could not connect: ' . mysql_error());
$conn = mysql_select_db("Plychannel" , $con) or die ("could not load the database");


//LOGIN CHECK

if (isset($_COOKIE['Username']))
{
	$user = decrypt(urldecode($_COOKIE['Username']));
	$login = mysql_query("SELECT * FROM `users` WHERE `Username` = '$user' LIMIT 1");
	if (mysql_num_rows($login) > 0)
	{
		$loginData = mysql_fetch_array($login);
		if ($loginData['Blocked'] == 1)
		{
			setcookie("Username", "", time() - 3600);
		}
	}
	else
	{
		setcookie("Username", "", time() - 3600);
	}
}

?>