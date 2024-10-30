<?php
session_start();
require 'assets/include/db.php';
include("assets/include/header.php");

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($user_id, $hash);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && password_verify($password, $hash)) {
        $_SESSION['user_id'] = $user_id;

        if (isset($_POST['remember'])) {
            setcookie("user_id", $user_id, time() + (86400 * 30), "/", "", isset($_SERVER["HTTPS"]), true); 
        }

        header("Location: task.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Invalid email or password.";
        header("Location: login.php");
        exit();
    }

    $stmt->close();
    $conn->close();
}

if (isset($_SESSION['error_message'])) {
    $error_message = $_SESSION['error_message'];
    unset($_SESSION['error_message']);
}
?>

<title>Login - Trackit</title>
<body class="bg-dark">
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-0 bg-dark">
                    <div class="card-body p-4">
                        <h2 class="text-center mb-4 text-white">Login to Trackit</h2>
                        <?php if ($error_message): ?>
                            <div class="alert alert-danger"><?php echo $error_message; ?></div>
                        <?php endif; ?>
                        <form method="POST" action="login.php" onsubmit="this.querySelector('button[type=submit]').disabled=true;">
                            <div class="mb-3">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" name="email" class="form-control" style="height: 50px;" placeholder="Email" aria-label="Email" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" name="password" class="form-control" style="height: 50px;" placeholder="Password" aria-label="Password" required>
                                </div>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                                <label class="form-check-label text-white" for="remember">Remember Me</label>
                            </div>
                            <button type="submit" class="btn btn-success w-100 text-center" style="height: 50px;">Login</button>
                            <p class="mt-3 text-center text-white">
                                <a href="forgot_password.php" class="d-block d-sm-inline">Forgot Password?</a>
                                <span class="d-block d-sm-inline">New User? <a href="register.php">Register</a></span>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
