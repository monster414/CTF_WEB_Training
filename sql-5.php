<?php
error_reporting(0);
include("./mysql.php");
if(isset($_POST["source"]))
{
	echo '<a href="/run/sql-5.html"><input type="Submit" value="Back"></a><br><br>';
	highlight_file(__FILE__);	
	exit();
}
header('Content-type:text/json; charset=utf-8');
$username = $_POST["username"];
$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
$sql = "select username from user where username='".$username."'";
$res = mysqli_multi_query($con, $sql);
#$data = '{"msg":"Query Completed('.substr(md5(mt_rand(0,1000000)),0,8).')."}';
$data = '{"msg":"';
if($res)
{
	do
	{
		if($result = mysqli_store_result($con))
		{
			while($row = mysqli_fetch_row($result))
			{
				foreach($row as $col)
				{
					$data = $data.$col."<br>";
				}			
			}
			if(mysqli_more_results($con))
			{
				$data = $data."<hr />";
			}
		}
	}
	while(mysqli_next_result($con));
	mysqli_free_result($result);
}
else
{
	$data = $data."Error.";
}
$data = $data."\"}";
echo json_encode($data);
mysqli_close($con);
?>
