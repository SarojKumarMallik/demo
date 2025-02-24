<?php
// Database credentials
$servername = "localhost";
$username = "root"; // Default for XAMPP
$password = ""; // Default for XAMPP
$dbname = "website_db"; // Use the database name created earlier

// Create a connection  
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the title and favicon from the database
$sqlTitle = "SELECT meta_value FROM website_meta WHERE meta_key = 'title' LIMIT 1";
$sqlFavicon = "SELECT meta_value FROM website_meta WHERE meta_key = 'favicon' LIMIT 1";

$titleResult = $conn->query($sqlTitle);
$faviconResult = $conn->query($sqlFavicon);

$title = ($titleResult->num_rows > 0) ? $titleResult->fetch_assoc()['meta_value'] : "Default Website Title";
$favicon = ($faviconResult->num_rows > 0) ? 'data:image/x-icon;base64,' . $faviconResult->fetch_assoc()['meta_value'] : null;

// Close the database connection
$conn->close();
?>