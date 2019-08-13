<?php

session_start();
$product_ids = array();
//session_destroy();

if (!(isset($_SESSION['login_user']))){
// If not, redirects you to login page
header ("Location: login.php");
die(); }


header('Content-Type: application/json; charset=utf-8');
require_once("recommend.php");
require_once("generator.php");

//echo ($_SESSION['login_user']);

$re = new Recommend();

$re1 = $re->getRecommendations($customer, $_SESSION['login_user']);

$output = implode('- ', array_map(
    function ($v, $k) { return sprintf("%s%v", $k, $v); },
    $re1,
    array_keys($re1)
));

//print_r (implode($re1,', '));
/*
$output = implode(', ', array_map(
    function ($v, $k) { return sprintf("%s%v", $k, $v); },
    $re1,
    array_keys($re1)
)); 

$myArray = array_map('trim', explode(',', $output));
*/
$myArray = explode('- ', $output);

$var1 = $myArray[0];
$var1_fixed = str_replace("'", "\\'", $var1); 

$var2 = $myArray[1];
$var2_fixed = str_replace("'", "\\'", $var2); 

$var3 = $myArray[2];
$var3_fixed = str_replace("'", "\\'", $var3);

$var4 = $myArray[3];
$var4_fixed = str_replace("'", "\\'", $var4);

$var5 = $myArray[4];
$var5_fixed = str_replace("'", "\\'", $var5);

$var6 = $myArray[5];
$var6_fixed = str_replace("'", "\\'", $var6);

$con = mysqli_connect('localhost','','','');
mysqli_set_charset($con,"utf8");
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}
mysqli_select_db($con,"MovieStore");
$t=time();


$sql="SELECT * FROM MovieData " . " WHERE MovieData.name = '$var1_fixed' OR  MovieData.name = '$var2_fixed' OR  MovieData.name = '$var3_fixed' OR  MovieData.name = '$var4_fixed' OR  MovieData.name = '$var5_fixed' OR  MovieData.name = '$var6_fixed';";
$result = mysqli_query($con,$sql);
$array = mysqli_fetch_all($result, MYSQLI_BOTH);
 

$sess = $_SESSION['login_user'];
array_push($array, $sess);

echo json_encode($array);


mysqli_free_result($result);
mysqli_close($con);
?>