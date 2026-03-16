<?php
$server = "localhost";
$user = "root";
$password = "";
$dbname = "remember_me";
$conn = mysqli_connect($server, $user, $password, $dbname);
if (!$conn)
    die("Connection Error: " . mysqli_connect_error());
?>