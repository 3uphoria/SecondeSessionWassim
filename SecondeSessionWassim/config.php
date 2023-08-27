<?php
$db_host = "localhost";
$db_user = "root";
$db_password = "root";
$db_name = "web_ex";

$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
