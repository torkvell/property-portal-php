<?php
$DBServer  = "";
$DBUser  = "";
$DBPass  = "";
$DBName   = "";

//Tilkobling
$conn = new mysqli($DBServer, $DBUser, $DBPass, $DBName);
if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}
?>