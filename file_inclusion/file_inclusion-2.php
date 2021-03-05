<!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
	<title>文件包含</title>
</head>
<body>
	<p>文件包含</p>
	<form action="./file_inclusion-2.php" method="POST">
		<p><input type="Submit" value="source" name="source"></p>
	</form>
	<a href="../"><input type="Submit" value="Index"></a>
	<br><br>
	<form action="./file_inclusion-2.php" method="POST" enctype="multipart/form-data">
		<input type="file" name="file" />
		<br><br> 	
		<input type="submit" value="submit" />
	</form>
	<p><a href="./shell.zip">hint1<a></p>
	<p><a href="./shell.gz">hint2<a></p>
</body>
</html>
<?php
error_reporting(0);
if(isset($_POST["source"]))
{
	echo '<a href="./file_inclusion-2.php"><input type="Submit" value="Back"></a><br><br>';
	highlight_file(__FILE__);
	exit();
}
if(isset($_GET["file"]) && $_GET["file"] != "")
{
	$file = $_GET["file"];
	include($file.".txt");
}
else
{
	header('location: ./file_inclusion-2.php?file=text');
}
?>
