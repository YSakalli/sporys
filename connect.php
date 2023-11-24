<?php 
// 
$servername = "localhost";
// dbtecnoc_yusuf
$username = "root";
// 6NY?]He4V#K3
$password = "";
// dbtecnoc_sporys
$dbname = "users";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>