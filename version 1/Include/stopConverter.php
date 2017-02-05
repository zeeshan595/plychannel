<?php
$pid = stripslashes(strip_tags(trim($_POST['pid'])));

if (!preg_match_all("/[0-9]+/", $pid, $matches))
	die("Couldn't match pid's: " . $pid);

if (sizeof($matches[0]) != 2)
{
	print_r($matches);
	die("Incorrect match of size: " . sizeof($matches[0]));
}
echo shell_exec("sudo kill -9 " . $matches[0][0]);
echo shell_exec("sudo kill -9 " . $matches[0][1]);

?>