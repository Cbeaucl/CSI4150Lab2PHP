<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "lab1test";

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$username = $_POST["name"];
$phonenumber = $_POST["phone"];
$alpha = $_POST["alpha"];
$sql = "INSERT INTO users (username, phone, alpha)
VALUES ('$username', '$phonenumber', '$alpha')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>