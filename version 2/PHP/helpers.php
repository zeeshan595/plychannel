<?php

function timeToString($ptime)
{
    $etime = time() - $ptime;

    if ($etime < 1)
    {
        return '0 seconds';
    }

    $a = array( 12 * 30 * 24 * 60 * 60  =>  'year',
                30 * 24 * 60 * 60       =>  'month',
                24 * 60 * 60            =>  'day',
                60 * 60                 =>  'hour',
                60                      =>  'minute',
                1                       =>  'second'
                );

    foreach ($a as $secs => $str)
    {
        $d = $etime / $secs;
        if ($d >= 1)
        {
            $r = round($d);
            return $r . ' ' . $str . ($r > 1 ? 's' : '');
        }
    }
}

function getPageUrl()
{
    $pageURL = '';
    if ($_SERVER["SERVER_PORT"] != "80")
    {
        $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
    }
    else
    {
        $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}

function encrypt($str)
{
    $key = "4as5d43h5g4f65h4d2r1g3s54v5as3erlfahfa35r4354390250";
    $result = '';
    for($i=0; $i<strlen($str); $i++)
    {
        $char = substr($str, $i, 1);
        $keychar = substr($key, ($i % strlen($key))-1, 1);
        $char = chr(ord($char)+ord($keychar));
        $result.= $char;
    }
    return urlencode(base64_encode($result));
}

function decrypt($str)
{
    $str = base64_decode(urldecode($str));
    $result = '';
    $key = "4as5d43h5g4f65h4d2r1g3s54v5as3erlfahfa35r4354390250";
    for($i=0; $i<strlen($str); $i++)
    {
        $char = substr($str, $i, 1);
        $keychar = substr($key, ($i % strlen($key))-1, 1);
        $char = chr(ord($char)-ord($keychar));
        $result.=$char;
    }
    return $result;
}

function getPercentage($one, $two, &$percentOne, &$percentTwo)
{
    $green = 50;
    $red = 50;
    if($one != 0 || $two != 0)
    {
        $total = $two + $one;
        $percentOne = ($one * 100) / $total;
        $percentTwo = ($two * 100) / $total;
    }
}

function getTitle($Url){
    $str = file_get_contents($Url);
    if(strlen($str)>0){
        preg_match("/\<title\>(.*)\<\/title\>/",$str,$title);
        return $title[1];
    }
}

function AddToHistory($id)
{
    if (isset($_COOKIE['Username']))
    {
        require_once("/var/www/PHP/connect.php");

        $user = decrypt(urldecode($_COOKIE['Username']));
        $check = mysql_query("SELECT * FROM `userhistory` WHERE `username` = '$user' AND `videoID` = '$id' LIMIT 1");
        if (mysql_num_rows($check) > 0)
        {
            mysql_query("UPDATE `userhistory` SET `time` = '".time()."' WHERE `videoID` = '$id' AND `username` = '$user' LIMIT 1");
        }
        else
        {
            mysql_query("INSERT INTO `userhistory` (`username` , `time` , `videoID`) VALUES ('".$user."' , '".time()."' , '".$id."')");
        }
    }
}

?>
