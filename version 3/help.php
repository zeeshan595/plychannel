<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Traditional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-traditional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="Styles/toolbar.css" type="text/css" rel="stylesheet" />
		<link href="Styles/page.css" type="text/css" rel="stylesheet" />
		<title>Plychannel</title>
	</head>

	<body>
		
		<?php require_once("PHP/toolbar.php"); ?>
		<?php require_once("PHP/connect.php"); ?>

		<div class="content">
			<h3>Help</h3>
			<p>
				<h5>Contents:</h5>
				<table>
				<tr>
					<td><a href='#plychannl' class="greyButton">1:What is Plychannel?</a></td>
				</tr><tr>
					<td><a href='#login' class="greyButton">2:Login/Register</a></td>
				</tr><tr>
					<td><a href='#channel' class="greyButton">3:Channels</a></td>
				</tr><tr>
					<td><a href='#subscription' class="greyButton">4:Subscriptions</a></td>
				</tr><tr>
					<td><a href='#upload' class="greyButton">5:Uploading</a></td>
				</tr><tr>
					<td><a href='#playlist' class="greyButton">6:Playlists</a></td>
				</tr><tr>
					<td><a href='#manager' class="greyButton">7:Video manager</a></td>
				</tr>
				</table>
			</p>
			<br />
			<img src='Images/seperator.png' width='640px' />
			<br />

			<a name='plychannl'></a>
			<h3>What is Plychannel:</h3>
			<p>
				Plychannel is a website that allows users to upload videos and share them with their friends. You can make the video private, public
				 and unlisted.<br />
				Public: Can be viewed by everyone.<br />
				Unlisted: Your content will not be listed anywhere.<br />
				Private: Your content will only be able to be viewed by the people you chose via their email address.<br />
				Using this website you can also host TV shows and create your own film and upload it here for your friends/everyone to view.
			</p>

			<a name='login'></a>
			<h3>Login/Register</h3>
			<p>
				You are allowed to view any public video without registering with us.But to upload a video, create playlists, use subscriptions and/or to view a private video shared by your
				 friend you will need to register with your email.<br /><br />
				<b>Register</b><br /><br />
				Registering with us is really easy. just click <a href='http://plychannel.com/register' target='_blank'>here</a> to go to the register page. After your
				 there you need to fill in some details (Name , username , password , email).Please read the terms and agreement before you register.
				  After you register you will receive a email from us to confirm that your email is right in case we need to contact you.
				Open your email and click the link in the email. This will activate your account and you can now login.<br /><br />
				<b>Login</b><br /><br />
				Login is really simple press the login button on the top right. After you have logged in you will be able to see upload insted of login. Moreover the menu on the right to Upload will have extra features added to it.
			</p>

			<a name='channel'></a>
			<h3>Channels</h3>
			<p>
				Channels are were all of the user's contents are stored. Your channel will contain all of your videos , playlist along with your channels description.
				You can view other peoples channels and see what content they have uploaded. To view your channel. After logging in click the menu button on the top right then click my channel.<br />
			</p>

			<a name='subscription'></a>
			<h3>Subscription</h3>
			<p>
				Subscription is a easy way or following a channel and knowing what they uploaded. If you subscribe to a channel their latest videos
				will be displayed on the home page.
			</p>

			<a name='upload'></a>
			<h3>Upload</h3>
			<p>
				You must be logged in to upload a video.<br />
				To upload a video it is simple; First click the upload button on the top right and then just drag and drop your videos into the box displayed.
				These are the audio formats we support.<br />
				<br />
				"webm" , "avi" , "mp4" , "mkv" , "mov" , "mpeg4" , "wmv" , "flv"<br />
				<br />
				When uploading a video you will see all of its details which you can edit. If the page is to long and you want to upload more videos just click the little down arrow under the progress bar
				and it will minimize the upload to a more compact view. After the upload is finished your video will need to process to perform at its best on our site.
			</p>

			<a name='playlist'></a>
			<h3>Playlists</h3>
			<p>
				Playlist is a easy way to organise your videos into a group for people to view.
				Playlists can be created easily. just go to your video manager by clicking on the top right menu button.
				Tick any video you would like to add in the playlist. After click Action->Add To Playlist at the top
				This will show a menu where you can add those videos to a playlist you already have or create a new one.
				If you want to add a video to your playlist that you are watching right now. Click the Add to playlist tab in the video (2nd)
				Now click on the playlist you would like this video to be added to. You can also create a new playlist if you want.
			</p>
			<a name='manager'></a>
			<h3>Video manager</h3>
			<p>
				You can go to video manager to view, edit, delete your videos or playlists.
			</p>
		  </div>

		<?php require_once("PHP/footer.php"); ?>
		<!-- JS -->
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script type="text/javascript" src="Javascript/toolbar.js"></script>
		<script type="text/javascript">
			$(function() {
			  $('a[href*=#]:not([href=#])').click(function() {
			    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
			      var target = $(this.hash);
			      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
			      if (target.length) {
			        $('html,body').animate({
			          scrollTop: target.offset().top
			        }, 1000);
			        return false;
			      }
			    }
			  });
			});
		</script>
	</body>
</html>