<!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
	<title>文件包含</title>
</head>
<body>
	<p>文件包含</p>
	<form action="./file_inclusion-1.php" method="POST">
		<p><input type="Submit" value="source" name="source"></p>
	</form>
	<a href="../"><input type="Submit" value="Index"></a>
	<br><br>
	<p><a href="./shell">hint<a></p>
</body>
</html>
<?php
error_reporting(0);
if(isset($_POST["source"]))
{
	echo '<a href="./file_inclusion-1.php"><input type="Submit" value="Back"></a><br><br>';
	highlight_file(__FILE__);
	exit();
}
if(isset($_GET["file"]) && $_GET["file"] != "")
{
	$file = $_GET["file"];
	include($file);
}
else
{
	header('location: ./file_inclusion-1.php?file=text.txt');
}
$flag = "flag{35e6ac9e78e250a81105bb4e711e9eed}";
?>
