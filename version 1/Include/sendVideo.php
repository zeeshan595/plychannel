<?php

if (!isset($_COOKIE['Username']))
	die();

require_once("/var/www/Include/encrypt.php");
require_once("/var/www/Include/Mail.php");
require_once("/var/www/Include/connect.php");

$user = decrypt(urldecode(stripslashes(strip_tags(trim($_COOKIE['Username'])))));
$rawEmail = stripcslashes(strip_tags(trim($_POST['emails'])));
$id = stripcslashes(strip_tags(trim($_POST['id'])));
$encid = urlencode(encrypt($id));

$query = mysql_query("SELECT * FROM `videos` WHERE `ID` = '$id' LIMIT 1");
$query = mysql_fetch_array($query);
$title = $query['Title'];
$description = $query['Discription'];

preg_match_all("/([a-zA-Z0-9\-\_\+\.])+@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})/", $rawEmail, $emails);
$emails = $emails[0];

for ($x = 0; $x < count($emails); $x++)
{
	$to = $emails[$x];
	$message = "Hi, $user just shared this video with you<br /><a href='http://plychannel.com/watch?v=$encid'>http://plychannel.com/watch?v=$encid<br /><img width='200px' src='http://plychannel.com/Images/video?i=$encid' /><br />$title<br /><br /><br /><br />$description</a>";
	SendMail($to , 'Plychannel - Shared Video' , $message);
}
?>
<div class="alert alert-success">Email sent.</div>