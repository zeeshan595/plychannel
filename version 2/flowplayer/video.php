<!doctype html>
<?php
if (!isset($_GET['v']) || !isset($_GET['t']))
   die("");

require_once('/var/www/PHP/connect.php');
$ID = trim(stripcslashes(strip_tags(decrypt($_GET['v']))));

if (isset($_GET['p']))
{
   $lastVideo = false;
   $p = trim(stripcslashes(strip_tags(decrypt($_GET['p']))));
   $playlist = mysql_query("SELECT * FROM `playlist_videos` WHERE `playlistID` = '".$p."' AND `videoID` = '".$ID."' LIMIT 1");
   $playlist = mysql_fetch_array($playlist);
   $playlist = $playlist['videoNumber'];
   $playlist = $playlist + 1;
   $playlist = mysql_query("SELECT * FROM `playlist_videos` WHERE `playlistID` = '".$p."' AND `videoNumber` = '".$playlist."' LIMIT 1");
   if(mysql_num_rows($playlist) != 0)
   {
      $playlist = mysql_fetch_array($playlist);
      $playlist = $playlist['videoID'];
      $playlist = "http://plychannel.com/watch?v=" . urlencode(encrypt($playlist)) . "&p=" . urlencode($_GET['p']);
   }
   else
   {
      $lastVideo = true;
   }
}

$vid = mysql_query("SELECT * FROM `videos` WHERE `ID` = '".$ID."' LIMIT 0 , 1");
$vid = mysql_fetch_array($vid);
if ($vid['Privacy'] == 'p')
{
   if ($vid['Author'] != $user)
   {
      preg_match_all("/[a-zA-Z0-9\_\.\@]{3,45}/" , $vid['ViewsAllow'] , $matches);
      $x = 0;
      $CanView = false;
      while($x < count($matches))
      {
         if ($matches[$x][0] == $user)
         {
            $CanView = true;
            break;
         }  
         $x++;
      }
      if (!$CanView)
         die("<h4>This video is private. Ask author to grant you permission.</h4>");
   }
}
else if ($vid['reports'] > 9)
{
   die("<h4>This video was reported and is now blocked from this site.</h4>");
}
mysql_query("UPDATE `videos` SET `Views` = '".($vid['Views'] + 1)."' WHERE `ID` = '".$ID."'");
?>

<head>
   <!-- player skin -->
   <link rel="stylesheet" type="text/css" href="skin/minimalist.css">

   <!-- site specific styling -->
   <style type="text/css">
   body { font: 12px "Myriad Pro", "Lucida Grande", sans-serif; text-align: center; padding-top: 5%; }
   .flowplayer { background-color: #000; }
   .flowplayer .fp-embed {       display: none;   }
   .flowplayer .fp-fullscreen {       display: block;   }
   </style>

   <!-- flowplayer depends on jQuery 1.7.1+ (for now) -->
   <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

   <!-- include flowplayer -->
   <script type="text/javascript" src="flowplayer.min.js"></script>
</head>

<body>
   <!-- the player -->
   <div class="flowplayer" data-ratio="0.75" data-key="$428164314165388" data-swf="flowplayer/flowplayer.swf" data-ratio="0.4167">
      <video>
         <source type="video/webm" src="http://plychannel.com/Uploads/num<?php echo $ID; ?>.webm">
         <source type="video/mp4" src="http://plychannel.com/Uploads/num<?php echo $ID; ?>.mp4">
      </video>
   </div>

   <script type="text/javascript">
      flowplayer.conf.fullscreen = true;
      flowplayer.conf.logo = 'http://plychannel.com/Images/logo.png';
      flowplayer(function (api, root) {
         api.bind("load", function () {

         }).bind("ready", function(e, api, video) {
            if (video.duration == "infinity")
               video.duration = 50;
            // do something when a video is loaded and ready to play
            api.seek(<?php echo trim(stripcslashes(strip_tags($_GET['t']))); ?>, function(){  })
            api.play();   

         api.bind("finish", function(){
            var nextID = "<?PHP if(isset($_GET['p']))echo 1;else echo 0; ?>";
            var lastVideo = "<?php if($lastVideo)echo 1;else echo 0; ?>";
            if(nextID != '0' && lastVideo == '0')
            {
               top.location.replace("<?php echo $playlist; ?>");
            }
         });

         });
      });
      $(".flowplayer").css("width", ($(document).width() - 10) + "px");
      $(".flowplayer").css("height", ($(document).height() - 60) + "px");
   </script>
</body>

<?php
if (isset($_COOKIE['Username']))
{
   if (file_exists("/var/www/Uploads/num" . $ID . ".webm"))
   {
      AddToHistory($ID);
   }
}
?>