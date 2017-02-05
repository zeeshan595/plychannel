<?php
if (!isset($_COOKIE['Username']))
	die();

$id = $_GET['id'];

$name = $_FILES['file']['name'];
$tmpFile = $_FILES['file']['tmp_name'];
$ext = strtolower(end(explode(".", $name)));
$allowedExt = array('webm' , 'avi' , 'mp4' , 'mkv' , 'mov' , 'mpeg4' , 'wmv' , 'flv');

if (in_array($ext , $allowedExt) === false)
{
	die("You are not allowed to upload that type of file: " . $ext);
}
else
{
	if(move_uploaded_file($tmpFile, "/var/www/Temp/num" . $id . "." . $ext))
	{
		$cmd = "nohup avconv -i /var/www/Temp/num".$id . "." . $ext." -strict experimental -acodec aac -ac 2 -ab 160k -vcodec libx264 -pix_fmt yuv420p -preset slow -level 30 -y /var/www/Uploads/num".$id.".mp4 > /var/www/Logs/mp4".$id.".txt 2>&1 & echo $!";
		$cmd2 = "nohup avconv -i /var/www/Temp/num".$id . "." . $ext." -f webm -c:v libvpx -minrate 1M -maxrate 1M -b:v 1M -y /var/www/Uploads/num".$id.".webm > /var/www/Logs/webm".$id.".txt 2>&1 & echo $!";

		echo shell_exec($cmd) . "||";
		echo shell_exec($cmd2);
	}
	else
	{
		echo "ERROR";
	}
}
?>