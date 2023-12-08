<?php
$servername = "localhost";

$username = "dbtecnoc_yusuf";

$password = "6NY?]He4V#K3";

$dbname = "dbtecnoc_sporys";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>