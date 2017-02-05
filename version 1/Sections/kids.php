<?php
  require_once("Include/connect.php");
  require_once("Include/encrypt.php");
  require_once("Include/extraFunctions.php");
  $query = mysql_query("SELECT * FROM `videos` WHERE `Category` = 'Kids & Cartoons' AND `Uploaded` = '1' AND `Privacy` = 'a' AND `Time` > '".(time() - 2678400)."' ORDER BY `Views` DESC ,`Time` DESC LIMIT 15");
?>
<script type="text/javascript">
	$(window).resize(function() {
    resizeSectionKids();
  });
  $(document).ready(function (){
    resizeSectionKids();
  });

  function resizeSectionKids()
  {
    if ($(window).width() > 1184)
      $("#KidsSection").css('width', 1150 + 'px');
    else if ($(window).width() > 976)
      $("#KidsSection").css('width', 949 + 'px');
    else if ($(window).width() > 765)
      $("#KidsSection").css('width', 715 + 'px');
    else
      $("#KidsSection").css('width', 735 + 'px');
  }
</script>
<h3 style="font-size: 18px;font-weight: bold;color: #000;">
  <a href="http://plychannel.com/Kids+Cartoons">Kids & Cartoons</a>
</h3>
<div id="KidsSection" style="margin-left:10px;margin-right:10px;overflow-x:scroll;overflow-y:hidden;height:220px;">
<table>
<tr>
<?php 
  while($row = mysql_fetch_array($query))
  {
?>
<!-- START -->
<td style='min-width:210px;'>
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
</td>
<!-- END -->
<?php
  }
?>
</tr>
</table>
</div>