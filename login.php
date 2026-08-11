<?php
require_once 'db.php';

$loginError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $userPass = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($userPass, $user['password'])) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['fullName'] = $user['fullName'];

        header('Location: user-inf.php');
        exit();
    } else {
        $loginError = "Invalid email or password.";
    }
}

include 'header.php';
?>

<div class="row justify-content-center my-5">
    <div class="col-md-5 col-lg-4">
        <div class="card shadow-lg border-0 rounded-3">
            <div class="card-body p-4">
                <h3 class="card-title text-center fw-bold mb-4 text-primary">Login</h3>

                <?php if (!empty($loginError)): ?>
                    <div class="alert alert-danger alert-dismissible fade show text-center py-2 fs-6" role="alert">
                        <?= htmlspecialchars($loginError) ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="login.php">
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Email Address</label>
                        <input type="email" class="form-control form-control-lg fs-6" id="email" name="email" placeholder="name@example.com" required autocomplete="off">
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <input type="password" class="form-control form-control-lg fs-6" id="password" name="password" placeholder="Enter your password" required>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold shadow-sm">Log In</button>
                </form>

                <div class="text-center mt-3">
                    <small class="text-muted">Don't have an account? <a href="register.php" class="text-decoration-none fw-bold">Register here</a></small>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>