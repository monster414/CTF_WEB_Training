<?php
error_reporting(0);
include("../mysql.php");
if(isset($_POST["source"]))
{
	echo '<a href="./sql-4.html"><input type="Submit" value="Back"></a><br><br>';
	highlight_file(__FILE__);	
	exit();
}
header('Content-type:text/json; charset=utf-8');
$username = $_POST["username"];
$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
$sql = "select username from user where username='".$username."'";
$res = mysqli_query($con, $sql);
$data = '{"msg":"Query Completed('.substr(md5(mt_rand(0,1000000)),0,8).')."}';
echo json_encode($data);
mysqli_close($con);
?>
