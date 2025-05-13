<?php
$servername = "localhost";
$username = "ppdb7395_smkhm";
$password = "SdfaCOLq6[Tl";
$dbname = "ppdb7395_smk_hijau_muda";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
