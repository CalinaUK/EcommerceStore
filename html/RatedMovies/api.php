<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
$con = mysqli_connect('localhost','root','','');
mysqli_set_charset($con,"utf8");
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}
if (!(isset($_SESSION['login_user']))){
// If not, redirects you to login page
header ("Location: login.php");
die(); }

$sess = $_SESSION['login_user'];
mysqli_select_db($con,"MovieStore");
$t=time();
$sql="SELECT * FROM MovieData, movieRatings, customers WHERE MovieData.id = movieRatings.fkMovieID AND movieRatings.fkCustomerID = .customers.customerID AND customers.customerName = '$sess'";
$result = mysqli_query($con,$sql);
$array = mysqli_fetch_all($result, MYSQLI_BOTH);



echo json_encode($array);


mysqli_free_result($result);
mysqli_close($con);
?>