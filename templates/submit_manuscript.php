<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Author') {
    header("Location: login.php");
    exit;
}

// Include database connection
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $submission_date = date('Y-m-d');
    $author_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO manuscripts (title, submission_date, author_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $title, $submission_date, $author_id);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
    } else {
        $error = "Error submitting manuscript";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Manuscript</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Navbar included -->
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <h2>Submit a Manuscript</h2>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <footer class="bg-light text-center text-lg-start mt-5">
    <div class="text-center p-3">
        &copy; 2024 Publication System. All rights reserved.
    </div>
</footer>

</body>
</html>
