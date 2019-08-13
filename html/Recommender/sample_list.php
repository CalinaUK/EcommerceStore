<?php

$con = mysqli_connect('localhost','','','');
mysqli_set_charset($con,"utf8");
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con,"MovieStore");
$t=time();


$sql="SELECT cs.customerName, mv.MovieName, mr.rating FROM movieRatings mr, customers cs, MovieData mv WHERE mr.fkCustomerID = cs.CustomerID AND mr.fkMovieID = mv.id GROUP BY cs.customerName, mv.MovieName, mr.rating";

$result = $con->query($sql);

$films = array();
$customers = array();

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
    	 $second_array = array($row["MovieName"]=>$row["rating"]); 
            $result = array_merge((array)$films, (array)$second_array); 
            print_r($result);
        //echo "Name: " . $row["customerName"]. "     Movie: " . $row["MovieName"]. "      Rating: " . $row["rating"]. "<br>";
    }
    print_r($films);
} else {
    echo "0 results";
}

mysql_free_result($result);


/*while( $row = mysql_fetch_assoc( $result)){
    $new_array[] = $row; // Inside while loop
    echo $new_array[];
} 

mysql_free_result($result);
$films =  array(
                
	"phil" => array("film1" => 8.5, "film2" => 3.5, "film4" => 9),
		
	"sameer" => array("film1" => 2.5, "film2" => 9.5, "film3" => 8, "film4" => 3.5, "film5" => 10),
		
	"john" => array("film1" => 8, "film2" => 3.5, "film3" => 4) 
		
); */

?>
