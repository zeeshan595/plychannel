<?php

$Username = "";
$Name = "";
$Email = "";
$Message = "";
if(isset($_POST['SUBMITTED']))
{
  $Username = $_POST['Username'];
  $Password = $_POST['Password'];
  $Name = $_POST['Name'];
  $Email = $_POST['Email'];
  $Message = "";

  if(!preg_match("/^[a-zA-Z0-9\-\_\@\+\.]{3,45}$/", $Username))
  {
    if(strlen($Username) > 3 && $Username < 45)
    {
      $Message .= "You can only type letters, numbers,_,@ and . for your username.";
    }
    else
    {
      $Message .= "Your Username must be between 3 to 45 characters long.";
    }
  }

  if(!preg_match("/^[a-zA-Z\ @]{3,45}$/", $Name))
  {
    if(strlen($Name) > 3 && $Name < 45)
    {
      $Message .= "You can only type letters and space for your name.";
    }
    else
    {
      $Message .= "Your name must be between 3 to 45 characters long.";
    }
  }

  if(!preg_match("/^[a-zA-Z0-9\-\_\@\#\$\%\^\&\*\(\)\+]{3,45}$/", $Password))
  {
    if(strlen($Password) > 3 && $Password < 45)
    {
      $Message .= "You can only type letters, numbers,_,@ and . for your password.";
    }
    else
    {
      $Message .= "Your Password must be between 3 to 45 characters long.";
    }
  }

  if(!preg_match("/^([a-zA-Z0-9\-\_\+\.])+@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/", $Email))
  {
    if(strlen($Email) > 3 && $Email < 200)
    {
      $Message .= "You can only type letters, numbers,_,@ and . for your email.";
    }
    else
    {
      $Message .= "Your Email must be between 3 to 200 characters long.";
    }
  }

  if($Message == "")
  {
    $image = addslashes(file_get_contents("Images/defaultPic.jpg"));
    require_once("Include/connect.php");
    $check = mysql_query("SELECT `Blocked` FROM `users` WHERE `Username` = '".$Username."' OR `Email` = '".$Email."'");
    if(mysql_num_rows($check) != 0)
    {
      $Message = "That username or email already exists.";
    }
    else
    {
      require_once("Include/encrypt.php");
      $code = rand(999 , 9999);
      $update = mysql_query("INSERT INTO `users` 
        (`Blocked`,`Username` , `Password` , `Name` , `Email` , `ChannelName` , `About` , `Background` , `Image` , `ChannelVideo` , `Code` , `Active` , `Time` , `website`, `twitter`, `facebook`, `googleplus`) VALUES 
        ('0',
        '".$Username."' ,
        '".urlencode(encrypt($Password))."',
        '".$Name."',
        '".$Email."' ,
        '".$Username."\'s Channel' ,
        'There is no discription for this channel' ,
        'http://plychannel.com/Images/default_banenr.jpg' ,
        '".$image."' ,
        '-1' ,
        '".$code."' ,
        '0' ,
        '".time()."',
        '', '', '', '')");
      if (!$update)
        die (mysql_error());
      $body = "
      <a href='http://plychannel.com/'><img src='http://plychannel.com/Images/logo.png' width='100px' /></a><br />
      <h4>Click the link below to activate your account</h4><br />
      <a href='http://plychannel.com/activator?u=$Username&k=$code'>http://plychannel.com/activator?u=$Username&k=$code</a>";
      require_once('Include/Mail.php');
      SendMail($Email , "Plychannel Activation" , $body);
      $Message = "Account Created.<br />To activate your account click on the email link we sent you.<br />";
    }
  }
}

?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="http://plychannel.com/Images/favicon.ico">

    <title>Plychannel - Register</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/login.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    
  </head>

  <body style='min-width:800px'>

    <div class="container">
<?php
    if ($Message != "")
    {
?>
      <div class="alert alert-info">
        <?php echo $Message; ?>
      </div>
<?php
    }
?> 
      <form class="form-signin" role="form" method="POST">
        <h2 class="form-signin-heading">Register</h2>
        <input type="text" name="Name" value="<?php echo $Name; ?>" class="form-control" placeholder="Name" required="">
        <br />
        <input id="user" name="Username" value="<?php echo $Username; ?>" type="username" class="form-control" placeholder="Username" required="">
        
        <div id="UserCheck" style="display:none;position: relative;left: 305px;top: -28px;">
          <span id="glyphicon" class="glyphicon glyphicon glyphicon-remove" style="position:absolute;"></span>
          <div class="well" style="displat:none;position: absolute;top: -30px;left: 30px;width: 175px;">
          </div>
        </div>
        <br />
        <input id="email" name="Email" value="<?php echo $Email; ?>" type="text" class="form-control" placeholder="Email address" required="" autofocus="">
        <div id="EmailCheck" style="display:none;position: relative;left: 305px;top: -28px;">
          <span id="glyphicon" class="glyphicon glyphicon glyphicon-remove" style="position:absolute;"></span>
          <div class="well" style="displat:none;position: absolute;top: -30px;left: 30px;width: 175px;">
          </div>
        </div>
        <br />
        <input id="password" name="Password" type="password" class="form-control" placeholder="Password" required="">
        <div id="PassCheck" style="display:none;position: relative;left: 305px;top: -40px;">
          <span id="glyphicon" class="glyphicon glyphicon glyphicon-remove" style="position:absolute;"></span>
          <div class="well" style="displat:none;position: absolute;top: -30px;left: 30px;width: 175px;">
          </div>
        </div>
        <input id="password2" name="Password2" type="password" class="form-control" placeholder="Re-Password" required="">
        <div id="MatchCheck" style="display:none;position: relative;left: 305px;top: -40px;">
          <span id="glyphicon" class="glyphicon glyphicon glyphicon-remove" style="position:absolute;"></span>
          <div class="well" style="displat:none;position: absolute;top: -30px;left: 30px;width: 175px;">
          </div>
        </div>
        <a href='login'>Already have an account.</a><br />
        <input type="hidden" name="SUBMITTED" value="true" />
        <button class="btn btn-lg btn-default btn-block" id='submit' disabled>Create</button>
      </form>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src='js/register.js'></script>
  </body>
</html>