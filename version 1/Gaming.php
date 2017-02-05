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
<meta name="keywords" content="video, sharing, family, plychannel, ply channel, ago, views, month, months, days, westnstyle, camera, phone, free, upload, Ply Channel" />
<meta name="author" content="Zeeshan Abid" />
<link rel="shortcut icon" href="Images/favicon.ico" />

<title>PlyChannel</title>

<!-- og Tags -->

<meta property="og:title" content="PlyChannel"/>
<meta property="og:type" content="html"/>
<meta property="og:image" content="http://plychannel.com/logo.png"/>
<meta property="og:image:type" content="image/png">
<meta property="og:image:width" content="300">
<meta property="og:image:height" content="33">

<meta property="og:url" content="http://plychannel.com/"/>
<meta property="og:description" content="video, sharing, family, plychannel, ply channel"/>

<?php require_once("Include/navigation.php");?>

<?php
require_once("Include/extraFunctions.php");
require_once("Include/encrypt.php");
require_once("Include/connect.php");

if (isset($_GET['p']))
	$p = stripcslashes(strip_tags(trim($_GET['p'])));
else
	$p = 0;

$videosPerPage = 30;
$min = $p * 30;

$category = "Gaming";
echo "<h2>".$category."</h2>";
$query = mysql_query("SELECT * FROM `videos` WHERE `Uploaded` = '1' AND `Privacy` = 'a' AND `Category` = '".$category."' ORDER BY `Time` DESC LIMIT $min, $videosPerPage");

$totalVideos =  mysql_query("SELECT COUNT(`ID`) as 'Title' FROM `videos` WHERE `Uploaded` = '1' AND `Privacy` = 'a' AND `Category` = '".$category."' LIMIT 100");
$totalVideos = mysql_fetch_array($totalVideos);
$totalVideos = $totalVideos[0];

while ($row = mysql_fetch_array($query))
{
?>
	<div class="col-6 col-sm-6 col-lg-4" style="width: 220px;">
		<a href="http://plychannel.com/watch?v=<?php echo encrypt($row['ID']); ?>" title="<?php echo $row['Title']; ?>">
			<div class="videoThumb">
				<div style="position:relative; width:0; height:0;top:0;left:0;"><span id="videoTime"><?php echo $row['Length']; ?></span></div>
				<img data-src="holder.js/200x120" class="img-thumbnail" alt="200x120" style="width: 200px; height: 120px;" src="http://plychannel.com/Images/video?i=<?php echo encrypt($row['ID']); ?>">
				<h3>
					<?php
					$title = $row['Title']; 
					if (strlen($title) > 31)
					  $title = substr($title, 0, 27) . "...";
					echo $title;
					?>
				</h3>
				<p>
					<?php echo $row['Author']; ?><br />
					<?php echo $row['Views']; ?><br />
					<?php echo timeToString($row['Time']); ?>
				</p>
			</div>
		</a>
	</div>
<?php
}
?>


</div>
<div>
<ul class="pagination">
  
<?php
   if ($p == 0)
    echo "<li class='disabled'><a>&laquo;</a></li>";
   else
    echo "<li><a href='?cat=".$category."&p=".($p-1)."'>&laquo;</a></li>";

  for($x = 0; $x < ($totalVideos / $videosPerPage); $x++)
  {
    if ($x == $p)
      echo "<li class='active'><a href='?cat=".$category."&p=".$x."'><span>".($x + 1)."</span></a></li>";
    else
      echo "<li><a href='?cat=".$category."&p=".$x."'><span>".($x + 1)."</span></a></li>";
  }

  if (($p + 1) >= ($totalVideos / $videosPerPage))
    echo "<li class='disabled'><a>&raquo;</a></li>";
  else
    echo "<li><a href='?cat=".$category."&p=".($p+1)."'>&raquo;</a></li>";
?>
  
</ul>
<?php require_once("Include/footer.php"); ?>