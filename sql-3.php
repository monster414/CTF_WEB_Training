<?php
error_reporting(0);
include("./mysql.php");
if(isset($_POST["source"]))
{
	echo '<a href="/run/sql-3.html"><input type="Submit" value="Back"></a><br><br>';
	highlight_file(__FILE__);	
	exit();
}
header('Content-type:text/json; charset=utf-8');
$username = $_POST["username"];
$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
$sql = "select username from user where username='".$username."'";
$res = mysqli_query($con, $sql);
$row = mysqli_fetch_array($res);
if($row)
{
	$data = '{"msg":"User Exist."}';
	echo json_encode($data);
}
else
{
	$data = '{"msg":"User Don\'t Exist."}';
	echo json_encode($data);
}
mysqli_close($con);
?>
