<?php 
// 
$servername = "localhost";
// 
$username = "dbtecnoc_yusuf";
// 
$password = "6NY?]He4V#K3"; 
// 
$dbname = "dbtecnoc_sporys";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>