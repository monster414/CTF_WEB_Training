<!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
	<title>JS限制</title>
	<script type="text/javascript">
	function dist(file_upload)
	{
		var filename = file_upload.value;
		var mime = filename.toLowerCase().substr(filename.lastIndexOf("."));
		if(mime != ".jpg" && mime != ".png" && mime != ".gif")
		{
			alert("仅允许上传jpg/png/bmp/ico/gif文件");
			file_upload.outerHTML = file_upload.outerHTML;
		}
	}
	</script>
</head>
<body>
	<p>JS限制</p>
	<form action="./file_upload-1.php" method="POST">
		<p><input type="Submit" value="source" name="source"></p>
	</form>
	<a href="../"><input type="Submit" value="Index"></a>
	<br><br>
	<form action="./file_upload-1.php" method="POST" enctype="multipart/form-data">
		<input type="file" name="file" onchange="dist(this)" />
		<br><br>
		<input type="submit" value="submit" />
	</form>
</body>
</html>
<?php
error_reporting(0);
if(isset($_POST["source"]))
{
	echo '<a href="./file_upload-1.php"><input type="Submit" value="Back"></a><br><br>';
	highlight_file(__FILE__);	
	exit();
}
if(isset($_FILES["file"]))
{
	$name = $_FILES["file"]["name"];
	move_uploaded_file($_FILES["file"]["tmp_name"], "../upload/".$name);
	echo "<br><a href=../upload/".$name.">".$name."</a>";
}
?>
