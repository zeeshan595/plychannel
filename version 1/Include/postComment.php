<?php
	if (!isset($_COOKIE['Username']))
		die("Please login before leaving a comment.");

	require_once("/var/www/Include/connect.php");
	require_once("/var/www/Include/encrypt.php");

	$user = stripcslashes(strip_tags(trim(decrypt(urldecode($_COOKIE['Username'])))));
	$id = stripcslashes(strip_tags(trim($_POST['id'])));
	$parent = stripcslashes(strip_tags(trim($_POST['parent'])));
	$message = stripcslashes(trim($_POST['message']));

	if (preg_match("/<[^<]+?>/" , $message))
		die("You cannot use html code in comments.");

	$message = preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank">$1</a>', $message);
	$message = nl2br($message);

	mysql_query("
		INSERT INTO `comments`
		(`id`, `videoID`, `message`, `time`, `author`, `likes`,`dislikes`, `parent`) VALUES 
		('', '$id', '$message', '".time()."', '$user', '0', '0', '$parent')");

	if (preg_match_all("/#([a-zA-Z0-9\-\_\@\+]{3,45})/" , $message , $matches) != 0)
	{
		require_once('/var/www/Include/Mail.php');

		for ($i = 0; $i <= count($matches); $i++)
		{
			$EmailChecker = mysql_query("SELECT * FROM `users` WHERE `Username` = '".mysql_real_escape_string($matches[$i][1])."' LIMIT 1");
			if ($EmailChecker)
			{
				if (mysql_num_rows($EmailChecker) > 0)
				{
					$email = mysql_fetch_array($EmailChecker);
					$email = $email['Email'];
					$Message = "
					<a href='http://plychannel.com/'><img src='http://plychannel.com/Images/logo.png' width='100px' /></a><br />
					<h4>".$user." mentioned you in a comment.</h4>Comment:<br />
					<p>".$message."</p>
					";
					SendMail($email , "Plychannel" , $Message);
				}
			}
		}
	}
		
	$commid = mysql_insert_id();
	echo "DONE";
?>