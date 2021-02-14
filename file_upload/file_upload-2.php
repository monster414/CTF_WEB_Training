<!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
	<title>%00截断</title>
</head>
<body>
	<p>%00截断</p>
	<form action="./file_upload-2.php" method="POST">
		<p><input type="Submit" value="source" name="source"></p>
	</form>
	<a href="../"><input type="Submit" value="Index"></a>
	<form action="./file_upload-2.php?path=../upload/" method="POST" enctype="multipart/form-data">
		<input type="file" name="file" />
		<br><br>
		<input type="submit" value="submit" />
	</form>
</body>
</html>
<?php
error_reporting(0);
if(isset($_POST["source"]))
{
	echo '<a href="./file_upload-2.php"><input type="Submit" value="Back"></a><br><br>';
	highlight_file(__FILE__);	
	exit();
}
if(isset($_FILES["file"]))
{
	$name = basename($_FILES["file"]["name"]);
	$info = pathinfo($name);
	$ext = $info["extension"];
	$whitelist = array("jpg", "png", "bmp", "ico", "gif");
	if(in_array($ext, $whitelist))
	{
		$path = $_GET["path"];
		$dest = $path.md5(rand(0,10000)).".".$ext;
		move_uploaded_file($_FILES["file"]["tmp_name"], $dest);
		echo "<br><a href=".$dest.">".$dest."</a>";
	}
}
?>
