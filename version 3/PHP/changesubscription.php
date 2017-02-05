<?php

require_once("connect.php");
$id = $_POST['id'];
$email = $_POST['email'];

mysql_query("UPDATE `subscriptions` SET `Email` = '$email' WHERE `ID` = '$id' LIMIT 1");

?>