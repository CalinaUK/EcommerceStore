<?php

$mysqli = new mysqli('localhost','','','');
mysqli_set_charset($mysqli,"utf8");

/* check connection */
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}

$query = "SELECT DISTINCT customers.customerName FROM customers, movieRatings WHERE customers.customerID = movieRatings.fkCustomerID ORDER BY customerName";


if ($result = $mysqli->query($query)) {

    //fetch associative array 
    while ($row = $result->fetch_assoc()) {
    	$customer[$row["customerName"]] = NULL;
    	$customerID[$count] = $row["customerName"];
    	$count = $count+1;
        //printf ("%s, %s", $row["customerName"], $row["fkCustomerID"]);
    }

    $result->free(); 
}

$length = count($customerID);

for ($i = 0; $i < $length; $i++) {
	$count = 0;

	$query = "SELECT DISTINCT mv.MovieName, mr.rating FROM movieRatings mr, customers cs, MovieData mv WHERE mr.fkCustomerID = cs.CustomerID AND mr.fkMovieID = mv.id AND cs.customerName = '".$customerID[$i]."' ORDER BY mv.MovieName";

	$films = array();
	$ratings = array();
	$rowCount = array();

	if ($result = $mysqli->query($query)) {
	    //fetch associative array 
	    while ($row = $result->fetch_assoc()) {
	    	$ratings[$row["MovieName"]] = $row["rating"];
	    	$films[$row["customerName"]] = $ratings;

	 		$movie[$row["MovieName"]] = $row["rating"];
	 		$count += 1;

	    }

	   	unset($customer[$customerID[$i]]);
	    $customer[$customerID[$i]] = $movie;
	    unset($movie);

	    $result->free(); 
	}

}
unset($customer['adam']);
unset($customer[0]);

$query = "SELECT DISTINCT mv.MovieName, mr.rating FROM movieRatings mr, customers cs, MovieData mv WHERE mr.fkCustomerID = cs.CustomerID AND mr.fkMovieID = mv.id AND cs.customerName = 'adam' ORDER BY mv.MovieName";

if ($result = $mysqli->query($query)) {
	    //fetch associative array 
	    while ($row = $result->fetch_assoc()) {
	    		$movie[$row["MovieName"]] = $row["rating"];
	    	}
	$customer['adam'] = $movie;

	$result->free(); 
}

//print_r($customer);

 $output = implode(', ', array_map(
		    function ($v, $k) { return sprintf('"%s" => %s3', $k, $v); },
		    $customer,
		    array_keys($customer)
		));

$outArr = array($output);




?>