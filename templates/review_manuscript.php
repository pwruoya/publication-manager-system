<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Editor') {
    header("Location: login.php");
    exit;
}

// Include database connection
include 'db.php';

$editor_id = $_SESSION['user_id'];
$manuscript_id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status = $_POST['status'];
    
    $stmt = $conn->prepare("UPDATE manuscripts SET status = ?, editor_id = ? WHERE manuscript_id = ?");
    $stmt->bind_param("sii", $status, $editor_id, $manuscript_id);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
    } else {
        $error = "Error reviewing manuscript";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Manuscript</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Navbar included -->
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <h2>Review Manuscript</h2>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-control">
                    <option value="Reviewed">Reviewed</option>
                    <option value="Published">Published</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit Review</button>
        </form>
    </div>

    <footer class="bg-light text-center text-lg-start mt-5">
    <div class="text-center p-3">
        &copy; 2024 Publication System. All rights reserved.
    </div>
</footer>

</body>
</html>
