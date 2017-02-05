<?php
  require_once("Include/connect.php");
  require_once("Include/encrypt.php");
  $query = mysql_query("SELECT * FROM `playlists` WHERE `owner` = '$user' AND `privacy` = 'a' Order BY `id` DESC LIMIT 5");
?>
<script>
	$(window).resize(function() {
    resizePLaylistChannel();
  });
  $(document).ready(function (){
    resizePLaylistChannel();
  });

  function resizePLaylistChannel()
  {
    if ($(window).width() > 1184)
      $("#ChannelPlaylist").css('width', 1150 + 'px');
    else if ($(window).width() > 976)
      $("#ChannelPlaylist").css('width', 949 + 'px');
    else if ($(window).width() > 765)
      $("#ChannelPlaylist").css('width', 715 + 'px');
    else
      $("#ChannelPlaylist").css('width', 735 + 'px');
  }
</script>
<style>
  #ChannelPlaylist img {
    width: 250px;
    height: 150px;
  }
  #ChannelPlaylist span {
    display: block;
    position: relative;
    font-weight: bold;
    font-size: 15px;
    top: -150px;
    left: 260px;
    text-decoration: none;
  }
  #ChannelPlaylist #description {
    position: relative;
    font-size: 12px;
    color: #969696;
    top: -150px;
    width: 400px;
    height: 150px;
    text-decoration: none;
  }

  a:hover{
    text-decoration: none;
  }
</style>
<h3 style="font-size: 18px;font-weight: bold;color: #000;">
  Recent Playlists on <?php echo $channel['ChannelName']; ?>
</h3>
<?php
while ($row = mysql_fetch_array($query))
{
  $plID = $row['id'];
  $img = mysql_query("SELECT * FROM `playlist_videos` WHERE `playlistID` = '$plID' ORDER BY rand() LIMIT 1");
  $img = mysql_fetch_array($img);
  $img = encrypt($img['videoID']);

  $title = $row['name'];
  $description = $row['discription'];
?>
  <a href="http://plychannel.com/playlist?id=<?php echo urlencode(encrypt($plID)); ?>" title="<?php echo $title; ?>">
  <div id="ChannelPlaylist" style="width:0;height: 250px;padding: 20px;">
    <div style="position:relative; width:0; height:0;top:0;left:0;"><span id="videoTime"><?php echo $row['Length']; ?></span></div>
    <img src="http://plychannel.com/Images/video?i=<?php echo $img; ?>" />
    <span><?php echo $title; ?></span>
    <span id="description">
<?php
  if (strlen($description) > 400)
    $description = substr($description, 0, 400) . "...";
  
  echo $description;
?>
    </span>
  </div>
  </a>
<?php
}
?>