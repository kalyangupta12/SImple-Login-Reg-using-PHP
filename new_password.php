<?php
session_start();
include('includes/db_connect.php');

$message = "";
$toastClass = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password === $confirm_password) {
        // Hash the new password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        
        // Update the password in the database
        $stmt = $conn->prepare("UPDATE `signup-users` SET user_password = ? WHERE user_email = ?");
        $stmt->bind_param("ss", $hashed_password, $_SESSION['otp_email']);
        
        if ($stmt->execute()) {
            $message = "Password has been reset successfully.";
            $toastClass = "bg-success";
            session_unset(); // Clear the session
            header("Location: login.php"); // Redirect to login page
            exit();
        } else {
            $message = "Failed to reset password.";
            $toastClass = "bg-danger";
        }
        $stmt->close();
    } else {
        $message = "Passwords do not match.";
        $toastClass = "bg-warning";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>New Password</title>
</head>
<body>
    <div class="container mt-5">
        <?php if ($message): ?>
            <div class="toast align-items-center text-white <?php echo $toastClass; ?>" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <?php echo $message; ?>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        <?php endif; ?>
        <form action="new_password.php" method="POST" class="mt-4">
            <div class="mb-3">
                <label for="new_password" class="form-label">New Password</label>
                <input type="password" name="new_password" id="new_password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Reset Password</button>
        </form>
    </div>
</body>
</html>
