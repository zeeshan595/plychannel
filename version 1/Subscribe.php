<?php
require_once("Include/header.php");
if (!isset($_COOKIE['Username']))
	header("Location: http://plychannel.com/login");

require_once("Include/connect.php");
require_once("Include/encrypt.php");

$subscribing = stripcslashes(strip_tags(trim($_GET['u'])));
$user = decrypt(urldecode(stripcslashes(strip_tags(trim($_COOKIE['Username'])))));
$query = mysql_query("SELECT * FROM `users` WHERE  `Username` = '$user' LIMIT 1");
if (mysql_num_rows($query) == 0)
	header("Location: http://plychannel.com/404");

$returningUrl = "";
if (isset($_GET['feature']))
	$returningUrl = stripcslashes(strip_tags(trim($_GET['feature'])));

if (isset($_POST['code']))
{
	$code = stripcslashes(strip_tags(trim($_POST['code'])));
	$check = mysql_query("SELECT * FROM `subscriptions` WHERE `Username` = '$user' AND `Subscribed` = '$subscribing' LIMIT 1");
	
	$securityCheck = mysql_query("SELECT * FROM `users` WHERE `Username` = '$user' AND `Code` = '$code' LIMIT 1");
	if (mysql_num_rows($securityCheck) == 0)
		header("Location: http://plychannel.com/404");

	if (mysql_num_rows($check) == 0)
	{
		mysql_query("INSERT INTO `subscriptions` (`Time`, `ID`, `Username`, `Subscribed`, `Email`, `Order`, `Videos`) VALUES ('".time()."', '', '$user', '$subscribing', '".isset($_POST['emailNot'])."', '0', '15')");
	}
	else
	{
		mysql_query("DELETE FROM `subscriptions` WHERE `Username` = '$user' AND `Subscribed` = '$subscribing' LIMIT 1");
	}
	header("Location: " . $returningUrl);
}
function toNumber($dest)
{
    if ($dest)
        return ord(strtolower($dest)) - 96;
    else
        return 0;
}
?>
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="description" content="A video sharing website, where you can share videos with your friends, family and others." />
<meta name="keywords" content="video, sharing, family, plychannel, ply channel, ago, views, month, months, days, westnstyle" />
<meta name="author" content="Zeeshan Abid" />
<link rel="shortcut icon" href="Images/favicon.ico" />

<title>Plychannel</title>

<!-- og Tags -->

<meta property="og:title" content="Plychannel.com"/>
<meta property="og:type" content="html"/>
<meta property="og:image" content="http://plychannel.com/logo.png"/>
<meta property="og:image:type" content="image/png">
<meta property="og:image:width" content="300">
<meta property="og:image:height" content="33">

<meta property="og:url" content="http://plychannel.com/"/>
<meta property="og:description" content="video, sharing, family, plychannel, ply channel"/>
<?php
require_once("Include/navigation.php");
$user = decrypt(urldecode(stripcslashes(strip_tags(trim($_COOKIE['Username'])))));
$code = toNumber($_SERVER["SERVER_NAME"]);
mysql_query("UPDATE  `users` SET  `Code` =  '$code' WHERE  `Username` = '$user' LIMIT 1");
$check = mysql_query("SELECT * FROM `subscriptions` WHERE `Username` = '$user' AND `Subscribed` = '$subscribing' LIMIT 1");
if (mysql_num_rows($check) == 0)
{
?>
	<h5>Are you sure you want to subscribe to <?php echo $subscribing; ?></h5><br />
	<form action="" method="POST">
		<input type="hidden" value="<?php echo $code; ?>" name="code" />
		<input type="checkbox" name="emailNot" value="true" />Send an email when <?php echo $subscribing; ?> uploads a video<br />
		<button type="submit" class="btn btn-sm btn-primary">Yes</button>
		<a href="<?php echo $returningUrl; ?>"><button class="btn btn-sm btn-primary">No</button></a>
	</form>
<?php
}
else
{
?>
	<h5>Are you sure you want to unsubscribe to <?php echo $subscribing; ?></h5><br />
	<form action="" method="POST">
		<input type="hidden" value="<?php echo $code; ?>" name="code" />
		<button type="submit" class="btn btn-sm btn-primary">Yes</button>
		<a href="<?php echo $returningUrl; ?>"><button class="btn btn-sm btn-primary">No</button></a>
	</form>
<?php
}
?>



<?php require_once("Include/footer.php"); ?>