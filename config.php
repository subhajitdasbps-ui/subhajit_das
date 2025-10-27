<?php
$host = "localhost";
$user = "admin";        // change this to your MySQL username
$pass = "";            // change this to your MySQL password
$dbname = "attend";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
session_start();
?>
