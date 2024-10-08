<?php
session_start();
include('includes/db_connect.php');

$message = "";
$toastClass = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Check if the email exists in the database
    $stmt = $conn->prepare("SELECT user_email FROM `signup-users` WHERE user_email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Generate a random OTP
        $otp = rand(100000, 999999);

        // Store the OTP in the session
        $_SESSION['otp'] = $otp;
        $_SESSION['otp_email'] = $email;

        // Send OTP using PHPMailer
        require 'PHPMailer/src/Exception.php';
        require 'PHPMailer/src/PHPMailer.php';
        require 'PHPMailer/src/SMTP.php';

        $mail = new PHPMailer\PHPMailer\PHPMailer();

        try {
            // SMTP configuration is for Hostinger Webmail , Please Check out GMail Configuration on Mail
            $mail->isSMTP();
            $mail->Host = 'smtp.hostinger.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'your_email@gmail.com';
            $mail->Password = 'APP PASSWORD';
            $mail->Port = 587;

            // Email settings
            $mail->setFrom('your_email@gmail.com', 'XYZ COMPANY');
            $mail->addAddress($email);
            $mail->Subject = 'Password Reset OTP';
            $mail->Body = "Your OTP for password reset is: $otp";

            // Send the email
            if ($mail->send()) {
                $message = "OTP sent to your email.";
                $toastClass = "bg-success";
                header("Location: verify_otp.php"); // Redirect to OTP verification page
                exit();
            }
        } catch (Exception $e) {
            $message = "Error sending OTP: " . $mail->ErrorInfo;
            $toastClass = "bg-danger";
        }
    } else {
        $message = "Email not found";
        $toastClass = "bg-warning";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Reset Password</title>
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
        <form action="reset_password.php" method="POST" class="mt-4">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Send OTP</button>
        </form>
    </div>
</body>
</html>
