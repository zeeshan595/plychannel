<?php

require_once('/var/www/Include/encrypt.php');
require_once('/var/www/Include/connect.php');

$Username = $_GET['u'];
$image = mysql_query("SELECT * FROM `users` WHERE `Username` = '".$Username."'");
$image = mysql_fetch_array($image);
$image = $image['Image'];

echo $image;
header('Content-Type: image/png');
?>