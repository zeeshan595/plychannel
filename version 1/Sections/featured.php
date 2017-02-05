<style type="text/css">
.featuredBig img {
	width: 400px;
	height: 250px;
}
.featuredBig div {
	font-weight: bold;
	padding: 5px;
	font-size: 15px;
	color: #FE563B;
}

.featuredBig span {
	display: block;
	font-weight: bold;
	padding: 1px 0 1px 10px;
	color: #919191;
	font-size: 12px;
}

.featuredSmall {
	height: 75px;
	padding: 3px;
}
.featuredSmall img {
	width: 100px;
	height: 70px;
}
.featuredSmall div {
	position: relative;
	width:230px;
	top: -65px;
	left: 110px;
	font-weight: bold;
}

.featuredSmall span{
	color: #919191;
	font-weight: bold;
	position: relative;
	left: 115px;
	top: -61px;
	display: table;
	font-size: 12px;
}

.downArrow{
	background: url("http://plychannel.com/Images/down-arrow.png");
	background-size: 100%;
	margin-right: auto;
	margin-left: auto;
	width: 500px;
	height:20px;
}
.downArrow:hover{
	background: url("http://plychannel.com/Images/down-arrow - Hover.png");
}

.upArrow{
	background: url("http://plychannel.com/Images/up-arrow - Hover.png");
	background-size: 100%;
	margin-right: auto;
	margin-left: auto;
	width: 500px;
	height:20px;
}
.upArrow:hover{
	background: url("http://plychannel.com/Images/up-arrow - Hover.png");
}
</style>
<script>
$(window).resize(function() {
    resizeSectionFeatured();
  });
  $(document).ready(function (){
    resizeSectionFeatured();
  });

  function resizeSectionFeatured()
  {
	if ($(window).width() > 1184 && $(window).height() > 800)
	{
		$(".featuredBig img").css('width', 800 + 'px');
		$(".featuredBig img").css('height', 600 + 'px');
		$('[id=featuredMedium]').each(function(){
			$(this).css('display', 'block');
		});
		$('[id=featuredLarge]').each(function(){
				$(this).css('display', 'block');
		});
	}
	else if ($(window).width() > 976 && $(window).height() > 600)
	{
		$(".featuredBig img").css('width', 600 + 'px');
		$(".featuredBig img").css('height', 400 + 'px');
		$('[id=featuredMedium]').each(function(){
			$(this).css('display', 'block');
		});
		$('[id=featuredLarge]').each(function(){
			$(this).css('display', 'none');
		});
	}
	else
	{
		$(".featuredBig img").css('width', 400 + 'px');
		$(".featuredBig img").css('height', 250 + 'px');
		$('[id=featuredMedium]').each(function(){
			$(this).css('display', 'none');
		});
		$('[id=featuredLarge]').each(function(){
			$(this).css('display', 'none');
		});
	}
  }
</script>
<table width='100%'>
<tr>
<?php
	require_once("Include/connect.php");
	require_once("Include/encrypt.php");
	require_once("Include/extraFunctions.php");

	$query = mysql_query("SELECT * FROM `videos` WHERE `Uploaded` = '1' AND `Privacy` = 'a' ORDER BY `Time` DESC, `Views` DESC LIMIT 10");
	$counter = 0;
	while($row = mysql_fetch_array($query))
	{
		if ($counter == 0)
		{
?>
		<td width='250px'>
			<a href="watch?v=<?php echo encrypt($row['ID']); ?>" style="text-decoration: none;">
				<div class="featuredBig">
					<div style="position:relative; width:0; height:0;top:15px;left:0;"><span id="videoTime"><?php echo $row['Length']; ?></span></div>
					<img src="http://plychannel.com/Images/video?i=<?php echo encrypt($row['ID']); ?>" alt="video">
					<div><?php echo $row['Title']; ?></div>
					<span>by <?php echo $row['Author']; ?></span>
					<span><?php echo timeToString($row['Time']); ?> ago</span>
				</div>
			</a>
		</td><td valign="top">
<?php
			$counter = 1;
		}
		else
		{
			if ($counter > 6)
				echo "<div id='featuredLarge'>";
			else if ($counter > 4)
				echo "<div id='featuredMedium'>";
?>
			<a title="<?php echo $row['Title']; ?>" href="watch?v=<?php echo encrypt($row['ID']); ?>" style="text-decoration: none;">
				<div class="featuredSmall">
					<div style="position:relative; width:0; height:0;top:0;left:0;"><span id="videoTime"><?php echo $row['Length']; ?></span></div>
					<img src="http://plychannel.com/Images/video?i=<?php echo encrypt($row['ID']); ?>" alt="video">
					<div>
<?php
$title = $row['Title']; 
if (strlen($title) > 27)
	$title = substr($title, 0, 24) . "...";
echo $title;
?>
					</div>
					<span>by <?php echo $row['Author']; ?></span>
					<span><?php echo timeToString($row['Time']); ?> ago</span>
				</div>
			</a>
<?php
			if ($counter > 6)
				echo "</div>";
			else if ($counter > 4)
				echo "</div>";

			$counter++;
		}
	}
?>
</td>
</tr>
</table>
<div class="downArrow" id="showMoreFeatured"></div>
<div id="moreFeatured" loaded="false" style="margin-left:75px;display:none;"><center>LOADING...</center></div>

<script>
$("#showMoreFeatured").click(function(){
	if ($(this).attr("class") == "downArrow")
	{
		$(this).attr("class", "upArrow");
		if ($("#moreFeatured").attr("loaded") == "false")
		{
			$.ajax({
				url: "http://plychannel.com/Include/featuredList.php",
				type: 'post',
				data: {},
				success: function(data){
					$("#moreFeatured").html(data);
				}
			});
		}
		//inline-block
		$("#moreFeatured").slideDown(700).css("display", "inline-block");
	}
	else
	{
		$(this).attr("class", "downArrow");
		$("#moreFeatured").attr("loaded", "true");
		$("#moreFeatured").slideUp(700);
	}
});
</script>