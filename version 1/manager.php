<?php
if(!isset($_COOKIE['Username']))
{
	header('Location: http://plychannel.com/login?feature=http://plychannel.com/manager');
  die();
}
$videosPerPage = 30;

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
  $query = mysql_query("SELECT * FROM `videos` WHERE `Author` = '$user' AND `Uploaded` = '1'");
  $formDefiner = stripslashes(strip_tags(trim($_POST['formDefiner'])));
  if ($formDefiner == "Delete")
  {
    while($row = mysql_fetch_array($query))
    {
      if (isset($_POST['video_' . $row['ID']]))
        mysql_query("DELETE FROM `videos` WHERE `id` = '".$row['ID']."' LIMIT 1");
    }
  }
  else if ($formDefiner == "AddTo")
  {
    echo "
    <div id='popup'>
    <form action='' method='POST' id='playlistForm'>
      <input type='hidden' id='SubmitPlaylistData' name='SubmitPlaylistData' value='true' />
      <h2>Add to playlist</h2>
      ";
      $playlists = mysql_query("SELECT * FROM `playlists` WHERE `owner` = '$user'");
      if(mysql_num_rows($playlists) > 0)
      {
        echo "
        Add To 
        <select name='playlistPicked'>
        ";
        while($row = mysql_fetch_array($playlists))
        {
          echo "
          <option value='".$row['id']."'>
          ".$row['name']."
          </option>
          ";
        }
        echo "
        </select><br />
        <button type='button' id='AddToPlaylist' class='btn btn-sm btn-primary'>Add</button>
        <br />
        <h2>OR</h2>
        ";
      }
      $videos = mysql_query("SELECT * FROM `videos` WHERE `Author` = '$user' AND `Uploaded` = '1'");
      while($row = mysql_fetch_array($videos))
      {
        if(isset($_POST['video_' . $row['ID']]))
        {
          echo "<input type='hidden' name='video_".$row['ID']."' value='true' />";
        }
      }

      echo"
      <br />
      Create a new playlist and add the items in there.<br /><br />
      Name:<br /><input type='text' name='newPlaylist' /><br />
      <button type='button' id='CreatePlaylistButton' class='btn btn-sm btn-primary'>Create</button>
      <a href='http://plychannel.com/manager'><button type='button' class='btn btn-sm btn-danger'>Cancel</button></a>
    </form>
    </div>
    <br />
  ";
  }
}
else if (isset($_POST['SubmitPlaylistData']))
{
  $submitPlaylistData = stripslashes(strip_tags(trim($_POST['SubmitPlaylistData'])));
  if ($submitPlaylistData == "1")
  {
    $newPlaylist = stripcslashes(strip_tags(trim($_POST['newPlaylist'])));
    mysql_query("INSERT INTO `playlists` (`id`, `name`, `discription`, `owner`) VALUES ('', '$newPlaylist', 'No Description Avalible.', '$user')");
    $playlistId = mysql_insert_id();
    $checkPlaylist = 0;
  }
  else
  {
    $playlistId = stripcslashes(strip_tags(trim($_POST['playlistPicked'])));
    $checkPlaylist = mysql_query("SELECT * FROM `playlist_videos` WHERE `playlistID` = '$playlistId' ORDER BY `videoNumber` DESC LIMIT 1");
    if (mysql_num_rows($checkPlaylist) > 0)
    {
      $checkPlaylist = mysql_fetch_array($checkPlaylist);
      $checkPlaylist = $checkPlaylist['videoNumber'];
      $checkPlaylist += 1;
    }
  }
  
  $videos = mysql_query("SELECT * FROM `videos` WHERE `Author` = '$user' AND `Uploaded` = '1'");
  while($row = mysql_fetch_array($videos))
  {
    if(isset($_POST['video_' . $row['ID']]))
    {
      $videoID = $row['ID'];
      mysql_query("INSERT INTO `playlist_videos` (`id`, `videoNumber`, `playlistID`, `videoID`) VALUES ('', '$checkPlaylist', '$playlistId', '$videoID')");
      $checkPlaylist += 1;
    }
  }
}

?>

<ul class="nav nav-tabs">
  <li class="active"><a href="http://plychannel.com/manager"><img src="http://plychannel.com/Images/videos.png" width="20px" /></a></li>
  <li><a href="http://plychannel.com/managerPlaylist"><img src="http://plychannel.com/Images/playlists.png" width="20px" /></a></li>
</ul>


<?php
$user = decrypt(urldecode($_COOKIE['Username']));

if (isset($_GET['p']))
	$p = strip_tags(trim($_GET['p']));
else
	$p = 0;

$min = $p * $videosPerPage;
$query = mysql_query("SELECT * FROM `videos` WHERE `Author` = '$user' AND `Uploaded` = '1' ORDER BY `Time` DESC LIMIT $min, $videosPerPage");

$totalVideos = mysql_query("SELECT COUNT(`ID`) AS title FROM `videos` WHERE `Author` = '$user' AND `Uploaded` = '1' ORDER BY `Time` DESC");
$totalVideos = mysql_fetch_array($totalVideos);
$totalVideos = $totalVideos[0];
?>
<form action="" method="POST" id="managerForm">
<input type="hidden" value="edit" name="formDefiner" id="formDefiner" />
<table>
<tr>
<td><input type="checkbox" id="checkAllBoxes"></td>
<td><div class="btn-group" style="margin: 15px;">
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
    Action <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" role="menu">
    <li><a href="#" id="EditVideos">Edit</a></li>
    <li><a href="#" id="AddTo">Add To Playlist</a></li>
    <li><a href="#" id="Delete">Delete</a></li>
  </ul>
</div></td></tr></table>
<br />
<?php
while ($row = mysql_fetch_array($query))
{
	$title = $row['Title'];
	$description = $row['Discription'];
  $id = $row['ID'];
  $encid = urlencode(encrypt($id));
?>
<div class="media">
<a class="pull-left" href="http://plychannel.com/watch?v=<?php echo $encid; ?>">
<table>
<tr>
<td><input type="checkbox" id="checkboxes" name="video_<?php echo $id; ?>" value="true"></td>
<td><div style="position:relative; width:0; height:0;top:0;left:0;"><span id="videoTime"><?php echo $row['Length']; ?></span></div><img class="media-object" src="http://plychannel.com/Images/video?i=<?php echo $encid; ?>" ></td>
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

  for($x = 0; $x < ($totalVideos / $videosPerPage); $x++)
  {
    if ($x == $p)
      echo "<li class='active'><a href='?p=".$x."'><span>".($x + 1)."</span></a></li>";
    else
      echo "<li><a href='?p=".$x."'><span>".($x + 1)."</span></a></li>";
  }

  if (($p + 1) >= ($totalVideos / $videosPerPage))
    echo "<li class='disabled'><a>&raquo;</a></li>";
  else
    echo "<li><a href='?p=".($p+1)."'>&raquo;</a></li>";
?>
  
</ul>

<script src="http://plychannel.com/js/manager.js"></script>
<?php require_once("Include/footer.php"); ?>