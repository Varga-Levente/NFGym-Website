<?php
$servername = "10.10.10.20";
$username = "sysadmin";
$password = "R=7gGaRV";
$dbname = "c10426gym";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}
?>