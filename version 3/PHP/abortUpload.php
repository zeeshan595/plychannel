<?php

$id = stripcslashes(strip_tags(trim($_POST['id'])));
$pid = stripcslashes(strip_tags(trim($_POST['pid'])));

if (!preg_match_all("/[0-9]+/", $pid, $matches))
	die("Couldn't match pid's: " . $pid);

if (sizeof($matches[0]) != 2)
{
	print_r($matches);
	die("Incorrect match of size: " . sizeof($matches[0]));
}
echo shell_exec("kill -9 " . $matches[0][0]);
echo shell_exec("kill -9 " . $matches[0][1]);

require_once("connect.php");

$user = decrypt(urldecode($_COOKIE['Username']));

$checkDone = mysql_query("SELECT * FROM `videos` WHERE `ID` = '$id' AND `Author` = '$user' LIMIT 1");
$checkDone = mysql_fetch_array($checkDone);
$checkDone = $checkDone['Uploaded'];
if ($checkDone == '1')
	die($id);



mysql_query("DELETE FROM `videos` WHERE `ID` = '$id' AND `Author` = '$user' LIMIT 1");

shell_exec("rm /var/www/Uploads/num".$id.".mp4");
shell_exec("rm /var/www/Uploads/num".$id.".webm");

shell_exec("rm /var/www/Uploads/".$id.".jpg");

shell_exec("rm /var/www/Logs/mp4".$id.".txt");
shell_exec("rm /var/www/Logs/webm".$id.".txt");

if (isset($_POST['name']))
{
	$name = stripcslashes(strip_tags(trim($_POST['name'])));
	$ext = end(explode(".", $name));
	shell_exec("rm /var/www/Temp/num" . $id . "." . $ext);
	echo "DELETED FILE: " . $name . " | " . $ext;
}

?>