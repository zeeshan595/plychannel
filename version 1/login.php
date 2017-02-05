<?php
if (isset($_COOKIE['Username']))
{
  require_once("Include/connect.php");
  require_once("Include/encrypt.php");
  $user = decrypt(urldecode($_COOKIE['Username']));
  $checkUser = mysql_query("SELECT * FROM `users` WHERE `Username` = '$user' LIMIT 1");
  if (mysql_num_rows($checkUser) == 0)
  {
    setcookie("Username", "", time() - 216000, "/");
    header("Location: http://plychannel.com/login?fakeuser=" . $user);
  }
  else
  {
    header("Location: http://plychannel.com");
  }
}
else if (isset($_POST['SUBMITTED']))
{
  require_once("Include/connect.php");
  require_once("Include/encrypt.php");
  $error = "";
  $email = $_POST['email'];
  $password = $_POST['password'];
  if (!preg_match("/^([a-zA-Z0-9\-\_\+\.])+@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/", $email))
  {
    $error .= "Email is not in correct format.<br />";
  }

  if (!preg_match("/^[a-zA-Z0-9\-\_\@\#\$\%\^\&\*\(\)\+]{3,45}$/", $password))
  {
    $error .= "Password is not in correct format.<br />";
  }

  if ($error == "")
  {
    $password = urlencode(encrypt($password));
    $query = mysql_query("SELECT * FROM `users` WHERE `Email` = '$email' AND `Password` = '$password' LIMIT 1");
    if (mysql_num_rows($query) == 0)
    {
      $error = "Password and Email do not match.<br />";
    }
    else
    {
        $user = mysql_fetch_array($query);
        if ($user['Active'] == '1')
        {
        if ($user['Blocked'] == '0')
        {
          $user = $user['Username'];
          setcookie("Username", urlencode(encrypt($user)), time() + 32140800, "/");

          if (!isset($_GET['feature']))
            header("Location: http://plychannel.com/");
          else
            header("Location: " . $_GET['feature']);
        }
        else
        {
          $error = "Your account has been blocked.";
        }
      }
      else
      {
        $error = "Please activate your account by clicking the link provided in your email when you registered.";
      }
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

    <title>Plychannel - Login</title>

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

      <?php if ($error != "") { ?>
      
      <div class="alert alert-danger">
        <strong>Oh snap!</strong> <?php echo $error; ?>
      </div>

      <?php } ?>

      <form class="form-signin" role="form" method="POST">
        <h2 class="form-signin-heading">Please sign in</h2>
        <input id="email" name="email" type="text" class="form-control" placeholder="Email address" required="" autofocus="">
        <div id="EmailCheck" style="display:none;position: relative;left: 305px;top: -28px;">
          <span id="glyphicon" class="glyphicon glyphicon glyphicon-remove" style="position:absolute;"></span>
          <div class="well" style="displat:none;position: absolute;top: -30px;left: 30px;width: 175px;">
          </div>
        </div>
        <br />
        <input id="password" name="password" type="password" class="form-control" placeholder="Password" required="">
        <div id="PassCheck" style="display:none;position: relative;left: 305px;top: -40px;">
          <span id="glyphicon" class="glyphicon glyphicon glyphicon-remove" style="position:absolute;"></span>
          <div class="well" style="displat:none;position: absolute;top: -30px;left: 30px;width: 175px;">
          </div>
        </div>
        <input type="hidden" value="true" id="password" name="SUBMITTED" />
        <a href='register'>Don't have a plychannel account.</a><br />
        <a href='recover'>Can't login?</a>
        <button class="btn btn-primary btn-block" id='submit' >Sign in</button>
      </form>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src='js/login.js'></script>
  </body>
</html>