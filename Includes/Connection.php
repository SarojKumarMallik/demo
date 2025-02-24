<?php 
// Databse Variables
$Host       ='localhost';
$DBUser     ='root';
$DBPass     ='root';
$DB         ='blog2';

//Create Connection

$Connection = new mysqli($Host, $DBUser, $DBPass, $DB);
$Connection->set_charset("utf8mb4");

//Check Connection
if($Connection->connect_error){
    die("Connection failed: " . $Connection->connect_error);
}
?>