<?php
$host = "localhost";
$username = "root";
$password = "Annant@1100";
$database = "ResultManagement";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
