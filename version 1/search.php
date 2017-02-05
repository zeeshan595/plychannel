<?php
require_once("Include/header.php");
if (!isset($_GET['s']))
	header("Location: http://plychannel.com/");
?>

<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="description" content="A video sharing website, where you can share videos with your friends, family and others." />
<meta name="keywords" content="video, sharing, family, plychannel, ply channel, ago, views, month, months, days, westnstyle" />
<meta name="author" content="Zeeshan Abid" />
<link rel="shortcut icon" href="Images/favicon.ico" />

<title>Plychannel - Home</title>

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
require_once("Include/connect.php");
require_once("Include/encrypt.php");
$search = stripcslashes(strip_tags(trim($_GET['s'])));

preg_match_all("/[a-zA-Z0-9]+/", $search, $matches);
$s = "";
$o = "";
for ($x = 0; $x < sizeof($matches[0]); $x++)
{
	$match = $matches[0][$x];
	$s .= "`Title` LIKE '%".$match."%' OR `Tags` LIKE '%".$match."%' OR `Description` LIKE '%".$match."%' OR";
  $o .= " WHEN `Title` LIKE '".$match."%' THEN " . (($x * 3) + 0);
  $o .= " WHEN `Title` LIKE '% %".$match." %' THEN " . (($x * 3) + 1);
  $o .= " WHEN `Title` LIKE '%".$match."' THEN " . (($x * 3) + 2);
}
if (sizeof($matches) > 0)
{
	$s = substr($s, 0, -3);
	$s = " AND (" . $s . ")";
}


$videosPerPage = 30;

$min = $p * $videosPerPage;
$query = mysql_query("SELECT * FROM `videos` WHERE (`Uploaded` = '1' AND `Privacy` = 'a') $s ORDER BY CASE $o ELSE 3 END LIMIT $min, $videosPerPage  
");
$max = mysql_num_rows($query);
if ($max == 0)
{
?>
	<div class="alert alert-danger">
	<strong>Sorry!</strong> Can't find that video, try searching again.
	</div>
<?php
	require_once("Include/footer.php");
	die();
}
$totalVideos = mysql_query("SELECT COUNT(`ID`) FROM `videos` WHERE (`Uploaded` = '1' AND `Privacy` = 'a' AND `Author` = '$user') $s");
$totalVideos = mysql_fetch_array($totalVideos);
$totalVideos = $totalVideos[0];
?>

<div style="margin-left:15px;">
<?php
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
by <?php echo $row['Author']; ?><br />
<?php echo $row['Views']; ?> views<br />
<?php echo timeToString($row['Time']); ?> ago
</p>
</div>
</a>
</div>
<?php
	}
?>
</div>
</div>
<div>
<ul class="pagination">
  
<?php
   if ($p == 0)
    echo "<li class='disabled'><a>&laquo;</a></li>";
   else
    echo "<li><a href='?u=".$user."&p=".($p-1)."'>&laquo;</a></li>";

  for($x = 0; $x < ($totalVideos / $videosPerPage); $x++)
  {
    if ($x == $p)
      echo "<li class='active'><a href='?u=".$user."&p=".$x."'><span>".($x + 1)."</span></a></li>";
    else
      echo "<li><a href='?u=".$user."&p=".$x."'><span>".($x + 1)."</span></a></li>";
  }

  if (($p + 1) >= ($totalVideos / $videosPerPage))
    echo "<li class='disabled'><a>&raquo;</a></li>";
  else
    echo "<li><a href='?u=".$user."&p=".($p+1)."'>&raquo;</a></li>";
?>
  
</ul>
<?php require_once("Include/footer.php"); ?>