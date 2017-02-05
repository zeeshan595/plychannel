<?php

require_once("connect.php");
$id = $_POST['id'];

mysql_query("DELETE FROM `subscriptions` WHERE `ID` = '$id' LIMIT 1");

if (isset($_POST['author']))
{
$author = $_POST['author'];
$key = mysql_query("SELECT `Code` FROM `users` WHERE `Username` = '$user' LIMIT 1");
$key = mysql_fetch_array($key);
$key = $key[0];
?>

	<div author="<?php echo $author; ?>" user="<?php echo $user; ?>" number="<?php echo $key; ?>" id="subButton" sub="0" class="subscribe"></div>

<?php
}
?>