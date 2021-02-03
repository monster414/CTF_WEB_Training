<?php
error_reporting(0);
include("./mysql.php");
if(isset($_POST["source"]))
{
	echo '<a href="./sql-8.html"><input type="Submit" value="Back"></a><br><br>';
	highlight_file(__FILE__);	
	exit();
}
header('Content-type:text/json; charset=utf-8');
$id = addslashes($_POST["id"]);
$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
$sql = "select username from user where id='".$id."'";
mysqli_query($con, 'set names gbk');
$res = mysqli_query($con, $sql);
$row = mysqli_fetch_array($res);
$data = '{"id":"'.stripcslashes($id).'", "username":"'.$row[0].'"}';
echo json_encode($data);
mysqli_close($con);
?>
