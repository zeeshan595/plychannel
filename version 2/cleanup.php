<?php

require_once("/var/www/PHP/connect.php");
//Check MySQL and clean data
$clean = mysql_query("SELECT `ID` FROM `videos` WHERE `Uploaded` = '0' ORDER BY `ID` DESC LIMIT 50");
while ($row = mysql_fetch_array($clean))
{
	unlink("/var/www/Uploads/".$row[0].".jpg");
	unlink("/var/www/Uploads/num".$row[0].".webm");
	unlink("/var/www/Uploads/num".$row[0].".mp4");
	mysql_query("DELETE FROM `videos` WHERE `ID` = '".$row[0]."' LIMIT 1");
	echo "DELETE: " . $row[0] . "<br />";
}
//Clean Temp files
$files = glob('/var/www/Temp/'); // get all file names
foreach($files as $file){ // iterate files
  if(is_file($file))
    unlink($file); // delete file
}

echo "DELETE Temp Files <br />";
//Clean Log files
$files = glob('/var/www/Logs/'); // get all file names
foreach($files as $file){ // iterate files
  if(is_file($file))
    unlink($file); // delete file
}

echo "DELETE Logs <br />";

//Clean Video Lengths and there duration
$clean = mysql_query("SELECT * FROM  `videos` WHERE  `Length` NOT REGEXP  '([0-9]+:)?[0-9]+:[0-9]+' LIMIT 50");
while ($row = mysql_fetch_array($clean))
{
	$time =  exec("avconv -i /var/www/Uploads/num".$row[0].".webm 2>&1 | grep 'Duration' | cut -d ' ' -f 4 | sed s/,//");
	if ($time == "")
	{
		echo "DELETE: " . $row[0] . "<br />";
		mysql_query("DELETE FROM `videos` WHERE `ID` = '".$row[0]."' LIMIT 1");
	}
	else
	{
		$timeArray = explode(":", $time);

		$duration = "";

		if ($timeArray[0] != "00")
			$duration .= $timeArray[0] . ":";


		$duration .= $timeArray[1] . ":";
		$seconds = explode(".", $timeArray[2]);
		$duration .= $seconds[0];
		echo "Time Added: " . $row[0] . " | $time -> $duration <br />";
		mysql_query("UPDATE `videos` SET `Length` = '".$duration."' WHERE `ID` = '".$row[0]."' LIMIT 1");
	}
}

echo "FIXED all video durations <br />";

//Clean Uploads Directory
$files = scandir("/var/www/Uploads/"); 
foreach ($files as $file)
{
	if ($file != "." && $file != "..")
	{
		$name = explode(".", $file);
		$name = $name[0];
		$ext = end(explode(".", $file));
		if ($ext != "jpg")
			$name = substr($name, 3, strlen($name) - 3);

		
		$check = mysql_query("SELECT `Length` FROM `videos` WHERE `ID` = '$name' LIMIT 1");
		if (mysql_num_rows($check) == 0)
		{
			echo "DELETE: " . $file ." | File is not linked <br />";
			unlink("/var/www/Uploads/" . $file);
		}
	}
}

echo "DELETED all unlinked files <br />";

?>