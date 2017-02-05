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

$url = "/var/www/Backgrounds/" . $user . "." . $ext;

unlink($"/var/www/Backgrounds/" . $user . ".jpg");
unlink($"/var/www/Backgrounds/" . $user . ".jpeg");
move_uploaded_file($tmp_name, $url);

$image = imagecreatefromjpeg($url);

$thumb_width = 1160;
$thumb_height = 200;

$width = imagesx($image);
$height = imagesy($image);

$original_aspect = $width / $height;
$thumb_aspect = $thumb_width / $thumb_height;

if ( $original_aspect >= $thumb_aspect )
{
   // If image is wider than thumbnail (in aspect ratio sense)
   $new_height = $thumb_height;
   $new_width = $width / ($height / $thumb_height);
}
else
{
   // If the thumbnail is wider than the image
   $new_width = $thumb_width;
   $new_height = $height / ($width / $thumb_width);
}

$thumb = imagecreatetruecolor( $thumb_width, $thumb_height );

// Resize and crop
imagecopyresampled($thumb,
                   $image,
                   0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
                   0 - ($new_height - $thumb_height) / 2, // Center the image vertically
                   0, 0,
                   $new_width, $new_height,
                   $width, $height);

unlink($url);
imagejpeg($thumb, $url, 80);

require_once("/var/www/Include/connect.php");

mysql_query("UPDATE `users` SET `Background` = 'http://plychannel.com/Backgrounds/".$user.".".$ext."' WHERE `Username` = '$user' LIMIT 1");

?>