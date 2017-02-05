<?php

require_once("Include/connect.php");
require_once("Include/encrypt.php");

$id = stripcslashes(strip_tags(trim(decrypt(urldecode($_GET['id'])))));
$playlist = mysql_query("SELECT * FROM `playlists` WHERE `id` = '$id' LIMIT 1");
if (mysql_num_rows($playlist) == 0)
{
  header("Location: http://plychannel.com/404");
}
$playlist = mysql_fetch_array($playlist);

$edit = false;

if (isset($_GET['edit']) && isset($_COOKIE['Username']) && decrypt(urldecode($_COOKIE['Username'])) == $playlist['owner'])
{
  $edit = true;
}

require_once("Include/header.php"); ?>

<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="description" content="A video manager for your videos." />
<meta name="keywords" content="video, sharing, family, plychannel, ply channel" />
<meta name="author" content="Zeeshan Abid" />
<link rel="shortcut icon" href="Images/favicon.ico" />

<title>Plychannel - Video Manager</title>

<!-- og Tags -->

<meta property="og:title" content="Plychannel.com"/>
<meta property="og:type" content="html"/>
<meta property="og:image" content="http://plychannel.com/logo.png"/>
<meta property="og:image:type" content="image/png">
<meta property="og:image:width" content="300">
<meta property="og:image:height" content="33">

<meta property="og:url" content="http://plychannel.com/"/>
<meta property="og:description" content="A video manager for your videos."/>

<?php require_once("Include/navigation.php");?>

<style>
  .media-object{
    width:150px;
    height:90px;
  }
  .media-heading {
    font-size: 15px;
    font-weight: bold;
    color: #FE563B;
  }
  .media-body {
    color: #999999;
    font-size: 13px;
    font-weight: bold;
  }

  a:hover{
    text-decoration: none;
  }

  h3{
    color: #000;
    font-size: 16px;
    font-weight: bold;
  }

  p{
    color: #999999;
    font-size: 13px;
    font-weight: bold;
  }
  #sortable { 
    list-style-type: none;
    margin: 0;
    padding: 0;
    width: 100%;
  }
  #sortable li {
    margin: 0 3px 3px 3px;
    padding: 0.4em;
    padding-left: 1.5em;
    font-size: 1.4em;
    height: 100px; 
  }
  #deleteVideo {
    width: 100%;
    height: 100px;
    border: 1px #999999 solid;
    margin-top: 10px;
    text-align: center;
    padding: 35px;
  }
</style>

<?php

if ($edit)
{
?>
  <div class="alert alert-info">
  <strong>Help!</strong> To reposition the videos just drag them where you want them in the playlist.
  </div>
<?php
}

$title = $playlist['name'];
$pDescription = $playlist['discription'];
$author = $playlist["owner"];

if ($edit)
{
preg_replace("/\<br \/\>/", "\n", $pDescription);

?>
  <form action="" method="POST">
  <button type="button" class="btn btn-default" data-toggle="dropdown">Save</button><br />
  <input type="text" value="<?php echo $title; ?>" name="title" /><br />
  <textarea name="description" style="margin-top: 10px;resize: none;height: 124px;width: 100%;"><?php echo $author . "<br />" . $pDescription; ?></textarea>
  <input type="hidden" value="true" name="SUBMITT" />
  <div id="deleteVideo">Drag videos here to remove them from the playlist</div>
  <ul id="sortable">
<?php
}
else
{
?>
  <h3><?php echo $title; ?></h3>
  <p><?php echo $author . "<br />" . $pDescription; ?></p>
<?php
}
$counter = 0;
$videos = mysql_query("SELECT * FROM `playlist_videos` WHERE `playlistID` = '$id' ORDER BY `videoNumber` ASC");
while($row = mysql_fetch_array($videos))
{
  $id = $row['videoID'];
  $encid = urlencode(encrypt($id));
  $check = mysql_query("SELECT * FROM `videos` WHERE `ID` = '$id'");
  $check = mysql_fetch_array($check);
  $title = $check['Title'];
  $description = $check['Discription'];
  if ($edit)
    echo "<li>";
?>
<div class="media">
<a class="pull-left" href="http://plychannel.com/watch?v=<?php echo $encid; ?>&p=<?php echo urlencode(encrypt($playlist['id'])); ?>">
<table>
<tr>
<td><img class="media-object" src="http://plychannel.com/Images/video?i=<?php echo $encid; ?>" ></td>
<td valign="top"><div class="media-body">
<h4 class="media-heading"><?php echo $title; ?></h4>
<?php
$charLimit = 200;

preg_match_all("/\<br \/\>/", $description, $matches);
$desSize = (sizeof($matches[0]) * 100) + strlen(strip_tags($description));

if ($desSize > $charLimit)
{
  preg_match_all("/\<br \/\>/", substr($description, 0, $charLimit), $newLines);
  $newLines = sizeof($newLines[0]) * 100;
  echo substr($description, 0,  $charLimit - $newLines) . "...";
}
else
{
  echo $description;
}
?>
</div>
</td>
</tr>
</table>
</a>
</div>
<?php
if ($edit)
  echo "</li>";

$counter++;
}
if ($edit)
{
?>
</form>
</ul>
<?php
}
?>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script src="js/playlist.js"></script>
<?php require_once("Include/footer.php"); ?>