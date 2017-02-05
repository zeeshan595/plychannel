<?php
  require_once("connect.php");
  require_once("encrypt.php");
  require_once("extraFunctions.php");
  $query = mysql_query("SELECT * FROM `videos` WHERE `Uploaded` = '1' AND `Privacy` = 'a' ORDER BY `Time` DESC, `Views` DESC LIMIT 10, 30");
?>
<?php 
  while($row = mysql_fetch_array($query))
  {
?>
<!-- START -->
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
<!-- END -->
<?php
  }
?>
<br />
<br />