<?php
// Start the session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page
    header("Location: login.html");
    exit;
}


// Set database credentials
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "loan1";

// Establish database connection
$conn = mysqli_connect($hostname, $username, $password, $dbname);

// Check connection
if (!$conn) 
{
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve user data from database
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM create_new_user WHERE user_id = $user_id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

// Close database connection
mysqli_close($conn);
?> 