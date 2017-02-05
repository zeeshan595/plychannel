<?php
require_once("Include/header.php");
if (!isset($_COOKIE['Username']))
	header("Location: http://plychannel.com/login");

?>
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="description" content="A video sharing website, where you can share videos with your friends, family and others." />
<meta name="keywords" content="video, sharing, family, plychannel, ply channel, ago, views, month, months, days, westnstyle" />
<meta name="author" content="Zeeshan Abid" />
<link rel="shortcut icon" href="Images/favicon.ico" />

<title>Plychannel - Subscriptions</title>

<!-- og Tags -->

<meta property="og:title" content="Plychannel.com"/>
<meta property="og:type" content="html"/>
<meta property="og:image" content="http://plychannel.com/logo.png"/>
<meta property="og:image:type" content="image/png">
<meta property="og:image:width" content="300">
<meta property="og:image:height" content="33">

<meta property="og:url" content="http://plychannel.com/"/>
<meta property="og:description" content="video, sharing, family, plychannel, ply channel"/>
<style>
.subscription {
	padding: 5px;
	margin-bottom: 10px;
}
</style>
<?php
require_once("Include/navigation.php");
require_once("Include/connect.php");
require_once("Include/encrypt.php");
$user = stripcslashes(strip_tags(trim(decrypt(urldecode($_COOKIE['Username'])))));

if (isset($_POST['SUBMITTED']))
{
	$query = mysql_query("SELECT * FROM `subscriptions` WHERE `Username` = '$user' ORDER BY `Order` DESC");
	while ($row = mysql_fetch_array($query))
	{
		$id = $row['ID'];
		if (isset($_POST["remove_" . $row['ID']]))
		{
			mysql_query("DELETE FROM `subscriptions` WHERE `Username` = '$user' AND `ID` = '$id' LIMIT 1");
		}
		else if (isset($_POST["email_" . $row['ID']]))
		{
			mysql_query("UPDATE `subscriptions` SET `Email` = '1' WHERE `ID` = '$id' LIMIT 1");
		}
		else
		{
			mysql_query("UPDATE `subscriptions` SET `Email` = '0' WHERE `ID` = '$id' LIMIT 1");
		}
	}
}
?>
<form action="" method="POST">
<table width="100%">
	<tr>
	<div class="subscription">
		<td></td>
		<td width="50px">Email</td>
		<td width="50px">Remove</td>
	</div>
	</tr>
	<tr>
		<td class="subscription"><button type="submit" class="btn btn-sm btn-default">Save</button><input type="hidden" name="SUBMITTED" value="true" /></td>
		<td class="subscription" width="50px"><input type="checkbox" id="emailAll" /></td>
		<td class="subscription" width="50px"><input type="checkbox" id="removeAll" /></td>
	</tr>

<?php
$query = mysql_query("SELECT * FROM `subscriptions` WHERE `Username` = '$user' ORDER BY `Order` DESC");
while ($row = mysql_fetch_array($query))
{
?>
	<tr>
		<td><span class="subscription"><?php echo $row['Subscribed']; ?></span></td>
		<td class="subscription" width="50px"><input type="checkbox" id="email" name="email_<?php echo $row['ID']; ?>" <?php if ($row['Email'] == '1') echo "checked"; ?> /></td>
		<td class="subscription" width="50px"><input type="checkbox" id="remove" name="remove_<?php echo $row['ID']; ?>" /></td>
	</tr>
<?php
}
?>
</table>
</form>
<script>
$("#emailAll").click(function(){
	$('[id=email]').each(function(){
		$(this).prop('checked', $("#emailAll").prop('checked'));
	});
});
$("#removeAll").click(function(){
	$('[id=remove]').each(function(){
		$(this).prop('checked', $("#removeAll").prop('checked'));
	});
});
</script>
<?php
require_once("Include/footer.php");
?>