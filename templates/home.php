<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Include database connection
include 'db.php';

$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['role']; // Role can be Author, Editor, or Publisher

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<?php include 'navbar.php'; ?>

<div class="container mt-5">
    <h2>Welcome, <?php echo $_SESSION['name']; ?></h2>

    <?php if ($user_role == 'Author'): ?>
        <h3>Your Manuscripts</h3>
        <a href="submit_manuscript.php" class="btn btn-primary">Submit New Manuscript</a>
        <!-- Display manuscripts by the author -->
    <?php elseif ($user_role == 'Editor'): ?>
        <h3>Manuscripts to Review</h3>
        <!-- Display manuscripts for review -->
    <?php elseif ($user_role == 'Publisher'): ?>
        <h3>Published Books</h3>
        <!-- Display books and manage publication -->
    <?php endif; ?>
</div>

<!-- Footer included -->
<footer class="bg-light text-center text-lg-start mt-5">
    <div class="text-center p-3">
        &copy; 2024 Publication System. All rights reserved.
    </div>
</footer>

</body>

</html>