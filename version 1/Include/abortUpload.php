<?php
if (!isset($_COOKIE['Username']))
	die();

require_once("/var/www/Include/connect.php");
require_once("/var/www/Include/encrypt.php");

$user = decrypt(urldecode($_COOKIE['Username']));
$id = stripcslashes(strip_tags(trim($_POST['id'])));

$checkDone = mysql_query("SELECT * FROM `videos` WHERE `ID` = '$id' AND `Author` = '$user' LIMIT 1");
$checkDone = mysql_fetch_array($checkDone);
$checkDone = $checkDone['Uploaded'];
if ($checkDone == '1')
	die($id);



mysql_query("DELETE FROM `videos` WHERE `ID` = '$id' AND `Author` = '$user' LIMIT 1");

shell_exec("sudo rm /var/www/Uploads/num".$id.".mp4");
shell_exec("sudo rm /var/www/Uploads/num".$id.".webm");

shell_exec("sudo rm /var/www/Uploads/".$id.".jpg");

shell_exec("sudo rm /var/www/Logs/mp4".$id.".txt");
shell_exec("sudo rm /var/www/Logs/webm".$id.".txt");

if (isset($_POST['name']))
{
	$name = stripcslashes(strip_tags(trim($_POST['name'])));
	$ext = end(explode(".", $name));
	shell_exec("sudo rm /var/www/Temp/num" . $id . "." . $ext);
	echo "DELETED FILE: " . $name . " | " . $ext;
}

echo $id;

?>