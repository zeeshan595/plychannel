<?php
if(!isset($_COOKIE['Username']))
{
	header('Location: http://plychannel.com/login?feature=http://plychannel.com/manager');
  die();
}
$PlaylistsPerPage = 30;

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
</style>

<?php

require_once("Include/connect.php");
require_once("Include/encrypt.php");

$user = decrypt(urldecode($_COOKIE['Username']));

if (isset($_POST['formDefiner']))
{
  $query = mysql_query("SELECT * FROM `playlists` WHERE `owner` = '$user'");
  $formDefiner = stripslashes(strip_tags(trim($_POST['formDefiner'])));
  if ($formDefiner == "Delete")
  {
    while($row = mysql_fetch_array($query))
    {
      if (isset($_POST['play_' . $row['id']]))
      {
        mysql_query("DELETE FROM `playlists` WHERE `id` = '".$row['id']."' LIMIT 1");
        mysql_query("DELETE FROM `playlist_videos` WHERE `playlistID` = '".$row['id']."'");
      }

    }
  }
}

?>

<ul class="nav nav-tabs">
  <li><a href="http://plychannel.com/manager"><img src="http://plychannel.com/Images/videos.png" width="20px" /></a></li>
  <li class="active"><a href="http://plychannel.com/managerPlaylist"><img src="http://plychannel.com/Images/playlists.png" width="20px" /></a></li>
</ul>


<?php
$user = decrypt(urldecode($_COOKIE['Username']));

if (isset($_GET['p']))
	$p = strip_tags(trim($_GET['p']));
else
	$p = 0;

$min = $p * $PlaylistsPerPage;
$query = mysql_query("SELECT * FROM `playlists` WHERE `owner` = '$user' LIMIT $min, $PlaylistsPerPage");

$totalPlaylists = mysql_query("SELECT COUNT(`ID`) AS title FROM `playlists` WHERE `owner` = '$user'");
$totalPlaylists = mysql_fetch_array($totalPlaylists);
$totalPlaylists = $totalPlaylists[0];
?>
<div class="alert alert-info">
<strong>Heads up!</strong> Edit will only select the first playlist you selected. We only support one playlist being edited at a time.
</div>
<form action="" method="POST" id="managerForm">
<input type="hidden" value="edit" name="formDefiner" id="formDefiner" />
<table>
<tr>
<td><input type="checkbox" id="checkAllBoxes" /></td>
<td><div class="btn-group" style="margin: 15px;">
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
    Action <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" role="menu">
    <li><a href="#" id="EditPlaylist">Edit</a></li>
    <li><a href="#" id="DeletePlaylist">Delete</a></li>
  </ul>
</div></td></tr></table>
<br />
<?php
while ($row = mysql_fetch_array($query))
{
	$title = $row['name'];
	$description = $row['discription'];
  $id = $row['id'];
  $encid = urlencode(encrypt($id));
  $img = mysql_query("SELECT * FROM `playlist_videos` WHERE `playlistID` = '$id' ORDER BY rand() ASC LIMIT 1");
  $img = mysql_fetch_array($img);
  $img = urlencode(encrypt($img['videoID']));
?>
<div class="media">
<a class="pull-left" href="http://plychannel.com/playlist?id=<?php echo $encid; ?>">
<table>
<tr>
<td><input type="checkbox" id="checkboxes" name="play_<?php echo $id; ?>" value="true"></td>
<td><img class="media-object" src="http://plychannel.com/Images/video?i=<?php echo $img; ?>" ></td>
<td valign="top"><div class="media-body">
<h4 class="media-heading"><?php echo $title; ?></h4>
<?php
preg_match_all("/\<br \/\>/", $description, $matches);
$desSize = (sizeof($matches) * 50) + strlen(strip_tags($description));
if ($desSize < 300)
{
  echo substr($description, 0, 300) . "...";
}
?>
</div>
</td>
</tr>
</table>
</a>
</div>
<?php
}
?>
</form>
<ul class="pagination">
  
<?php
   if ($p == 0)
    echo "<li class='disabled'><a>&laquo;</a></li>";
   else
    echo "<li><a href='?p=".($p-1)."'>&laquo;</a></li>";

  for($x = 0; $x < ($totalPlaylists / $PlaylistsPerPage); $x++)
  {
    if ($x == $p)
      echo "<li class='active'><a href='?p=".$x."'><span>".($x + 1)."</span></a></li>";
    else
      echo "<li><a href='?p=".$x."'><span>".($x + 1)."</span></a></li>";
  }

  if (($p + 1) >= ($totalPlaylists / $PlaylistsPerPage))
    echo "<li class='disabled'><a>&raquo;</a></li>";
  else
    echo "<li><a href='?p=".($p+1)."'>&raquo;</a></li>";
?>
  
</ul>

<script src="http://plychannel.com/js/manager.js"></script>
<?php require_once("Include/footer.php"); ?>