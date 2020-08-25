<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);


$servername = "localhost";
$username = "";
$dbname = "";

// Create connection
$conn =  mysqli_connect ($servername, $username, "", $dbname  ) ;
mysqli_select_db($conn, $dbname);


// Check connection
if ( !$conn ) {
  die("Connection failed: " . $conn->connect_error);
}
$id = 4;
$sql = "SELECT * FROM products";
$result = mysqli_query ( $conn, $sql ) or die ( "{$sql}" . mysqli_error( $conn ) );

while (  $line = mysqli_fetch_array ( $result ) )
{   
    
    echo '<img width="300" height="300" src="data:image/jpeg;base64,'.base64_encode( $line['image'] ).'"/>';

}



?>
