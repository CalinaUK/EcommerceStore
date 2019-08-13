<?php

session_start();

$conn = new mysqli('localhost','','','');
mysqli_set_charset($conn,"utf8");

/* checconnk connection */
if ($conn->connect_errno) {
    printf("Connect failed: %s\n", $conn->connect_error);
    exit();
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    // username and password sent from form

    $myusername = mysqli_real_escape_string($conn,$_POST['username']);

    $sql = "SELECT customers.customerName FROM customers WHERE customers.customerName = '$myusername'";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $active = $row['active'];

    $count = mysqli_num_rows($result);

    // If result matched $myusername and $mypassword, table row must be 1 row

    if($count == 1) {
      // session_register("myusername");
       $_SESSION['login_user'] = $myusername;

       header("location: index.html");

    }
    //Error handling for incorrectly spelt password or username
    else {
       echo 
       "Your Login Name is invalid";
    }
 }

 $conn->close();
?>

<html>

<head>
	
	<!--Title and stylesheet-->
  <title>User Login</title>
  <link rel="stylesheet" type="text/css" href="style.css">
		
		
</head>

<body>

<!-- Title bar and logo -->
<br>

<!-- Login form -->
<aside class="login">
      <h2> Please login </h2>
      <br> </br>
      <form action="login.php" method="post" class="">
	      <label>Username  : </label>	<input type="text" name="username" class="box"><br><br>
       <br>
      <input type="submit" name="submit1" value=" Submit ">
	      <br> </br>
      </form>
</aside>

</body>

</html>
