<?php
require_once 'db.php';

$registerError = "";
$registerSuccess = false;


if (isset($_POST['fname'], $_POST['email'], $_POST['password'], $_POST['confirm_password']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = trim($_POST['fname']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPass = $_POST['confirm_password'];

    if ($password !== $confirmPass) {
        $registerError = "Password and confirm password do not match.";
    } else {
       
        $checkQuery = "SELECT id FROM users WHERE email = :email";
        $checkStmt  = $pdo->prepare($checkQuery);
        $checkStmt->execute([':email' => $email]);

        if ($checkStmt->fetch()) {
            $registerError = "This email is already registered.";
        } else {
            $userPass = password_hash($password, PASSWORD_DEFAULT);

           
            $query = "INSERT INTO users (fullName, email, password) VALUES (:fullName, :email, :password)";
            $stmt  = $pdo->prepare($query);

            $executed = $stmt->execute([
                ':fullName' => $fullName,
                ':email'    => $email,
                ':password' => $userPass
            ]);

            if ($executed) {
                $registerSuccess = true;
            } else {
                $registerError = "Something went wrong, please try again.";
            }
        }
    }
}

include 'header.php';
?>

<div class="row justify-content-center my-5">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-lg border-0 rounded-3">
            <div class="card-body p-4">
                <h3 class="card-title text-center fw-bold mb-4 text-primary">Create an Account</h3>

               
                <?php if ($registerSuccess): ?>
                    <div class="alert alert-success text-center py-3" role="alert">
                        <h5 class="alert-heading fw-bold mb-2">Success!</h5>
                        Account created successfully.<br>
                        <a href="login.php" class="btn btn-success btn-sm mt-2 fw-bold">Log in from here</a>
                    </div>
                <?php else: ?>

                    
                    <?php if (!empty($registerError)): ?>
                        <div class="alert alert-danger alert-dismissible fade show text-center py-2 fs-6" role="alert">
                            <?= htmlspecialchars($registerError) ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="register.php">
                        <div class="mb-3">
                            <label for="fname" class="form-label fw-semibold">Full Name</label>
                            <input type="text" class="form-control form-control-lg fs-6" id="fname" name="fname" placeholder="Ali Taher" required autocomplete="off">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email Address</label>
                            <input type="email" class="form-control form-control-lg fs-6" id="email" name="email" placeholder=" ali@example.com" required autocomplete="off">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">Password</label>
                            <input type="password" class="form-control form-control-lg fs-6" id="password" name="password" placeholder="Create a password" required>
                        </div>

                        <div class="mb-4">
                            <label for="confirm_password" class="form-label fw-semibold">Confirm Password</label>
                            <input type="password" class="form-control form-control-lg fs-6" id="confirm_password" name="confirm_password" placeholder="Re-enter password" required>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold shadow-sm">Register</button>
                    </form>

                    <div class="text-center mt-3">
                        <small class="text-muted">Already have an account? <a href="login.php" class="text-decoration-none fw-bold">Log in</a></small>
                    </div>

                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>