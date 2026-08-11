<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'db.php';

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

$updateMessage = '';
$updateStatus = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fname'])) {
    $fullName = trim($_POST['fname']);

    $query = "UPDATE users SET fullName = :fullName WHERE id = :id";
    $stmt  = $pdo->prepare($query);

    $success = $stmt->execute([
        ':fullName' => $fullName,
        ':id'       => $_SESSION['id']
    ]);

    if ($success) {
        $_SESSION['fullName'] = $fullName;
        $updateMessage = "Profile updated successfully!";
        $updateStatus = "success";
    } else {
        $updateMessage = "Something went wrong, please try again.";
        $updateStatus = "danger";
    }
}

include 'header.php';
?>

<div class="row justify-content-center my-4">
    <div class="col-md-8 col-lg-6">

        <?php if (!empty($updateMessage)): ?>
            <div class="alert alert-<?= $updateStatus ?> alert-dismissible fade show text-center mb-4" role="alert">
                <?= htmlspecialchars($updateMessage) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card shadow-sm border-0 rounded-3 mb-4">
            <div class="card-header bg-primary text-white py-3">
                <h4 class="mb-0 fw-bold">
                    Hello, <?= htmlspecialchars($_SESSION['fullName'] ?? 'User') ?> 
                </h4>
            </div>
            <div class="card-body p-4">
                <h6 class="text-muted fw-bold mb-3">Account Information</h6>
                <ul class="list-group list-group-flush mb-3">
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span class="text-secondary fw-semibold">User ID:</span>
                        <span class="badge bg-secondary rounded-pill"><?= htmlspecialchars($_SESSION['id']) ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span class="text-secondary fw-semibold">Email:</span>
                        <span class="fw-bold text-dark"><?= htmlspecialchars($_SESSION['email']) ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span class="text-secondary fw-semibold">Full Name:</span>
                        <span class="fw-bold text-dark"><?= htmlspecialchars($_SESSION['fullName']) ?></span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card shadow-sm border-0 rounded-3 mb-4">
            <div class="card-body p-4">
                <h5 class="card-title fw-bold text-dark mb-3">Update Profile</h5>
                <form method="POST" action="user-inf.php">
                    <div class="mb-3">
                        <label for="fname" class="form-label fw-semibold">Update Full Name</label>
                        <input type="text" class="form-control form-control-lg fs-6" name="fname" id="fname" value="<?= htmlspecialchars($_SESSION['fullName'] ?? '') ?>" required>
                    </div>
                    <button type="submit" class="btn btn-success fw-bold px-4">Update Name</button>
                </form>
            </div>
        </div>

        <div class="text-end">
            <form method="POST" action="logout.php">
                <button type="submit" class="btn btn-outline-danger fw-bold">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>

    </div>
</div>

<?php include 'footer.php'; ?>