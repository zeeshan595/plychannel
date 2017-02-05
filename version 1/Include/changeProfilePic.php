<?php

if(!isset($_COOKIE['Username']))
	die();

require_once("/var/www/Include/encrypt.php");

$user = stripcslashes(strip_tags(trim($_COOKIE['Username'])));
$user = decrypt(urldecode($user));

$file = $_FILES['file'];

$name = $file["name"];
$ext = strtolower(end(explode(".", $name)));
$type = $file['type'];
$tmp_name = $file['tmp_name'];

if ($ext != "jpg" && $ext != "jpeg")
	die();

$url = "/var/www/Temp/" . $user . "." . $ext;

move_uploaded_file($tmp_name, $url);
//Get Dimentions
list($width, $height) = getimagesize($url);
$new_width = 200;
$new_height = 200;

//Resample
$image_p = imagecreatetruecolor($new_width, $new_height);
$image = imagecreatefromjpeg($url);
imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

unlink($url);
imagejpeg($image_p, $url, 100);
$image = addslashes(file_get_contents($url));

require_once("/var/www/Include/connect.php");

mysql_query("UPDATE `users` SET `Image` = '$image' WHERE `Username` = '$user' LIMIT 1");
echo mysql_error();
unlink($url);
?>