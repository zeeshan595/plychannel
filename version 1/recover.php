<?php
if (isset($_POST['SUBMITTED']))
{
  require_once("Include/connect.php");
  require_once("Include/encrypt.php");
  require_once('Include/Mail.php');
  $email = stripcslashes(strip_tags(trim($_POST['email'])));
  if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/", $email))
  {
    $error = "Email is not in correct format.<br />";
  }
  else
  {
    $check = mysql_query("SELECT * FROM `users` WHERE `Email` = '$email' LIMIT 1");
    
    $check = mysql_fetch_array($check);
    $user = $check['Username'];
    $code = $check['Code'];

    if ($check['Blocked'] == '0')
    {
      $code = rand(999,99999);
      mysql_query("UPDATE `users` SET `Code` = '$code' WHERE `Username` = '$user' LIMIT 1");
      if ($check['Active'] == '1')
      {
        $message = "There is no issue with your account, If you forgot your password we sent you a email <strong>containing</strong> your password.";
        $body = "
        <a href='http://plychannel.com/'><img src='http://plychannel.com/Images/logo.png' width='100px' /></a><br />
        <h4>Your password is currently: ".decrypt(urldecode($check['Password']))."</h4>";
        SendMail($email , "Plychannel Password Recovery" , $body);
      }
      else
      {
        $message = "You're account isn't activated, don't worry we sent you a new activation email.";
        $body = "
        <a href='http://plychannel.com/'><img src='http://plychannel.com/Images/logo.png' width='100px' /></a><br />
        <h4>Click the link below to activate your account</h4><br />
        <a href='http://plychannel.com/activator?u=$user&k=$code'>http://plychannel.com/activator?u=$user&k=$code</a>";
        SendMail($email , "Plychannel Activation Recovery" , $body);
      }
    }
    else
    {
      $error = "You're account was blocked. Please contact us for further information.";
    }
  }
}
?>
<html lang="en"><head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="http://plychannel.com/Images/favicon.ico">

    <title>Plychannel - Help Login</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/login.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  <style type="text/css"></style></head>

  <body>

    <div class="container">

      <?php if (isset($error)) { ?>
      
      <div class="alert alert-danger">
        <strong>Oh snap!</strong> <?php echo $error; ?>
      </div>

      <?php } ?>

      <?php if (isset($message)) { ?>
      
      <div class="alert alert-info">
        <strong>Hey There!</strong> <?php echo $message; ?>
      </div>

      <?php } ?>

      <form class="form-signin" role="form" method="POST">
        <h2 class="form-signin-heading">Enter your email</h2>
        <input id="email" name="email" type="text" class="form-control" placeholder="Email address" required="" autofocus="">
        <div id="EmailCheck" style="display:none;position: relative;left: 305px;top: -28px;">
          <span id="glyphicon" class="glyphicon glyphicon glyphicon-remove" style="position:absolute;"></span>
          <div class="well" style="displat:none;position: absolute;top: -30px;left: 30px;width: 175px;">
          </div>
        </div>
        <input type="hidden" value="true" id="password" name="SUBMITTED" />
        <button class="btn btn-primary btn-block" id='submit' >Recover</button>
      </form>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src='js/recover.js'></script>
  </body>
</html>