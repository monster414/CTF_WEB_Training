<?php
error_reporting(0);
include("./mysql.php");
if(isset($_POST["source"]))
{
	echo '<a href="/run/sql-1.html"><input type="Submit" value="Back"></a><br><br>';
	highlight_file(__FILE__);	
	exit();
}
header('Content-type:text/json; charset=utf-8');
$id = $_POST["id"];
$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
$sql = "select id, username from user where id=".$id;
$res = mysqli_query($con, $sql);
$row = mysqli_fetch_array($res);
$data = '{"id":"'.$id.'", "username":"'.$row[1].'"}';
echo json_encode($data);
?>
