<?php
error_reporting(0);
include("../mysql.php");
if(isset($_POST["source"]))
{
	echo '<a href="./sql-6.html"><input type="Submit" value="Back"></a><br><br>';
	highlight_file(__FILE__);	
	exit();
}
header('Content-type:text/json; charset=utf-8');
$id = $_POST["id"];
$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
$sql = "select username from user where id='".$id."'";
$res = mysqli_query($con, $sql);
if($res)
{
	$row = mysqli_fetch_array($res);
	$data = '{"id":"'.$id.'", "username":"'.$row[0].'"}';
}
else
{
	$data = '{"id":"'.$id.'", "username":"'.mysqli_error($con).'"}';
}
echo json_encode($data);
mysqli_close($con);
?>
