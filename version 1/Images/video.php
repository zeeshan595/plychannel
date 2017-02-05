<?php
if (!isset($_GET['i']))
	die();

$i = stripcslashes(strip_tags(trim($_GET['i'])));

if (isset($_GET['w']))
	$w = stripcslashes(strip_tags(trim($_GET['w'])));
else
	$w = 800;

if (isset($_GET['h']))
	$h = stripcslashes(strip_tags(trim($_GET['h'])));
else
	$h = 600;


if ($w > 800)
	$w = 800;

if ($h > 600)
	$h = 600;

require_once("/var/www/Include/encrypt.php");

$i = decrypt(urldecode($i));

header('Content-Type: image/jpeg');
$url = '/var/www/Uploads/' . $i . '.jpg';
if (file_exists($url))
{
	if ($h == 600 && $w == 800)
    	$im = file_get_contents($url);
    else
    {
	    //Get Dimentions
	    list($width, $height) = getimagesize($url);
	    $new_width = $w;
	    $new_height = $h;

	    //Resample
	    $image_p = imagecreatetruecolor($new_width, $new_height);
		$image = imagecreatefromjpeg($url);
		imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
		imagejpeg($image_p, null, 100);
	}
}
else
{
    $im = file_get_contents("/var/www/Images/404.png");
}
echo $im;
?>