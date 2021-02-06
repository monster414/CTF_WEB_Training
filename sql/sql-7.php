<?php
#error_reporting(0);
include("../mysql.php");
header('Content-type:text/json; charset=utf-8');
function comment($name, $content, $con, $data)
{
	$sql = "select name from msg where name='".$name."'";
	if(mysqli_fetch_array(mysqli_query($con, $sql)) === NULL)
	{
		$sql = "insert into msg (name, content) values ('".$name."', '".$content."')";
		$res = mysqli_query($con, $sql);
	}
	else
	{
		$data = $data.'Same name is banned.<br>';
	}
	return $data;
}

function list_comment($con, $data)
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
			$data = $data.'name: '.$names[$i].'<br>content: '.$row[0].'<hr />';
		}
	}
	$data = $data.'"}';
	return $data;
}

function delete_comments($con)
{
	$sql = "delete from msg";
	mysqli_query($con, $sql);
}

if(isset($_POST["source"]))
{
	echo '<a href="./sql-7.html"><input type="Submit" value="Back"></a><br><br>';
	highlight_file(__FILE__);
	exit();
}
$data = '{"msg":"';
$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if(isset($_POST["name"]) && isset($_POST["content"]))
{
	$name = addslashes($_POST["name"]);
	$content = addslashes($_POST["content"]);
	$data = comment($name, $content, $con, $data);
}
if(isset($_POST["delete"]))
{
	delete_comments($con);
}
$data = list_comment($con, $data);
echo json_encode($data);
mysqli_close($con);
?>
