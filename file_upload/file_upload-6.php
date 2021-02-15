<!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
	<title>.user.ini</title>
</head>
<body>
	<p>.user.ini</p>
	<form action="./file_upload-6.php" method="POST">
		<p><input type="Submit" value="source" name="source"></p>
	</form>
	<a href="../"><input type="Submit" value="Index"></a>
	<br><br>
	<form action="./file_upload-6.php" method="POST" enctype="multipart/form-data">
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
	echo '<a href="./file_upload-6.php"><input type="Submit" value="Back"></a><br><br>';
	highlight_file(__FILE__);	
	exit();
}
if(isset($_FILES["file"]))
{
	$name = basename($_FILES["file"]["name"]);
	$info = pathinfo($name);
	$ext = $info["extension"];
	$whitelist = array("jpg", "png", "gif");
	if(in_array($ext, $whitelist))
	{
		$dest = "../upload/".$name;
		move_uploaded_file($_FILES["file"]["tmp_name"], $dest);
		echo "<br><a href=".$dest.">".$name."</a>";
	}
	else
	{
		echo "文件类型违规";
	}
}
?>
