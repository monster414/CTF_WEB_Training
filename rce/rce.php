<!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
	<title>RCE</title>
</head>
<body>
	<p>RCE</p>
	<form action="./rce.php" method="POST">
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
	echo '<a href="./rce.php"><input type="Submit" value="Back"></a><br><br>';
	highlight_file(__FILE__);
	exit();
}
if(isset($_GET["ip"]) && $_GET["ip"] != "")
{
	$ip = $_GET["ip"];
	system("ping -c 1 $ip");
}
else
{
	header("location: ./rce.php?ip=127.0.0.1");
}
?>
