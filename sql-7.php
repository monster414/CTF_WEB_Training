<!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
	<title>二次注入</title>
	<!--<script crossorigin="anonymous" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" src="https://lib.baomitu.com/jquery/3.5.1/jquery.min.js"></script>
	<script type="text/javascript">
	$(function()
	{
		$('#Submit').click(function()
		{
			var id = $('#id').val();
			$.ajax
			({
				type: "POST",
				url: "./sql-8.php",
				data: {
						'id': id,
				},
				datatype: "json",
				success: function(content)
				{
					var data = JSON.parse(content);
					$('#text').empty();
					$('#text').html("id: " + data.id + "<br>username: " + data.username);
					console.log(data);
				},
				error:function(data)
				{
					console.log(data);
				}
			})
		})
	})
	</script>-->
</head>
<body>
	<p>二次注入</p>
	<form action="./sql-7.php" method="POST">
		<p><input type="Submit" value="source" name="source"></p>
	</form>
	<a href="."><input type="Submit" value="Index"></a>
	<form action="./sql-7.php" method="POST">
		<p>name: <input type="text" name="name" id="name" style="width:450px;"></p>
		<p>content: <input type="text" name="content" id="content" style="width:450px;"></p>
		<p><input type="Submit" value="Submit" id="Submit"></p>
	</form>
	<span id="text"></span>
	<form action="./sql-7.php" method="POST">
		<p><input type="Submit" value="delete" name="delete"></p>
	</form>
</body>
</html>
<?php
#error_reporting(0);
include("./mysql.php");
#header('Content-type:text/json; charset=utf-8');
function comment($name, $content, $con)
{
	$sql = "select name from msg where name='".$name."'";
	if(mysqli_fetch_array(mysqli_query($con, $sql)) === NULL)
	{
		$sql = "insert into msg (name, content) values ('".$name."', '".$content."')";
		$res = mysqli_query($con, $sql);
	}
	else
	{
		echo "Same name is banned.";
	}
}
function list_comment($con)
{
	$sql = "select count(*) from msg";
	$res = mysqli_query($con, $sql);
	$row = mysqli_fetch_array($res);
	$num = $row[0];
	if($num !== 0)
	{
		$names = array();
		for($i = 0;$i < $num;$i++)
		{
			$sql = "select name from msg limit $i,1";
			$res = mysqli_query($con, $sql);
			$row = mysqli_fetch_array($res);
			array_push($names, $row[0]);
		}
		for($i = 0;$i < $num;$i++)
		{
			$sql = "select content from msg where name='".$names[$i]."'";
			$res = mysqli_query($con, $sql);
			$row = mysqli_fetch_array($res);
			echo "name: ".$names[$i];
			echo "<br>";
			echo "content: ".$row[0];
			echo "<hr />";
		}
	}
}
function delete_comments($con)
{
	$sql = "delete from msg";
	mysqli_query($con, $sql);
}
if(isset($_POST["source"]))
{
	echo '<a href="./sql-7.php"><input type="Submit" value="Back"></a><br><br>';
	highlight_file(__FILE__);
	exit();
}
$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if(isset($_POST["name"]) && isset($_POST["content"]))
{
	$name = addslashes($_POST["name"]);
	$content = addslashes($_POST["content"]);
	comment($name, $content, $con);
}
if(isset($_POST["delete"]))
{
	delete_comments($con);
}
list_comment($con);
mysqli_close($con);
?>
