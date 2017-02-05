<?php

require_once("Include/header.php");

if ($_SERVER["SERVER_NAME"] == "64.251.26.114" || $_SERVER["SERVER_NAME"] == "www.plychannel.com")
{
	header("Location: http://plychannel.com/");
}
?>

<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="description" content="Share your videos with friends, family, and the world. Upload videos and Download Videos for Free." />
<meta name="keywords" content="new, indian, movies, watch, online, movies, video, sharing, family, plychannel, ply channel, ago, views, month, months, days, westnstyle, camera, phone, free, upload, Ply Channel" />
<meta name="author" content="Zeeshan Abid" />
<link rel="shortcut icon" href="Images/favicon.ico" />

<title>Ply Channel</title>

<!-- og Tags -->

<meta property="og:title" content="PlyChannel"/>
<meta property="og:type" content="html"/>
<meta property="og:image" content="http://plychannel.com/logo.png"/>
<meta property="og:image:type" content="image/png">
<meta property="og:image:width" content="300">
<meta property="og:image:height" content="33">

<meta property="og:url" content="http://plychannel.com/"/>
<meta property="og:description" content="Share your videos with friends, family, and the world. Upload videos and Download Videos for Free."/>

<?php require_once("Include/navigation.php");?>


<center><h3><u>something big is coming</u></h3></center>

<div style="border:#e0e0e0 1px solid;">
	<?php require_once("Sections/featured.php"); ?>
</div><div style="border:#e0e0e0 1px solid;">
	<?php require_once("Sections/mostViewed.php"); ?>
</div><div style="border:#e0e0e0 1px solid;">
	<?php require_once("Sections/music.php"); ?>
</div><div style="border:#e0e0e0 1px solid;">
	<?php require_once("Sections/gaming.php"); ?>
</div><div style="border:#e0e0e0 1px solid;">
	<?php require_once("Sections/tchnology.php"); ?>
</div><div style="border:#e0e0e0 1px solid;">
	<?php require_once("Sections/news.php"); ?>
</div><div style="border:#e0e0e0 1px solid;">
	<?php require_once("Sections/movies.php"); ?>
</div><div style="border:#e0e0e0 1px solid;">
	<?php require_once("Sections/shows.php"); ?>
</div><div style="border:#e0e0e0 1px solid;">
	<?php require_once("Sections/education.php"); ?>
</div><div style="border:#e0e0e0 1px solid;">
	<?php require_once("Sections/sports.php"); ?>
</div><div style="border:#e0e0e0 1px solid;">
	<?php require_once("Sections/kids.php"); ?>
</div><div style="border:#e0e0e0 1px solid;">
	<?php require_once("Sections/kids.php"); ?>
</div>

<?php require_once("Include/footer.php"); ?>