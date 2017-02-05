<?php require_once("Include/header.php"); ?>

<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="description" content="A video sharing website, where you can share videos with your friends, family and others." />
<meta name="keywords" content="video, sharing, family, plychannel, ply channel" />
<meta name="author" content="Zeeshan Abid" />
<link rel="shortcut icon" href="Images/favicon.ico" />

<title>Plychannel - Contact</title>

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
.uploadForm {
	font-size: 13px;
	text-align: left;
	overflow-y: hidden;
	height:auto;
}
.formInput {
	padding: 5px;
}
.formInput span {
	margin-left: 0;
	display: block;
}
.formInput textarea {
	resize: none;
	width: 100%;
	height: 75px;
}
</style>

<?php require_once("Include/navigation.php"); ?>

Email: <a href="mailto:support@plychannel.com">support@plychannel.com</a><br />
Facebook: <a href="https://www.facebook.com/ply.zee595">https://www.facebook.com/ply.zee595</a><br />
Twitter: <a href="https://twitter.com/plychannel">https://twitter.com/plychannel</a><br />

<?php
if (isset($_POST['SUBMITTED']))
{
	$name = stripcslashes(strip_tags(trim($_POST['name'])));
	$email = stripcslashes(strip_tags(trim($_POST['email'])));
	$message = stripcslashes(strip_tags(trim($_POST['message'])));

	if (!preg_match("/^[a-zA-Z0-9(\ )?]+$/", $name))
	{
?>
		<div class="alert alert-danger">
		<strong>Something's Wrong!</strong> Your name is not in the correct format.
		</div>
<?php
	}
	else if (!preg_match("/^([a-zA-Z0-9\-\_\+\.])+@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/", $email))
	{
?>
		<div class="alert alert-danger">
		<strong>Something's Wrong!</strong> Your email is not in the correct format.
		</div>
<?php
	}
	else
	{
		$body = "Name: $name<br />Email: $email<br /><br />$message";
		require_once('Include/Mail.php');
		SendMail("support@plychannel.com" , "Plychannel Contact" , $body);
?>
		<div class="alert alert-info">
		<strong>Heads up!</strong> We recived the message. Thank you for contacting us.
		</div>
<?php
	}
}
?>

<form action="" method="POST">
	<div class="uploadForm"  id="uploadForm_<?php echo $id; ?>">
		<div class="formInput">
			<span>Name:</span>
			<input type="text" name="name" />
		</div>
		<div class="formInput">
			<span>Email:</span>
			<input type="text" name="email" />
		</div>
		<div class="formInput">
			<span>Message:</span><br />
			<textarea name="message"></textarea>
		</div>
	</div>
	<button type="submit" class="btn btn-sm btn-default">Send</button>
	<input type="hidden" value="true" name="SUBMITTED" />
</form>
<?php require_once("Include/footer.php"); ?>