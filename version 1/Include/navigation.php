<!-- Bootstrap core CSS -->
<link rel="stylesheet" type="text/css" href="http://plychannel.com/css/bootstrap.css" media="screen" title="style (screen)" />
<!-- Bootstrap theme -->
<link rel="stylesheet" type="text/css" href="http://plychannel.com/css/bootstrap-theme.css" media="screen" title="style (screen)" />

<!-- Custom styles for this template -->
<link rel="stylesheet" type="text/css" href="http://plychannel.com/css/style.css" media="screen" title="style (screen)" />

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->
<script src="https://code.jquery.com/jquery-1.10.2.min.js" type='text/javascript'></script>
</head>

<body>
<div class="header">
<ul class="nav nav-pills pull-right">
<li>
<form action='http://plychannel.com/search' method='GET' id='SearchForm'>
<table><tr>
<td><input type='text' name='s' class='SearchTextField' placeholder="Search..." value="<?php if (isset($_GET['s'])) echo stripcslashes(strip_tags(trim($_GET['s']))); ?>" /></td>
<td><a style="padding: 5px;" href="javascript:SearchForm.submit();"><img class='SearchButton' src='http://plychannel.com/Images/search.png' alt="search button"></a></td>
</tr></table>
</form>
</li>
<li>
<?php
if (isset($_COOKIE['Username']))
{
?>
	<a href="http://plychannel.com/upload"><img src="http://plychannel.com/Images/upload.png" alt="upload button" style="width:12px;" />Upload</a>
<?php
}
else
{
?>
	<a href="http://plychannel.com/login"><img src="http://plychannel.com/Images/log.png" alt="login" style="width:12px;" />Login</a>
<?php
}
?>
</li>
<li>
<script>
function ShowNavMenu()
{
	if ($("#NavigationMenu").css("display") == "none")
		$("#NavigationMenu").css("display", "block");
	else
		$("#NavigationMenu").css("display", "none");
}
</script>
<a href="javascript:ShowNavMenu();"><span class="glyphicon glyphicon-list"></span></a>
	<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu2" id="NavigationMenu" style="left: -120px;">
<?php
	if (isset($_COOKIE['Username']))
	{
		require_once('Include/encrypt.php');
		$user = decrypt(urldecode($_COOKIE['Username']));
?>
	  <li role="presentation"><a role="menuitem" tabindex="-1" href="http://plychannel.com/channel/<?php echo $user; ?>"><img src='http://plychannel.com/Images/author?u=<?php echo $user; ?>' style="width:12px;" />My Channel</a></li>
	  <li role="presentation"><a role="menuitem" tabindex="-1" href="http://plychannel.com/manager"><img src='http://plychannel.com/Images/manager.png' alt="video manager" style="width:12px;" />Video Manager</a></li>
	  <li role="presentation"><a role="menuitem" tabindex="-1" href="http://plychannel.com/subscriptions"><img src='http://plychannel.com/Images/subscription.png' alt="subscription" style="width:12px;" />Subscriptions</a></li>
	  <li role="presentation"><a role="menuitem" tabindex="-1" href="http://plychannel.com/settings"><img src='http://plychannel.com/Images/settings.png' alt="settings" style="width:12px;" />Settings</a></li>
	  <li role="presentation" class="divider"></li>
<?php
	}
?>
	  <li role="presentation"><a role="menuitem" tabindex="-1" href="http://plychannel.com/contact"><img src='http://plychannel.com/Images/contact.png' alt="contact us" style="width:12px;" />Contact Us</a></li>
	  <li role="presentation"><a role="menuitem" tabindex="-1" href="http://plychannel.com/help"><img src='http://plychannel.com/Images/help.png' alt="help" style="width:12px;" />Help</a></li>
	  <li role="presentation"><a role="menuitem" tabindex="-1" href="http://plychannel.com/terms"><img src='http://plychannel.com/Images/terms.png' alt="terms" style="width:12px;" />Terms</a></li>
<?php
	if (isset($_COOKIE['Username']))
	{
?>
	  <li role="presentation" class="divider"></li>
	  <li role="presentation"><a role="menuitem" tabindex="-1" href="http://plychannel.com/logout"><img src='http://plychannel.com/Images/log.png' alt="Logout" style="width:12px;" />Logout</a></li>
<?php
	}
?>
	</ul>
</li>
</ul>
<h3><a href='http://plychannel.com/'><img src='http://plychannel.com/Images/logo.png' alt="plychannel logo"></a></h3>
</div>

<div class="container">

<div class="row row-offcanvas row-offcanvas-right">

<?php
$new_query_string = http_build_query($_GET);
if ($new_query_string != "")
	$new_query_string .= "&";

if (!isset($_GET['accept-cookies']) && !isset($_COOKIE['cookies']))
{
?>
	<div class="alert alert-info">
	<strong>Heads up!</strong> We use cookies on this website. By using this website, we'll assume you consent to the cookies we set and you agree to our <a href='http://plychannel.com/terms?accept-cookies'>terms & condition</a>.
	<br />
	<a href="?<?php echo $new_query_string; ?>accept-cookies"><button type="button" class="btn btn-sm btn-primary">Ok</button></a>
	</div>
<?php
}
else if (isset($_GET['accept-cookies']))
{
	setcookie("cookies", "true", time() + 31557600, "/");
}
?>