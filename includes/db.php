<?php
$servername = "localhost";
$username = "root";
$password = "Has1234#";
$dbname = "smart_lost_found"; // Change this if your database has a different name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
