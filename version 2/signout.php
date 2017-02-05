<?php

setcookie("Username", "", time() - 3600, "/");
header("Location: http://plychannel.com/home");

?>