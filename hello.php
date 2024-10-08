<?php
session_start();

// Check if the session email is set, if not, redirect to login
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

include('includes/db_connect.php'); // Ensure this file has proper connection details

// Ensure connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Use prepared statements to prevent SQL injection
$user_email = $_SESSION['email'];
$stmt = $conn->prepare("SELECT user_name FROM `signup-users` WHERE user_email = ?");
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();

// Check if the user exists and fetch the username
if ($result && mysqli_num_rows($result) > 0) {
    $row = $result->fetch_assoc();
    $user_name = $row['user_name']; // Assign user_name from the result
} else {
    // Handle case where no result is found (optional)
    $user_name = "Guest"; // Default value if no user is found
}

// Close the statement and connection (optional for cleanup)
$stmt->close();
$conn->close();

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Get Name </title>
</head>
<body>
    <h1>Hello <span style="color:red;"><?php echo htmlspecialchars($user_name) ?></span> you are logged in</h1>
</body>
</html>