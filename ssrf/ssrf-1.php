<!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
	<title>SSRF</title>
</head>
<body>
	<p>SSRF</p>
	<form action="./ssrf.php" method="POST">
		<p><input type="Submit" value="source" name="source"></p>
	</form>
	<a href="../"><input type="Submit" value="Index"></a>
	<br>
</body>
</html>
<?php
error_reporting(0);
if(isset($_POST["source"]))
{
	echo '<a href="./ssrf.php"><input type="Submit" value="Back"></a><br><br>';
	highlight_file(__FILE__);
	exit();
}
if(isset($_GET["url"])!= $_GET["url"] != "")
{
	
}
else
{
	header('location: ./ssrf.php?url=http://127.0.0.1/');
}
?>
