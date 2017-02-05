<?php
if (isset($_COOKIE['Username']))
{
	require_once("Include/encrypt.php");
	require_once("Include/connect.php");
	$user = decrypt(urldecode($_COOKIE['Username']));
	$blockCheck = mysql_query("SELECT * FROM `users` WHERE `Username` = '$user' LIMIT 1");
	if (mysql_num_rows($blockCheck) > 0)
	{
		$isBlocked = mysql_fetch_array($blockCheck);
		$isBlocked = $isBlocked['Blocked'];
		if ($isBlocked == '1')
			header("Location: http://plychannel.com/logout");
	}
	else
	{
		header("Location: http://plychannel.com/logout");
	}
}
?>
<!DOCTYPE html>
<html lang="en-US" xmlns:og="http://ogp.me/ns#">
<head>
<meta name="viewport" content="width=700px, user-scalable=yes">