<?php
session_start();

if (!(isset($_SESSION['login_user']))){
// If not, redirects you to login page
header ("Location: login.php");
die(); }
else {
	header ("Location: /RatedMovies/index.html");
	exit;
	
}
header('Content-Type: application/json; charset=utf-8');
$con = mysqli_connect('localhost','','', '');
mysqli_set_charset($con,"utf8");
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}
mysqli_select_db($con,"MovieStore");
$t=time();
$sql="SELECT * FROM MovieData ORDER BY MovieData.id;";
$result = mysqli_query($con,$sql);
$array = mysqli_fetch_all($result, MYSQLI_BOTH);



echo json_encode($array);


mysqli_free_result($result);
mysqli_close($con);
?>