<?php
session_start();
include('includes/db_connect.php');

$message = "";
$toastClass = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_otp = $_POST['otp'];

    if ($entered_otp == $_SESSION['otp']) {
        // Redirect to password reset form
        header("Location: new_password.php");
        exit();
    } else {
        $message = "Invalid OTP. Please try again.";
        $toastClass = "bg-danger";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Verify OTP</title>
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
        <form action="verify_otp.php" method="POST" class="mt-4">
            <div class="mb-3">
                <label for="otp" class="form-label">Enter OTP</label>
                <input type="text" name="otp" id="otp" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Verify OTP</button>
        </form>
    </div>
</body>
</html>
