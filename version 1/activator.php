<?PHP
require_once('/var/www/Include/header.php');

?>

<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="description" content="A video sharing website, where you can share videos with your friends, family and others." />
<meta name="keywords" content="video, sharing, family, plychannel, ply channel" />
<meta name="author" content="Zeeshan Abid" />
<link rel="shortcut icon" href="Images/favicon.ico" />

<title>Plychannel - Activate Account</title>

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

require_once('/var/www/Include/navigation.php');
require_once('Include/connect.php');
$message = "<h5>There was a error activating your account. please contact us for more details.</h5>";
if (isset($_GET['u']) && isset($_GET['k']))
{
	$code = mysql_real_escape_string(strip_tags(urldecode($_GET['u'])));
	$key = $_GET['k'];
	if (preg_match("/[0-9]{3,50}/", $key))
	{
		$key = mysql_real_escape_string(strip_tags($key));
		$find  = mysql_query("UPDATE `users` SET `Active` = '1' WHERE `Username` = '".$code."' AND `Code` = '".$key."'");
		if ($find)
		{
			$message = "<h5>Your account is now activated.</h5>";
		}
	}
}

echo $message;
require_once('Include/footer.php');
?>