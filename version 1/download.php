<?php
echo "<h4>Currently unavailable</h4><br /><a href='http://plychannel.com/manager'>Go Back</a>";
die();

if (!isset($_COOKIE['Username']))
{
	header("Location: http://plychannel.com/login");
	die();
}
require_once("Include/connect.php");
require_once("Include/encrypt.php");

$user = stripcslashes(strip_tags(trim(decrypt(urldecode($_COOKIE['Username'])))));
$query = mysql_query("SELECT * FROM `videos` WHERE `Author` = '$user' AND `Uploaded` = '1'");
while($row = mysql_fetch_array($query))
{
	if (isset($_POST['video_' . $row['ID']]))
	{
		$id = stripcslashes(strip_tags(trim($row['ID'])));
		$check = mysql_query("SELECT * FROM `videos` WHERE `ID` = '$id' LIMIT 1");
		if (mysql_num_rows($check) == 0)
		{
			header("Location: http://plychannel.com/404");
			die($id);
		}
		else
		{
			echo "<h4>Currently unavailable</h4><br /><a href='http://plychannel.com/manager'>Go Back</a>";
		}
	}
}
?>