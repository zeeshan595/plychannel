<?php

if (!isset($_COOKIE['Username']))
	die();

require_once("connect.php");

$user = decrypt(urldecode($_COOKIE['Username']));
$vid = addslashes(strip_tags(trim($_POST['vid'])));
$comment = addslashes(strip_tags(trim($_POST['comment'])));
$parent = addslashes(strip_tags(trim($_POST['parent'])));

mysql_query("INSERT INTO `comments` (
		`id`,
		`videoID`,
		`message`,
		`time`,
		`author`,
		`likes`,
		`dislikes`,
		`parent`,
		`reports`
	) VALUES(
		'',
		'$vid',
		'$comment',
		'".time()."',
		'$user',
		'0',
		'0',
		'$parent',
		'0'
	)");
?>