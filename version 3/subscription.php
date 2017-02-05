<?php
	if (!isset($_COOKIE['Username']))
		header("Location: http://plychannel.com/signin?feature=http://plychannel.com/history");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Traditional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-traditional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="Styles/toolbar.css" type="text/css" rel="stylesheet" />
		<link href="Styles/page.css" type="text/css" rel="stylesheet" />
		<title>Subscriptions - Plychannel</title>
	</head>

	<body>
		
		<?php require_once("PHP/toolbar.php"); ?>
		<?php require_once("PHP/connect.php"); ?>

		<div class="content">
			<div class="section">
			    <h3>Subscriptions</h3>
			    <table>
			    	<tr>
			    		<td valign="middle"></td>
			    		<td valign="middle" style="width: 100%;">Channel Name</td>
			    		<td valign="middle">Email</td>
			    		<td valign="middle"></td>
			    	</tr>
			    
<?php
				require_once("PHP/connect.php");
				$subs = mysql_query("SELECT * FROM `subscriptions` WHERE `Username` = '$user'");
				while($row = mysql_fetch_array($subs))
				{
?>
			    	<tr id="subItem" number="<?php echo $row['ID']; ?>">
			    		<td valign="middle"><a href="http://plychannel.com/channel/<?php echo $row['Subscribed']; ?>"><img src="http://plychannel.com/Images/author?u=<?php echo $row['Subscribed']; ?>" alt="Author Image" style="width: 50px; height: 50px; margin-top: 11px;" /></a></td>
			    		<td valign="middle" style="width: 100%;"><a style="color: #000;font-size: 14px;font-weight: bold;" href="http://plychannel.com/channel/<?php echo $row['Subscribed']; ?>"><?php echo $row['Subscribed']; ?></a></td>
			    		<td valign="middle"><input type="checkbox" id="EmailCheck" number="<?php echo $row['ID']; ?>" <?php if ($row['Email'] == '1') echo "checked"; ?> /></td>
			    		<td valign="middle"><button class="Button" id="unsub" number="<?php echo $row['ID']; ?>">Unsubscribe</button></td>
			    	</tr>
<?php
				}
?>
				</table>
			</div>
		</div>

		<?php require_once("PHP/footer.php"); ?>
		<!-- JS -->
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script type="text/javascript" src="Javascript/toolbar.js"></script>
		<script type="text/javascript" src="Javascript/subscriptions.js"></script>
	</body>
</html>