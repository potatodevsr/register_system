<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "register_db";

//Create Cinnection
$conn = mysqli_connect($servername, $username, $password, $dbname);

if ($conn) {
    die("Connection failed" .mysqli_connect_error());
}
?>