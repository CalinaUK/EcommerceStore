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

echo("Session User: ");
echo($_SESSION['login_user']);
echo(" ");

$re = new Recommend();

$re1 = $re->getRecommendations($customer, $_SESSION['login_user']);

print_r ($re1);

$output = implode('- ', array_map(
    function ($v, $k) { return sprintf("%s%v", $k, $v); },
    $re1,
    array_keys($re1)
));

$myArray = explode('- ', $output);
$var1 = $myArray[0];
$var2 = $myArray[1];
//echo($var1);
//echo($var1.$var2);

?>
