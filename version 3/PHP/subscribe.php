<?php

require_once("connect.php");
$author = $_POST['author'];
$key = $_POST['key'];

$code = mysql_query("SELECT `Code` FROM `users` WHERE `Username` = '$user' LIMIT 1");
$code = mysql_fetch_array($code);
$code = $code[0];

if ($key == $code)
{
	mysql_query("UPDATE `users` SET `Code` = '".rand(999, 9999)."' WHERE `Username` = '$user' LIMIT 1");
	mysql_query("INSERT INTO `subscriptions` (`Time`, `Username`, `Subscribed`, `Email`, `Order`, `Videos`) VALUES ('".time()."', '$user', '$author', '0', '0', '15')");
	$id = mysql_insert_id();
?>
	
	<div author="<?php echo $author; ?>" number="<?php echo $id; ?>" id="subButton" sub="1" class="subscribed"></div>

<?
}
?>